<?php
class Kategori_adm extends CI_Model{
	
	var $table = 'kategori';

	function get_all_category(){ /////// penting untuk get all
		$this->db->select('*');
		$this->db->from('kategori');
		$this->db->order_by('kat_id desc');
		$query=$this->db->get();
		return $query->result();
	}
 
	function get_all_parent(){ /////// penting untuk get all
		$this->db->select('a.id_parent, a.parent_kategori, , a.slug_parent, a.gambar AS gambar_parent, b.*');
		$this->db->from('parent_kategori a');
		$this->db->join('kategori b', 'b.kat_id=a.id_kategori', 'left');
		$this->db->order_by('a.id_parent desc');
		$q=$this->db->get();
		return $q->result();
	}

	function get_categories(){
		$this->db->where('aktif', 'on');
		$this->db->from('kategori');
      	$query = $this->db->get();
      	return $query->result_array();
    }

    function master_cat(){ // load kategori option saat editing data
	$this->db->order_by('kat_id');
	$this->db->where(array('aktif' => 'on'));
	$sql_jabatan=$this->db->get('kategori');
	if($sql_jabatan->num_rows()>0){
		return $sql_jabatan->result_array();
		}
	}

	function ambil_cat($idf){
	$this->db->where('kat_id',$idf);
	$sql=$this->db->get('kategori');
	if($sql->num_rows()>0){
			return $sql->row_array();
		}
	}

	function get_data_parent($idf){
		$this->db->select('*');
		$this->db->from('parent_kategori');
		$this->db->where('id_parent', $idf);
		$r = $this->db->get();
		return $r->result();
	}

	function get_data_kategori($idf){
		$this->db->select('*');
		$this->db->from('kategori');
		$this->db->where('kat_id', $idf);
		$r = $this->db->get();
		return $r->result();
	}

	function get_data_parent_categorie($idf){
    	$this->db->where('id_parent', $idf);
    	$this->db->from('parent_kategori');
      	$query = $this->db->get();
      	return $query->row_array();
    }

	function get_categorie($idf){
    	$this->db->where('kat_id', $idf);
    	$this->db->from('kategori');
      	$query = $this->db->get();
      	return $query->row_array();
    }

	function kategori_telah_dihapus($idf){
		$this->db->where('kat_id', $idf);
		$this->db->delete($this->table);
	}

	function parent_kategori_telah_dihapus($idf){
		$this->db->where('id_parent', $idf);
		$this->db->delete('parent_kategori');
	}
    
    function tambah_kategori($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
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
		$this->db->delete('kategori');
	}

	function add($data){ // tambah data kategori
      	$this->db->insert('kategori', $data);
    }

    function add_parent($data){ // tambah data kategori
      	$this->db->insert('parent_kategori', $data);
    }

    function update_kategorix($data, $idf){ //// penting untuk update_kategorix
    	$this->db->where('kat_id',$idf);
    	$this->db->update('kategori',$data);
    }

    function update_parent_kategori($data, $idf){ //// penting untuk update_kategorix
    	$this->db->where('id_parent',$idf);
    	$this->db->update('parent_kategori',$data);
    }
	
}
?>