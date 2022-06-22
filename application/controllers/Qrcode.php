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
        date_default_timezone_set('Asia/Jakarta');
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

    public function scan()
    {
        $batasakhir = strtotime("14:00:00");
        $scan = strtotime("14:20:00");

        $selisih =   $scan - $batasakhir;



        if ($selisih > 0) {
            $jam = floor($selisih / (60 * 60));
            $menit    = $selisih - $jam * (60 * 60);
            echo "terlambat " . $jam .  ' jam ' . floor($menit / 60) . ' menit';
        } else {

            $selisih =  $batasakhir - $scan;
            $jam = floor($selisih / (60 * 60));
            $menit    = $selisih - $jam * (60 * 60);
            echo "tak terlambat " . $jam .  ' jam ' . floor($menit / 60) . ' menit';
        }
    }
}
