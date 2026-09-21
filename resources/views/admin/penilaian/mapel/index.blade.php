@extends('layouts.app')

@section('title', 'Penilaian Mata Pelajaran')

@section('content')

<div class="container-fluid py-4">


    
    
    

    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Penilaian Mata Pelajaran
        </h3>

        <p class="text-muted mb-0">
            Pilih kelas untuk melihat mata pelajaran dan data penilaian.
        </p>

    </div>


    
    
    

    <div class="card border-0 shadow-sm kelas-search-card">

        <div class="card-body p-4">

            <div class="kelas-search">

                <label
                    class="form-label fw-semibold"
                >
                    Cari Kelas
                </label>


                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-search"></i>

                    </span>


                    <input
                        type="text"
                        id="searchKelas"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Contoh: X Rekayasa Perangkat Lunak A"
                        autocomplete="off"
                    >

                </div>

            </div>

        </div>

    </div>


    
    
    

    <div id="kelasContent">

        <div
            class="kelas-grid"
            id="kelasList"
        >

            @forelse($kelas as $k)


                <div
                    class="kelas-item"
                    data-search="{{ strtolower(
                        $k->tingkat . ' ' .
                        $k->nama_kelas . ' ' .
                        ($k->jurusan?->nama_jurusan ?? 'Umum')
                    ) }}"
                >


                    <a
                        href="{{ route(
                            'admin.penilaian.mapel.kelas',
                            $k->id
                        ) }}"
                        class="kelas-link"
                    >


                        <div
                            class="card border-0 shadow-sm kelas-card"
                        >


                            
                            <div class="card-body p-4">


                                <div
                                    class="d-flex justify-content-between align-items-start"
                                >


                                    <div>

                                        <div
                                            class="text-muted small mb-1"
                                        >
                                            Kelas
                                        </div>


                                        <h4
                                            class="fw-bold text-dark mb-1"
                                        >

                                            {{ $k->tingkat }}
                                            {{ $k->nama_kelas }}

                                        </h4>


                                        <div
                                            class="text-muted"
                                        >

                                            {{ $k->jurusan?->nama_jurusan ?? 'Umum' }}

                                        </div>

                                    </div>


                                    
                                    <div
                                        class="rounded-circle
                                               bg-success
                                               bg-opacity-10
                                               p-3
                                               text-success
                                               kelas-icon"
                                    >

                                        <i
                                            class="bi bi-mortarboard-fill fs-4"
                                        ></i>

                                    </div>


                                </div>


                                <hr class="my-4">


                                
                                <div
                                    class="d-flex
                                           justify-content-between
                                           align-items-center"
                                >

                                    <span class="text-muted">

                                        <i
                                            class="bi bi-people me-1"
                                        ></i>

                                        Siswa

                                    </span>


                                    <strong class="text-dark">

                                        {{ $k->siswa_kelas_count }}

                                    </strong>

                                </div>


                            </div>


                            
                            <div
                                class="card-footer
                                       bg-white
                                       border-0
                                       px-4
                                       pb-4
                                       pt-0"
                            >

                                <div
                                    class="text-success fw-semibold"
                                >

                                    Lihat Mata Pelajaran

                                    <i
                                        class="bi bi-arrow-right ms-1"
                                    ></i>

                                </div>

                            </div>


                        </div>


                    </a>


                </div>


            @empty


                <div class="kelas-empty">


                    <div
                        class="card border-0 shadow-sm"
                    >

                        <div
                            class="card-body
                                   text-center
                                   py-5"
                        >

                            <i
                                class="bi
                                       bi-mortarboard
                                       fs-1
                                       text-muted"
                            ></i>


                            <h5 class="mt-3">

                                Kelas tidak ditemukan

                            </h5>


                            <p
                                class="text-muted mb-0"
                            >

                                Belum ada kelas yang sesuai.

                            </p>

                        </div>

                    </div>


                </div>


            @endforelse


        </div>

    </div>


</div>






<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const searchInput =
            document.getElementById(
                'searchKelas'
            );


        const kelasItems =
            document.querySelectorAll(
                '.kelas-item'
            );


        const kelasList =
            document.getElementById(
                'kelasList'
            );


        if (
            !searchInput ||
            !kelasList
        ) {

            return;

        }


        function filterKelas() {


            const keyword =
                searchInput.value
                    .toLowerCase()
                    .trim();


            let jumlahHasil = 0;


            kelasItems.forEach(
                function (item) {


                    const dataSearch =
                        item.dataset.search;


                    if (
                        dataSearch.includes(
                            keyword
                        )
                    ) {

                        item.style.display =
                            '';

                        jumlahHasil++;

                    } else {

                        item.style.display =
                            'none';

                    }

                }
            );


            

            const oldMessage =
                document.getElementById(
                    'liveSearchEmpty'
                );


            if (oldMessage) {

                oldMessage.remove();

            }


            

            if (
                jumlahHasil === 0
            ) {


                const empty =
                    document.createElement(
                        'div'
                    );


                empty.id =
                    'liveSearchEmpty';


                empty.className =
                    'kelas-empty';


                empty.innerHTML = `

                    <div class="card border-0 shadow-sm">

                        <div class="card-body text-center py-5">

                            <i class="bi bi-search fs-1 text-muted"></i>

                            <h5 class="mt-3">
                                Kelas tidak ditemukan
                            </h5>

                            <p class="text-muted mb-0">
                                Tidak ada kelas yang sesuai dengan
                                pencarian
                                "<strong>${escapeHtml(keyword)}</strong>".
                            </p>

                        </div>

                    </div>

                `;


                kelasList.appendChild(
                    empty
                );

            }

        }


        

        searchInput.addEventListener(
            'input',
            function () {

                filterKelas();

            }
        );


        

        function escapeHtml(text) {

            const div =
                document.createElement(
                    'div'
                );

            div.textContent =
                text;

            return div.innerHTML;

        }


        

        filterKelas();

    }
);

</script>

@endsection