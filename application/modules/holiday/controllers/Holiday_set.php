<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday_set extends CI_Controller {

	// Menampilkan halaman utama dan mengelola proses import data
	public function index()
	{
		if ($_POST) {
			// Mengambil data yang dikirim melalui POST dan memecahnya menjadi baris-baris
			$rows = explode("\n", $this->input->post('rows'));
			$success = 0;
			$failled = 0;
			$exist = 0;

			// Memproses setiap baris data
			foreach($rows as $row) {
				$exp = explode("\t", $row);

				// Melanjutkan jika jumlah elemen dalam baris tidak sama dengan 3
				if (count($exp) != 3) continue;

				$date = trim($exp[1]);
				$arr = [
					'year' => trim($exp[0]),
					'date' => trim($exp[1]),
					'info' => trim($exp[2]),
				];

				// Mengecek apakah tanggal sudah ada di database
				$check = $this->db
					->where('date', trim($exp[1]))
					->count_all_results('holiday');

				// Jika tanggal belum ada, maka menyimpan data ke database
				if ($check == 0) {
					if ($this->db->insert('holiday', $arr)) {
						$success++;
					} else {
						$failled++;
					}
				} else {
					$exist++;
				}
			}

			// Menyiapkan pesan hasil proses import
			$msg = 'Sukses : ' . $success . ' baris, Gagal : ' . $failled . ', Duplikat : ' . $exist;
			$this->session->set_flashdata('success', $msg);
			redirect('manage/holiday/import');
		} else {
			// Menyiapkan data untuk ditampilkan di halaman import
			$data['title'] = 'Import Data Hari Libur';
			$data['main'] = 'holiday/holiday_upload';
			$this->load->view('manage/layout', $data);
		}
	}

	// Mengunduh template Excel untuk data hari libur
	public function download() {
		$data = file_get_contents("./media/template_excel/template_libur_nasional.xls");
		$name = 'template_libur_nasional.xls';
		$this->load->helper('download');
		force_download($name, $data);
	}

}

/* End of file Holiday_set.php */
/* Location: ./application/modules/holiday/controllers/Holiday_set.php */