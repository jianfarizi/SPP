<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Model untuk mengelola periode tahun pelajaran
class Period_model extends CI_Model {

    // Konstruktor, memanggil konstruktor induk
    function __construct() {
        parent::__construct();
    }

    // Fungsi untuk mendapatkan data periode dari database
    function get($params = array())
    {
        // Memeriksa apakah parameter ID diberikan, jika ya, tambahkan kondisi WHERE
        if(isset($params['id']))
        {
            $this->db->where('period_id', $params['id']);
        }

        // Memeriksa apakah parameter status diberikan, jika ya, tambahkan kondisi WHERE
        if(isset($params['status']))
        {
            $this->db->where('period_status', $params['status']);
        }

        // Memeriksa apakah parameter periode awal diberikan, jika ya, tambahkan kondisi WHERE
        if(isset($params['period_start']))
        {
            $this->db->where('period_start', $params['period_start']);
        }

        // Memeriksa apakah parameter periode akhir diberikan, jika ya, tambahkan kondisi WHERE
        if(isset($params['period_end']))
        {
            $this->db->where('period_end', $params['period_end']);
        }

        // Memeriksa apakah parameter limit diberikan, jika ya, atur limit dan offset
        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL; // Default offset adalah NULL
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        // Memeriksa apakah parameter order_by diberikan, jika ya, tambahkan kondisi ORDER BY
        if(isset($params['order_by']))
        {
            $this->db->order_by($params['order_by'], 'desc');
        }
        else
        {
            $this->db->order_by('period_id', 'desc'); // Default sorting berdasarkan ID periode secara menurun
        }

        $this->db->select('period_id, period_start, period_end, period_status'); // Pilih kolom-kolom yang dibutuhkan
        $res = $this->db->get('period'); // Ambil data dari tabel 'period'

        // Mengembalikan hasil sebagai array berdasarkan apakah ID diberikan atau tidak
        if(isset($params['id']))
        {
            return $res->row_array(); // Mengembalikan satu baris sebagai array jika ID diberikan
        }
        else
        {
            return $res->result_array(); // Mengembalikan hasil sebagai array dari beberapa baris jika ID tidak diberikan
        }
    }
    
    // Fungsi untuk menambah atau memperbarui data periode di database
    function add($data = array()) {

       // Jika parameter period_id diberikan, atur nilai untuk pembaruan
       if(isset($data['period_id'])) {
        $this->db->set('period_id', $data['period_id']);
    }

    // Atur nilai untuk periode awal jika diberikan
    if(isset($data['period_start'])) {
        $this->db->set('period_start', $data['period_start']);
    }

    // Atur nilai untuk periode akhir jika diberikan
    if(isset($data['period_end'])) {
        $this->db->set('period_end', $data['period_end']);
    }

    // Atur nilai untuk status periode jika diberikan
    if(isset($data['period_status'])) {
        $this->db->set('period_status', $data['period_status']);
    }

    // Jika parameter period_id diberikan, lakukan pembaruan
    if (isset($data['period_id'])) {
        $this->db->where('period_id', $data['period_id']);
        $this->db->update('period');
        $id = $data['period_id'];
    } else if (isset($data['status_active'])) {
        // Jika status aktif diberikan, lakukan pembaruan tanpa ID
        $this->db->update('period');
        $id = NULL;
    } else {
        // Jika tidak ada period_id, lakukan penyisipan data
        $this->db->insert('period');
        $id = $this->db->insert_id(); // Ambil ID yang baru disisipkan
    }

    $status = $this->db->affected_rows(); // Mengecek jumlah baris yang terpengaruh
    return ($status == 0) ? FALSE : $id; // Mengembalikan ID jika berhasil, atau FALSE jika tidak ada perubahan
}

    // Fungsi untuk menghapus data periode dari database
    function delete($id) {
    $this->db->where('period_id', $id);
    $this->db->delete('period');
}

}