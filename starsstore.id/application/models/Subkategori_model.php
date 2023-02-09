<?php
class Subkategori_model extends CI_Model {

    function get_produk_sepatu_pria(){
        $this->db->select('*');
        $this->db->from('produk a');
         $this->db->join('produk_review b', 'a.id_produk=b.id_produk', 'left');
        $this->db->where('a.parent','33');
        $this->db->where('a.status','Y');
        $this->db->order_by('a.id_produk desc');
        $q = $this->db->get();
        return $q->result();
    }
}