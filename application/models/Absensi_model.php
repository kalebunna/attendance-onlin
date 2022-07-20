<?php
defined('BASEPATH') or die('No direct script access allowed!');

class Absensi_model extends CI_Model
{
    public function get_absen($id_user, $bulan, $tahun)
    {
        $this->db->join("absensi", "absensi.id_absen=a.id_absensi");
        // $this->db->select("DATE_FORMAT(absensi.tgl, '%d-%m-%Y') AS tgl, a.jam AS jam_masuk, (SELECT waktu FROM absensi al WHERE al.tgl = a.tgl AND id_user = '6' AND al.keterangan != a.keterangan) AS jam_pulang");
        $this->db->select("DATE_FORMAT(absensi.tgl, '%d-%m-%Y') AS tgl,  a.jam AS jam_masuk, (SELECT jam FROM absensi_karyawan ak where ak.id_absensi=a.id_absensi AND in_OUT='Keluar' )AS jam_pulang ");
        $this->db->where('id_users', $id_user);
        $this->db->where("DATE_FORMAT(tgl, '%m') = ", $bulan);
        $this->db->where("DATE_FORMAT(tgl, '%Y') = ", $tahun);
        $this->db->where("in_out", "Masuk");
        // $this->db->group_by("tgl");
        $result = $this->db->get('absensi_karyawan a');
        return $result->result_array();
    }

    public function absen_harian_user($id_user)
    {
        $today = date('Y-m-d');
        $this->db->join("absensi", "absensi.id_absen=absensi_karyawan.id_absensi");
        $this->db->where('absensi.tgl', $today);
        $this->db->where('absensi_karyawan.id_users', $id_user);
        $data = $this->db->get('absensi_karyawan');
        return $data;
    }

    public function insert_data($data)
    {
        $result = $this->db->insert('absensi_karyawan', $data);
        return $result;
    }

    public function get_jam_by_time($time)
    {
        $this->db->where('start', $time, '<=');
        $this->db->or_where('finish', $time, '>=');
        $data = $this->db->get('jam');
        return $data->row();
    }

    public function cek_if_today_already_exist($today)
    {
        $this->db->where($today);
        $this->db->limit(1);
        $row = $this->db->get("absensi");
        if ($row->num_rows() > 0) {
            return $row->row()->id_absen;
        } else {
            $datainput = [
                "tgl" => date("Y-m-d")
            ];
            $this->db->insert("absensi", $datainput);
            return $this->db->insert_id();
        }
    }
}



/* End of File: d:\Ampps\www\project\absen-pegawai\application\models\Absensi_model.php */