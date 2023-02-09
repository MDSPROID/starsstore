<?php
class M_menu extends CI_Model
 {
     function __construct()
     {
         parent::__construct();
     }
     
     // membaut menu submenu dinamis
     function getMenu($parent,$hasil){
         $w = $this->db->query("SELECT * from kategori where parent_kategori='".$parent."'");
         foreach($w->result() as $h)
         {
                 $cek_parent=$this->db->query("SELECT * from kategori WHERE parent_kategori=".$h->kat_id."");
         if(($cek_parent->num_rows())>0){
                $hasil .= '<li class="dropdown"><a href="'.base_url().'blog/read/'.$h->slug.'" class="dropdown-toggle" data-toggle="dropdown">'.$h->kategori.' &nbsp;<b class="caret"></b></a> ';
                }
          else {
                        $hasil.='<li><a href="'.base_url().'blog/read/'.$h->slug.'">'.$h->kategori.'</a></li>';
                        }
                                $hasil .='<ul class="dropdown-menu">';
                                $hasil = $this->getMenu($h->kat_id,$hasil);
                                $hasil .='</ul>';              
                                $hasil .= "</li></li>";
         }
         return str_replace('<ul class="dropdown-menu"></ul>','',$hasil);
     }           
     
     // fungsi untuk menampilkan menu yang di klik
     public function read($id_menu){
                $this->db->where('kat_id',$id_menu);
                $sql_menu=$this->db->get('kategori');
                        if($sql_menu->num_rows()==1){
                                return $sql_menu->row_array();   
                        }        
                }
 
}              
 ?>