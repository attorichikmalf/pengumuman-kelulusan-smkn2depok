<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Siswa extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('admin/Siswa_model');
        $this->load->model('admin/Sekolah_model');
        $this->load->library(array('session', 'form_validation', 'upload'));
        $this->load->helper(array('url', 'form'));
        $this->load->model('admin/PengumumanLog_model', 'logModel');
        

        // Cek apakah admin sudah login
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/auth/login');

        }
    }

    public function index()
    {
        $data['sekolah'] = $this->Sekolah_model->getSekolah();
        // Ambil parameter dari URL
        $search = $this->input->get('search');
        $limit_input = $this->input->get('limit');
        $sort = $this->input->get('sort') ?: 'nama';
        $order = $this->input->get('order') ?: 'asc';
        $offset = $this->input->get('per_page') ?: 0;

        // Validasi limit
        $valid_limits = ['25', '50', '100', 'all'];
        $limit = in_array($limit_input, $valid_limits) ? $limit_input : '25';

        // Hitung total rows
        $total_rows = $this->Siswa_model->count_all($search);

        $this->load->library('pagination');

        // Konfigurasi pagination
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'per_page';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = ($limit === 'all') ? $total_rows : (int)$limit;

        // Bangun query string dasar
        $query_string = [
            'search' => $search,
            'limit' => $limit,
            'sort' => $sort,
            'order' => $order
        ];
        $config['base_url'] = site_url('admin/siswa/index') . '?' . http_build_query($query_string);

        // Styling Bootstrap
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        // Ambil data siswa sesuai kebutuhan sort dan limit
        if ($limit === 'all' || $sort === 'status2') {
            // Ambil semua siswa (tanpa limit)
            $siswa_data = $this->Siswa_model->get_all_siswa($search);

            // Tambah status2
            foreach ($siswa_data as &$siswa) {
                $siswa['status2'] = $this->logModel->sudah_melihat_pengumuman($siswa['id']) ? 'Sudah Melihat' : 'Belum Melihat';
            }

            // Sorting manual
            usort($siswa_data, function ($a, $b) use ($sort, $order) {
                $valA = $a[$sort] ?? '';
                $valB = $b[$sort] ?? '';
                return ($order === 'asc') ? strcmp($valA, $valB) : strcmp($valB, $valA);
            });

            // Potong hasil jika bukan limit 'all'
            if ($limit !== 'all') {
                $siswa_data = array_slice($siswa_data, $offset, (int)$limit);
            }
        } else {
            // Ambil data terbatas dari DB langsung
            $siswa_data = $this->Siswa_model->get_siswa((int)$limit, $offset, $search, $sort, $order);

            foreach ($siswa_data as &$siswa) {
                $siswa['status2'] = $this->logModel->sudah_melihat_pengumuman($siswa['id']) ? 'Sudah Melihat' : 'Belum Melihat';
            }
        }

        // Kirim ke view
        $data = [
            'siswa' => $siswa_data,
            'pagination' => $this->pagination->create_links(),
            'order' => $order,
            'sort' => $sort,
            'limit' => $limit,
            'total_rows' => $total_rows,
            'search' => $search,
            'sekolah' => $this->Sekolah_model->getSekolah()
        ];

        $this->load->view('admin/siswa/index', $data);
    }

    
    

    public function tambah() {
        $this->load->view('admin/siswa/form');
    }

    public function edit($id) {
        // Ambil data siswa berdasarkan ID
        $data['siswa'] = (object) $this->Siswa_model->get_siswa_by_id($id);

        // Jika tidak ditemukan, tampilkan 404
        if (!$data['siswa']) {
            show_404();
        }

        $this->load->view('admin/siswa/form', $data);
    }

    public function update($id)
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');
        $this->form_validation->set_rules('nisn', 'NISN', 'required|numeric|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/siswa/edit/' . $id);
        } else {
            $nisn = $this->input->post('nisn', true);
            $nis = $this->input->post('nis', true);

            // Cek apakah NISN atau NIS sudah digunakan oleh siswa lain
            $siswa_lain = $this->Siswa_model->get_by_nisn_or_nis_except($nisn, $nis, $id);
            if ($siswa_lain) {
                $error_msg = '';
                if ($siswa_lain['nisn'] == $nisn) {
                    $error_msg .= "NISN <b>{$nisn}</b> sudah digunakan oleh <b>{$siswa_lain['nama']}</b>.<br>";
                }
                if ($siswa_lain['nis'] == $nis) {
                    $error_msg .= "NIS <b>{$nis}</b> sudah digunakan oleh <b>{$siswa_lain['nama']}</b>.";
                }
                $this->session->set_flashdata('error', $error_msg);
                redirect('admin/siswa/edit/' . $id);
                return;
            }

            $data = [
                'nama' => $this->input->post('nama', true),
                'kelas' => $this->input->post('kelas', true),
                'nisn' => $nisn,
                'nis' => $nis,
                'tanggal_lahir' => $this->input->post('tanggal_lahir', true),
                'pesan' => $this->input->post('pesan', true),
                'link_google_drive' => $this->input->post('link_google_drive', true),
                'status' => $this->input->post('status', true),
                'update_at' => date('Y-m-d H:i:s')
            ];

            // Ambil data lama siswa sebelum update
            $siswa_lama = $this->Siswa_model->get_by_id($id);

            // Variabel untuk mengecek apakah ada perubahan
            $perubahan_ditemukan = false;

            if ($this->Siswa_model->update_siswa($id, $data)) {
                // Cek perubahan pada data
                $info_perubahan = 'Data siswa berhasil diperbarui!<br>';

                // Tampilkan Nama Siswa dengan warna
                $info_perubahan .= '<b style="color: blue;">Nama: ' . $data['nama'] . '</b><br>';

                // Bandingkan dan tampilkan hanya yang berubah
                if ($siswa_lama['kelas'] != $data['kelas']) {
                    $info_perubahan .= '<span style="color: green;"><b>Kelas:</b> ' . $data['kelas'] . '</span><br>';
                    $perubahan_ditemukan = true;
                }
                if ($siswa_lama['nisn'] != $data['nisn']) {
                    $info_perubahan .= '<span style="color: green;"><b>NISN:</b> ' . $data['nisn'] . '</span><br>';
                    $perubahan_ditemukan = true;
                }
                if ($siswa_lama['nis'] != $data['nis']) {
                    $info_perubahan .= '<span style="color: green;"><b>NIS:</b> ' . $data['nis'] . '</span><br>';
                    $perubahan_ditemukan = true;
                }
                if ($siswa_lama['tanggal_lahir'] != $data['tanggal_lahir']) {
                    $info_perubahan .= '<span style="color: green;"><b>Tanggal Lahir:</b> ' . date('d-m-Y', strtotime($data['tanggal_lahir'])) . '</span><br>';
                    $perubahan_ditemukan = true;
                }
                if ($siswa_lama['pesan'] != $data['pesan']) {
                    $info_perubahan .= '<span style="color: green;"><b>Pesan:</b> ' . $data['pesan'] . '</span><br>';
                    $perubahan_ditemukan = true;
                }
                if ($siswa_lama['link_google_drive'] != $data['link_google_drive']) {
                    $info_perubahan .= '<span style="color: green;"><b>Link Google Drive:</b> <a href="' . $data['link_google_drive'] . '" target="_blank">Lihat Dokumen</a></span><br>';
                    $perubahan_ditemukan = true;
                }
                if ($siswa_lama['status'] != $data['status']) {
                    $info_perubahan .= '<span style="color: green;"><b>Status:</b> ' . $data['status'] . '</span><br>';
                    $perubahan_ditemukan = true;
                }

                // Jika ada perubahan, reset status melihat pengumuman
                if ($perubahan_ditemukan) {
                    // Reset status melihat pengumuman hanya jika ada perubahan
                    $this->logModel->reset_status_melihat($id);
                    $info_perubahan .= '<span class="text-danger"><b>Status melihat pengumuman telah di-reset menjadi: Belum Melihat</b></span>';
                } else {
                    // Jika tidak ada perubahan, tampilkan pesan bahwa tidak ada perubahan
                    $info_perubahan = '<span style="color: orange;">Data siswa tidak ada perubahan.</span>';
                }

                // Set flashdata dengan perubahan yang berhasil
                $this->session->set_flashdata('success', $info_perubahan);
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data siswa.');
            }

            redirect('admin/siswa');
        }
    }
    
    
    
    public function simpan() {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');
        $this->form_validation->set_rules('nis', 'NIS', 'required|numeric|trim');
        $this->form_validation->set_rules('nisn', 'NISN', 'required|numeric|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/siswa/tambah');
        } else {
            $nisn = $this->input->post('nisn', true);
            $nis  = $this->input->post('nis', true);
    
            // Cek jika sudah ada NISN atau NIS di database
            $siswa_lain = $this->Siswa_model->get_by_nisn_or_nis($nisn, $nis);
            if ($siswa_lain) {
                $error_msg = '';
                if ($siswa_lain['nisn'] == $nisn) {
                    $error_msg .= "NISN <b>{$nisn}</b> sudah digunakan oleh <b>{$siswa_lain['nama']}</b>.<br>";
                }
                if ($siswa_lain['nis'] == $nis) {
                    $error_msg .= "NIS <b>{$nis}</b> sudah digunakan oleh <b>{$siswa_lain['nama']}</b>.";
                }
                $this->session->set_flashdata('error', $error_msg);
                redirect('admin/siswa/tambah');
                return;
            }
    
            $data = [
                'nama' => $this->input->post('nama', true),
                'kelas' => $this->input->post('kelas', true),
                'nisn' => $nisn,
                'nis' => $nis,
                'tanggal_lahir' => $this->input->post('tanggal_lahir', true),
                'pesan' => $this->input->post('pesan', true),
                'link_google_drive' => $this->input->post('link_google_drive', true),
                'status' => $this->input->post('status', true),
                'create_at' => date('Y-m-d H:i:s'),
                'update_at' => date('Y-m-d H:i:s')
            ];
    
            $this->Siswa_model->insert_siswa($data);
            $this->session->set_flashdata('success', 'Data siswa berhasil ditambahkan!');
            redirect('admin/siswa');
        }
    }
    
    
    public function cek_nisn_update($nisn, $id) {
        $this->Siswa_model->cek_duplikat_siswa($nisn, $nis);
    
        if ($siswa && $siswa->id != $id) {
            $this->form_validation->set_message('cek_nisn_update', 'NISN sudah digunakan oleh siswa lain.');
            return false;
        }
    
        return true;
    }
    

    public function delete($id) {
        // Ambil data siswa sebelum dihapus untuk mendapatkan nama
        $siswa = $this->Siswa_model->get_by_id($id);
        
        // Cek jika siswa ditemukan
        if ($siswa) {
            // Proses penghapusan data siswa
            if ($this->Siswa_model->delete_siswa($id)) {
                $this->session->set_flashdata('success', 'Data siswa <b>' . $siswa['nama'] . '</b> berhasil dihapus!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus data siswa.');
            }
        } else {
            $this->session->set_flashdata('error', 'Siswa tidak ditemukan.');
        }
        
        redirect('admin/siswa');
    }
    

    public function proses_import()
    {
        $config['upload_path']   = FCPATH . 'uploads/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size']      = 2048;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file_excel')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('admin/siswa');
            return;
        }

        $file = $this->upload->data();
        $file_path = $config['upload_path'] . $file['file_name'];

        try {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file_path);
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $data_import = [];
            $duplikat_data = [];

            $existing_nisn = [];
            $existing_nis = [];

            foreach ($sheet as $index => $row) {
                if ($index == 1) continue; // Skip header

                $nama = trim($row['A']);
                $kelas = trim($row['B']);
                $nisn = trim($row['C']);
                $nis = trim($row['D']);
                $tanggal_lahir = trim($row['E']);
                $pesan = isset($row['F']) ? trim($row['F']) : '';
                $link_google_drive = isset($row['G']) ? trim($row['G']) : '';
                $status = trim($row['H']);

                if (!empty($nama) && !empty($nisn) && !empty($nis) && !empty($tanggal_lahir) && !empty($status)) {

                    // Duplikat di file Excel
                    if (isset($existing_nisn[$nisn])) {
                        $duplikat_data[] = "Baris {$index}: <b>{$nama}</b> memiliki NISN yang sama dengan <b>{$existing_nisn[$nisn]}</b> (NISN: {$nisn}) di file Excel.";
                        continue;
                    }
                    if (isset($existing_nis[$nis])) {
                        $duplikat_data[] = "Baris {$index}: <b>{$nama}</b> memiliki NIS yang sama dengan <b>{$existing_nis[$nis]}</b> (NIS: {$nis}) di file Excel.";
                        continue;
                    }

                    // Simpan nama untuk validasi internal
                    $existing_nisn[$nisn] = $nama;
                    $existing_nis[$nis] = $nama;

                    // Duplikat di database
                    if ($this->Siswa_model->cek_duplikat_siswa($nisn, $nis)) {
                        $duplikat_data[] = "Baris {$index}: <b>{$nama}</b> (NISN: {$nisn}, NIS: {$nis}) sudah terdaftar di database.";
                        continue;
                    }

                    // Format tanggal
                    $tanggal_lahir_format = date('Y-m-d', strtotime($tanggal_lahir));

                    $data_import[] = [
                        'nama' => $nama,
                        'kelas' => $kelas,
                        'nisn' => $nisn,
                        'nis' => $nis,
                        'tanggal_lahir' => $tanggal_lahir_format,
                        'pesan' => $pesan,
                        'link_google_drive' => $link_google_drive,
                        'status' => $status,
                        'create_at' => date('Y-m-d H:i:s'),
                        'update_at' => date('Y-m-d H:i:s')
                    ];
                }
            }

            @unlink($file_path); // Hapus file setelah diproses

            $jumlah_import = count($data_import);
            $jumlah_duplikat = count($duplikat_data);

            if ($jumlah_import > 0) {
                $this->Siswa_model->insert_batch_siswa($data_import);
            }

            // Notifikasi
            if ($jumlah_import > 0) {
                $this->session->set_flashdata('success', "✅ <b>{$jumlah_import}</b> data berhasil diimport.");
            }

            if ($jumlah_duplikat > 0) {
                $duplikat_html = "<b>Detail duplikat:</b><br>" . implode("<br>", $duplikat_data);
                $this->session->set_flashdata('error', "⚠️ <b>{$jumlah_duplikat}</b> data tidak dimasukkan karena duplikat.<br><br>{$duplikat_html}");
            }

            if ($jumlah_import == 0 && $jumlah_duplikat == 0) {
                $this->session->set_flashdata('info', "Tidak ada data yang valid untuk diimport.");
            }

        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Kesalahan saat membaca file: ' . $e->getMessage());
            @unlink($file_path);
        }

        redirect('admin/siswa');
    }

    public function hapus_semua()
    {
        // Hitung jumlah data siswa sebelum dihapus
        $total_siswa = $this->db->count_all('siswa');

        // Hapus semua data dari tabel siswa
        $this->db->empty_table('siswa');

        // Reset Auto Increment ID ke 1
        $this->db->query("ALTER TABLE siswa AUTO_INCREMENT = 1");

        // Set pesan sukses dengan jumlah data yang dihapus
        $this->session->set_flashdata('success', 'Semua data siswa berhasil dihapus. Total data yang dihapus: ' . $total_siswa . '. ID dimulai dari 1 saat import.');

        // Redirect kembali ke halaman siswa
        redirect('admin/siswa');
    }

}
?>
