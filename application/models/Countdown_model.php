<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Countdown_model extends CI_Model {

    // Ambil target_time terbaru dari tabel countdown_time
    public function get_countdown_time() {
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('countdown_time'); // Pastikan tabel ini ada di database

        if ($query->num_rows() > 0) {
            return $query->row()->target_time; // Kembalikan nilai target_time
        } else {
            // Jika tabel kosong, insert default data agar tidak error
            $default_time = '2025-03-23 21:46:00';
            $this->db->insert('countdown_time', ['target_time' => $default_time]);
            return $default_time;
        }
    }

    // Fungsi untuk memperbarui waktu target countdown
    public function update_target_time($new_target_time) {
        // Periksa apakah ada data dalam tabel
        $query = $this->db->get('countdown_time');

        if ($query->num_rows() > 0) {
            // Jika ada, update record terbaru
            $this->db->set('target_time', $new_target_time);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $this->db->update('countdown_time');
        } else {
            // Jika tidak ada data, insert record baru
            $this->db->insert('countdown_time', ['target_time' => $new_target_time]);
        }

        return $this->db->affected_rows() > 0; // True jika ada perubahan data
    }
}
