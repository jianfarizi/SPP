<div class="content-wrapper">
    <!-- Header Konten (Judul Halaman) -->
    <section class="content-header">
        <!-- Judul Halaman yang Dinamis -->
        <h1>
            <?php echo isset($title) ? '' . $title : null; ?>
        </h1>
        <!-- Breadcrumb Navigasi -->
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <!-- Konten Utama -->
    <section class="content">

        <div class="row">
            <div class="col-md-4">

                <!-- Kotak Gambar Profil -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <!-- Menampilkan Gambar Profil Pengguna -->
                        <?php if (!empty($user['user_image'])) { ?>
                        <img src="<?php echo upload_url('users/'.$user['user_image']) ?>"
                            class="profile-user-img img-responsive img-circle">
                        <?php } else { ?>
                        <img src="<?php echo media_url('img/user.png') ?>"
                            class="profile-user-img img-responsive img-circle">
                        <?php } ?>

                        <!-- Nama Pengguna -->
                        <h3 class="profile-username text-center"><?php echo $user['user_full_name'] ?></h3>

                        <!-- Role/Jabatan Pengguna -->
                        <p class="text-muted text-center"><?php echo $user['role_name'] ?></p>

                        <!-- Daftar Statistik Pengguna -->
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="pull-right">1,322</a>
                            </li>
                        </ul>
                        <br>
                        <!-- Tautan untuk Mengatur Ulang Password -->
                        <?php if ($this->session->userdata('uid') != $user['user_id']) { ?>
                        <a href="<?php echo site_url('manage/users/rpw/'. $user['user_id']) ?>"
                            class="btn btn-info btn-block"><b>Reset Password</b></a>
                        <?php } else { ?>
                        <!-- Tautan untuk Mengubah Password Pribadi -->
                        <a href="<?php echo site_url('manage/profile/cpw/') ?>" class="btn btn-info btn-block"><b>Ubah
                                Password</b></a>
                        <?php } ?>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <div class="col-md-8">
                <!-- Kotak Tentang Saya -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <!-- Judul Kotak Tentang Saya -->
                        <h3 class="box-title">About Me</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Informasi Nama Pengguna -->
                        <strong><i class="fa fa-book margin-r-5"></i> Nama</strong>
                        <p class="text-muted">
                            <?php echo $user['user_full_name'] ?>
                        </p>

                        <hr>

                        <!-- Informasi Email Pengguna -->
                        <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
                        <p class="text-muted"><?php echo $user['user_email'] ?></p>

                        <hr>

                        <!-- Catatan Tentang Pengguna -->
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
                        <p><?php echo $user['user_description'] ?></p>
                        <!-- Tautan untuk Mengedit Profil Pengguna -->
                        <a href="<?php echo site_url('manage/users/edit/' . $user['user_id']) ?>"
                            class="btn btn-success"><b>Edit</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
        </div>
    </section>
</div>