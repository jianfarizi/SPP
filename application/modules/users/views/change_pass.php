<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reset Password
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Membuka form dengan metode POST ke URL saat ini -->
        <?php echo form_open(current_url()); ?>
        <!-- Kotak kecil (Stat box) -->
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <!-- Header box (opsional) -->
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Menampilkan pesan kesalahan validasi -->
                        <?php echo validation_errors(); ?>

                        <!-- Jika URL segment ketiga adalah 'cpw', maka input Password lama ditampilkan -->
                        <div class="form-group">
                            <?php if ($this->uri->segment(3) == 'cpw') { ?>
                            <label>Password lama *</label>
                            <input type="password" name="user_current_password" class="form-control"
                                placeholder="Password lama">
                            <?php } ?>
                        </div>

                        <!-- Input untuk Password baru -->
                        <div class="form-group">
                            <label>Password baru*</label>
                            <input type="password" name="user_password" class="form-control"
                                placeholder="Password baru">

                            <!-- Menyimpan ID pengguna dalam input tersembunyi -->
                            <?php if ($this->uri->segment(3) == 'cpw') { ?>
                            <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('uid'); ?>">
                            <?php } else { ?>
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>">
                            <?php } ?>
                        </div>

                        <!-- Input untuk Konfirmasi Password baru -->
                        <div class="form-group">
                            <label>Konfirmasi password baru*</label>
                            <input type="password" name="passconf" class="form-control"
                                placeholder="Konfirmasi password baru">
                        </div>

                        <!-- Keterangan bahwa kolom-kolom tersebut wajib diisi -->
                        <p class="text-muted">*) Kolom wajib diisi.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <!-- Header box (opsional) -->
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Tombol Simpan untuk mengirimkan form -->
                        <button type="submit" class="btn btn-block btn-success">Simpan</button>

                        <!-- Tombol Batal untuk kembali ke halaman sebelumnya -->
                        <a href="<?php echo site_url('manage/users'); ?>" class="btn btn-block btn-info">Batal</a>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>