<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $this->load->model('Buku_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['total_buku']     = $this->Buku_model->count_all();
        $data['total_kategori'] = $this->Buku_model->count_kategori();
        $data['total_stok']     = $this->Buku_model->total_stok();
        $data['buku_terbaru']   = $this->Buku_model->get_latest(5);

        $data['username'] = $this->session->userdata('nama_lengkap');
        $data['level']    = $this->session->userdata('level');

        $this->load->view('layout/header');
        $this->load->view('dashboard/index', $data);
        $this->load->view('layout/footer');
    }
}
