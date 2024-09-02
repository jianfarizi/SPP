<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_set extends CI_Controller {

  // Konstruktor kelas
  public function __construct()
  {
    parent::__construct();
    // Cek jika pengguna belum login, arahkan ke halaman login
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    // Cek hak akses pengguna
    $list_access = array(SUPERUSER);
    if (!in_array($this->session->userdata('uroleid'),$list_access)) {
      redirect('manage');
    }

    // Muat model dan helper yang diperlukan
    $this->load->model(array('student/Student_model', 'setting/Setting_model'));
    $this->load->helper(array('form', 'url'));
  }

  // Menampilkan daftar kelas
  public function index($offset = NULL) {
    $this->load->library('pagination');

    // Ambil variabel dari URL (filter)
    $f = $this->input->get(NULL, TRUE);
    $data['f'] = $f;

    $params = array();

    // Filter berdasarkan nama kelas
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['class_name'] = $f['n'];
    }

    $paramsPage = $params;
    $params['limit'] = 10;
    $params['offset'] = $offset;
    $data['classes'] = $this->Student_model->get_class($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    
    // Konfigurasi pagination
    $config['per_page'] = 10;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/class/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Student_model->get_class($paramsPage));
    $this->pagination->initialize($config);

    $data['title'] = 'Kelas';
    $data['main'] = 'class/class_list';
    $this->load->view('manage/layout', $data);
  }

  // Menambahkan beberapa kelas
  public function add_glob(){
    if ($_POST == TRUE) {
      $className = $_POST['class_name'];
      $cpt = count($_POST['class_name']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['class_name'] = $className[$i];
        $this->Student_model->add_class($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Kelas Berhasil');
    redirect('manage/class');
  }

  // Menambah atau memperbarui data kelas
  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('class_name', 'Nama Kelas', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      // Jika ada ID kelas, tambahkan ke parameter
      if ($this->input->post('class_id')) {
        $params['class_id'] = $this->input->post('class_id');
      }
      $params['class_name'] = $this->input->post('class_name');
      $status = $this->Student_model->add_class($params);

      $this->session->set_flashdata('success', $data['operation'] . ' Keterangan Kelas');
      redirect('manage/class');

      if ($this->input->post('from_angular')) {
        echo $status;
      }
    } else {
      // Jika mode edit dan ID ada, ambil data kelas berdasarkan ID
      if ($this->input->post('class_id')) {
        redirect('manage/class/edit/' . $this->input->post('class_id'));
      }

      if (!is_null($id)) {
        $object = $this->Student_model->get_class(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/class');
        } else {
          $data['class'] = $object;
        }
      }
      $data['title'] = $data['operation'] . ' Keterangan Kelas';
      $data['main'] = 'class/class_add';
      $this->load->view('manage/layout', $data);
    }
  }

  // Menghapus data kelas
  public function delete($id = NULL) {
    // Cek hak akses pengguna
    if ($this->session->userdata('uroleid') != SUPERUSER){
      redirect('manage');
    }
    $siswa = $this->Student_model->get(array('class_id' => $id));

    if ($_POST) {
      // Cek jika ada siswa yang terdaftar di kelas, jika ada, tidak bisa dihapus
      if (count($siswa) > 0) {
        $this->session->set_flashdata('failed', 'Data Kelas tidak dapat dihapus');
        redirect('manage/class');
      }

      $this->Student_model->delete_class($id);

      // Catat aktivitas penghapusan
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'user',
          'log_action' => 'Hapus',
          'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
      );
      $this->session->set_flashdata('success', 'Hapus Kelas berhasil');
      redirect('manage/class');
    } elseif (!$_POST) {
      // Jika tidak ada POST, redirect ke halaman edit
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/class/edit/' . $id);
    }  
  }
}