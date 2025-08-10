<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('admin/Sekolah_model');

        // Pastikan hanya admin yang bisa mengakses halaman ini
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/auth/login');
        }
    }

    // Halaman Dashboard
    public function dashboard() {
        $data['title'] = "Dashboard Admin"; // Opsional: Tambahkan judul halaman
        $data['sekolah'] = $this->Sekolah_model->getSekolah();
        $this->load->view('admin/dashboard', $data);

    }

    // Logout Admin
    public function logout() {
        $this->session->unset_userdata('admin_logged_in');
        $this->session->set_flashdata('success', 'Anda telah logout.');
        redirect('admin/auth/login');
    }
}
?>
