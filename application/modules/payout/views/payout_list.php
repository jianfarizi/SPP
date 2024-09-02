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
            <div class="col-md-12">
                <!-- Kotak Formulir Filter -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filter Data Pembayaran Siswa</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Tahun Pelajaran</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="n">
                                    <?php foreach ($period as $row): ?>
                                    <option
                                        <?php echo (isset($f['n']) AND $f['n'] == $row['period_id']) ? 'selected' : '' ?>
                                        value="<?php echo $row['period_id'] ?>">
                                        <?php echo $row['period_start'].'/'.$row['period_end'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="" class="col-sm-2 control-label">NIS Siswa</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" autofocus name="r"
                                        <?php echo (isset($f['r'])) ? 'placeholder="'.$f['r'].'"' : 'placeholder="Masukan NIS Siswa"' ?>
                                        required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="submit">Cari</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <!-- Informasi Siswa jika filter diterapkan -->
                <?php if ($f) { ?>

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informasi Siswa</h3>
                        <?php if ($f['n'] AND $f['r'] != NULL) { ?>
                        <a href="<?php echo site_url('manage/payout/printBill' . '/?' . http_build_query($f)) ?>"
                            target="_blank" class="btn btn-danger btn-xs pull-right">Cetak Semua Tagihan</a>
                        <?php } ?>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-9">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td width="200">Tahun Ajaran</td>
                                        <td width="4">:</td>
                                        <?php foreach ($period as $row): ?>
                                        <?php echo (isset($f['n']) AND $f['n'] == $row['period_id']) ? 
											'<td><strong>'.$row['period_start'].'/'.$row['period_start'].'<strong></td>' : '' ?>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <td>NIS</td>
                                        <td>:</td>
                                        <?php foreach ($siswa as $row): ?>
                                        <?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
											'<td>'.$row['student_nis'].'</td>' : '' ?>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <td>Nama Siswa</td>
                                        <td>:</td>
                                        <?php foreach ($siswa as $row): ?>
                                        <?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
											'<td>'.$row['student_full_name'].'</td>' : '' ?>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <td>Nama Ibu Kandung</td>
                                        <td>:</td>
                                        <?php foreach ($siswa as $row): ?>
                                        <?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ?  
											'<td>'.$row['student_name_of_mother'].'</td>' : '' ?>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td>:</td>
                                        <?php foreach ($siswa as $row): ?>
                                        <?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
											'<td>'.$row['class_name'].'</td>' : '' ?>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php if (majors() == 'senior') { ?>
                                    <tr>
                                        <td>Program Keahlian</td>
                                        <td>:</td>
                                        <?php foreach ($siswa as $row): ?>
                                        <?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
												'<td>'.$row['majors_name'].'</td>' : '' ?>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <?php foreach ($siswa as $row): ?>
                            <?php if (isset($f['n']) AND $f['r'] == $row['student_nis']) { ?>
                            <?php if (!empty($row['student_img'])) { ?>
                            <img src="<?php echo upload_url('student/'.$row['student_img']) ?>"
                                class="img-thumbnail img-responsive">
                            <?php } else { ?>
                            <img src="<?php echo media_url('img/user.png') ?>" class="img-thumbnail img-responsive">
                            <?php } 
								} ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Transaksi Terakhir -->
                    <div class="col-md-5">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Transaksi Terakhir</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table class="table table-responsive table-bordered" style="white-space: nowrap;">
                                    <tr class="info">
                                        <th>Pembayaran</th>
                                        <th>Tagihan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                    <?php 
									foreach ($log as $key) :
									?>
                                    <tr>
                                        <td><?php echo ($key['bulan_bulan_id']!= NULL) ? $key['posmonth_name'].' - T.A '.$key['period_start_month'].'/'.$key['period_end_month'].' ('.$key['month_name'].')' : $key['posbebas_name'].' - T.A '.$key['period_start_bebas'].'/'.$key['period_end_bebas'] ?>
                                        </td>
                                        <td><?php echo ($key['bulan_bulan_id']!= NULL) ? 'Rp. '. number_format($key['bulan_bill'], 0, ',', '.') : 'Rp. '. number_format($key['bebas_pay_bill'], 0, ',', '.') ?>
                                        </td>
                                        <td><?php echo pretty_date($key['log_trx_input_date'],'d F Y',false)  ?></td>
                                    </tr>
                                    <?php endforeach ?>

                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Formulir Pembayaran -->
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Pembayaran</h3>
                            </div>
                            <div class="box-body">
                                <form id="calcu" name="calcu" method="post" action="">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Total</label>
                                                <input type="text" class="form-control numeric"
                                                    value="<?php echo $cash+$cashb ?>" name="harga" id="harga"
                                                    placeholder="Total Pembayaran" onfocus="startCalculate()"
                                                    onblur="stopCalc()">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bayar</label>
                                                <input type="text" class="form-control numeric" id="cash" name="cash"
                                                    placeholder="Jumlah Bayar" onfocus="startCalculate()"
                                                    onblur="stopCalc()">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kembalian</label>
                                                <input type="text" class="form-control" id="kembali" name="kembali"
                                                    placeholder="Kembalian" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <textarea name="desc" class="form-control"
                                                    placeholder="Keterangan Pembayaran"></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" id="student_nis" name="student_nis"
                                            value="<?php echo $f['r']; ?>">
                                        <input type="hidden" id="period_id" name="period_id"
                                            value="<?php echo $f['n']; ?>">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-success pull-right"
                                                onclick="return confirm('Apakah Anda yakin?')">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>

                    <!-- Riwayat Pembayaran -->
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Riwayat Pembayaran</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table class="table table-responsive table-bordered" style="white-space: nowrap;">
                                    <tr class="info">
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Jumlah Bayar</th>
                                    </tr>
                                    <?php
									$sum = 0;
									foreach ($history as $key) :
									?>
                                    <tr>
                                        <td><?php echo pretty_date($key['cash_trans_date'],'d F Y',false)  ?></td>
                                        <td><?php echo $key['cash_desc'] ?></td>
                                        <td>Rp. <?php echo number_format($key['cash'], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php
									$sum += $key['cash'];
									endforeach;
									?>
                                    <tr>
                                        <td colspan="2"><strong>Total</strong></td>
                                        <td><strong>Rp. <?php echo number_format($sum, 0, ',', '.') ?></strong></td>
                                    </tr>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                </div>
                <?php } ?>
            </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script>
// Menghitung kembalian pembayaran
function startCalculate() {
    timer = setInterval("calculate()", 10);
}

function stopCalc() {
    clearInterval(timer);
}

function calculate() {
    var harga = document.getElementById('harga').value;
    var cash = document.getElementById('cash').value;
    var kembali = document.getElementById('kembali');

    if (harga && cash) {
        kembali.value = parseFloat(cash) - parseFloat(harga);
    }
}
</script>