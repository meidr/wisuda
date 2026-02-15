<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Swiper demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />

    <style>
        html,
        body {
            position: relative;
            height: 100%;
            margin: 0;
            padding: 0;
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
            width: 100vw;
            /* Full width */
            height: 100vh;
            /* Full height */
        }

        swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 22px;
            font-weight: bold;
            color: #fff;
            background-color: #007aff;
            /* Set a background color to visualize the slides */
        }

        .foto {
            width: 3cm;
            /* Set width to 3 cm */
            height: 4cm;
            /* Set height to 4 cm */
            border: 3px solid #000;
            /* Add a 5px solid black border */
            padding: 2px;
            /* Optional padding inside the border */
            box-sizing: border-box;
            /* Ensure padding and border are included in the element's total size */
        }
    </style>
</head>

<body>

    <swiper-container init="false" class="mySwiper">
        @foreach ($peserta as $value)
            <swiper-slide>
                <div>WISUDA</div>
                <div>
                    @php
                        if ($value->file) {
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

    <script>
        var swiperEl = document.querySelector(".mySwiper");
        Object.assign(swiperEl, {
            grabCursor: true,
            effect: "creative",
            keyboard: true,
            creativeEffect: {
                prev: {
                    shadow: true,
                    translate: [0, 0, -400],
                },
                next: {
                    translate: ["100%", 0, 0],
                },
            },
        });
        swiperEl.initialize()
    </script>
</body>

</html>
