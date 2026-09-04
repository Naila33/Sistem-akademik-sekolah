<?php

namespace Tests\Feature;

use Tests\TestCase;

class WaliKelasDashboardTest extends TestCase
{
    public function test_wali_kelas_dashboard_route_exists_and_shows_required_profile_info(): void
    {
        $this->assertNotNull(route('wali-kelas.dashboard'));

        $jadwalMengajar = collect([
            (object) [
                'kelas' => (object) [
                    'nama_kelas' => 'XII-1',
                    'tingkat' => 'XII',
                    'jurusan' => (object) ['nama_jurusan' => 'TKJ'],
                ],
                'mataPelajaran' => (object) ['nama_mapel' => 'Bahasa Indonesia'],
            ],
        ]);

        $html = view('wali-kelas.dashboard', [
            'guru' => (object) ['nama' => 'Sri Wahyuni'],
            'waliKelas' => collect([
                (object) [
                    'kelas' => (object) [
                        'tingkat' => 'XII',
                        'nama_kelas' => 'XII-1',
                        'jurusan' => (object) ['nama_jurusan' => 'TKJ'],
                    ],
                ],
            ]),
            'jadwalMengajar' => $jadwalMengajar,
            'username' => 'sriwahyuni',
        ])->render();

        $this->assertStringContainsString('Ganti Password', $html);
        $this->assertStringContainsString('sriwahyuni', $html);
        $this->assertStringContainsString('Sri Wahyuni', $html);
        $this->assertStringContainsString('Bahasa Indonesia', $html);
        $this->assertStringContainsString('Wali Kelas', $html);
    }
}
