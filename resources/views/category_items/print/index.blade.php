<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Category Items</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #f2f2f2;
        }
        .title {
            text-align: center;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: bold;
        }
        footer {
            position: fixed;
            bottom: -15mm;
            left: 0;
            right: 0;
            height: 15mm;
            text-align: center;
            font-size: 10px;
            color: #555;
        }

    </style>
</head>
<body>

<div class="title">DATA CATEGORY ITEMS</div>
<table>
    <tr>
        <th>Kode</th>
        <td>{{$data->kode}}</td>
    </tr>
    <tr>
        <th>Nama</th>
        <td>{{$data->nama}}</td>
    </tr>
    
</table>

<h3>List Item</h3>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Item</th>
            <th>Jenis</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Supplier</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data->masterItems as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->jenis }}</td>
            <td>{{ $item->harga_beli }}</td>
            <td>{{ $item->harga_beli * (100 + $item->laba) / 100 }}</td>
            <td>{{ $item->supplier }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<footer>{{ \Illuminate\Support\Carbon::now('Asia/Jakarta')->format('d-m-Y H:i:s') }}</footer>
</body>
</html>
