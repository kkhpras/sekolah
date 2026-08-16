<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // Cek login user
    public function cek_login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return FALSE;
    }

    // Ambil semua user
    public function get_all()
    {
        return $this->db->get('users')->result();
    }
}
