<div class="content-wrapper">
    <!-- Header Konten (Judul Halaman) -->
    <section class="content-header">
        <h1>
            <!-- Menampilkan Judul Halaman Dinamis -->
            <?php echo isset($title) ? '' . $title : null; ?>
            <small></small>
        </h1>
        <!-- Breadcrumb Navigasi -->
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <!-- Konten Utama -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- Kotak Konten Utama -->
                <div class="box">
                    <div class="box-header">
                        <!-- Tombol untuk Menambah Pengguna Baru -->
                        <a href="<?php echo site_url('manage/users/add') ?>" class="btn btn-sm btn-success"><i
                                class="fa fa-plus"></i> Tambah</a>

                        <!-- Formulir Pencarian -->
                        <div class="box-tools">
                            <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <!-- Input Pencarian -->
                                <input type="text" id="field" autofocus name="n"
                                    <?php echo (isset($f['n'])) ? 'placeholder="'.$f['n'].'"' : 'placeholder="Email atau Nama"' ?>
                                    class="form-control" required>
                                <div class="input-group-btn">
                                    <!-- Tombol Pencarian -->
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- Tabel Daftar Pengguna -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Nama</th>
                                <th>Hak Akses</th>
                                <th>Aksi</th>
                            </tr>
                            <tbody>
                                <?php
                                if (!empty($user)) {
                                    $i = 1;
                                    foreach ($user as $row):
                                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['user_email']; ?></td>
                                    <td><?php echo $row['user_full_name']; ?></td>
                                    <td><?php echo $row['role_name']; ?></td>
                                    <td>
                                        <!-- Tombol Lihat Profil Pengguna -->
                                        <a href="<?php echo site_url('manage/users/view/' . $row['user_id']) ?>"
                                            class="btn btn-xs btn-info" data-toggle="tooltip" title="Lihat"><i
                                                class="fa fa-eye"></i></a>

                                        <!-- Tombol Reset Password (Tidak untuk Pengguna Saat Ini) -->
                                        <?php if ($this->session->userdata('uid') != $row['user_id']) { ?>
                                        <a href="<?php echo site_url('manage/users/rpw/' . $row['user_id']) ?>"
                                            class="btn btn-xs btn-warning"><i class="fa fa-lock" data-toggle="tooltip"
                                                title="Reset Password"></i></a>
                                        <?php } else { ?>
                                        <!-- Tombol Ubah Password (Untuk Pengguna Saat Ini) -->
                                        <a href="<?php echo site_url('manage/profile/cpw/'); ?>"
                                            class="btn btn-xs btn-warning"><i class="fa fa-rotate-left"
                                                data-toggle="tooltip" title="Ubah Password"></i></a>
                                        <?php } ?>

                                        <!-- Tombol Hapus (Tidak untuk Pengguna Saat Ini) -->
                                        <?php if ($row['user_id'] != $this->session->userdata('uid')) { ?>
                                        <a href="#delModal<?php echo $row['user_id']; ?>" data-toggle="modal"
                                            class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip"
                                                title="Hapus"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <!-- Modal Konfirmasi Penghapusan -->
                                <div class="modal modal-default fade" id="delModal<?php echo $row['user_id']; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <!-- Tombol Tutup Modal -->
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <!-- Judul Modal -->
                                                <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi
                                                    penghapusan</h3>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah anda yakin akan menghapus data ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <!-- Formulir Konfirmasi Penghapusan -->
                                                <?php echo form_open('manage/users/delete/' . $row['user_id']); ?>
                                                <input type="hidden" name="delName"
                                                    value="<?php echo $row['user_full_name']; ?>">
                                                <!-- Tombol Batal -->
                                                <button type="button" class="btn btn-default pull-left"
                                                    data-dismiss="modal"><span class="fa fa-close"></span>
                                                    Batal</button>
                                                <!-- Tombol Hapus -->
                                                <button type="submit" class="btn btn-danger"><span
                                                        class="fa fa-check"></span> Hapus</button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                                <?php
                                        $i++;
                                    endforeach;
                                } else {
                                    ?>
                                <tr id="row">
                                    <!-- Tabel Kosong -->
                                    <td colspan="6" align="center">Data Kosong</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- Tautan untuk Halaman Pagination -->
                <div>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>