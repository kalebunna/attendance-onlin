<?php
class Main_model extends CI_Model
{
    public function deskripsi($key)
    {
        return $this->encryption->decrypt($key);
    }
}
