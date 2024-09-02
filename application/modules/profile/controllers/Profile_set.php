<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_set extends CI_Controller {
    
  // Konstruktor kelas Profile_set
  public function __construct()
  {
    parent::__construct();
    // Cek apakah pengguna sudah login, jika tidak, arahkan ke halaman login
    if ($this->session->userdata('logged') == NULL) {
        header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    // Memuat model dan helper yang diperlukan
    $this->load->model(array('users/Users_model', 'logs/Logs_model'));
    $this->load->helper(array('form', 'url'));
  }
    
  // Menampilkan detail profil pengguna
  public function index($offset = NULL) {
    $id = $this->session->userdata('uid');
    // Jika data pengguna tidak ditemukan, arahkan ke halaman daftar pengguna
    if ($this->Users_model->get(array('id' => $id)) == NULL) {
        redirect('manage/users');
    }
    // Ambil data pengguna dan kirimkan ke view
    $data['user'] = $this->Users_model->get(array('id' => $id));
    $data['title'] = 'Detail Profil';
    $data['main'] = 'profile/profile_view';
    $this->load->view('manage/layout', $data);
  }
     
  // Fungsi untuk menambah atau mengedit pengguna
  public function edit($id = NULL) {
    $data['operation'] = 'Edit';

    // Jika ada data POST, lakukan proses update
    if ($_POST == TRUE) {

      $params['user_id'] = $this->input->post('user_id');
      $params['user_role_role_id'] = $this->input->post('role_id');
      $params['user_last_update'] = date('Y-m-d H:i:s');
      $params['user_full_name'] = $this->input->post('user_full_name');
      $params['user_description'] = $this->input->post('user_description');
      $status = $this->Users_model->add($params);

      // Jika ada file gambar yang diunggah, proses upload gambar
      if (!empty($_FILES['user_image']['name'])) {
        $paramsupdate['user_image'] = $this->do_upload($name = 'user_image', $fileName = $params['user_full_name']);
      }

      $paramsupdate['user_id'] = $status;
      $this->Users_model->add($paramsupdate);

      // Catat aktivitas log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Profile',
          'log_action' => $data['operation'],
          'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('user_full_name')
      ));

      // Set pesan sukses dan arahkan kembali ke halaman profil
      $this->session->set_flashdata('success', $data['operation'] . ' Pengguna Berhasil');
      redirect('manage/profile');
    } else {
      // Jika tidak ada data POST, tampilkan form edit
      if ($this->input->post('user_id')) {
        redirect('manage/profile/edit/' . $this->input->post('user_id'));
      }

      // Mode edit, ambil data pengguna dan tampilkan form edit
      $data['user'] = $this->Users_model->get(array('id' => $this->session->userdata('uid')));
      $data['roles'] = $this->Users_model->get_role();
      $data['title'] = $data['operation'] . ' Pengguna';
      $data['main'] = 'profile/profile_edit';
      $this->load->view('manage/layout', $data);
    }
  }

  // Fungsi untuk mengunggah file
  function do_upload($name = NULL, $fileName = NULL) {
    $this->load->library('upload');

    $config['upload_path'] = FCPATH . 'uploads/users/';

    // Buat direktori jika belum ada
    if (!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }

    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['max_size'] = '32000';
    $config['file_name'] = $fileName;
    $this->upload->initialize($config);

    // Jika proses upload gagal, tampilkan pesan error dan redirect
    if (!$this->upload->do_upload($name)) {
      $this->session->set_flashdata('failed', $this->upload->display_errors('', ''));
      redirect(uri_string());
    }

    $upload_data = $this->upload->data();

    return $upload_data['file_name'];
  }

  // Fungsi untuk mengganti password pengguna
  function cpw() {
    $this->load->model('Logs_model');
    $this->load->library('form_validation');
    // Set aturan validasi untuk form ganti password
    $this->form_validation->set_rules('user_password', 'Password', 'required|matches[passconf]|min_length[6]');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[6]');
    $this->form_validation->set_rules('user_current_password', 'Old Password', 'required|callback_check_current_password');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    if ($_POST AND $this->form_validation->run() == TRUE) {
      // Update password pengguna
      $old_password = $this->input->post('user_current_password');
      $params['user_password'] = sha1($this->input->post('user_password'));
      $status = $this->Users_model->change_password($this->session->userdata('uid'), $params);

      // Catat aktivitas log
      $this->Logs_model->add(array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Pengguna',
          'log_action' => 'Ganti Password',
          'log_info' => 'ID:null;Title:' . $this->input->post('user_name')
      ));
      $this->session->set_flashdata('success', 'Ubah password Pengguna berhasil');
      redirect('manage/profile');
    } else {
      // Jika data pengguna tidak ditemukan, arahkan ke halaman utama
      if ($this->Users_model->get(array('id' => $this->session->userdata('uid'))) == NULL) {
        redirect('manage');
      }
      // Tampilkan form ganti password
      $data['title'] = 'Ganti Password Pengguna';
      $data['main'] = 'profile/change_pass';
      $this->load->view('manage/layout', $data);
    }
  }

  // Callback untuk memeriksa kecocokan password lama
  function check_current_password() {
    $pass = $this->input->post('user_current_password');
    $user = $this->Users_model->get(array('id' => $this->session->userdata('uid')));
    // Cek apakah password lama sesuai dengan yang ada di database
    if (sha1($pass) == $user['user_password']) {
      return TRUE;
    } else {
      $this->form_validation->set_message('check_current_password', 'Password lama tidak sesuai');
      return FALSE;
    }
  }
    
}