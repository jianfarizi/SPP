<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SMA</title>

    <!-- Mengatur viewport untuk tampilan responsif -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Ikon favicon untuk tab browser -->
    <link rel="icon" type="image/png" href="<?php echo media_url('img/SMA_1_LABUHAN_HAJI.png') ?>">

    <!-- Link ke stylesheet untuk Bootstrap -->
    <link href="<?php echo media_url() ?>css/bootstrap.min.css" rel="stylesheet" />
    <!-- Link ke stylesheet untuk Font Awesome -->
    <link href="<?php echo media_url() ?>css/font-awesome.min.css" rel="stylesheet" />
    <!-- Link ke stylesheet untuk halaman login -->
    <link href="<?php echo media_url() ?>css/login.css" rel="stylesheet" />
</head>

<body>

    <div class="row">
        <div class="col-md-5">
            <!-- Logo Sekolah -->
            <div class="logo hidden-xs hidden-sm">
                <?php if (isset($setting_logo) AND $setting_logo['setting_value'] == NULL) { ?>
                <!-- Jika logo tidak ada di pengaturan, tampilkan logo default -->
                <a src="<?php echo media_url('img/smplogo.png') ?>" class="img-responsive">
                    <?php } else { ?>
                    <!-- Jika logo ada, tampilkan logo dari pengaturan -->
                    <img src="<?php echo upload_url('school/' . $setting_logo['setting_value']) ?>"
                        class="img-responsive">
                    <?php } ?>
            </div>
            <!-- Nama Merk dan Sekolah -->
            <p class="merk"><span style="color: #2ABB9B">SISTEM INFORMASI PEMBAYARAN</span> </p>
            <?php if (isset($setting_school) AND $setting_school['setting_value'] == '-') { ?>
            <!-- Jika nama sekolah tidak ada di pengaturan, tampilkan teks default -->
            <p class="school">Sistem Informasi Pembayaran </p>
            <?php } else { ?>
            <!-- Jika nama sekolah ada, tampilkan nama sekolah dari pengaturan -->
            <p class="school"><?php echo $setting_school['setting_value'] ?></p>
            <?php } ?>
        </div>
        <div class="col-md-7">
            <!-- Kotak Login -->
            <div class="box">
                <?php echo form_open('manage/auth/login', array('class'=>'login100-form validate-form')); ?>

                <div class="col-md-12">
                    <p class="title-login">Login Admin</p>
                    <?php if ($this->session->flashdata('failed')) { ?>
                    <!-- Jika login gagal, tampilkan pesan error -->
                    <br><br>
                    <div class="alert alert-danger alert-dismissible" style="margin-top: -85px !important;">
                        <h5><i class="fa fa-close"></i> Email atau Password salah!</h5>
                    </div>
                    <?php  }  ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" required="" autofocus="" name="email" placeholder="Masukan email"
                                    class="form-control flat">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" required="" name="password" placeholder="Masukan password"
                                    class="form-control flat">
                            </div>
                        </div>
                    </div>
                    <!-- Tombol Login -->
                    <button class="btn btn-login">Login</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</body>

</html>