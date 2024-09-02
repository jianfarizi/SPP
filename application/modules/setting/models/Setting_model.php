<?php

if (!defined('BASEPATH'))
    exit('No direct script are allowed'); // Mencegah akses langsung ke file ini

class Setting_model extends CI_Model {

    // Fungsi untuk mengambil data pengaturan
    public function get($param = array()) {

        // Cek jika parameter 'id' ada dan tambahkan kondisi WHERE
        if (isset($param['id'])) {
            $this->db->where('setting_id', $param['id']);
        }
        
        // Cek jika parameter 'setting_school' ada dan tambahkan kondisi WHERE
        if (isset($param['setting_school'])) {
            $this->db->where('setting_school', $param['setting_school']);
        }

        // Cek jika parameter 'setting_logo' ada dan tambahkan kondisi WHERE
        if (isset($param['setting_logo'])) {
            $this->db->where('setting_logo', $param['setting_logo']);
        }

        // Jika parameter 'id' atau 'setting_school' ada, ambil satu baris data
        if (isset($param['id']) OR isset($param['setting_school'])) {
            return $this->db->get('setting')->row_array();
        } else {
            // Jika tidak, ambil semua baris data
            return $this->db->get('setting')->result_array();
        }
    }

    // Fungsi untuk mengambil nilai pengaturan
    public function get_value($params = array()) {
        $setting = $this->get($params);

        // Kembalikan nilai pengaturan jika tidak kosong, jika kosong kembalikan string kosong
        if (!empty($setting['setting_value']))
            return $setting['setting_value'];
        else
            return '';
    }

    // Fungsi untuk menyimpan data pengaturan
    public function save($param = array()) {
        // Cek jika parameter 'setting_school' ada, update pengaturan dengan id 1
        if (isset($param['setting_school'])) {
            $this->db->set('setting_value', $param['setting_school']);
            $this->db->where('setting_id', 1);
            $this->db->update('setting');
        }
        // Cek jika parameter 'setting_address' ada, update pengaturan dengan id 2
        if (isset($param['setting_address'])) {
            $this->db->set('setting_value', $param['setting_address']);
            $this->db->where('setting_id', 2);
            $this->db->update('setting');
        }
        // Cek jika parameter 'setting_phone' ada, update pengaturan dengan id 3
        if (isset($param['setting_phone'])) {
            $this->db->set('setting_value', $param['setting_phone']);
            $this->db->where('setting_id', 3);
            $this->db->update('setting');
        }

        // Cek jika parameter 'setting_district' ada, update pengaturan dengan id 4
        if (isset($param['setting_district'])) {
            $this->db->set('setting_value', $param['setting_district']);
            $this->db->where('setting_id', 4);
            $this->db->update('setting');
        }

        // Cek jika parameter 'setting_city' ada, update pengaturan dengan id 5
        if (isset($param['setting_city'])) {
            $this->db->set('setting_value', $param['setting_city']);
            $this->db->where('setting_id', 5);
            $this->db->update('setting');
        }

        // Cek jika parameter 'setting_logo' ada, update pengaturan dengan id 6
        if (isset($param['setting_logo'])) {
            $this->db->set('setting_value', $param['setting_logo']);
            $this->db->where('setting_id', 6);
            $this->db->update('setting');
        }

        // Cek jika parameter 'setting_level' ada, update pengaturan dengan id 7
        if (isset($param['setting_level'])) {
            $this->db->set('setting_value', $param['setting_level']);
            $this->db->where('setting_id', 7);
            $this->db->update('setting');
        }

        // Cek jika parameter 'setting_user_sms' ada, update pengaturan dengan id 8
        if (isset($param['setting_user_sms'])) {
            $this->db->set('setting_value', $param['setting_user_sms']);
            $this->db->where('setting_id', 8);
            $this->db->update('setting');
        }

        // Cek jika parameter 'setting_pass_sms' ada, update pengaturan dengan id 9
        if (isset($param['setting_pass_sms'])) {
            $this->db->set('setting_value', $param['setting_pass_sms']);
            $this->db->where('setting_id', 9);
            $this->db->update('setting');
        }

        // Cek jika parameter 'setting_sms' ada, update pengaturan dengan id 10
        if (isset($param['setting_sms'])) {
            $this->db->set('setting_value', $param['setting_sms']);
            $this->db->where('setting_id', 10);
            $this->db->update('setting');
        }

    }

}