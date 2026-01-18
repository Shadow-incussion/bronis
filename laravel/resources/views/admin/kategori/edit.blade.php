<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori | Brownies Kukus</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<style>
/* ===== STYLE SAMA DENGAN INDEX ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(180deg,#f6f1eb,#efe4da);
}

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

.topbar img{ width:165px; }

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
    padding:25px;
    border-radius:14px;
    box-shadow:0 6px 14px rgba(0,0,0,.12);
    max-width:500px;
}

input[type="text"]{
    width:100%;
    padding:10px 14px;
    border-radius:8px;
    border:1px solid #ccc;
    margin-bottom:15px;
}

.primary{
    background:#f4b41a;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    font-weight:600;
    color:#4b2c20;
    cursor:pointer;
}

.back{
    display:inline-block;
    margin-top:15px;
    text-decoration:none;
    color:#c6862d;
    font-weight:600;
}
</style>

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
            <button class="logout">Logout</button>
        </form>
    </div>
</div>

<div class="admin">

<!-- SIDEBAR -->
<div class="sidebar">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('pengguna.index') }}">Pengguna</a>
    <a href="{{ route('produk.index') }}">Produk</a>
    <a href="{{ route('kategori.index') }}" class="active">Kategori</a>
    <a href="{{ route('stok.index') }}">Stok</a>
    <a href="{{ route('transaksi.index') }}">Transaksi</a>
    <a href="{{ route('laporan.index') }}">Laporan</a>
</div>

<!-- MAIN -->
<div class="main">

<div class="page-title">Edit Kategori</div>

<div class="box">

<form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nama"
           value="{{ $kategori->nama }}"
           required>

    <button class="primary">Update</button>
</form>

<a href="{{ route('kategori.index') }}" class="back">← Kembali</a>

</div>
</div>
</div>

</body>
</html>
