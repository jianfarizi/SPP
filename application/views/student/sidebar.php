<!-- Kolom sisi kiri. Berisi logo dan sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: gaya dapat ditemukan di sidebar.less -->
    <section class="sidebar">
        <!-- Panel pengguna di sidebar -->
        <div class="user-panel">
            <div class="pull-left image">
                <!-- Menampilkan gambar pengguna jika tersedia, jika tidak, menampilkan gambar default -->
                <?php if ($this->session->userdata('student_img') != null) { ?>
                <img src="<?php echo upload_url().'/student/'.$this->session->userdata('student_img'); ?>"
                    class="img-responsive">
                <?php } else { ?>
                <img src="<?php echo media_url() ?>img/user.png" class="img-responsive">
                <?php } ?>
            </div>
            <div class="pull-left info">
                <!-- Menampilkan nama lengkap pengguna -->
                <p><?php echo ucfirst($this->session->userdata('ufullname_student')); ?></p>
                <!-- Menampilkan status online -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Spasi tambahan di atas menu sidebar -->
        <div style="margin-top: 20px"></div>

        <!-- Menu sidebar: gaya dapat ditemukan di sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- Header menu -->
            <li class="header">MENU</li>

            <!-- Menu item untuk Dashboard -->
            <li
                class="<?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'active' : '' ?>">
                <a href="<?php echo site_url('student'); ?>">
                    <!-- Ikon untuk Dashboard -->
                    <i class="fa fa-th"></i> <span>Dashboard</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>