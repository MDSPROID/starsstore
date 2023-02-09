<link href="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.min.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/dropzone.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/basic.min.css');?>">
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/drupload_for_product.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/dUp/dropzone.min.js')?>"></script>
<script type="text/javascript">
$(function(){
  // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
  var baseURL = window.location.origin + '/';
  $('.seacrhart').autocomplete({
      serviceUrl: baseURL + 'trueaccon2194/produk/searchart',
      onSelect: function (res) {
          $('#artikel').val(''+res.artikel); // membuat id 'v_jurusan' untuk ditampilkan
      }
  }); 

  $(".duplicatevariant").click(function(){
    var stk = $("#stoking").val();
    var crt = $("#harga_coret").val();
    var fix = $("#harga_fix").val();

    $("#stoking1").val(stk);
    $("#harga_coret1").val(crt);
    $("#harga_fix1").val(fix);

    $("#stoking2").val(stk);
    $("#harga_coret2").val(crt);
    $("#harga_fix2").val(fix);

    $("#stoking3").val(stk);
    $("#harga_coret3").val(crt);
    $("#harga_fix3").val(fix);

    $("#stoking4").val(stk);
    $("#harga_coret4").val(crt);
    $("#harga_fix4").val(fix);

    $("#stoking5").val(stk);
    $("#harga_coret5").val(crt);
    $("#harga_fix5").val(fix);

    $("#stoking6").val(stk);
    $("#harga_coret6").val(crt);
    $("#harga_fix6").val(fix);
  });
});
</script> 
<style type="text/css">
  .dropzone{
    border:2px dashed #9e9e9e;
  }
  .dropzone .dz-preview .dz-error-message{
    color: white;
  }
