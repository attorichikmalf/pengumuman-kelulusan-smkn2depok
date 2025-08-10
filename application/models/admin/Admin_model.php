<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Cek login admin
    public function check_login($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('admin');

        if ($query->num_rows() == 1) {
            $admin = $query->row();
            if (password_verify($password, $admin->password)) {
                return $admin;
            }
        }
        return false;
    }

    // Tambah admin baru
    public function create_admin($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('admin', $data);
    }

    // Ambil data admin berdasarkan ID
    public function get_admin_by_id($id) {
        $query = $this->db->get_where('admin', ['id' => $id]);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    // Update profil admin
    public function update_profile($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('admin', $data);
    }

    // Ganti password admin
    public function change_password($id, $new_password) {
        $data = ['password' => password_hash($new_password, PASSWORD_DEFAULT)];
        $this->db->where('id', $id);
        return $this->db->update('admin', $data);
    }

    // Cek ketersediaan username
    public function is_username_available($username, $id = null) {
        $this->db->where('username', $username);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        return $this->db->get('admin')->num_rows() == 0;
    }

    // Cek ketersediaan email
    public function is_email_available($email, $id = null) {
        $this->db->where('email', $email);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        return $this->db->get('admin')->num_rows() == 0;
    }

    // Ambil semua admin
    public function get_all_admins() {
        $query = $this->db->get('admin'); 
        return $query->num_rows() > 0 ? $query->result() : []; // Menghindari nilai null
    }
    
    // Hapus admin (tidak bisa hapus diri sendiri)
    public function delete_admin($id) {
        $current_admin_id = $this->session->userdata('admin_id');
        if ($id == $current_admin_id) {
            return false;
        }
        return $this->db->delete('admin', ['id' => $id]);
    }

    // Hitung jumlah admin
    public function count_admins() {
        return $this->db->count_all('admin');
    }

    public function add_admin($data) {
        return $this->db->insert('admin', $data);
    }

    public function update_password($id, $new_password) {
        $this->db->set('password', $new_password);
        $this->db->where('id', $id);
        return $this->db->update('admin'); // Pastikan tabelnya benar!
    }

    public function get_by_username($username) {
        return $this->db->get_where('admin', ['username' => $username])->row();
    }
    
    public function get_by_email($email) {
        return $this->db->get_where('admin', ['email' => $email])->row();
    }

    public function getSekolah()
    {
        return $this->db->get_where('sekolah', ['id' => 1])->row_array(); // ambil sekolah aktif atau default
    }
    
    
    
}