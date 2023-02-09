<?php
class Email_adm extends CI_Model{ 
	
	var $table = 'email'; 

	var $table2 = 'master_telp_blaz';  	
    var $column_order = array(null, 'a.id'); //set column field database for datatable orderable
    var $column_search = array('a.A','a.B','a.C'); //set column field database for datatable searchable 
    var $order = array('a.id' => 'desc'); // default order 

    private function _get_datatables_query()
    {   
		$this->db->select('*');        
        $this->db->from('master_telp_blaz a');

		//add custom filter here
        if($this->input->post('kategori'))
        {
        	$kat = $this->input->post('kategori');	
        	if(!empty($kat)){
        		$this->db->where('a.C',$kat);
        	}
        }		
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table2);
        return $this->db->count_all_results();
    }

    function hapus_duplikat(){
    	$this->db->query("DELETE FROM master_telp_blaz WHERE B IN (SELECT * FROM (SELECT B FROM master_telp_blaz GROUP BY B HAVING (COUNT(*) > 1)) AS nomor)");
    	//SELECT B FROM master_telp_blaz WHERE B IN (SELECT * FROM (SELECT B FROM master_telp_blaz GROUP BY B HAVING (COUNT(*) > 0)) AS nomor)
    }

    function kontak_telah_dihapus($id){
		$this->db->where('id', $id);
		$this->db->delete('master_telp_blaz');
	}

	function duplikate_checker($nm){
		$this->db->select('B');
		$this->db->from('master_telp_blaz');
		$this->db->where('B', $nm);
		$t = $this->db->get();
		return $t->row_array();
	}

	function ambil_kontak(){
		$this->db->from('master_telp_blaz');
		$t = $this->db->get();
		return $t->result();	
	}

	function ambil_kontak1($kat){
		$this->db->from('master_telp_blaz');
		$this->db->where('C', $kat);
		$t = $this->db->get();
		return $t->result();
	}

    function get_data_kontak($id){
    	$this->db->from('master_telp_blaz');
		$this->db->where('id', $id);
		$t = $this->db->get();
		return $t->row();
    }

	function get_list_mail(){ 
		$this->db->select('*');
		$this->db->from('email');
		$this->db->order_by('id desc');
		$q = $this->db->get();
		return $q->result();
	}  

	function ubah_status($idx){
		$data = array(
			'status' => 'terkirim',
		);
		$this->db->where('id', $idx);
		$this->db->update('email', $data);
	}
 
	function data_newsletter(){
		$this->db->select('*');
		$this->db->from('newsletter');
		$this->db->where('status','on');
		$f = $this->db->get();
		return $f->result();
	}

	function data_customer(){
		$this->db->select('email');
		$this->db->from('order_customer');
		$this->db->group_by('email');
		$f = $this->db->get();
		return $f->result();
	}

	function simpan_email_konsep($data_mail){
		$this->db->insert('email', $data_mail);
	}

	function data_admin(){
		$this->db->select('*');
		$this->db->from('setting_email_account');
		$this->db->where('status', 'e_admin');
		return $this->db->get();
	}

	function data_finance(){
		$this->db->select('*');
		$this->db->from('setting_email_account');
		$this->db->where('status', 'e_finance');
		return $this->db->get();
	}

	function data_cc(){
		$this->db->select('*');
		$this->db->from('setting_email_account');
		$this->db->where('status', 'e_cc');
		return $this->db->get();
	}

	function data_suport(){
		$this->db->select('*');
		$this->db->from('setting_email_account');
		$this->db->where('status', 'e_support');
		return $this->db->get();
	}

	function data_sales(){
		$this->db->select('*');
		$this->db->from('setting_email_account');
		$this->db->where('status', 'e_sales');
		return $this->db->get();
	}

	function data_bcc(){
		$this->db->select('*');
		$this->db->from('setting_email_account');
		$this->db->where('status', 'e_bcc');
		return $this->db->get();
	}

	function get_data_email($idx){
		$this->db->select('*');
		$this->db->from('email');
		$this->db->where('id', $idx);
		$g = $this->db->get();
		return $g->row_array();
	}

	function get_data_email_for_send($idx){
		$this->db->select('*');
		$this->db->from('email');
		$this->db->where('id', $idx);
		$g = $this->db->get();
		return $g->result();
	}

	function update_email($idx,$data, $data_email){

		$csfrom_filtering = $this->security->xss_clean($this->input->post('fromcustom'));
        $csfrom = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$csfrom_filtering);

		// BARU FROM BISA KUSTOM
        if($data['from'] == "custom"){
        	$from = $csfrom;
        }else{
        	$from = $data['from'];
        }

		$data_mail = array(
	     	'judul'		=> $data['judul'],
    		'to_type'	=> $data['kategori_email'],
    		'from'		=> $from,
    		'to' 		=> $data_email,
    		'message'	=> $data['message'],
    		'status'	=> $data['stat'],
    		'date_created' => date('Y-m-d H:i:s'),
    		'user_add'	=> $this->data['id'],
    	);
		$this->db->where('id', $idx);
		$this->db->update('email', $data_mail);
	}

	function remove_dipilih($check) { 
		$count = count($check);
		for($i=0; $i<$count; $i++) {
			//$data = array(
			//	'id' 	=> $check[$i],
			//);
			$this->db->delete('email',array('id' => $check[$i]));
		}
	}
}
?>