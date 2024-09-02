<?php

// Jika data program keahlian sudah ada (edit mode)
if (isset($majors)) {

    $inputMajorsValue = $majors['majors_name']; // Nilai nama program keahlian
    $inputShortValue = $majors['majors_short_name']; // Nilai singkatan program keahlian
    
} else {
    
    // Jika data program keahlian belum ada (tambah mode)
    $inputMajorsValue = set_value('majors_name'); // Ambil nilai yang diinputkan jika ada error
    $inputShortValue = set_value('majors_short_name'); // Ambil nilai yang diinputkan jika ada error
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
            <li><a href="<?php echo site_url('manage/majors') ?>">Kelas</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Form untuk menambah atau mengedit program keahlian -->
        <?php echo form_open_multipart(current_url()); ?>

        <div class="row">
            <!-- Kolom untuk form input -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Menampilkan pesan kesalahan validasi -->
                        <?php echo validation_errors(); ?>

                        <?php if (isset($majors)) { ?>
                        <!-- Menyimpan ID program keahlian untuk mode edit -->
                        <input type="hidden" name="majors_id" value="<?php echo $majors['majors_id']; ?>">
                        <?php } ?>

                        <!-- Input untuk Nama Program Keahlian -->
                        <div class="form-group">
                            <label>Nama Program Keahlian <small data-toggle="tooltip"
                                    title="Wajib diisi">*</small></label>
                            <input name="majors_name" type="text" class="form-control"
                                value="<?php echo $inputMajorsValue ?>" placeholder="Isi Nama Program Keahlian">
                        </div>

                        <!-- Input untuk Singkatan Program Keahlian -->
                        <div class="form-group">
                            <label>Singkatan Program Keahlian <small data-toggle="tooltip"
                                    title="Wajib diisi">*</small></label>
                            <input name="majors_short_name" type="text" class="form-control"
                                value="<?php echo $inputShortValue ?>" placeholder="Isi Singkatan Program Keahlian">
                        </div>

                        <!-- Keterangan kolom wajib diisi -->
                        <p class="text-muted">*) Kolom wajib diisi.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

            <!-- Kolom untuk tombol simpan dan batal -->
            <div class="col-md-3">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Tombol untuk menyimpan data -->
                        <button type="submit" class="btn btn-block btn-success">Simpan</button>
                        <!-- Tombol untuk membatalkan dan kembali ke daftar program keahlian -->
                        <a href="<?php echo site_url('manage/majors'); ?>" class="btn btn-block btn-info">Batal</a>
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