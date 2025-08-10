<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Cek kelulusan siswa berdasarkan NISN, NIS, dan Tanggal Lahir
     */
    public function cek_kelulusan($nisn, $nis, $tanggal_lahir) {
        $this->db->where('tanggal_lahir', $tanggal_lahir);
        
        if (!empty($nisn)) {
            $this->db->where('nisn', $nisn);
        } elseif (!empty($nis)) {
            $this->db->where('nis', $nis);
        }

        return $this->db->get('siswa')->row(); // Langsung kembalikan objek siswa
    }

    /**
     * Menghitung total siswa
     */
    public function get_total_siswa() {
        return $this->db->count_all('siswa');
    }

    /**
     * Menghitung jumlah siswa yang sudah melihat pengumuman
     * Sekarang diambil dari tabel pengumuman_log untuk keakuratan
     */
    public function get_siswa_sudah_melihat() {
        return $this->db->count_all('pengumuman_log'); // Mengambil dari log, bukan kolom 'sudah_melihat'
    }

    /**
     * Menghitung jumlah siswa yang belum melihat pengumuman
     */
    public function get_siswa_belum_melihat() {
        $total_siswa = $this->get_total_siswa();
        $siswa_sudah_melihat = $this->get_siswa_sudah_melihat();
        return $total_siswa - $siswa_sudah_melihat;
    }

    /**
     * Update status siswa bahwa dia sudah melihat pengumuman
     */
    public function update_status_melihat($id_siswa) {
        $this->db->where('id', $id_siswa);
        return $this->db->update('siswa', ['sudah_melihat' => 1]);
    }

    public function get_siswa_by_nisn_or_nis($nisn, $nis) {
        // Mencari siswa berdasarkan nisn atau nis
        $this->db->group_start();
        if (!empty($nisn)) {
            $this->db->where('nisn', $nisn);
        }
        if (!empty($nis)) {
            $this->db->or_where('nis', $nis);
        }
        $this->db->group_end();
        return $this->db->get('siswa')->row(); // Mengambil 1 siswa yang cocok
    }
    

    public function simpan_log_pengumuman_gagal($ip_address, $nisn, $nis, $tanggal_lahir_input, $status_cocok, $nama_diduga, $id_siswa) {
        // Data yang akan disimpan ke dalam tabel log_pengumuman_gagal
        $data = [
            'ip_address' => $ip_address,
            'nisn' => $nisn,
            'nis' => $nis,
            'tanggal_lahir_input' => $tanggal_lahir_input,
            'status_cocok' => $status_cocok,
            'nama_diduga' => $nama_diduga,
            'id_siswa' => $id_siswa,
            'created_at' => date('Y-m-d H:i:s') // Waktu log disimpan
        ];
    
        // Insert ke tabel log_pengumuman_gagal
        return $this->db->insert('log_pengumuman_gagal', $data);
    }

    
    
    
}
