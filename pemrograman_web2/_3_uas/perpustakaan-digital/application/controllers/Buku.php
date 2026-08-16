<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Cek session - harus login untuk mengakses
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Anda harus login terlebih dahulu!');
            redirect('auth/login');
        }

        $this->load->model('Buku_model');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    // READ - Menampilkan semua buku dengan searching dan pagination
    public function index()
    {
        // Konfigurasi pagination
        $config['base_url']     = base_url('buku/index');
        $config['total_rows']   = $this->Buku_model->count_all();
        $config['per_page']     = 5;
        $config['uri_segment']  = 3;

        // Styling pagination Bootstrap
        $config['full_tag_open']    = '<nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav>';
        $config['first_link']       = '&laquo; Pertama';
        $config['first_tag_open']   = '<li class="page-item">';
        $config['first_tag_close']  = '</li>';
        $config['last_link']        = 'Terakhir &raquo;';
        $config['last_tag_open']    = '<li class="page-item">';
        $config['last_tag_close']   = '</li>';
        $config['next_link']        = '&raquo;';
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tag_close']   = '</li>';
        $config['prev_link']        = '&laquo;';
        $config['prev_tag_open']    = '<li class="page-item">';
        $config['prev_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '</span></li>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // Searching
        $keyword = $this->input->get('q');

        if ($keyword) {
            $data['buku'] = $this->Buku_model->search($keyword, $config['per_page'], $page);
            $config['total_rows'] = $this->Buku_model->count_search($keyword);
            $this->pagination->initialize($config);
        } else {
            $data['buku'] = $this->Buku_model->get_all($config['per_page'], $page);
        }

        $data['keyword']    = $keyword;
        $data['pagination'] = $this->pagination->create_links();
        $data['total']      = $config['total_rows'];
        $data['no']         = $page + 1;

        $this->load->view('layout/header');
        $this->load->view('buku/index', $data);
        $this->load->view('layout/footer');
    }

    // CREATE - Menampilkan form tambah buku
    public function create()
    {
        // Set rules validasi
        $this->form_validation->set_rules('judul', 'Judul Buku', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('penulis', 'Penulis', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('penerbit', 'Penerbit', 'required|trim');
        $this->form_validation->set_rules('tahun', 'Tahun Terbit', 'required|numeric|exact_length[4]');
        $this->form_validation->set_rules('isbn', 'ISBN', 'required|trim|min_length[10]|max_length[13]');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required|trim');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric|greater_than_equal_to[0]');

        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');
        $this->form_validation->set_message('exact_length', '{field} harus {param} digit.');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header');
            $this->load->view('buku/create');
            $this->load->view('layout/footer');
        } else {
            $data = array(
                'judul'      => $this->input->post('judul'),
                'penulis'    => $this->input->post('penulis'),
                'penerbit'   => $this->input->post('penerbit'),
                'tahun'      => $this->input->post('tahun'),
                'isbn'       => $this->input->post('isbn'),
                'kategori'   => $this->input->post('kategori'),
                'stok'       => $this->input->post('stok'),
                'deskripsi'  => $this->input->post('deskripsi'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->Buku_model->insert($data);
            $this->session->set_flashdata('success', 'Buku berhasil ditambahkan!');
            redirect('buku');
        }
    }

    // UPDATE - Menampilkan form edit buku
    public function edit($id)
    {
        $data['buku'] = $this->Buku_model->get_by_id($id);

        if (empty($data['buku'])) {
            $this->session->set_flashdata('error', 'Buku tidak ditemukan!');
            redirect('buku');
        }

        // Set rules validasi
        $this->form_validation->set_rules('judul', 'Judul Buku', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('penulis', 'Penulis', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('penerbit', 'Penerbit', 'required|trim');
        $this->form_validation->set_rules('tahun', 'Tahun Terbit', 'required|numeric|exact_length[4]');
        $this->form_validation->set_rules('isbn', 'ISBN', 'required|trim|min_length[10]|max_length[13]');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required|trim');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric|greater_than_equal_to[0]');

        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');
        $this->form_validation->set_message('exact_length', '{field} harus {param} digit.');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header');
            $this->load->view('buku/edit', $data);
            $this->load->view('layout/footer');
        } else {
            $data = array(
                'judul'      => $this->input->post('judul'),
                'penulis'    => $this->input->post('penulis'),
                'penerbit'   => $this->input->post('penerbit'),
                'tahun'      => $this->input->post('tahun'),
                'isbn'       => $this->input->post('isbn'),
                'kategori'   => $this->input->post('kategori'),
                'stok'       => $this->input->post('stok'),
                'deskripsi'  => $this->input->post('deskripsi'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->Buku_model->update($id, $data);
            $this->session->set_flashdata('success', 'Buku berhasil diperbarui!');
            redirect('buku');
        }
    }

    // DELETE - Menghapus buku
    public function delete($id)
    {
        $buku = $this->Buku_model->get_by_id($id);

        if (empty($buku)) {
            $this->session->set_flashdata('error', 'Buku tidak ditemukan!');
            redirect('buku');
        }

        $this->Buku_model->delete($id);
        $this->session->set_flashdata('success', 'Buku "' . $buku->judul . '" berhasil dihapus!');
        redirect('buku');
    }

    // Detail buku (opsional - untuk Read detail)
    public function detail($id)
    {
        $data['buku'] = $this->Buku_model->get_by_id($id);

        if (empty($data['buku'])) {
            $this->session->set_flashdata('error', 'Buku tidak ditemukan!');
            redirect('buku');
        }

        $this->load->view('layout/header');
        $this->load->view('buku/detail', $data);
        $this->load->view('layout/footer');
    }
}
