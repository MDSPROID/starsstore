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
  <h3>Tambah Produk
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
      <li class="active">Tambah Produk</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/produk/proses_tambah_produk', array('id'=>'form_produk_add'));?>
      <input type="hidden" name="identity_produk" id="identity_produk" value="<?php echo $identity_product?>">
      <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#general">General</a></li>
          <li><a data-toggle="tab" href="#info">Info</a></li>
          <li><a data-toggle="tab" href="#ukuna">Stok</a></li>
          <li><a data-toggle="tab" href="#gambar1">Gambar</a></li>
      </ul>
    <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
  	<div id="general" class="tab-pane fade in active">
    <h4><span style="font-weight: 100;">Preview URL:</span> <i id="cp"><?php echo base_url('/produk/')?><span class="prevURL"></span></i></h4>
    <label class="label label-default" onclick="copv();"><i class="glyphicon glyphicon-copy"></i> Copy URL</label> <i class="ntcpv" style="color: green;"></i>
    <?php echo br(2)?>
        <div class="row">
          <div class="col-md-6 input group">
            <label>Nama Produk : <i style="color:red;">*</i></label>
            <input type="text" name="nama" class="form-control cek_nama" id="nama" placeholder="Nama produk" >
            <br> 
          </div>
          <div class="col-md-6 input group">
            <label>Slug : </label> <i style="color:red;">*tanpa spasi dan tanpa huruf besar</i>
            <input type="text" name="slug" class="form-control cek_slug" oninput="prv(this);" id="slug" placeholder="URL produk" >
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Artikel : <i style="color:red;">*</i></label>
            <input type="text" name="artikel" class="seacrhart form-control cek_artikel calcArt" id="artikel" placeholder="Kode Produk" >
            <br>
          </div>
          <div class="col-md-6">
            <label>Status :</label>
            <div class="ios-switch switch-lg">
                <input type="checkbox" name="status" class="js-switch pull-right fixed-header-check" checked>
            </div>
            <br>
          </div>
          <div class="col-md-12"></div>
          <div style="margin-top:20px;" class="col-md-12 input group">
            <label>Deskripsi : <i style="color:red;">*</i></label>
            <textarea name="editor1" id="mytextarea" ></textarea>
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
              <?php foreach($get_kategories as $data){ ?>
                  <option value="<?php echo $data->kat_id;?>"><?php echo $data->kategori;?></option>
              <?php }?>
            </select>
            <br>
          </div>
          <div class="col-md-6 col-xs-6 input group">
            <label>Parent kategori : <i style="color:red;">*</i></label>
            <select class="form-control" name="parent" id="parent">
                <option value="">--- Pilih ---</option>
              <?php foreach($get_parent_kategori as $data){ ?>
                <option value="<?php echo $data->id_parent;?>"><?php echo $data->parent_kategori;?></option>
              <?php }?>
            </select>
            <br>
          </div>
          <div class="col-md-6 col-xs-6 input group">
            <label>Merk : <i style="color:red;">*</i></label>
            <select class="form-control" name="merknya" id="merk">
            <?php foreach( $get_merkx as $data){?>
                <option value="<?php echo $data->merk_id?>"><?php echo $data->merk?></option>  
            <?php }?>
            </select>
            <br>
          </div>
          <div class="col-md-6 col-xs-6 input group">
            <label>ID Seller : </label>
            <select name="sellerID" class="form-control">
              <option value="">Pilih</option>
              <?php foreach($list_seller as $l){?>
                <option value="<?php echo $l->id_seller?>"><?php echo $l->id_seller?> (<?php echo $l->nama_seller?>)</option>
              <?php }?>
            </select>
            <br>
          </div>
          <div class="col-md-6 col-xs-6 input group">
            <label>Berat (KG) : <i style="color:red;">*pakai titik (.)</i></label>
            <input type="text" name="berat" class="form-control cek_berat" id="berat" value="0.5">
            <br>
          </div>
          <div class="col-md-6 col-xs-6 input group">
            <label>Point : <i style="color:red;">*</i></label>
            <input type="number" name="point" class="form-control cek_point" id="point" value="0" >
            <br>
          </div>
          <div class="col-md-6  col-xs-12 input group">
            <label>Gambar : <i style="color:red;">*</i></label><i style="color:red;"></i>
            <div class="input-group">
            <input type="text" name="gambar" class="form-control" id="carfID">
            <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
            </span>
            </div>
            <br>
          </div>
          <div class="col-md-6  col-xs-12 input group">
            <label>Tags :</label> <i style="color:red;">*pisahkan dengan koma</i>
            <input type="text" name="tags" data-role="tagsinput" class="form-control">
            <br>
          </div>
        </div>
    </div>
    <div id="ukuna" class="tab-pane fade">
      <div class="row">
        <div class="col-md-12 col-xs-12 input group">
          <?php echo br()?>
          <div class="row">
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
              <label>Harga dicoret</label>
            </div>
            <div class="col-md-2 col-xs-2 padd0">
              <label>Harga Fix</label>
            </div>
            <div class="col-md-2 col-xs-2">
              <label>Lokasi Barang : </label>
            </div>
          </div>
          <div id="simple-clone" class="row">
            <div class="toclone">
                <a style="margin-left: 15px;" href="#" class="btn btn-success clone"><i class="glyphicon glyphicon-plus"></i></a>
                <a href="#" class="btn btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>
                <br>
              <div class="col-md-2 col-xs-2 padd0">
                <select  name="color[]" class="form-control">
                  <?php foreach($get_colorx as $data){ ?>
                    <option value="<?php echo $data->id_opsi_color;?>"><?php echo $data->opsi_color;?></option>
                  <?php }?>
                </select>
              </div>
              <div class="col-md-2 col-xs-2 padd0">
                <select name="size[]" id="sizing" class="form-control">
                  <?php foreach($get_sizex as $data){ ?>
                    <option value="<?php echo $data->id_opsi_size;?>"><?php echo $data->opsi_size;?></option>
                  <?php }?>
                </select>
              </div>
              <div class="col-md-2 col-xs-2 padd0">
                <input type="number" name="stock[]" class="form-control">
              </div>
              <div class="col-md-2 col-xs-2 padd0">
                <input type="number" name="harga_dicoret[]" placeholder="Dicoret" class="form-control">
              </div>
              <div class="col-md-2 col-xs-2 padd0">
                <input type="number" name="harga_fix[]" placeholder="Fix" class="form-control">
              </div>
              <div class="col-md-2 col-xs-2">
                <select name="lokasi_barang[]" class="form-control">
                  <option value="ecommerce">Stok E-commerce</option>
                  <option value="store">Stok Toko</option>
                </select> 
              </div>
              <?php echo br(3)?>
            </div> 
          </div>
        </div>
      </div>
    </div>
    <div id="gambar1" class="tab-pane fade">
      <label><input type="radio" name="swt" class="form-control" onclick="swtdrop();" value="drop" checked> Drop Gambar</label>
      <label><input type="radio" name="swt" class="form-control" onclick="swturl();" value="url"> URL</label>
      <br>
      <br>
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
    <i style="color:red;">- Gambar tidak diupload jika melebihi 2 MB</i>
  </div>
</div>
<div class="col-md-3">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
        <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
        <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
        <h5>Tanggal    : <b><?php echo date('d M Y')?></b></h5>
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
  var no = 0;
  $('#simple-clone').cloneya();
  $('#gambar-clone').cloneya();
</script>