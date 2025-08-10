<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function simpan_log($data) {
        $this->db->insert('log_pengumuman_gagal', $data);
    }

    // Mendapatkan log pengumuman gagal dari database
    public function get_log_pengumuman_gagal() {
        return $this->db->get('log_pengumuman_gagal')->result();
    }

    public function getSekolah()
    {
        return $this->db->get_where('sekolah', ['id' => 1])->row_array(); // ambil sekolah aktif atau default
    }
}
