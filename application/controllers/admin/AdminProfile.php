<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminProfile extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('admin/Admin_model');
        $this->load->model('admin/Sekolah_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['security', 'url']);

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/auth/login');
        }
    }
    
    public function index() {

        $data['sekolah'] = $this->Sekolah_model->getSekolah();
        $admin = $this->Admin_model->get_admin_by_id($this->session->userdata('admin_id'));
        if (!$admin) {
            show_error('Data admin tidak ditemukan.', 404);
        }
        $data['admin'] = $admin;
        $this->load->view('admin/profile', $data);
    }
    
    public function update_profile() {
        $id = $this->session->userdata('admin_id');
        $admin = $this->Admin_model->get_admin_by_id($id);
        if (!$admin) {
            $this->session->set_flashdata('error', 'Data admin tidak ditemukan.');
            redirect('admin/profile');
            return;
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim|callback_username_check['.$id.']');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|callback_email_check['.$id.']');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/profile');
            return;
        }

        $data = [
            'username' => $this->input->post('username', true),
            'email' => $this->input->post('email', true),
            'nama' => $this->input->post('nama', true)
        ];
        
        if ($this->Admin_model->update_profile($id, $data)) {
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
        }
        redirect('admin/profile');
    }

    public function change_password() {
        $id = $this->session->userdata('admin_id');
        if (!$id) {
            redirect('admin/login');
            return;
        }

        $data['sekolah'] = $this->Sekolah_model->getSekolah();

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('old_password', 'Password Lama', 'required');
            $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $admin = $this->Admin_model->get_admin_by_id($id);
                if (!$admin) {
                    $this->session->set_flashdata('error', 'Data admin tidak ditemukan.');
                } elseif (!password_verify($this->input->post('old_password'), $admin->password)) {
                    $this->session->set_flashdata('error', 'Password lama salah.');
                } else {
                    $new_password = $this->input->post('new_password');
                    if (password_verify($new_password, $admin->password)) {
                        $this->session->set_flashdata('error', 'Password baru tidak boleh sama dengan password lama.');
                    } else {
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        if ($this->Admin_model->update_password($id, $hashed_password)) {
                            $this->session->set_flashdata('success', 'Password berhasil diubah.');
                            redirect('admin/profile');
                            return;
                        } else {
                            $this->session->set_flashdata('error', 'Gagal mengubah password.');
                        }
                    }
                }
            }
            redirect('admin/profile/change_password');
        }

        $this->load->view('admin/change_password', $data);
    }

    
    public function manage_admin() {
        $data['admins'] = $this->Admin_model->get_all_admins();
        $data['sekolah'] = $this->Sekolah_model->getSekolah();
        $this->load->view('admin/manage_admin', $data);
        
    }

    public function delete_admin($id) {
        if ($id != $this->session->userdata('admin_id')) {
            if ($this->Admin_model->delete_admin($id)) {
                $this->session->set_flashdata('success', 'Admin berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus admin.');
            }
        } else {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus akun sendiri.');
        }
        redirect('admin/profile/manage_admin');
    }
    
    public function add_admin() {
        $data['sekolah'] = $this->Sekolah_model->getSekolah();
        $this->load->view('admin/add_admin', $data);
    }

    
    public function save_admin() {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[admin.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[admin.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        
        if ($this->form_validation->run() == FALSE) {
            
            $data['sekolah'] = $this->Sekolah_model->getSekolah();
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/profile/add_admin');
        }
        
        $data = [
            'nama' => $this->input->post('nama'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
        ];
        
        if ($this->Admin_model->add_admin($data)) {
            $this->session->set_flashdata('success', 'Admin berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan admin.');
        }
        redirect('admin/profile/manage_admin');
    }
    
    public function username_check($username, $id) {
        $admin = $this->Admin_model->get_by_username($username);
        if ($admin && $admin->id != $id) {
            $this->form_validation->set_message('username_check', 'Username sudah digunakan oleh admin lain.');
            return false;
        }
        return true;
    }
    
    public function email_check($email, $id) {
        $admin = $this->Admin_model->get_by_email($email);
        if ($admin && $admin->id != $id) {
            $this->form_validation->set_message('email_check', 'Email sudah digunakan oleh admin lain.');
            return false;
        }
        return true;
    }
}