</style>
<div class="page-title"> 
  <h3>Edit Produk
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
      <li class="active" href="#">Edit Produk</li>
    </ol>
  </div> 
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
      <?php 
        if(empty($get_data['sku_produk'])){
          // generate SKU Produk
          $length =10; 
          $sku= "";
          srand((double)microtime()*1000000);
          $data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
          $data .= "1234567890";
          for($i = 0; $i < $length; $i++){
            $sku .= substr($data, (rand()%(strlen($data))), 1);
            $skux = "SKU_".$sku;
          }

        }else{
          $skux = $get_data['sku_produk'];
        }
      ?>
      <?php echo form_open_multipart('trueaccon2194/produk/update_produk', array('id'=>'form_produk_add'));?>
      <input type="hidden" name="identity_produk" id="identity_produk" value="<?php echo $skux?>">
      <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#general">General</a></li>
          <li><a data-toggle="tab" href="#info">Info</a></li>
          <li><a data-toggle="tab" href="#ukuna">Stok</a></li>
          <li><a data-toggle="tab" href="#gambar1">Gambar</a></li>
      </ul>
    <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
    <div id="general" class="tab-pane fade in active">
    <?php echo br()?>
        <div class="row">
          <div class="col-md-6 input group">
            <label> Nama Produk : <i style="color:red;">*</i></label>
            <input type="text" name="nama" class="form-control cek_nama" id="nama" value="<?php echo $get_data['nama_produk']?>" placeholder="Nama produk">
            <input type="hidden" name="id_produk" value="<?php echo $get_data['id_produk']?>">
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Slug : </label> <i style="color:red;">*tanpa spasi dan tanpa huruf besar</i>
            <input type="text" name="slug" class="form-control cek_slug" value="<?php echo $get_data['slug']?>" id="slug" placeholder="URL produk" >
            <br>
          </div>
           <div class="col-md-6 input group">
            <label>Artikel : <i style="color:red;">*</i></label>
            <input type="text" name="artikel" class="seacrhart form-control cek_artikel calcArt" id="artikel" value="<?php echo $get_data['artikel']?>" id="artikel" placeholder="Kode Produk" >
            <br>
          </div>
          <div class="col-md-6">
            <label>Status :</label>
            <div class="ios-switch switch-lg">
                <input type="checkbox" name="status" class="js-switch pull-right fixed-header-check" <?php echo $status1;?>>
            </div>
            <br>
          </div>
          <div class="col-md-6"></div>
          <div style="margin-top:20px;" class="col-md-12 input group">
            <label>Deskripsi : <i style="color:red;">*</i></label>
            <textarea name="editor1" id="mytextarea" ><?php echo $get_data['keterangan']?></textarea>
          <?php echo br()?>
          </div>
        </div>
    </div>
    <div id="info" class="tab-pane fade">
    <?php echo br()?>
        <div class="row">
          <div class="col-md-6 col-xs-6 input group">
            <label>Kategori : <i style="color:red;">*</i></label>
            <select class="form-control" name="kategori" id="kategori">
              <option value="">--- Pilih ---</option>
              <?php foreach($get_kategorix as $data){ 
                  if($data->kat_id == $get_data['kategori']){?>
                <option value="<?php echo $data->kat_id;?>" SELECTED><?php echo $data->kategori;?></option>
              <?php }else{?>
                <option value="<?php echo $data->kat_id;?>"><?php echo $data->kategori;?></option>
              <?php }}?>
            </select>
            <br>
          </div>
          <div class="col-md-6 col-xs-6 input group">
            <label>Parent kategori : <i style="color:red;">*</i></label>
            <select class="form-control" name="parent" id="parent">
              <option value="">--- Pilih ---</option>
              <?php foreach($get_parent_kategorix as $data){ 
                  if($data->id_parent == $get_data['parent']){?>
                <option value="<?php echo $data->id_parent;?>" SELECTED><?php echo $data->parent_kategori;?></option>
              <?php }else{?>
                <option value="<?php echo $data->id_parent;?>"><?php echo $data->parent_kategori;?></option>
              <?php }}?>
            </select>
            <br>
          </div>
          <div class="col-md-6 col-xs-6 input group">
            <label>Merk : <i style="color:red;">*</i></label>
            <select class="form-control" name="merknya" id="merk">
              <?php foreach($get_merkx as $data){ 
                  if($data->merk_id == $get_data['merk']){?>
                <option value="<?php echo $data->merk_id;?>" SELECTED><?php echo $data->merk;?></option>
              <?php }else{?>
                <option value="<?php echo $data->merk_id;?>"><?php echo $data->merk;?></option>
              <?php }}?>
            </select>
            <br>
          </div>
          <div class="col-md-6 col-xs-6 input group">
            <label>ID Seller : </label>
            <select name="sellerID" class="form-control">
              <option value="">Pilih</option>
              <?php foreach($get_d_seller as $data){ 
                  if($data->id_seller == $get_data['idseller']){?>
                <option value="<?php echo $data->id_seller;?>" SELECTED><?php echo $data->id_seller;?></option>
              <?php }else{?>
                <option value="<?php echo $data->id_seller;?>"><?php echo $data->id_seller;?></option>
              <?php }}?>
            </select>
            <br>
          </div>
          <div class="col-md-6 col-xs-6 input group">
            <label>Berat (KG) : <i style="color:red;">*pakai titik (.)</i></label>
            <input type="text" name="berat" value="<?php echo $get_data['berat']?>" class="form-control cek_berat" id="berat" >
            <br>
          </div>
          <div class="col-md-6 col-xs-6 input group">
            <label>Point : <i style="color:red;">*</i></label>
            <input type="number" name="point" class="form-control cek_point" id="point" value="<?php echo $get_data['point']?>" >
            <br>
          </div>
          <div class="col-md-6 col-xs-12 input group">
            <label>Gambar : <i style="color:red;">*</i></label><i style="color:red;">*</i><br>
            <img src="<?php echo $get_data['gambar']?>" height="100">
            <div class="input-group">
            <input type="text" name="gambar" value="<?php echo $get_data['gambar']?>" class="form-control" id="carfID">
            <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
            </span>
            </div>
            <br>
          </div>
          <div class="col-md-6 col-xs-12 input group">
            <label>Tags :</label> <i style="color:red;">*pisahkan dengan koma</i>
            <input type="text" name="tags" value="<?php echo $get_data['tags']?>" data-role="tagsinput" class="form-control">
            <br>
          </div>
        </div>
    </div>
    <div id="ukuna" class="tab-pane fade">
      <?php echo br()?>
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="row">
<!-- Hasil dari database -->            
            <div class="col-md-12 col-xs-12" style="display:none;margin-bottom: 15px;"><a class="btn btn-block btn-primary duplicatevariant">Terapkan Stok & Harga</a></div>
            <div class="col-md-2 col-xs-2 padd0">
              <label>Warna : </label>
            </div>
            <div class="col-md-2 col-xs-2 padd0">
              <label>Size : </label>
            </div>
            <div class="col-md-2 col-xs-2 padd0">
              <label>Stok : </label>
            </div>
            <div class="col-md-2 col-xs-2 padd0">
              <label>Harga dicoret :</label>
            </div>
            <div class="col-md-2 col-xs-2 padd0">
              <label>Harga Fix :</label>
            </div>
            <div class="col-md-2 col-xs-2">
              <label>Lokasi Barang :</label>
            </div>
            <?php foreach($get_stok_color_size_pilihan as $data){?>
            <div id="get_option<?php echo $data['id'];?>">
              <div class="col-md-2 col-xs-2 padd0">
                <label onclick="remove_element_color_size_stok_url_upd(this)" data-id="<?php echo $data['id'];?>" class="label label-danger">X</label>
                <select class="form-control" name="color_update[]" id="coloring" style="margin-bottom:10px;">
                    <option value="">-- pilih --</option>
                <?php foreach($get_data_colorx_all as $datac){
                  if($datac['id_opsi_color'] == $data['id_opsi_get_color']){?>
                    <option value="<?php echo $datac['id_opsi_color']?>" SELECTED><?php echo $datac['opsi_color']?></option>
                    <?php }else{?>
                    <option value="<?php echo $datac['id_opsi_color']?>"><?php echo $datac['opsi_color']?></option>
                    <?php }}?>
                </select>
              </div>
              <div class="col-md-2 col-xs-2 padd0" id="get_sizex">
                <select class="form-control" name="size_update[]" id="sizing" style="margin-bottom:20px;margin-top:9px;">
                    <option value="">-- pilih --</option>
                <?php foreach($get_data_sizex_all as $datac){
                  if($datac['id_opsi_size'] == $data['id_opsi_get_size']){?>
                    <option value="<?php echo $datac['id_opsi_size']?>" SELECTED><?php echo $datac['opsi_size']?></option>
                    <?php }else{?>
                    <option value="<?php echo $datac['id_opsi_size']?>"><?php echo $datac['opsi_size']?></option>
                    <?php }}?>
                </select>
              </div>
              <div class="col-md-2 col-xs-2 padd0" id="get_stokx">
                <input type="number" name="stock_update[]" id="stoking" value="<?php echo $data['stok']?>" class="form-control" style="margin-bottom:20px;margin-top:9px;">
              </div>
              <div class="col-md-2 col-xs-2 padd0" id="hg_dicoretx">
                <input type="number" name="harga_dicoret[]" id="harga_coret1" value="<?php echo $data['harga_dicoret']?>" class="form-control" style="margin-bottom:20px;margin-top:9px;">
                <input type="hidden" name="befdiskon[]" value="<?php echo $data['harga_dicoret']?>">
              </div>
              <div class="col-md-2 col-xs-2 padd0" id="hg_fixx">
                <input type="number" name="harga_fix[]" id="harga_fix" value="<?php echo $data['harga_fix']?>" class="form-control" style="margin-bottom:20px;margin-top:9px;">
              </div>
              <div class="col-md-2 col-xs-2" id="get_lokasi_barangx">
                <select name="lokasi_barang_update[]" class="form-control" style="margin-bottom:20px;margin-top:9px;">
                  <?php if($data['lokasi_barang'] == "ecommerce"){?>
                    <option>- Pilih -</option>
                    <option value="ecommerce" SELECTED>Stok E-commerce</option>
                    <option value="store">Stok Toko</option>
                  <?php }else if($data['lokasi_barang'] == "store"){?>
                    <option>- Pilih -</option>
                    <option value="ecommerce">Stok E-commerce</option>
                    <option value="store" SELECTED>Stok Toko</option>
                  <?php }else{?>
                    <option>- Pilih -</option>
                    <option value="ecommerce">Stok E-commerce</option>
                    <option value="store">Stok Toko</option>
                  <?php }?>
                </select> 
              </div>
            </div>
            <?php }?>
          </div>
          <div id="simple-clone">
            <div class="toclone row">
                <a style="margin-left: 15px;" href="#" class="btn btn-success clone"><i class="glyphicon glyphicon-plus"></i></a>
                <a href="#" class="btn btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>
              <br>
              <div class="col-md-2 col-xs-2 padd0">
                <select class="form-control" name="color_update[]" id="coloring1" style="margin-top: 8px;margin-bottom:10px;">
                  <option value="">-- pilih --</option>
                  <?php foreach($get_data_colorx_all  as $data){ ?>
                    <option value="<?php echo $data['id_opsi_color'];?>"><?php echo $data['opsi_color'];?></option>
                  <?php }?>
                </select>
              </div>
              <div class="col-md-2 col-xs-2 padd0">
                <select class="form-control" name="size_update[]" id="sizing1" style="margin-bottom:20px;margin-top:8px;">
                  <option value="">-- pilih --</option>
                   <?php foreach($get_data_sizex_all as $data){ ?>
                      <option value="<?php echo $data['id_opsi_size'];?>"><?php echo $data['opsi_size'];?></option>
                   <?php }?>
                </select>
              </div>
              <div class="col-md-2 col-xs-2 padd0">
                <input type="number" name="stock_update[]" id="stoking1" placeholder="stok" class="form-control" style="margin-bottom:20px;margin-top:8px;">
              </div>
              <div class="col-md-2 col-xs-2 padd0">
                  <input type="number" name="harga_dicoret[]" id="harga_coret1" placeholder="dicoret" class="form-control" style="margin-bottom:20px;margin-top:9px;">
                  <input type="hidden" name="befdiskon[]">
              </div>
              <div class="col-md-2 col-xs-2 padd0">
                  <input type="number" name="harga_fix[]" id="harga_fix1" placeholder="fix" class="form-control" style="margin-bottom:20px;margin-top:9px;">
              </div>
              <div class="col-md-2 col-xs-2">
                <select name="lokasi_barang_update[]" id="get_lokasi_barang1" style="margin-bottom:20px;margin-top:8px;" class="form-control">
                  <option value="ecommerce">Stok E-commerce</option>
                  <option value="store">Stok Toko</option>
                </select> 
              </div>
            </div>
          </div>

        </div>
