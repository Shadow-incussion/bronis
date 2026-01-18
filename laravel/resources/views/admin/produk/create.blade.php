<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Produk | Brownies Kukus</title>

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
.topbar img{ width:165px; }

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

label{
    font-weight:600;
    color:#5a3621;
    display:block;
    margin-top:12px;
}

input, select{
    width:100%;
    padding:10px;
    margin-top:6px;
    border-radius:8px;
    border:1px solid #ccc;
}

button.primary{
    margin-top:18px;
    background:#f4b41a;
    border:none;
    padding:12px;
    width:100%;
    border-radius:10px;
    font-weight:600;
    color:#4b2c20;
    cursor:pointer;
}

.error{
    background:#f8d7da;
    color:#721c24;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}
</style>
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <img src="{{ asset('images/logo.png') }}">
</div>

<div class="admin">

<!-- SIDEBAR -->
<div class="sidebar">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('pengguna.index') }}">Pengguna</a>
    <a href="{{ route('produk.index') }}" class="active">Produk</a>
    <a href="{{ route('kategori.index') }}">Kategori</a>
    <a href="{{ route('stok.index') }}">Stok</a>
    <a href="{{ route('transaksi.index') }}">Transaksi</a>
    <a href="{{ route('laporan.index') }}">Laporan</a>
</div>

<!-- MAIN -->
<div class="main">

    <div class="page-title">Tambah Produk</div>

    <div class="box">

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Nama Produk</label>
            <input type="text" name="nama" value="{{ old('nama') }}" required>

            <label>Harga</label>
            <input type="number" name="harga" value="{{ old('harga') }}" required>

            <label>Stok</label>
            <input type="number" name="stok" value="{{ old('stok') }}" required>

            <label>Kategori</label>
            <select name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}"
                        {{ old('id_kategori') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                @endforeach
            </select>

            <label>Foto Produk</label>
            <input type="file" name="foto">

            <label>Status</label>
            <select name="status" required>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>

            <button type="submit" class="primary">Simpan Produk</button>
        </form>

    </div>
</div>
</div>

</body>
</html>
