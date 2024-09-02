<?php

// Memeriksa apakah variabel $debit ada
if (isset($debit)) {

	// Mengatur nilai input berdasarkan data debit yang ada
	$inputDateValue = $debit['debit_date'];
	$inputValue = $debit['debit_value'];
	$inputDescValue = $debit['debit_desc'];
	
} else {
	// Mengatur nilai input dengan nilai default dari form
	$inputDateValue = set_value('debit_date');
	$inputValue = set_value('debit_value');
	$inputDescValue = set_value('debit_desc');
	
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
            <li><a href="<?php echo site_url('manage/debit') ?>">Jurnal Penerimaan</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <!-- Konten Utama -->
    <section class="content">
        <!-- Form untuk mengirim data dengan method multipart -->
        <?php echo form_open_multipart(current_url()); ?>
        <!-- Kotak informasi kecil (Stat box) -->
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <!-- Header kotak informasi -->
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Menampilkan pesan kesalahan validasi -->
                        <?php echo validation_errors(); ?>
                        <?php if (isset($debit)) { ?>
                        <!-- Input hidden untuk ID debit jika ada -->
                        <input type="hidden" name="debit_id" value="<?php echo $debit['debit_id']; ?>">
                        <?php } ?>

                        <div class="form-group">
                            <label>Tanggal </label>
                            <div class="input-group date" data-date="" data-date-format="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <!-- Input tanggal debit, hanya baca (readonly) -->
                                <input class="form-control" type="text" name="debit_date" readonly="readonly"
                                    placeholder="Tanggal Penerimaan" value="<?php echo $inputDateValue; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan *</label>
                            <!-- Input teks untuk keterangan debit -->
                            <input type="text" class="form-control" name="debit_desc"
                                value="<?php echo $inputDescValue ?>" placeholder="Keterangan Penerimaan">
                        </div>

                        <div class="form-group">
                            <label>Jumlah Rupiah *</label>
                            <!-- Input teks untuk jumlah rupiah dengan format numeric -->
                            <input type="text" class="form-control numeric" name="debit_value"
                                value="<?php echo $inputValue ?>" placeholder="Jumlah">
                        </div>

                        <!-- Petunjuk bahwa kolom dengan tanda bintang (*) wajib diisi -->
                        <p class="text-muted">*) Kolom wajib diisi.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <!-- Header kotak informasi -->
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Tombol simpan untuk mengirim form -->
                        <button type="submit" class="btn btn-block btn-success">Simpan</button>
                        <!-- Tombol batal untuk kembali ke halaman sebelumnya -->
                        <a href="<?php echo site_url('manage/debit'); ?>" class="btn btn-block btn-info">Batal</a>
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