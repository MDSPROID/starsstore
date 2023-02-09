<?php
class Order_adm extends CI_model{  

    var $table = 'order_customer';      
    var $column_order = array(null, 'a.nama_lengkap'); //set column field database for datatable orderable
    var $column_search = array('a.invoice','a.buy_in','a.total_belanja','a.sender','a.nama_lengkap'); //set column field database for datatable searchable 
    var $order = array('a.id' => 'asc'); // default order 

    var $table_konfirmasi = 'bukti_pembayaran';     
    var $column_order_konfirmasi = array(null); //set column field database for datatable orderable
    var $column_search_konfirmasi = array('a.id_pesanan','a.nama'); //set column field database for datatable searchable 
    var $order_konfirmasi = array('a.id_pembayaran' => 'desc'); // default order  

    function get_datatables_all(){
        $ignore = array('E-commerce');   
        $this->db->select('*');        
        $this->db->from('order_customer a'); 
        $this->db->join('bukti_pembayaran b','b.id_pesanan=a.invoice','left');
        $this->db->join('toko c','c.kode_edp=a.sender','left');
        $this->db->order_by('a.id desc');   
        $this->db->where_in('a.buy_in', 'E-commerce');
        //$this->db->group_by('c.nama_toko');
        $r = $this->db->get();
        return $r->result();

    }

