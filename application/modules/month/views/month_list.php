<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? '' . $title : null; ?>
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- Box Header -->
                    <div class="box-header">
                        <!-- Tambahkan tombol atau fitur lain di sini jika diperlukan -->
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body table-responsive">
                        <!-- Tabel Daftar Bulan -->
                        <table class="table table-hover">
                            <tr>
                                <th>No</th> <!-- Kolom nomor urut -->
                                <th>Nama Bulan</th> <!-- Kolom nama bulan -->
                                <th>Aksi</th> <!-- Kolom aksi -->
                            </tr>
                            <tbody>
                                <?php
                                if (!empty($month)) {
                                    $i = 1;
                                    foreach ($month as $row):
                                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td> <!-- Nomor urut -->
                                    <td><?php echo $row['month_name']; ?></td> <!-- Nama bulan -->
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="<?php echo site_url('manage/month/edit/' . $row['month_id']) ?>"
                                            class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                        $i++;
                                    endforeach;
                                } else {
                                    ?>
                                <tr id="row">
                                    <td colspan="3" align="center">Data Kosong</td> <!-- Pesan jika tidak ada data -->
                                </tr>
                                <?php 
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div>
                    <!-- Pagination Links -->
                    <?php echo $this->pagination->create_links(); ?>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>