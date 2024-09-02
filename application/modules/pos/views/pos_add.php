<?php

// Mengecek apakah ada data POS yang dikirimkan
if (isset($pos)) {
    // Mengambil nilai dari data POS yang ada
    $inputNameValue = $pos['pos_name'];
    $inputDescValue = $pos['pos_description'];
} else {
    // Jika tidak ada data POS, ambil nilai default dari form input
    $inputNameValue = set_value('pos_name');
    $inputDescValue = set_value('pos_description');
}

?>
<div class="content-wrapper">
    <!-- Header Konten (Judul Halaman) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? '' . $title : null; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li><a href="<?php echo site_url('manage/pos') ?>">Tahun Pelajaran</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <!-- Konten Utama -->
    <section class="content">
        <!-- Form untuk menambahkan atau mengedit POS -->
        <?php echo form_open_multipart(current_url()); ?>
        <div class="row">
            <!-- Kolom untuk input data POS -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <!-- Menampilkan pesan validasi jika ada -->
                        <?php echo validation_errors(); ?>
                        <!-- Jika ada data POS, tambahkan field hidden untuk menyimpan ID POS -->
                        <?php if (isset($pos)) { ?>
                        <input type="hidden" name="pos_id" value="<?php echo $pos['pos_id']; ?>">
                        <?php } ?>

                        <!-- Field untuk Nama POS -->
                        <div class="form-group">
                            <label>Nama POS <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="pos_name" type="text" class="form-control"
                                value="<?php echo $inputNameValue ?>" placeholder="POS Bayar">
                        </div>

                        <!-- Field untuk Keterangan -->
                        <div class="form-group">
                            <label>Keterangan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="pos_description" type="text" class="form-control"
                                value="<?php echo $inputDescValue ?>" placeholder="Keterangan">
                        </div>

                        <p class="text-muted">*) Kolom wajib diisi.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

            <!-- Kolom untuk tombol aksi (Simpan, Batal, Hapus) -->
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body">
                        <!-- Tombol untuk menyimpan data -->
                        <button type="submit" class="btn btn-block btn-success">Simpan</button>
                        <!-- Tombol untuk membatalkan tindakan dan kembali ke halaman POS -->
                        <a href="<?php echo site_url('manage/pos'); ?>" class="btn btn-block btn-info">Batal</a>
                        <!-- Jika ada ID POS, tampilkan tombol Hapus -->
                        <?php if (isset($pos['pos_id'])) { ?>
                        <a href="#delModal<?php echo $pos['pos_id']; ?>" data-toggle="modal"
                            class="btn btn-block btn-danger">Hapus</a>
                        <?php } ?>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
        <!-- /.row -->
    </section>

    <!-- Modal Konfirmasi Hapus -->
    <?php if (isset($pos['pos_id'])) { ?>
    <div class="modal modal-default fade" id="delModal<?php echo $pos['pos_id']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi Penghapusan</h3>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <!-- Form untuk menghapus data POS -->
                    <?php echo form_open('manage/pos/delete/' . $pos['pos_id']); ?>
                    <input type="hidden" name="delName" value="<?php echo $pos['pos_name']; ?>">
                    <!-- Tombol untuk membatalkan penghapusan -->
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span
                            class="fa fa-close"></span> Batal</button>
                    <!-- Tombol untuk mengkonfirmasi penghapusan -->
                    <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <?php } ?>
</div>