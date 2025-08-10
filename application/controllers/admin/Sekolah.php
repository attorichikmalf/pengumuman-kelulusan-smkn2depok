<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekolah extends CI_Controller {
    public function __construct() {
        parent::__construct();

        // Load library dan helper
        $this->load->library(array('session', 'form_validation', 'upload'));
        $this->load->helper(array('url', 'form'));
        


        // Load model
        $this->load->model('admin/Sekolah_model');
        
        

        // Proteksi akses: Harus login sebagai admin
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/auth/login');

        }
    }

    // Menampilkan daftar sekolah
    public function index() {
        $data['list_sekolah'] = $this->Sekolah_model->getAllSekolah(); // untuk list
        $data['sekolah'] = $this->Sekolah_model->getSekolah(); // untuk logo, nama, dsb
        
        
        $this->load->view('admin/sekolah/index', $data);
        
    }

    // Menampilkan form edit sekolah
    public function edit($id) {
        $data['sekolah'] = $this->Sekolah_model->getSekolahById($id);
        
        if (!$data['sekolah']) {
            show_404(); // Jika data tidak ditemukan
        }

        $this->load->view('admin/sekolah/edit', $data);
    }

    // Proses update sekolah
    public function update($id)
{
    $this->form_validation->set_rules('nama_sekolah', 'Nama Sekolah', 'required');
    $this->form_validation->set_rules('npsn', 'NPSN', 'required');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');
    $this->form_validation->set_rules('kota', 'Kota', 'required');
    $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->edit($id);
    } else {
        $data = [
            'nama_sekolah' => $this->input->post('nama_sekolah'),
            'npsn'         => $this->input->post('npsn'),
            'alamat'       => $this->input->post('alamat'),
            'kota'         => $this->input->post('kota'),
            'provinsi'     => $this->input->post('provinsi'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        $sekolah = $this->Sekolah_model->getSekolahById($id);

        // Proses upload logo
        if (!empty($_FILES['logo']['name'])) {
            $config['upload_path']   = './uploads/logo/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 2048;
            $config['file_name']     = 'logo_' . time();
            $config['overwrite']     = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('logo')) {
                $uploadData = $this->upload->data();
                $data['logo'] = $uploadData['file_name'];

                if ($sekolah && !empty($sekolah['logo']) && file_exists('./uploads/logo/' . $sekolah['logo'])) {
                    unlink('./uploads/logo/' . $sekolah['logo']);
                }
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', 'Gagal upload logo: ' . $error);
                redirect('admin/sekolah/edit/' . $id);
                return;
            }
        }

        // Proses upload background
        if (!empty($_FILES['background']['name'])) {
            $config['upload_path']   = './uploads/background/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 3072; // Maks 3MB
            $config['file_name']     = 'background_' . time();
            $config['overwrite']     = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('background')) {
                $uploadData = $this->upload->data();
                $data['background'] = $uploadData['file_name'];

                if ($sekolah && !empty($sekolah['background']) && file_exists('./uploads/background/' . $sekolah['background'])) {
                    unlink('./uploads/background/' . $sekolah['background']);
                }
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', 'Gagal upload background: ' . $error);
                redirect('admin/sekolah/edit/' . $id);
                return;
            }
        }

        if ($this->Sekolah_model->updateSekolah($id, $data)) {
            $this->session->set_flashdata('success', 'Data sekolah berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data sekolah.');
        }

        redirect('admin/sekolah');
    }
}

}
