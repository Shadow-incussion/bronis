<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login | Brownies Kukus</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    height:100vh;
    background: linear-gradient(180deg,#5a3724,#3e2416);
    display:flex;
    justify-content:center;
    align-items:center;
    color:#fff;
    font-family:'Poppins', sans-serif;
}

.login-wrapper{
    width:360px;
    text-align:center;
}

.login-wrapper img{
    width:300px;
    margin-bottom:1px;
}

.subtitle{
    font-size:13px;
    opacity:.85;
    margin-bottom:25px;
}

.input-group{
    position:relative;
    margin-bottom:14px;
}

.input-group input{
    width:100%;
    padding:12px 12px 12px 42px;
    border-radius:8px;
    border:1px solid rgba(255,255,255,.15);
    background: rgba(255,255,255,.08);
    color:#fff;
    outline:none;
}

.input-group input::placeholder{
    color:#ddd;
}

.input-group span{
    position:absolute;
    left:12px;
    top:50%;
    transform:translateY(-50%);
    opacity:.8;
}

button{
    width:100%;
    padding:12px;
    background:#f4b41a;
    border:none;
    border-radius:8px;
    font-weight:600;
    font-size:15px;
    color:#4b2c20;
    cursor:pointer;
}

button:hover{
    background:#e6a900;
}

.error{
    background:#ffb3b3;
    color:#7a0000;
    padding:10px;
    border-radius:6px;
    margin-bottom:12px;
    font-size:13px;
}
</style>
</head>

<body>

<div class="login-wrapper">

    <img src="{{ asset('images/logo.png') }}" alt="Logo Brownies Kukus">

    <p class="subtitle">
        Sistem Informasi Manajemen<br>
        UMKM Brownies Kukus Berbasis Web
    </p>

    {{-- pesan error --}}
    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="input-group">
            <span>👤</span>
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <span>🔒</span>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit">Login</button>
    </form>

</div>

</body>
</html>
