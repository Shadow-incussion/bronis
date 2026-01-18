<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Produk | Brownies Kukus</title>
<style>
/* style sama seperti create.blade.php */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:linear-gradient(180deg,#f6f1eb,#efe4da);}
.topbar{height:60px;background:#efe4da;display:flex;align-items:center;justify-content:space-between;padding:0 20px;border-bottom:1px solid #d6c7bb;box-shadow:0 2px 6px rgba(0,0,0,.08);}
.topbar img{width:165px;}
.admin{display:flex;min-height:calc(100vh - 60px);}
.sidebar{width:220px;background:linear-gradient(180deg,#6b3f28,#5a3322);padding-top:15px;}
.sidebar a{display:block;padding:13px 22px;margin:4px 12px;border-radius:8px;color:#fff;text-decoration:none;}
.sidebar a.active{background:#f4b41a;color:#4b2c20;font-weight:600;}
.main{flex:1;padding:25px;}
.page-title{font-size:20px;font-weight:600;color:#5a3621;margin-bottom:20px;}
.box{background:#fff;padding:20px;border-radius:14px;box-shadow:0 6px 14px rgba(0,0,0,.12);}
input, select, button{padding:10px;margin:10px 0;width:100%;}
button.primary{background:#f4b41a;border:none;padding:10px;color:#4b2c20;font-weight:600;cursor:pointer;}
</style>
</head>
<body>

<div class="topbar">
    <img src="{{ asset('images/logo.png') }}">
</div>

<div class="admin">
    <div class="sidebar">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('pengguna.index') }}">Pengguna</a>
        <a href="{{ route('produk.index') }}" class="active">Produk</a>
        <a href="{{ route('kategori.index') }}">Kategori</a>
        <a href="{{ route('stok.index') }}">Stok</a>
        <a href="{{ route('transaksi.index') }}">Transaksi</a>
        <a href="{{ route('laporan.index') }}">Laporan</a>
    </div>

    <div class="main">
        <div class="page-title">Edit Produk</div>

        <div class="box">
            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <label>Nama Produk</label>
                <input type="text" name="nama" value="{{ $produk->nama }}" required>

                <label>Harga</label>
                <input type="number" name="harga" value="{{ $produk->harga }}" required>

                <label>Kategori</label>
                <select name="id_kategori">
                    <option value="">--Pilih Kategori--</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ $produk->id_kategori == $k->id ? 'selected' : '' }}>
    {{ $k->nama }}
</option>

                    @endforeach
                </select>

                <label>Foto Produk</label>
                <input type="file" name="foto">
                @if($produk->foto)
                    <img src="{{ asset('storage/'.$produk->foto) }}" width="80">
                @endif

                <label>Status</label>
                <select name="status">
                    <option value="aktif" {{ $produk->status=='aktif'?'selected':'' }}>Aktif</option>
                    <option value="nonaktif" {{ $produk->status=='nonaktif'?'selected':'' }}>Nonaktif</option>
                </select>

                <button type="submit" class="primary">Update</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
