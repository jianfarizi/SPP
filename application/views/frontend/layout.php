<!DOCTYPE html>
<html>

<head>
    <title>SMA 1 LABUHAN HAJI</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Judul Halaman -->
    <title><?php echo $this->config->item('app_name') ?> <?php echo isset($title) ? ' | ' . $title : null; ?></title>
    <!-- Ikon Favicon -->
    <link rel="icon" type="image/png" href="<?php echo media_url('ico/favicon.ico') ?>">
    <!-- Memberitahu browser untuk responsif terhadap lebar layar -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo media_url() ?>/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo media_url() ?>/css/font-awesome.min.css">
    <!-- Gaya Tema AdminLTE -->
    <link rel="stylesheet" href="<?php echo media_url() ?>/css/AdminLTE.min.css">
    <!-- Gaya Kustom -->
    <link rel="stylesheet" href="<?php echo media_url() ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo media_url() ?>/css/frontend-style.css">
    <!-- Gaya Font Google -->
    <link rel="stylesheet" href="<?php echo media_url() ?>/css/load-font-googleapis.css">

    <!-- Skrip jQuery -->
    <script src="<?php echo media_url() ?>/js/jquery.min.js"></script>

</head>

<body>
    <!-- Navigasi Bar -->
    <nav class="navbar navbar-default fixed">
        <div class="navbar-header">
            <a class="navbar-brand" href="">
                <?php if (isset($setting_logo) AND $setting_logo['setting_value'] != NULL) { ?>
                <!-- Logo Sekolah dari Pengaturan -->
                <img src="<?php echo upload_url('school/' . $setting_logo['setting_value']) ?>"
                    style="height: 40px; margin-top: -10px;" class="pull-left">
                <?php } else { ?>
                <!-- Logo Sekolah Default -->
                <img src="<?php echo media_url('img/smplogo.png') ?>"
                    style="height: 40px; margin-top: -10px; margin-right: 5px;" class="pull-left">
                <?php } ?>
                <!-- Nama Sekolah dari Pengaturan -->
                <?php echo $setting_school['setting_value'] ?>
            </a>
            <!-- Tombol Sign In (Dikomentari) -->
            <!-- <button type="button" class="btn btn-default navbar-btn pull-right">Sign in</button> -->
        </div>
    </nav>

    <!-- Menyertakan Tampilan Halaman Depan -->
    <?php $this->load->view('frontend/home') ?>
    <!-- Menyertakan Tampilan Footer -->
    <?php $this->load->view('frontend/footer') ?>

    <!-- Skrip Bootstrap -->
    <script src="<?php echo media_url() ?>/js/bootstrap.min.js"></script>
</body>

</html>