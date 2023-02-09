 <link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
 <script type="text/javascript">
  $(document).ready( function () { 

    $('#datetimepicker1').datetimepicker({
      format: 'yyyy-MM-dd'
    });         
  });
</script>
<div class="page-title">
  <h3>Produk Grouping Otomatis
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
      <li><a href="<?php echo base_url('trueaccon2194/produk/')?>">Produk</a></li>
      <li><a href="<?php echo base_url('trueaccon2194/produk/produk_grouping/')?>">Produk Grouping</a></li>
      <li class="active">Grouping Otomatis</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)" style="margin-right:10px;margin-bottom:10px;"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a> 
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/produk/create_grouping_otomatis', array('id'=>'form_produk_add'));?>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
        <div id="general" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-12 input group">
                <label>Masukkan Kisaran Harga yang berbeda-beda </label> <i style="color:red;">*</i>
                <br><br>
              </div>
              <div class="col-md-3 col-xs-3 padd0">
                <label>Harga Terendah : </label>
              </div>
              <div class="col-md-3 col-xs-3 padd0">
                <label>Harga Terendah : </label>
              </div>
              <div class="col-md-3 col-xs-3 padd0">
                <label>Gambar : </label>
              </div>
              <div class="col-md-3 col-xs-3">
                <label>Posisi : </label>
              </div>
              <div id="simple-clone">
                <div class="toclone">
                    <a style="margin-left: 15px;" href="#" class="btn btn-success clone"><i class="glyphicon glyphicon-plus"></i></a>
                    <a href="#" class="btn btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>
                    <br>
                  <div class="col-md-3 col-xs-3 padd0">
                    <div class="input-group">
                      <span class="input-group-addon">Rp.</span>
                      <input type="number" name="lowprice[]" class="form-control cek_retail" id="retail" placeholder="Terendah" required>
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-3 padd0">
                    <div class="input-group">
                      <span class="input-group-addon">Rp.</span>
                      <input type="number" name="highprice[]" class="form-control cek_odv" id="retail" placeholder="Tetinggi" required>
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-3 padd0">
                    <div class="input-group">
                    <input type="text" name="gambar[]" class="form-control" id="carfID">
                    <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
                    </span>
                    </div>
                    <br>
                  </div>
                  <div class="col-md-3 col-xs-3">
                    <select class="form-control" name="posisi[]" required>
                      <option value="">-- pilih --</option>
                      <option value="utama" selected>Halaman Utama</option>
                      <option value="promo">Halaman Promo</option>
                    </select>
                    <br>
                  </div>
                  <?php echo br(3)?>
                </div>
              </div>
            </div>
        </div>
        <i style="color:red;">(*) Masukkan harga tanpa titik koma.</i><br>
        <i style="color:red;">Posisi Halamana Utama, Ukuran Banner : 370px x 653px</i><br>
        <i style="color:red;">Posisi Halamana Promo, Ukuran Banner : 697px x 288px</i>
  </div>
</div>
<div class="col-md-3">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
        <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
        <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
        <h5>Tanggal    : <b><?php echo date('d M Y')?></b></h5>
        <button type="submit" class="simpan_review btn btn-success">Simpan</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<?php echo form_close();?>
<script src="<?php echo base_url('assets/manage/js/cloneya/jquery-cloneya.js');?>"></script>
<script>
  $('#simple-clone').cloneya();
</script>