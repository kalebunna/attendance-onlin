<?php
class Qrcode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_model', 'absensi');
    }

    public function index()
    {
        $data_cek = [
            "tgl" =>
            date("Y-m-d")
        ];
        $id = $this->encryption->encrypt($this->absensi->cek_if_today_already_exist($data_cek));
        $data = [
            "id" => $id
        ];

        $this->load->view("qrcode_today", $data);
    }
}
