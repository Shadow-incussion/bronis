<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<meta charset="UTF-8">
<title>Dashboard | Brownies Kukus</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(180deg,#f6f1eb,#efe4da);
}

/* ===== TOPBAR ===== */
.topbar{
    height:60px;
    background:#efe4da;
    color:#5a3621;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 20px;
    border-bottom:1px solid #d6c7bb;
    box-shadow:0 2px 6px rgba(0,0,0,.08);
}

.topbar img{
    width:165px;
}

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
    background:none;
    border:none;
    cursor:pointer;
}

/* ===== LAYOUT ===== */
.admin{
    display:flex;
}

/* ===== SIDEBAR ===== */
.sidebar{
    width:220px;
    background:linear-gradient(180deg,#6b3f28,#5a3322);
    min-height:calc(100vh - 60px);
    padding-top:15px;
}

.sidebar a{
    display:block;
    padding:13px 22px;
    margin:4px 12px;
    border-radius:8px;
    color:#fff;
    text-decoration:none;
}

.sidebar a.active{
    background:#f4b41a;
    color:#4b2c20;
    font-weight:600;
}

/* ===== MAIN ===== */
.main{
    flex:1;
    padding:25px;
}

.main h2{
    font-size:20px;
    margin-bottom:18px;
    color:#5a3621;
}

/* ===== CARD ===== */
.card-box{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
}

.card{
    background:#fff;
    padding:18px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,.1);
    border-left:5px solid #f4b41a;
}

.card b{
    font-size:22px;
    margin-top:6px;
    display:block;
}

/* ===== GRAFIK ===== */
.box{
    margin-top:25px;
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 6px 14px rgba(0,0,0,.12);
}
</style>
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <div class="left">
        <img src="{{ asset('images/logo.png') }}">
    </div>
    <div class="right">
        <span class="icon">🔔</span>
        <span class="icon">👤</span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </div>
</div>

<!-- CONTENT -->
<div class="admin">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
        <a href="{{ route('pengguna.index') }}">Pengguna</a>
        <a href="{{ route('produk.index') }}">Produk</a>
        <a href="{{ route('kategori.index') }}">Kategori</a>
        <a href="{{ route('stok.index') }}">Stok</a>
        <a href="{{ route('transaksi.index') }}">Transaksi</a>
        <a href="{{ route('laporan.index') }}">Laporan</a>
    </div>

    <!-- MAIN -->
    <div class="main">
        <h2>Dashboard</h2>

        <div class="card-box">
            <div class="card">Total Produk<b>{{ $totalProduk }}</b></div>
            <div class="card">Stok Menipis<b>{{ $stokMenipis }}</b></div>
            <div class="card">Pesanan Hari Ini<b>{{ $pesananHariIni }}</b></div>
            <div class="card">
                Total Penjualan
                <b>Rp {{ number_format($totalPenjualan,0,',','.') }}</b>
            </div>
        </div>

        <!-- GRAFIK -->
        <div class="box">
            <canvas id="grafikHarian"></canvas>
            <br><br>
            <canvas id="grafikMingguan"></canvas>
            <br><br>
            <canvas id="grafikBulanan"></canvas>
        </div>
    </div>

</div>

<!-- SCRIPT GRAFIK -->
<script>
new Chart(document.getElementById('grafikHarian'), {
    type: 'line',
    data: {
        labels: @json($harianLabel),
        datasets: [{
            label: 'Penjualan Harian',
            data: @json($harianTotal),
            borderWidth: 2,
            fill: false
        }]
    }
});

new Chart(document.getElementById('grafikMingguan'), {
    type: 'bar',
    data: {
        labels: @json($mingguanLabel),
        datasets: [{
            label: 'Penjualan Mingguan',
            data: @json($mingguanTotal)
        }]
    }
});

new Chart(document.getElementById('grafikBulanan'), {
    type: 'bar',
    data: {
        labels: @json($bulananLabel),
        datasets: [{
            label: 'Penjualan Bulanan',
            data: @json($bulananTotal)
        }]
    }
});
</script>

</body>
</html>
