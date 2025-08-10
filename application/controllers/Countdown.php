<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Countdown extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Countdown_model'); // Load model Countdown_model
        $this->load->helper('url'); // Load helper untuk redirect
    }

    public function index() {
        // Ambil data target_time dari model
        $target_time = $this->Countdown_model->get_countdown_time();

        // Jika tidak ada data, set default target_time
        if (empty($target_time)) {
            $target_time = '2025-03-23 21:46:00'; // Atur waktu default jika belum ada di database
        }

        // Kirim data ke view
        $data['target_time'] = $target_time;

        // Load view pengumuman admin dan teruskan data
        $this->load->view('admin/pengumuman', $data);
    }
}
