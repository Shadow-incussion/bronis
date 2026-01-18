<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel | Manajemen Pengguna</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<style>
/* === STYLE ASLI TIDAK DIUBAH === */
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
.topbar .left img{ width:165px; }
.topbar .right{ display:flex; align-items:center; }
.topbar .icon{ font-size:18px; margin-left:14px; color:#c6862d; cursor:pointer; }
.topbar .logout{ margin-left:18px; color:#c6862d; font-weight:600; text-decoration:none; }
.admin{ display:flex; min-height:calc(100vh - 60px); }
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
.main{ flex:1; padding:25px; }
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
    margin-bottom:20px;
}
.primary{
    padding:10px 18px;
    background:#f4b41a;
    border:none;
    border-radius:8px;
    font-weight:600;
    color:#4b2c20;
    cursor:pointer;
    margin-bottom:15px;
}
table{
    width:100%;
    border-collapse:collapse;
}
th{
    background:#6b3f28;
    color:#fff;
    padding:12px;
}
td{
    padding:12px;
    border-bottom:1px solid #eee;
}
.action a, .action button{
    text-decoration:none;
    font-weight:600;
    margin-right:10px;
    font-size:13px;
    background:none;
    border:none;
    cursor:pointer;
}

.edit{ color:#0d6efd; }
.delete{ color:#dc3545; }

/* Form Tambah User */
.user-form input, .user-form select{
    width:100%;
    padding:8px 10px;
    margin-bottom:12px;
    border:1px solid #ccc;
    border-radius:6px;
}
.user-form button{
    background:#f4b41a;
    color:#4b2c20;
    font-weight:600;
    padding:10px 16px;
    border:none;
    border-radius:6px;
    cursor:pointer;
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
            <button class="logout" type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="admin">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('pengguna.index') }}" class="active">Pengguna</a>
        <a href="{{ route('produk.index') }}">Produk</a>
        <a href="{{ route('kategori.index') }}">Kategori</a>
        <a href="{{ route('stok.index') }}">Stok</a>
        <a href="{{ route('transaksi.index') }}">Transaksi</a>
        <a href="{{ route('laporan.index') }}">Laporan</a>
    </div>

    <!-- MAIN -->
    <div class="main">
        <div class="page-title">Manajemen Pengguna</div>

        <!-- FORM TAMBAH USER -->
        <div class="box">
            <div style="font-weight:600; margin-bottom:10px;">Tambah Pengguna Baru</div>
            <form class="user-form" action="{{ route('pengguna.store') }}" method="POST">
                @csrf
                <div>
                    <label>Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div>
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required>
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label>Role</label>
                    <select name="role" required>
                        <option value="">--Pilih Role--</option>
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>
                <button type="submit">Simpan User</button>
            </form>
        </div>

        <!-- LIST & EDIT USER INLINE -->
        <div class="box">
            <table>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>

                @foreach($users as $user)
                <tr>
                    <form action="{{ route('pengguna.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td>
                            <input type="text" name="name" value="{{ $user->name }}" required>
                        </td>
                        <td>
                            <input type="text" name="username" value="{{ $user->username }}" required>
                        </td>
                        <td>
                            <select name="role" required>
                                <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                                <option value="kasir" {{ $user->role=='kasir'?'selected':'' }}>Kasir</option>
                            </select>
                        </td>
                        <td class="action">
                            <button type="submit" class="edit">Simpan</button>
                    </form>

                    <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="delete"
                            onclick="return confirm('Hapus pengguna?')">Hapus</button>
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
