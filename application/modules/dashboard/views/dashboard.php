<div class="content-wrapper">
    <!-- Content Header (Bagian header konten) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content (Konten utama) -->
    <section class="content">
        <div class="row">
            <!-- Box untuk Penerimaan Hari Ini -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text dash-text">Penerimaan Hari Ini</span>
                        <span
                            class="info-box-number"><?php echo 'Rp. ' . number_format($total_bulan+$total_bebas+$total_debit, 0, ',', '.') ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- Box untuk Pengeluaran Hari Ini -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text dash-text">Pengeluaran Hari Ini</span>
                        <span
                            class="info-box-number"><?php echo 'Rp. ' . number_format($total_kredit, 0, ',', '.') ?></span>
                        <a href="<?= base_url('manage/kredit') ?>">
                            <p>Terdaftar di Sistem</p>
                        </a>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix untuk perangkat kecil -->
            <div class="clearfix visible-sm-block"></div>

            <!-- Box untuk Total Penerimaan -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-dollar"></i></span>

                    <div class="info-box-content">
                        <?php
            $totalAll = $total_bulan+$total_bebas+$total_debit;
            ?>
                        <span class="info-box-text dash-text">Total Penerimaan</span>
                        <span
                            class="info-box-number"><?php echo 'Rp. ' . number_format($totalAll - $total_kredit,0, ',', '.') ?></span>
                        <a href="<?= base_url('manage/debit') ?>">
                            <p>Terdaftar di Sistem</p>
                        </a>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- Box untuk Siswa Aktif -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text dash-text">Siswa Aktif</span>
                        <span class="info-box-number"><?php echo $student ?></span>
                        <a href="<?= base_url('manage/student') ?>">
                            <p>Terdaftar di Sistem</p>
                        </a>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>

        <div class="row">
            <!-- Box untuk Kalender -->
            <div class="col-md-7">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Kalender</h3>
                        <div class="box-tools pull-right">
                            <!-- Tombol untuk menutup atau menghapus box -->
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <!-- Kalender -->
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->

    </section>
    <!-- /.content -->
</div>

<!-- Modal untuk menambah agenda -->
<div class="modal fade in" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php echo form_open(current_url()); ?>
        <div class="modal-content">
            <div class="modal-header">
                <!-- Tombol untuk menutup modal -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addModalLabel">Tambah Agenda</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="add" value="1">
                <label>Tanggal*</label>
                <p id="labelDate"></p>
                <input type="hidden" name="date" class="form-control" id="inputDate">
                <label>Keterangan*</label>
                <textarea name="info" id="inputDesc" class="form-control"></textarea><br />
            </div>
            <div class="modal-footer">
                <!-- Tombol untuk menyimpan agenda -->
                <button type="submit" id="btnSimpan" class="btn btn-success">Simpan</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<!-- Modal untuk menghapus hari libur -->
<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php echo form_open(current_url()); ?>
        <div class="modal-content">
            <div class="modal-header">
                <!-- Tombol untuk menutup modal -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="delModalLabel">Hapus Hari Libur</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del" value="1">
                <input type="hidden" name="id" id="idDel">
                <label>Tahun</label>
                <p id="showYear"></p>
                <label>Tanggal</label>
                <p id="showDate"></p>
                <label>Keterangan*</label>
                <p id="showDesc"></p>
            </div>
            <div class="modal-footer">
                <!-- Tombol untuk menghapus data -->
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
// Inisialisasi kalender dengan fullCalendar
$('#calendar').fullCalendar({
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'prevYear,nextYear',
    },

    // URL untuk mengambil data event
    events: "<?php echo site_url('manage/dashboard/get');?>",

    // Fungsi saat hari diklik
    dayClick: function(date, jsEvent, view) {
        var tanggal = date.getDate();
        var bulan = date.getMonth() + 1;
        var tahun = date.getFullYear();
        var fullDate = tahun + '-' + bulan + '-' + tanggal;

        $('#addModal').modal('toggle');
        $('#addModal').modal('show');

        $("#inputDate").val(fullDate);
        $("#labelDate").text(fullDate);
        $("#inputYear").val(date.getFullYear());
        $("#labelYear").text(date.getFullYear());
    },

    // Fungsi saat event diklik
    eventClick: function(calEvent, jsEvent, view) {
        $("#delModal").modal('toggle');
        $("#delModal").modal('show');
        $("#idDel").val(calEvent.id);
        $("#showYear").text(calEvent.year);

        var tgl = calEvent.start.getDate();
        var bln = calEvent.start.getMonth() + 1;
        var thn = calEvent.start.getFullYear();

        $("#showDate").text(tgl + '-' + bln + '-' + thn);
        $("#showDesc").text(calEvent.title);
    }
});

// Validasi input deskripsi pada modal tambah agenda
$("#inputDesc").on('change keyup focus input propertychange', function() {
    var desc = $("#inputDesc").val();
    if (desc.trim().length > 0) {
        $("#btnSimpan").removeClass('disabled');
    } else {
        $("#btnSimpan").addClass('disabled');
    }
});

// Fungsi untuk mengatur ulang modal setelah ditutup
$("#closeModal").click(function() {
    $("#inputDesc").val('');
    $("#btnSimpan").addClass('disabled');
});
</script>