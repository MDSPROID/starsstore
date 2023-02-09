<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cataloguegaes extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model(array('catalok','home','users'));
		$this->perPage = 20;
        $get_data_set = toko_libur();
        if($get_data_set['aktif'] == "on"){
            redirect(base_url('toko-libur'));
        }
        // cek cookie - GET
        $cookie = get_cookie('Bismillahirrohmanirrohim');
        if($cookie != ""){
            if($this->session->userdata('log_access') == ""){ //jika session login tidak ada maka dibuatkan login otomatis
                // cek cookie jika ada cookies dibrowser maka buatkan session user otomatis
                $cek = $this->users->get_by_cookie($cookie);
                foreach($cek->result() as $data){
                    $email = $data->email;
                    $sess_user['id']                    = $data->id;
                    $sess_user['last_login']            = $data->last_login;
                    $sess_user['log_access']            = "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";
                    $this->session->set_userdata($sess_user);
                    $this->users->updateLastloginCustomer($data->id);
                    $this->users->saving_ipdevicebrowser($data->id, $email);
                }
            }
        }
	}  

    function cat_detail($read){


        if($this->uri->segment(1) == "kategori"){

            // analisis slug
            $get_id_by_encrypt = $this->catalok->get_id_from_kategori($read);
            if($get_id_by_encrypt->num_rows() == 0){
                $data['produk_lain'] = $this->home->get_produk_latest();
                $this->load->view('theme/v1/header');
                $this->load->view('theme/v1/404', $data);
                $this->load->view('theme/v1/footer');
            }else{

                $get_id_by_encrypt = $this->catalok->get_id_from_kategori($read);
                foreach($get_id_by_encrypt->result() as $get){
                    $get_id = $get->kat_id;
                    $get_name_kat = $get->kategori;
                    $get_bg_kat = $get->gambar;

                    $get_idg = $this->encrypt->encode($get->kat_id);
                    $id_kategori = base64_encode($get_idg); 

                }

                $data = array();
                //$conditions ="";
                
                //total rows count
                $totalRec = count($this->catalok->getRows(array('bds'=>'kategori'), $id_kategori));
                
                //pagination configuration
                $config['target']      = '#postList';
                $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData/';
                $config['total_rows']  = $totalRec;
                $config['per_page']    = $this->perPage;
                $config['link_func']   = 'searchFilter';
                $this->ajax_pagination->initialize($config);

                $data['brand'] = $this->catalok->get_brand();
                $data['ukuran'] = $this->catalok->get_ukuran();
                $data['warna'] = $this->catalok->get_warna();
                $data['kategori_ins'] = $get_id;
                $data['name_kat'] = $get_name_kat;
                $data['bg_kategori'] = $get_bg_kat;

                //get the posts data
                $data['posts'] = $this->catalok->getRows(array('limit'=>$this->perPage,'bds'=>'kategori'), $id_kategori);

                //$data['posts'] = $this->catalok->get_all_produk_with_kategori(array('limit'=>$this->perPage), $id_kategori);

                $data_header['title'] = "<title>".$get->kategori."</title>";
                $data_header['meta_desc'] = "<meta name='".$get->keterangan."' />";
                $data_header['meta_key'] = "<meta name='keywords' content='".$get->kata_kunci."'/>";

                $this->load->view('theme/v1/header', $data_header);
                $this->load->view('theme/v1/view_category',$data);
                $this->load->view('theme/v1/footer');
            }

        }else if($this->uri->segment(1) == "sub-kategori"){

            // analisis slug
            $get_id_by_encrypt = $this->catalok->get_id_parent_kategori($read);
            if($get_id_by_encrypt->num_rows() == 0){
                $data['produk_lain'] = $this->home->get_produk_latest();
                $this->load->view('theme/v1/header');
                $this->load->view('theme/v1/404', $data);
                $this->load->view('theme/v1/footer');
            }else{

                $get_id_by_encrypt = $this->catalok->get_id_parent_kategori($read);
                foreach($get_id_by_encrypt->result() as $get){
                    $get_id = $get->id_parent;
                    $get_name_kat = $get->parent_kategori;
                    $get_bg_kat = $get->gambar;

                    $get_idg = $this->encrypt->encode($get->id_parent);
                    $id_kategori = base64_encode($get_idg); 
                }                

                $data = array();
                //$conditions ="";
                
                //total rows count
                $totalRec = count($this->catalok->getRows(array('bds'=>'sub-kategori'), $id_kategori));
                
                //pagination configuration
                $config['target']      = '#postList';
                $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData/';
                $config['total_rows']  = $totalRec;
                $config['per_page']    = $this->perPage;
                $config['link_func']   = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                
                //get the posts data
                $data['brand'] = $this->catalok->get_brand();
                $data['ukuran'] = $this->catalok->get_ukuran();
                $data['warna'] = $this->catalok->get_warna();
                $data['kategori_ins'] = $get_id;
                $data['name_kat'] = $get_name_kat;
                $data['bg_kategori'] = $get_bg_kat;

                $data['posts'] = $this->catalok->getRows(array('limit'=>$this->perPage,'bds'=>'sub-kategori'), $id_kategori);
                //$data['get_price_tertinggi_untuk_filter'] = $this->catalok->get_price_tertinggi($id_parent_kategori);

                $data_header['title'] = "<title>".$get->parent_kategori."</title>";
                $data_header['meta_desc'] = "<meta name='".$get->keterangan."' />";
                $data_header['meta_key'] = "<meta name='keywords' content='".$get->kata_kunci."'/>";

                $this->load->view('theme/v1/header', $data_header);
                $this->load->view('theme/v1/view_category',$data);
                $this->load->view('theme/v1/footer');
            }

        }else if($this->uri->segment(1) == "merk"){

            // analisis slug
            $get_id_by_encrypt = $this->catalok->get_id_from_merk($read);
            if($get_id_by_encrypt->num_rows() == 0){
                $data['produk_lain'] = $this->home->get_produk_latest();
                $this->load->view('theme/v1/header');
                $this->load->view('theme/v1/404', $data);
                $this->load->view('theme/v1/footer');
            }else{

                $this->load->model('home');
                $get_id_by_encrypt = $this->catalok->get_id_from_merk($read);
                foreach($get_id_by_encrypt->result() as $get){
                    $get_id         = $get->merk_id;
                    $get_name_kat   = $get->merk;
                    $get_bg_kat     = $get->logo;
                    $slugBrand      = $get->slug;
                    $bannerbrand    = $get->banner;

                    $get_idg = $this->encrypt->encode($get->merk_id);
                    $id_kategori = base64_encode($get_idg); 
                }                

                $data = array();
                //$conditions =""; 
                
                //total rows count
                $totalRec = count($this->catalok->getRows(array('bds'=>'merk'), $id_kategori));
                
                //pagination configuration
                $config['target']      = '#postList';
                $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData/';
                $config['total_rows']  = $totalRec;
                $config['per_page']    = $this->perPage;
                $config['link_func']   = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                
                //get the posts data
                $data['brand'] = $this->catalok->get_brand();
                $data['ukuran'] = $this->catalok->get_ukuran();
                $data['warna'] = $this->catalok->get_warna();
                $data['kategori_ins'] = $get_id;
                $data['name_kat'] = $get_name_kat;

                $data['posts'] = $this->catalok->getRows(array('limit'=>$this->perPage,'bds'=>'merk'), $id_kategori);
                //$data['get_price_tertinggi_untuk_filter'] = $this->catalok->get_price_tertinggi($id_parent_kategori);

                $data_header['name_brand'] = $get_name_kat;
                $data_header['bg_kategori'] = $get_bg_kat;
                $data_header['title'] = "<title>".$get->merk."</title>";
                $data_header['meta_desc'] = "<meta name='".$get->deskripsi."' />";
                $data_header['meta_key'] = "<meta name='keywords' content='".$get->merk."'/>";
                $data_header['get_slider_utama'] = $this->home->get_data_slide_utama();
                $data_header['slug'] = $slugBrand;
                $data_header['banner'] = $bannerbrand;

                $this->load->view('theme/v1/header_brand', $data_header);
                $this->load->view('theme/v1/view_category',$data);
                $this->load->view('theme/v1/footer');
            }

        }else if($this->uri->segment(1) == "pencarian"){

            // kategori berdasarkan merk
            $keyword_filtering    = $this->security->xss_clean($this->input->get('keywords'));
            $keyword = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$keyword_filtering);

            // analisis slug
            $get_kat_gender = $keyword;
            $idg = $this->encrypt->encode($keyword);
            $idkategori_gender = base64_encode($idg);

            $data = array();
            //total rows count
            $totalRec = count($this->catalok->getRows(array('bds'=>'pencarian'), $idkategori_gender));
            
            //pagination configuration
            $config['target']      = '#postList';
            $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData/';
            $config['total_rows']  = $totalRec;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter';
            $this->ajax_pagination->initialize($config);

            $data['kategori'] = "";        
            $data['name_kat'] = $get_kat_gender;
            $data['brand'] = $this->catalok->get_brand();
            $data['ukuran'] = $this->catalok->get_ukuran();
            $data['warna'] = $this->catalok->get_warna();
            $data['kategori_ins'] = $get_kat_gender;

            $data['posts'] = $this->catalok->getRows(array('limit'=>$this->perPage,'bds'=>'pencarian'), $idkategori_gender);

            $data_header['title'] = "<title>".$get_kat_gender."</title>";
            $data_header['meta_desc'] = "<meta name='kategori ".$get_kat_gender."' />";
            $data_header['meta_key'] = "<meta name='keywords' content=' kategori ".$get_kat_gender."'/>";

            $this->load->view('theme/v1/header', $data_header);
            $this->load->view('theme/v1/view_category_pencarian',$data);
            $this->load->view('theme/v1/footer');

        }else if($this->uri->segment(1) == "promo-menarik"){

            // analisis slug
            $this->load->model('home');
            $get_id_by_encrypt = $this->home->cekslugpromo($read);
            if($get_id_by_encrypt->num_rows() == 0){
                $data['produk_lain'] = $this->home->get_produk_latest();
                $this->load->view('theme/v1/header');
                $this->load->view('theme/v1/404', $data);
                $this->load->view('theme/v1/footer');
            }else{ 

                $get_id_by_encrypt = $this->home->cekslugpromo($read);
                foreach($get_id_by_encrypt->result() as $get){
                    $get_id = $get->id;
                    $get_name_kat = $get->name_group;
                    $get_bg_kat = $get->gambar;

                    $get_idg = $this->encrypt->encode($get->id);
                    $id_kategori = base64_encode($get_idg); 
                }                

                $data = array();
                //$conditions ="";
                
                //total rows count
                $totalRec = count($this->catalok->getRows(array('bds'=>'promo-menarik'), $id_kategori));
                
                //pagination configuration
                $config['target']      = '#postList';
                $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData/';
                $config['total_rows']  = $totalRec;
                $config['per_page']    = $this->perPage;
                $config['link_func']   = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                
                //get the posts data
                $data['brand'] = $this->catalok->get_brand();
                $data['ukuran'] = $this->catalok->get_ukuran();
                $data['warna'] = $this->catalok->get_warna();
                $data['kategori_ins'] = $get_id;
                $data['name_kat'] = $get_name_kat;
                $data['bg_kategori'] = $get_bg_kat;

                $data['posts'] = $this->catalok->getRows(array('limit'=>$this->perPage,'bds'=>'promo-menarik'), $id_kategori);
                //$data['get_price_tertinggi_untuk_filter'] = $this->catalok->get_price_tertinggi($id_parent_kategori);

                $data_header['title'] = "<title>".$get->name_group."</title>";
                $data_header['meta_desc'] = "<meta name='".$get->keterangan."' />";
                $data_header['meta_key'] = "<meta name='keywords' content='".$get->keterangan."'/>";

                $this->load->view('theme/v1/header', $data_header);
                $this->load->view('theme/v1/view_category',$data);
                $this->load->view('theme/v1/footer');
            }

        }else if($this->uri->segment(1) == "terbaru"){

            if($this->uri->segment(2) == "highlight"){

                //tanpa analisis slug 
                $this->load->model('home');

                $get_id_by_encrypt = $this->home->cekslugpromo($read);
                foreach($get_id_by_encrypt->result() as $get){
                    $get_bg_kat = $get->gambar;

                    $get_idg = $this->encrypt->encode($get->id);
                    $id_kategori = base64_encode($get_idg); 
                }               
                $get_bg_kat  = "";
                $get_name_kat = "Terbaru";
                $get_id = "";
                $id_kategori = "";

                $data = array();
                //$conditions ="";
                
                //total rows count
                $totalRec = count($this->catalok->getRows(array('bds'=>'terbaru'), $id_kategori));
                
                //pagination configuration
                $config['target']      = '#postList';
                $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData/';
                $config['total_rows']  = $totalRec;
                $config['per_page']    = $this->perPage;
                $config['link_func']   = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                
                //get the posts data
                $data['brand'] = $this->catalok->get_brand();
                $data['ukuran'] = $this->catalok->get_ukuran(); 
                $data['warna'] = $this->catalok->get_warna();
                $data['kategori_ins'] = $get_id;
                $data['name_kat'] = $get_name_kat;
                $data['bg_kategori'] = $get_bg_kat;

                $data['posts'] = $this->catalok->getRows(array('limit'=>$this->perPage,'bds'=>'terbaru'), $id_kategori);
                //$data['get_price_tertinggi_untuk_filter'] = $this->catalok->get_price_tertinggi($id_parent_kategori);

                $data_header['title'] = "<title>Terbaru</title>";
                $data_header['meta_desc'] = "<meta name='Produk terbaru semua model' />";
                $data_header['meta_key'] = "<meta name='keywords' content='produk terbaru, semua model, pria, wanita, anak-anak, sepatu, sandal, stars, sepatu stars terbaru'/>";

                $this->load->view('theme/v1/header', $data_header);
                $this->load->view('theme/v1/view_category',$data);
                $this->load->view('theme/v1/footer');

            }else{
                
                //tanpa analisis slug 
                $this->load->model('home');

                // analisis slug brand
                $slugbrand = $this->uri->segment(2);
                $get_id_by_encrypt = $this->home->cekslugbrand($slugbrand);
                foreach($get_id_by_encrypt->result() as $get){
                    $get_bg_kat = $get->logo;
                    $get_idg = $this->encrypt->encode($get->merk_id);
                    $id_kategori = base64_encode($get_idg); 
                }               
                $get_bg_kat  = $get->logo;
                $get_name_kat = $get->merk;
                $get_id = $get->merk_id;
                //$id_kategori = $get->merk_id;
                $bannerbrand = $get->banner;
                $slugBrand = $get->slug;

                //echo $id_kategori;

                $data = array();
                //$conditions ="";
                
                //total rows count
                $totalRec = count($this->catalok->getRows(array('bds'=>'merk-terbaru'), $id_kategori));
                
                //pagination configuration
                $config['target']      = '#postList';
                $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData/';
                $config['total_rows']  = $totalRec;
                $config['per_page']    = $this->perPage;
                $config['link_func']   = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                
                //get the posts data
                $data['brand'] = $this->catalok->get_brand();
                $data['ukuran'] = $this->catalok->get_ukuran(); 
                $data['warna'] = $this->catalok->get_warna();
                $data['kategori_ins'] = $get_id;
                $data['name_kat'] = $get_name_kat;
                $data_header['bg_kategori'] = $get_bg_kat;
                $data_header['banner'] = $bannerbrand;
                $data_header['slug'] = $slugBrand;

                $data['posts'] = $this->catalok->getRows(array('limit'=>$this->perPage,'bds'=>'merk-terbaru'), $id_kategori);
                //$data['get_price_tertinggi_untuk_filter'] = $this->catalok->get_price_tertinggi($id_parent_kategori);

                $data_header['name_brand'] = $get_name_kat;
                $data_header['title'] = "<title>Terbaru</title>";
                $data_header['meta_desc'] = "<meta name='".$get_name_kat." - Terbaru' />";
                $data_header['meta_key'] = "<meta name='keywords' content='produk terbaru ".$get_name_kat."'/>";

                $this->load->view('theme/v1/header_brand', $data_header);
                $this->load->view('theme/v1/view_category',$data);
                $this->load->view('theme/v1/footer');


            }

        }

    }

    function ajaxPaginationData(){ 
        
        $conditions = array();

        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //calc offset number
        $g = $this->input->post('ftj');
        $get_iddx = $this->encrypt->encode($g);
        $idkategori_gender = base64_encode($get_iddx);
        
        //set conditions for search
        $bds_filtering     = $this->security->xss_clean($this->input->post('bds'));
        $berdasarkan = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$bds_filtering);

        $brand_filtering     = $this->security->xss_clean($this->input->post('brand'));
        $brand = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$brand_filtering);

        $minH_filtering     = $this->security->xss_clean($this->input->post('minH'));
        $minH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$minH_filtering);

        $maxH_filtering     = $this->security->xss_clean($this->input->post('maxH'));
        $maxH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$maxH_filtering);

        $sortBy_filtering   = $this->security->xss_clean($this->input->post('sortBy'));
        $sortBy = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$sortBy_filtering);

        $colour_filtering   = $this->security->xss_clean($this->input->post('colour'));
        $colourxx = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$colour_filtering);
        $colourx = base64_decode($colourxx);
        $colour = $this->encrypt->decode($colourx);

        $ukuran_filtering   = $this->security->xss_clean($this->input->post('size'));
        $ukuranxx = str_replace("/(<\/?)(p)([^>]*>)", "",$ukuran_filtering);
        $ukuranx = base64_decode($ukuranxx);
        $ukuran = $this->encrypt->decode($ukuranx);

        //$rating_filtering   = $this->security->xss_clean($this->input->post('rating'));
        //$rating = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php", "",$rating_filtering);

        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($minH)){
            $conditions['search']['minH'] = $minH;
        }
        if(!empty($maxH)){
            $conditions['search']['maxH'] = $maxH;
        }
        if(!empty($colour)){
            $conditions['search']['colour'] = $colour;
        }
        if(!empty($ukuran)){
            $conditions['search']['size'] = $ukuran;
        }
        if(!empty($brand)){
            $conditions['search']['brand'] = $brand;
        }
        //if(!empty($rating)){
        //    $conditions['search']['rating'] = $rating;
        //}

        // menentukan kuncian dari sebuah kondisi URL
        if(!empty($berdasarkan)){
            $conditions['bds'] = $berdasarkan;
        }


        //total rows count
        if($berdasarkan == "terbaru"){ // TIDAK PERLU IDKATEGORI_GENDER
            $totalRec = count($this->catalok->getRowsterbaru($conditions));
        }else{
            $totalRec = count($this->catalok->getRows($conditions, $idkategori_gender));
        }
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData/';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get the posts data
        if($berdasarkan == "terbaru"){ // TIDAK PERLU IDKATEGORI_GENDER
            $data['posts'] = $this->catalok->getRowsterbaru($conditions);
        }else{
            $data['posts'] = $this->catalok->getRows($conditions, $idkategori_gender);
        }

        //print_r($sortBy.'|'.$minH.'|'.$maxH.'|'.$colour.'|'.$ukuran.'|'.$brand);
        //print_r($posts);
        
        //load the view
        $this->load->view('theme/v1/view_filtering', $data);
    }

    
	function ajaxPaginationData_by_parent_kategori(){

        $conditions = array();
        
        //calc offset number
        $id_parent_kategori = $this->input->post('parent_kategori');

        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $brand_filtering 	= $this->security->xss_clean($this->input->post('brand'));
        $brand = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$brand_filtering);

        $minH_filtering 	= $this->security->xss_clean($this->input->post('minH'));
        $minH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$minH_filtering);

        $maxH_filtering     = $this->security->xss_clean($this->input->post('maxH'));
        $maxH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$maxH_filtering);

        $keywords_filtering = $this->security->xss_clean($this->input->post('keywords'));
        $keywords = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$keywords_filtering);

        $sortBy_filtering 	= $this->security->xss_clean($this->input->post('sortBy'));
        $sortBy = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$sortBy_filtering);

        $colour_filtering 	= $this->security->xss_clean($this->input->post('colour'));
        $colour = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$colour_filtering);

        $ukuran_filtering 	= $this->security->xss_clean($this->input->post('size'));
        $ukuran = str_replace("/(<\/?)(p)([^>]*>)", "",$ukuran_filtering);

        $rt_filtering 	= $this->security->xss_clean($this->input->post('rt'));
        $rt = str_replace("/(<\/?)(p)([^>]*>),", "",$rt_filtering);

        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($minH)){
            $conditions['search']['minH'] = $minH;
        }
        if(!empty($maxH)){
            $conditions['search']['maxH'] = $maxH;
        }
        if(!empty($brand)){
        	$conditions['search']['brand'] = $brand;
        }
        if(!empty($colour)){
        	$conditions['search']['colour'] = $colour;
        }
        if(!empty($ukuran)){
        	$conditions['search']['size'] = $ukuran;
        }
        if(!empty($rt)){
        	$conditions['search']['rt'] = $rt;
        }
        //total rows count
        $totalRec = count($this->catalok->get_all_produk_with_kategori($conditions, $id_parent_kategori));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData_by_kategori/'.$id_parent_kategori;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->catalok->get_all_produk_with_kategori($conditions, $id_parent_kategori);
        
        //load the view
		$this->load->view('theme/v1/view_filtering',$data);
    }

    function semua_kategori(){
        $data['get_kat'] = $this->catalok->get_kat();

        $data_header['title'] = "<title>Semua Kategori</title>";
        $data_header['meta_desc'] = "<meta name='semua kategori' />";
        $data_header['meta_key'] = "<meta name='keywords' content='kategori produk, pria, wanita, anak-anak, banyak pilihan, banyak promo, selalu ada diskon'/>";
        $this->load->view('theme/v1/header', $data_header);
        $this->load->view('theme/v1/semua_kategori',$data);
        $this->load->view('theme/v1/footer');
    }

    function brand_promote(){
        // get brand 
        $data['get_brand'] = $this->catalok->get_brand_endorse();

        $data_header['title'] = "<title>Brand</title>";
        $data_header['meta_desc'] = "<meta name='brand promo' />";
        $data_header['meta_key'] = "<meta name='keywords' content='brand promo, brand favorite, brand produk'/>";
        $this->load->view('theme/v1/header', $data_header);
        $this->load->view('theme/v1/brand_detail',$data);
        $this->load->view('theme/v1/footer');
    }

    function brand($read){
        $get_id_by_encrypt = $this->catalok->get_id_brand($read);

        foreach($get_id_by_encrypt as $get){
            $get_merk = $get->merk;
            $get_slug_merk = $get->slug;
            $get_id = $this->encrypt->encode($get->merk_id);
            $id_brand = base64_encode($get_id);
        }

        $data = array();
        $conditions =array();
        
        //total rows count
        $totalrecord = count($this->catalok->get_all_produk_with_brand($conditions,$id_brand));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData_by_brand/'.$id_brand;
        $config['total_rows']  = $totalrecord;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['posts'] = $this->catalok->get_all_produk_with_brand(array('limit'=>$this->perPage), $id_brand);
        $data['parent_kategori'] = $this->catalok->get_parent_kategori();
        $data['ukuran'] = $this->catalok->get_ukuran();
        $data['warna'] = $this->catalok->get_warna();
        $data['brand_ins'] = $id_brand;
        $data['nama_brand'] = $get_merk;
        $data['slug_merk'] = $get_slug_merk;
        $data['get_price_tertinggi_untuk_brand'] = $this->catalok->get_price_tertinggi_for_brand($id_brand);

        $data_header['title'] = "<title>".$get->merk."</title>";
        $data_header['meta_desc'] = "<meta name='".$get->deskripsi."' />";
        $data_header['meta_key'] = "<meta name='keywords' content='".$get->slug."'/>";

        $this->load->view('theme/v1/header', $data_header);
        $this->load->view('theme/v1/view_catalok_brand',$data);
        $this->load->view('theme/v1/footer');
    }

     function ajaxPaginationData_by_brand(){

        $conditions = array();
        
        //calc offset number
        $id_brand = $this->input->post('merk_id');

        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $parent_kategori_filtering    = $this->security->xss_clean($this->input->post('parent_kategori'));
        $parent_kategori = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$parent_kategori_filtering);

        $minH_filtering    = $this->security->xss_clean($this->input->post('minH'));
        $minH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$minH_filtering);

        $maxH_filtering     = $this->security->xss_clean($this->input->post('maxH'));
        $maxH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$maxH_filtering);

        $keywords_filtering = $this->security->xss_clean($this->input->post('keywords'));
        $keywords = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$keywords_filtering);

        $sortBy_filtering   = $this->security->xss_clean($this->input->post('sortBy'));
        $sortBy = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$sortBy_filtering);

        $colour_filtering   = $this->security->xss_clean($this->input->post('colour'));
        $colour = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$colour_filtering);

        $ukuran_filtering   = $this->security->xss_clean($this->input->post('size'));
        $ukuran = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$ukuran_filtering);

        $rt_filtering   = $this->security->xss_clean($this->input->post('rt'));
        $rt = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$rt_filtering);

        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($minH)){
            $conditions['search']['minH'] = $minH;
        }
        if(!empty($maxH)){
            $conditions['search']['maxH'] = $maxH;
        }
        if(!empty($parent_kategori)){
            $conditions['search']['parent_kategori'] = $parent_kategori;
        }
        if(!empty($colour)){
            $conditions['search']['colour'] = $colour;
        }
        if(!empty($ukuran)){
            $conditions['search']['size'] = $ukuran;
        }
        if(!empty($rt)){
            $conditions['search']['rt'] = $rt;
        }
        //total rows count
        $totalRec = count($this->catalok->get_all_produk_with_brand($conditions, $id_brand));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData_by_brand/'.$id_brand;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->catalok->get_all_produk_with_brand($conditions, $id_brand);
        
        //load the view
        $this->load->view('theme/v1/view_filtering',$data);
    }

