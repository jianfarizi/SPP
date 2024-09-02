<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Mendapatkan data dari database
    function get($params = array()) {

        // Filter berdasarkan id student
        if (isset($params['id'])) {
            $this->db->where('student.student_id', $params['id']);
        }
        // Filter berdasarkan student_id
        if (isset($params['student_id'])) {
            $this->db->where('student.student_id', $params['student_id']);
        }

        // Filter berdasarkan multiple_id (beberapa ID)
        if (isset($params['multiple_id'])) {
            $this->db->where_in('student.student_id', $params['multiple_id']);
        }

        // Filter berdasarkan student_search yang bisa mencari NIS atau nama lengkap student
        if (isset($params['student_search'])) {
            $this->db->where('student_nis', $params['student_search']);
            $this->db->or_like('student_full_name', $params['student_search']);
        }

        // Filter berdasarkan student_nis
        if (isset($params['student_nis'])) {
            $this->db->where('student.student_nis', $params['student_nis']);
        }

        // Filter berdasarkan nis dengan like
        if (isset($params['nis'])) {
            $this->db->like('student_nis', $params['nis']);
        }

        // Filter berdasarkan password dengan like
        if (isset($params['password'])) {
            $this->db->like('student_password', $params['password']);
        }

        // Filter berdasarkan nama lengkap student
        if (isset($params['student_full_name'])) {
            $this->db->where('student.student_full_name', $params['student_full_name']);
        }

        // Filter berdasarkan status student
        if (isset($params['status'])) {
            $this->db->where('student.student_status', $params['status']);
        }
        
        // Filter berdasarkan tanggal input student
        if (isset($params['date'])) {
            $this->db->where('student_input_date', $params['date']);
        }

        // Filter berdasarkan class_id
        if (isset($params['class_id'])) {
            $this->db->where('class_class_id', $params['class_id']);
        }

        // Filter berdasarkan majors_id
        if (isset($params['majors_id'])) {
            $this->db->where('majors_majors_id', $params['majors_id']);
        }

        // Filter berdasarkan nama class
        if (isset($params['class_name'])) {
            $this->db->like('class_name', $params['class_name']);
        }

        // Mengelompokkan hasil berdasarkan class_id
        if (isset($params['group'])) {
            $this->db->group_by('student.class_class_id'); 
        }

        // Membatasi jumlah hasil yang dikembalikan
        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }
            $this->db->limit($params['limit'], $params['offset']);
        }

        // Mengatur urutan hasil berdasarkan order_by atau default
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('student_last_update', 'desc');
        }

        // Menentukan kolom yang akan dipilih
        $this->db->select('student.student_id, student_nis, student_nisn, student_password, student_gender, student_phone, student_hobby, student_address, student_parent_phone, student_full_name, student_born_place, student_born_date, student_img, student_status, student_name_of_mother, student_name_of_father, student_input_date, student_last_update');
        $this->db->select('class_class_id, class.class_name');
        $this->db->select('majors_majors_id, majors.majors_name, majors_short_name');

        // Menggabungkan tabel class dan majors
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');

        // Mengambil data dari tabel student
        $res = $this->db->get('student');

        // Mengembalikan hasil sesuai dengan parameter
        if (isset($params['id'])) {
            return $res->row_array();
        } else if (isset($params['student_nis'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Mendapatkan data class
    function get_class($params = array()) {
        // Filter berdasarkan id class
        if (isset($params['id'])) {
            $this->db->where('class_id', $params['id']);
        }

        // Filter berdasarkan nama class
        if (isset($params['class_name'])) {
            $this->db->where('class_name', $params['class_name']);
        }

        // Membatasi jumlah hasil yang dikembalikan
        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }
            $this->db->limit($params['limit'], $params['offset']);
        }

        // Mengatur urutan hasil berdasarkan order_by atau default
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('class_id', 'asc');
        }

        // Menentukan kolom yang akan dipilih
        $this->db->select('class_id, class_name');
        // Mengambil data dari tabel class
        $res = $this->db->get('class');

        // Mengembalikan hasil sesuai dengan parameter
        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Mendapatkan data majors
    function get_majors($params = array()) {
        // Filter berdasarkan id majors
        if (isset($params['id'])) {
            $this->db->where('majors_id', $params['id']);
        }

        // Filter berdasarkan nama majors
        if (isset($params['majors_name'])) {
            $this->db->where('majors_name', $params['majors_name']);
        }

        // Filter berdasarkan short name majors
        if (isset($params['majors_short_name'])) {
            $this->db->where('majors_short_name', $params['majors_short_name']);
        }

        // Membatasi jumlah hasil yang dikembalikan
        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }
            $this->db->limit($params['limit'], $params['offset']);
        }

        // Mengatur urutan hasil berdasarkan order_by atau default
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('majors_id', 'asc');
        }

        // Menentukan kolom yang akan dipilih
        $this->db->select('majors_id, majors_name, majors_short_name');
        // Mengambil data dari tabel majors
        $res = $this->db->get('majors');

        // Mengembalikan hasil sesuai dengan parameter
        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Menambahkan atau memperbarui data student
    function add($data = array()) {

        // Mengatur data yang akan dimasukkan atau diperbarui
        if (isset($data['student_id'])) {
            $this->db->set('student_id', $data['student_id']);
        }
        if (isset($data['student_nis'])) {
            $this->db->set('student_nis', $data['student_nis']);
        }
        if (isset($data['student_nisn'])) {
            $this->db->set('student_nisn', $data['student_nisn']);
        }
        if (isset($data['student_password'])) {
            $this->db->set('student_password', $data['student_password']);
        }
        if (isset($data['student_gender'])) {
            $this->db->set('student_gender', $data['student_gender']);
        }
        if (isset($data['student_phone'])) {
            $this->db->set('student_phone', $data['student_phone']);
        }
        if (isset($data['student_parent_phone'])) {
            $this->db->set('student_parent_phone', $data['student_parent_phone']);
        }
        if (isset($data['student_hobby'])) {
            $this->db->set('student_hobby', $data['student_hobby']);
        }
        if (isset($data['student_address'])) {
            $this->db->set('student_address', $data['student_address']);
        }
        if (isset($data['student_name_of_father'])) {
            $this->db->set('student_name_of_father', $data['student_name_of_father']);
        }
        if (isset($data['student_full_name'])) {
            $this->db->set('student_full_name', $data['student_full_name']);
        }
        if (isset($data['student_img'])) {
            $this->db->set('student_img', $data['student_img']);
        }
        if (isset($data['student_born_place'])) {
            $this->db->set('student_born_place', $data['student_born_place']);
        }
        if (isset($data['student_born_date'])) {
            $this->db->set('student_born_date', $data['student_born_date']);
        }
        if (isset($data['student_name_of_mother'])) {
            $this->db->set('student_name_of_mother', $data['student_name_of_mother']);
        }
        if (isset($data['class_class_id'])) {
            $this->db->set('class_class_id', $data['class_class_id']);
        }
        if (isset($data['majors_majors_id'])) {
            $this->db->set('majors_majors_id', $data['majors_majors_id']);
        }
        if (isset($data['student_status'])) {
            $this->db->set('student_status', $data['student_status']);
        }
        if (isset($data['student_input_date'])) {
            $this->db->set('student_input_date', $data['student_input_date']);
        }
        if (isset($data['student_last_update'])) {
            $this->db->set('student_last_update', $data['student_last_update']);
        }

        // Menambahkan data baru atau memperbarui data yang ada
        if (isset($data['student_id'])) {
            $this->db->where('student_id', $data['student_id']);
            $this->db->update('student');
            $id = $data['student_id'];
        } else {
            $this->db->insert('student');
            $id = $this->db->insert_id();
        }

        // Mengecek status perubahan data
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Menambahkan atau memperbarui data class
    function add_class($data = array()) {

        // Mengatur data yang akan dimasukkan atau diperbarui
        if (isset($data['class_id'])) {
            $this->db->set('class_id', $data['class_id']);
        }
        if (isset($data['class_name'])) {
            $this->db->set('class_name', $data['class_name']);
        }

        // Menambahkan data baru atau memperbarui data yang ada
        if (isset($data['class_id'])) {
            $this->db->where('class_id', $data['class_id']);
            $this->db->update('class');
            $id = $data['class_id'];
        } else {
            $this->db->insert('class');
            $id = $this->db->insert_id(); 
        }

        // Mengecek status perubahan data
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Menambahkan atau memperbarui data majors
    function add_majors($data = array()) {

        // Mengatur data yang akan dimasukkan atau diperbarui
        if (isset($data['majors_id'])) {
            $this->db->set('majors_id', $data['majors_id']);
        }
        if (isset($data['majors_name'])) {
            $this->db->set('majors_name', $data['majors_name']);
        }
        if (isset($data['majors_short_name'])) {
            $this->db->set('majors_short_name', $data['majors_short_name']);
        }

        // Menambahkan data baru atau memperbarui data yang ada
        if (isset($data['majors_id'])) {
            $this->db->where('majors_id', $data['majors_id']);
            $this->db->update('majors');
            $id = $data['majors_id'];
        } else {
            $this->db->insert('majors');
            $id = $this->db->insert_id(); 
        }

        // Mengecek status perubahan data
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Menghapus data student berdasarkan id
    function delete($id) {
        $this->db->where('student_id', $id);
        $this->db->delete('student');
    }

    // Menghapus data class berdasarkan id
    function delete_class($id) {
        $this->db->where('class_id', $id);
        $this->db->delete('class');
    }

    // Menghapus data majors berdasarkan id
    function delete_majors($id) {
        $this->db->where('majors_id', $id);
        $this->db->delete('majors');
    }

    // Mengecek apakah ada data student dengan field dan value tertentu
    public function is_exist($field, $value) {
        $this->db->where($field, $value);        
        return $this->db->count_all_results('student') > 0 ? TRUE : FALSE;
    }

    // Mengubah password student berdasarkan id
    function change_password($id, $params) {
        $this->db->where('student_id', $id);
        $this->db->update('student', $params);
    }
}