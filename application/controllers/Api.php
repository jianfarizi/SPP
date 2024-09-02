<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model dan library jika diperlukan
    }

    // Method default untuk API ini
    public function index() {
        $res = array('message' => 'Nothing here'); // Pesan default jika tidak ada endpoint yang dipanggil

        $this->output
                ->set_content_type('application/json') // Set header content-type sebagai JSON
                ->set_output(json_encode($res)); // Encode data sebagai JSON dan output
    }

    // Mendapatkan data kelas
    public function get_class() {
        $this->load->model('student/Student_model'); // Muat model Student_model
        $res = $this->Student_model->get_class(); // Ambil data kelas dari model

        $this->output
                ->set_content_type('application/json') // Set header content-type sebagai JSON
                ->set_output(json_encode($res)); // Encode data sebagai JSON dan output
    }

    // Mendapatkan data kelas dengan parameter group
    public function get_class2() {
        $this->load->model('student/Student_model'); // Muat model Student_model
        $res = $this->Student_model->get(array('group' => true)); // Ambil data kelas dengan parameter group dari model

        $this->output
                ->set_content_type('application/json') // Set header content-type sebagai JSON
                ->set_output(json_encode($res)); // Encode data sebagai JSON dan output
    }

    // Mendapatkan siswa berdasarkan ID kelas
    public function get_student_by_class($id = NULL) {
        if ($id != NULL) {
            $this->load->model('student/Student_model'); // Muat model Student_model
            $res = $this->Student_model->get(array('status' => 1, 'class_id' => $id)); // Ambil data siswa dengan status aktif dan ID kelas

            $this->output
                    ->set_content_type('application/json') // Set header content-type sebagai JSON
                    ->set_output(json_encode($res)); // Encode data sebagai JSON dan output
        } else {
            redirect('api'); // Redirect ke endpoint default jika ID tidak ada
        }
    }

    // Mendapatkan data siswa berdasarkan ID siswa
    public function get_student_by_id($student_id = NULL) {
        if ($student_id != NULL) {
            $this->load->model('student/Student_model'); // Muat model Student_model
            $res = $this->Student_model->get(array('id' => $student_id)); // Ambil data siswa berdasarkan ID

            $this->output
                    ->set_content_type('application/json') // Set header content-type sebagai JSON
                    ->set_output(json_encode($res)); // Encode data sebagai JSON dan output
        } else {
            redirect('api'); // Redirect ke endpoint default jika ID siswa tidak ada
        }
    }

    // Mendapatkan data payout bulan berdasarkan ID pembayaran dan ID siswa
    public function get_payout_bulan($payment_id = NULL, $student_id = NULL) {
        if ($payment_id != NULL) {
            $this->load->model('bulan/Bulan_model'); // Muat model Bulan_model
            $res = $this->Bulan_model->get(array('payment_id' => $payment_id, 'student_id' => $student_id)); // Ambil data payout bulan berdasarkan ID pembayaran dan ID siswa

            $this->output
                    ->set_content_type('application/json') // Set header content-type sebagai JSON
                    ->set_output(json_encode($res)); // Encode data sebagai JSON dan output
        } else {
            redirect('api'); // Redirect ke endpoint default jika ID pembayaran tidak ada
        }
    }
}