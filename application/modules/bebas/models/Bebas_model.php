<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bebas_model extends CI_Model {

    // Konstruktor untuk memuat model
    function __construct() {
        parent::__construct();
    }

    // Fungsi untuk mengambil data dari database
    function get($params = array()) {
        // Memfilter berdasarkan ID jika disediakan
        if(isset($params['id'])) {
            $this->db->where('bebas.bebas_id', $params['id']);
        }

        // Memfilter berdasarkan ID siswa jika disediakan
        if(isset($params['student_id'])) {
            $this->db->where('bebas.student_student_id', $params['student_id']);
        }

        // Memfilter berdasarkan NIS siswa jika disediakan
        if(isset($params['student_nis'])) {
            $this->db->where('student_nis', $params['student_nis']);
        }

        // Memfilter berdasarkan beberapa ID jika disediakan
        if (isset($params['multiple_id'])) {
            $this->db->where_in('bebas.bebas_id', $params['multiple_id']);
        }

        // Memfilter berdasarkan ID pembayaran jika disediakan
        if(isset($params['payment_id'])) {
            $this->db->where('bebas.payment_payment_id', $params['payment_id']);
        }

        // Memfilter berdasarkan ID periode jika disediakan
        if(isset($params['period_id'])) {
            $this->db->where('payment.period_period_id', $params['period_id']);
        }

        // Memfilter berdasarkan ID kelas jika disediakan
        if(isset($params['class_id'])) {
            $this->db->where('student.class_class_id', $params['class_id']);
        }

        // Memfilter berdasarkan ID jurusan jika disediakan
        if(isset($params['majors_id'])) {
            $this->db->where('student.majors_majors_id', $params['majors_id']);
        }

        // Memfilter berdasarkan tanggal input jika disediakan
        if(isset($params['bebas_input_date'])) {
            $this->db->where('bebas_input_date', $params['bebas_input_date']);
        }

        // Memfilter berdasarkan tanggal update terakhir jika disediakan
        if(isset($params['bebas_last_update'])) {
            $this->db->where('bebas_last_update', $params['bebas_last_update']);
        }

        // Memfilter berdasarkan rentang tanggal jika disediakan
        if(isset($params['date_start']) AND isset($params['date_end'])) {
            $this->db->where('bebas_input_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('bebas_input_date <=', $params['date_end'] . ' 23:59:59');
        }

        // Memfilter berdasarkan status jika disediakan
        if(isset($params['status'])) {
            $this->db->where('bebas_input_date', $params['status']);
        }

        // Mengelompokkan hasil berdasarkan ID siswa jika disediakan
        if(isset($params['group'])) {
            $this->db->group_by('bebas.student_student_id'); 
        }

        // Mengelompokkan hasil berdasarkan ID pembayaran jika disediakan
        if(isset($params['grup'])) {
            $this->db->group_by('bebas.payment_payment_id'); 
        }

        // Menetapkan batasan jumlah hasil dan offset jika disediakan
        if(isset($params['limit'])) {
            if(!isset($params['offset'])) {
                $params['offset'] = NULL;
            }
            $this->db->limit($params['limit'], $params['offset']);
        }

        // Menetapkan urutan hasil berdasarkan kolom dan arah yang disediakan
        if(isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('bebas_last_update', 'desc');
        }

        // Menentukan kolom-kolom yang akan diambil dari tabel
        $this->db->select('bebas.bebas_id, bebas_bill, bebas_total_pay, bebas_input_date, bebas_last_update');
        $this->db->select('student_student_id, student.class_class_id, class_name, student_full_name, student_nis, student_name_of_mother, student_parent_phone, student.majors_majors_id, majors_name, majors_short_name');
        $this->db->select('payment_payment_id, pos_name, payment_type, period_period_id, period_start, period_end');

        // Melakukan join dengan tabel-tabel terkait
        $this->db->join('student', 'student.student_id = bebas.student_student_id', 'left');
        $this->db->join('payment', 'payment.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('pos', 'pos.pos_id = payment.pos_pos_id', 'left');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('period', 'period.period_id = payment.period_period_id', 'left');
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');

        // Mengambil hasil query
        $res = $this->db->get('bebas');

        // Mengembalikan hasil berdasarkan apakah ID disediakan atau tidak
        if(isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Fungsi untuk menambah atau memperbarui data di database
    function add($data = array()) {
        // Menetapkan nilai kolom jika disediakan
        if(isset($data['bebas_id'])) {
            $this->db->set('bebas_id', $data['bebas_id']);
        }

        if(isset($data['student_id'])) {
            $this->db->set('student_student_id', $data['student_id']);
        }

        if(isset($data['payment_id'])) {
            $this->db->set('payment_payment_id', $data['payment_id']);
        }

        if(isset($data['bebas_bill'])) {
            $this->db->set('bebas_bill', $data['bebas_bill']);
        }

        if(isset($data['bebas_total_pay'])) {
            $this->db->set('bebas_total_pay', $data['bebas_total_pay']);
        }

        // Menambahkan atau mengurangi anggaran jika disediakan
        if (isset($data['increase_budget'])) {
            $this->db->set('bebas_total_pay', 'bebas_total_pay +' . $data['increase_budget'], FALSE);
        }

        if (isset($data['decrease_budget'])) {
            $this->db->set('bebas_total_pay', 'bebas_total_pay -' . $data['decrease_budget'], FALSE);
        }

        if(isset($data['bebas_input_date'])) {
            $this->db->set('bebas_input_date', $data['bebas_input_date']);
        }

        if(isset($data['bebas_last_update'])) {
            $this->db->set('bebas_last_update', $data['bebas_last_update']);
        }

        // Memperbarui data jika ID disediakan, atau menambah data baru jika tidak ada ID
        if (isset($data['bebas_id'])) {
            $this->db->where('bebas_id', $data['bebas_id']);
            $this->db->update('bebas');
            $id = $data['bebas_id'];
        } else {
            $this->db->insert('bebas');
            $id = $this->db->insert_id();
        }

        // Mengembalikan ID yang baru ditambahkan atau FALSE jika tidak ada perubahan
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Fungsi untuk menghapus data dari database berdasarkan ID
    function delete($id) {
        $this->db->where('bebas_id', $id);
        $this->db->delete('bebas');
    }

    // Fungsi untuk menghapus data bebas berdasarkan parameter
    function delete_bebas($params = array()) {
        // Memfilter berdasarkan ID pembayaran jika disediakan
        if (isset($params['payment_id'])) {
            $this->db->where('payment_payment_id', $params['payment_id']);
        }

        // Memfilter berdasarkan ID siswa jika disediakan
        if (isset($params['student_id'])) {
            $this->db->where('student_student_id', $params['student_id']);
        }

        // Memfilter berdasarkan ID bebas jika disediakan
        if (isset($params['id'])) {
            $this->db->where('bebas.bebas_id', $params['id']);
        }

        // Menghapus data dari tabel bebas
        $this->db->delete('bebas');
    }
}