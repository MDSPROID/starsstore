<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd'
      });
  });
</script>
<div class="page-title">
  <h3>Produk Grouping
    <?php  
      if($this->session->flashdata('success')):?>
        <label style="font-size: 12px;position: absolute;margin-left: 10px;padding: 5px 5px;font-weight:500;" class="label label-success"><?php echo $this->session->flashdata('success')?></label>
      <?php endif?>
      <?php 
      if($this->session->flashdata('error')):?>
        <label style="font-size: 12px;position: absolute;margin-left: 10px;padding: 5px 5px;font-weight:500;" class="label label-danger"><?php echo $this->session->flashdata('error')?></label>
    <?php endif?>
  </h3>
  <div class="page-breadcrumb">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('trueaccon2194/info_type_user_log')?>">Home</a></li>
      <li><a href="<?php echo base_url('trueaccon2194/produk')?>">Produk</a></li>
      <li><a class="active" href="javascript:void(0);">Produk Grouping</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a class="btn btn-primary pull-left" href="javascript:history.go(-1)" style="margin-right:10px;margin-bottom:10px;"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a> 
  <a href="<?php echo base_url('trueaccon2194/produk/daftar_grup');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-book"></i> Daftar Grup</a>
  <?php echo form_open_multipart('trueaccon2194/produk/delete_select', array('class' => 'input-group'));?>
  <?php if(empty($tong)){?>
    <button disabled href="#" class="btn btn-danger" style="margin-right:10px;margin-bottom:10px;"><i class="glyphicon glyphicon-trash"></i> Tong Sampah</button>
  <?php }else{?>
    <a href="<?php echo base_url('trueaccon2194/produk/daftar_produk_dihapus/');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Tong Sampah</a>
  <?php }?>
