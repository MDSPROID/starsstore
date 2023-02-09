<?php
class Media_promosi_adm extends CI_Model{
	
	var $table = 'banner';

	function get_banner(){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('tgl_mulai ASC');
		$r = $this->db->get();
		return $r->result();
	}

	function cek_posisi($b){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_banner',$b);
		$r = $this->db->get();
		return $r->row_array();	
	}

	function cek_exp(){
		$this->db->select('id_banner,ket,tgl_akhir');
		$this->db->from($this->table);
		$this->db->where('status_banner','on');
		$r = $this->db->get();
		return $r->result();
	}
 
	function ganti_status_exp($id){
		$data = array(
			'status_banner'	=> 'expired',
		);
		$this->db->where('id_banner', $id);
		$this->db->update($this->table, $data);
	}

	function on($id){
		$data = array(
			'status_banner'	=> 'on',
		);
		$this->db->where('id_banner',$id);
		$this->db->update($this->table, $data);
	}

	function off($id){
		$data = array(
			'status_banner'	=> '',
		);
		$this->db->where('id_banner',$id);
		$this->db->update($this->table, $data);
	}

	function hapus($b){
		$this->db->where('id_banner',$b);
		$this->db->delete($this->table);
	}

	function get_banner1(){ // get banner 1
		$this->db->select('*');
		$this->db->where('posisi', 'kiri');
		$this->db->from('banner a');
		$this->db->join('user u', 'a.user=u.id', 'left');
		$query=$this->db->get();
		return $query->result();
	}

	function update_banner1($where, $data){
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	function get_total_counter_banner1(){ // get total counter banner 1
		$this->db->select('*');
		$this->db->where('id_banner','1');
		$this->db->from('banner_perclick');
		$this->db->order_by('tgl desc');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_banner1_perday(){ // total per day
		$this->db->select('*');
		$this->db->where('id_banner','1');
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 DAY)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_banner1_perweek(){ // total per week
		$this->db->select('*');
		$this->db->where('id_banner','1');
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_banner1_permonth(){ // total per month
		$this->db->select('*');
		$this->db->where('id_banner','1');
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_banner2_1(){ // get banner 2_1
		$this->db->select('*');
		$this->db->where('id_banner','2');
		$this->db->from('banner a');
		$this->db->join('user u', 'a.user=u.id', 'left');
		$query=$this->db->get();
		return $query->result();
	}

	function update_banner2_1_picture($where, $data){ // edit banner 2_1 as picture
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();	
	}

	function update_banner2_1_video($where, $data){ // edit banner as video
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();	
	}

	function get_total_counter_banner2_1(){ // get total counter banner 2_1
		$this->db->select('*');
		$this->db->where('id_banner','2');
		$this->db->from('banner_perclick');
		$this->db->order_by('tgl desc');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_banner2_1_perday(){ // total per daya
		$this->db->select('*');
		$this->db->where('id_banner','2');
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 DAY)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_banner2_1_perweek(){ // total per week
		$this->db->select('*');
		$this->db->where('id_banner','2');
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_banner2_1_permonth(){ // total per month
		$this->db->select('*');
		$this->db->where('id_banner','2');
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_banner2_2(){ // get banner 2_2
		$this->db->select('*');
		$this->db->where('id_banner','3');
		$this->db->from('banner a');
		$this->db->join('user u', 'a.user=u.id', 'left');
		$query=$this->db->get();
		return $query->result();
	}

	function update_banner2_2_picture($where, $data){ // edit banner 2_1 as picture
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();	
	}

	function update_banner2_2_video($where, $data){ // edit banner as video
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();	
	}

	function get_total_counter_banner2_2(){ // get total counter banner 2_2
		$this->db->select('*');
		$this->db->where('id_banner','3');
		$this->db->from('banner_perclick');
		$this->db->order_by('tgl desc');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_banner2_2_perday(){ // total per daya
		$this->db->select('*');
		$this->db->where('id_banner','3');
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 DAY)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_banner2_2_perweek(){ // total per week
		$this->db->select('*');
		$this->db->where('id_banner','3');
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_banner2_2_permonth(){ // total per month
		$this->db->select('*');
		$this->db->where('id_banner','3');
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_slider(){ // get slider list
		$this->db->select('*');
		$this->db->where('posisi','utama');
		$this->db->from('banner a');
		$this->db->join('user u', 'a.user=u.id', 'left');
		$query=$this->db->get();
		return $query->result();
	}


	/////////////////// PREVIEW PERFORM SLIDE ///////////////////////////////

	function get_data_slide($id){
		$this->db->from('banner');
		$this->db->where('id_banner', $id);
		$t = $this->db->get();
		return $t->row();
	}

	function get_data_preview_slide($idx){
		$this->db->select('*');
		$this->db->from('banner a');
		$this->db->join('user c', 'c.id=a.user','left');
		$this->db->where('a.id_banner', $idx);
		$t = $this->db->get();
		return $t->result();
	}

	function get_total_counter_slide_periode($idx){ // get total counter banner 2_2
		$this->db->select('bulan,COUNT(*) AS total_klik_per_bulan');
		$this->db->where('id_banner', $idx);
		$this->db->from('banner_perclick');
		$this->db->group_by('bulan');
		$query=$this->db->get();
		return $query->result();
	}

	function get_total_counter_slide($idx){ // get total counter banner 2_2
		$this->db->select('*');
		$this->db->where('id_banner', $idx);
		$this->db->from('banner_perclick');
		$this->db->order_by('tgl desc');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_slide_perday($idx){ // total per daya
		$this->db->select('*');
		$this->db->where('id_banner',$idx);
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 DAY)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_slide_perweek($idx){ // total per week
		$this->db->select('*');
		$this->db->where('id_banner',$idx);
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_slide_permonth($idx){ // total per month
		$this->db->select('*');
		$this->db->where('id_banner',$idx);
		$this->db->where('tgl > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
		$this->db->from('banner_perclick');
		$query=$this->db->get();
		return $query->result();
	}


	////////////////////// END PREVIEW PERFORM SLIDE /////////////////////////////////////////////////

	function on_iklan($id){
		$off_data = array(
			'status_banner' => 'Y',
			);
		$this->db->where('id_banner', $id);
		$off = $this->db->update('banner', $off_data);
	}

	function off_iklan($id){
		$off_data = array(
			'status_banner' => 'N',
			);
		$this->db->where('id_banner', $id);
		$off = $this->db->update('banner', $off_data);
	}

	function insert_slider($data){	
		$this->db->insert($this->table, $data);
		return $this->db->affected_rows();	
	}

	function update_slider($id, $data){
		$this->db->where('id_banner', $id);
		$this->db->update($this->table, $data);
	}

	function update_slider_lain($id, $data){
		$this->db->where('id_banner', $id);
		$this->db->update($this->table, $data);
	}

	function update_banner3_picture($where, $data){
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();	
	}

	function update_banner3_video($where, $data){
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();	
	}

	function hapus_banner($id){
		$this->db->delete('banner', array('id_banner' => $id));
	}
	
}
?>