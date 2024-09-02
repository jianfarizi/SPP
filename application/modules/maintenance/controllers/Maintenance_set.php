<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Maintenance_set
 *
 * Controller ini menangani fungsi-fungsi terkait pemeliharaan sistem seperti backup database.
 * 
 * @package     Arca CMS
 * @subpackage  Controllers
 * @category    Controllers
 */
class Maintenance_set extends CI_Controller {

	public function __construct() {
		parent::__construct(TRUE);
        // Mengecek apakah pengguna sudah login
		if ($this->session->userdata('logged') == NULL) {
			// Jika belum login, arahkan ke halaman login
			header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
		}
        // Memuat model Setting_model
		$this->load->model(array('setting/Setting_model'));
	}

    /**
     * Menampilkan halaman utama pemeliharaan
     *
     * Menampilkan halaman daftar pemeliharaan dengan judul "Maintenance".
     */
	public function index() {
		$config['base_url'] = site_url('manage/maintenance/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$data['title'] = 'Maintenance';
		$data['main'] = 'maintenance/maintenance_list';
		$this->load->view('manage/layout', $data);
	}

    /**
     * Membackup database
     *
     * Melakukan backup database dalam format zip dan mengunduhnya.
     */
	public function backup() {
		// Memuat library dbutil untuk backup database
		$this->load->dbutil();

		// Mendapatkan nama sekolah dari model Setting_model
		$data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));

		// Menyiapkan preferensi backup
		$prefs = [
			'format' => 'zip',
			'filename' => $data['setting_school']['setting_value'].'-'.date("Y-m-d H-i-s").'.sql'
		];

		// Mengambil backup database
		$backup = $this->dbutil->backup($prefs); 

		// Menyiapkan nama file zip untuk diunduh
		$file_name = $data['setting_school']['setting_value'].'-'.date("Y-m-d-H-i-s") .'.zip';

		// Mengunduh file zip yang telah dibuat
		$this->zip->download($file_name);
	}

}

/* End of file Maintenance_set.php */
/* Location: ./application/modules/maintenance/controllers/Maintenance_set.php */