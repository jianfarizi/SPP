<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_set extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Cek apakah pengguna sudah login
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        // Memuat model-model yang diperlukan
        $this->load->model(array('users/Users_model', 'holiday/Holiday_model'));
        $this->load->model(array('student/Student_model', 'kredit/Kredit_model', 'debit/Debit_model', 'bulan/Bulan_model', 'setting/Setting_model', 'information/Information_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model'));
        // Memuat library user_agent
        $this->load->library('user_agent');
    }

    public function index() {
        // Mendapatkan ID pengguna dari sesi
        $id = $this->session->userdata('uid'); 
        // Mendapatkan data pengguna dan statistik
        $data['user'] = count($this->Users_model->get());
        $data['student'] = count($this->Student_model->get(array('status'=>1)));
        $data['kredit'] = $this->Kredit_model->get(array('date'=> date('Y-m-d')));
        $data['information'] = $this->Information_model->get(array('information_publish'=>1));
        $data['debit'] = $this->Debit_model->get(array('date'=> date('Y-m-d')));
        $data['bulan_day'] = $this->Bulan_model->get_total(array('status'=>1, 'date'=> date('Y-m-d')));
        $data['bebas_day'] = $this->Bebas_pay_model->get(array('date'=> date('Y-m-d')));

        // Menghitung total kredit
        $data['total_kredit'] = 0;
        foreach ($data['kredit'] as $row) {
            $data['total_kredit'] += $row['kredit_value'];
        }

        // Menghitung total debit
        $data['total_debit'] = 0;
        foreach ($data['debit'] as $row) {
            $data['total_debit'] += $row['debit_value'];
        }

        // Menghitung total tagihan bulanan
        $data['total_bulan'] = 0;
        foreach ($data['bulan_day'] as $row) {
            $data['total_bulan'] += $row['bulan_bill'];
        }

        // Menghitung total tagihan bebas
        $data['total_bebas'] = 0;
        foreach ($data['bebas_day'] as $row) {
            $data['total_bebas'] += $row['bebas_pay_bill'];
        }

        // Memuat library form_validation untuk validasi form
        $this->load->library('form_validation');
        // Menangani form penambahan agenda
        if ($this->input->post('add', TRUE)) {
            $this->form_validation->set_rules('date', 'Tanggal', 'required');
            $this->form_validation->set_rules('info', 'Info', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            if ($_POST AND $this->form_validation->run() == TRUE) {
                // Memproses data tanggal
                list($tahun, $bulan, $tanggal) = explode('-', $this->input->post('date', TRUE));

                $params['year'] = $tahun;
                $params['date'] = $this->input->post('date');
                $params['info'] = $this->input->post('info');

                // Menambahkan agenda baru
                $ret = $this->Holiday_model->add($params);

                $this->session->set_flashdata('success', 'Tambah Agenda berhasil');
                redirect('manage');
            }
        }
        // Menangani form penghapusan agenda
        elseif ($this->input->post('del', TRUE)) {
            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            if ($_POST AND $this->form_validation->run() == TRUE) {
                $id = $this->input->post('id', TRUE);
                // Menghapus agenda berdasarkan ID
                $this->Holiday_model->delete($id);

                $this->session->set_flashdata('success', 'Hapus Agenda berhasil');
                redirect('manage');
            }
        }
        // Mendapatkan logo setting
        $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
        // Mendapatkan data hari libur
        $data['holiday'] = $this->Holiday_model->get();
        // Menetapkan judul halaman dan tampilan utama
        $data['title'] = 'Dashboard';
        $data['main'] = 'dashboard/dashboard';
        // Memuat tampilan layout dengan data
        $this->load->view('manage/layout', $data);
    }

    // Mendapatkan data acara untuk kalender
    public function get() {
        $events = $this->Holiday_model->get();
        foreach ($events as $i => $row) {
            $data[$i] = array(
                'id' => $row['id'],
                'title' => strip_tags($row['info']),
                'start' => $row['date'],
                'end' => $row['date'],
                'year' => $row['year'],
                    //'url' => event_url($row)
            );
        }
        // Mengembalikan data acara dalam format JSON
        echo json_encode($data, TRUE);
    }

}