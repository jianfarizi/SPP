<!DOCTYPE html>
<html>

<head>
    <!-- Menetapkan karakter set dan kompatibilitas browser -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Pengaturan viewport untuk responsif di perangkat mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SMA 1 LABUHAN HAJI - LOGIN</title>

    <!-- Ikon halaman -->
    <link rel="icon" type="image/png" href="<?php echo media_url('img/SMA_1_LABUHAN_HAJI.png') ?>">

    <!-- Link ke file CSS untuk bootstrap -->
    <link href="<?php echo media_url() ?>css/bootstrap.min.css" rel="stylesheet" />
    <!-- Link ke file CSS untuk Font Awesome (ikon) -->
    <link href="<?php echo media_url() ?>css/font-awesome.min.css" rel="stylesheet" />
    <!-- Link ke file CSS khusus untuk halaman login -->
    <link href="<?php echo media_url() ?>css/login.css" rel="stylesheet" />
</head>

<body>

    <!-- Kontainer utama untuk tata letak halaman login -->
    <div class="row">
        <!-- Kolom untuk logo dan informasi sekolah -->
        <div class="col-md-5 ">
            <!-- Logo sekolah untuk tampilan desktop -->
            <div class="logo hidden-xs hidden-sm">
                <?php if (isset($setting_logo) AND $setting_logo['setting_value'] == NULL) { ?>
                <img src="<?php echo media_url('img/logo.png') ?>" class="img-responsive">
                <?php } else { ?>
                <img src="<?php echo upload_url('school/' . $setting_logo['setting_value']) ?>" class="img-responsive">
                <?php } ?>
            </div>
            <!-- Nama sistem informasi pembayaran -->
            <p class="merk"><span style="color: #2ABB9B">SISTEM INFORMASI PEMBAYARAN</span> </p>
            <!-- Nama sekolah jika tersedia -->
            <?php if (isset($setting_school) AND $setting_school['setting_value'] == '-') { ?>
            <p class="school">Sistem Informasi Pembayaran </p>
            <?php } else { ?>
            <p class="school"><?php echo $setting_school['setting_value'] ?></p>
            <?php } ?>
        </div>

        <!-- Kolom untuk formulir login -->
        <div class="col-md-7">
            <div class="box">
                <!-- Formulir login siswa -->
                <?php echo form_open('student/auth/login', array('class'=>'login100-form validate-form')); ?>

                <div class="col-md-10">
                    <!-- Judul formulir login -->
                    <p class="title-login">Login Siswa</p>

                    <!-- Menampilkan pesan kesalahan jika login gagal -->
                    <?php if ($this->session->flashdata('failed')) { ?>
                    <br><br>
                    <div class="alert alert-danger alert-dismissible" style="margin-top: -85px !important;">
                        <h5><i class="fa fa-close"></i> NIS atau Password salah!</h5>
                    </div>
                    <?php  }  ?>

                    <!-- Kolom input untuk NIS dan Password -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIS</label>
                                <input type="text" required="" autofocus="" name="nis" placeholder="Masukan NIS"
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

                    <!-- Tombol untuk mengirim formulir login -->
                    <button class="btn btn-login">Login</button>

                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

</body>

</html>