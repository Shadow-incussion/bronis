<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home | Brownies Kukus</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* ===== RESET ===== */
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        html{ scroll-behavior:smooth; }

        body{
            background:linear-gradient(135deg,#4b2c20,#7a4a32);
            color:#fff;
        }

        /* ===== NAV ===== */
        .top-nav{
            position:fixed;
            top:0;
            right:0;
            width:100%;
            padding:15px 40px;
            display:flex;
            justify-content:flex-end;
            gap:25px;
            z-index:100;
        }

        .top-nav a{
            color:#ffd27d;
            text-decoration:none;
            font-weight:500;
            font-size:14px;
        }

        /* ===== SECTION ===== */
        section{
            min-height:100vh;
            padding:120px 80px;
            display:flex;
            align-items:center;
        }

        /* ===== HERO ===== */
        .hero{
            justify-content:space-between;
        }

        .hero-text{
            max-width:520px;
        }

        .hero-text h1{
            font-size:44px;
            margin-bottom:15px;
        }

        .hero-text p{
            font-size:16px;
            line-height:1.8;
            opacity:.9;
            margin-bottom:30px;
        }

        .hero-text .btn{
            display:inline-block;
            background:#f4b41a;
            color:#4b2c20;
            padding:12px 28px;
            border-radius:8px;
            font-weight:600;
            text-decoration:none;
            margin-right:10px;
        }

        .hero img{
            width:380px;
        }

        /* ===== PRODUK ===== */
        .produk{
            flex-direction:column;
        }

        .produk h2{
            font-size:32px;
            margin-bottom:20px;
        }

        .filter-kategori{
            margin-bottom:25px;
        }

        .filter-kategori button{
            background:rgba(255,255,255,.15);
            color:#ffd27d;
            border:none;
            padding:8px 18px;
            margin-right:10px;
            border-radius:6px;
            cursor:pointer;
            font-weight:600;
        }

        .filter-kategori button.active{
            background:#ffd27d;
            color:#4b2c20;
        }

        .produk-list{
            width:100%;
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
            gap:25px;
        }

        .card{
            background:rgba(255,255,255,.15);
            padding:20px;
            border-radius:14px;
            text-align:center;
        }

        .card img{
            width:100%;
            height:180px;
            object-fit:cover;
            border-radius:10px;
            margin-bottom:12px;
        }

        .card h3{
            margin-bottom:6px;
        }

        .card span{
            display:block;
            margin-bottom:10px;
            color:#ffd27d;
            font-weight:600;
        }

        .btn-order{
            display:inline-block;
            background:#f4b41a;
            color:#4b2c20;
            padding:8px 18px;
            border-radius:6px;
            text-decoration:none;
            font-weight:600;
        }

        /* ===== CONTACT ===== */
        .contact{
            flex-direction:column;
            text-align:center;
        }

        .contact h2{
            font-size:32px;
            margin-bottom:20px;
        }

        .contact-icons{
            display:flex;
            gap:30px;
        }

        .contact-icons a{
            color:#ffd27d;
            text-decoration:none;
            font-weight:600;
            font-size:16px;
        }
    </style>
</head>

<body>

<!-- ===== NAV ===== -->
<div class="top-nav">
    <a href="#produk">Produk</a>
    <a href="#contact">Contact</a>
    <a href="{{ route('login') }}">Login</a>
</div>

<!-- ===== HERO ===== -->
<section class="hero" id="home">
    <div class="hero-text">
        <h1>Brownies Kukus</h1>
        <p>
            Brownies kukus lembut dengan rasa premium,
            dibuat dari bahan berkualitas dan tanpa pengawet.
        </p>

        <a href="#produk" class="btn">Lihat Produk</a>
        <a href="{{ route('login') }}" class="btn">Login Sistem</a>
    </div>

    <img src="{{ asset('images/logo.png') }}" alt="Brownies Kukus">
</section>

<!-- ===== PRODUK ===== -->
<section class="produk" id="produk">
    <h2>Produk Kami</h2>

    <!-- FILTER -->
    <div class="filter-kategori">
        <button class="active" data-filter="all">Semua</button>
        @foreach($kategori as $k)
            <button data-filter="{{ $k->id }}">{{ $k->nama }}</button>
        @endforeach
    </div>

    <!-- LIST PRODUK -->
    <div class="produk-list">
        @foreach($produk as $p)
        <div class="card" data-kategori="{{ $p->id_kategori }}">
            <img src="{{ asset('uploads/produk/'.$p->foto) }}" alt="{{ $p->nama }}">
            <h3>{{ $p->nama }}</h3>
            <span>Rp {{ number_format($p->harga,0,',','.') }}</span>

            <a
                href="https://wa.me/628123456789?text={{ urlencode(
'Halo Admin, saya ingin memesan:
Produk : '.$p->nama.'
Harga : Rp'.number_format($p->harga,0,',','.').'
Mohon info stok & total pembayaran.'
                ) }}"
                target="_blank"
                class="btn-order">
                Order via WhatsApp
            </a>
        </div>
        @endforeach
    </div>
</section>

<!-- ===== CONTACT ===== -->
<section class="contact" id="contact">
    <h2>Hubungi Kami</h2>
    <p>Silakan hubungi kami melalui</p>

    <div class="contact-icons">
        <a href="https://wa.me/628123456789" target="_blank">📱 WhatsApp</a>
        <a href="https://instagram.com/akunmu" target="_blank">📸 Instagram</a>
        <a href="mailto:brownies@gmail.com">✉️ Email</a>
    </div>
</section>

<!-- ===== SCRIPT ===== -->
<script>
    const buttons = document.querySelectorAll('.filter-kategori button');
    const cards   = document.querySelectorAll('.produk-list .card');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;

            cards.forEach(card => {
                card.style.display =
                    filter === 'all' || card.dataset.kategori === filter
                    ? 'block'
                    : 'none';
            });
        });
    });
</script>

</body>
</html>
