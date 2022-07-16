<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Scanbarcode extends RestController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->response([
            'status' => false,
            'message' => 'No such user found'
        ], 404);
    }

    public function input_absen()
    {

        // get data id hari ini
        $data_where_today = [
            "tgl" => date("Y-m-d")
        ];
        $this->db->where($data_where_today);
        $retrive_data = $this->db->get("absensi");
        if ($retrive_data->num_row() > 0) {

            $id = $retrive_data->row()->id_absen;
            // case for masuk dan keluar
            $where_case = [
                "id_users" => $this->post("id_user"),
                "id_absensi" => $id
            ];
            $this->db->where($where_case);
            $status = $this->db->get("absensi_karyawan")->num_rows();

            $input_data = [
                "id_absensi" => $id,
                "id_users" => $this->post("id_user"),
                "jam" => date("h:i:sa"),
                "in_out" => $status = (0) ? 'Masuk'  : 'Pulang',
            ];

            // pengecekan jika telah 2 kali scan
            if ($status >= 2) {
                $this->response(array('status' => 'out'));
            } else {
                $this->db->where("keterangan", $input_data['in_out']);
                $jam = $this->db->get("jam")->row();
                $jam_start = $jam->start;
                $jam_finish = $jam->finish;
                if (strtotime()) {
                    # code...
                }
            }
        } else {
            $this->response(array('status' => 'no_update'));
        }
    }
}
