<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Controller untuk pengaturan bulan
class Month_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    // Cek apakah pengguna sudah login
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    // Daftar akses yang diperbolehkan
    $list_access = array(SUPERUSER);
    // Cek apakah user memiliki akses yang sesuai
    if (!in_array($this->session->userdata('uroleid'), $list_access)) {
      redirect('manage');
    }

    // Load model dan helper yang diperlukan
    $this->load->model('bulan/Bulan_model');
    $this->load->helper(array('form', 'url'));
  }

  // Menampilkan daftar bulan
  public function index($offset = NULL) {
    $this->load->library('pagination');
    
    // Mengambil filter dari URL
    $f = $this->input->get(NULL, TRUE);
    $data['f'] = $f;

    $params = array();
    
    // Filter berdasarkan nama bulan
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['class_name'] = $f['n'];
    }

    // Set parameter untuk pagination
    $paramsPage = $params;
    $params['limit'] = 12;
    $params['offset'] = $offset;
    $data['month'] = $this->Bulan_model->get_month($params);

    // Konfigurasi pagination
    $config['per_page'] = 12;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/month/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Bulan_model->get_month($paramsPage));
    $this->pagination->initialize($config);

    // Set data untuk tampilan
    $data['title'] = 'Bulan';
    $data['main'] = 'month/month_list';
    $this->load->view('manage/layout', $data);
  }

  // Menambah atau memperbarui data bulan
  public function add($id = NULL) {
    $this->load->library('form_validation');
    
    // Set aturan validasi form
    $this->form_validation->set_rules('month_name', 'Name', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button ket="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    
    // Menentukan operasi berdasarkan ada tidaknya ID
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    // Jika form disubmit dan validasi berhasil
    if ($_POST AND $this->form_validation->run() == TRUE) {

        // Ambil ID bulan jika ada
        if ($this->input->post('month_id')) {
            $params['month_id'] = $this->input->post('month_id');
        }
        // Ambil nama bulan dari form
        $params['month_name'] = $this->input->post('month_name');
        
        // Tambahkan atau perbarui data bulan
        $status = $this->Bulan_model->add_month($params);

        // Set pesan sukses dan redirect
        $this->session->set_flashdata('success', $data['operation'] . ' Bulan');
        redirect('manage/month');

        // Jika dari Angular, tampilkan status
        if ($this->input->post('from_angular')) {
            echo $status;
        }
    } else {
        // Jika ID bulan ada, redirect ke edit
        if ($this->input->post('month_id')) {
            redirect('manage/month/edit/' . $this->input->post('month_id'));
        }

        // Jika dalam mode edit
        if (!is_null($id)) {
            $object = $this->Bulan_model->get_month(array('id' => $id));
            if ($object == NULL) {
                redirect('manage/month');
            } else {
                $data['month'] = $object;
            }
        }
        // Set data untuk tampilan
        $data['title'] = $data['operation'] . ' Bulan';
        $data['main'] = 'month/month_add';
        $this->load->view('manage/layout', $data);
    }
  }
}