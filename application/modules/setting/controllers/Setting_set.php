<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); // Mencegah akses langsung ke file ini

class Setting_set extends CI_Controller {

    // Konstruktor untuk inisialisasi controller
    public function __construct()
    {
        parent::__construct();
        // Cek apakah pengguna sudah login, jika belum, arahkan ke halaman login
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
    }

    // Fungsi utama untuk menampilkan dan memproses pengaturan
    public function index() {
        $this->load->model('setting/Setting_model'); // Memuat model pengaturan
        $this->load->library('form_validation'); // Memuat library validasi form

        // Aturan validasi untuk form pengaturan
        $this->form_validation->set_rules('setting_school', 'Nama Sekolah', 'trim|required|xss_clean');
        $this->form_validation->set_rules('setting_address', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('setting_phone', 'Nomor Telephone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('setting_district', 'Nama Kecamatan', 'trim|required|xss_clean');
        $this->form_validation->set_rules('setting_city', 'Nama Kota/Kab', 'trim|required|xss_clean');
        $this->form_validation->set_rules('setting_level', 'Tingkat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('setting_user_sms', 'User SMS Gateway', 'trim|required|xss_clean');
        $this->form_validation->set_rules('setting_pass_sms', 'Pass SMS Gateway', 'trim|required|xss_clean');

        // Jika form di-submit dan validasi berhasil
        if ($_POST AND $this->form_validation->run() == TRUE) {

            // Ambil data dari input form
            $param['setting_school'] = $this->input->post('setting_school');
            $param['setting_address'] = $this->input->post('setting_address');
            $param['setting_phone'] = $this->input->post('setting_phone');
            $param['setting_district'] = $this->input->post('setting_district');
            $param['setting_city'] = $this->input->post('setting_city');
            $param['setting_level'] = $this->input->post('setting_level');
            $param['setting_user_sms'] = $this->input->post('setting_user_sms');
            $param['setting_pass_sms'] = $this->input->post('setting_pass_sms');
            $param['setting_sms'] = $this->input->post('setting_sms');

            // Simpan data pengaturan ke database
            $status = $this->Setting_model->save($param);

            // Jika ada file logo yang di-upload
            if (!empty($_FILES['setting_logo']['name'])) {
                // Upload file logo dan simpan nama file
                $paramsupdate['setting_logo'] = $this->do_upload($name = 'setting_logo', $fileName = $param['setting_school']);

                // Update pengaturan dengan logo yang baru di-upload
                $paramsupdate['setting_id'] = $status;
                $this->Setting_model->save($paramsupdate);
            }

            // Set pesan sukses dan redirect ke halaman pengaturan
            $this->session->set_flashdata('success', 'Sunting pengaturan berhasil');
            redirect('manage/setting');
        } else {
            // Jika tidak ada data POST atau validasi gagal, ambil data pengaturan dari database
            $data['title'] = 'Pengaturan';
            $data['setting_school'] = $this->Setting_model->get(array('id' => 1));
            $data['setting_address'] = $this->Setting_model->get(array('id' => 2));
            $data['setting_phone'] = $this->Setting_model->get(array('id' => 3));
            $data['setting_district'] = $this->Setting_model->get(array('id' => 4));
            $data['setting_city'] = $this->Setting_model->get(array('id' => 5));
            $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
            $data['setting_level'] = $this->Setting_model->get(array('id' => 7));
            $data['setting_user_sms'] = $this->Setting_model->get(array('id' => 8));
            $data['setting_pass_sms'] = $this->Setting_model->get(array('id' => 9));
            $data['setting_sms'] = $this->Setting_model->get(array('id' => 10));
            
            // Tampilkan halaman pengaturan
            $data['main'] = 'setting/setting_list';
            $this->load->view('manage/layout', $data);
        }
    }

    // Fungsi untuk meng-upload file
    function do_upload($name = NULL, $fileName = NULL) {
        $this->load->library('upload'); // Memuat library upload

        // Konfigurasi upload
        $config['upload_path'] = FCPATH . 'uploads/school/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE); // Buat direktori jika tidak ada
        }
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '1024'; // Maksimal ukuran file dalam KB
        $config['file_name'] = $fileName;
        $this->upload->initialize($config);

        // Jika gagal upload, set pesan error dan redirect
        if (!$this->upload->do_upload($name)) {
            $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
            redirect(uri_string());
        }

        // Ambil data upload dan kembalikan nama file
        $upload_data = $this->upload->data();
        return $upload_data['file_name'];
    }

}

/* End of file Setting_set.php */
/* Location: ./application/controllers/Setting_set.php */