    private function _get_datatables_query()
    {   
 
        $ignore = array('E-commerce');   
        $this->db->select('*');        
        $this->db->from('order_customer a');
        $this->db->join('bukti_pembayaran b','b.id_pesanan=a.invoice','left');
        $this->db->join('toko c','c.kode_edp=a.sender','left');
        $this->db->order_by('a.id desc');
        //add custom filter here
        $tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        if($this->input->post('tgl1'))
        {      
            $this->db->where('a.tanggal_order >=', $tgl1);
            $this->db->where('a.tanggal_order <=', $tgl2);
        } 

        $stat = $this->input->post('status');
        if($this->input->post('status')) 
        {   
            $semua = array('2hd8jPl613!2_^5','*^56t38H53gbb^%$0-_-','Uywy%u3bShi)payDhal','ScUuses8625(62427^#&9531(73','batal');
            if($stat == "all"){
                $this->db->where_in('a.status', $semua); 
            }else{
                $this->db->where('a.status', $stat);
            }
        } 

        if($this->input->post('buy_in'))
        {
            $srtby = $this->input->post('buy_in');
            if(!empty($srtby)){
                $this->db->where('a.buy_in',$srtby);    
            }
        }

        if($this->input->post('dibayar'))
        {   
            $db = $this->input->post('dibayar');    
            if(!empty($db)){
                $this->db->where('a.dibayar',$db);
            }
        }

        if($this->input->post('sender'))
        {
            $sender = $this->input->post('sender'); 
            if(!empty($sender)){
                $this->db->where('a.sender',$sender);
                //$this->db->where("(a.sender LIKE '%".$sender."%')");
            }
        }


        $this->db->where_in('a.buy_in', $ignore);
 
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
         
        //if(isset($_POST['order'])) // here order processing
        //{
        //    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        //} 
        //else if(isset($this->order))
        //{
        //    $order = $this->order;
        //    $this->db->order_by(key($order), $order[key($order)]);
        //}
        //$this->db->group_by('c.nama_toko');
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_konfirmasi_data(){ 

        $this->db->select('a.*,b.*,c.nama_lengkap,c.email as eml, c.no_telp,c.buy_in,c.total_belanja');        
        $this->db->from('bukti_pembayaran a');
        $this->db->join('bukti_transfer b','b.identity_bukti=a.identity_pembayaran','left');
        $this->db->join('order_customer c','c.invoice=a.id_pesanan','left');
        $this->db->group_by('a.identity_pembayaran');
 
        $i = 0;
     
        foreach ($this->column_search_konfirmasi as $item) // loop column 
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
 
                if(count($this->column_search_konfirmasi) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_konfirmasi[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order_konfirmasi))
        {
            $order = $this->order_konfirmasi;
            $this->db->order_by(key($order), $order[key($order)]);
        }

    }
 
    function get_datatables_konfirmasi()
    {
        $this->get_konfirmasi_data();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_konfirmasi()
    {
        $this->get_konfirmasi_data();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_konfirmasi()
    {
        $this->db->from($this->table_konfirmasi);
        return $this->db->count_all_results();
    }

    function get_order_all(){
        $this->db->select('*');
        $this->db->from('order_customer');
        $this->db->where('buy_in','E-commerce');
        $this->db->order_by('id desc'); 
        $r = $this->db->get();
        return $r->result(); 
    } 

    function get_inv_inout($idinvoice){
        $this->db->select('*');
        $this->db->from('inout_inv');
        $this->db->where('inv', $idinvoice);
        $get = $this->db->get();
        return $get->row_array();
    }

    function cariDataidpesanan($keyword){
        $ignore = array('E-commerce');  
        $this->db->select('invoice');
        $this->db->from('order_customer');
        $this->db->like('invoice',$keyword);
        $this->db->where_not_in('buy_in',$ignore);
        return $this->db->get();  
    }

    function get_toko(){
        $this->db->select('*');
        $this->db->from('toko');
        $this->db->where('toko_aktif','on');
        $this->db->order_by('nama_toko','asc');
        $this->db->group_by('nama_toko');
        $r = $this->db->get();
        return $r->result();    
    }

    function get_data_tokopengirim($id){
        $a = base64_decode($id);
        $b = $this->encrypt->decode($a);
        $this->db->select('*');
        $this->db->from('order_customer a');
        $this->db->join('toko b','b.nama_toko=a.sender','left');
        $this->db->where('a.no_order_cus', $b);
        $this->db->group_by('b.nama_toko');
        return $this->db->get();
    }

    function cariDatatoko($keyword){
        $this->db->select('nama_toko,kode_edp');
        $this->db->from('toko');
        $this->db->like('nama_toko',$keyword);
        $this->db->group_by('nama_toko');
        return $this->db->get();  
    }

    function cek_exp(){
        $this->db->select('id,email,invoice,tanggal_jatuh_tempo');
        $this->db->from('order_customer');
        $this->db->where('buy_in','E-commerce');
        $this->db->where('status','2hd8jPl613!2_^5');
        return $this->db->get();
    }

    function cek_pesanan($idx){
        $this->db->select('*');
        $this->db->from('order_customer');
        $this->db->where('invoice',$idx);       
        return  $this->db->get(); 
    }

    function cek_konfirm_already($idx){
        $this->db->select('*');
        $this->db->from('bukti_pembayaran');
        $this->db->where('id_pesanan',$idx);       
        return  $this->db->get();    
    }

    function update_status_pesanan($status, $id){
        $this->db->where('invoice', $id);
        $this->db->update('order_customer', $status);
    }

    function simpan_bukti_pembayaran($data_konfirmasi){
        $this->db->insert('bukti_pembayaran', $data_konfirmasi);
    }

    function update_bukti_pembayaran($data_konfirmasi, $idx){
        $this->db->where('identity_pembayaran', $idx);
        $this->db->update('bukti_pembayaran', $data_konfirmasi);    
    }

    function ubah_status_baca($b, $data_baca){
        $this->db->where('no_order_cus', $b); 
        $this->db->update('order_customer', $data_baca);
    }

    function get_marketplace(){ 
        $this->db->select('*');
        $this->db->from('online_store_list');
        $this->db->order_by('id','asc');
        $r = $this->db->get();
        return $r->result();    
    }

    function get_data_konfirm_by_order($tgl1, $tgl2, $status1, $status2, $market){ // UNTUK RPP RPK MANUAL
        $this->db->select('a.id_pesanan,a.identity_pembayaran,a.tgl,a.catatan,a.tgl_input_data,b.*');
        $this->db->from('bukti_pembayaran a');
        $this->db->join('order_customer b','b.invoice=a.id_pesanan','left');
        //$this->db->join('bukti_transfer c','c.identity_bukti=a.identity_pembayaran','left');
        $this->db->where('b.tanggal_order >=', $tgl1);
        $this->db->where('b.tanggal_order <=', $tgl2);
        $this->db->where_in('b.status', $status2);
        $this->db->where_in('b.dibayar',$status1);
        $this->db->where_in('b.buy_in', $market);
        //$this->db->group_by('a.id_produk');
        $this->db->order_by('b.tanggal_order asc');
        $r = $this->db->get();
        return $r->result();
    }

    function get_data_konfirm_by_order_finish($tgl1, $tgl2, $status1, $status2, $market){ // UNTUK RPP RPK MANUAL
        $this->db->select('a.id_pesanan,a.identity_pembayaran,a.tgl,a.catatan,a.tgl_input_data,b.*');
        $this->db->from('bukti_pembayaran a');
        $this->db->join('order_customer b','b.invoice=a.id_pesanan','left');
        //$this->db->join('bukti_transfer c','c.identity_bukti=a.identity_pembayaran','left');
        $this->db->where('b.tanggal_order_finish >=', $tgl1);
        $this->db->where('b.tanggal_order_finish <=', $tgl2);
        $this->db->where_in('b.status', $status2);
        $this->db->where_in('b.dibayar',$status1);
        $this->db->where_in('b.buy_in', $market);
        //$this->db->group_by('a.id_produk');
        $this->db->order_by('b.tanggal_order_finish asc');
        $r = $this->db->get();
        return $r->result();
    }

    function getkonfirmasidata($b){
        $this->db->select('a.*,b.*,c.buy_in');
        $this->db->from('bukti_pembayaran a');
        $this->db->join('bukti_transfer b','b.identity_bukti=a.identity_pembayaran','left');
        $this->db->join('order_customer c','c.invoice=a.id_pesanan','left');
        $this->db->where('a.identity_pembayaran', $b);
        $r = $this->db->get();
        return $r->row_array();     
    }

    function getkonfirmasi($b){
        $this->db->select('a.id_pesanan,a.tgl,a.catatan,a.tgl_input_data,c.*');
        $this->db->from('bukti_pembayaran a');
        //$this->db->join('bukti_transfer b','b.identity_bukti=a.identity_pembayaran','left');
        $this->db->join('order_customer c','c.invoice=a.id_pesanan','left');
        $this->db->where('a.identity_pembayaran',$b);
        $r = $this->db->get();
        return $r->result();    
    }

    function getkonfirmasi_bukti($b){
        $this->db->select('b.*');
        $this->db->from('bukti_pembayaran a');
        $this->db->join('bukti_transfer b','b.identity_bukti=a.identity_pembayaran','left');
        $this->db->where('a.identity_pembayaran',$b);
        $r = $this->db->get();
        return $r->result();    
    }

    function getkonfirmasibukti($b){
        $this->db->select('a.*,b.*');
        $this->db->from('bukti_transfer a');
        $this->db->join('bukti_pembayaran b','b.identity_pembayaran=a.identity_bukti','left');
        $this->db->where('b.identity_pembayaran',$b);
        $r = $this->db->get();
        return $r->result();    
    }

    function daftar_rekening_pusat(){
        $this->db->select('name_bank, no_rek');
        $this->db->from('daftar_rekening_pusat');
        $this->db->where('aktife_stat_bank','on');       
        $r = $this->db->get(); 
        return $r->result();   
    }

    function ganti_status_exp($id){
        $data = array(
            'status'    => 'batal',
        );
        $this->db->where('id', $id);
        $this->db->update('order_customer', $data);
    }

    function update_sender($datasender, $inv){
        $this->db->where('no_order_cus', $inv);
        $this->db->update('order_customer', $datasender);
    }

//  function get_divisi(){
//      $this->db->select('*');
//      $this->db->from('produk_milik');
//      $this->db->where('aktif','on');
//      $query=$this->db->get();
//      return $query->result();
//  } 

    function get_data_akun($id){
        $a = base64_decode($id);
        $b = $this->encrypt->decode($a);
        $this->db->select('*');
        $this->db->from('online_store');
        $this->db->where('id_akun', $b);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function add($data){
        $data = array(
            'nama_akun'     => $data['nama_akun'],
            'email'         => $data['email'],
            'password'      => $data['password'],
            );
        $this->db->insert('online_store', $data);
    }

    function update_merk($data,$id,$id_user){ //// penting untuk update
        $a = base64_decode($id);
        $b = $this->encrypt->decode($a);
        $data = array(
            'merk'      => $data['merk'],
            'logo'      => $data['logo'],
            'deskripsi' => $data['desc'],
            'slug'      => $data['slug'],
            'aktif'     => $data['status'],
            'user_pengubah' => $id_user,
            'diubah_tgl'    => date('Y-m-d H:i:s'),
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

    function update_selesai($inv){
        $data = array(
            'tanggal_order_finish'          => date('Y-m-d'),
            'tanggal_waktu_order_finish'    => date('Y-m-d H:i:s'),
        );
        $this->db->where('no_order_cus', $inv);
        $this->db->update('order_customer',$data);
    }

    function getMailcs($id){
        $this->db->select('*');
        $this->db->where('id', $id);
        $r = $this->db->get('order_customer');
        return $r->result();
    }

    function changeStat($inv, $status){

        echo $inv.'|'.$status;
        
        if($status == "menunggu"){
            $stat = "2hd8jPl613!2_^5";
            $money = "belum";

            $data = array(
                'status' => $stat,
                'dibayar'=> $money,
            );
        }else if($status == "dibayar"){
            $stat = "*^56t38H53gbb^%$0-_-";
            $money = "bayar";

            $data = array(
                'status' => $stat,
                'dibayar'=> $money,
            );
        }else if($status == "pengiriman"){
            $stat = "Uywy%u3bShi)payDhal";
            $money = "bayar";

            $data = array(
                'status' => $stat,
                'dibayar'=> $money,
            );
        }else if($status == "diterima"){
            $stat = "ScUuses8625(62427^#&9531(73";
            $money = "bayar";

            $data = array(
                'status' => $stat,
                'dibayar'=> $money,
                'tanggal_order_finish'      => date('Y-m-d'),
                'tanggal_waktu_order_finish'=> date('Y-m-d H:i:s'),
            );
            
        }else if($status == "batal"){
            $stat = "batal";
            $money = "belum";

            $data = array(
                'status' => $stat,
                'dibayar'=> $money,
            );
        }
        //print_r($b);
        $this->db->where('no_order_cus', $inv);
        $this->db->update('order_customer', $data);
    }

    function changeStat_market($inv, $status){
        $a = base64_decode($inv);
        $b = $this->encrypt->decode($a);
        if($status == "menunggu"){
            $stat = "2hd8jPl613!2_^5";
        }else if($status == "dibayar"){
            $stat = "*^56t38H53gbb^%$0-_-";
        }else if($status == "pengiriman"){
            $stat = "Uywy%u3bShi)payDhal";
        }else if($status == "diterima"){
            $stat = "ScUuses8625(62427^#&9531(73";
        }else if($status == "batal"){
            $stat = "batal";
        }
        $data = array(
            'status' => $stat,
            );
        //print_r($b);
        $this->db->where('no_order_cus', $b);
        $this->db->update('order_customer', $data);
    }

    function checkingInv($id){
        $a = base64_decode($id);
        $b = $this->encrypt->decode($a);
        $this->db->select('a.*, b.*, d.*, e.email as email1, e.nama_lengkap as nama_lengkap1, e.telp,f.kode_edp, f.nama_toko');
        $this->db->from('order_customer a');
        $this->db->join('order_expedisi b', 'a.no_order_cus=b.no_order_ex', 'left');
        $this->db->join('order_with_voucher d', 'a.no_order_cus=d.no_order_vou', 'left');
        $this->db->join('customer e', 'a.id_customer=e.id', 'left');
        $this->db->join('toko f','f.kode_edp=a.sender','left');
        $this->db->where('a.no_order_cus', $b);
        $this->db->group_by('f.nama_toko');
        $q = $this->db->get();
        return $q->result();
    }

    function checkingdataorder($id){
        $a = base64_decode($id);
        $b = $this->encrypt->decode($a);
        //$this->db->select('a.*, c.*');
        //$this->db->from('order_customer a');
        //$this->db->join('order_product c', 'a.no_order_cus=c.no_order_pro', 'left');
        //$this->db->where('a.no_order_cus', $b);
        $this->db->select('g.*,h.no_order_pro,h.artikel,h.ukuran,h.warna,h.qty,h.harga_fix,h.harga_before,i.nama_produk,i.gambar');
        $this->db->from('order_customer g');
        $this->db->join('order_product h', 'h.no_order_pro=g.no_order_cus', 'left');
        $this->db->join('produk i','i.artikel=h.artikel','left');
        $this->db->where('g.no_order_cus', $b);
        $q = $this->db->get();
        return $q->result();   
    }

     function checkingdataBank($b){
        $this->db->select('a.*, b.*');
        $this->db->from('order_customer a');
        $this->db->join('daftar_rekening_pusat b', 'a.bank_pembayaran=b.code_network', 'left');
        $this->db->where('a.no_order_cus', $b);
        $q = $this->db->get();
        return $q->result();   
    }

    function selectInfbnk($idbnk){
        $this->db->select('*');
        $this->db->where('code_network', $idbnk);
        return $this->db->get('daftar_rekening_pusat');
    }

    function input_resi_update_status($resi, $inv){
        $data = array(
            'tanggal_dikirim'   => date('Y-m-d H:i:s'),
            'status'            => 'Uywy%u3bShi)payDhal',
            'no_resi'           => $resi,
            );
        $this->db->where('invoice', $inv);
        $this->db->update('order_customer', $data);
    }

    function update_status_pengiriman($inv){ // tidak dipakai
        $data = array(
            'status' => 'Uywy%u3bShi)payDhal',
            );
        $this->db->where('invoice', $inv);
        $this->db->update('order_customer', $data);
    }

    function hapus_konfirmasi($id){
        $idf = base64_decode($id);
        $idp = $this->encrypt->decode($idf);
        $this->db->delete('bukti_pembayaran', array('identity_pembayaran' => $idp));
    }
}
?>