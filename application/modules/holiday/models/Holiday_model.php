<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	// Nama tabel yang digunakan
	var $table = 'holiday';

    // Mendapatkan data dari database dengan berbagai parameter opsional
	public function get($params = array())
    {
        // Mengecek jika parameter 'id' ada dan menambahkannya ke query
        if(isset($params['id']))
        {
            $this->db->where('id', $params['id']);
        }
        // Mengecek jika parameter 'year' ada dan menambahkannya ke query
        if(isset($params['year']))
        {
            $this->db->where('year', $params['year']);
        }
        // Mengecek jika parameter 'date' ada dan menambahkannya ke query
        if(isset($params['date']))
        {
            $this->db->where('date', $params['date']);
        }
        // Mengecek jika parameter 'info' ada dan menambahkannya ke query
        if(isset($params['info']))
        {
            $this->db->where('info', $params['info']);
        }
        // Mengecek jika parameter rentang tanggal ada dan menambahkannya ke query
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('date >=', $params['date_start'].' 00:00:00');
            $this->db->where('date <=', $params['date_end'].' 23:59:59');
        }

        // Mengecek jika parameter 'limit' ada dan menambahkannya ke query
        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }
            $this->db->limit($params['limit'], $params['offset']);
        }

        // Mengecek jika parameter 'order_by' ada dan menambahkannya ke query
        if(isset($params['order_by']))
        {
            $this->db->order_by($params['order_by'], 'desc');
        }
        else
        {
            $this->db->order_by('id', 'desc');
        }

        // Menjalankan query untuk mendapatkan data dari tabel 'holiday'
        $res = $this->db->get('holiday');

        // Mengembalikan hasil sebagai array berdasarkan apakah 'id' ada atau tidak
        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }

    // Menambahkan atau memperbarui data di database
    function add($data = array()) {
        $param = array(
            'date' => $data['date'],
            'year' => $data['year'],
            'info' => $data['info'],
            );
        $this->db->set($param);

        // Mengecek jika 'id' ada untuk memperbarui data
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('holiday');
            $id = $data['id'];
        } else {
            // Jika 'id' tidak ada, maka menyisipkan data baru
            $this->db->insert('holiday');
            $id = $this->db->insert_id();
        }

        // Mengecek status dari operasi dan mengembalikan id atau FALSE
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    // Menghapus data dari database berdasarkan 'id'
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('holiday');
    }

    // Mendapatkan daftar tanggal libur
    function get_holiday() {
        $libur = $this->get();

        $res_libur = array();
        foreach ($libur as $key) {
            $res_libur[] = $key['date'];
        }

        return $res_libur;
    }

    // Mengecek apakah ada data yang sudah ada dalam tabel 'holiday'
    public function is_exist($field, $value)
    {
        $this->db->where($field, $value);        

        return $this->db->count_all_results('holiday') > 0 ? TRUE : FALSE;
    }
}

/* End of file Holiday_model.php */
/* Location: ./application/modules/holiday/models/Holiday_model.php */