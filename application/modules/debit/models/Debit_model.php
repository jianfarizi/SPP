<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debit_model extends CI_Model {

    // Konstruktor untuk model
    function __construct() {
        parent::__construct();
    }

    // Fungsi untuk mendapatkan data debit dari database
    function get($params = array())
    {
        // Memeriksa apakah parameter 'id' ada dan menambahkannya ke query
        if (isset($params['id'])) {
            $this->db->where('debit_id', $params['id']);
        }

        // Memeriksa apakah parameter 'date' ada dan menambahkannya ke query
        if (isset($params['date'])) {
            $this->db->where('debit_date', $params['date']);
        }

        // Memeriksa apakah parameter 'debit_desc' ada dan menambahkannya ke query
        if (isset($params['debit_desc'])) {
            $this->db->like('debit_desc', $params['debit_desc']);
        }

        // Memeriksa apakah parameter 'debit_input_date' ada dan menambahkannya ke query
        if (isset($params['debit_input_date'])) {
            $this->db->where('debit_input_date', $params['debit_input_date']);
        }

        // Memeriksa apakah parameter 'debit_last_update' ada dan menambahkannya ke query
        if (isset($params['debit_last_update'])) {
            $this->db->where('debit_last_update', $params['debit_last_update']);
        }

        // Memeriksa apakah parameter 'date_start' dan 'date_end' ada untuk rentang tanggal
        if (isset($params['date_start']) AND isset($params['date_end'])) {
            $this->db->where('debit_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('debit_date <=', $params['date_end'] . ' 23:59:59');
        }

        // Memeriksa apakah parameter 'limit' ada untuk membatasi jumlah hasil
        if (isset($params['limit'])) {
            // Jika parameter 'offset' tidak ada, set null
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        // Memeriksa apakah parameter 'order_by' ada untuk mengatur urutan hasil
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('debit_id', 'desc');
        }

        // Memilih kolom yang akan diambil dari tabel
        $this->db->select('debit_id, debit_date, debit_value, debit_desc, debit_input_date, debit_last_update');
        $this->db->select('user_user_id, user_full_name');

        // Bergabung dengan tabel users untuk mendapatkan nama pengguna
        $this->db->join('users', 'users.user_id = debit.user_user_id', 'left');

        // Mengambil data dari tabel debit
        $res = $this->db->get('debit');

        // Mengembalikan hasil query
        if (isset($params['id'])) {
            // Jika ada parameter 'id', kembalikan hasil sebagai array baris tunggal
            return $res->row_array();
        } else {
            // Jika tidak ada parameter 'id', kembalikan hasil sebagai array baris banyak
            return $res->result_array();
        }
    }

    // Fungsi untuk menambahkan atau memperbarui data debit ke database
    function add($data = array()) {

        // Menambahkan atau memperbarui kolom berdasarkan data yang ada
        if (isset($data['debit_id'])) {
            $this->db->set('debit_id', $data['debit_id']);
        }

        if (isset($data['debit_date'])) {
            $this->db->set('debit_date', $data['debit_date']);
        }

        if (isset($data['debit_value'])) {
            $this->db->set('debit_value', $data['debit_value']);
        }

        if (isset($data['debit_desc'])) {
            $this->db->set('debit_desc', $data['debit_desc']);
        }

        if (isset($data['user_user_id'])) {
            $this->db->set('user_user_id', $data['user_user_id']);
        }

        if (isset($data['debit_input_date'])) {
            $this->db->set('debit_input_date', $data['debit_input_date']);
        }

        if (isset($data['debit_last_update'])) {
            $this->db->set('debit_last_update', $data['debit_last_update']);
        }

        // Memeriksa apakah 'debit_id' ada untuk menentukan apakah akan melakukan update atau insert
        if (isset($data['debit_id'])) {
            // Jika 'debit_id' ada, lakukan update
            $this->db->where('debit_id', $data['debit_id']);
            $this->db->update('debit');
            $id = $data['debit_id'];
        } else {
            // Jika 'debit_id' tidak ada, lakukan insert
            $this->db->insert('debit');
            $id = $this->db->insert_id();
        }

        // Memeriksa status dari operasi yang dilakukan
        $status = $this->db->affected_rows();
        // Mengembalikan ID yang baru ditambahkan atau false jika tidak ada perubahan
        return ($status == 0) ? FALSE : $id;
    }

    // Fungsi untuk menghapus data debit dari database
    function delete($id) {
        $this->db->where('debit_id', $id);
        $this->db->delete('debit');
    }

}

/* End of file debit_model.php */
/* Location: ./application/modules/jurnal/models/debit_model.php */