<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Memuat library form_validation
        $this->load->library('form_validation');
        
        // Memuat model lainnya
        $this->load->model('Countdown_model');
        $this->load->model('admin/Sekolah_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library(array('session', 'form_validation', 'upload'));
        $this->load->helper(array('url', 'form'));
        
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/auth/login');

        }
    }

    public function index() {
        // Ambil waktu countdown dari model
        $data['countdown_time'] = $this->Countdown_model->get_countdown_time();
        $data['sekolah'] = $this->Sekolah_model->getSekolah();

        // Jika data tidak ada, set default
        if (empty($data['countdown_time'])) {
            $data['countdown_time'] = date('Y-m-d\TH:i'); // Default waktu target
        }

        // Load view pengumuman
        $this->load->view('admin/pengumuman', $data);
    }
    

    public function update_time() {
        // Set rules untuk form validation
        $this->form_validation->set_rules('target_time', 'Target Time', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, beri pesan error
            $this->session->set_flashdata('error', validation_errors());
        } else {
            // Ambil inputan dari form
            $new_target_time = $this->input->post('target_time', true);
    
            // Update target_time di model
            $this->Countdown_model->update_target_time($new_target_time);
    
            // Beri pesan sukses
            $this->session->set_flashdata('success', 'Waktu pengumuman berhasil diperbarui!');
        }
    
        // Redirect kembali ke halaman pengumuman setelah update
        redirect('admin/pengumuman');
    }
    
    

    // public function cek_pengumuman() {
    //     $nisn_or_nis = $this->input->post('nisn_or_nis'); // Bisa NIS atau NISN
    //     $tanggal_lahir = $this->input->post('tanggal_lahir');
    
    //     $hasil = $this->Pengumuman_model->cek_kelulusan($nisn_or_nis, $tanggal_lahir);
        
    //     if ($hasil) {
    //         $data['hasil'] = $hasil;
    //         $this->load->view('admin/hasil_kelulusan', $data);
    //     } else {
    //         $this->session->set_flashdata('error', 'NIS/NISN atau Tanggal Lahir tidak ditemukan!');
    //         redirect('dashboard');
    //     }
    // }
    

    
}
