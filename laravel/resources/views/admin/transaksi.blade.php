<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Transaksi | Brownies Kukus</title>

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
    padding:0 20px;
    border-bottom:1px solid #d6c7bb;
}
.topbar img{ width:165px; }

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
}

.primary{
    background:#f4b41a;
    border:none;
    padding:6px 12px;
    border-radius:6px;
    font-weight:600;
    color:#4b2c20;
    cursor:pointer;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}
th{
    background:#6b3f28;
    color:#fff;
    padding:12px;
}
td{
    padding:12px;
    border-bottom:1px solid #eee;
    color:#5a3621;
}

select{
    padding:6px;
    border-radius:6px;
}

/* PRINT */
@media print {
    .sidebar,.topbar,.primary,select,button{ display:none!important; }
}
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
    <a href="{{ route('produk.index') }}">Produk</a>
    <a href="{{ route('kategori.index') }}">Kategori</a>
    <a href="{{ route('stok.index') }}">Stok</a>
    <a href="{{ route('transaksi.index') }}" class="active">Transaksi</a>
    <a href="{{ route('laporan.index') }}">Laporan</a>
</div>

<div class="main">
<div class="page-title">Manajemen Transaksi</div>

<div class="box">

<button class="primary" onclick="toggleForm()">+ Tambah Transaksi</button>

<!-- FORM TAMBAH -->
<div id="formTransaksi" style="display:none;margin:15px 0;">
<form action="{{ route('transaksi.store') }}" method="POST">
@csrf

<label>Nama Customer</label>
<input type="text" name="nama_customer" required>

<label>Produk</label>
<select name="produk_id" required>
@foreach($produk as $p)
<option value="{{ $p->id }}">
    {{ $p->nama }} {{ $p->stok()->sum('jumlah') }}
</option>


@endforeach
</select>

<label>Jumlah</label>
<input type="number" name="jumlah" min="1" required>

<label>Status</label>
<select name="status">
<option value="menunggu">Menunggu</option>
<option value="diproses">Diproses</option>
</select>

<br><br>
<button class="primary">Simpan</button>
</form>
</div>

<table>
<tr>
    <th>Nama</th>
    <th>Produk</th>
    <th>Total</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

@foreach($transaksi as $t)
<tr>
    <td>{{ $t->nama_customer }}</td>

    <td>
        @foreach($t->detail as $d)
            {{ $d->produk->nama }} ({{ $d->qty }})<br>
        @endforeach
    </td>

    <td>Rp {{ number_format($t->total,0,',','.') }}</td>

    <!-- 🔥 STATUS BISA DIUBAH -->
    <td>
        <form action="{{ route('transaksi.updateStatus',$t->id) }}" method="POST">
            @csrf
            <select name="status" onchange="this.form.submit()">
                <option value="menunggu" {{ $t->status=='menunggu'?'selected':'' }}>Menunggu</option>
                <option value="diproses" {{ $t->status=='diproses'?'selected':'' }}>Diproses</option>
                <option value="selesai" {{ $t->status=='selesai'?'selected':'' }}>Selesai</option>
            </select>
        </form>
    </td>

    <td>
        <button class="primary" onclick="printRow('print-{{ $t->id }}')">🖨 Cetak</button>
    </td>
</tr>

<tr style="display:none">
<td colspan="5">
<div id="print-{{ $t->id }}">
    <h3 style="text-align:center">Struk Transaksi</h3>
    Nama : {{ $t->nama_customer }}<br>
    Tanggal : {{ $t->created_at->format('d/m/Y H:i') }}<br><hr>
    @foreach($t->detail as $d)
        {{ $d->produk->nama }} x {{ $d->qty }}<br>
    @endforeach
    <hr>
    <b>Total : Rp {{ number_format($t->total,0,',','.') }}</b>
</div>
</td>
</tr>
@endforeach
</table>

</div>
</div>
</div>

<script>
function toggleForm(){
    const f=document.getElementById('formTransaksi');
    f.style.display=f.style.display==='none'?'block':'none';
}
function printRow(id){
    const c=document.getElementById(id).innerHTML;
    document.body.innerHTML=c;
    window.print();
    location.reload();
}
</script>

</body>
</html>
