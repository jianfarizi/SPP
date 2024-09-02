<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kredit_model extends CI_Model {

    // Konstruktor untuk model Kredit
    function __construct() {
        parent::__construct();
    }

    // Mendapatkan data kredit dari database berdasarkan parameter
    function get($params = array())
    {
        // Memeriksa apakah parameter ID diset
        if(isset($params['id']))
        {
            $this->db->where('kredit_id', $params['id']);
        }

        // Memeriksa apakah parameter tanggal diset
        if (isset($params['date'])) {
            $this->db->where('kredit_date', $params['date']);
        }

        // Memeriksa apakah parameter keterangan diset
        if (isset($params['kredit_desc'])) {
            $this->db->like('kredit_desc', $params['kredit_desc']);
        }

        // Memeriksa apakah parameter tanggal input diset
        if(isset($params['kredit_input_date']))
        {
            $this->db->where('kredit_input_date', $params['kredit_input_date']);
        }

        // Memeriksa apakah parameter tanggal pembaruan diset
        if(isset($params['kredit_last_update']))
        {
            $this->db->where('kredit_last_update', $params['kredit_last_update']);
        }
        
        // Memeriksa apakah parameter tanggal mulai dan tanggal akhir diset
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('kredit_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('kredit_date <=', $params['date_end'] . ' 23:59:59');
        }

        // Memeriksa apakah parameter limit diset
        if(isset($params['limit']))
        {
            // Memeriksa apakah parameter offset diset
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            // Mengatur limit dan offset untuk query
            $this->db->limit($params['limit'], $params['offset']);
        }

        // Memeriksa apakah parameter order_by diset
        if(isset($params['order_by']))
        {
            // Mengatur urutan berdasarkan parameter order_by
            $this->db->order_by($params['order_by'], 'desc');
        }
        else
        {
            // Mengatur urutan default berdasarkan kredit_id
            $this->db->order_by('kredit_id', 'desc');
        }

        // Memilih kolom yang akan diambil
        $this->db->select('kredit_id, kredit_date, kredit_value, kredit_desc, kredit_input_date, kredit_last_update');
        $this->db->select('user_user_id, user_full_name');

        // Bergabung dengan tabel users untuk mendapatkan nama pengguna
        $this->db->join('users', 'users.user_id = kredit.user_user_id', 'left');

        // Menjalankan query
        $res = $this->db->get('kredit');

        // Mengembalikan hasil query
        if(isset($params['id']))
        {
            return $res->row_array(); // Mengembalikan satu baris jika ID diset
        }
        else
        {
            return $res->result_array(); // Mengembalikan beberapa baris jika ID tidak diset
        }
    }

    // Menambahkan atau memperbarui data kredit ke database
    function add($data = array()) {

        // Memeriksa apakah parameter kredit_id diset untuk memperbarui data
        if(isset($data['kredit_id'])) {
            $this->db->set('kredit_id', $data['kredit_id']);
        }

        // Memeriksa apakah parameter kredit_date diset
        if(isset($data['kredit_date'])) {
            $this->db->set('kredit_date', $data['kredit_date']);
        }

        // Memeriksa apakah parameter kredit_value diset
        if(isset($data['kredit_value'])) {
            $this->db->set('kredit_value', $data['kredit_value']);
        }

        // Memeriksa apakah parameter kredit_desc diset
        if(isset($data['kredit_desc'])) {
            $this->db->set('kredit_desc', $data['kredit_desc']);
        }

        // Memeriksa apakah parameter user_user_id diset
        if(isset($data['user_user_id'])) {
            $this->db->set('user_user_id', $data['user_user_id']);
        }

        // Memeriksa apakah parameter kredit_input_date diset
        if(isset($data['kredit_input_date'])) {
            $this->db->set('kredit_input_date', $data['kredit_input_date']);
        }

        // Memeriksa apakah parameter kredit_last_update diset
        if(isset($data['kredit_last_update'])) {
            $this->db->set('kredit_last_update', $data['kredit_last_update']);
        }

        // Memeriksa apakah parameter kredit_id diset untuk melakukan update
        if (isset($data['kredit_id'])) {
            $this->db->where('kredit_id', $data['kredit_id']);
            $this->db->update('kredit'); // Melakukan update
            $id = $data['kredit_id'];
        } else {
            $this->db->insert('kredit'); // Melakukan insert
            $id = $this->db->insert_id(); // Mendapatkan ID yang baru dimasukkan
        }

        // Memeriksa apakah ada baris yang terpengaruh
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id; // Mengembalikan ID atau FALSE jika tidak ada perubahan
    }

    // Menghapus data kredit dari database
    function delete($id) {
        $this->db->where('kredit_id', $id);
        $this->db->delete('kredit'); // Menghapus data berdasarkan ID
    }
}