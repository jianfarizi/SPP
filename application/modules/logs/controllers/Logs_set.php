<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Kelas Controllers Logs_set
 *
 * @package     Arca CMS
 * @subpackage  Controllers
 * @category    Controllers 
 * @author      Achyar Anshorie
 */
class Logs_set extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memeriksa apakah pengguna sudah login
        if ($this->session->userdata('logged') == NULL) {
            // Jika belum login, arahkan ke halaman login
            header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        // Memuat model Logs_model
        $this->load->model('logs/Logs_model');
    }

    /**
     * Menampilkan daftar log dengan paginasi
     *
     * @param int $offset Offset untuk paginasi
     */
    public function index($offset = NULL) {
        $this->load->library('pagination');
        
        $params = array();
        $paramsPage = $params;
        // Mengatur batas jumlah data yang ditampilkan per halaman
        $params['limit'] = 5;
        $params['offset'] = $offset;
        // Mengambil data log dari model
        $data['logs'] = $this->Logs_model->get($params);
        
        // Konfigurasi untuk paginasi
        $config['per_page'] = 5; // Jumlah item per halaman
        $config['uri_segment'] = 4; // Segment URL untuk offset
        $config['base_url'] = site_url('manage/logs/index'); // URL dasar
        $config['suffix'] = '?' . http_build_query($_GET, '', "&"); // Query string untuk paginasi
        $config['total_rows'] = count($this->Logs_model->get($paramsPage)); // Jumlah total baris data
        $this->pagination->initialize($config); // Inisialisasi paginasi

        // Menetapkan data yang akan dikirim ke tampilan
        $data['title'] = 'Log Aktivitas';
        $data['main'] = 'logs/log_list';
        // Memuat tampilan dengan layout yang sesuai
        $this->load->view('manage/layout', $data);
    }

}