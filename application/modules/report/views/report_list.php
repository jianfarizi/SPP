<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? '' . $title : null; ?>
            <!-- Menampilkan judul halaman -->
            <small>List</small> <!-- Keterangan tambahan pada judul -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <!-- Tautan kembali ke halaman utama -->
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
            <!-- Menampilkan judul halaman aktif -->
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header">
                        <?php echo form_open(current_url(), array('method' => 'get')) ?>
                        <!-- Form untuk filter data -->
                        <br>
                        <div class="row">
                            <!-- Kolom untuk memilih tanggal awal -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
                                        <span class="input-group-addon"><i
                                                class="glyphicon glyphicon-calendar"></i></span>
                                        <input class="form-control" type="text" name="ds" readonly="readonly"
                                            <?php echo (isset($q['ds'])) ? 'value="'.$q['ds'].'"' : '' ?>
                                            placeholder="Tanggal Awal"> <!-- Input tanggal awal -->
                                    </div>
                                </div>
                            </div>
                            <!-- Kolom untuk memilih tanggal akhir -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
                                        <span class="input-group-addon"><i
                                                class="glyphicon glyphicon-calendar"></i></span>
                                        <input class="form-control" type="text" name="de" readonly="readonly"
                                            <?php echo (isset($q['de'])) ? 'value="'.$q['de'].'"' : '' ?>
                                            placeholder="Tanggal Akhir"> <!-- Input tanggal akhir -->

                                    </div>
                                </div>
                            </div>
                            <!-- Tombol untuk submit filter -->
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <!-- Tombol untuk ekspor ke Excel jika ada filter aktif -->
                            <?php if ($q) { ?>
                            <a class="btn btn-success"
                                href="<?php echo site_url('manage/report/report' . '/?' . http_build_query($q)) ?>"><i
                                    class="fa fa-file-excel-o"></i> Export Excel</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>