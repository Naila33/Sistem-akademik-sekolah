<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\CalonSiswa;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PembagianKelasImport implements ToCollection
{
    public $berhasil = 0;
    public $gagal = [];

    public function collection(Collection $rows)
    {
        // Ambil baris pertama sebagai header
        $header = $rows->first();

        // Cari posisi kolom berdasarkan nama header
        $nisIndex = $header->search(function ($value) {
            return strtolower(trim($value)) === 'nis';
        });

        $kelasIndex = $header->search(function ($value) {
            return strtolower(trim($value)) === 'kelas';
        });

        // Kalau kolom NIS tidak ditemukan
        if ($nisIndex === false) {
            $this->gagal[] = 'Kolom NIS tidak ditemukan di Excel.';
            return;
        }

        // Kalau kolom Kelas tidak ditemukan
        if ($kelasIndex === false) {
            $this->gagal[] = 'Kolom Kelas tidak ditemukan di Excel.';
            return;
        }

        // Proses data mulai dari baris kedua
        foreach ($rows->skip(1) as $row) {

            $nis = trim((string) ($row[$nisIndex] ?? ''));
            $namaKelas = preg_replace(
                '/\s+/',
                ' ',
                trim((string) ($row[$kelasIndex] ?? ''))
            );

            // Lewati baris kosong
            if (!$nis && !$namaKelas) {
                continue;
            }

            // NIS kosong
            if (!$nis) {
                $this->gagal[] = 'Ada data dengan NIS kosong.';
                continue;
            }

            // Kelas kosong
            if (!$namaKelas) {
                $this->gagal[] = "NIS {$nis}: kelas kosong.";
                continue;
            }

            // Cari calon siswa berdasarkan NISN
            $calonSiswa = CalonSiswa::where('nisn', $nis)->first();

            if (!$calonSiswa) {
                $this->gagal[] =
                    "NIS {$nis}: siswa tidak ditemukan di calon_siswa.";
                continue;
            }

            // Excel dapat berisi "X A", sedangkan database memisahkan
            // tingkat dan nama_kelas.
            $kelas = Kelas::where('nama_kelas', $namaKelas)->first();

            if (!$kelas && str_contains($namaKelas, ' ')) {
                [$tingkat, $nama] = explode(' ', $namaKelas, 2);

                $kelas = Kelas::where('tingkat', $tingkat)
                    ->where('nama_kelas', $nama)
                    ->first();
            }

            if (!$kelas) {
                $this->gagal[] =
                    "NIS {$nis}: kelas '{$namaKelas}' tidak ditemukan.";
                continue;
            }

            /*
             * Otomatis membuat record siswa di tabel datasiswa
             * jika belum ada
             */
            $siswa = Siswa::firstOrCreate(
                ['nisn' => $calonSiswa->nisn],
                [
                    'nis' => Siswa::generateNis(),
                    'nik' => $calonSiswa->nik,
                    'nama' => $calonSiswa->nama_lengkap,
                    'tempat_lahir' => $calonSiswa->tempat_lahir,
                    'tanggal_lahir' => $calonSiswa->tanggal_lahir,
                    'jk' => $calonSiswa->jenis_kelamin,
                    'alamat' => $calonSiswa->alamat,
                    'nama_orang_tua' => $calonSiswa->nama_ayah,
                ]
            );

            // Cek apakah siswa sudah punya kelas
            $sudahAda = SiswaKelas::where(
                'siswa_id',
                $siswa->id
            )->exists();

            if ($sudahAda) {
                $this->gagal[] =
                    "NIS {$nis}: siswa sudah memiliki kelas.";
                continue;
            }

            // Simpan pembagian kelas
            SiswaKelas::create([
                'siswa_id' => $siswa->id,
                'kelas_id' => $kelas->id,
            ]);

            $this->berhasil++;
        }
    }
}
