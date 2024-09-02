<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Model untuk menangani log aktivitas
 *
 * @package     Arca CMS
 * @subpackage  Models
 * @category    Models 
 */
class Logs_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Mengambil data log dari database
     *
     * @param array $params Parameter untuk query
     * @return array Data log
     */
    function get($params = array()) {
        // Jika parameter 'id' ada, tambahkan kondisi WHERE
        if (isset($params['id'])) {
            $this->db->where('logs.log_id', $params['id']);
        }

        // Jika parameter 'limit' ada, set limit dan offset
        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        // Jika parameter 'order_by' ada, set urutan
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('log_id', 'desc');
        }

        // Pilih kolom yang akan diambil
        $this->db->select('logs.log_id, log_date, log_action, log_module, log_info, logs.user_id');
        $this->db->select('user_full_name');

        // Gabungkan tabel logs dengan tabel users
        $this->db->join('users', 'users.user_id = logs.user_id', 'left');

        // Ambil data dari tabel logs
        $res = $this->db->get('logs');

        // Jika parameter 'id' ada, kembalikan satu baris data
        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            // Jika tidak, kembalikan semua baris data
            return $res->result_array();
        }
    }

    /**
     * Menambahkan atau memperbarui data log di database
     *
     * @param array $data Data log yang akan ditambahkan atau diperbarui
     * @return mixed ID log yang baru ditambahkan atau ID log yang diperbarui
     */
    function add($data = array()) {

        // Set data untuk kolom log_id jika ada
        if (isset($data['log_id'])) {
            $this->db->set('log_id', $data['log_id']);
        }

        // Set data untuk kolom log_date jika ada
        if (isset($data['log_date'])) {
            $this->db->set('log_date', $data['log_date']);
        }

        // Set data untuk kolom log_action jika ada
        if (isset($data['log_action'])) {
            $this->db->set('log_action', $data['log_action']);
        }

        // Set data untuk kolom log_module jika ada
        if (isset($data['log_module'])) {
            $this->db->set('log_module', $data['log_module']);
        }

        // Set data untuk kolom log_info jika ada
        if (isset($data['log_info'])) {
            $this->db->set('log_info', $data['log_info']);
        }

        // Set data untuk kolom user_id jika ada
        if (isset($data['user_id'])) {
            $this->db->set('user_id', $data['user_id']);
        }

        // Jika parameter 'log_id' ada, lakukan update
        if (isset($data['log_id'])) {
            $this->db->where('log_id', $data['log_id']);
            $this->db->update('logs');
            $id = $data['log_id'];
        } else {
            // Jika tidak ada 'log_id', lakukan insert
            $this->db->insert('logs');
            $id = $this->db->insert_id();
        }

        // Cek jumlah baris yang terpengaruh
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

}