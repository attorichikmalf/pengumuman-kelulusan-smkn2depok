<?php
class Log_pengumuman_model extends CI_Model
{
    public function simpan_log_gagal($data)
    {
        return $this->db->insert('log_pengumuman_gagal', $data);
    }
}
