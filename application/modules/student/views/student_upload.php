<div class="content-wrapper">
    <!-- Content Header (Bagian Header Konten) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? '' . $title : null; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <!-- Main content (Konten Utama) -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header (Header Kotak) -->
                    <div class="box-body table-responsive">
                        <!-- Petunjuk Singkat -->
                        <h4>Petunjuk Singkat</h4>
                        <p>
                            Penginputan data Siswa bisa dilakukan dengan mengcopy data dari file Ms. Excel. Format file
                            excel harus sesuai kebutuhan aplikasi. Silahkan download formatnya
                            <a href="<?php echo site_url('manage/student/download');?>">
                                <span class="label label-success">Disini</span>
                            </a>
                            <br><br>
                            <strong>CATATAN :</strong>
                        <ol>
                            <li>Pengisian jenis data <strong>TANGGAL</strong> diisi dengan format
                                <strong>YYYY-MM-DD</strong> Contoh <strong>2017-12-21</strong><br>
                                Cara ubah : blok semua tanggal pilih format cell di excel ganti dengan format date pilih
                                yang tahunnya di depan
                            </li>
                        </ol>
                        </p>
                        <hr>

                        <!-- Form untuk Mengimpor Data -->
                        <?php echo form_open_multipart(current_url()) ?>

                        <div class="form-group">
                            <!-- Textarea untuk menempelkan data dari Excel -->
                            <textarea placeholder="Copy data yang akan dimasukan dari file excel, dan paste disini"
                                rows="8" class="form-control" name="rows"></textarea>
                        </div>
                        <div class="form-group">
                            <!-- Tombol untuk mengirimkan form -->
                            <button type="submit" class="btn btn-success btn-sm btn-flat">Import</button>
                            <!-- Tombol untuk kembali ke halaman sebelumnya -->
                            <a href="<?php echo site_url('manage/student') ?>"
                                class="btn btn-info btn-sm btn-flat">Kembali</a>
                        </div>
                        <?php echo form_close() ?>

                    </div>
                    <!-- /.box-body (Isi Kotak) -->
                </div>
                <!-- /.box (Kotak) -->
            </div>
        </div>
    </section>
    <!-- /.content (Konten) -->
</div>