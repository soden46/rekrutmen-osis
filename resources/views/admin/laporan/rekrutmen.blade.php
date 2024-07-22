<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Rekrutmen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        body {
            font-size: 12px;
            font-family: Verdana, Tahoma, "DejaVu Sans", sans-serif;
        }

        .table,
        .td,
        .th,
        thead {
            border: 1px solid black;
            text-align: center
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .text-center {
            text-align: center;
        }

        .text-success {
            color: green
        }

        .text-danger {
            color: red
        }

        .fw-bold {
            font-weight: bold
        }

        .tandatangan {
            text-align: center;
            margin-left: 400px;

        }

        #foto {
            float: left;
            width: 88px;
            height: 88px;
            background: transparent;
        }

        #foto2 {
            justify-content: center;
            width: 60%;
            height: 30px;
            background: transparent;
        }

        .header h1 {
            font-size: 18px;
            font-family: sans-serif;
            position: relative;
            margin: 0;
            padding: 0;
            top: 1px;
        }

        .header p {
            font-size: 13px;
            font-family: sans-serif;
            position: relative;
            margin: 0;
            padding: 0;
            top: 1px;
        }

        .header2 h1 {
            font-size: 14px;
            font-family: sans-serif;
            position: relative;
            margin: 0;
            padding: 0;
            top: 2px;
            text-decoration: underline;
        }

        .header2 p {
            font-size: 12px;
            font-family: sans-serif;
            position: relative;
            margin: 0;
            padding: 0;
            top: 2px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <div class="header">
                <img src="{{ asset('assets/img/logo.png') }}" id="foto" alt="Logo" height="75px" />
                <h1 class="text-center">SMP Negeri 2 Mlati</h1>
                <p class="text-center">Sinduadi, Mlati, Sleman, Yogyakarta </p>
                <p class="text-center">Telepon 586711</p>
                <p class="text-center">Kode Pos : 55284 </p>
            </div>
            <div class="divider py-1 bg-dark mb-3 mt-2"></div>
            <h5 class="text-center">Laporan Data Rekrutmen</h5>

            <table class="table table-bordered">
                <tr class="font-12">
                    <th style="width: 150px">Nama Ekskul</th>
                    <th style="width: 150px">Nama Rekrutmen</th>
                    <th style="width: 150px">Tanggal Dimulai</th>
                    <th style="width: 150px">Tanggal Berakhir</th>
                </tr>
                @foreach ($rekrutmen as $data)
                    <tr>
                        <td style="width: 150px">{{ $data->ekskul->nama_ekskul ?? '' }}</td>
                        <td style="width: 150px">{{ $data->nama_rekrutmen ?? '' }}</td>
                        <td style="width: 150px">{{ date('d/m/Y', strtotime($data->tanggal_dimulai ?? '')) }}</td>
                        <td style="width: 150px">{{ date('d/m/Y', strtotime($data->tanggal_berakhir ?? '')) }}</td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
