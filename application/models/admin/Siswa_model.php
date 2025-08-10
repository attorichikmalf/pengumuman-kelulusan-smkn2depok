<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_siswa($search = null, $sort = 'nama', $order = 'asc') {
        $this->db->select('*');
        $this->db->from('siswa');

        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('kelas', $search);
            $this->db->or_like('nisn', $search);
            $this->db->group_end();
        }

        $valid_columns = ['id', 'nama', 'kelas', 'status'];
        $this->db->order_by(in_array($sort, $valid_columns) ? $sort : 'nama', $order === 'desc' ? 'desc' : 'asc');

        return $this->db->get()->result_array();
    }

    public function get_siswa_by_id($id) {
        return $this->db->get_where('siswa', ['id' => $id])->row_array();
    }

    public function insert_siswa($data) {
        return $this->db->insert('siswa', $data);
    }

    public function insert_batch_siswa($data) {
        return $this->db->insert_batch('siswa', $data);
    }

    public function update_siswa($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('siswa', $data);
    }

    public function delete_siswa($id) {
        $this->db->where('id', $id);
        return $this->db->delete('siswa');
    }

    public function count_all($search = null) {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('nisn', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results('siswa');
    }

    public function get_siswa($limit, $offset, $search = null, $sort = 'nama', $order = 'asc') {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('kelas', $search);
            $this->db->or_like('nisn', $search);
            $this->db->group_end();
        }

        $valid_columns = ['id', 'nama', 'kelas', 'status'];
        $this->db->order_by(in_array($sort, $valid_columns) ? $sort : 'nama', $order === 'desc' ? 'desc' : 'asc');

        $this->db->limit($limit, $offset);
        return $this->db->get('siswa')->result_array();
    }

    // public function get_by_nisn($nisn) {
    //     return $this->db->get_where('siswa', ['nisn' => $nisn])->row_array();
    // }
    
    // public function get_by_nis($nis) {
    //     return $this->db->get_where('siswa', ['nis' => $nis])->row_array();
    // }
    
    // public function cek_duplikat_siswa($nisn, $nis) {
    //     // Cek apakah ada siswa dengan NISN atau NIS yang duplikat
    //     $this->db->select('id, nama, nisn, nis');
    //     $this->db->group_start()
    //         ->where('nisn', $nisn)
    //         ->or_where('nis', $nis)
    //     ->group_end();
    
    //     // Eksekusi query untuk mencari duplikat
    //     $query = $this->db->get('siswa');
    
    //     // Jika ada duplikat, kembalikan data siswa yang duplikat
    //     if ($query->num_rows() > 0) {
    //         return $query->row_array(); // Mengembalikan data siswa yang ditemukan duplikatnya
    //     }
    
    //     // Tidak ditemukan duplikat
    //     return null;
    // }

    public function cek_duplikat_siswa($nisn, $nis)
    {
        return $this->db
            ->group_start()
                ->where('nisn', $nisn)
                ->or_where('nis', $nis)
            ->group_end()
            ->get('siswa')
            ->row_array();
    }

    public function get_by_nisn_or_nis_except($nisn, $nis, $id) {
        return $this->db->where('id !=', $id)
                        ->group_start()
                            ->where('nisn', $nisn)
                            ->or_where('nis', $nis)
                        ->group_end()
                        ->get('siswa')
                        ->row_array();
    }

    public function get_by_nisn_or_nis($nisn, $nis) {
        return $this->db->group_start()
                        ->where('nisn', $nisn)
                        ->or_where('nis', $nis)
                        ->group_end()
                        ->get('siswa')
                        ->row_array();
    }

    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('siswa');  // Ganti 'siswa' dengan nama tabel yang sesuai
        return $query->row_array();
    }

    public function getSekolah()
    {
        return $this->db->get_where('sekolah', ['id' => 1])->row_array(); // ambil sekolah aktif atau default
    }

}
