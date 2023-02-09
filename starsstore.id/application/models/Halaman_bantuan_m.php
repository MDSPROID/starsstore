<?php
class Halaman_bantuan_m extends CI_Model
 {

    function get_all_bantuan(){
        $this->db->select('*');
        $this->db->from('halaman_kategori a');
        $this->db->join('halaman_dinamis b', 'a.id_kategori_halaman=b.id_kategori');
        $this->db->where('b.status','on');
        $this->db->group_by('b.id_kategori');
        $this->db->order_by('a.kategori DESC');
        return $this->db->get();
    } 	

    function get_all_bantuan2($kat_id){
        $this->db->select('*');
        $this->db->from('halaman_dinamis');
        $this->db->where('id_kategori', $kat_id);
        return $this->db->get();
 	}

 	function get_isi_kategori_bantuan(){
 		$this->db->select('*');
 		$this->db->from('halaman_kategori');
        $this->db->order_by('kategori ASC');
 		$query = $this->db->get();
 		return $query->result();
 	}

    function get_detail_page($slug){
        $this->db->select('*');
        $this->db->where('slug', $slug);
        $this->db->where('status', 'on');
        $u = $this->db->get('halaman_dinamis');
        return $u->result();
    }

    function insToKontakData($data_kontak){
    	$this->db->insert('kontak', $data_kontak);
    }

    function cariData($keyword){
        $this->db->select('*');
        $this->db->from('halaman_dinamis');
        $this->db->like('judul',$keyword);
        return $this->db->get();  
    }
}