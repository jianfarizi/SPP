<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tagihan_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Mendapatkan data dari basis data
    function get($params = array())
    {
        // Filter berdasarkan ID pembayaran
        if(isset($params['id']))
        {
            $this->db->where('payment.payment_id', $params['id']);
        }

        // Filter berdasarkan ID periode
        if(isset($params['period_id']))
        {
            $this->db->where('payment.period_period_id', $params['period_id']);
        }

        // Filter berdasarkan ID POS
        if(isset($params['pos_id']))
        {
            $this->db->where('payment.pos_pos_id', $params['pos_id']);
        }

        // Filter berdasarkan nama POS
        if(isset($params['search'])) 
        {
            $this->db->like('pos_name', $params['search']);
        }

        // Filter berdasarkan tanggal awal periode
        if(isset($params['period_start'])) 
        {
            $this->db->where('period_start', $params['period_start']);
        }

        // Filter berdasarkan tanggal akhir periode
        if(isset($params['period_end'])) 
        {
            $this->db->where('period_end', $params['period_end']);
        }

        // Filter berdasarkan tanggal input pembayaran
        if(isset($params['payment_input_date']))
        {
            $this->db->where('payment_input_date', $params['payment_input_date']);
        }

        // Filter berdasarkan tanggal update terakhir pembayaran
        if(isset($params['payment_last_update']))
        {
            $this->db->where('payment_last_update', $params['payment_last_update']);
        }
        
        // Filter berdasarkan rentang tanggal input pembayaran
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('payment_input_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('payment_input_date <=', $params['date_end'] . ' 23:59:59');
        }

        // Filter berdasarkan status pembayaran (seharusnya mungkin adalah 'status', bukan 'payment_input_date')
        if(isset($params['status']))
        {
            $this->db->where('payment_input_date', $params['status']);
        }

        // Set limit dan offset untuk paginasi
        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        // Mengatur pengurutan data
        if(isset($params['order_by']))
        {
            $this->db->order_by($params['order_by'], 'desc');
        }
        else
        {
            $this->db->order_by('payment_last_update', 'desc');
        }

        // Menentukan kolom yang akan diambil
        $this->db->select('payment.payment_id, payment_type, payment_input_date, payment_last_update');
        $this->db->select('pos_pos_id, pos_name, pos_description');
        $this->db->select('period_period_id, period.period_start, period.period_end, period.period_status');

        // Join tabel period dan pos
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $res = $this->db->get('payment');

        // Mengembalikan hasil query
        if(isset($params['id']))
        {
            return $res->row_array(); // Mengembalikan satu baris data
        }
        else
        {
            return $res->result_array(); // Mengembalikan beberapa baris data
        }
    }

    // Menambahkan atau memperbarui data ke dalam basis data
    function add($data = array()) {
        
        // Mengatur data yang akan diinsert atau diupdate
        if(isset($data['payment_id'])) {
            $this->db->set('payment_id', $data['payment_id']);
        }
        
        if(isset($data['payment_type'])) {
            $this->db->set('payment_type', $data['payment_type']);
        }
        
        if(isset($data['period_id'])) {
            $this->db->set('period_period_id', $data['period_id']);
        }
        
        if(isset($data['pos_id'])) {
            $this->db->set('pos_pos_id', $data['pos_id']);
        }
        
        if(isset($data['payment_input_date'])) {
            $this->db->set('payment_input_date', $data['payment_input_date']);
        }
        
        if(isset($data['payment_last_update'])) {
            $this->db->set('payment_last_update', $data['payment_last_update']);
        }
        
        // Jika payment_id ada, maka lakukan update
        if (isset($data['payment_id'])) {
            $this->db->where('payment_id', $data['payment_id']);
            $this->db->update('payment');
            $id = $data['payment_id'];
        } else {
            // Jika tidak ada payment_id, maka lakukan insert
            $this->db->insert('payment');
            $id = $this->db->insert_id();
        }

        // Mengembalikan ID yang diinsert atau diupdate
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Menghapus semua data dari tabel payment
    function delete_all() {
        $this->db->truncate('payment');
    }
    
    // Menghapus data berdasarkan ID
    function delete($id) {
        $this->db->where('payment_id', $id);
        $this->db->delete('payment');
    }
    
}