<?php

if (isset($month)) {
    // Jika ada data bulan, ambil nama bulan dari data
    $inputMonthValue = $month['month_name'];
} else {
    // Jika tidak ada data bulan, gunakan nilai default
    $inputMonthValue = set_value('month_name');
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
            <li><a href="<?php echo site_url('manage/month') ?>">Bulan</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php echo form_open_multipart(current_url()); ?>
        <!-- Formulir untuk menambah/memperbarui bulan -->
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <!-- Box header -->
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Tampilkan pesan kesalahan validasi jika ada -->
                        <?php echo validation_errors(); ?>

                        <!-- Jika ada data bulan, tambahkan input tersembunyi untuk ID bulan -->
                        <?php if (isset($month)) { ?>
                        <input type="hidden" name="month_id" value="<?php echo $month['month_id']; ?>">
                        <?php } ?>

                        <div class="form-group">
                            <!-- Input untuk nama bulan -->
                            <label>Nama Bulan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="month_name" type="text" class="form-control"
                                value="<?php echo $inputMonthValue ?>" placeholder="Isi Nama Bulan">
                        </div>

                        <p class="text-muted">*) Kolom wajib diisi.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <!-- Box header -->
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Tombol Simpan untuk mengirim data -->
                        <button type="submit" class="btn btn-block btn-success">Simpan</button>
                        <!-- Tombol Batal untuk kembali ke daftar bulan -->
                        <a href="<?php echo site_url('manage/month'); ?>" class="btn btn-block btn-info">Batal</a>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
        <!-- /.row -->
    </section>
</div>