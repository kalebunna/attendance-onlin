<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Dashboard extends REST_Controller
{
    public function index_post()
    {
        date_default_timezone_set('Asia/Jakarta');
        // cek sudah absen pulang
        $iduser = $this->post("id");
        $where = [
            "absensi_karyawan.id_users" => $iduser,
            "absensi.tgl" => date("Y-m-d"),
            "absensi_karyawan.in_out" => "Masuk"
        ];
        $this->db->where($where);
        $this->db->join("absensi", "absensi.id_absen=absensi_karyawan.id_absensi");
        $masuk = $this->db->get("absensi_karyawan")->num_rows();
        if ($masuk > 0) {
            $absen_masuk = true;
        } else {
            $absen_masuk = false;
        }

        $where = [
            "absensi_karyawan.id_users" => $iduser,
            "absensi.tgl" => date("Y-m-d"),
            "absensi_karyawan.in_out" => "Keluar"
        ];
        $this->db->where($where);
        $this->db->join("absensi", "absensi.id_absen=absensi_karyawan.id_absensi");
        $keluar = $this->db->get("absensi_karyawan")->num_rows();
        if ($keluar > 0) {
            $absenKeluar = true;
        } else {
            $absenKeluar = false;
        }

        $data = array(
            "masuk" => $absen_masuk,
            "keluar" => $absenKeluar
        );

        $this->response($data);
    }

    public function get_history_post()
    {
        $this->db->trans_start();
        $this->db->where("Month(tgl)", date('m'));
        $this->db->where("Year(tgl)", date('Y'));
        $result = $this->db->get("absensi")->result();
        $all_result = array();
        foreach ($result as $key) {
            $dataResult["tanhgal"] = $key->tgl;
            // ambil data masuk
            $where = [
                "id_users" => $this->post("id"),
                "id_absensi" => $key->id_absen,
                "in_out" => "Masuk"
            ];
            $this->db->where($where);
            $this->db->limit(1);
            $tempmasuk = $this->db->get("absensi_karyawan")->row();
            $dataResult["jammasuk"] = $tempmasuk->jam;
            $dataResult["kemlabat"] = $tempmasuk->ket_lambar = true ? "Terlambat" : "OK";
            $dataResult["selisih"] = $tempmasuk->selisih;

            $where = [
                "id_users" => $this->post("id"),
                "id_absensi" => $key->id_absen,
                "in_out" => "Keluar"
            ];
            $this->db->where($where);
            $this->db->limit(1);
            $keluar = $this->db->get("absensi_karyawan")->row();
            print_r($keluar);
            $dataResult["jam_keluar"] = $keluar->jam;
            array_push($all_result, $dataResult);
        }
        $this->response(array('ss' => $all_result));
    }
}
