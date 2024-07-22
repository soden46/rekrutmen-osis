<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Jadwal Tes</title>
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

        .table td,
        .table th {
            padding: 8px;
            word-wrap: break-word;
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

        @media print {
            @page {
                margin: 20mm;
            }

            .table {
                page-break-inside: auto;
            }

            .table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .table td,
            .table th {
                word-wrap: break-word;
                overflow: hidden;
                white-space: nowrap;
            }
        }

        .table-responsive {
            overflow-x: auto;
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
            <h5 class="text-center">Laporan Data Jadwal Tes</h5>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr class="font-12">
                        <th>Nama Rekrutmen</th>
                        <th>Nama Ekskul</th>
                        <th>Nama Jadwal Tes</th>
                        <th>Tanggal Tes</th>
                        <th>Jam Tes</th>
                    </tr>
                    @foreach ($tes as $data)
                        <tr>
                            <td>{{ $data->rekrutmen->nama_rekrutmen ?? '' }}</td>
                            <td>{{ $data->rekrutmen->ekskul->nama_ekskul ?? '' }}</td>
                            <td>{{ $data->nama_jadwal_tes }}</td>
                            <td>{{ $data->tanggal }}</td>
                            <td>{{ $data->jam }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</body>

</html>
