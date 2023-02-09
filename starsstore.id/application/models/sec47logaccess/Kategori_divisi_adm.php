<?php
class Kategori_divisi_adm extends CI_Model{
	
	var $table = 'kategori_divisi';

	function get_all_category(){ /////// penting untuk get all
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('kat_divisi_id desc');
		$query=$this->db->get();
		return $query->result();
	}
 
	function get_categorie($idf){
    	$this->db->where('kat_divisi_id', $idf);
    	$this->db->from('kategori_divisi');
      	$query = $this->db->get();
      	return $query->row_array();
    }

	function kategori_telah_dihapus($idf){
		$this->db->where('id_akun', $idf);
		$this->db->delete('online_store');
	}

	function hapus_dipilih1() { //untuk menhapus yang dipilih di menu pilihan hapus
		
		if ($action == "delete") {
			$delete = $this->input->post('msg');
			for ($i=0; $i < count($delete) ; $i++) { 
				$this->db->where('kat_id', $delete[$i]);
				$this->db->delete('kategori');
			}
		}elseif($action == "all"){
			$this->db->delete('kategori');
		}
	}

	function hapus_dipilih() { //untuk menhapus yang dipilih di menu pilihan hapus
		
			$delete = $this->input->post('checklist');
			for ($i=0; $i < count($delete) ; $i++) { 
				$this->db->where_in('kat_id', $delete[$i]);
				$this->db->delete('kategori');
			}
	}

	function hapus_semuanya(){
		$this->db->delete('kategori_divisi');
	}

	function add($data){ // tambah data kategori
      	$this->db->insert('kategori_divisi', $data);
    }

    function update_kategorix($data, $idf){ //// penting untuk update_kategorix
    	$this->db->where('kat_divisi_id',$idf);
    	$this->db->update('kategori_divisi',$data);
    }
	
}
?>