<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Produk | Brownies Kukus</title>
<style>
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
table{width:100%;border-collapse:collapse;}
th{background:#6b3f28;color:#fff;padding:12px;}
td{padding:12px;border-bottom:1px solid #eee;color:#5a3621;}
button.primary{background:#f4b41a;border:none;padding:8px 14px;border-radius:6px;color:#4b2c20;font-weight:600;cursor:pointer;}
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
        <div class="page-title">Manajemen Produk</div>

        <a href="{{ route('produk.create') }}"><button class="primary">Tambah Produk</button></a>

        <div class="box">
            <table>
                <tr>
                    <th>Nama Produk</th>
                    <th>Foto</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                @foreach($produk as $p)
                <tr>
                    <td>{{ $p->nama_produk }}</td>
                    <td>
                        @if($p->foto)
                        <img src="{{ asset('storage/'.$p->foto) }}" width="50">
                        @endif
                    </td>
                    <td>Rp{{ number_format($p->harga,0,',','.') }}</td>
                    <td>{{ $p->kategori?->nama_kategori }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                    <td>
                        <a href="{{ route('produk.edit', $p->id) }}">Edit</a>
                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button>Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

</body>
</html>
