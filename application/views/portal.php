<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMA 1 LABUHAN HAJI - Home </title>
    <link rel="icon" type="image/png" href="<?php echo media_url('img/SMA_1_LABUHAN_HAJI.png') ?>">

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo media_url() ?>/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo media_url() ?>/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <link href="<?php echo media_url() ?>/css/frontend-style.css" rel="stylesheet">
    <link href="<?php echo media_url() ?>/css/portal.css" rel="stylesheet">

</head>

<body>
    <!-- Background Image Section -->

    <body style="background-image:url(asset/images/icon/f.png);background-size:cover;">

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="page-content--bge5">
                <div class="container">
                    <!-- Login Wrap Section -->
                    <div class="login-wrap">
                        <div class="login-content">
                            <!-- Content Section -->
                            <section class="content-section">
                                <div class="container text-center">
                                    <div class="row">
                                        <!-- Welcome Message -->
                                        <div class="col-md-12">
                                            <h1>Selamat Datang Di</h1>
                                            <h3>SISTEM INFORMASI PEMBAYARAN SEKOLAH</h3>
                                            <p class="lead mb-5 colr">
                                            <h1><strong>SMA 1 LABUHAN HAJI</strong></h1>
                                            </p>
                                            <br> <br> <br>
                                        </div>
                                        <br> <br> <br>
                                        <!-- Admin Login -->
                                        <div class="col-md-4">
                                            <a href="<?php echo site_url('manage') ?>">
                                                <div class="box">
                                                    <i class="fa fa-user icon-menu"></i>
                                                    <br>
                                                    <strong>Login Admin</strong>
                                                </div>
                                            </a>
                                        </div>
                                        <!-- Check Payment -->
                                        <div class="col-md-4">
                                            <a href="<?php echo site_url('home') ?>">
                                                <div class="box">
                                                    <i class="fa fa-money icon-menu"></i>
                                                    <br>
                                                    <strong>Cek Pembayaran</strong>
                                                </div>
                                            </a>
                                        </div>
                                        <!-- Student Login -->
                                        <div class="col-md-4">
                                            <a href="<?php echo site_url('student') ?>">
                                                <div class="box">
                                                    <i class="fa fa-graduation-cap icon-menu"></i>
                                                    <br>
                                                    <strong>Login Siswa</strong>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- End of Content Section -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Page Wrapper -->

    </body>

</html>