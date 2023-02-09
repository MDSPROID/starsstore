<?php
class Produk_adm extends CI_Model{  
      
    var $table = 'produk';
    var $column_order = array(null, 'a.artikel','a.nama_produk'); //set column field database for datatable orderable
    var $column_search = array('a.artikel','a.nama_produk','a.status'); //set column field database for datatable searchable 
    var $column_search_dump = array('b.artikel','b.nama_produk','b.status'); //set column field database for datatable searchable 
    var $order = array('a.status' => 'desc'); // default order 

    private function _get_datatables_query() 
    { 
        $ignore = array('dump');  
        $this->db->select('a.*,c.*,d.merk,d.logo,e.kategori,f.parent_kategori'); 
        $this->db->from('produk a');
//      $this->db->join('produk_jenis b', 'a.jenis=b.jenis','left');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk');
        $this->db->join('merk d', 'a.merk=d.merk_id','left');
        $this->db->join('kategori e', 'e.kat_id=a.kategori','left');
        $this->db->join('parent_kategori f', 'f.id_parent=a.parent','left');
        //$this->db->join('kategori_divisi e', 'a.id_kategori_divisi=e.kat_divisi_id','left');
        //$this->db->join('produk_opsional_size e','e.id_opsi_size=c.id_opsi_get_size');
//      $this->db->join('master_barang f', 'a.artikel=f.artikel','left');

        //add custom filter here
        $tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        if($this->input->post('tgl1') || $this->input->post('tgl2'))
        {   
            $this->db->where('a.tgl_dibuat >=', $tgl1);
            $this->db->where('a.tgl_dibuat <=', $tgl2);
        } 

        $stat = $this->input->post('status_produk');
        if($this->input->post('status_produk'))
        {    
            if($stat == "on"){
                $this->db->where('a.status', 'on'); 
            }else if($stat == "off"){ 
                $this->db->where('a.status', '');
            }
        }else{
                $this->db->where('a.status', 'on');
            }

        if($this->input->post('sort_by'))
        {
            $srtby = $this->input->post('sort_by');
            if($srtby == "a_z"){
                $this->db->order_by('a.nama_produk asc');
            }else if($srtby == "z_a"){
                $this->db->order_by('a.nama_produk desc');
            }else if($srtby == "low"){
                $this->db->order_by('c.harga_fix desc');
            }else if($srtby == "high"){
                $this->db->order_by('c.harga_fix asc');
            }
        }

        if($this->input->post('kategori'))
        {
            $size = $this->input->post('kategori'); 
            if(!empty($size)){
                $this->db->where('a.kategori', $this->input->post('kategori'));
            }
        }

        if($this->input->post('size'))
        {
            $size = $this->input->post('size'); 
            if(!empty($size)){
                $this->db->where('c.id_opsi_get_size', $this->input->post('size'));
            }
        }

        if($this->input->post('color'))
        {
            $warna = $this->input->post('color');   
            if(!empty($warna)){
                $this->db->where('c.id_opsi_get_color', $this->input->post('color'));
            }
        }

        $this->db->where_not_in('a.status', $ignore);
 
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

        $this->db->group_by('a.id_produk');
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

    function syncPrice($datax){
        $this->db->select('retprc');
        $this->db->from('brgcp');
        $this->db->where('art_id', $datax);
        $r = $this->db->get();
        return $r->row_array();
    }

    function cek_toko($edptoko){
        $this->db->select('*');
        $this->db->from('toko');
        $this->db->where('kode_edp', $edptoko);
        $r = $this->db->get();
        return $r->row_array();
    }

    function get_list_size(){
        $this->db->select('*');
        $this->db->from('produk_opsional_size');
        $r = $this->db->get();
        return $r->result();
    }

    function get_list_color(){
        $this->db->select('*');
        $this->db->from('produk_opsional_color');
        $r = $this->db->get();
        return $r->result();
    }

    function count_variasi($idprodukvariasi){
        $this->db->select('COUNT(id_produk_optional) as variasi');
        $this->db->from('produk_get_color');
        $this->db->where('id_produk_optional',$idprodukvariasi);
        $r = $this->db->get();
        return $r->row_array(); 
    }

    function get_variasi($idprodukvariasi){
        $this->db->select('a.*,b.*');
        $this->db->from('produk_get_color a');
        $this->db->join('produk_opsional_size b','b.id_opsi_size=a.id_opsi_get_size','left');
        //$this->db->join('order_product c','c.id_produk=a.id_produk_optional','left');
        $this->db->where('a.id_produk_optional',$idprodukvariasi);
        $r = $this->db->get();
        return $r->result();        
    }

    function produk_terjual($art, $size){
        $this->db->select('SUM(qty) as total_terjual');
        $this->db->from('order_product a');
        $this->db->join('order_customer b','b.no_order_cus=a.no_order_pro','left');
        $this->db->where('a.artikel',$art);
        $this->db->where('a.ukuran',$size);
        $this->db->where('b.status','ScUuses8625(62427^#&9531(73');
        $r = $this->db->get();
        return $r->row_array();     
    }

    function get_list_produk_for_new_table(){ 
        $this->db->select('a.id_produk,a.nama_produk,a.sku_produk,a.artikel,a.gambar,a.status,c.*,d.*,e.kategori');
        $this->db->from('produk a');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk');
        $this->db->join('merk d', 'a.merk=d.merk_id','left');
        $this->db->join('kategori e', 'e.kat_id=a.kategori','left');
        $this->db->where('a.status', 'on');
        $this->db->order_by('a.artikel asc');
        $this->db->group_by('a.id_produk');
        $q = $this->db->get(); 
        return $q->result(); 
    }

    function produk_dilihat($idprodukvariasi){ 
        $this->db->select('COUNT(a.id_produk_view) AS total_dilihat');
        $this->db->from('produk_viewed a');
        $this->db->where('id_produk_view',$idprodukvariasi);
        $this->db->group_by('a.id_produk_view');
        $q = $this->db->get();
        return $q->row_array();
    }

    function get_data_by_art(){
        $this->db->select('id_produk,nama_produk,artikel,gambar,last_check_stok');
        $this->db->from('produk');
        $this->db->where('status','on');
        $this->db->where("last_check_stok = '0000-00-00' OR last_check_stok < NOW() ");
        $this->db->limit(10);
        $this->db->order_by('rand()');
        $q = $this->db->get(); 
        return $q->result();
    }

    function get_data_by_art2($lmt){
        $this->db->select('*'); // b.id_produk,b.nama_produk,b.artikel,b.gambar
        $this->db->from('produk_all_stok a');
        //$this->db->join('produk b','b.artikel=a.art_id','left');
        $this->db->limit($lmt);
        //$this->db->order_by('rand()');
        $q = $this->db->get(); 
        return $q->result();
    }

    function get_data_by_art2byexcel($lmt){
        $this->db->select('*'); // b.id_produk,b.nama_produk,b.artikel,b.gambar
        $this->db->from('brgcp');
        $this->db->limit($lmt);
        $q = $this->db->get(); 
        return $q->result();
    }

    function get_data_by_art3($artxx){
        $this->db->select('b.id_produk,b.nama_produk,b.artikel,b.gambar'); 
        $this->db->from('produk b');
        $this->db->where('b.artikel',$artxx);
        $this->db->where('b.status','on');
        return $this->db->get(); 
    }

    function get_data_by_art4(){
        $this->db->select('a.art_id,a.prj, a.retprc'); // b.id_produk,b.nama_produk,b.artikel,b.gambar
        $this->db->from('brgcp a');
        //$this->db->join('produk b','b.artikel=a.art_id','left');
        //$this->db->limit($lmt);
        //$this->db->order_by('rand()');
        $q = $this->db->get(); 
        return $q->result();
    }
  
    function get_list_produk(){ 
        $ignore = array('dump'); 
        $this->db->select('*');
        $this->db->from('produk a');
//      $this->db->join('produk_jenis b', 'a.jenis=b.jenis','left');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk');
        $this->db->join('merk d', 'a.merk=d.merk_id','left');
        //$this->db->join('kategori_divisi e', 'a.id_kategori_divisi=e.kat_divisi_id','left');
//      $this->db->join('master_barang f', 'a.artikel=f.artikel','left');
        $this->db->where_not_in('a.status', $ignore);
        $this->db->order_by('a.artikel asc');
        $this->db->group_by('a.id_produk');
        $q = $this->db->get(); 
        return $q->result();
    }

    function carisizeberdasarkanid($filter_size){
        $this->db->select('opsi_size');
        $this->db->from('produk_opsional_size');
        $this->db->where('id_opsi_size',$filter_size);
        $t = $this->db->get();
        return $t->row_array();
    }

    function caricolorberdasarkanid($filter_color){
        $this->db->select('opsi_color');
        $this->db->from('produk_opsional_color');
        $this->db->where('id_opsi_color',$filter_color);
        $t = $this->db->get();
        return $t->row_array(); 
    }

    function get_size_bukalapak($id){
        $this->db->select('b.opsi_size');
        $this->db->from('produk_get_color a');
        $this->db->join('produk_opsional_size b','b.id_opsi_size=a.id_opsi_get_size','left');
        $this->db->where('a.id_produk_optional',$id);
        $t = $this->db->get();
        return $t->result();
    }

    function filter_produk(){
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->where('status','on');
        $this->db->order_by('id_produk desc');
        $t = $this->db->get();
        return $t->result();
    }

    function get_gambar($sku){
        $this->db->select('gambar');
        $this->db->from('produk_image');
        $this->db->where('identity_produk',$sku);
        $t = $this->db->get();
        return $t->result();
    }

    function filter_produk_excel($filter_status,$filter_sortby,$filter_size,$filter_color,$tgl1,$tgl2)
    {
        $ignore = array('dump'); 
        $this->db->select('a.id_produk,a.nama_produk,a.sku_produk,a.stok_global,a.artikel,a.berat,a.keterangan,a.gambar as gambar_utama,c.*,d.*');
        $this->db->from('produk a');
//      $this->db->join('produk_jenis b', 'a.jenis=b.jenis','left');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk');
        $this->db->join('merk d', 'a.merk=d.merk_id','left');
        //$this->db->join('produk_image e','e.identity_produk=a.sku_produk');
        //$this->db->join('kategori_divisi e', 'a.id_kategori_divisi=e.kat_divisi_id','left');
        //$this->db->join('produk_opsional_size e','e.id_opsi_size=c.id_opsi_get_size');
//      $this->db->join('master_barang f', 'a.artikel=f.artikel','left');

        //add custom filter here
        $tgl1 = $this->input->post('tglupload1');
        $tgl2 = $this->input->post('tglupload2');
        if($this->input->post('tglupload1') || $this->input->post('tglupload2'))
        {   
            $this->db->where('a.tgl_dibuat >=', $tgl1);
            $this->db->where('a.tgl_dibuat <=', $tgl2);
        } 

        $stat = $this->input->post('status_produk');
        if($this->input->post('status_produk'))
        {   
            if($stat == "on"){
                $this->db->where('a.status', 'on');
            }else if($stat == "off"){
                $this->db->where('a.status', '');
            }
        } 

        if($this->input->post('sort_by'))
        {
            $srtby = $this->input->post('sort_by');
            if($srtby == "a_z"){
                $this->db->order_by('a.nama_produk asc');
            }else if($srtby == "z_a"){
                $this->db->order_by('a.nama_produk desc');
            }else if($srtby == "low"){
                $this->db->order_by('c.harga_fix desc');
            }else if($srtby == "high"){
                $this->db->order_by('c.harga_fix asc');
            }else if($srtby == "tr_diubah"){
                $this->db->order_by('a.tgl_diubah desc');
            }else if($srtby == "first_end"){
                $this->db->order_by('a.id_produk asc');
            }else if($srtby == "end_first"){
                $this->db->order_by('a.id_produk desc');
            }
        }

        if($this->input->post('size'))
        {
            $size = $this->input->post('size'); 
            if(!empty($size)){
                $this->db->where('c.id_opsi_get_size', $this->input->post('size'));
            }
        }

        if($this->input->post('color'))
        {
            $warna = $this->input->post('color');   
            if(!empty($warna)){
                $this->db->where('c.id_opsi_get_color', $this->input->post('color'));
            }
        }

        if($this->input->post('produk_pilih'))
        {
            $produk = $this->input->post('produk_pilih');   
            if(!empty($produk)){
                $this->db->where_in('a.artikel', $this->input->post('produk_pilih'));
            }
        }

        //$this->db->where_not_in('a.status', $ignore);
 
        //$i = 0;
     
        //foreach ($this->column_search as $item) // loop column 
        //{
        //    if($_POST['search']['value']) // if datatable send POST for search
        //    {
                 
        //        if($i===0) // first loop
        //        {
        //            $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        //            $this->db->like($item, $_POST['search']['value']);
        //        }
        //        else
        //        {
        //            $this->db->or_like($item, $_POST['search']['value']);
        //        }
 
        //        if(count($this->column_search) - 1 == $i) //last loop
        //            $this->db->group_end(); //close bracket
        //    }
        //    $i++;
        //}
         
        //if(isset($_POST['order'])) // here order processing
        //{
        //    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        //} 
        //else if(isset($this->order))
        //{
        //    $order = $this->order;
        //    $this->db->order_by(key($order), $order[key($order)]);
        //}
        $this->db->group_by('a.id_produk');
        $r = $this->db->get();
        return $r->result();
    }

    function filter_produk_excel_shopee($filter_status,$filter_sortby,$filter_size,$filter_color,$tgl1,$tgl2)
    {
        $ignore = array('dump'); 
        $this->db->select('a.id_produk,a.nama_produk,a.sku_produk,a.stok_global,a.artikel,a.berat,a.keterangan,a.gambar as gambar_utama,c.*,d.*,e.*');
        $this->db->from('produk a');
//      $this->db->join('produk_jenis b', 'a.jenis=b.jenis','left');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk');
        $this->db->join('merk d', 'a.merk=d.merk_id','left');
        //$this->db->join('produk_image e','e.identity_produk=a.sku_produk');
        //$this->db->join('kategori_divisi e', 'a.id_kategori_divisi=e.kat_divisi_id','left');
        $this->db->join('produk_opsional_size e','e.id_opsi_size=c.id_opsi_get_size');
//      $this->db->join('master_barang f', 'a.artikel=f.artikel','left');

        //add custom filter here
        $tgl1 = $this->input->post('tglupload1');
        $tgl2 = $this->input->post('tglupload2');
        if($this->input->post('tglupload1') || $this->input->post('tglupload2'))
        {   
            $this->db->where('a.tgl_dibuat >=', $tgl1);
            $this->db->where('a.tgl_dibuat <=', $tgl2);
        } 

        $stat = $this->input->post('status_produk');
        if($this->input->post('status_produk'))
        {   
            if($stat == "on"){
                $this->db->where('a.status', 'on');
            }else if($stat == "off"){
                $this->db->where('a.status', '');
            }
        } 

        if($this->input->post('sort_by'))
        {
            $srtby = $this->input->post('sort_by');
            if($srtby == "a_z"){
                $this->db->order_by('a.nama_produk asc');
            }else if($srtby == "z_a"){
                $this->db->order_by('a.nama_produk desc');
            }else if($srtby == "low"){
                $this->db->order_by('c.harga_fix desc');
            }else if($srtby == "high"){
                $this->db->order_by('c.harga_fix asc');
            }else if($srtby == "tr_diubah"){
                $this->db->order_by('a.tgl_diubah desc');
            }else if($srtby == "first_end"){
                $this->db->order_by('a.id_produk asc');
            }else if($srtby == "end_first"){
                $this->db->order_by('a.id_produk desc');
            }
        }

        if($this->input->post('size'))
        {
            $size = $this->input->post('size'); 
            if(!empty($size)){
                $this->db->where('c.id_opsi_get_size', $this->input->post('size'));
            }
        }

        if($this->input->post('color'))
        {
            $warna = $this->input->post('color');   
            if(!empty($warna)){
                $this->db->where('c.id_opsi_get_color', $this->input->post('color'));
            }
        }

        if($this->input->post('produk_pilih'))
        {
            $produk = $this->input->post('produk_pilih');   
            if(!empty($produk)){
                $this->db->where_in('a.artikel', $this->input->post('produk_pilih'));
            }
        }

        //$this->db->where_not_in('a.status', $ignore);
 
        //$i = 0;
     
        //foreach ($this->column_search as $item) // loop column 
        //{
        //    if($_POST['search']['value']) // if datatable send POST for search
        //    {
                 
        //        if($i===0) // first loop
        //        {
        //            $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        //            $this->db->like($item, $_POST['search']['value']);
        //        }
        //        else
        //        {
        //            $this->db->or_like($item, $_POST['search']['value']);
        //        }
 
        //        if(count($this->column_search) - 1 == $i) //last loop
        //            $this->db->group_end(); //close bracket
        //    }
        //    $i++;
        //}
         
        //if(isset($_POST['order'])) // here order processing
        //{
        //    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        //} 
        //else if(isset($this->order))
        //{
        //    $order = $this->order;
        //    $this->db->order_by(key($order), $order[key($order)]);
        //}
        //$this->db->group_by('a.id_produk');
        $r = $this->db->get();
        return $r->result();
    }


    function filter_produk_excel_lazada($filter_status,$filter_sortby,$filter_size,$filter_color,$filter_kategori,$tgl1,$tgl2)
    {
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk');
        $this->db->join('merk d', 'a.merk=d.merk_id','left');
        $this->db->join('produk_opsional_size e','e.id_opsi_size=c.id_opsi_get_size');

        //add custom filter here
        $tgl1 = $this->input->post('tglupload1');
        $tgl2 = $this->input->post('tglupload2');
        if($this->input->post('tglupload1') || $this->input->post('tglupload2'))
        {   
            $this->db->where('a.tgl_dibuat >=', $tgl1);
            $this->db->where('a.tgl_dibuat <=', $tgl2);
        } 

        $stat = $this->input->post('status_produk');
        if($this->input->post('status_produk'))
        {   
            if($stat == "on"){
                $this->db->where('a.status', 'on');
            }else if($stat == "off"){
                $this->db->where('a.status', '');
            }
        } 

        if($this->input->post('sort_by'))
        {
            $srtby = $this->input->post('sort_by');
            if($srtby == "a_z"){
                $this->db->order_by('a.nama_produk asc');
            }else if($srtby == "z_a"){
                $this->db->order_by('a.nama_produk desc');
            }else if($srtby == "low"){
                $this->db->order_by('c.harga_fix desc');
            }else if($srtby == "high"){
                $this->db->order_by('c.harga_fix asc');
            }else if($srtby == "tr_diubah"){
                $this->db->order_by('a.tgl_diubah desc');
            }else if($srtby == "first_end"){
                $this->db->order_by('a.id_produk asc');
            }else if($srtby == "end_first"){
                $this->db->order_by('a.id_produk desc');
            }
        }

        if($this->input->post('size'))
        {
            $size = $this->input->post('size'); 
            if(!empty($size)){
                $this->db->where('c.id_opsi_get_size', $this->input->post('size'));
            }
        }

        if($this->input->post('color'))
        {
            $warna = $this->input->post('color');   
            if(!empty($warna)){
                $this->db->where('c.id_opsi_get_color', $this->input->post('color'));
            }
        }

        if($this->input->post('kategori'))
        {
            $kategori = $this->input->post('kategori'); 
            if(!empty($kategori)){
                $this->db->where('a.kategori', $this->input->post('kategori'));
            }
        }

        if($this->input->post('produk_pilih'))
        {
            $produk = $this->input->post('produk_pilih');   
            if(!empty($produk)){
                $this->db->where_in('a.artikel', $this->input->post('produk_pilih'));
            }else{

            }
        }


        //$this->db->where_not_in('a.status', $ignore);
 
        //$i = 0;
     
        //foreach ($this->column_search as $item) // loop column 
        //{
        //    if($_POST['search']['value']) // if datatable send POST for search
        //    {
                 
        //        if($i===0) // first loop
        //        {
        //            $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        //            $this->db->like($item, $_POST['search']['value']);
        //        }
        //        else
        //        {
        //            $this->db->or_like($item, $_POST['search']['value']);
        //        }
 
        //        if(count($this->column_search) - 1 == $i) //last loop
        //            $this->db->group_end(); //close bracket
        //    }
        //    $i++;
        //}
         
        //if(isset($_POST['order'])) // here order processing
        //{
        //    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        //} 
        //else if(isset($this->order))
        //{
        //    $order = $this->order;
        //    $this->db->order_by(key($order), $order[key($order)]);
        //}
        //$this->db->group_by('a.id_produk');
        $r = $this->db->get();
        return $r->result();
    }

    function filter_produk_excel_bukalapak($filter_status,$filter_sortby,$filter_size,$filter_color,$tgl1,$tgl2)
    {
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk');
        $this->db->join('merk d', 'a.merk=d.merk_id','left');

        //add custom filter here
        $tgl1 = $this->input->post('tglupload1');
        $tgl2 = $this->input->post('tglupload2');
        if($this->input->post('tglupload1') || $this->input->post('tglupload2'))
        {   
            $this->db->where('a.tgl_dibuat >=', $tgl1);
            $this->db->where('a.tgl_dibuat <=', $tgl2);
        } 

        $stat = $this->input->post('status_produk');
        if($this->input->post('status_produk'))
        {   
            if($stat == "on"){
                $this->db->where('a.status', 'on');
            }else if($stat == "off"){
                $this->db->where('a.status', '');
            }
        } 

        if($this->input->post('sort_by'))
        {
            $srtby = $this->input->post('sort_by');
            if($srtby == "a_z"){
                $this->db->order_by('a.nama_produk asc');
            }else if($srtby == "z_a"){
                $this->db->order_by('a.nama_produk desc');
            }else if($srtby == "low"){
                $this->db->order_by('c.harga_fix desc');
            }else if($srtby == "high"){
                $this->db->order_by('c.harga_fix asc');
            }else if($srtby == "tr_diubah"){
                $this->db->order_by('a.tgl_diubah desc');
            }else if($srtby == "first_end"){
                $this->db->order_by('a.id_produk asc');
            }else if($srtby == "end_first"){
                $this->db->order_by('a.id_produk desc');
            }
        }

        if($this->input->post('size'))
        {
            $size = $this->input->post('size'); 
            if(!empty($size)){
                $this->db->where('c.id_opsi_get_size', $this->input->post('size'));
            }
        }

        if($this->input->post('color'))
        {
            $warna = $this->input->post('color');   
            if(!empty($warna)){
                $this->db->where('c.id_opsi_get_color', $this->input->post('color'));
            }
        }

        if($this->input->post('kategori'))
        {
            $kategori = $this->input->post('kategori'); 
            if(!empty($kategori)){
                $this->db->where('a.kategori', $this->input->post('kategori'));
            }
        }

        if($this->input->post('produk_pilih'))
        {
            $produk = $this->input->post('produk_pilih');   
            $produkx = array($produk);
            //$arr=explode(",",$produk);
            $produkxx = implode(',',$produkx);
            $produk1 = array($produkxx);
            if(!empty($produk)){
                $this->db->where_in('a.artikel', $produk1);
            }
        }


        //$this->db->where_not_in('a.status', $ignore);
 
        //$i = 0;
     
        //foreach ($this->column_search as $item) // loop column 
        //{
        //    if($_POST['search']['value']) // if datatable send POST for search
        //    {
                 
        //        if($i===0) // first loop
        //        {
        //            $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        //            $this->db->like($item, $_POST['search']['value']);
        //        }
        //        else
        //        {
        //            $this->db->or_like($item, $_POST['search']['value']);
        //        }
 
        //        if(count($this->column_search) - 1 == $i) //last loop
        //            $this->db->group_end(); //close bracket
        //    }
        //    $i++;
        //}
         
        //if(isset($_POST['order'])) // here order processing
        //{
        //    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        //} 
        //else if(isset($this->order))
        //{
        //    $order = $this->order;
        //    $this->db->order_by(key($order), $order[key($order)]);
        //}
        $this->db->group_by('a.id_produk');
        $this->db->order_by('a.id_produk desc');
        $r = $this->db->get();
        return $r->result();
    }

    function filter_produk_excel_blibli($filter_status,$filter_sortby,$filter_size,$filter_color,$tgl1,$tgl2)
    {
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk');
        $this->db->join('merk d', 'a.merk=d.merk_id','left');
        $this->db->join('produk_opsional_size e','e.id_opsi_size=c.id_opsi_get_size');
//      $this->db->join('master_barang f', 'a.artikel=f.artikel','left');

        //add custom filter here
        $tgl1 = $this->input->post('tglupload1');
        $tgl2 = $this->input->post('tglupload2');
        if($this->input->post('tglupload1') || $this->input->post('tglupload2'))
        {   
            $this->db->where('a.tgl_dibuat >=', $tgl1);
            $this->db->where('a.tgl_dibuat <=', $tgl2);
        } 

        $stat = $this->input->post('status_produk');
        if($this->input->post('status_produk'))
        {   
            if($stat == "on"){
                $this->db->where('a.status', 'on');
            }else if($stat == "off"){
                $this->db->where('a.status', '');
            }
        } 

        if($this->input->post('sort_by'))
        {
            $srtby = $this->input->post('sort_by');
            if($srtby == "a_z"){
                $this->db->order_by('a.nama_produk asc');
            }else if($srtby == "z_a"){
                $this->db->order_by('a.nama_produk desc');
            }else if($srtby == "low"){
                $this->db->order_by('c.harga_fix desc');
            }else if($srtby == "high"){
                $this->db->order_by('c.harga_fix asc');
            }else if($srtby == "tr_diubah"){
                $this->db->order_by('a.tgl_diubah desc');
            }else if($srtby == "first_end"){
                $this->db->order_by('a.id_produk asc');
            }else if($srtby == "end_first"){
                $this->db->order_by('a.id_produk desc');
            }
        }

        if($this->input->post('size'))
        {
            $size = $this->input->post('size'); 
            if(!empty($size)){
                $this->db->where('c.id_opsi_get_size', $this->input->post('size'));
            }
        }

        if($this->input->post('color'))
        {
            $warna = $this->input->post('color');   
            if(!empty($warna)){
                $this->db->where('c.id_opsi_get_color', $this->input->post('color'));
            }
        }

        if($this->input->post('kategori'))
        {
            $kategori = $this->input->post('kategori'); 
            if(!empty($kategori)){
                $this->db->where('a.kategori', $this->input->post('kategori'));
            }
        }

        if($this->input->post('produk_pilih'))
        {
            $produk = $this->input->post('produk_pilih');   
            $produkx = array($produk);
            //$arr=explode(",",$produk);
            $produkxx = implode(',',$produkx);
            $produk1 = array($produkxx);
            if(!empty($produk)){
                $this->db->where_in('a.artikel', $produk1);
            }
        }


        //$this->db->where_not_in('a.status', $ignore);
 
        //$i = 0;
     
        //foreach ($this->column_search as $item) // loop column 
        //{
        //    if($_POST['search']['value']) // if datatable send POST for search
        //    {
                 
        //        if($i===0) // first loop
        //        {
        //            $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        //            $this->db->like($item, $_POST['search']['value']);
        //        }
        //        else
        //        {
        //            $this->db->or_like($item, $_POST['search']['value']);
        //        }
 
        //        if(count($this->column_search) - 1 == $i) //last loop
        //            $this->db->group_end(); //close bracket
        //    }
        //    $i++;
        //}
         
        //if(isset($_POST['order'])) // here order processing
        //{
        //    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        //} 
        //else if(isset($this->order))
        //{
        //    $order = $this->order;
        //    $this->db->order_by(key($order), $order[key($order)]);
        //}
        //$this->db->group_by('a.id_produ');
        $this->db->order_by('a.id_produk desc');
        $r = $this->db->get();
        return $r->result();
    }

    function get_sub_kat($prop_id){
        $this->db->select('*');
        $this->db->from('parent_kategori');
        $this->db->where('id_kategori',$prop_id);
        return $this->db->get();
    }

    function get_list_produk_grouping(){ 
        $ignore = array('dump');
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk');
        //$this->db->join('produk_jenis b', 'a.jenis=b.jenis','left');
//      $this->db->join('produk_milik c', 'a.milik=c.id_milik','left');
        //$this->db->join('merk d', 'a.merk=d.merk_id','left');
        //$this->db->join('kategori_divisi e', 'a.id_kategori_divisi=e.kat_divisi_id','left');
//      $this->db->join('master_barang f', 'a.artikel=f.artikel','left');
        $this->db->where('a.status','on');
        $this->db->order_by('a.id_produk desc');
        $this->db->group_by('a.id_produk');
        $q = $this->db->get();
        return $q->result();
    }

    function cek_exp_promo_masal(){
        $this->db->select('*');
        return $this->db->get('produk_group_name');
    }

    function get_produk_group($id){
        $this->db->select('*');
        $this->db->from('produk_group a');
        $this->db->join('produk_get_color b','b.id_produk_optional=a.id_produk_group','left');
        $this->db->where('a.id_group_name',$id);
        return $this->db->get();
    }

    function hapus($id){
        $this->db->where('id_cs', $id);
        $this->db->delete('reset_password_expired_id');
    }

    function get_list_produk_grouping_tong_sampah(){
        $this->db->select('*');
        $this->db->from('produk_grouping a');
        //$this->db->join('produk_jenis b', 'a.jenis=b.jenis','left');
        //$this->db->join('master_barang b','b.artikel=a.artikel','left');
        //$this->db->join('merk c','a.merk=c.merk_id','left');
        //$this->db->join('kategori_divisi d', 'a.id_kategori_divisi=d.kat_divisi_id','left');
        $this->db->where('a.status','dump');
        $this->db->order_by('a.id_produk desc');
        $q = $this->db->get();
        return $q->result();
    }

    function get_produk_grup_show($id){
        $this->db->select('*');
        $this->db->from('produk_group a');
        $this->db->join('produk b', 'b.id_produk=a.id_produk_group','left');
        $this->db->join('produk_get_color c','c.id_produk_optional=b.id_produk');
        $this->db->where('a.id_group_name', $id);
        $this->db->order_by('b.harga_net asc');
        $this->db->group_by('b.id_produk');
        $q = $this->db->get();
        return $q->result();
    }

    function get_nama_group($idxx){
        $this->db->select('*');
        $this->db->from('produk_group_name');
        $this->db->where('id', $idxx);
        $q = $this->db->get();
        return $q->row_array();
    }

    function get_group($idxx){
        $ignore = array('dump');
        $this->db->select('*');
        $this->db->from('produk_group a');
        $this->db->join('produk b','b.id_produk=a.id_produk_group','left');
        $this->db->join('produk_get_color c','c.id_produk_optional=b.id_produk','left');
        $this->db->where_not_in('b.status', $ignore);
        $this->db->where('a.id_group_name', $idxx);
        $this->db->order_by('b.id_produk desc');
        $this->db->group_by('b.id_produk');
        $q = $this->db->get();
        return $q->result();
    }

    function get_list_grouping(){
        $this->db->select('*');
        $this->db->from('produk_group_name a');
        $this->db->order_by('a.dibuat desc');
        $q = $this->db->get();
        return $q->result();
    }

    function create_group_manual($iduser, $nama, $gambar, $ket, $mulai, $akhir, $posisi, $produk){

        $sl1 = $nama;
        $sl2 = strtolower($sl1);
        $sl3 = str_replace(' ','-',$sl2);
        $sl4 = str_replace('%','-persen',$sl3);

        $data_grup = array(
            'name_group'    => $nama,
            'slug'          => $sl4,
            'gambar'        => $gambar,
            'keterangan'    => $ket,
            'status'        => 'on',
            'posisi'        => $posisi,
            'mulai'         => $mulai,
            'berakhir'      => $akhir,
            'user_buat'     => $iduser,
            'dibuat'        => date('Y-m-d'),
        );
        $this->db->insert('produk_group_name', $data_grup);

        $last_insert_id = $this->db->insert_id();

        // tandai produk yang sudah digrupkan
        $count = count($produk);
        for($i=0; $i<$count; $i++) {
            $data_produk = array(
                'id_group_name'     => $last_insert_id,
                'id_produk_group'   => $produk[$i],
            );
            $this->db->insert('produk_group', $data_produk);
            
            //$tandai = array(
            //  'grup' => 'aktif',
            //);
            //$this->db->where('id_produk', $produk[$i]);
            //$this->db->update('produk_grouping', $tandai);
        }
    }

    function create_group_promo($iduser, $nama, $gambar, $ket, $mulai, $akhir, $posisi, $produk){

        $sl1 = $nama;
        $sl2 = strtolower($sl1);
        $sl3 = str_replace(' ','-',$sl2);
        $sl4 = str_replace('%','-persen',$sl3);

        $data_grup = array(
            'name_group'    => $nama,
            'slug'          => $sl4,
            'gambar'        => $gambar,
            'keterangan'    => $ket,
            'status'        => 'on',
            'posisi'        => $posisi,
            'mulai'         => $mulai,
            'berakhir'      => $akhir,
            'user_buat'     => $iduser,
            'dibuat'        => date('Y-m-d'),
        );
        $this->db->insert('produk_group_name', $data_grup);

        $last_insert_id = $this->db->insert_id();

        // tandai produk yang sudah digrupkan
        $count = count($produk);
        for($i=0; $i<$count; $i++) {
            $data_produk = array(
                'id_group_name'     => $last_insert_id,
                'id_produk_group'   => $produk[$i],
            );
            $this->db->insert('produk_group', $data_produk);
            
            //$tandai = array(
            //  'grup' => 'aktif',
            //);
            //$this->db->where('id_produk', $produk[$i]);
            //$this->db->update('produk_grouping', $tandai);
        }

        // tandai waktu promo dimulai di table produk
        //$count = count($produk);
        //for($i=0; $i<$count; $i++) {

        //  $data_produk1 = array(
        //        'tgl_mulai_promo'     => $mulai,
        //        'tgl_akhir_promo'     => $akhir,
        //    );
        //  $this->db->where('id_produk',$produk[$i]);
        //    $this->db->update('produk_group', $data_produk1);
        //}
    }

    function getRange($low, $high){
        //$ignore = array('aktif');
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b','b.id_produk_optional=a.id_produk');
        $this->db->where('b.harga_fix >=', $low);
        $this->db->where('b.harga_fix <=', $high);
        //$this->db->where_not_in('grup',$ignore);
        $this->db->where('status','on');
        $this->db->order_by('a.id_produk asc');
        $r = $this->db->get();
        return $r->result();
    }

    function update_group_manual($iduser, $idgroup, $nama, $gambar, $ket, $mulai, $akhir, $posisi, $produk, $status){
        $idf = base64_decode($idgroup);
        $id = $this->encrypt->decode($idf);

        //HAPUS SEMUA PRODUK DARI GROUP DAN NANTI AKAN DIINSERT ULANG
        $this->db->delete('produk_group',array('id_group_name' => $id));

        $sl1 = $nama;
        $sl2 = strtolower($sl1);
        $sl3 = str_replace(' ','-',$sl2);
        $sl4 = str_replace('%','-persen',$sl3);

        $data_grup = array(
            'name_group'    => $nama,
            'slug'          => $sl4,
            'gambar'        => $gambar,
            'keterangan'    => $ket,
            'status'        => $status,
            'posisi'        => $posisi,
            'mulai'         => $mulai,
            'berakhir'      => $akhir,
            'user_ubah'     => $iduser,
            'diubah'        => date('Y-m-d'),
        );

        $this->db->where('id', $id);
        $this->db->update('produk_group_name', $data_grup);

        $count = count($produk);
        for($i=0; $i<$count; $i++) {
            $data_produk = array(
                'id_group_name'     => $id,
                'id_produk_group'   => $produk[$i],
            );
            $this->db->insert('produk_group', $data_produk);

            $tandai = array(
                'grup' => '',
            );
            $this->db->where('id_produk', $produk[$i]);
            $this->db->update('produk_grouping', $tandai);
        }
    }

    function off_group($idgroup){
        $idf = base64_decode($idgroup);
        $id = $this->encrypt->decode($idf);
        $off_data = array(
            'status' => '',
            );
        $this->db->where('id', $id);
        $off = $this->db->update('produk_group_name', $off_data);
    }

    function on_group($idgroup){
        $idf = base64_decode($idgroup);
        $id = $this->encrypt->decode($idf);
        $off_data = array(
            'status' => 'on',
            );
        $this->db->where('id', $id);
        $off = $this->db->update('produk_group_name', $off_data);
    }

    function get_produkyangdigrup($idgroup){
        $idf = base64_decode($idgroup);
        $id = $this->encrypt->decode($idf);

        $this->db->select('*');
        $this->db->from('produk_group');
        $this->db->where('id_group_name',$id);
        return $this->db->get()->result();
    }

    function get_namegroup($idgroup){
        $idf = base64_decode($idgroup);
        $id = $this->encrypt->decode($idf);

        $this->db->select('name_group');
        $this->db->from('produk_group_name');
        $this->db->where('id',$id);
        $x = $this->db->get();
        return $x->row_array();
    }

    function hapus_group($idgroup, $idprodukdarigrup){
        $idf = base64_decode($idgroup);
        $id = $this->encrypt->decode($idf);

        //$count = count($idprodukdarigrup);
        //for($i=0; $i<$count; $i++) {
        //  $data_produk = array(
        //        'grup'    => '',
        //    );
        //    $this->db->where('id_produk', $idprodukdarigrup[$i]);
        //    $this->db->update('produk_grouping', $data_produk);
        //}

        $this->db->delete('produk_group_name',array('id' => $id));
        $this->db->delete('produk_group',array('id_group_name' => $id));
    }

    function get_grup_all($id){
        $idf = base64_decode($id);
        $idx = $this->encrypt->decode($idf);

        $ignore = array('');
        $this->db->select('*');
        $this->db->where('id',$idx);
        $this->db->where_not_in('status', $ignore);
        $r = $this->db->get('produk_group_name');
        return $r->result();
    }

    function data_produk_by_id_group($idgrup){
        $idf = base64_decode($idgrup);
        $idx = $this->encrypt->decode($idf);

        $ignore = array('');
        $this->db->select('a.*, b.id_produk, b.nama_produk, b.artikel, b.gambar,c.*');
        $this->db->from('produk_group a');
        $this->db->join('produk b', 'b.id_produk=a.id_produk_group', 'left');
        $this->db->join('produk_get_color c','c.id_produk_optional=b.id_produk');
        $this->db->where('a.id_group_name', $idx);
        $this->db->group_by('b.id_produk');
        return $this->db->get();    
    }

    function get_list_produk_tong_sampah(){ 
        $this->db->select('*');
        $this->db->from('produk a');
        //$this->db->join('produk_jenis b', 'a.jenis=b.jenis','left');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk');
        //$this->db->join('master_barang b','b.artikel=a.artikel','left');
        //$this->db->join('merk c','a.merk=c.merk_id','left');
        //$this->db->join('kategori_divisi d', 'a.id_kategori_divisi=d.kat_divisi_id','left');
        $this->db->where('a.status','dump');
        $this->db->order_by('a.id_produk desc');
        $this->db->group_by('a.id_produk');
        $q = $this->db->get();
        return $q->result();
    }

    function get_list_produk_for_option_color($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_color c','b.id_opsi_get_color=c.id_opsi_color');
        $this->db->where('b.id_produk_optional', $idp);
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
    //  $this->db->where('d.opsi_size','20');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_gbdata($skup){
        $this->db->select('COUNT(gambar) as totalgambar');
        $this->db->from('produk_image b');
        $this->db->where('b.identity_produk', $skup);
        $f = $this->db->get();
        return $f->row_array();
    }

// STOK UKURAN
    function get_list_produk_for_option_size20($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','20');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size21($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','21');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size22($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','22');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size23($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','23');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size24($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','24');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size25($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','25');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size26($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','26');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size27($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','27');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size28($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','28');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size29($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','29');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size30($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','30');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size31($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','31');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size32($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','32');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size33($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','33');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size34($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','34');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size35($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','35');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size36($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','36');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size37($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','37');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size38($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','38');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size39($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','39');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size40($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','40');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size41($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','41');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size42($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','42');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size43($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','43');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size44($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','44');
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_list_produk_for_option_size45($idp){ 
        $this->db->select('*');
        $this->db->from('produk_get_color b');
        $this->db->join('produk_opsional_size d','b.id_opsi_get_size=d.id_opsi_size');
        $this->db->where('b.id_produk_optional', $idp);
        $this->db->where('d.opsi_size','45');
        $f = $this->db->get();
        return $f->row_array();
    }

// END STOK UKURAN


    function get_list_url_for_copy($idp){
        $idf = base64_decode($idp);
        $id = $this->encrypt->decode($idf);
        $this->db->select('slug');
        $this->db->from('produk');
        $this->db->where('id_produk', $id);
        $f = $this->db->get();
        return $f->result();    
    }

    function get_list_produk_for_preview($id){ 
        $this->db->select('produk.nama_produk,produk.slug,produk.artikel,produk.keterangan,produk.tags,produk.status,produk.harga_retail,produk.harga_odv,produk.diskon,produk.stok,produk.berat,produk.point,produk.status,produk.parent,produk.tgl_dibuat,produk.tgl_diubah,rt.nama_depan as user1,ty.nama_depan as user2,merk.merk,kat.kategori as kategori, parent_kategori.id_parent, parent_kategori.parent_kategori AS parentnya_produk'); //produk_milik.milik as barang_milik
        $this->db->from('produk');
        //$this->db->join('produk_milik', 'produk.milik=produk_milik.id_milik','left');
    //  $this->db->join('produk_jenis', 'produk.jenis=produk_jenis.id_jenis','left');
        $this->db->join('merk', 'produk.merk=merk.merk_id','left');
        $this->db->join('kategori kat', 'produk.kategori=kat.kat_id','left');
        $this->db->join('parent_kategori', 'parent_kategori.id_parent=produk.parent','left');
        $this->db->join('user rt', 'produk.dibuat=rt.id','left');
        $this->db->join('user ty', 'produk.diubah=ty.id','left');
        $this->db->where('produk.id_produk',$id);
        $q = $this->db->get();
        return $q->row();
    }

    function get_data_all($id){
        $idf = base64_decode($id);
        $idp = $this->encrypt->decode($idf);
        $this->db->select('*');
        $this->db->where('id_produk', $idp);
        $get = $this->db->get('produk');
        return $get->row_array();
    }

//  function get_data_jenis(){
//      $this->db->select('*');
//      $this->db->where('aktif','on');
//      $this->db->from('produk_jenis');
//      $g = $this->db->get();
//      return $g->result_array(); 
//  }

    function get_kat_divisi(){
        $this->db->select('*');
        $this->db->where('aktif','on');
        $this->db->from('kategori_divisi');
        $g = $this->db->get();
        return $g->result();    
    }

    function get_data_coloring($id){
        $idf = base64_decode($id);
        $idp = $this->encrypt->decode($idf);

        $this->db->where('id_produk_optional', $idp);
        $this->db->from('produk_get_color');
        $c = $this->db->get();
        return $c->result_array();
    }

    function get_data_color_all(){
        $this->db->select('*');
        $this->db->from('produk_opsional_color');
        $cx = $this->db->get();
        return $cx->result_array();
    }

    function get_data_size_all(){
        $this->db->select('*');
        $this->db->from('produk_opsional_size');
        $cx = $this->db->get();
        return $cx->result_array();
    }

    function get_data_option_and_stok($id){
        $idf = base64_decode($id);
        $idp = $this->encrypt->decode($idf);
        $this->db->select('*');
        $this->db->from('produk_get_color');
        $this->db->where('id_produk_optional', $idp);
        $d = $this->db->get();
        return $d->result_array();
    }

    function get_data_seller(){
        $this->db->select('*');
        $this->db->where('status_seller','aktifSeller');
        $q = $this->db->get('seller');
        return $q->result();
    }

    function get_data_divisi_all(){
        $this->db->select('*');
        $this->db->where('aktif','on');
        $q = $this->db->get('kategori_divisi');
        return $q->result_array();
    }

    function get_sku($idp){
        $this->db->select('sku_produk');
        $this->db->where('id_produk',$idp);
        $q = $this->db->get('produk');
        return $q->row_array(); 
    }

    function get_data_imaging($sku){
        //$idf = base64_decode($id);
        //$idp = $this->encrypt->decode($idf);
        $this->db->where('identity_produk', $sku);
        $this->db->from('produk_image');
        $c = $this->db->get();
        return $c->result_array();
    }

    function get_src($token){
        $this->db->select('token,gambar');
        $this->db->where('token',$token);
        $q = $this->db->get('produk_image');
        return $q->result();    
    }

    function get_data_milik(){
      $this->db->select('*');
      $this->db->where('aktif','on');
      $this->db->from('produk_milik');
      $g = $this->db->get();
      return $g->result();
    } 

    function find_kategori($filter_kategori){
        $this->db->select('*');
        $this->db->where('kat_id',$filter_kategori);
        $this->db->where('aktif','on');
        $q = $this->db->get('kategori');
        return $q->row_array();
    }

    function get_kategori(){
        $this->db->where('aktif','on');
        $q = $this->db->get('kategori');
        return $q->result();
    }

    function get_parent_kategori(){
        $this->db->where('aktif','on');
        $this->db->order_by('id_kategori asc');
        $g = $this->db->get('parent_kategori');
        return $g->result();
    }
    
//  function get_milik(){
//      $this->db->where('aktif','on');
//      $this->db->order_by('id_milik desc');
//      $g = $this->db->get('produk_milik');
//      return $g->result();
//  }

    function get_merk(){
        $this->db->where('aktif','on');
        $this->db->order_by('merk_id');
        $g = $this->db->get('merk');
        return $g->result();
    }

//  function get_jenis(){
//      $this->db->where('aktif','on');
//      $this->db->order_by('id_jenis asc');
//      $g = $this->db->get('produk_jenis');
//      return $g->result();
//  }

    function get_size(){
        $this->db->order_by('id_opsi_size');
        $g = $this->db->get('produk_opsional_size');
        return $g->result();
    }

    function get_color(){
        $this->db->order_by('id_opsi_color');
        $g = $this->db->get('produk_opsional_color');
        return $g->result();
    }

    function off_produk($id){
        $off_data = array(
            'status' => '',
            );
        $this->db->where('id_produk', $id);
        $off = $this->db->update('produk', $off_data);
    }

    function on_produk($id){
        $off_data = array(
            'status' => 'on',
            );
        $this->db->where('id_produk', $id);
        $off = $this->db->update('produk', $off_data);
    }

    function on_off_produk($idxx,$dataxx){ 
        if($dataxx == 1){ // produk di OFF kan
            $dataP = array(
                'status' => '',
                );
        }else{ // produk di ON kan
            $dataP = array(
                'status' => 'on',
                );
        }

        $this->db->where('artikel', $idxx);
        $off = $this->db->update('produk', $dataP);
    }

    function get_master_by_artikel($art){
        $this->db->select('*');
        $this->db->from('master_barang');
        $this->db->where('artikel', $art);
        $t = $this->db->get();
        return $t->result();
    }

    function cek_riwayat(){
        $this->db->select('*');
        $this->db->from('log_activity');
        $this->db->where('log_tipe','23');
        $this->db->order_by('log_time desc');
        $t = $this->db->get();
        return $t->result();   
    }

    function hapus_riwayat(){
        $this->db->delete('log_activity',array('log_tipe' => 23));
    }

    function add($id_user, $data){

        // Diskon percent
        //if($data['diskon'] > 0){
        //  $diskon_percent = ($data['retail'] - $data['diskon']) / $data['retail'] * 100;
        //  $harga_net = $data['diskon'];
        //}else{
        //  $diskon_percent = 0;
        //  $harga_net = $data['retail'];
        //}

        // slug otomatis
        if($data['slug'] == ""){
            $sl1 = $data['nama'];
            $sl2 = strtolower($sl1);
            $sl3 = str_replace(' ','-',$sl2);
            //generate code unique for slug | menghindari url sama (ganda)
            $length = 4;
            $random= "";
            srand((double)microtime()*1000000);
 
            $wordnum = "abcdefghijklmnopqrstuvwxyz";
            $wordnum .= "1234567890";
 
            for($i = 0; $i < $length; $i++){
                $random .= substr($wordnum, (rand()%(strlen($wordnum))), 1);
            }
            $slug = $sl3.'-'.$random;
        }else{
            $slug = $data['slug'];
        }

        $data_produk = array(
            'nama_produk'   => $data['nama'], 
            'sku_produk'    => $data['identity_produk'],
            'slug'          => $slug,
            //'jenis'           => $status_barang,
            'artikel'       => $data['artikel'],
            'merk'          => $data['merknya'],
            'keterangan'    => $data['editor1'],
            'tags'          => $data['tags'], 
            //'id_kategori_divisi' => $data['kat_divisi'],
            'kategori'      => $data['kategori'],
            'parent'        => $data['parent'],
            //'harga_retail'    => $data['retail'],
            //'harga_odv'       => round($odv_bisnis),
            //'harga_net'       => $harga_net,
            //'diskon'      => round($diskon_percent),
            //'diskon_rupiah'   => $data['diskon'],
            'idseller'      => $data['sellerID'],
            'berat'         => $data['berat'], 
            'gambar'        => $data['gambar'],
            'point'         => $data['point'],
            'status'        => $data['status'],
            'dibuat'        => $id_user,
            'tgl_dibuat'    => date('Y-m-d H:i:s'),
        );
        $this->db->insert('produk', $data_produk);

        $last_insert_id = $this->db->insert_id();

        // tracking diskon
        //$cnt = count($_POST['harga_dicoret']);
        //for($i=0; $i<$cnt; $i++) {
        //  if($data['harga_dicoret'] > 0){
        //      $produk_diskon = array(
        //          'id_produk_diskon'  => $last_insert_id,
        //          'warna'             => $data['color'][$i],
        //          'ukuran'            => $data['size'][$i],
                    //'diskon'          => round(($data['harga_dicoret'][$i] - $data['harga_fix'][$i]) / $data['harga_dicoret'][$i] * 100),
        //          'diskon_rupiah'     => $data['harga_dicoret'][$i] - $data['harga_fix'][$i],
        //          'retail_before'     => $data['harga_dicoret'][$i],
        //          'retail_after'      => $data['harga_fix'][$i],
        //          'tgl'               => date('Y-m-d'),
        //          'tgl_waktu'         => date('Y-m-d H:i:s'),
        //          'user_pengubah'     => $id_user,
        //      );
        //      $this->db->insert('tracking_discount', $produk_diskon);
        //  }
        //}

        // gambar tambahan
        $xxx = array_filter($_POST['gambar_tambah']);
        if(!empty($_POST['gambar_tambah'])){
            $count = count($xxx);
            for($i=0; $i<$count; $i++){
                    $data_add = array(
                        'identity_produk'   => $data['identity_produk'],
                        'gambar'            => $data['gambar_tambah'][$i],
                    );
                    $this->db->insert('produk_image', $data_add);
            }
        }

        // produk option size, color, stok, url
        $count = count($_POST['size']);
        for($i=0; $i<$count; $i++) {
            $data_size = array(
                'id_produk_optional'=> $last_insert_id,
                'id_opsi_get_color' => $data['color'][$i],
                'id_opsi_get_size'  => $data['size'][$i],
                'stok'              => $data['stock'][$i],
                'harga_dicoret'     => $data['harga_dicoret'][$i],
                'harga_fix'         => $data['harga_fix'][$i],
                'lokasi_barang'     => $data['lokasi_barang'][$i],
            );
            $this->db->insert('produk_get_color', $data_size);
        }
        // produk option color
        //$count = count($_POST['color']);
        //for($i=0; $i<$count; $i++) {
       // $data_size = array(
        //  'id_produk' => $last_insert_id,
        //    'id_opsi_get_color' => $data['color'][$i],
        //);
        //$this->db->insert('produk_get_color', $data_size);
        //}
        // produk option stok
        //$count = count($_POST['stock']);
        //for($i=0; $i<$count; $i++) {
        //$data_size = array(
        //  'id_produk' => $last_insert_id,
        //    'id_opsi_get_stok' => $data['stock'][$i],
        //);
        //$this->db->insert('produk_get_stok', $data_size);
        //}
        
    }   

    function duplikat_data($data_duplikat){
        $this->db->insert('produk', $data_duplikat);
    }

    function update_produk($id,$id_user,$data){ //update_produk($id,$id_user,$data,$status_barang)

        // Diskon percent
        //if($data['diskon'] > 0){
        //  $diskon_percent = ($data['retail'] - $data['diskon']) / $data['retail'] * 100;
        //  $harga_net = $data['diskon'];
        //}else{
        //  $diskon_percent = 0;
        //  $harga_net = $data['retail'];
        //}

        $data_produk = array(
            'nama_produk'   => $data['nama'], 
            'sku_produk'    => $data['identity_produk'],
            'slug'          => $data['slug'],
            //'jenis'           => $status_barang,
            'artikel'       => $data['artikel'],
            'merk'          => $data['merknya'],
            'keterangan'    => $data['editor1'],
            'tags'          => $data['tags'],
            //'id_kategori_divisi' => $data['kat_divisi'],
            'kategori'      => $data['kategori'],
            'parent'        => $data['parent'],         
            //'harga_retail'    => $data['retail'],
            //'harga_odv'       => round($odv_bisnis),
            //'harga_net'       => $harga_net,
            //'diskon'      => round($diskon_percent),
            //'diskon_rupiah'   => $data['diskon'],
            'idseller'      => $data['sellerID'],
            'berat'         => $data['berat'],
            'gambar'        => $data['gambar'],
            'point'         => $data['point'],
            'status'        => $data['status'],
            'diubah'        => $id_user,
            'tgl_diubah'    => date('Y-m-d H:i:s'),
        );

        $this->db->where('id_produk', $id);
        $this->db->update('produk', $data_produk);

        // tracking diskon
        //$rs = array_filter($_POST['color_update']);
        //$cnt = count($rs);
        //for($i=0; $i<$cnt; $i++) {
        //  if($data['harga_dicoret'] != $data['befdiskon']){
        //      $produk_diskon = array(
        //          'id_produk_diskon'  => $id,
        //          'warna'             => $data['color_update'][$i],
        //          'ukuran'            => $data['size_update'][$i],
                    //'diskon'          => round(($data['harga_dicoret'][$i] - $data['harga_fix'][$i]) / $data['harga_dicoret'][$i] * 100),
        //          'diskon_rupiah'     => $data['harga_dicoret'][$i] - $data['harga_fix'][$i],
        //          'retail_before'     => $data['harga_dicoret'][$i],
        //          'retail_after'      => $data['harga_fix'][$i],
        //          'tgl'               => date('Y-m-d'),
        //          'tgl_waktu'         => date('Y-m-d H:i:s'),
        //          'user_pengubah'     => $id_user,
        //      );
        //      $this->db->insert('tracking_discount', $produk_diskon);
        //  }else{
        //      echo "kosong";
        //  }
        //}

        //hapus semua data warna dan ukuran dan akan di insert ulang 
        //$this->db->delete('produk_get_size',array('id_produk' => $id));
        $this->db->delete('produk_get_color',array('id_produk_optional' => $id));

        $r = array_filter($_POST['color_update']);

        if(!empty($_POST['color_update'])){

            $count = count($r);
            for($i=0; $i<$count; $i++) {
                $data_color = array(
                    'id_produk_optional'=> $id,
                    'id_opsi_get_color' => $data['color_update'][$i],
                    'id_opsi_get_size'  => $data['size_update'][$i],
                    'stok'              => $data['stock_update'][$i],
                    'harga_dicoret'     => $data['harga_dicoret'][$i],
                    'harga_fix'         => $data['harga_fix'][$i],
                    'lokasi_barang'     => $data['lokasi_barang_update'][$i],
                );
                $this->db->where('id_produk_optional',$id);
                $this->db->insert('produk_get_color', $data_color);
            }
        }

        
        // update gambar tambahan
        $xx = array_filter($_POST['gambar_tambah']);
        if(!empty($_POST['gambar_tambah'])){
            $count = count($xx);
            for($i=0; $i<$count; $i++){
            $data_add = array(
                'identity_produk'   => $data['identity_produk'],
                'gambar'            => $data['gambar_tambah'][$i],
            );
            $this->db->insert('produk_image', $data_add);
            }
        }
    }

    function buang_produk($id){
        $idf = base64_decode($id);
        $idp = $this->encrypt->decode($idf);
        $data_produk = array(
            'status' => 'dump',
        );
        $this->db->where('id_produk', $idp);
        $this->db->update('produk', $data_produk);
    }

    function renew_produk($id){
        $idf = base64_decode($id);
        $idp = $this->encrypt->decode($idf);
        $data_produk = array(
            'status' => 'on',
        );
        $this->db->where('id_produk', $idp);
        $this->db->update('produk', $data_produk);
    }

    function get_gb_utama($id){
        $idf = base64_decode($id);
        $idp = $this->encrypt->decode($idf);
        $this->db->select('gambar');
        $this->db->from('produk');
        $this->db->where('id_produk', $idp);
        $r = $this->db->get();
        return $r->row_array();
    }

    function get_gb_tambahan($sku){
        $this->db->select('gambar');
        $this->db->from('produk_image');
        $this->db->where('identity_produk', $sku);
        $r = $this->db->get();
        return $r->result();
    }

    function hapus_produk($id,$sku){
        $idf = base64_decode($id);
        $idp = $this->encrypt->decode($idf);
        $query = $this->db->get_where('produk',array('id_produk'=>$idp));
        $query = $this->db->get_where('produk_image',array('identity_produk'=>$idp));
        $this->db->delete('produk', array('id_produk' => $idp));
        $this->db->delete('produk_image', array('identity_produk' => $idp));
        $this->db->delete('produk_review', array('id_produk' => $idp));
        $this->db->delete('produk_viewed', array('id_produk_view' => $idp));
        $this->db->delete('produk_get_color', array('id_produk_optional' => $idp));
        $this->db->delete('tracking_discount', array('id_produk_diskon' => $idp));
    }

    function delete_warna_select($id){
        $this->db->delete('produk_get_color', array('id_color' => $id));
    }

    function delete_size_select($id){
        $this->db->delete('produk_get_size', array('id_size' => $id));
    }

    function delete_image_select($id){
        $this->db->delete('produk_image', array('id_gambar' => $id));
    }

    function remove_dipilih($check) { //untuk menghapus yang dipilih di menu pilihan hapus
        $count = count($check);
        for($i=0; $i<$count; $i++) {
            $data = array(
                'status'    => 'dump',
            );
            $this->db->where('id_produk', $check[$i]);
            $this->db->update('produk', $data);
        }
        //$cek = array();
        //foreach($cek as $cek_id){
        //  $query = $this->db->get_where('produk_image',array('id_produk'=>$cek_id));
        //  $data = $query->result_array();
        //  foreach ($data as $resultnya) 
        //  {
        //      unlink('assets/img/produk/'.$resultnya['gambar']);
        //  }
        //}
        //$action = $this->input->post('action');
        //if ($action == "delete") {
        //  $delete = $cek;

        //  print_r($delete);
            //for ($i=0; $i < count($delete) ; $i++) { 
                
            //  $query = $this->db->get_where('produk_image',array('id_produk'=>$delete[$i]));
            //  $data = $query->result_array();
            //  foreach ($data as $resultnya) 
            //  {
            //      unlink('assets/img/produk/'.$resultnya['gambar']);
            //  }
                //$this->db->delete('produk', array('id_produk' => $delete[$i]));
                //$this->db->delete('produk_image', array('id_produk' => $delete[$i]));
        //}elseif($action == "all"){
            //$this->db->delete('produk');
            //$this->db->delete('produk_image');
        //}
    }

    function getsellerdata(){
        $this->db->select('*');
        $this->db->from('seller');
        $this->db->where('status_seller','aktifSeller');
        $r = $this->db->get();
        return $r->result();
    }

    function cariDataartikel($keyword){
        $this->db->select('art_id');
        $this->db->from('brgcp');
        $this->db->like('art_id',$keyword);
        return $this->db->get();  
    }

    function get_art_produk(){
        $this->db->select('artikel, harga_retail, harga_net');
        $this->db->from('produk');
        $this->db->where('status','on');
        $t = $this->db->get();      
        return $t->result();
    }

    function get_art_p($keyword){
        $this->db->select('artikel, harga_retail, harga_net');
        $this->db->from('produk');
        $this->db->where('status','on');
        $t = $this->db->get();      
        return $t->result();
    }

    function get_master(){
        $this->db->select('*');
        $this->db->from('master_barang');
        $r = $this->db->get();
        return $r->result();
    }

    function cekName($newnamex){
        $this->db->select('*');
        $this->db->from('brgcp');
        $this->db->where('art_id', $newnamex);
        return $this->db->get();
    }

    function cekName1($newnamex){
        $this->db->select('*');
        $this->db->from('brgcp');
        $this->db->where('art_id', $newnamex);
        $t = $this->db->get();
        return $t->row_array();
    }

    function cekArtinDB($newnamex){
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->where('artikel', $newnamex);
        $t = $this->db->get();
        return $t->row_array(); 
    }

    function get_db_brgcp(){
        $this->db->select('*');
        $this->db->from('brgcp');
        $r = $this->db->get();
        return $r->result();
    }

     function get_data_from_produk($art){
        $this->db->select('*');
        $this->db->from('brgcp');
        $this->db->where('art_id', $art);
        $g = $this->db->get();
        return $g->result();
    }

    function get_data_from_master($art){
        $this->db->select('*');
        $this->db->from('brgcp');
        $this->db->where('art_id', $art);
        $g = $this->db->get();
        return $g->result();
    }

    function data_produk_dan_master(){
        $this->db->select('a.id_produk,a.artikel as artikel1, a.diskon, 
            b.art_id as artikel2, b.retprc, c.id_produk_optional, c.id_opsi_get_color, c.id_opsi_get_size, c.stok, c.harga_dicoret as harga1, c.harga_fix as harga2');
        $this->db->from('produk a');
        $this->db->join('brgcp b','b.art_id=a.artikel','left');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk','left');
        //$this->db->where('a.status', 'on');
        $g = $this->db->get();
        return $g->result();
    }

    function produk_berubah_harga($d_pro){
        $this->db->insert('tracking_discount', $d_pro);
    }

    function update_harga_produk($id_produkk,$id_color,$id_size,$data){
        $this->db->where('id_produk_optional',$id_produkk);
        $this->db->where('id_opsi_get_color',$id_color);
        $this->db->where('id_opsi_get_size',$id_size);
        $this->db->update('produk_get_color', $data);
    }

    function cek_produk($tgl1, $tgl2){
        $this->db->select('a.id_produk_diskon, a.diskon as disc, a.diskon_rupiah, a.retail_before, a.retail_after, a.tgl, a.tgl_waktu, user_pengubah, b.*, c.id,c.nama_depan');
        $this->db->from('tracking_discount a');
        $this->db->join('produk b','b.id_produk=a.id_produk_diskon');
        $this->db->join('user c', 'c.id=a.user_pengubah');
        $this->db->where('a.tgl >=', $tgl1);
        $this->db->where('a.tgl <=', $tgl2);
        $this->db->group_by('b.id_produk');
        $t = $this->db->get();
        return $t->result();
    }

    function cekartikel($dataxx){
        $this->db->select('*');
        $this->db->from('brgcp a');
        $this->db->where('a.art_id', $dataxx);
        $this->db->group_by('a.art_id');
        return $this->db->get();
    }

    function get_produk_dump(){
        $this->db->select('*');
        $this->db->from('produk_dump');
        $t = $this->db->get();   
        return $t->result();
    }

    private function _get_datatables_query_dump()
    { 
        $this->db->select('*');
        $this->db->from('produk_dump a');
        $this->db->join('produk b', 'b.artikel=a.artikel','left');    
        $this->db->order_by('a.tgl_input desc');    

        //add custom filter here
        $tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        if($this->input->post('tgl1'))
        {      
            $this->db->where('a.tgl >=', $tgl1);
            $this->db->where('a.tgl <=', $tgl2);
        } 
 
        $i = 0;
     
        foreach ($this->column_search_dump as $item) // loop column 
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
 
                if(count($this->column_search_dump) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

    }
 
    function get_datatables_dump()
    {
        $this->_get_datatables_query_dump();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_dump()
    {
        $this->_get_datatables_query_dump();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_dump()
    {
        $this->db->from('produk_dump');
        return $this->db->count_all_results();
    }

    function get_color_list($idprodukforcolor){
        $this->db->select('*');
        $this->db->from('produk_get_color a');
        $this->db->join('produk_opsional_color b','b.id_opsi_color=a.id_opsi_get_color','left');
        $this->db->where('a.id_produk_optional', $idprodukforcolor);
        $this->db->group_by('a.id_produk_optional');
        $g = $this->db->get();
        return $g->row_array();
    }

    function get_size_produk($art1x){
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b','b.id_produk_optional=a.id_produk','left');
        $this->db->join('produk_opsional_size c','c.id_opsi_size=b.id_opsi_get_size','left');
        $this->db->join('size_chart d','d.eu=c.opsi_size','left');
        /*$this->db->where('a.status','on');*/
        $this->db->where('a.artikel',$art1x);
        return $this->db->get();
    }

    function update_harga_stok($data_harga_stok){
        $this->db->update_batch('produk_get_color', $data_harga_stok, 'id_produk_optional');
    }

    function get_produk_all_aktif(){ // hanya produk aktif
        $this->db->select('a.*,b.*,c.merk_id,d.id_milik');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b','b.id_produk_optional=a.id_produk','left');
        $this->db->join('merk c', 'c.merk_id=a.merk','left');
        $this->db->join('produk_milik d', 'd.id_milik=a.id_kategori_divisi','left');
        $this->db->where('a.status', 'on');
        $this->db->order_by('a.id_produk desc');
        $this->db->group_by('a.id_produk');
        $q = $this->db->get(); 
        return $q->result();
    }

    function cek_review($id){
        $this->db->select('*');
        $this->db->from('produk_review a');
        $this->db->where('a.id_produk', $id);
        return $this->db->get(); 
    }

    function get_idproduk($art){
        $this->db->select('id_produk');
        $this->db->from('produk a');
        $this->db->where('a.artikel', $art);
        $r = $this->db->get();    
        return $r->row_array();
    }

    function get_id_warna($warna){
        $this->db->select('id_opsi_color');
        $this->db->from('produk_opsional_color a');
        $this->db->where('a.opsi_color', $warna);
        $r = $this->db->get();    
        return $r->row_array();   
    }

    function get_id_size1($size1){
        $this->db->select('id_opsi_size');
        $this->db->from('produk_opsional_size a');
        $this->db->where('a.opsi_size', $size1);
        $r = $this->db->get();    
        return $r->row_array();      
    }

    function get_id_size2($size2){
        $this->db->select('id_opsi_size');
        $this->db->from('produk_opsional_size a');
        $this->db->where('a.opsi_size', $size2);
        $r = $this->db->get();    
        return $r->row_array();      
    }

    function get_id_size3($size3){
        $this->db->select('id_opsi_size');
        $this->db->from('produk_opsional_size a');
        $this->db->where('a.opsi_size', $size3);
        $r = $this->db->get();    
        return $r->row_array();      
    }

    function get_id_size4($size4){
        $this->db->select('id_opsi_size');
        $this->db->from('produk_opsional_size a');
        $this->db->where('a.opsi_size', $size4);
        $r = $this->db->get();    
        return $r->row_array();      
    }

    function get_id_size5($size5){
        $this->db->select('id_opsi_size');
        $this->db->from('produk_opsional_size a');
        $this->db->where('a.opsi_size', $size5);
        $r = $this->db->get();    
        return $r->row_array();      
    }

    function get_color_all(){
        $this->db->select('id_opsi_color,opsi_color');
        $this->db->from('produk_opsional_color');
        $cx = $this->db->get();
        return $cx->result();
    }

    function get_size_all(){
        $this->db->select('id_opsi_size,opsi_size');
        $this->db->from('produk_opsional_size');
        $cx = $this->db->get();
        return $cx->result();
    }

    function get_data_produk($b){
        $a = base64_decode($b);
        $id = $this->encrypt->decode($a);
        $this->db->select('sku_produk');
        $this->db->from('produk');
        $this->db->where('id_produk', $id);
        $t = $this->db->get();
        return $t->row_array();
    }
}
?>