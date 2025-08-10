<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekolah_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Perbaiki nama metode ini agar sesuai dengan pemanggilan di Dashboard.php
    public function getSekolah() {
        $query = $this->db->select('*')->from('sekolah')->get();
        return $query->row_array();
    }

    public function get_sekolah() {
        $query = $this->db->select('*')->from('sekolah')->get();
        return $query->row_array();
    }


    public function getSekolahById($id) {
        return $this->db->get_where('sekolah', ['id' => $id])->row_array();
    }

    public function updateSekolah($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('sekolah', $data);
    }

    public function getAllSekolah() {
        return $this->db->get('sekolah')->result_array();
    }

    

}
