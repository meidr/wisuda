<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SlideShow | Wisuda</title>
    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/homepage/images/logo-ponpes-icon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('splide/css/splide.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pure-snow/style.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .splide {
            height: 100vh;
            /* Viewport height */
            width: 100vw;
            /* Viewport width */
        }

        .splide__track {
            height: 100%;
        }

        .splide__slide {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 1.2rem;
            color: white;
            height: 100%;
            background-image: url('{{ asset('img/bg-wisuda-hitam.png') }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            text-align: center;
        }

        .foto {
            width: 170px;
            height: 220px;
            padding: 2px;
            box-sizing: border-box;
            border-radius: 20%;
            box-shadow: 0px 1px 30px 12px rgba(0, 0, 0, 0.75);
            -webkit-box-shadow: 0px 1px 30px 12px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 0px 1px 30px 12px rgba(0, 0, 0, 0.75);
            object-fit: cover;
            object-position: center;
        }


        #bg-bawah {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px;
            text-align: center;
            color: #fff;
        }

        #bg-bawah img,
        svg {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            background-repeat: repeat;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            color: white;
            z-index: 999;
            pointer-events: none;
        }

        .set-margin {
            margin-top: -15px
        }

        .bg-white {
            background-color: #fff;
            color: #0E131B;
            border-radius: 20px;
            padding: 5px 15px;
            font-weight: bold;
        }

        .splide__slide h1 {
            font-family: 'Great Vibes', cursive;
            font-size: 3rem;
            margin-top: -60px;
            margin-bottom: -8px;
        }

        .nama {
            /* font-size: 1.3rem; */
            box-shadow: 0px 1px 30px 12px rgba(0, 0, 0, 0.75);
            -webkit-box-shadow: 0px 1px 30px 12px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 0px 1px 30px 12px rgba(0, 0, 0, 0.75);
            margin-bottom: 5px;
            margin-top: -5px;
        }
    </style>
</head>

<body>
    <!-- Overlay -->
    <div class="overlay">
        <div id="snow" data-count="70"></div>
        <div id="bg-bawah">
            <img src="{{ asset('img/bg-bawah.png') }}" alt="">
        </div>
    </div>
    <section class="splide" aria-label="Fullscreen Splide Example">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($peserta as $value)
                    @if ($value->urutan_peserta_id)
                        <li class="splide__slide">
                            <h1>Selamat atas Wisuda</h1>
                            <br>
                            <div class="set-margin">
                                @php
                                    if ($value->file != null) {
                                        $foto = asset(
                                            'img/download-foto/' . $value->id . $value->peserta_dokumen_extension,
                                        );
                                    } else {
                                        if ($value->jenis_kelamin == 'Perempuan') {
                                            $foto = asset('img/Foto Perempuan.png');
                                        } else {
                                            $foto = asset('img/Foto Laki-Laki.png');
                                        }
                                    }
                                @endphp
                                <img class="foto" src="{{ $foto }}" alt="Foto Wisuda"
                                    onerror="handleImgError(this)">
                            </div>
                            <br>
                            <div class="set-margin bg-white nama">{{ $value->nama }}</div>
                            @if ($value->jenis_kelamin == 'Perempuan')
                                <div>binti</div>
                            @else
                                <div>bin</div>
                            @endif
                            <div><b>{{ $value->nama_ayah }}</b></div>
                            <br>
                            <div class="set-margin"><b>{{ $value->kota }} - {{ $value->propinsi }}</b></div>
                            <br>
                            <div class="set-margin">{{ $value->prodi_nama }}</div>
                            <div>Universitas Islam Internasional Darullugahh Wadda'wah</div>
                        </li>
                    @else
                        <li class="splide__slide"
                            style="background-image: url('{{ asset('img/bg-wisuda-' . $value->urutan_prodi_alias . '.png') }}');">
                            <h1>Prosesi Wisuda 2024</h1>
                            <br>
                            <br>
                            <div>PRODI</div>
                            <div><b>{{ $value->urutan_prodi_nama }}</b></div>
                            <br>
                            <div class="set-margin">{{ $value->prodi_nama }}</div>
                            <br>
                            <div>Universitas Islam Internasional Darullugahh Wadda'wah</div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </section>

    <script src="{{ asset('splide/js/splide.min.js') }}"></script>
    <script src="{{ asset('pure-snow/script.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var splide = new Splide('.splide', {
                // type: 'loop', // Loop mode for infinite scrolling
                height: '100vh', // Fullscreen height
                width: '100vw', // Fullscreen width
                cover: true, // Cover the whole slide
                keyboard: 'global', // Enable keyboard navigation globally
                pagination: false, // Hide pagination
                arrows: false // Hide navigation arrows
            });

            // Fungsi untuk menambahkan animasi fade-in ke slide saat ini
            function addFadeInAnimation(slide) {
                var elements = slide.querySelectorAll('*'); // Pilih semua elemen di dalam slide
                elements.forEach(function(element) {
                    element.classList.add('animate__animated', 'animate__zoomIn', 'animate__faster');
                });
            }

            // Fungsi untuk menambahkan animasi fade-out ke slide sebelumnya
            function addFadeOutAnimation(slide) {
                var elements = slide.querySelectorAll('*'); // Pilih semua elemen di dalam slide
                elements.forEach(function(element) {
                    element.classList.remove('animate__zoomIn', 'animate__faster'); // Hapus animasi fade-in
                    element.classList.add('animate__animated',
                        'animate__fadeOut'); // Tambahkan animasi fade-out
                });
            }

            // Event listener ketika splide di-mount (pertama kali dimuat)
            splide.on('mounted', function() {
                var slides = document.querySelectorAll('.splide__slide');
                addFadeInAnimation(slides[0]); // Tambahkan animasi ke slide pertama
            });

            // Event listener untuk setiap perpindahan slide
            splide.on('move', function(newIndex, prevIndex) {
                var slides = document.querySelectorAll('.splide__slide');

                // Tambahkan animasi fade-out ke slide sebelumnya
                addFadeOutAnimation(slides[prevIndex]);

                // Tambahkan animasi fade-in ke slide saat ini
                addFadeInAnimation(slides[newIndex]);
            });

            splide.mount();

            // Optional: Custom keyboard controls
            document.addEventListener('keydown', function(event) {
                if (event.key === 'ArrowLeft') {
                    splide.go('<'); // Navigate to previous slide
                }
                if (event.key === 'ArrowRight') {
                    splide.go('>'); // Navigate to next slide
                }
            });
        });

        function handleImgError(img) {
            // matikan handler agar tidak loop
            img.onerror = null;

            // daftar ekstensi yang akan dicoba
            const exts = ['.png', '.jpg', '.jpeg', '.webp', '.gif'];

            // cari yang belum dicoba (jika src sudah berisi ext, bisa skip)
            const base = img.getAttribute('src').replace(/\.(png|jpg|jpeg|webp|gif)$/i, '');

            // iterasikan dan set src ke satu per satu
            (function tryExt(i) {
                if (i >= exts.length) return; // habis, berhenti
                img.src = base + exts[i];
                img.onerror = () => {
                    img.onerror = null;
                    tryExt(i + 1);
                };
            })(0);
        }
    </script>
</body>

</html>
