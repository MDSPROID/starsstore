<?php
class Catalok extends CI_Model
{
  
    function get_all_produk_with_kategori($params = array(), $id_kategori){ 
        $get_id = base64_decode($id_kategori);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select('a.*,a.slug AS slug_produk,c.*,d.kat_id, d.kategori, d.gambar AS gambar_kategori, d.slug');
        $this->db->from('produk a');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk','left');
        $this->db->join('kategori d', 'd.kat_id=a.kategori');
        $this->db->where('a.status','on');
        $this->db->where('a.kategori',$idx);
        $this->db->group_by('a.id_produk');

        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('a.nama_produk',$params['search']['keywords']);
        }

        //sort data by ascending or desceding order
        if(empty($params['search']['sortBy'])){
            //$this->db->order_by('a.nama_produk',$params['search']['sortBy']);
            $this->db->order_by('a.id_produk','desc');
        }else if($params['search']['sortBy'] == "asc"){
            $this->db->order_by('a.nama_produk','asc');
        }else if($params['search']['sortBy'] == "desc"){
            $this->db->order_by('a.nama_produk','desc');
        }else if($params['search']['sortBy'] == "asc_price"){
            $this->db->order_by('a.diskon_rupiah','asc');
        }else if($params['search']['sortBy'] == "desc_price"){
            $this->db->order_by('a.diskon_rupiah','desc');
        }

