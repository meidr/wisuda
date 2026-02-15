<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cetak Kwitansi</title>

    <style>
        .table_content {
            line-height: 1;
        }

        .bold {
            font-weight: bold;
        }

        .italic {
            font-style: italic;
        }

        .td-left {
            width: 175px;
            font-weight: bold;
            font-size: 18px;
        }

        .td-center {
            width: 1px;
            font-weight: bold;
            font-size: 18px;
        }

        .td-right {
            font-weight: bold;
            font-size: 18px;
        }

        .td-foot {
            font-weight: bold;
            font-size: 26px;
        }
    </style>
</head>

<body>
    <div id="printableArea">
        <table border="0" class="table_content" cellpadding="9" style="border: 1px solid #000; width: 100%">
            <thead>

                <tr>
                    <td style="border-bottom: 2px double #000;" align="center">
                        <img src="{{ asset('img/logo_uii.webp') }}" width="100">
                    </td>
                    <td align="center" colspan="2"
                        style="border-bottom: 2px double #000; font-weight: bold;font-size: 26px;">
                        <b>PANITIA PENDAFTARAN MAHASISWA/I WISUDA<br>UNIVERSITAS ISLAM INTERNASIONAL<br> DARULLUGHAH
                            WADDA'WAH<br>
                            TAHUN {{ @$kui->hijri->hijri->year }} H / {{ @$kui->hijri->gregorian->year }} M</b>
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td align="left" class="td-left">No Kwitansi</td>
                    <td align="left" class="td-center">: </td>
                    <td align="left" class="td-right">{{ @$kui->no }}</td>
                </tr>

                <tr>
                    <td align="left" class="td-left">Tanggal</td>
                    <td align="left" class="td-center">: </td>
                    <td align="left" class="td-right">{{ @$kui->tgl }}</td>
                </tr>

                <tr>
                    <td align="left" class="td-left">Telah Terima dari</td>
                    <td align="left" class="td-center">: </td>
                    <td align="left" class="td-right">{{ @$kui->dari }}</td>
                </tr>

                <tr>
                    <td align="left" class="td-left">Username</td>
                    <td align="left" class="td-center">: </td>
                    <td align="left" class="td-right">{{ @$kui->username }}</td>
                </tr>

                <tr>
                    <td align="left" class="td-left">Password</td>
                    <td align="left" class="td-center">: </td>
                    <td align="left" class="td-right">{{ @$kui->no_unik }}</td>
                </tr>


                <tr>
                    <td align="left" class="td-left">Jenis Pembayaran</td>
                    <td align="left" class="td-center">: </td>
                    <td align="left" class="td-right">{{ @$kui->jenis_pembayaran }}</td>
                </tr>

                <tr>
                    <td align="left" class="td-left">Uang Sejumlah</td>
                    <td align="left" class="td-center">: </td>
                    <td align="left" class="td-right">{{ @$kui->jumlah }}</td>
                </tr>

                @php
                    $jumlah = str_replace('.', '', @$kui->jumlah);
                    $bilangan = \Helper::terbilang($jumlah);
                @endphp

                <tr>
                    <td align="left" class="td-left">Terbilang </td>
                    <td align="left" class="td-center"> : </td>
                    <td align="left" class="td-right">{{ @$bilangan . ' Rupiah' }}</td>
                </tr>

                <tr>
                    <td align="left" class="td-left">Untuk Pembayaran</td>
                    <td align="left" class="td-center"> : </td>
                    <td align="left" class="td-right">BIAYA PENDAFTARAN WISUDA MAHASISWA/I
                    </td>
                </tr>

                <tr>
                    <td align="left" colspan="3"><br></td>
                </tr>
            </tbody>

            <tfoot>
                <tr valign="top">
                    <td align="left" class="td-foot">
                        &nbsp;&nbsp;Rp. {{ @$kui->jumlah }}</td>
                    <td align="right" class="td-foot" colspan="2">
                        Bangil, {{ date('d-m-Y') }}<br><br><br>{{ @$kui->panitia->nama }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
