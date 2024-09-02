<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Model untuk menangani operasi database terkait pembayaran
class Payment_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Mendapatkan data dari database dengan parameter yang diberikan
    function get($params = array())
    {
        // Memfilter berdasarkan ID pembayaran jika parameter 'id' diset
        if(isset($params['id']))
        {
            $this->db->where('payment.payment_id', $params['id']);
        }

        // Memfilter berdasarkan ID periode jika parameter 'period_id' diset
        if(isset($params['period_id']))
        {
            $this->db->where('payment.period_period_id', $params['period_id']);
        }

        // Memfilter berdasarkan ID POS jika parameter 'pos_id' diset
        if(isset($params['pos_id']))
        {
            $this->db->where('payment.pos_pos_id', $params['pos_id']);
        }

        // Mencari berdasarkan nama POS jika parameter 'search' diset
        if(isset($params['search'])) 
        {
            $this->db->like('pos_name', $params['search']);
        }

        // Memfilter berdasarkan periode mulai jika parameter 'period_start' diset
        if(isset($params['period_start'])) 
        {
            $this->db->where('period_start', $params['period_start']);
        }

        // Memfilter berdasarkan periode akhir jika parameter 'period_end' diset
        if(isset($params['period_end'])) 
        {
            $this->db->where('period_end', $params['period_end']);
        }

        // Memfilter berdasarkan tanggal input pembayaran jika parameter 'payment_input_date' diset
        if(isset($params['payment_input_date']))
        {
            $this->db->where('payment_input_date', $params['payment_input_date']);
        }

        // Memfilter berdasarkan tanggal pembaruan terakhir pembayaran jika parameter 'payment_last_update' diset
        if(isset($params['payment_last_update']))
        {
            $this->db->where('payment_last_update', $params['payment_last_update']);
        }
        
        // Memfilter berdasarkan rentang tanggal input pembayaran jika parameter 'date_start' dan 'date_end' diset
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('payment_input_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('payment_input_date <=', $params['date_end'] . ' 23:59:59');
        }

        // Memfilter berdasarkan status pembayaran jika parameter 'status' diset
        if(isset($params['status']))
        {
            $this->db->where('payment_input_date', $params['status']);
        }

        // Mengatur batasan jumlah data yang diambil dan offset jika parameter 'limit' diset
        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        // Mengatur urutan hasil data jika parameter 'order_by' diset
        if(isset($params['order_by']))
        {
            $this->db->order_by($params['order_by'], 'desc');
        }
        else
        {
            // Urutkan berdasarkan tanggal pembaruan terakhir secara default
            $this->db->order_by('payment_last_update', 'desc');
        }

        // Menentukan kolom yang akan diambil
        $this->db->select('payment.payment_id, payment_type, payment_input_date, payment_last_update');
        $this->db->select('pos_pos_id, pos_name, pos_description');
        $this->db->select('period_period_id, period.period_start, period.period_end, period.period_status');

        // Bergabung dengan tabel period dan pos untuk mendapatkan data terkait
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');

        // Mengambil data dari tabel pembayaran
        $res = $this->db->get('payment');

        // Mengembalikan hasil sebagai array
        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }

    // Menambahkan atau memperbarui data pembayaran ke database
    function add($data = array()) {
        
         // Menyimpan ID pembayaran jika diset
         if(isset($data['payment_id'])) {
            $this->db->set('payment_id', $data['payment_id']);
        }
        
         // Menyimpan tipe pembayaran jika diset
         if(isset($data['payment_type'])) {
            $this->db->set('payment_type', $data['payment_type']);
        }
        
         // Menyimpan ID periode jika diset
         if(isset($data['period_id'])) {
            $this->db->set('period_period_id', $data['period_id']);
        }
        
         // Menyimpan ID POS jika diset
         if(isset($data['pos_id'])) {
            $this->db->set('pos_pos_id', $data['pos_id']);
        }
        
         // Menyimpan tanggal input pembayaran jika diset
         if(isset($data['payment_input_date'])) {
            $this->db->set('payment_input_date', $data['payment_input_date']);
        }
        
         // Menyimpan tanggal pembaruan terakhir jika diset
         if(isset($data['payment_last_update'])) {
            $this->db->set('payment_last_update', $data['payment_last_update']);
        }
        
        // Memperbarui data jika ID pembayaran diset, jika tidak, menambahkan data baru
        if (isset($data['payment_id'])) {
            $this->db->where('payment_id', $data['payment_id']);
            $this->db->update('payment');
            $id = $data['payment_id'];
        } else {
            $this->db->insert('payment');
            $id = $this->db->insert_id();
        }

        // Mengembalikan ID atau FALSE jika tidak ada perubahan
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Menghapus semua data pembayaran dari database
    function delete_all() {
        $this->db->truncate('payment');
    }
    
    // Menghapus data pembayaran berdasarkan ID
    function delete($id) {
        $this->db->where('payment_id', $id);
        $this->db->delete('payment');
    }
}