<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use LDAP\Result;

class Auth extends RestController
{
    public function login_post()
    {
        $this->load->model('User_Model', 'user');
        $username = $this->post("username");
        $password = $this->post("password");
        $this->db->where("username", $username);
        $this->db->limit(1);
        $data_user = $this->db->get("users");
        if ($data_user->num_rows() > 0) {
            $data_password = $data_user->row()->password;
            $verify_password = password_verify($password, $data_password);
            // $this->response(array('status' => $password));
            if ($verify_password) {
                $respons = array(
                    "status" => "succes",
                    "data" => $data_user->row()
                );
                $this->response($respons);
            } else {
                $respons = array(
                    "status" => "err",
                    "data" => ""
                );
                $this->response($respons);
            }
        } else {
            $respons = array(
                "status" => "err",
                "data" => ""
            );
            $this->response($respons);
        }
    }
}
