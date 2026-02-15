<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Biodata Peserta Wisuda UII Dalwa</title>

    <style>
        body {
            font-size: 12px;
            font-family: "Open Sans", sans-serif;
        }

        table {
            font-size: 14px;
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            /* font:sans-serif; */
            font-family: "Open Sans", sans-serif;
        }

        table td {
            height: 10px;
            padding: 5px;
        }

        label {
            margin-bottom: 0;
        }

        .square-box {
            width: 100px;
            height: 120px;
            border: 1px solid #000;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h6 class="mb-4 text-center"><u>Biodata Peserta Wisuda UII Dalwa</u></h6>
        <table>
            <tbody>
                <tr>
                    <td width="120">Nama</td>
                    <td>:</td>
                    <td>{{ @$peserta->nama }}</td>
                </tr>
                <tr>
                    <td width="120">NIM</td>
                    <td>:</td>
                    <td>{{ @$peserta->nim }}</td>
                </tr>
                <tr>
                    <td width="120">Prodi</td>
                    <td>:</td>
                    <td>{{ @$peserta->getProdi->nama }}</td>
                </tr>
                <tr>
                    <td width="120">Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ @$peserta->tempat_lahir }},
                        {{ date('d M Y', strtotime(@$peserta->tanggal_lahir)) }} </td>
                </tr>
                <tr>
                    <td width="120">Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ strtoupper(@$peserta->user->jenis_kelamin) }}</td>
                </tr>
                <tr>
                    <td width="120">Identitas</td>
                    <td>:</td>
                    <td>
                        @foreach ($tipeIdentitas as $key => $value)
                            <label for="{{ $value }}">{{ strtoupper($value) }}</label>
                            <input type="checkbox" class="mr-3" id="{{ $value }}"
                                {{ $peserta->tipe_identitas == $value ? 'checked' : '' }}>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td width="120">No Identitas</td>
                    <td>:</td>
                    <td>{{ @$peserta->nomor_identitas }}</td>
                </tr>
                <tr>
                    <td width="120">Propinsi</td>
                    <td>:</td>
                    <td>{{ @$peserta->propinsi }}</td>
                </tr>
                <tr>
                    <td width="120">Kota/Kabupaten</td>
                    <td>:</td>
                    <td>{{ @$peserta->kota }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
