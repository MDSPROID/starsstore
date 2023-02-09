<?php 
class Home extends CI_Model 
 {

    //function simpan_voucher1($data_voucher){
    //    $this->db->insert('voucher', $data_voucher);
    //}

    //function simpan_voucher2($data_voucher){
    //    $this->db->insert('voucher', $data_voucher);
    //}

    //function simpan_voucher3($data_voucher){
    //    $this->db->insert('voucher', $data_voucher);
    //}

    //function simpan_voucher4($data_voucher){
    //    $this->db->insert('voucher', $data_voucher);
    //}

    //function simpan_voucher5($data_voucher){
    //    $this->db->insert('voucher', $data_voucher);
    //}

    //function ambil_data(){
    //    $this->db->select('COUNT(nomor_voucher) as voucher');
    //    $this->db->from('voucher');
    //    $this->group_by('voucher.hadiah');
    //    $this->db->limit(5);
    //    $r = $this->db->get(); 
    //    return $r->result();
    //}

    function write_banner($data_info){
        $this->db->insert("banner_perclick", $data_info);
    }

    function load_email(){
        $ignore = array('e_cc','e_support','e_bcc');
        $this->db->select('*');
        $this->db->from('setting_email_account');
        $this->db->where_not_in('status',$ignore);
        $r = $this->db->get(); 
        return $r->result();
    }

    function cek_newstore($edptoko){
        $this->db->select('*');
        $this->db->from('toko');
        $this->db->where('kode_edp', $edptoko);
        $r = $this->db->get();
        return $r->row_array();
    }

    function get_coupon(){
        $this->db->select('*');
        $this->db->from('voucher_and_coupon a');
        $this->db->where('a.aktif','on');
        $this->db->where('a.valid_until >= NOW()');
        $this->db->limit(1);
        $q = $this->db->get();
        return $q->result();  
    }

    function get_pesanan_belum_dibayar($id_customer){
        $this->db->select('invoice, total_belanja');
        $this->db->from('order_customer');
        $this->db->where('status','2hd8jPl613!2_^5');
        $this->db->where('id_customer',$id_customer);
        $r = $this->db->get(); 
        return $r->result();
    }

    function get_order_menunggu_pembayaran(){
        $this->db->select('invoice,total_belanja');
        $this->db->from('order_customer a');
        $this->db->where('a.status', '2hd8jPl613!2_^5');
        $this->db->where('tanggal_order > DATE_SUB(NOW(), INTERVAL 2 DAY)');
        $r = $this->db->get();
        return $r->result();
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

    function daftar_rekening_pusat(){
        $this->db->select('name_bank, no_rek');
        $this->db->from('daftar_rekening_pusat');
        $this->db->where('aktife_stat_bank','on');       
        $r = $this->db->get(); 
        return $r->result();   
    }

    function load_email_all(){
        $this->db->select('*');
        $this->db->from('setting_email_account');
        $t = $this->db->get();
        return $t->result();
    }

    function get_parent_kategori(){
        $this->db->select('*');
        $this->db->from('parent_kategori');
        $this->db->where('aktif','on');
        $r = $this->db->get();
        return $r->result();
    }

    function get_produk_grup(){
        $this->db->select('a.name_group, a.gambar as gb_grup,b.*,c.*,d.*');
        $this->db->from('produk_group_name a');
        $this->db->join('produk_group b','b.id_group_name=a.id','left');
        $this->db->join('produk c','c.id_produk=b.id_produk_group','left');
        $this->db->join('produk_get_color d','d.id_produk_optional=c.id_produk','left');
        $this->db->where('a.status','on');
        $this->db->where('a.posisi','utama');
        $this->db->group_by('c.id_produk');
        $this->db->limit(10);
        $r = $this->db->get();
        return $r->result();
    }

    function cekinvorder($dataxx){
        $this->db->like('invoice', $dataxx);
        $this->db->order_by('id desc');
        $this->db->limit(5);
        return $this->db->get('order_customer');
    }

    function cek_data_spv($kodeEdp){
        $this->db->where('code_edp', $kodeEdp);
        return $this->db->get('data_spv');
    }

    function add_data_supervisor($data_toko){
        $this->db->insert('data_spv', $data_toko);
    }

    function set_status_default_notif_closing(){
        $data = array(
            'aktif' => '',
        );
        $this->db->where('id',8);
        $this->db->update('setting',$data);
    }

    function get_title_promo(){
        $this->db->select('id_promo,judul');
        $this->db->from('promo_slide_utama');
        $this->db->where('id_promo = 1');
        $r = $this->db->get();
        return $r->result();
    }

    function get_promo_slide(){
        $ignore = array('','expired');
        $this->db->select('*');
        $this->db->from('promo_slide_utama');
        $this->db->where('id_promo > 1');
        $this->db->where('status', 'on');
        $r = $this->db->get();
        return $r->result();
    }

    function put_in_product_viewed($id){
        $data = array(
            'id_produk_view' => $id,
            'ip'        => $this->input->ip_address(),
            'browser'   => $this->agent->browser(),
            'platform'  => $this->agent->platform(),
            'tanggal'   => date('Y-m-d H:i:s'),

        );
        $this->db->insert('produk_viewed', $data);
    }

    // pencarian produk
    function get_autocomplete($in){
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->where('status','on');
        $this->db->where("(nama_produk LIKE '%".$in."%' OR artikel LIKE '%".$in."%' OR keterangan LIKE '%".$in."%' OR tags LIKE '%".$in."%')");
        $this->db->limit(4);
        $t = $this->db->get();
        return $t->result();
    }

    //pencarian merk
    function get_autocomplete2($in){
        $this->db->select('merk,logo,slug,aktif');
        $this->db->from('merk');
        $this->db->or_like('merk', $in);
        $this->db->or_like('deskripsi', $in);
        $this->db->where('aktif','on');
        $t = $this->db->get();
        return $t->result();
    }

    function cariDataproduk($keyword){
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->or_like('nama_produk', $keyword);
        $this->db->or_like('artikel',$keyword);
        $this->db->or_like('tags',$keyword);
        $this->db->where('status','on');
        return $this->db->get();
    }

    function cariDatamerk($keyword){
        $this->db->select('b.merk_id, b.merk as merkx, b.logo, b.slug as slug_merk');
        $this->db->from('merk b');
        $this->db->or_like('b.merk',$keyword);
        $this->db->where('b.aktif','on');
        return $this->db->get();
    }

    function cariDataall($keyword){
        $this->db->select('a.*, b.merk_id, b.merk as merkx, b.logo, b.slug as slug_merk, c.id_parent, c.parent_kategori, c.kata_kunci, c.slug_parent');
        $this->db->from('produk a');
        $this->db->join('merk b','b.merk_id=a.merk','left');
        $this->db->join('parent_kategori c','c.id_parent=a.parent','left');
        $this->db->or_like('a.nama_produk', $keyword);
        $this->db->or_like('a.artikel',$keyword);
        $this->db->or_like('a.tags',$keyword);
        $this->db->or_like('b.merk',$keyword);
        $this->db->or_like('c.kata_kunci',$keyword);
        $this->db->where('a.status','on');
        $this->db->where('b.aktif','on');
        $this->db->where('c.aktif','on');
        return $this->db->get();
    }

    function cek_already_email($news){
        $this->db->select('email');
        $this->db->where('email', $news);
        return $this->db->get('newsletter');
    }

    function cek_already_email_in_dataorder($news){
        $this->db->select('email');
        $this->db->where('email', $news);
        return $this->db->get('newsletter');
    }

    function add_email_new_newsletter($news){
        $data_newsletter = array(
            'email'     => $news,
            'tipe'      => 'email',
            'status'    => 'on',
            'tgl_daftar'=> date('Y-m-d H:i:s'),
            );
        $this->db->insert('newsletter', $data_newsletter);
    }

    function cek_already_notelp($news){
        $this->db->select('email');
        $this->db->where('email', $news);
        return $this->db->get('newsletter');
    }

    function cek_already_notelp_in_dataorder($news){
        $this->db->select('email');
        $this->db->where('email', $news);
        return $this->db->get('newsletter');
    }

    function add_notelp_new_newsletter($news){
        $data_newsletter = array(
            'email'     => $news,
            'tipe'      => 'telp',
            'status'    => 'on',
            'tgl_daftar'=> date('Y-m-d H:i:s'),
            );
        $this->db->insert('newsletter', $data_newsletter);
    }

    function get_data_banner(){
        $this->db->select('*');
        $this->db->from('banner');
        $this->db->where('status_banner', 'on'); 
        $this->db->where('tgl_akhir >= NOW()');
        $banner = $this->db->get();
        return $banner->result();
    } 
 
    function get_data_slide_utama(){
        $this->db->select('*');
        $this->db->from('banner');
        $this->db->where('posisi', 'utama');
        $this->db->where('status_banner', 'on');
        $this->db->where('tgl_akhir >= NOW()');
        $this->db->order_by('id_banner desc');
        $banner = $this->db->get();
        return $banner->result();
    }

    function get_brand(){
        $this->db->select('a.*, b.id_produk, b.diskon');
        $this->db->from('merk a');
        $this->db->join('produk b','b.merk=a.merk_id','left');
        $this->db->group_by('a.merk');
        $this->db->where('a.aktif','on');
        //$this->db->limit('18');
        $banner = $this->db->get();
        return $banner->result();
    }

    function get_promo_flag(){
        $this->db->select('*');
        $this->db->from('promo_home_flag');
        $this->db->where('status', 'on');
        $this->db->where('tgl_akhir >= NOW()'); 
        $banner = $this->db->get();
        return $banner->result();   
    }

    function get_id_produk_detail($read){
        $this->db->select('id_produk,sku_produk,status');
        $this->db->where('slug', $read);
        return $this->db->get('produk');
    }

    function get_produk_latest(){ 
        $this->db->select('a.id_produk AS id_produknya, a.nama_produk, a.slug, a.merk, a.harga_retail, a.harga_odv, a.harga_net, a.diskon, a.diskon_rupiah, a.gambar,a.rating_produk, a.status, b.*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b', 'b.id_produk_optional=a.id_produk', 'left');
        $this->db->where_in('a.status','on');
        $this->db->order_by('rand()');
        $this->db->group_by('a.id_produk');
        $q = $this->db->get();
        return $q->result();
    }

    function produk_gambar_tambahan($sku){
        $this->db->select('produk_image.gambar AS gambar_tambah');
        $this->db->from('produk_image');
        $this->db->where('identity_produk', $sku);
        $q = $this->db->get();
        return $q->result();
    }

    function get_produk_discount(){
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b', 'b.id_produk_optional=a.id_produk', 'left');
        $this->db->where('a.status','on');
        $this->db->group_by('a.id_produk');
        $this->db->limit(15);
        $q = $this->db->get();
        return $q->result();
    }

    function get_data_produk_kat_utama(){
        $this->db->select('*');
        $this->db->from('kategori');
        $this->db->where('aktif','on');
        $q = $this->db->get();
        return $q->result();   
    }

    function get_produk_by_kat_utama($id_kat){
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b', 'b.id_produk_optional=a.id_produk', 'left');
        $this->db->where('a.status','on');
        $this->db->where('a.kategori',$id_kat);
        $this->db->order_by('id_produk desc');
        $this->db->group_by('a.id_produk');
        $this->db->limit(15);
        $q = $this->db->get();
        return $q->result();
    }

    function get_produk_latest2(){
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b', 'b.id_produk_optional=a.id_produk', 'left');
        $this->db->where('a.status','on');
        $this->db->order_by('id_produk desc');
        $this->db->group_by('a.id_produk');
        $this->db->limit(15);
        $q = $this->db->get();
        return $q->result();
    }

    function get_produk_randoms(){
        $this->db->select('a.id_produk AS id_produknya, a.nama_produk, a.slug, a.gambar,a.rating_produk, a.status,b.*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b', 'b.id_produk_optional=a.id_produk', 'left');
        $this->db->where_in('a.status',array('on','soldout'));
        $this->db->group_by('a.id_produk');
        $this->db->limit(20);
        $this->db->order_by('rand()');
        $q = $this->db->get();
        return $q->result();
    }

    function get_price($id,$idcolor,$idsize){
        $get_id = base64_decode($id);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select('*');
        $this->db->from('produk_get_color');
        $this->db->where('id_produk_optional', $idx);
        $this->db->where('id_opsi_get_color', $idcolor);
        $this->db->where('id_opsi_get_size', $idsize);
        return $this->db->get();
    }

    function next_p(){
        $this->db->select('a.nama_produk, a.slug');
        $this->db->from('produk a');
        $this->db->where_in('a.status',array('on'));
        $this->db->limit(1);
        $this->db->order_by('rand()');
        $q = $this->db->get();
        return $q->row_array();
    }

    function produk_detail($get_id_last){
        $get_id = base64_decode($get_id_last);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select('a.id_produk AS idp, a.nama_produk, a.slug AS slug_produk, a.artikel, a.merk, a.keterangan, a.tags, a.kategori, a.parent, a.berat,a.gambar as gbr, a.point, a.rating_produk,a.status,b.*,c.*,d.*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b', 'b.id_produk_optional=a.id_produk', 'left');
        $this->db->join('merk c', 'a.merk=c.merk_id', 'left');
        $this->db->join('produk_review d', 'd.id_produk=a.id_produk', 'left');
        //$this->db->join('produk_feedback d', 'a.id_produk=d.id_produk', 'left');
        //$this->db->join('produk_milik e', 'a.milik=e.id_milik', 'left');
        //$this->db->join('produk_jenis f', 'a.jenis=f.jenis', 'left');
        //$this->db->join('kategori_divisi g', 'a.id_kategori_divisi=g.kat_divisi_id', 'left');
        $this->db->where('a.id_produk', $idx);
        $this->db->group_by('a.id_produk');
        $q = $this->db->get();
        return $q->result();
    }

    function produk_review($get_id_last){
        $get_id = base64_decode($get_id_last);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select('b.id_produk as idprev, b.nama_review, b.review, b.rating as grating, b.tgl_review, b.status as stat_review');
        $this->db->from('produk_review b');
        $this->db->where('b.id_produk', $idx);
        $this->db->order_by('b.tgl_review desc');
        $this->db->limit(5);
        return $this->db->get();
    }

    function diskusi_produk($get_id_last){
        $get_id = base64_decode($get_id_last);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select('*');
        $this->db->from('produk_q_n_a b');
        $this->db->where('b.id_produk', $idx);
        $this->db->order_by('b.id_q_n_a desc');
        $this->db->limit(5);
        $q = $this->db->get();
        return $q->result();
    }

    function umur_produk($get_id_last){
        $get_id = base64_decode($get_id_last);
        $idx    = $this->encrypt->decode($get_id);

        $this->db->select('tgl_dibuat,tgl_diubah');
        $this->db->from('produk');
        $this->db->where('tgl_dibuat > DATE_SUB(NOW(), INTERVAL 3 DAY)');
        $this->db->where('id_produk', $idx);
        return $this->db->get();
    }

    function produk_kategori($get_id_last){
        $get_id = base64_decode($get_id_last);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select('*'); 
        $this->db->from('produk pr');
        $this->db->join('kategori kt', 'pr.kategori=kt.kat_id', 'left');
        $this->db->join('parent_kategori prt','prt.id_parent=pr.parent','left');
        $this->db->where('pr.id_produk', $idx);
        $q = $this->db->get();
        return $q->result();
    }
     
    function produk_option_size($get_id_last){
        $get_id = base64_decode($get_id_last);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select('*'); 
        $this->db->from('produk');
        $this->db->join('produk_get_color', 'produk.id_produk=produk_get_color.id_produk_optional', 'left');
        $this->db->join('produk_opsional_color', 'produk_get_color.id_opsi_get_color=produk_opsional_color.id_opsi_color', 'left');
        $this->db->join('produk_opsional_size', 'produk_get_color.id_opsi_get_size=produk_opsional_size.id_opsi_size', 'left');
        $this->db->where('produk.id_produk', $idx);
        $q = $this->db->get();
        return $q->result();
    }

    function produk_option_color($get_id_last){
        $get_id = base64_decode($get_id_last);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select('*'); 
        $this->db->from('produk');
        $this->db->join('produk_get_color', 'produk.id_produk=produk_get_color.id_produk_optional', 'left');
        $this->db->join('produk_opsional_color', 'produk_get_color.id_opsi_get_color=produk_opsional_color.id_opsi_color', 'left');
        $this->db->join('produk_opsional_size', 'produk_get_color.id_opsi_get_size=produk_opsional_size.id_opsi_size', 'left');
        $this->db->where('produk_get_color.stok > 0');
        $this->db->where('produk.id_produk', $idx);
        $this->db->group_by('produk_get_color.id_opsi_get_color');
        $q = $this->db->get();
        return $q->result();
    }

    function produk_option_color_add($get_id_last){
        $get_id = base64_decode($get_id_last);
        $idx    = $this->encrypt->decode($get_id);
        $this->db->select('*'); 
        $this->db->from('produk_get_color a');
        $this->db->join('produk_opsional_color b', 'b.id_opsi_color=a.id_opsi_get_color');
        $this->db->where('a.id_produk_optional', $idx);
        $this->db->group_by('a.id_opsi_get_color');
        $q = $this->db->get();
        return $q->result();
    }

    function produk_size($get_id_last){
        $get_id = base64_decode($get_id_last);
        $idx    = $this->encrypt->decode($get_id); 
        $this->db->select('*'); 
        $this->db->from('produk');
        $this->db->join('produk_get_size', 'produk.id_produk=produk_get_size.id_produk', 'left');
        $this->db->join('produk_opsional_size', 'produk_get_size.id_opsi_get_size=produk_opsional_size.id_opsi_size', 'left');
        $this->db->order_by('produk_opsional_size.id_opsi_size ASC');
        $this->db->where('produk.id_produk', $idx);
        $q = $this->db->get();
        return $q->result();
    }

    function get_our_store(){
        $this->db->select('*');
        $this->db->from('other_store');
        $this->db->where('status','on');
        $r = $this->db->get();
        return $r->result();
    }

    function cekKata($dataxx){
        $this->db->select('*');
        $this->db->from('toko');
        $this->db->like('nama_toko',$dataxx);
        $this->db->or_like('alamat',$dataxx);
        return $this->db->get();
    }

    function get_store_locator(){
        $this->db->select('aktif');
        $this->db->from('setting');
        $this->db->where('id',5);
        $r = $this->db->get();
        return $r->row_array();   
    }

    function cek_global_stok($get_id,$exidsize,$exidcolor){
        $data = array(
            'id_produk_optional'=> $get_id,
            'id_opsi_get_color' => $exidcolor,
            'id_opsi_get_size'  => $exidsize,
        );
        $this->db->select('stok');
        $this->db->from('produk_get_color');
        $this->db->where($data);
        //$this->db->where('stok > 0');
        $q = $this->db->get();
        return $q->result();    
    }

    function cek_global_bascket($id){
        $this->db->select('SUM(jml) as jumlah');
        $this->db->from('keranjang');
        $this->db->where('id_produk', $id);
        $q = $this->db->get();
        return $q->result();    
    }

    function add_to_bascket($id,$nama,$artikel,$merk,$point,$diskon,$berat,$after,$before,$size,$color,$jml){
        $data = array(
            'id_produk'     => $id,
            'nama_produk'   => $nama,
            'artikel'       => $artikel,
            'merk'          => $merk,
            'point'         => $point,
            'diskon'        => $diskon,
            'berat'         => $berat,
            'after'         => $after,
            'before'        => $before,
            'size'          => $size,
            'color'         => $color,
            'jml'           => $jml,
            'tgl_input'     => date('Y-m-d H:i:s'),
            );
        $this->db->insert('keranjang', $data);
    }

    function lacakPesananfix($inv){
        $this->db->select('*');
        $this->db->from('order_customer');
        $this->db->where('invoice', $inv);
        $r = $this->db->get();
        return $r->result();
    }

    function getPromo(){
        $this->db->select('*');
        $this->db->from('produk_group_name');
        $this->db->where('status','on');
        $this->db->where('berakhir >= NOW()');
        return $this->db->get();    
    }

    function cekslugpromo($slug){
        $this->db->select('*');
        $this->db->from('produk_group_name');
        $this->db->where('slug',$slug);
        //$this->db->where('berakhir >= NOW()');
        return $this->db->get();
    }

    function cekslugbrand($slugbrand){
        $this->db->select('*');
        $this->db->from('merk');
        $this->db->where('slug',$slugbrand);
        //$this->db->where('berakhir >= NOW()');
        return $this->db->get();
    }

    function get_setting_notifhomepage(){
        $this->db->select('*');
        $this->db->from('setting');
        $this->db->where('id',12);
        $f = $this->db->get();
        return $f->row_array();
    }

    function get_setting_freeongkirallcity(){
        $this->db->select('*');
        $this->db->from('setting');
        $this->db->where('id',13);
        $f = $this->db->get();
        return $f->row_array();
    }

    function list_city_freeongkir(){
        $this->db->select('count(*) as city');
        $this->db->from('kota_free_ongkir');
        $f = $this->db->get();
        return $f->row_array();   
    }

    function cek_status_sync_stok_produk(){
        $this->db->select('*');
        $this->db->from('setting');
        $this->db->where('id',14);
        $f = $this->db->get();
        return $f->row_array();   
    }

    function get_size_produk_detail($id){
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b','b.id_produk_optional=a.id_produk','left');
        $this->db->join('produk_opsional_size c','c.id_opsi_size=b.id_opsi_get_size','left');
        $this->db->join('size_chart d','d.eu=c.opsi_size','left');
        /*$this->db->where('a.status','on');*/
        $this->db->where('a.id_produk',$id);
        return $this->db->get();
    }

    function get_penjualan_hari_ini_by_market($market){
        $hari_besok = date('Y-m-d', strtotime('-1 day'));
        $this->db->select('COALESCE(SUM(order_product.qty),0) as jual_pasang, COALESCE(SUM(order_product.harga_fix),0) as turn_over');
        $this->db->from('order_customer'); 
        $this->db->join('order_product', 'order_product.no_order_pro=order_customer.no_order_cus','left');
        $this->db->where('order_customer.buy_in', $market);
        $this->db->where('order_customer.tanggal_order',$hari_besok);
        $this->db->where_not_in('order_customer.status',array('batal'));
        //$this->db->group_by('order_customer.buy_in');
        $x = $this->db->get();
        return $x->result();  
    }

    function penj_by_sosmed_dan_mp_all_price_calc_by_std($market){
        $tanggal_awal_bulan_ini = date('Y-m')."-01";
        $tanggal_kemarin_dari_bulan_ini = date('Y-m-d', strtotime('-2 days'));
        $this->db->select('COALESCE(SUM(b.qty),0) as jual_pasang_std, COALESCE(SUM(b.harga_fix),0) as turn_over_std');
        $this->db->from('order_customer a'); 
        $this->db->join('order_product b', 'a.no_order_cus=b.no_order_pro','left');
        $this->db->where('a.buy_in',$market);
        $this->db->where('a.tanggal_order >=',$tanggal_awal_bulan_ini);
        $this->db->where('a.tanggal_order <=',$tanggal_kemarin_dari_bulan_ini);
        $this->db->where_not_in('a.status',array('batal'));
        //$this->db->group_by('a.buy_in');
        $x = $this->db->get();
        return $x->row_array();       
    }

    function penj_by_sosmed_dan_mp_all_price_calc_by_sty($market){
        $bulan_awal_tahun_ini = date('Y')."-01-01";
        $bulan_kemarin_tahun_inix = date('Y-m-d', strtotime('-1 month'));//, strtotime('-1 month'));
        $bulan_kemarin_tahun_ini = date("Y-m-t", strtotime($bulan_kemarin_tahun_inix));
        $this->db->select('a.invoice, COALESCE(SUM(b.qty),0) as jual_pasang_sty, COALESCE(SUM(b.harga_fix),0) as turn_over_sty');
        $this->db->from('order_customer a'); 
        $this->db->join('order_product b', 'a.no_order_cus=b.no_order_pro','left');
        $this->db->where('a.buy_in',$market);
        $this->db->where('a.tanggal_order >=',$bulan_awal_tahun_ini);
        $this->db->where('a.tanggal_order <=',$bulan_kemarin_tahun_ini);
        $this->db->where_not_in('a.status',array('batal'));
        //$this->db->group_by('a.buy_in');
        $x = $this->db->get();
        return $x->row_array();       
    }

    function cek_sync_produk_status(){
        $this->db->select('id,aktif');
        $this->db->from('setting');
        $this->db->where('id',14);       
        $g = $this->db->get();    
        return $g->row_array();
    }

    function cekDataganda($idSales,$market){
        if($market == "E-commerce"){
            $dbecommerce = $this->load->database('ecommerce', TRUE);
            $dbecommerce->select('Sls_id');
            $dbecommerce->from('sls');
            $dbecommerce->where('Sls_id', $idSales);
            return $dbecommerce->get();
        }else if($market == "shopee"){
            $dbshopee = $this->load->database('shopee', TRUE);
            $dbshopee->select('Sls_id');
            $dbshopee->from('sls');
            $dbshopee->where('Sls_id', $idSales);
            return $dbshopee->get();
        }else if($market == "tokopedia"){
            $dbtokopedia = $this->load->database('tokopedia', TRUE);
            $dbtokopedia->select('Sls_id');
            $dbtokopedia->from('sls');
            $dbtokopedia->where('Sls_id', $idSales);
            return $dbtokopedia->get();
        }else if($market == "lazada"){
            $dblazada = $this->load->database('lazada', TRUE);
            $dblazada->select('Sls_id');
            $dblazada->from('sls');
            $dblazada->where('Sls_id', $idSales);
            return $dblazada->get();
        }else if($market == "blibli"){
            $dbblibli = $this->load->database('blibli', TRUE);
            $dbblibli->select('Sls_id');
            $dbblibli->from('sls');
            $dbblibli->where('Sls_id', $idSales);
            return $dbblibli->get();
        }else if($market == "bukalapak"){
            $dbbukalapak = $this->load->database('bukalapak', TRUE);
            $dbbukalapak->select('Sls_id');
            $dbbukalapak->from('sls');
            $dbbukalapak->where('Sls_id', $idSales);
            return $dbbukalapak->get();
        }
    }

    function getDataSales($market, $tgl1, $tgl2){
        $tgl1x = date("Y-m-d H:i:s", strtotime($tgl1));
        $tgl2x = date("Y-m-d H:i:s", strtotime($tgl2));
        if($market == "E-commerce"){
            $dbecommerce = $this->load->database('ecommerce', TRUE);
            $dbecommerce->select('*');
            $dbecommerce->from('sls');
            $dbecommerce->where('tgl >=', $tgl1x);
            $dbecommerce->where('tgl <=', $tgl2x);
            return $dbecommerce->get();
        }else if($market == "shopee"){
            $dbshopee = $this->load->database('shopee', TRUE);
            $dbshopee->select('*');
            $dbshopee->from('sls');
            $dbshopee->where('tgl >=', $tgl1x);
            $dbshopee->where('tgl <=', $tgl2x);
            return $dbshopee->get();
        }else if($market == "tokopedia"){
            $dbtokopedia = $this->load->database('tokopedia', TRUE);
            $dbtokopedia->select('*');
            $dbtokopedia->from('sls');
            $dbtokopedia->where('tgl >=', $tgl1x);
            $dbtokopedia->where('tgl <=', $tgl2x);
            return $dbtokopedia->get();
        }else if($market == "lazada"){
            $dblazada = $this->load->database('lazada', TRUE);
            $dblazada->select('*');
            $dblazada->from('sls');
            $dblazada->where('tgl >=', $tgl1x);
            $dblazada->where('tgl <=', $tgl2x);
            return $dblazada->get();
        }else if($market == "blibli"){
            $dbblibli = $this->load->database('blibli', TRUE);
            $dbblibli->select('*');
            $dbblibli->from('sls');
            $dbblibli->where('tgl >=', $tgl1x);
            $dbblibli->where('tgl <=', $tgl2x);
            return $dbblibli->get();
        }else if($market == "bukalapak"){
            $dbbukalapak = $this->load->database('bukalapak', TRUE);
            $dbbukalapak->select('*');
            $dbbukalapak->from('sls');
            $dbbukalapak->where('tgl >=', $tgl1x);
            $dbbukalapak->where('tgl <=', $tgl2x);
            return $dbbukalapak->get();
        }
    }

    function getDataProduk($market, $tgl1, $tgl2){
        $tgl1x = date("Y-m-d H:i:s", strtotime($tgl1));
        $tgl2x = date("Y-m-d H:i:s", strtotime($tgl2));

        //if($market == "E-commerce" || $market == "instagram"){
            $dbecommerce = $this->load->database('ecommerce', TRUE);
            $dbecommerce->select('*');
            $dbecommerce->from('slsdet a');
            $dbecommerce->join('sls b','b.Sls_id=a.Sls_id','left');
            //$dbecommerce->where('a.Sls_id', $idSales);
            $dbecommerce->where('b.tgl >=', $tgl1x);
            $dbecommerce->where('b.tgl <=', $tgl2x);
            return $dbecommerce->get();
        //}else if($market == "shopee"){
        //    $dbshopee = $this->load->database('shopee', TRUE);
        //    $dbshopee->select('*');
        //    $dbshopee->from('slsdet a');
        //    $dbshopee->join('sls b','b.Sls_id=a.Sls_id','left');
            //$dbshopee->where('a.Sls_id', $idSales);
        //    $dbshopee->where('b.tgl >=', $tgl1x);
        //    $dbshopee->where('b.tgl <=', $tgl2x);
        //    return $dbshopee->get();
        //}else if($market == "tokopedia"){
        //    $dbtokopedia = $this->load->database('tokopedia', TRUE);
        //    $dbtokopedia->select('*');
        //    $dbtokopedia->from('slsdet a');
        //    $dbtokopedia->join('sls b','b.Sls_id=a.Sls_id','left');
            //$dbtokopedia->where('a.Sls_id', $idSales);
        //    $dbtokopedia->where('b.tgl >=', $tgl1x);
        //    $dbtokopedia->where('b.tgl <=', $tgl2x);
        //    return $dbtokopedia->get();
        //}else if($market == "lazada"){
        //    $dblazada = $this->load->database('lazada', TRUE);
        //    $dblazada->select('*');
        //    $dblazada->from('slsdet a');
        //    $dblazada->join('sls b','b.Sls_id=a.Sls_id','left');
            //$dblazada->where('a.Sls_id', $idSales);
        //    $dblazada->where('b.tgl >=', $tgl1x);
        //    $dblazada->where('b.tgl <=', $tgl2x);
        //    return $dblazada->get();
        //}else if($market == "blibli"){
        //    $dbblibli = $this->load->database('blibli', TRUE);
        //    $dbblibli->select('*');
        //    $dbblibli->from('slsdet a');
        //    $dbblibli->join('sls b','b.Sls_id=a.Sls_id','left');
            //$dbblibli->where('a.Sls_id', $idSales);
        //    $dbblibli->where('b.tgl >=', $tgl1x);
        //    $dbblibli->where('b.tgl <=', $tgl2x);
        //    return $dbblibli->get();
        //}else if($market == "bukalapak"){
        //    $dbbukalapak = $this->load->database('bukalapak', TRUE);
        //    $dbbukalapak->select('*');
        //    $dbbukalapak->from('slsdet a');
        //    $dbbukalapak->join('sls b','b.Sls_id=a.Sls_id','left');
            //$dbbukalapak->where('a.Sls_id', $idSales);
        //    $dbbukalapak->where('b.tgl >=', $tgl1x);
        //    $dbbukalapak->where('b.tgl <=', $tgl2x);
        //    return $dbbukalapak->get();
        //}
    }

    function getDataProduk1($market, $idSales){
        if($market == "E-commerce"){
            $dbecommerce = $this->load->database('ecommerce', TRUE);
            $dbecommerce->select('a.*');
            $dbecommerce->from('slsdet a');
            $dbecommerce->join('sls b','b.Sls_id=a.Sls_id','left');
            $dbecommerce->where('a.Sls_id', $idSales);
            return $dbecommerce->get();
        }else if($market == "shopee"){
            $dbshopee = $this->load->database('shopee', TRUE);
            $dbshopee->select('a.*');
            $dbshopee->from('slsdet a');
            $dbshopee->join('sls b','b.Sls_id=a.Sls_id','left');
            $dbshopee->where('a.Sls_id', $idSales);
            return $dbshopee->get();
        }else if($market == "tokopedia"){
            $dbtokopedia = $this->load->database('tokopedia', TRUE);
            $dbtokopedia->select('a.*');
            $dbtokopedia->from('slsdet a');
            $dbtokopedia->join('sls b','b.Sls_id=a.Sls_id','left');
            $dbtokopedia->where('a.Sls_id', $idSales);
            return $dbtokopedia->get();
        }else if($market == "lazada"){
            $dblazada = $this->load->database('lazada', TRUE);
            $dblazada->select('a.*');
            $dblazada->from('slsdet a');
            $dblazada->join('sls b','b.Sls_id=a.Sls_id','left');
            $dblazada->where('a.Sls_id', $idSales);
            return $dblazada->get();
        }else if($market == "blibli"){
            $dbblibli = $this->load->database('blibli', TRUE);
            $dbblibli->select('a.*');
            $dbblibli->from('slsdet a');
            $dbblibli->join('sls b','b.Sls_id=a.Sls_id','left');
            $dbblibli->where('a.Sls_id', $idSales);
            return $dbblibli->get();
        }else if($market == "bukalapak"){
            $dbbukalapak = $this->load->database('bukalapak', TRUE);
            $dbbukalapak->select('a.*');
            $dbbukalapak->from('slsdet a');
            $dbbukalapak->join('sls b','b.Sls_id=a.Sls_id','left');
            $dbbukalapak->where('a.Sls_id', $idSales);
            return $dbbukalapak->get();
        }
    }

}              
 ?>