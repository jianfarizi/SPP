<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_student extends CI_Controller {

  // Konstruktor kelas Profile_student
  public function __construct()
  {
    parent::__construct();
    // Cek apakah pengguna telah login sebagai siswa, jika tidak, arahkan ke halaman login
    if ($this->session->userdata('logged_student') == NULL) {
      header("Location:" . site_url('student/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    // Memuat model dan helper yang diperlukan
    $this->load->model(array('student/Student_model','logs/Logs_model'));
    $this->load->helper(array('form', 'url'));
  }

  // Menampilkan detail profil siswa
  public function index($offset = NULL) {
    $id = $this->session->userdata('uid_student');
    // Jika data siswa tidak ditemukan, arahkan ke halaman utama siswa
    if ($this->Student_model->get(array('id' => $id)) == NULL) {
      redirect('student');
    }
    // Ambil data siswa dan kirimkan ke view
    $data['student'] = $this->Student_model->get(array('id' => $id));
    $data['title'] = 'Detail Profil';
    $data['main'] = 'profile/profile_view_student';
    $this->load->view('student/layout', $data);
  }

  // Fungsi untuk mengedit profil siswa
  public function edit($id = NULL) {
    $data['operation'] = 'Edit Profil';

    // Jika ada data POST, lakukan proses update
    if ($_POST == TRUE) {

      $params['student_id'] = $this->input->post('student_id');
      $params['student_gender'] = $this->input->post('student_gender');
      $params['student_phone'] = $this->input->post('student_phone');
      $params['student_last_update'] = date('Y-m-d H:i:s');
      $params['student_born_place'] = $this->input->post('student_born_place'); 
      $params['student_born_date'] = $this->input->post('student_born_date'); 
      $params['student_address'] = $this->input->post('student_address'); 
      $params['student_name_of_mother'] = $this->input->post('student_name_of_mother'); 
      $params['student_name_of_father'] = $this->input->post('student_name_of_father'); 
      $params['student_parent_phone'] = $this->input->post('student_parent_phone'); 

      // Update data siswa
      $status = $this->Student_model->add($params);

      // Set pesan sukses dan arahkan kembali ke halaman profil
      $this->session->set_flashdata('success', $data['operation'] . ' Profil Siswa Berhasil');
      redirect('student/profile');
    } else {
      // Jika tidak ada data POST, tampilkan form edit
      if ($this->input->post('student_id')) {
        redirect('student/profile/edit/' . $this->input->post('student_id'));
      }

      // Mode edit, ambil data siswa dan tampilkan form edit
      $data['student'] = $this->Student_model->get(array('id' => $this->session->userdata('uid_student')));
      $data['title'] = $data['operation'] . ' Siswa';
      $data['main'] = 'profile/profile_edit_student';
      $this->load->view('student/layout', $data);
    }
  }

  // Fungsi untuk mengganti password siswa
  function cpw() {
    $this->load->model('Logs_model');
    $this->load->library('form_validation');
    // Set aturan validasi untuk form ganti password
    $this->form_validation->set_rules('student_password', 'Password', 'required|matches[passconf]|min_length[6]');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[6]');
    $this->form_validation->set_rules('student_current_password', 'Old Password', 'required|callback_check_current_password');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    if ($_POST AND $this->form_validation->run() == TRUE) {
      $old_password = $this->input->post('student_current_password');

      // Update password siswa
      $params['student_password'] = sha1($this->input->post('student_password'));
      $status = $this->Student_model->change_password($this->session->userdata('uid_student'), $params);

      // Set pesan sukses dan arahkan kembali ke halaman profil
      $this->session->set_flashdata('success', 'Ubah password Siswa berhasil');
      redirect('student/profile');
    } else {
      // Jika data siswa tidak ditemukan, arahkan ke halaman utama siswa
      if ($this->Student_model->get(array('id' => $this->session->userdata('uid_student'))) == NULL) {
        redirect('student');
      }
      // Tampilkan form ganti password
      $data['title'] = 'Ganti Password Siswa';
      $data['main'] = 'profile/change_pass_student';
      $this->load->view('student/layout', $data);
    }
  }

  // Callback untuk memeriksa kecocokan password lama
  function check_current_password() {
    $pass = $this->input->post('student_current_password');
    $student = $this->Student_model->get(array('id' => $this->session->userdata('uid_student')));
    // Cek apakah password lama sesuai dengan yang ada di database
    if (sha1($pass) == $student['student_password']) {
      return TRUE;
    } else {
      $this->form_validation->set_message('check_current_password', 'Password lama tidak sesuai');
      return FALSE;
    }
  }

}