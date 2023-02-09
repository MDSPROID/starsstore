<?php
class Bestseller_adm extends CI_model{ 

	var $table = 'merk'; 

	function get_bestsell(){
		$this->db->select('*');
		$this->db->from('produk_get_color a');
		$this->db->join('order_product b', 'a.id_produk_optional=b.id_produk');
		$this->db->where('a.stok > 0');
		$r = $this->db->get();
		return $r->result_array();
	}

	function get_merk(){
		$this->db->order_by('merk ASC');
		$this->db->from($this->table);
		$query=$this->db->get();
		return $query->result();
	}

	function get_data_merk($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$this->db->select('*');
		$this->db->from('merk');
		$this->db->where('merk_id', $b);
		$query = $this->db->get();
      	return $query->row_array();
	}
	
	function add($data, $id_user){
		$data = array(
      		'merk'		=> $data['merk'],
      		'logo'		=> $data['logo'],
      		'deskripsi' => $data['editor1'],
	      	'slug'		=> $data['slug'],
    		'aktif'		=> $data['status'],
    		'user_pembuat' => $id_user,
    		'dibuat_tgl'	=> date('Y-m-d H:i:s'),
    		);
    	$this->db->insert('merk', $data);
	}

	function update_merk($data,$id,$id_user){ //// penting untuk update
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$data = array(
      		'merk'		=> $data['merk'],
      		'logo'		=> $data['logo'],
      		'deskripsi' => $data['desc'],
	      	'slug'		=> $data['slug'],
    		'aktif'		=> $data['status'],
    		'user_pengubah' => $id_user,
    		'diubah_tgl'	=> date('Y-m-d H:i:s'),
    		);
		$this->db->where('merk_id', $b);
    	$this->db->update('merk', $data);
    }

    function merk_telah_dihapus($id){
    	$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$this->db->where('merk_id', $b);
		$this->db->delete($this->table);
	}

	function remove_selected() { //untuk menhapus yang dipilih di menu pilihan hapus
		$action = $this->input->post('action');
		if ($action == "delete") {
			$delete = $this->input->post('msg');
			for ($i=0; $i < count($delete) ; $i++) { 
				$this->db->where('merk_id', $delete[$i]);
				$this->db->delete('merk');
			}
		}elseif($action == "all"){
			$this->db->query("DELETE FROM merk");
		}
	}
}
?>