<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
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
            width: 120px;
            height: 150px;
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
                <img src="{{public_path('storage/asset/sleman.png')}}" id="foto" alt="Logo" height="75px" />
                <h1 class="text-center">SMP Negeri 2 Mlati</h1>
                <p class="text-center">Jalan </p>
                <p class="text-center">Telepon (0274) 797496</p>
                <p class="text-center">Laman: </p>
            </div>
            <div class="divider py-1 bg-dark mb-3 mt-2"></div>

            <table class="table table-bordered">
                <tr class="font-12">
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>TB</th>
                    <th>BB</th>
                </tr>
                @foreach ($siswa as $data)
                <tr>
                    <td>{{ $data->nis }}</td>
                    <td>{{ $data->users->nama ?? ''}}</td>
                    <td>{{$data->kelas}}</td>
                    <td>{{$data->tanggal_lahir}}</td>
                    <td>{{$data->alamat}}</td>
                    <td>{{$data->jenis_kelamin}}</td>
                    <td>{{$data->tinggi_badan}}</td>
                    <td>{{$data->berat_badan}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>