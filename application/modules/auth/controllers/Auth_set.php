<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_set extends CI_Controller {

    // Konstruktor untuk memuat model, library, dan helper yang diperlukan
    public function __construct() {
        parent::__construct();
        $this->load->model('users/Users_model');
        $this->load->model('setting/Setting_model');
        $this->load->library('form_validation');
        $this->load->helper('string');
    }

    // Fungsi default yang akan dialihkan ke halaman login
    function index() {
        redirect('manage/auth/login');
    }

    // Fungsi untuk menampilkan halaman login dan menangani proses login
    function login() {
        // Jika pengguna sudah login, arahkan ke halaman manajemen
        if ($this->session->userdata('logged')) {
            redirect('manage');
        }
        
        // Mendapatkan nilai lokasi dari input post jika ada
        if ($this->input->post('location')) {
            $location = $this->input->post('location');
        } else {
            $location = NULL;
        }

        // Menetapkan aturan validasi form
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        // Memproses data login jika form valid
        if ($_POST AND $this->form_validation->run() == TRUE) {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            // Mengambil data pengguna dari database berdasarkan email dan password yang di-hash
            $user = $this->Users_model->get(array('email' => $email, 'password' => sha1($password)));

            // Jika data pengguna ditemukan
            if (count($user) > 0) {
                // Menyimpan data pengguna ke session
                $this->session->set_userdata('logged', TRUE);
                $this->session->set_userdata('uid', $user[0]['user_id']);
                $this->session->set_userdata('uemail', $user[0]['user_email']);
                $this->session->set_userdata('ufullname', $user[0]['user_full_name']);
                $this->session->set_userdata('uroleid', $user[0]['user_role_role_id']);
                $this->session->set_userdata('urolename', $user[0]['role_name']);
                $this->session->set_userdata('user_image', $user[0]['user_image']);

                // Arahkan ke lokasi yang diinginkan jika ada, atau ke halaman manajemen
                if ($location != '') {
                    header("Location:" . htmlspecialchars($location));
                } else {
                    redirect('manage');
                }
            } else {
                // Jika data pengguna tidak ditemukan, set flashdata error dan arahkan kembali ke halaman login
                if ($location != '') {
                    $this->session->set_flashdata('failed', 'Maaf, username dan password tidak cocok!');
                    header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($location));
                } else {
                    $this->session->set_flashdata('failed', 'Maaf, username dan password tidak cocok!');
                    redirect('manage/auth/login');
                }
            }
        } else {
            // Menyiapkan data pengaturan untuk ditampilkan di halaman login
            $data['setting_school'] = $this->Setting_model->get(array('id'=>1));
            $data['setting_logo'] = $this->Setting_model->get(array('id'=>SCHOOL_LOGO));
            // Memuat tampilan login
            $this->load->view('manage/login',$data);
        }
    }

    // Fungsi untuk memproses logout
    function logout() {
        // Menghapus semua data session pengguna
        $this->session->unset_userdata('logged');
        $this->session->unset_userdata('uid');
        $this->session->unset_userdata('uemail');
        $this->session->unset_userdata('ufullname');
        $this->session->unset_userdata('uroleid');
        $this->session->unset_userdata('urolename');
        $this->session->unset_userdata('user_image');

        // Mendapatkan nilai lokasi dari query parameter jika ada
        $q = $this->input->get(NULL, TRUE);
        if ($q['location'] != NULL) {
            $location = $q['location'];
        } else {
            $location = NULL;
        }
        // Arahkan ke lokasi yang diinginkan setelah logout
        header("Location:" . $location);
    }
}