<!-- Kolom sisi kiri. Berisi logo dan sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: gaya dapat ditemukan di sidebar.less -->
    <section class="sidebar">

        <!-- Panel pengguna di sidebar -->
        <div class="user-panel">
            <div class="pull-left image">
                <!-- Menampilkan gambar pengguna jika tersedia, jika tidak, tampilkan gambar default -->
                <?php if ($this->session->userdata('user_image') != null) { ?>
                <img src="<?php echo upload_url().'/users/'.$this->session->userdata('user_image'); ?>"
                    class="img-responsive">
                <?php } else { ?>
                <img src="<?php echo media_url() ?>img/avatar1.png" class="img-responsive">
                <?php } ?>
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst($this->session->userdata('ufullname')); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Jarak vertikal -->
        <div style="margin-top: 20px"></div>

        <!-- Menu sidebar: gaya dapat ditemukan di sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU</li>

            <!-- Menu Dashboard -->
            <li
                class="<?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'active' : '' ?>">
                <a href="<?php echo site_url('manage'); ?>">
                    <i class="fa fa-th"></i> <span>Dashboard</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

            <!-- Transaksi Pembayaran Siswa -->
            <li class="<?php echo ($this->uri->segment(2) == 'payout') ? 'active' : '' ?>">
                <a href="<?php echo site_url('manage/payout'); ?>">
                    <i class="fa fa-credit-card"></i> <span>Transaksi Pembayaran</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

            <!-- Kirim Tagihan -->
            <li class="<?php echo ($this->uri->segment(2) == 'tagihan') ? 'active' : '' ?>">
                <a href="<?php echo site_url('manage/tagihan'); ?>">
                    <i class="fa fa-whatsapp"></i> <span>Kirim Tagihan</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

            <!-- Menu Siswa, hanya terlihat untuk peran USER -->
            <?php if ($this->session->userdata('uroleid') == USER) { ?>
            <li class="<?php echo ($this->uri->segment(2) == 'student') ? 'active' : '' ?>">
                <a href="<?php echo site_url('manage/student'); ?>">
                    <i class="fa fa-users"></i> <span>Siswa</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <?php } ?>

            <!-- Data Keuangan, hanya terlihat untuk peran SUPERUSER -->
            <?php if ($this->session->userdata('uroleid') == SUPERUSER) { ?>
            <li
                class="<?php echo ($this->uri->segment(2) == 'pos' OR $this->uri->segment(2) == 'payment') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-money text-stock"></i> <span>Data Keuangan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'pos') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/pos') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'pos') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Pos Keuangan</a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(2) == 'payment') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/payment') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'payment') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Jenis Pembayaran</a>
                    </li>
                </ul>
            </li>

            <!-- Master Data, hanya terlihat untuk peran SUPERUSER -->
            <li
                class="<?php echo ($this->uri->segment(2) == 'student' OR $this->uri->segment(2) == 'class' OR $this->uri->segment(2) == 'majors' OR $this->uri->segment(2) == 'period') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-users text-stock"></i> <span>Master Data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'period') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/period') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'period') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Tahun Pelajaran</a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(2) == 'class') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/class') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'class') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Kelas</a>
                    </li>
                    <?php if (majors() == 'senior') { ?>
                    <li class="<?php echo ($this->uri->segment(2) == 'majors') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/majors') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'majors') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Program Keahlian</a>
                    </li>
                    <?php } ?>
                    <li
                        class="<?php echo ($this->uri->segment(2) == 'student' AND $this->uri->segment(3) != 'pass' AND $this->uri->segment(3) != 'upgrade') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/student') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'student' AND $this->uri->segment(3) != 'pass' AND $this->uri->segment(3) != 'upgrade') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Siswa</a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(3) == 'pass') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/student/pass') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(3) == 'pass') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Kelulusan</a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(3) == 'upgrade') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/student/upgrade') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(3) == 'upgrade') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Kenaikan Kelas</a>
                    </li>
                </ul>
            </li>

            <!-- Jurnal Umum -->
            <li
                class="<?php echo ($this->uri->segment(2) == 'kredit' OR $this->uri->segment(2) == 'debit') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-edit text-stock"></i> <span>Pemasukan/Pengeluaran</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'kredit') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/kredit') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'kredit') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Pengeluaran</a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(2) == 'debit') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/debit') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'debit') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Pemasukan</a>
                    </li>
                </ul>
            </li>

            <!-- Laporan -->
            <li
                class="<?php echo ($this->uri->segment(2) == 'report' OR $this->uri->segment(3) == 'report_bill') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-file-text-o text-stock"></i> <span>Data Laporan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li
                        class="<?php echo ($this->uri->segment(2) == 'report' AND $this->uri->segment(3) != 'report_bill') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/report') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'report' AND $this->uri->segment(3) != 'report_bill') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Laporan Keuangan</a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(3) == 'report_bill') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/report/report_bill') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(3) == 'report_bill') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Rekapitulasi</a>
                    </li>
                </ul>
            </li>

            <!-- Informasi -->
            <li class="<?php echo ($this->uri->segment(2) == 'information') ? 'active' : '' ?>">
                <a href="<?php echo site_url('manage/information'); ?>">
                    <i class="fa fa-bullhorn"></i> <span>Data Informasi</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

            <!-- Pengaturan Aplikasi -->
            <li
                class="<?php echo ($this->uri->segment(2) == 'setting' OR $this->uri->segment(2) == 'month') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-gear text-stock"></i> <span>Setting Aplikasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'setting') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/setting') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'setting') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Sekolah</a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(2) == 'month') ? 'active' : '' ?>">
                        <a href="<?php echo site_url('manage/month') ?>"><i
                                class="fa  <?php echo ($this->uri->segment(2) == 'month') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i>
                            Bulan</a>
                    </li>
                </ul>
            </li>

            <!-- Master Pengguna -->
            <li class="<?php echo ($this->uri->segment(2) == 'users') ? 'active' : '' ?>">
                <a href="<?php echo site_url('manage/users'); ?>">
                    <i class="fa fa-user"></i> <span>Master Pengguna</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

            <!-- Pemeliharaan Data -->
            <li class="<?php echo ($this->uri->segment(2) == 'maintenance') ? 'active' : '' ?>">
                <a href="<?php echo site_url('manage/maintenance'); ?>">
                    <i class="fa fa-database"></i> <span>Pemeliharaan Data</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <?php } ?>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>