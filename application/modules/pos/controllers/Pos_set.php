<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pos_set extends CI_Controller {

    // Konstruktor controller
    public function __construct() {
        parent::__construct(TRUE);
        
        // Cek apakah user sudah login, jika tidak redirect ke halaman login
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

        // Load model dan library yang diperlukan
        $this->load->model(array('pos/Pos_model', 'payment/Payment_model', 'logs/Logs_model'));
        $this->load->library('upload');
    }

    /**
     * Menampilkan daftar POS dengan opsi filter dan pagination
     * 
     * @param int $offset Offset untuk pagination
     */
    public function index($offset = NULL) {
        $this->load->library('pagination');
        
        // Ambil parameter filter dari URL
        $f = $this->input->get(NULL, TRUE);
        $data['f'] = $f;

        // Siapkan parameter untuk query
        $params = array();
        if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
            $params['pos_name'] = $f['n'];
        }

        // Set parameter untuk pagination
        $paramsPage = $params;
        $params['limit'] = 10;
        $params['offset'] = $offset;
        $data['pos'] = $this->Pos_model->get($params);

        // Konfigurasi pagination
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['base_url'] = site_url('manage/pos/index');
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['total_rows'] = count($this->Pos_model->get($paramsPage));
        $this->pagination->initialize($config);

        // Set judul halaman dan load view
        $data['title'] = 'Pos Bayar';
        $data['main'] = 'pos/pos_list';
        $this->load->view('manage/layout', $data);
    }

    /**
     * Menambahkan data POS baru secara massal
     */
    public function add_glob() {
        if ($_POST == TRUE) {
            $posName = $_POST['pos_name'];
            $posKet = $_POST['pos_description'];
            $cpt = count($_POST['pos_name']);
            for ($i = 0; $i < $cpt; $i++) {
                $params['pos_name'] = $posName[$i];
                $params['pos_description'] = $posKet[$i];
                $this->Pos_model->add($params);
            }
        }
        $this->session->set_flashdata('success',' Tambah POS Berhasil');
        redirect('manage/pos');
    }

    /**
     * Menambahkan atau memperbarui data POS
     * 
     * @param int $id ID POS yang akan diperbarui (opsional)
     */
    public function add($id = NULL) {
        $this->load->library('form_validation');
        
        // Set aturan validasi form
        $this->form_validation->set_rules('pos_name', 'Pos Bayar', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {
            // Ambil data dari form
            if ($this->input->post('pos_id')) {
                $params['pos_id'] = $this->input->post('pos_id');
            }
            $params['pos_name'] = $this->input->post('pos_name');
            $params['pos_description'] = $this->input->post('pos_description');

            // Tambah atau update data POS
            $status = $this->Pos_model->add($params);
            $paramsupdate['pos_id'] = $status;
            $this->Pos_model->add($paramsupdate);

            // Simpan log aktivitas
            $this->Logs_model->add(array(
                'log_date' => date('Y-m-d H:i:s'),
                'user_id' => $this->session->userdata('user_id'),
                'log_module' => 'Pos Bayar',
                'log_action' => $data['operation'],
                'log_info' => 'ID:null;Title:' . $params['pos_name']
            ));

            $this->session->set_flashdata('success', $data['operation'] . ' Pos Bayar berhasil');
            redirect('manage/pos');
        } else {
            // Jika mode edit, ambil data POS yang akan diperbarui
            if ($this->input->post('pos_id')) {
                redirect('manage/pos/edit/' . $this->input->post('pos_id'));
            }

            if (!is_null($id)) {
                $data['pos'] = $this->Pos_model->get(array('id' => $id));
            }
            $data['title'] = $data['operation'] . ' Pos Bayar';
            $data['main'] = 'pos/pos_add';
            $this->load->view('manage/layout', $data);
        }
    }

    /**
     * Menghapus data POS
     * 
     * @param int $id ID POS yang akan dihapus
     */
    public function delete($id = NULL) {
        if ($this->session->userdata('uroleid') != SUPERUSER) {
            redirect('manage');
        }

        if ($_POST) {
            // Cek apakah POS yang ingin dihapus sudah digunakan dalam payment
            $payment = $this->Payment_model->get(array('pos_id' => $id));
            if (count($payment) > 0) {
                $this->session->set_flashdata('failed', 'Data POS tidak dapat dihapus');
                redirect('manage/pos');
            }

            // Hapus data POS
            $this->Pos_model->delete($id);

            // Simpan log aktivitas
            $this->Logs_model->add(array(
                'log_date' => date('Y-m-d H:i:s'),
                'user_id' => $this->session->userdata('uid'),
                'log_module' => 'Pos Bayar',
                'log_action' => 'Hapus',
                'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
            ));
            $this->session->set_flashdata('success', 'Hapus Pos Bayar berhasil');
            redirect('manage/pos');
        } elseif (!$_POST) {
            // Jika tidak ada POST, set flashdata untuk konfirmasi penghapusan
            $this->session->set_flashdata('delete', 'Delete');
            redirect('manage/pos/edit/' . $id);
        }
    }
}