<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    // Menampilkan halaman login
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('auth/login');
    }

    // Proses login
    public function proses_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->User_model->cek_login($username, $password);

        if ($user) {
            // Set session data
            $session_data = array(
                'user_id'    => $user->id,
                'username'   => $user->username,
                'nama_lengkap' => $user->nama_lengkap,
                'level'      => $user->level,
                'logged_in'  => TRUE
            );

            $this->session->set_userdata($session_data);
            $this->session->set_flashdata('success', 'Selamat datang, ' . $user->nama_lengkap . '!');
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('auth/login');
        }
    }

    // Proses logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
