<?php
class Opsional_adm extends CI_model{

	function get_warnax(){ 
		$this->db->from('produk_opsional_color');
		$r = $this->db->get();
		return $r->result();
	}

	function get_sizex(){
		$this->db->from('produk_opsional_size');
		$r = $this->db->get();
		return $r->result();
	}

	function add_warna($data, $id_user){
    	$count = count($_POST['warna']);

    	for($i=0; $i<$count; $i++) {

    			$data_warna = array(
            		'opsi_color' 	=> $data['warna'][$i],
            		'dibuat' 		=> $id_user,
            		'dibuat_tgl'	=> date('Y-m-d H:i:s'),
				);
        $this->db->insert('produk_opsional_color', $data_warna);
    	}
	}

	function warna_telah_dihapus($id){
		$this->db->where('id_opsi_color', $id);
		$this->db->delete('produk_opsional_color');
	}

	function get_data_color($b){
		$a = base64_decode($b);
		$id = $this->encrypt->decode($a);
		$this->db->from('produk_opsional_color');
		$this->db->where('id_opsi_color', $id);
		$t = $this->db->get();
		return $t->row();
	}

	function update_warna($where,$data){ 
    	$this->db->update('produk_opsional_color', $data, $where);
    	return $this->db->affected_rows();
    }

///////////////////// SIZE ////////////////////////////////////////////////////////////////

	function add_ukuran($data,$id_user){
    	// problem starts here
    	$count = count($_POST['ukuran']);

    	for($i=0; $i<$count; $i++) {
        $data_size = array(
            'opsi_size' 	=> $data['ukuran'][$i],
            'dibuat' 		=> $id_user,
            'dibuat_tgl'	=> date('Y-m-d H:i:s'),
        );
        $this->db->insert('produk_opsional_size', $data_size);
    	}
	}

	function ukuran_telah_dihapus($id){
		$this->db->where('id_opsi_size', $id);
		$this->db->delete('produk_opsional_size');
	}

	function get_data_size($b){
		$a = base64_decode($b);
		$id = $this->encrypt->decode($a);
		$this->db->from('produk_opsional_size');
		$this->db->where('id_opsi_size', $id);
		$t = $this->db->get();
		return $t->row();
	}

	function update_ukuran($where,$data){ 
    	$this->db->update('produk_opsional_size', $data, $where);
    	return $this->db->affected_rows();
    } 

}
?>