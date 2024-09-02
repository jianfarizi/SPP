<div class="content-wrapper">
    <!-- Header Konten (Judul Halaman) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? '' . $title : null; ?>
            <small></small>
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
                <div class="box">
                    <div class="box-header">
                        <!-- Header Kotak -->
                        <!-- Jika ada form yang dibuka sebelumnya, tutup form di sini -->
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <!-- Tabel Daftar Tagihan -->
                        <table class="table table-hover">
                            <tr>
                                <th>POS</th>
                                <th>Nama Pembayaran</th>
                                <th>Tipe</th>
                                <th>Tahun Pelajaran</th>
                                <th>Aksi</th>
                            </tr>
                            <tbody>
                                <?php
                                // Cek apakah data tagihan tidak kosong
                                if (!empty($tagihan)) {
                                    // Loop melalui setiap item tagihan
                                    foreach ($tagihan as $row):
                                ?>
                                <tr>
                                    <td><?php echo $row['pos_name']; ?></td>
                                    <td><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end']; ?>
                                    </td>
                                    <td><?php echo ($row['payment_type'] == 'BULAN') ? 'Bulanan' : 'Bebas' ?></td>
                                    <td><?php echo $row['period_start'].'/'.$row['period_end']; ?></td>
                                    <td>
                                        <!-- Tindakan berdasarkan tipe pembayaran -->
                                        <?php if ($row['payment_type'] == 'BULAN') { ?>
                                        <!-- Tombol untuk mengirim notifikasi WhatsApp untuk tipe Bulanan -->
                                        <a data-toggle="tooltip" data-placement="top" title="Kirim Notifikasi"
                                            class="btn btn-primary btn-xs"
                                            href="https://wa.me/6281916647677?text=Assalamu’alaikum Wr.Wb%20Dengan%20hormat,%20Pemberitahuan%20Pembayaran%20SPP">
                                            Kirim Notif WhatsApp
                                        </a>
                                        <?php } else { ?>
                                        <!-- Tombol untuk mengirim notifikasi WhatsApp untuk tipe Bebas -->
                                        <a data-toggle="tooltip" data-placement="top" title="Kirim Notifikasi"
                                            class="btn btn-primary btn-xs"
                                            href="https://wa.me/6281916647677?text=Assalamu’alaikum Wr.Wb%20Dengan%20hormat,%20Pemberitahuan%20Pembayaran%20Uang%20Gedung">
                                            Kirim Notif WhatsApp
                                        </a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php
                                    endforeach;
                                } else {
                                ?>
                                <tr id="row">
                                    <td colspan="6" align="center">Data Kosong</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>

                <!-- Pagination -->
                <div>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>