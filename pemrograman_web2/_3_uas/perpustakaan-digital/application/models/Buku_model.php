<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends CI_Model {

    // READ - Ambil semua buku dengan pagination
    public function get_all($limit = NULL, $offset = NULL)
    {
        $this->db->order_by('id', 'DESC');
        if ($limit !== NULL && $offset !== NULL) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('buku')->result();
    }

    // READ - Ambil buku berdasarkan ID
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('buku');
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return NULL;
    }

    // CREATE - Insert buku baru
    public function insert($data)
    {
        return $this->db->insert('buku', $data);
    }

    // UPDATE - Update buku
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('buku', $data);
    }

    // DELETE - Hapus buku
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('buku');
    }

    // SEARCHING - Pencarian buku
    public function search($keyword, $limit = NULL, $offset = NULL)
    {
        $this->db->like('judul', $keyword);
        $this->db->or_like('penulis', $keyword);
        $this->db->or_like('penerbit', $keyword);
        $this->db->or_like('isbn', $keyword);
        $this->db->or_like('kategori', $keyword);
        $this->db->order_by('id', 'DESC');

        if ($limit !== NULL && $offset !== NULL) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('buku')->result();
    }

    // Count total buku untuk pagination
    public function count_all()
    {
        return $this->db->count_all_results('buku');
    }

    // Count hasil pencarian
    public function count_search($keyword)
    {
        $this->db->like('judul', $keyword);
        $this->db->or_like('penulis', $keyword);
        $this->db->or_like('penerbit', $keyword);
        $this->db->or_like('isbn', $keyword);
        $this->db->or_like('kategori', $keyword);
        return $this->db->count_all_results('buku');
    }

    // Count total kategori unik
    public function count_kategori()
    {
        $this->db->select('COUNT(DISTINCT kategori) as total');
        $query = $this->db->get('buku');
        return $query->row()->total;
    }

    // Total stok semua buku
    public function total_stok()
    {
        $this->db->select('SUM(stok) as total');
        $query = $this->db->get('buku');
        return $query->row()->total;
    }

    // Ambil buku terbaru
    public function get_latest($limit = 5)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('buku')->result();
    }
}
