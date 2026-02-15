<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Swiper demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="{{ asset('star/style.css') }}">
    <style>
        html,
        body {
            position: relative;
            height: 100%;
        }

        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        swiper-container {
            width: 100%;
            height: 100%;
        }

        swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 22px;
            font-weight: bold;
            color: #fff;
            background-image: url('{{ asset('img/bg-wisuda.png') }}');
            background-repeat: no-repeat;
            /* Prevent image from repeating */
            background-position: center;
            /* Center the background image */
            background-size: cover;
            /* Scale the image to cover the entire area without stretching */
        }

        .foto {
            width: 3cm;
            height: 4cm;
            border: 3px solid #000;
            padding: 2px;
            box-sizing: border-box;
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
            /* display: flex;
            align-items: center;
            justify-content: center; */
            color: white;
            z-index: 999;
            /* Pastikan elemen overlay memiliki z-index lebih tinggi */
            pointer-events: none;
            /* Agar tidak mengganggu interaksi dengan Swiper */
        }

        #snow {
            opacity: 0.5;
        }
    </style>
</head>

<body>
    <!-- Overlay -->
    <div class="overlay">
        <div class="night">
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
        </div>
        <div id="bg-bawah">
            <img src="{{ asset('img/bg-bawah.png') }}" alt="">
        </div>
    </div>

    <swiper-container class="mySwiper" keyboard=true>

        @foreach ($peserta as $value)
            <swiper-slide>
                <div>WISUDA</div>
                <div>
                    @php
                        if ($value->file != null) {
                            $foto = asset('img/download-foto/' . $value->file);
                        } else {
                            if ($value->jenis_kelamin == 'Perempuan') {
                                $foto = asset('img/logo uii dalwa.png');
                            } else {
                                $foto = asset('img/logo.png');
                            }
                        }
                    @endphp
                    <img class="foto" src="{{ $foto }}" alt="Foto Wisuda">
                </div>
                <div>{{ $value->nama }}</div>
                <div>{{ $value->nama_ayah }}</div>
                <div>{{ $value->tempat_lahir }}</div>
                <div>{{ $value->prodi_nama }}</div>
                <div>UII Dalwa</div>
            </swiper-slide>
        @endforeach
    </swiper-container>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    
</body>

</html>
