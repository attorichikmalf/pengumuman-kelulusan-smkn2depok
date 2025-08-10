<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Load model yang diperlukan
        $this->load->model('admin/PengumumanLog_model'); // Pastikan model ini ada
        $this->load->model('admin/Sekolah_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation'); // Load form validation library

        // Cek apakah admin sudah login
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/auth/login');

        }
    }

    public function index() {
        // Ambil data statistik dari PengumumanLog_model
        $total_siswa = $this->PengumumanLog_model->get_total_siswa();
        $sudah_melihat = $this->PengumumanLog_model->get_siswa_sudah_melihat();
        $belum_melihat = ($total_siswa !== null && $sudah_melihat !== null) ? $total_siswa - $sudah_melihat : 0;

        // Kirim data ke view
        $data = [
            'total_siswa' => $total_siswa,
            'sudah_melihat' => $sudah_melihat,
            'belum_melihat' => $belum_melihat,
            'sekolah'=> $this->Sekolah_model->getSekolah()
        ];

        $this->load->view('admin/dashboard', $data);
    }
    
    public function statistik_pengumuman() {
        // Hitung total siswa
        $total_siswa = intval($this->db->count_all('siswa'));
    
        // Hitung jumlah siswa yang sudah melihat pengumuman
        $this->db->where('sudah_melihat', 1);
        $sudah_melihat = intval($this->db->count_all_results('siswa'));
    
        // Hitung jumlah siswa yang belum melihat pengumuman
        $belum_melihat = max(0, $total_siswa - $sudah_melihat);
    
        // Data untuk dikirim ke view
        $data = [
            'total_siswa' => $total_siswa,
            'sudah_melihat' => $sudah_melihat,
            'belum_melihat' => $belum_melihat
        ];
    
        // Jika ini permintaan AJAX, kirimkan data JSON
        if ($this->input->is_ajax_request()) {
            echo json_encode($data);
            return;
        }
    
        // Load view
        $this->load->view('admin/statistik_pengumuman', $data);
    }
    
}
