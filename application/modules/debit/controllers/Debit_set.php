<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debit_set extends CI_Controller {

    // Konstruktor untuk controller
    public function __construct() {
        parent::__construct(TRUE);
        // Memeriksa apakah pengguna sudah login, jika tidak, arahkan ke halaman login
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        // Memuat model dan library yang diperlukan
        $this->load->model(array('debit/Debit_model', 'logs/Logs_model'));
        $this->load->library('upload');
    }

    // Menampilkan daftar debit
    public function index($offset = NULL) {
        $this->load->library('pagination');

        // Mengambil parameter filter dari URL
        $f = $this->input->get(NULL, TRUE);
        $data['f'] = $f;

        $params = array();

        // Menambahkan filter berdasarkan deskripsi debit jika ada
        if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
            $params['debit_desc'] = $f['n'];
        }

        // Mengatur parameter untuk pagination
        $paramsPage = $params;
        $params['limit'] = 5;
        $params['offset'] = $offset;
        $data['debit'] = $this->Debit_model->get($params);

        // Konfigurasi pagination
        $config['per_page'] = 5;
        $config['uri_segment'] = 4;
        $config['base_url'] = site_url('manage/debit/index');
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['total_rows'] = count($this->Debit_model->get($paramsPage));
        $this->pagination->initialize($config);

        $data['title'] = 'Jurnal Umum Penerimaan';
        $data['main'] = 'debit/debit_list';
        $this->load->view('manage/layout', $data);
    }

    // Menambahkan data debit secara global
    public function add_glob() {
        if ($_POST == TRUE) {
            // Menghapus titik pada nilai debit dan menyiapkan data untuk ditambahkan
            $krValue = str_replace('.', '', $_POST['debit_value']);
            $krDesc = $_POST['debit_desc'];
            $cpt = count($_POST['debit_value']);
            for ($i = 0; $i < $cpt; $i++) {
                $params['debit_date'] = $this->input->post('debit_date');
                $params['debit_value'] = $krValue[$i];
                $params['debit_desc'] = $krDesc[$i];
                $params['debit_input_date'] = date('Y-m-d H:i:s');
                $params['debit_last_update'] = date('Y-m-d H:i:s');
                $params['user_user_id'] = $this->session->userdata('uid');

                // Menambahkan data debit ke database
                $this->Debit_model->add($params);
            }
        }
        $this->session->set_flashdata('success',' Tambah Penerimaan Berhasil');
        redirect('manage/debit');
    }

    // Menambahkan atau memperbarui data debit
    public function add($id = NULL) {
        $this->load->library('form_validation');
        // Menetapkan aturan validasi untuk form
        $this->form_validation->set_rules('debit_date', 'Tanggal', 'trim|required|xss_clean');
        $this->form_validation->set_rules('debit_value', 'Nilai', 'trim|required|xss_clean');
        $this->form_validation->set_rules('debit_desc', 'Keterangan', 'trim|required|xss_clean');
        
        // Menetapkan delimiter error untuk validasi
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        // Memeriksa apakah form telah disubmit dan validasi berhasil
        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('debit_id')) {
                $params['debit_id'] = $this->input->post('debit_id');
            } else {
                $params['debit_input_date'] = date('Y-m-d H:i:s');
            }

            $params['debit_date'] = $this->input->post('debit_date');
            $params['debit_value'] = $this->input->post('debit_value');
            $params['debit_desc'] = $this->input->post('debit_desc');
            $params['debit_last_update'] = date('Y-m-d H:i:s');
            $params['user_user_id'] = $this->session->userdata('uid');

            // Menambahkan atau memperbarui data debit
            $status = $this->Debit_model->add($params);
            $paramsupdate['debit_id'] = $status;
            $this->Debit_model->add($paramsupdate);

            // Menambahkan log aktivitas
            $this->Logs_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id'),
                    'log_module' => 'Penerimaan',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:null;Title:' . $params['debit_desc']
                )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' Penerimaan berhasil');
            redirect('manage/debit');
        } else {
            if ($this->input->post('debit_id')) {
                redirect('manage/debit/edit/' . $this->input->post('debit_id'));
            }

            // Jika dalam mode edit, ambil data debit berdasarkan ID
            if (!is_null($id)) {
                $data['debit'] = $this->Debit_model->get(array('id' => $id));
            }
            $data['title'] = $data['operation'] . ' Jurnal Penerimaan';
            $data['main'] = 'debit/debit_add';
            $this->load->view('manage/layout', $data);
        }
    }

    // Menghapus data debit dari database
    public function delete($id = NULL) {
        if ($_POST) {
            // Menghapus data debit dan menambahkan log aktivitas
            $this->Debit_model->delete($id);
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('uid'),
                    'log_module' => 'Jurnal Penerimaan',
                    'log_action' => 'Hapus',
                    'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
                )
            );
            $this->session->set_flashdata('success', 'Hapus Jurnal Penerimaan berhasil');
            redirect('manage/debit');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('manage/debit/edit/' . $id);
        }
    }

}

/* End of file Jurnal_set.php */
/* Location: ./application/modules/jurnal/controllers/Jurnal_set.php */