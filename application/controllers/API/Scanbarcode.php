<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Scanbarcode extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
    }

    public function index_get()
    {
        $this->response([
            'status' => false,
            'message' => 'No such user found'
        ], 200);
    }

    public function input_absen_post()
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
            }
        } else {
            $this->response(array('status' => 'no_update'));
        }
    }

    public function absen_masuk_post()
    {
        date_default_timezone_set('Asia/Jakarta');
        $temp_id = $this->post("barcode");
        $id_user = $this->post("id_user");
        $in_out = $this->post("in_out");
        $id_barcode = $this->Main_model->deskripsi($temp_id);
        $cek_barcode = $this->db->query('SELECT * FROM absensi WHERE id_absen = "' . $id_barcode . '" AND tgl = "' . date("Y-m-d") . '";');
        if ($cek_barcode->num_rows() > 0) {
            $jamscan = date("h:i:sa");
            $data_jam = $this->db->where("keterangan", "Masuk")->limit(1)->get("jam")->row();
            $start = $data_jam->start;
            $finish = strtotime($data_jam->finish);

            $selisih = strtotime($jamscan) - $finish;

            if ($selisih >= 0) {
                $jam = floor($selisih / (60 * 60));
                $menit    = $selisih - $jam * (60 * 60);

                $valueselisih = $jam .  ' jam ' . floor($menit / 60) . ' menit';

                $ket_lambat = true;
                $selisih =  $valueselisih;
            } else {
                $ket_lambat = FALSE;
                $selisih =  "";
            }

            $data_input = [
                "selisih" => $selisih,
                "ket_lambat" => $ket_lambat,
                "in_out" => $in_out,
                "jam" => $jamscan,
                "id_absensi" => $id_barcode,
                "id_users" => $id_user,
            ];
            $this->db->insert("absensi_karyawan", $data_input);
            $this->response(array('status' => true));
        } else {
            $this->response(array('status' => false));
        }
    }
}
