<div class="content-wrapper">
    <!-- Header Konten (Judul Halaman) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? '' . $title : null; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Beranda</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <!-- Konten Utama -->
    <section class="content">

        <div class="row">
            <div class="col-md-4">

                <!-- Gambar Profil -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <?php if (!empty($user['user_image'])) { ?>
                        <img src="<?php echo upload_url('users/'.$user['user_image']) ?>"
                            class="profile-user-img img-responsive img-circle" alt="Gambar Profil">
                        <?php } else { ?>
                        <img src="<?php echo media_url('img/user.png') ?>"
                            class="profile-user-img img-responsive img-circle" alt="Gambar Profil Default">
                        <?php } ?>

                        <h3 class="profile-username text-center"><?php echo $user['user_full_name']; ?></h3>

                        <p class="text-muted text-center"><?php echo $user['role_name']; ?></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Pengikut</b> <a class="pull-right">1,322</a>
                            </li>
                        </ul>
                        <br>

                        <a href="<?php echo site_url('manage/profile/cpw/') ?>" class="btn btn-info btn-block"><b>Ubah
                                Password</b></a>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <div class="col-md-8">
                <!-- Kotak Tentang Saya -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tentang Saya</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i> Nama</strong>

                        <p class="text-muted">
                            <?php echo $user['user_full_name']; ?>
                        </p>

                        <hr>

                        <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>

                        <p class="text-muted"><?php echo ucfirst($this->session->userdata('uemail')); ?></p>

                        <hr>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Catatan</strong>

                        <p><?php echo $user['user_description'] ?></p>
                        <a href="<?php echo site_url('manage/profile/edit/') ?>" class="btn btn-success"><b>Edit</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
        </div>
    </section>
</div>