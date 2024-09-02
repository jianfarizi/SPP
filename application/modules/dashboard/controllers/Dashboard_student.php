<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_student extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Cek apakah siswa sudah login
        if ($this->session->userdata('logged_student') == NULL) {
            header("Location:" . site_url('student/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        // Memuat model-model yang diperlukan
        $this->load->model(array('student/Student_model', 'bulan/Bulan_model', 'setting/Setting_model','bebas/Bebas_model', 'information/Information_model', 'bebas/Bebas_pay_model'));
    }

    public function index() {
        // Mendapatkan ID siswa dari sesi
        $id = $this->session->userdata('uid'); 

        // Mendapatkan informasi yang diterbitkan
        $data['information'] = $this->Information_model->get(array('information_publish'=>1));
        
        // Mendapatkan tagihan bulanan untuk siswa yang sedang login
        $data['bulan'] = $this->Bulan_model->get(array('status'=>0, 'period_status'=>1, 'student_id'=> $this->session->userdata('uid_student')));
        
        // Mendapatkan tagihan bebas untuk siswa yang sedang login
        $data['bebas'] = $this->Bebas_model->get(array('period_status'=>1, 'student_id'=> $this->session->userdata('uid_student')));

        // Menghitung total tagihan bulanan
        $data['total_bulan'] =0;
        foreach ($data['bulan'] as $row) {
            $data['total_bulan'] += $row['bulan_bill'];
        }

        // Menghitung total tagihan bebas
        $data['total_bebas'] =0;
        foreach ($data['bebas'] as $row) {
            $data['total_bebas'] += $row['bebas_bill'];
        }

        // Menghitung total pembayaran tagihan bebas
        $data['total_bebas_pay'] =0;
        foreach ($data['bebas'] as $row) {
            $data['total_bebas_pay'] += $row['bebas_total_pay'];
        }

        // Menetapkan judul halaman dan tampilan utama
        $data['title'] = 'Dashboard';
        $data['main'] = 'dashboard/dashboard_student';
        // Memuat tampilan layout dengan data
        $this->load->view('student/layout', $data);
    }

}