<!-- tambah option -->
      </div>
    </div>
    <div id="gambar1" class="tab-pane fade">
      <label><input type="radio" name="swt" class="form-control" onclick="swtdrop();" value="drop" checked> Drop Gambar</label>
      <label><input type="radio" name="swt" class="form-control" onclick="swturl();" value="url"> URL</label>
      <br>
      <br>
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <ul class="list-inline">
              <?php foreach($get_additional_image as $data){?>
              <li id="gb_id<?php echo $data['id_gambar']?>">
                <img class="img_hover" onclick="hapus_gambar_dipilih(this)" data-id="<?php echo $data['id_gambar']?>" data-src="<?php echo $data['gambar'];?>" style="margin-right:10px;" src="<?php echo $data['gambar']?>" height="50">
              </li>
              <?php }?>
          </ul>
        </div>
      </div>
      <div class="dropzone">
        <div class="dz-message">
          <h3 class="txtgb"> Klik atau Drop gambar disini<br>file maksimal 2 MB<br><span style="font-size: 12px;">file yang diijinkan : gif, jpg, png, jpeg</span></h3>
        </div>
      </div>
      <div id="gambar-clone" class="row hidden urlmode">
        <div class="toclone">
          <a href="#" style="margin-left: 15px;" class="btn btn-success clone"><i class="glyphicon glyphicon-plus"></i></a>
          <a href="#" class="btn btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>
          <div class="col-md-12 col-xs-12">
            <div class="input-group">
              <input type="text" name="gambar_tambah[]" class="form-control" id="carfID1" >
              <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif1"><i class="glyphicon glyphicon-search"></i></a></span>
            </div>
          </div>  
          <?php echo br(4)?>
        </div>
      </div>
      <?php echo br()?>
    </div>
    <i style="color:red;">- (*) wajib diisi</i><br>
    <i style="color:red;">- Gambar tidak diupload jika melebihi 2MB</i>
  </div>
</div>
<div class="col-md-3">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
        <h5>Diubah oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
        <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
        <h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
        <button type="submit" class="simpan_produk btn btn-success">Simpan Produk</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<div class="col-md-3">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Price Calculation</div>
      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
        <h5>Odv (RIMS)  <b style="margin-left: 35px;">:</b> <b class="odv_rims"></b></h5>
        <h5>Retail (RIMS)  <b style="margin-left: 25px;">:</b> <b class="retail_rims"></b></h5>
        <h5>Margin     <b style="margin-left: 60px;">:</b> <b class="margin"></b></h5>
        <h5>Odv (Bisnis)  <b style="margin-left: 30px;">:</b> <b class="odv_bisnis"></b></h5>
        <h5>Suggestion Retail    : <b class="sugges"></b></h5>
        <h5>Margin Bisnis  <b style="margin-left: 23px;">:</b> <b class="margin_bisnis"></b></h5>
    </div>
    </div>
</div>
<?php echo form_close();?>
</div>
</div>
<script src="<?php echo base_url('assets/manage/js/cloneya/jquery-cloneya.js');?>"></script>
<script>
  $('#simple-clone').cloneya();
  $('#gambar-clone').cloneya();
</script>