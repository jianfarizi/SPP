<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pos_model extends CI_Model {

    // Konstruktor model
    function __construct() {
        parent::__construct();
    }

    /**
     * Mengambil data POS dari database
     * 
     * @param array $params Parameter untuk query, bisa berisi:
     *      - 'id': ID POS yang ingin diambil
     *      - 'pos_name': Nama POS untuk pencarian
     *      - 'limit': Batas jumlah data yang diambil
     *      - 'offset': Offset untuk pagination
     *      - 'order_by': Kolom dan urutan pengurutan
     * 
     * @return array Hasil query dalam bentuk array
     */
    function get($params = array())
    {
        // Jika parameter 'id' ada, tambahkan kondisi WHERE
        if(isset($params['id'])) {
            $this->db->where('pos_id', $params['id']);
        }

        // Jika parameter 'pos_name' ada, tambahkan kondisi LIKE untuk pencarian
        if(isset($params['pos_name'])) {
            $this->db->like('pos_name', $params['pos_name']);
        }

        // Jika parameter 'limit' ada, batasi jumlah data yang diambil
        if(isset($params['limit'])) {
            if(!isset($params['offset'])) {
                $params['offset'] = NULL; // Set offset menjadi NULL jika tidak ada
            }
            $this->db->limit($params['limit'], $params['offset']);
        }

        // Jika parameter 'order_by' ada, tambahkan kondisi ORDER BY
        if(isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            // Jika tidak ada, urutkan berdasarkan 'pos_id' secara menurun
            $this->db->order_by('pos_id', 'desc');
        }

        // Pilih kolom yang akan diambil
        $this->db->select('pos_id, pos_name, pos_description');
        $res = $this->db->get('pos');

        // Jika parameter 'id' ada, kembalikan satu baris hasil query
        if(isset($params['id'])) {
            return $res->row_array();
        } else {
            // Jika tidak ada, kembalikan seluruh baris hasil query
            return $res->result_array();
        }
    }

    /**
     * Menambahkan atau memperbarui data POS di database
     * 
     * @param array $data Data POS yang akan disimpan, bisa berisi:
     *      - 'pos_id': ID POS (opsional, jika ada berarti update)
     *      - 'pos_name': Nama POS
     *      - 'pos_description': Keterangan POS
     * 
     * @return mixed ID dari data yang disimpan jika berhasil, FALSE jika gagal
     */
    function add($data = array()) {
        // Set data POS yang akan ditambahkan atau diperbarui
        if(isset($data['pos_id'])) {
            $this->db->set('pos_id', $data['pos_id']);
        }
        
        if(isset($data['pos_name'])) {
            $this->db->set('pos_name', $data['pos_name']);
        }

        if(isset($data['pos_description'])) {
            $this->db->set('pos_description', $data['pos_description']);
        }
        
        // Jika ada 'pos_id', lakukan update; jika tidak, lakukan insert
        if (isset($data['pos_id'])) {
            $this->db->where('pos_id', $data['pos_id']);
            $this->db->update('pos');
            $id = $data['pos_id'];
        } else {
            $this->db->insert('pos');
            $id = $this->db->insert_id();
        }

        // Mengecek apakah ada baris yang terpengaruh
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    /**
     * Menghapus data POS dari database
     * 
     * @param int $id ID POS yang akan dihapus
     */
    function delete($id) {
        $this->db->where('pos_id', $id);
        $this->db->delete('pos');
    }
}