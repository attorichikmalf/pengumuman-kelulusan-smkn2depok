<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Cek apakah user sudah login sebagai admin
        if (!$this->session->userdata('is_admin_login')) {
            redirect('login'); // sesuaikan dengan route login kamu
        }

        // Memuat model yang diperlukan
        $this->load->model('admin/Log_model');  // Model untuk mengambil data log
        $this->load->model('Pengumuman_model'); // Model untuk mengelola pengumuman
        $this->load->model('admin/Sekolah_model');
    }

    public function index() {
        // Judul untuk halaman log
        $data['title'] = 'Log Pengumuman Gagal';
        $data['sekolah'] = $this->Sekolah_model->getSekolah();
        
        // Mengambil data log pengumuman gagal dari model
        $data['logs'] = $this->Log_model->get_log_pengumuman_gagal();
        
        // Mengambil data siswa yang sudah melihat pengumuman
        $data['sudah_melihat'] = $this->Pengumuman_model->get_siswa_sudah_melihat();
        
        // Mengambil data siswa yang belum melihat pengumuman
        $data['belum_melihat'] = $this->Pengumuman_model->get_siswa_belum_melihat();
        
        // Mengambil total jumlah siswa
        $data['total'] = $this->Pengumuman_model->get_total_siswa();

        // Memuat tampilan halaman log dengan data yang sudah disiapkan
        $this->load->view('admin/log/index', $data);
    }
}
