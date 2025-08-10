<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/Admin_model');
        $this->load->model('admin/Sekolah_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // Menampilkan halaman login
    public function login() {
    // Ambil token dari URL
    $expected_token = $this->config->item('admin_login_token');
    $data['sekolah'] = $this->Sekolah_model->getSekolah();
    $current_token = $this->uri->segment(4); // Segment ke-4 setelah 'admin/auth/login'

    // Jika token tidak sesuai, tampilkan 404
    if ($current_token !== $expected_token) {
        show_404();
    }

    // Kirim data ke view agar $sekolah bisa digunakan
    $this->load->view('admin/login', $data);
}


    // Proses login
    public function process_login() {
        $this->load->library('form_validation');
        $data['sekolah'] = $this->Sekolah_model->getSekolah();

        // Validasi form input
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // Jika validasi gagal, kembali ke halaman login dengan pesan error
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Username dan Password wajib diisi!');
            $login_secret_url = site_url($this->config->item('admin_login_path') . '/' . $this->config->item('admin_login_token'));
            redirect($login_secret_url);
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        // Cek data login di model
        $admin = $this->Admin_model->check_login($username, $password);

        if ($admin) {
            // Jika login berhasil, buat session
            $session_data = [
                'admin_id' => $admin->id,
                'admin_username' => $admin->username,
                'admin_logged_in' => TRUE
            ];
            $this->session->set_userdata($session_data);

            // Redirect ke dashboard
            redirect('admin/dashboard');
        } else {
            // Jika login gagal
            $this->session->set_flashdata('error', 'Username atau Password salah!');
            $login_secret_url = site_url($this->config->item('admin_login_path') . '/' . $this->config->item('admin_login_token'));
            redirect($login_secret_url);

        }
    }

    

    // Logout admin
    public function logout() {
    // Hapus session yang ada
    $this->session->unset_userdata('admin_logged_in');
    $this->session->sess_destroy();

    // Redirect ke halaman login rahasia
    $login_secret_url = site_url($this->config->item('admin_login_path') . '/' . $this->config->item('admin_login_token'));
    redirect($login_secret_url);
    }
}
?>