// promo side utama

	function promo_aksi($read){
        $get_id_by_encrypt = $this->catalok->get_id_promo($read);

        foreach($get_id_by_encrypt as $get){
            $get_judul_promo        = $get->judul;
            $get_slug_promo         = $get->slug;
            $get_inialisasi_promo   = $get->jenis_promo;
            $get_value1             = $get->value1;
            $get_value2             = $get->value2;
            $expdate                = $get->tgl_akhir;
            $status                 = $get->status;
            $get_id_parent_kategori = $this->encrypt->encode($get->parent_kategori);
            $category               = base64_encode($get_id_parent_kategori);
        }

        $now = date('Y-m-d H:i:s');
        if($expdate < $now){
            $data_header['title'] = "<title>Promo Berakhir</title>";
            $data_header['meta_desc'] = "<meta name='Promo Berakhir' />";
            $data_header['meta_key'] = "<meta name='keywords' content='Promo Berakhir'/>";

            $this->load->view('theme/v1/header', $data_header);
            $this->load->view('theme/v1/end-promo');
            $this->load->view('theme/v1/footer');
        }else if($status == "expired"){
            $data_header['title'] = "<title>Promo Berakhir</title>";
            $data_header['meta_desc'] = "<meta name='Promo Berakhir' />";
            $data_header['meta_key'] = "<meta name='keywords' content='Promo Berakhir'/>";
            $this->load->view('theme/v1/header', $data_header);
            $this->load->view('theme/v1/end-promo');
            $this->load->view('theme/v1/footer');

        }else if($status == ""){
            $data_header['title'] = "<title>Promo Berakhir</title>";
            $data_header['meta_desc'] = "<meta name='Promo Berakhir' />";
            $data_header['meta_key'] = "<meta name='keywords' content='Promo Berakhir'/>";

            $this->load->view('theme/v1/header', $data_header);
            $this->load->view('theme/v1/end-promo');
            $this->load->view('theme/v1/footer');
        }else if($get_inialisasi_promo == "catalok1diskon"){
            $data = array();
            $conditions =array();
            
            //total rows count
            $totalrecord = count($this->catalok->get_all_produk_with_1diskon($conditions,$category,$get_value1));
            
            //pagination configuration
            $config['target']      = '#postList';
            $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData_by_promo1diskon/'.$category;
            $config['total_rows']  = $totalrecord;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter';
            $this->ajax_pagination->initialize($config);
            
            //get the posts data
            $data['posts'] = $this->catalok->get_all_produk_with_1diskon(array('limit'=>$this->perPage), $category,$get_value1);
            $data['parent_kategori'] = $this->catalok->get_parent_kategori();
            $data['brand'] = $this->catalok->get_brand();
            $data['ukuran'] = $this->catalok->get_ukuran();
            $data['warna'] = $this->catalok->get_warna();
            $data['kategori_promo'] = $category;
            $data['nama_promo'] = $get_judul_promo;
            $data['slug_merk'] = $get_slug_promo;
            $data['promo_target'] = $get_value1;
            //$data['get_price_tertinggi_untuk_promo'] = $this->catalok->get_price_tertinggi_for_promo($id_promo);

            $data_header['title'] = "<title>".$get_judul_promo."</title>";
            $data_header['meta_desc'] = "<meta name='".$get_judul_promo."' />";
            $data_header['meta_key'] = "<meta name='keywords' content='".$get_slug_promo."'/>";

            $this->load->view('theme/v1/header', $data_header);
            $this->load->view('theme/v1/view_catalok_promo1diskon',$data);
            $this->load->view('theme/v1/footer');

        }else if($get_inialisasi_promo == "catalok2diskon"){

            $data = array();
            $conditions =array();
            
            //total rows count
            $totalrecord = count($this->catalok->get_all_produk_with_2diskon($conditions,$category, $get_value1, $get_value2));
            
            //pagination configuration
            $config['target']      = '#postList';
            $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData_by_promo2diskon/'.$category;
            $config['total_rows']  = $totalrecord;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter';
            $this->ajax_pagination->initialize($config);
            
            //get the posts data
            $data['posts'] = $this->catalok->get_all_produk_with_2diskon(array('limit'=>$this->perPage), $category,$get_value1, $get_value2);
            $data['parent_kategori'] = $this->catalok->get_parent_kategori();
            $data['brand'] = $this->catalok->get_brand();
            $data['ukuran'] = $this->catalok->get_ukuran();
            $data['warna'] = $this->catalok->get_warna();
            $data['kategori_promo'] = $category;
            $data['nama_promo'] = $get_judul_promo;
            $data['slug_merk'] = $get_slug_promo;
            $data['promo_target1'] = $get_value1;
            $data['promo_target2'] = $get_value2;
            //$data['get_price_tertinggi_untuk_promo'] = $this->catalok->get_price_tertinggi_for_promo($id_promo);

            $data_header['title'] = "<title>".$get_judul_promo."</title>";
            $data_header['meta_desc'] = "<meta name='".$get_judul_promo."' />";
            $data_header['meta_key'] = "<meta name='keywords' content='".$get_slug_promo."'/>";

            $this->load->view('theme/v1/header', $data_header);
            $this->load->view('theme/v1/view_catalok_promo2diskon',$data);
            $this->load->view('theme/v1/footer');

        }else if($get_inialisasi_promo == "catalok2harga"){

            $data = array();
            $conditions =array();
            
            //total rows count
            $totalrecord = count($this->catalok->get_all_produk_with_2harga($conditions,$category, $get_value1, $get_value2));
            
            //pagination configuration
            $config['target']      = '#postList';
            $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData_by_promo2diskon/'.$category;
            $config['total_rows']  = $totalrecord;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter';
            $this->ajax_pagination->initialize($config);
            
            //get the posts data
            $data['posts'] = $this->catalok->get_all_produk_with_2harga(array('limit'=>$this->perPage), $category,$get_value1, $get_value2);
            $data['parent_kategori'] = $this->catalok->get_parent_kategori();
            $data['brand'] = $this->catalok->get_brand();
            $data['ukuran'] = $this->catalok->get_ukuran();
            $data['warna'] = $this->catalok->get_warna();
            $data['kategori_promo'] = $category;
            $data['nama_promo'] = $get_judul_promo;
            $data['slug_merk'] = $get_slug_promo;
            $data['promo_target1'] = $get_value1;
            $data['promo_target2'] = $get_value2;
            //$data['get_price_tertinggi_untuk_promo'] = $this->catalok->get_price_tertinggi_for_promo($id_promo);

            $data_header['title'] = "<title>".$get_judul_promo."</title>";
            $data_header['meta_desc'] = "<meta name='".$get_judul_promo."' />";
            $data_header['meta_key'] = "<meta name='keywords' content='".$get_slug_promo."'/>";

            $this->load->view('theme/v1/header', $data_header);
            $this->load->view('theme/v1/view_catalok_promo2harga',$data);
            $this->load->view('theme/v1/footer');

        }
    }

    function ajaxPaginationData_by_promo1diskon(){

        $conditions = array();
        
        //calc offset number
        $category = $this->input->post('promo');

        $a = base64_decode($this->input->post('target'));
        $get_value1 = $this->encrypt->decode($a);

        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $parent_kategori_filtering    = $this->security->xss_clean($this->input->post('parent_kategori'));
        $parent_kategori = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$parent_kategori_filtering);

        $minH_filtering    = $this->security->xss_clean($this->input->post('minH'));
        $minH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$minH_filtering);

        $maxH_filtering     = $this->security->xss_clean($this->input->post('maxH'));
        $maxH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$maxH_filtering);

        $keywords_filtering = $this->security->xss_clean($this->input->post('keywords'));
        $keywords = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$keywords_filtering);

        $sortBy_filtering   = $this->security->xss_clean($this->input->post('sortBy'));
        $sortBy = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$sortBy_filtering);

        $brand_filtering   = $this->security->xss_clean($this->input->post('brand'));
        $brand = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$brand_filtering);

        $colour_filtering   = $this->security->xss_clean($this->input->post('colour'));
        $colour = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$colour_filtering);

        $ukuran_filtering   = $this->security->xss_clean($this->input->post('size'));
        $ukuran = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$ukuran_filtering);

        $rt_filtering   = $this->security->xss_clean($this->input->post('rt'));
        $rt = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$rt_filtering);

        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($minH)){
            $conditions['search']['minH'] = $minH;
        }
        if(!empty($maxH)){
            $conditions['search']['maxH'] = $maxH;
        }
        if(!empty($brand)){
            $conditions['search']['brand'] = $brand;
        }
        if(!empty($parent_kategori)){
            $conditions['search']['parent_kategori'] = $parent_kategori;
        }
        if(!empty($colour)){
            $conditions['search']['colour'] = $colour;
        }
        if(!empty($ukuran)){
            $conditions['search']['size'] = $ukuran;
        }
        if(!empty($rt)){
            $conditions['search']['rt'] = $rt;
        }
        //total rows count
        $totalRec = count($this->catalok->get_all_produk_with_1diskon($conditions, $category, $get_value1));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData_by_promo1diskon/'.$category;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->catalok->get_all_produk_with_1diskon($conditions, $category, $get_value1);
        
        //load the view
        $this->load->view('theme/v1/view_filtering',$data);
    }

    function ajaxPaginationData_by_promo2diskon(){

        $conditions = array();
        
        //calc offset number
        $category = $this->input->post('promo');

        $a = base64_decode($this->input->post('target1'));
        $get_value1 = $this->encrypt->decode($a);

        $a = base64_decode($this->input->post('target2'));
        $get_value2 = $this->encrypt->decode($a);

        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $parent_kategori_filtering    = $this->security->xss_clean($this->input->post('parent_kategori'));
        $parent_kategori = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$parent_kategori_filtering);

        $minH_filtering    = $this->security->xss_clean($this->input->post('minH'));
        $minH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$minH_filtering);

        $maxH_filtering     = $this->security->xss_clean($this->input->post('maxH'));
        $maxH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$maxH_filtering);

        $keywords_filtering = $this->security->xss_clean($this->input->post('keywords'));
        $keywords = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$keywords_filtering);

        $sortBy_filtering   = $this->security->xss_clean($this->input->post('sortBy'));
        $sortBy = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$sortBy_filtering);

        $brand_filtering   = $this->security->xss_clean($this->input->post('brand'));
        $brand = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$brand_filtering);

        $colour_filtering   = $this->security->xss_clean($this->input->post('colour'));
        $colour = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$colour_filtering);

        $ukuran_filtering   = $this->security->xss_clean($this->input->post('size'));
        $ukuran = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$ukuran_filtering);

        $rt_filtering   = $this->security->xss_clean($this->input->post('rt'));
        $rt = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$rt_filtering);

        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($minH)){
            $conditions['search']['minH'] = $minH;
        }
        if(!empty($maxH)){
            $conditions['search']['maxH'] = $maxH;
        }
        if(!empty($brand)){
            $conditions['search']['brand'] = $brand;
        }
        if(!empty($parent_kategori)){
            $conditions['search']['parent_kategori'] = $parent_kategori;
        }
        if(!empty($colour)){
            $conditions['search']['colour'] = $colour;
        }
        if(!empty($ukuran)){
            $conditions['search']['size'] = $ukuran;
        }
        if(!empty($rt)){
            $conditions['search']['rt'] = $rt;
        }
        
        //total rows count
        $totalRec = count($this->catalok->get_all_produk_with_2diskon($conditions, $category, $get_value1, $get_value2));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData_by_promo2diskon/'.$category;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->catalok->get_all_produk_with_2diskon($conditions, $category, $get_value1, $get_value2);
        
        //load the view
        $this->load->view('theme/v1/view_filtering',$data);
    }

    function ajaxPaginationData_by_promo2harga(){

        $conditions = array();
        
        //calc offset number
        $category = $this->input->post('promo');

        $a = base64_decode($this->input->post('target1'));
        $get_value1 = $this->encrypt->decode($a);

        $a = base64_decode($this->input->post('target2'));
        $get_value2 = $this->encrypt->decode($a);

        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $parent_kategori_filtering    = $this->security->xss_clean($this->input->post('parent_kategori'));
        $parent_kategori = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$parent_kategori_filtering);

        $minH_filtering    = $this->security->xss_clean($this->input->post('minH'));
        $minH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$minH_filtering);

        $maxH_filtering     = $this->security->xss_clean($this->input->post('maxH'));
        $maxH = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$maxH_filtering);

        $keywords_filtering = $this->security->xss_clean($this->input->post('keywords'));
        $keywords = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$keywords_filtering);

        $sortBy_filtering   = $this->security->xss_clean($this->input->post('sortBy'));
        $sortBy = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$sortBy_filtering);

        $brand_filtering   = $this->security->xss_clean($this->input->post('brand'));
        $brand = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$brand_filtering);

        $colour_filtering   = $this->security->xss_clean($this->input->post('colour'));
        $colour = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$colour_filtering);

        $ukuran_filtering   = $this->security->xss_clean($this->input->post('size'));
        $ukuran = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$ukuran_filtering);

        $rt_filtering   = $this->security->xss_clean($this->input->post('rt'));
        $rt = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$rt_filtering);

        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($minH)){
            $conditions['search']['minH'] = $minH;
        }
        if(!empty($maxH)){
            $conditions['search']['maxH'] = $maxH;
        }
        if(!empty($parent_kategori)){
            $conditions['search']['parent_kategori'] = $parent_kategori;
        }
        if(!empty($brand)){
            $conditions['search']['brand'] = $brand;
        }
        if(!empty($colour)){
            $conditions['search']['colour'] = $colour;
        }
        if(!empty($ukuran)){
            $conditions['search']['size'] = $ukuran;
        }
        if(!empty($rt)){
            $conditions['search']['rt'] = $rt;
        }
        //total rows count
        $totalRec = count($this->catalok->get_all_produk_with_2harga($conditions, $category, $get_value1, $get_value2));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'Cataloguegaes/ajaxPaginationData_by_promo2harga/'.$category;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->catalok->get_all_produk_with_2harga($conditions, $category, $get_value1, $get_value2);
        
        //load the view
        $this->load->view('theme/v1/view_filtering',$data);
    }

}