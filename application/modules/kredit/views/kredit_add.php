<?php

// Memeriksa apakah ada data kredit yang diterima
if (isset($kredit)) {
    // Mengatur nilai input berdasarkan data yang diterima
    $inputDateValue = $kredit['kredit_date'];
    $inputValue = $kredit['kredit_value'];
    $inputDescValue = $kredit['kredit_desc'];
} else {
    // Mengatur nilai input berdasarkan data yang diset oleh form validation
    $inputDateValue = set_value('kredit_date');
    $inputValue = set_value('kredit_value');
    $inputDescValue = set_value('kredit_desc');
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? '' . $title : null; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li><a href="<?php echo site_url('manage/kredit') ?>">Jurnal Pengeluaran</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Membuka form untuk mengirim data -->
        <?php echo form_open_multipart(current_url()); ?>

        <!-- Row untuk menampilkan form -->
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Menampilkan pesan error jika ada -->
                        <?php echo validation_errors(); ?>

                        <!-- Menyimpan ID kredit jika ada untuk keperluan update -->
                        <?php if (isset($kredit)) { ?>
                        <input type="hidden" name="kredit_id" value="<?php echo $kredit['kredit_id']; ?>">
                        <?php } ?>

                        <!-- Form untuk input tanggal -->
                        <div class="form-group">
                            <label>Tanggal</label>
                            <div class="input-group date" data-date="" data-date-format="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input class="form-control" type="text" name="kredit_date" readonly="readonly"
                                    placeholder="Tanggal Pengeluaran" value="<?php echo $inputDateValue; ?>">
                            </div>
                        </div>

                        <!-- Form untuk input keterangan -->
                        <div class="form-group">
                            <label>Keterangan *</label>
                            <input type="text" class="form-control" name="kredit_desc"
                                value="<?php echo $inputDescValue ?>" placeholder="Keterangan Pengeluaran">
                        </div>

                        <!-- Form untuk input jumlah rupiah -->
                        <div class="form-group">
                            <label>Jumlah Rupiah *</label>
                            <input type="text" class="form-control numeric" name="kredit_value"
                                value="<?php echo $inputValue ?>" placeholder="Jumlah">
                        </div>

                        <!-- Keterangan bahwa kolom ini wajib diisi -->
                        <p class="text-muted">*) Kolom wajib diisi.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

            <div class="col-md-3">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Tombol simpan -->
                        <button type="submit" class="btn btn-block btn-success">Simpan</button>
                        <!-- Tombol batal, mengarahkan kembali ke halaman daftar kredit -->
                        <a href="<?php echo site_url('manage/kredit'); ?>" class="btn btn-block btn-info">Batal</a>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <!-- Menutup form -->
        <?php echo form_close(); ?>
        <!-- /.row -->
    </section>
</div>