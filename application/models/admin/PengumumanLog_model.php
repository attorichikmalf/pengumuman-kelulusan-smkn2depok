<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PengumumanLog_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Pastikan database terhubung
    }

    // Simpan log saat siswa melihat pengumuman, hindari duplikasi
    public function simpan_log($id_siswa) {
        if ($this->sudah_melihat_pengumuman($id_siswa)) {
            return false; // Jika sudah melihat, cukup update waktu
        }

        $data = [
            'id_siswa'    => $id_siswa,
            'waktu_lihat' => date('Y-m-d H:i:s')
        ];

        return $this->db->insert('pengumuman_log', $data);
    }

    // Cek apakah siswa sudah melihat pengumuman
    public function sudah_melihat_pengumuman($id_siswa) {
        $this->db->where('id_siswa', $id_siswa);
        $query = $this->db->get('pengumuman_log');
        return $query->num_rows() > 0;
    }

    // Perbarui waktu jika siswa sudah pernah melihat pengumuman
    public function update_waktu_lihat($id_siswa) {
        $this->db->where('id_siswa', $id_siswa);
        $update = $this->db->update('pengumuman_log', ['waktu_lihat' => date('Y-m-d H:i:s')]);
        return $update ? true : false; // Pastikan update berhasil
    }

    // Ambil jumlah siswa yang sudah melihat pengumuman
    public function get_siswa_sudah_melihat() {
        return $this->db->count_all('pengumuman_log');
    }

    // Ambil total siswa dari tabel siswa
    public function get_total_siswa() {
        $query = $this->db->count_all('siswa');
        return $query ? $query : 0; // Pastikan nilai tidak null
    }

    public function get_status_siswa() {
        $this->db->select("siswa.id, siswa.nama, siswa.nis, siswa.nisn, siswa.tanggal_lahir, siswa.kelas, 
                            siswa.pesan, siswa.link_google_drive, siswa.status, 
                            IF(pengumuman_log.id_siswa IS NOT NULL, 'Sudah Melihat', 'Belum Melihat') AS status2", false);
        $this->db->from('siswa');
        $this->db->join('pengumuman_log', 'siswa.id = pengumuman_log.id_siswa', 'left');
        return $this->db->get()->result_array();
    }    

    public function reset_status_melihat($siswa_id) {
        $this->db->where('id_siswa', $siswa_id); // gunakan nama kolom yg benar
        return $this->db->delete('pengumuman_log');
    }

    public function getSekolah()
    {
        return $this->db->get_where('sekolah', ['id' => 1])->row_array(); // ambil sekolah aktif atau default
    }
    
       
    
}