</div>
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Project</th>
                    <th style="text-align:center;">Artikel</th>
                    <th style="text-align:center;">Harga</th>
                    <th style="text-align:center;">20</th>
                    <th style="text-align:center;">21</th>
                    <th style="text-align:center;">22</th>
                    <th style="text-align:center;">23</th>
                    <th style="text-align:center;">24</th>
                    <th style="text-align:center;">25</th>
                    <th style="text-align:center;">26</th>
                    <th style="text-align:center;">27</th>
                    <th style="text-align:center;">28</th>
                    <th style="text-align:center;">29</th>
                    <th style="text-align:center;">30</th>
                    <th style="text-align:center;">31</th>
                    <th style="text-align:center;">32</th>
                    <th style="text-align:center;">33</th>
                    <th style="text-align:center;">34</th>
                    <th style="text-align:center;">35</th>
                    <th style="text-align:center;">36</th>
                    <th style="text-align:center;">37</th>
                    <th style="text-align:center;">38</th>
                    <th style="text-align:center;">39</th>
                    <th style="text-align:center;">40</th>
                    <th style="text-align:center;">41</th>
                    <th style="text-align:center;">42</th>
                    <th style="text-align:center;">43</th>
                    <th style="text-align:center;">44</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($get_list) > 0){
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_produk;?>" /></td>
                  <td style="text-align:center;"><img src="
                  <?php 
                    if(empty($data->gambar)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->gambar;}?>" height="50"><br><?php 
                  if($data->status == "on"){
                      echo "<label style='top:7px;position:relative;' class='label label-success'>Aktif</label>";
                    }else{
                      echo "<label style='top:7px;position:relative;' class='label label-danger'>Tidak aktif</label>";
                      }?>
                  </td>
                  <td style="text-align:center;font-size: 12px;"><a href="<?php echo base_url()?>trueaccon2194/produk/edit_data/<?php $id = $this->encrypt->encode($data->id_produk); $idp = base64_encode($id); echo $idp ?>"><?php echo $data->nama_produk;?></a></td>
                  <td style="text-align:center;font-size: 12px;"><?php echo $data->artikel;?></td>
                  <td style="text-align:center;font-size: 12px;">
                  <?php
                  if($data->diskon == 0 || empty($data->diskon)){
                    echo "Rp. ".number_format($data->harga_net,0,".",".")."";
                  }else{
                     echo "Rp. <s>".number_format($data->harga_retail,0,".",".")."</s><br>Rp. ".number_format($data->harga_net,0,".",".")."<br><label style='top:7px;position:relative;' class='label label-danger'>$data->diskon%</label>";
                  }
                  ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "20"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "21"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "22"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "23"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "24"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "25"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "26"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "27"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "28"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "29"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "30"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "31"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "32"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "33"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "34"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "35"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "36"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "37"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "38"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "39"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "40"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "41"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "42"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "43"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                      $idp = $data->id_produk;
                      $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);          
                      foreach($cek_parent as $r){
                        if($r->opsi_size == "44"){
                          if($r->stok <= 5){
                            echo "<label class='btn btn-danger'>$r->stok</label>";
                          }else if($r->stok <= 10){
                            echo "<label class='btn btn-warning'>$r->stok</label>";
                          }else if($r->stok <= 30){
                            echo "<label class='btn btn-primary'>$r->stok</label>";
                          }else if($r->stok > 30){
                            echo "<label class='btn btn-success'>$r->stok</label>";
                          }
                        }
                      }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                    if($data->status == "on"){
                      echo "<a style='padding:3px 8px;' href='produk/off/$data->id_produk' class='btn btn-danger edit'>OFF</a>";
                    }else{
                      echo "<a style='padding:3px 8px;' href='produk/on/$data->id_produk' class='btn btn-success edit'>ON</a>";
                    }
                    ?>
                    <a href="<?php echo base_url()?>trueaccon2194/produk/edit_data/<?php $id = $this->encrypt->encode($data->id_produk); $idp = base64_encode($id); echo $idp ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger hapus" data-id="<?php $id = $this->encrypt->encode($data->id_produk); $idp = base64_encode($id); echo $idp ?>" data-name="<?php echo $data->nama_produk;?>" onclick="pindahkan_tong(this);"><i class="glyphicon glyphicon-remove"></i></a>
                    <a href="produk/duplikat_data/<?php $id = $this->encrypt->encode($data->id_produk); $idp = base64_encode($id); echo $idp ?>" class="btn btn-primary"><i class="glyphicon glyphicon-copy"></i></a>
                    <?php 
                      $f =$this->produk_adm->get_list_url_for_copy($idp);
                      foreach($f as $h){
                        $slugis = base_url('produk/'.$h->slug.'');
                      }
                    ?>
                    <a href="javascript:void(0);" id="copy-button" class="btn btn-success" data-clipboard-text="<?php echo $slugis?>"><i class="glyphicon glyphicon-link"></i></a>
                  </td>
              </tr>
             <?php 
            endforeach;}
            else{ echo "<tr><td colspan=13>DATA KOSONG!!</td></tr>";
              }?>
            </tbody>
  </table>
</div>
<?php echo form_close();?>
  </div>
</div>

<!-- Bootstrap modal edit-->
<div class="modal fade" id="modal_penurunan" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Book Form</h3>
      </div>
        <div class="modal-body form">
          <?php 
        echo form_open('trueaccon2194/produk/cek_perubahan_harga');
        ?>
          <div class="row">
            <div class="col-md-6 input group ">
            <label>Tanggal awal : <i style="color:red;">*</i></label>
            <div id="datetimepicker1" class="input-append">
                <input type="text" data-format="yyyy-MM-dd" value="<?php echo date('Y-m-d')?>" name="tgl1" class="form-control cek_tgl" placeholder="Tanggal awal" required>
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
            <div class="col-md-6 input group ">
            <label>Tanggal akhir : <i style="color:red;">*</i></label>
            <div id="datetimepicker2" class="input-append">
                <input type="text" data-format="yyyy-MM-dd" name="tgl2" value="<?php echo date('Y-m-d')?>" class="form-control cek_tgl" placeholder="Tanggal akhir" required>
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
            <div class="col-md-12">
              <div class="input-group">
                <button type="submit" name="laporan" value="" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Cek Produk Penurunan Harga</button> 
              </div>
            </div>
          </div>
        <?php echo form_close();?>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
  <!-- End Bootstrap modal -->