        // filter harga min dan max
        if(empty($params['search']['maxH'])){
            $this->db->order_by('a.diskon_rupiah asc');
        }else if(!empty($params['search']['maxH'])){
            //$priceR = explode(',', $params['search']['price']);
            $this->db->where('a.diskon_rupiah BETWEEN "'.$params['search']['minH']. '" AND "'.$params['search']['maxH'].'"');
        }
        //sort data by brand
        if(!empty($params['search']['brand'])){
            $this->db->where('a.merk',$params['search']['brand']);
        }elseif($params['search']['brand'] = 0){

        }
        // sort data by warna
        if(!empty($params['search']['colour'])){
            $this->db->where_in('c.id_opsi_get_color',explode(',', $params['search']['colour']));
        }
        if(!empty($params['search']['rt'])){
            $this->db->where_in('a.rating_produk_for_filter',explode(',', $params['search']['rt']));
        }
        // sort data by ukuran
        if(!empty($params['search']['size'])){
            $this->db->where_in('c.id_opsi_get_size',explode(',', $params['search']['size']));
            $this->db->where('c.stok > 0');
        }

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result():FALSE;
    }

    function getRows($params = array(), $id_kategori){
        $get_id = base64_decode($id_kategori);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select('a.*,a.slug AS slug_produk,c.*,d.kat_id, d.kategori, d.gambar AS gambar_kategori, d.slug');
        $this->db->from('produk a');
        $this->db->join('produk_get_color c','c.id_produk_optional = a.id_produk','left');
        $this->db->join('kategori d', 'd.kat_id=a.kategori');
        $this->db->where('a.status','on');   

        if(array_key_exists("bds", $params)){

            if($params['bds'] == "kategori"){
                $this->db->where('a.kategori',$idx);
            }else if($params['bds'] == "sub-kategori"){
                $this->db->where('a.parent',$idx);
            }else if($params['bds'] == "merk"){
                $this->db->where('a.merk',$idx);
            }else if($params['bds'] == "pencarian"){
                $this->db->where('a.status','on'); 
                $this->db->like('a.nama_produk',$idx);
                $this->db->or_like('a.tags',$idx);
                $this->db->or_like('a.keterangan',$idx);
            }else if($params['bds'] == "promo-menarik"){
                $this->db->join('produk_group e', 'e.id_produk_group=a.id_produk', 'left');
                $this->db->where('id_group_name', $idx);
            }else if($params['bds'] == "terbaru"){
                $this->db->order_by('a.id_produk desc');
            }else if($params['bds'] == "merk-terbaru"){
                $this->db->where('a.merk',$idx);
                $this->db->order_by('a.id_produk desc');
            }

        }
        
        $this->db->group_by('a.id_produk');

        //sort data by ascending or desceding order
        if(empty($params['search']['sortBy'])){
            //$this->db->order_by('a.nama_produk',$params['search']['sortBy']);
            $this->db->order_by('a.nama_produk','desc');
        }else if($params['search']['sortBy'] == "asc"){
            $this->db->order_by('a.nama_produk','asc');
        }else if($params['search']['sortBy'] == "desc"){
            $this->db->order_by('a.nama_produk','desc');
        }else if($params['search']['sortBy'] == "asc_price"){
            $this->db->order_by('c.harga_fix','asc');
        }else if($params['search']['sortBy'] == "desc_price"){
            $this->db->order_by('c.harga_fix','desc');
        }

        // filter harga min dan max
        if(empty($params['search']['maxH'])){
            $this->db->order_by('c.harga_fix asc');
        }else if(!empty($params['search']['maxH'])){
            //$priceR = explode(',', $params['search']['price']);
            $this->db->where('c.harga_fix BETWEEN "'.$params['search']['minH']. '" AND "'.$params['search']['maxH'].'"');
        }
        // sort data by warna
        if(!empty($params['search']['colour'])){
            $this->db->where_in('c.id_opsi_get_color',explode(',', $params['search']['colour']));
            $this->db->where('c.stok > 0');
        }
        // sort data by ukuran
        if(!empty($params['search']['size'])){
            $this->db->where_in('c.id_opsi_get_size',explode(',', $params['search']['size']));
            $this->db->where('c.stok > 0');
        }
        // sort data by brand
        if(!empty($params['search']['brand'])){
            $this->db->where_in('a.merk',$params['search']['brand']);
        }
        // sort data by rating is disabled
        //if(!empty($params['search']['rating'])){
        //    $this->db->where_in('a.rating_produk_for_filter',explode(',', $params['search']['rating']));
        //}

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result():FALSE;
    }

    function getRowsterbaru($params = array()){
        
        $this->db->select('a.*,a.slug AS slug_produk,c.*,d.kat_id, d.kategori, d.gambar AS gambar_kategori, d.slug');
        $this->db->from('produk a');
        $this->db->join('produk_get_color c','c.id_produk_optional = a.id_produk','left');
        $this->db->join('kategori d', 'd.kat_id=a.kategori');

        //if(array_key_exists("bds", $params)){   
        //    if($params['bds'] == "terbaru"){
        //        $this->db->order_by('id_produk desc');
        //    }
        //}
        $this->db->where('a.status','on');       
        $this->db->group_by('a.id_produk');

        //sort data by ascending or desceding order
        if(empty($params['search']['sortBy'])){
            //$this->db->order_by('a.nama_produk',$params['search']['sortBy']);
            $this->db->order_by('a.nama_produk','desc');
        }else if($params['search']['sortBy'] == "asc"){
            $this->db->order_by('a.nama_produk','asc');
        }else if($params['search']['sortBy'] == "desc"){
            $this->db->order_by('a.nama_produk','desc');
        }else if($params['search']['sortBy'] == "asc_price"){
            $this->db->order_by('c.harga_fix','asc');
        }else if($params['search']['sortBy'] == "desc_price"){
            $this->db->order_by('c.harga_fix','desc');
        }

        // filter harga min dan max
        if(empty($params['search']['maxH'])){
            $this->db->order_by('c.harga_fix asc');
        }else if(!empty($params['search']['maxH'])){
            //$priceR = explode(',', $params['search']['price']);
            $this->db->where('c.harga_fix BETWEEN "'.$params['search']['minH']. '" AND "'.$params['search']['maxH'].'"');
        }
        // sort data by warna
        if(!empty($params['search']['colour'])){
            $this->db->where_in('c.id_opsi_get_color',explode(',', $params['search']['colour']));
            $this->db->where('c.stok > 0');
        }
        // sort data by ukuran
        if(!empty($params['search']['size'])){
            $this->db->where_in('c.id_opsi_get_size',explode(',', $params['search']['size']));
            $this->db->where('c.stok > 0');
        }
        // sort data by brand
        if(!empty($params['search']['brand'])){
            $this->db->where_in('a.merk',$params['search']['brand']);
        }
        // sort data by rating is disabled
        //if(!empty($params['search']['rating'])){
        //    $this->db->where_in('a.rating_produk_for_filter',explode(',', $params['search']['rating']));
        //}

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result():FALSE;
    }

    function get_price_tertinggi($id_parent_kategori){
        $get_id = base64_decode($id_parent_kategori);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select_max('harga_net');
        $this->db->where('parent', $idx);
        $this->db->from('produk');
        $a = $this->db->get();
        return $a->result();
    }

    function get_brand(){
        $this->db->select('*');
        $this->db->from('merk');
        $this->db->where('aktif','on');
        $this->db->order_by('merk_id ASC');
        $q = $this->db->get();
        return $q->result();
    }

    function get_warna(){
        $this->db->select('*');
        $this->db->from('produk_opsional_color');
        $this->db->order_by('id_opsi_color ASC');
        $q = $this->db->get();
        return $q->result();
    }

    function get_ukuran(){
        $this->db->select('*');
        $this->db->from('produk_opsional_size');
        $this->db->order_by('id_opsi_size ASC');
        $q = $this->db->get();
        return $q->result();
    }

    function get_nama_kategori_for_breadcrumb($id_parent_kategori){
        $get_id = base64_decode($id_parent_kategori);
        $idx    = $this->encrypt->decode($get_id);

        $this->db->select('kategori, slug');
        $this->db->from('kategori a');
        $this->db->join('parent_kategori b', 'b.id_kategori=a.kat_id', 'left');
        $this->db->where('b.id_parent', $idx);
        $t = $this->db->get();
        return $t->result();
    }

    function get_id_from_merk($read){
        $this->db->select('*');
        $this->db->from('merk');
        $this->db->where('slug', $read);
        return $this->db->get();
    }

    function get_id_parent_kategori($read){
        $this->db->select('*');
        $this->db->from('parent_kategori');
        $this->db->where('slug_parent', $read);
        return $this->db->get();
    }

    function get_id_from_kategori($read){
        $this->db->select('*');
        $this->db->from('kategori');
        $this->db->where('slug', $read);
        return $this->db->get();
    }

    function get_data_parent_kategori($id_kategori){
        $get_id = base64_decode($id_kategori);
        $idx = $this->encrypt->decode($get_id);

        $this->db->select('*');
        $this->db->from('parent_kategori');
        $this->db->where('id_kategori', $idx);
        $q = $this->db->get();
        return $q->result();
    }

    function get_produk_berdasarkan_kategori($id_kategori){
        $get_id = base64_decode($id_kategori);
        $idx = $this->encrypt->decode($get_id);
        
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b', 'b.id_produk_optional=a.id_produk', 'left');
        $this->db->where('a.kategori', $idx);
        $this->db->where('a.status','on');
        $this->db->group_by('a.id_produk');
        $r = $this->db->get();
        return $r->result();
    }

    function get_id_brand($read){
        $this->db->select('*');
        $this->db->where('slug', $read);
        $q = $this->db->get('merk');
        return $q->result();
    }

    function get_all_produk_with_brand($params = array(), $id_brand){
        $get_id = base64_decode($id_brand);
        $idx    = $this->encrypt->decode($get_id);

        $this->db->select('a.*');
        $this->db->from('produk a');
        //$this->db->join('produk_get_size b','b.id_produk = a.id_produk','left');
        $this->db->join('produk_get_color c','c.id_produk_optional = a.id_produk','left');
        //$this->db->join('parent_kategori d', 'd.id_parent=a.parent');
        $this->db->where('a.status','on');
        $this->db->where('a.merk',$idx);
        $this->db->group_by('a.id_produk');

        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('a.nama_produk',$params['search']['keywords']);
        }

        //sort data by ascending or desceding order
        if(empty($params['search']['sortBy'])){
            //$this->db->order_by('a.nama_produk',$params['search']['sortBy']);
            $this->db->order_by('a.id_produk','desc');
        }else if($params['search']['sortBy'] == "asc"){
            $this->db->order_by('a.nama_produk','asc');
        }else if($params['search']['sortBy'] == "desc"){
            $this->db->order_by('a.nama_produk','desc');
        }else if($params['search']['sortBy'] == "asc_price"){
            $this->db->order_by('a.diskon_rupiah','asc');
        }else if($params['search']['sortBy'] == "desc_price"){
            $this->db->order_by('a.diskon_rupiah','desc');
        }

        // filter harga min dan max
        if(empty($params['search']['maxH'])){
            $this->db->order_by('a.harga_net asc');
        }else if(!empty($params['search']['maxH'])){
            //$priceR = explode(',', $params['search']['price']);
            $this->db->where('a.harga_net BETWEEN "'.$params['search']['minH']. '" AND "'.$params['search']['maxH'].'"');
        }

        //sort data by parent kategori
        if(!empty($params['search']['parent_kategori'])){
            $this->db->where_in('a.parent', explode(',', $params['search']['parent_kategori']));
        }
        
        //sort data by brand
        if(!empty($params['search']['brand'])){
            $this->db->where('a.merk',$params['search']['brand']);
        }elseif($params['search']['brand'] = 0){

        }

        // sort data by warna
        if(!empty($params['search']['colour'])){
            $this->db->where_in('c.id_opsi_get_color',explode(',', $params['search']['colour']));
        }
        // sort by rating
        if(!empty($params['search']['rt'])){
            $this->db->where_in('a.rating_produk_for_filter',explode(',', $params['search']['rt']));
        }
        // sort data by ukuran
        if(!empty($params['search']['size'])){
            $this->db->where_in('c.id_opsi_get_size',explode(',', $params['search']['size']));
            $this->db->where('c.stok > 0');
        }
       
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function get_parent_kategori(){
        $this->db->select('*');
        $this->db->from('parent_kategori');
        $this->db->where('aktif','on');
        $this->db->order_by('id_parent ASC');
        $q = $this->db->get();
        return $q->result();
    }

    function get_price_tertinggi_for_brand($id_brand){
        $get_id = base64_decode($id_brand);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select_max('harga_net');
        $this->db->where('merk', $idx);
        $this->db->from('produk');
        $a = $this->db->get();
        return $a->result();
    }

    // promo slide utama

   function get_id_promo($read){
        $this->db->select('*');
        $this->db->where('slug', $read);
        $q = $this->db->get('promo_slide_utama');
        return $q->result();
    }

     function get_all_produk_with_1diskon($params = array(), $category, $get_value1){
        $get_id = base64_decode($category); 
        $idx    = $this->encrypt->decode($get_id);

        $this->db->select('*');
        $this->db->from('produk a');
        //$this->db->join('produk_get_size b','b.id_produk = a.id_produk','left');
        $this->db->join('produk_get_color c','c.id_produk_optional = a.id_produk','left');
        //$this->db->join('parent_kategori d', 'd.id_parent=a.parent');
        $this->db->where('a.parent', $idx);
        $this->db->where('a.status','on');
        $this->db->where('a.diskon >= ',$get_value1, false);
        $this->db->group_by('a.id_produk');
        //$this->db->order_by('a.harga_net ASC');

        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('a.nama_produk',$params['search']['keywords']);
        }
        
        //sort data by ascending or desceding order
        if(empty($params['search']['sortBy'])){
            //$this->db->order_by('a.nama_produk',$params['search']['sortBy']);
            $this->db->order_by('a.id_produk','desc');
        }else if($params['search']['sortBy'] == "asc"){
            $this->db->order_by('a.nama_produk','asc');
        }else if($params['search']['sortBy'] == "desc"){
            $this->db->order_by('a.nama_produk','desc');
        }else if($params['search']['sortBy'] == "asc_price"){
            $this->db->order_by('a.diskon_rupiah','asc');
        }else if($params['search']['sortBy'] == "desc_price"){
            $this->db->order_by('a.diskon_rupiah','desc');
        }

        // filter harga min dan max
        if(empty($params['search']['maxH'])){
            $this->db->order_by('a.harga_net asc');
        }else if(!empty($params['search']['maxH'])){
            //$priceR = explode(',', $params['search']['price']);
            $this->db->where('a.harga_net BETWEEN "'.$params['search']['minH']. '" AND "'.$params['search']['maxH'].'"');
        }

        //sort data by parent
       // if(!empty($params['search']['parent_kategori'])){
       //     $this->db->where_in('a.parent', explode(',', $params['search']['parent_kategori']));
       // }

        //sort data by brand
        if(!empty($params['search']['brand'])){
            $this->db->where('a.merk',$params['search']['brand']);
        }elseif($params['search']['brand'] = 0){

        }

        // sort data by warna
        if(!empty($params['search']['colour'])){
            $this->db->where_in('c.id_opsi_get_color',explode(',', $params['search']['colour']));
        }
        // sort by rating
        if(!empty($params['search']['rt'])){
            $this->db->where_in('a.rating_produk_for_filter',explode(',', $params['search']['rt']));
        }
        // sort data by ukuran
        if(!empty($params['search']['size'])){
            $this->db->where_in('c.id_opsi_get_size',explode(',', $params['search']['size']));
            $this->db->where('c.stok > 0');
        }
        
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function get_all_produk_with_2diskon($params = array(), $category, $get_value1, $get_value2){
        $get_id = base64_decode($category); 
        $idx    = $this->encrypt->decode($get_id);

        $this->db->select('a.*');
        $this->db->from('produk a');
        //$this->db->join('produk_get_size b','b.id_produk = a.id_produk','left');
        $this->db->join('produk_get_color c','c.id_produk_optional = a.id_produk','left');
        //$this->db->join('parent_kategori d', 'd.id_parent=a.parent');
        $this->db->where('a.parent', $idx);
        $this->db->where('a.status','on');
        $this->db->where("a.diskon BETWEEN $get_value1 AND $get_value2");
        $this->db->group_by('a.id_produk');
        //$this->db->order_by('a.harga_net ASC');

        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('a.nama_produk',$params['search']['keywords']);
        }
        
        //sort data by parent
        //if(!empty($params['search']['parent_kategori'])){
        //    $this->db->where_in('a.parent', explode(',', $params['search']['parent_kategori']));
        //}

         //sort data by ascending or desceding order
        if(empty($params['search']['sortBy'])){
            //$this->db->order_by('a.nama_produk',$params['search']['sortBy']);
            $this->db->order_by('a.id_produk','desc');
        }else if($params['search']['sortBy'] == "asc"){
            $this->db->order_by('a.nama_produk','asc');
        }else if($params['search']['sortBy'] == "desc"){
            $this->db->order_by('a.nama_produk','desc');
        }else if($params['search']['sortBy'] == "asc_price"){
            $this->db->order_by('a.diskon_rupiah','asc');
        }else if($params['search']['sortBy'] == "desc_price"){
            $this->db->order_by('a.diskon_rupiah','desc');
        }

        // filter harga min dan max
        if(empty($params['search']['maxH'])){
            $this->db->order_by('a.harga_net asc');
        }else if(!empty($params['search']['maxH'])){
            //$priceR = explode(',', $params['search']['price']);
            $this->db->where('a.harga_net BETWEEN "'.$params['search']['minH']. '" AND "'.$params['search']['maxH'].'"');
        }

        //sort data by brand
        if(!empty($params['search']['brand'])){
            $this->db->where('a.merk',$params['search']['brand']);
        }elseif($params['search']['brand'] = 0){

        }
        // sort data by warna
        if(!empty($params['search']['colour'])){
            $this->db->where_in('c.id_opsi_get_color',explode(',', $params['search']['colour']));
        }
        // sort by rating
        if(!empty($params['search']['rt'])){
            $this->db->where_in('a.rating_produk_for_filter',explode(',', $params['search']['rt']));
        }
        // sort data by ukuran
        if(!empty($params['search']['size'])){
            $this->db->where_in('c.id_opsi_get_size',explode(',', $params['search']['size']));
            $this->db->where('c.stok > 0');
        }
        
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function get_all_produk_with_2harga($params = array(), $category, $get_value1, $get_value2){
        $get_id = base64_decode($category); 
        $idx    = $this->encrypt->decode($get_id);

        $this->db->select('a.*');
        $this->db->from('produk a');
        //$this->db->join('produk_get_size b','b.id_produk = a.id_produk','left');
        $this->db->join('produk_get_color c','c.id_produk_optional = a.id_produk','left');
        //$this->db->join('parent_kategori d', 'd.id_parent=a.parent');
        $this->db->where('a.parent', $idx);
        $this->db->where('a.status','on');
        $this->db->where("a.harga_net BETWEEN $get_value1 AND $get_value2");
        $this->db->group_by('a.id_produk');
        //$this->db->order_by('a.harga_net ASC');

        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('a.nama_produk',$params['search']['keywords']);
        }
       
        //sort data by ascending or desceding order
        if(empty($params['search']['sortBy'])){
            //$this->db->order_by('a.nama_produk',$params['search']['sortBy']);
            $this->db->order_by('a.id_produk','desc');
        }else if($params['search']['sortBy'] == "asc"){
            $this->db->order_by('a.nama_produk','asc');
        }else if($params['search']['sortBy'] == "desc"){
            $this->db->order_by('a.nama_produk','desc');
        }else if($params['search']['sortBy'] == "asc_price"){
            $this->db->order_by('a.harga_net','asc');
        }else if($params['search']['sortBy'] == "desc_price"){
            $this->db->order_by('a.harga_net','desc');
        }

        // filter harga min dan max
        if(empty($params['search']['maxH'])){
            $this->db->order_by('a.harga_net asc');
        }else if(!empty($params['search']['maxH'])){
            //$priceR = explode(',', $params['search']['price']);
            $this->db->where('a.harga_net BETWEEN "'.$params['search']['minH']. '" AND "'.$params['search']['maxH'].'"');
        }

        //sort data by brand
        if(!empty($params['search']['brand'])){
            $this->db->where('a.merk',$params['search']['brand']);
        }elseif($params['search']['brand'] = 0){

        }

        // sort data by warna
        if(!empty($params['search']['colour'])){
            $this->db->where_in('c.id_opsi_get_color',explode(',', $params['search']['colour']));
        }
        // sort by rating
        if(!empty($params['search']['rt'])){
            $this->db->where_in('a.rating_produk_for_filter',explode(',', $params['search']['rt']));
        }
        // sort data by ukuran
        if(!empty($params['search']['size'])){
            $this->db->where_in('c.id_opsi_get_size',explode(',', $params['search']['size']));
            $this->db->where('c.stok > 0');
        }
       
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function get_brand_endorse(){
        $this->db->select('a.*, b.id_produk, b.diskon');
        $this->db->from('merk a');
        $this->db->join('produk b','b.merk=a.merk_id','left');
        $this->db->group_by('a.merk');
        return $this->db->get();
    }

    function get_kat(){
        $this->db->select('*');
        $this->db->from('kategori a');
        $this->db->join('parent_kategori b','b.id_kategori=a.kat_id','left');
        $this->db->group_by('b.id_kategori');
        $this->db->order_by('a.kategori');
        return $this->db->get();
    }

     function get_kat2($kat_id1){
        $this->db->select('*');
        $this->db->from('parent_kategori');
        $this->db->where('id_kategori', $kat_id1);
        return $this->db->get();
    }
}
?>