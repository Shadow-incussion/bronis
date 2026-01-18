<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan | Brownies Kukus</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background:linear-gradient(180deg,#f6f1eb,#efe4da);
            font-size:14px;
        }

        .topbar{
            height:60px;
            background:#efe4da;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 20px;
            border-bottom:1px solid #d6c7bb;
            box-shadow:0 2px 6px rgba(0,0,0,.08);
        }

        .topbar .left img{ width:165px; }

        .topbar .right{
            display:flex;
            align-items:center;
        }

        .topbar .icon{
            font-size:18px;
            margin-left:14px;
            color:#c6862d;
        }

        .topbar .logout{
            margin-left:18px;
            color:#c6862d;
            font-weight:600;
            text-decoration:none;
        }

        .admin{
            display:flex;
            min-height:calc(100vh - 60px);
        }

        .sidebar{
            width:220px;
            background:linear-gradient(180deg,#6b3f28,#5a3322);
            padding-top:15px;
        }

        .sidebar a{
            display:block;
            padding:13px 22px;
            margin:4px 12px;
            border-radius:8px;
            color:#fff;
            text-decoration:none;
            font-size:14px;
        }

        .sidebar a.active{
            background:#f4b41a;
            color:#4b2c20;
            font-weight:600;
        }

        .main{
            flex:1;
            padding:25px;
        }

        .page-title{
            font-size:20px;
            font-weight:600;
            color:#5a3621;
            margin-bottom:20px;
        }

        .box{
            background:#fff;
            padding:20px;
            border-radius:14px;
            box-shadow:0 6px 14px rgba(0,0,0,.12);
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }

        th{
            background:#6b3f28;
            color:#fff;
            padding:12px;
            text-align:left;
        }

        td{
            padding:12px;
            border-bottom:1px solid #eee;
            color:#5a3621;
        }

        .total{
            text-align:right;
            font-weight:600;
            margin-top:15px;
        }

        .filter-laporan{
            margin-bottom:15px;
        }

        .filter-laporan button{
            padding:8px 16px;
            margin-right:8px;
            border:none;
            border-radius:6px;
            background:#f4b41a;
            color:#4b2c20;
            font-weight:600;
            cursor:pointer;
        }

        .filter-laporan button.active{
            background:#4b2c20;
            color:#f4b41a;
        }

        .cetak-btn{
            margin-top:10px;
            padding:8px 16px;
            border:none;
            border-radius:6px;
            background:#6b3f28;
            color:#fff;
            font-weight:600;
            cursor:pointer;
        }
    </style>
</head>

<body>

<div class="topbar">
    <div class="left">
        <img src="{{ asset('images/logo.png') }}">
    </div>
    <div class="right">
        <span class="icon">🔔</span>
        <span class="icon">👤</span>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();"
           class="logout">Logout</a>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>

<div class="admin">

    <div class="sidebar">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('pengguna.index') }}">Pengguna</a>
        <a href="{{ route('produk.index') }}">Produk</a>
        <a href="{{ route('kategori.index') }}">Kategori</a>
        <a href="{{ route('stok.index') }}">Stok</a>
        <a href="{{ route('transaksi.index') }}">Transaksi</a>
        <a href="{{ route('laporan.index') }}" class="active">Laporan</a>
    </div>

    <div class="main">
        <div class="page-title">Laporan Penjualan</div>

        <div class="box">

            <div class="filter-laporan">
                <form action="{{ route('laporan.index') }}" method="GET">
                    <button type="submit" name="periode" value="harian" class="{{ request('periode')=='harian'?'active':'' }}">Harian</button>
                    <button type="submit" name="periode" value="mingguan" class="{{ request('periode')=='mingguan'?'active':'' }}">Mingguan</button>
                    <button type="submit" name="periode" value="bulanan" class="{{ request('periode')=='bulanan'?'active':'' }}">Bulanan</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                </tr>

                @forelse($laporan as $l)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($l->tanggal)->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($l->total_penjualan,0,',','.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">Belum ada data penjualan</td>
                </tr>
                @endforelse
            </table>

            <div class="total">
                Total Keseluruhan :
                Rp {{ number_format($totalKeseluruhan,0,',','.') }}
            </div>

            <button class="cetak-btn" onclick="window.print()">Cetak Laporan</button>
        </div>
    </div>
</div>

</body>
</html>
