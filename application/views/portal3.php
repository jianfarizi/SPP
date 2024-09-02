<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Charset UTF-8 untuk memastikan semua karakter ditampilkan dengan benar -->
    <meta charset="utf-8">
    <!-- Menyesuaikan viewport untuk tampilan responsif pada perangkat mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Deskripsi halaman untuk SEO -->
    <meta name="description" content="">
    <!-- Penulis halaman -->
    <meta name="author" content="">

    <!-- Judul Halaman yang Ditampilkan di Tab Browser -->
    <title>SMA 1 LABUHAN HAJI | Portal</title>
    <!-- Ikon Favicon untuk Tab Browser -->
    <link rel="icon" type="image/png" href="<?php echo media_url('ico/favicon.ico') ?>">

    <!-- Bootstrap Core CSS untuk gaya dasar -->
    <link href="<?php echo media_url() ?>/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menggunakan font dari Google Fonts -->
    <link rel="stylesheet" href="<?php echo media_url() ?>/css/load-font-googleapis.css">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="<?php echo media_url() ?>/css/font-awesome.min.css">

    <!-- CSS Kustom untuk gaya tambahan -->
    <link href="<?php echo media_url() ?>/css/frontend-style.css" rel="stylesheet">
    <link href="<?php echo media_url() ?>/css/portal.css" rel="stylesheet">

</head>

<body>

    <!-- Bagian Utama Halaman -->
    <section class="content-section">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <!-- Judul Selamat Datang -->
                    <h2><i class="fa fa-graduation-cap"></i> Selamat Datang</h2>
                    <!-- Deskripsi Singkat tentang Sistem -->
                    <p class="lead mb-5 colr">Sistem Pembayaran Pendidikan Sekolah</p>
                </div>
                <!-- Menu Navigasi -->
                <div class="col-md-4">
                    <!-- Link Menu Login Admin -->
                    <a href="<?php echo site_url('manage') ?>">
                        <div class="box">
                            <i class="fa fa-desktop icon-menu"></i>
                            <br>
                            Login Admin
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <!-- Link Menu Cek Pembayaran Siswa -->
                    <a href="<?php echo site_url('home') ?>">
                        <div class="box">
                            <i class="fa fa-credit-card icon-menu"></i>
                            <br>
                            Cek Pembayaran Siswa
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <!-- Link Menu Login Siswa -->
                    <a href="<?php echo site_url('student') ?>">
                        <div class="box">
                            <i class="fa fa-users icon-menu"></i>
                            <br>
                            Login Siswa
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

</body>

</html>