 <link href="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" rel="stylesheet" type="text/css"/>
 <script src="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.min.js');?>"></script>
<script type="text/javascript">
$(function(){
    $('.seacrhart').autocomplete({
        serviceUrl: baseURL + 'trueaccon2194/produk/searchart',
        onSelect: function (res) {
            $('#artikel').val(''+res.artikel); // membuat id 'v_jurusan' untuk ditampilkan
        }
    });
});
</script>
<div class="page-title">
  <h3>Tambah Review Produk
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
      <li><a href="<?php echo base_url('trueaccon2194/review_produk')?>">Review Produk</a></li>
      <li class="active">Tambah Review Produk</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/review_produk/proses_tambah_review_produk', array('id'=>'form_produk_add'));?>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
      	<div id="general" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-12 input group">
                <label> Nama Produk : <i style="color:red;">*</i></label>
                <select class="form-control cek_nama" name="produk">
                <?php foreach($produk as $r){?>
                  <option value="<?php echo $r['id_produk']?>"><?php echo $r['nama_produk']?> [<?php echo $r['artikel']?>]</option>
                <?php }?>
                </select>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Nama Pe-review: </label> <i style="color:red;">*</i>
                <input type="text" name="nama_review" class="form-control cek_slug" id="slug" placeholder="Nama Pe-review" >
                <br>
              </div>
              <div class="col-md-6">
                <label>Status :</label>
                <div class="ios-switch switch-lg">
                    <input type="checkbox" name="status" class="js-switch pull-right fixed-header-check" checked>
                </div>
                <br><br>
              </div>
              <div class="col-md-6 input group">
                <label>Rating : <i style="color:red;">*</i></label>
                <ul class="list-unstyled rate">
                  <li><label><input type="radio" id="rt" name="rt" value="5stars.png"><span class="stars5">&nbsp</span></label></li>
                  <li><label><input type="radio" id="rt" name="rt" value="4stars.png"><span class="stars4">&nbsp</span></label></li>
                  <li><label><input type="radio" id="rt" name="rt" value="3stars.png"><span class="stars3">&nbsp</span></label></li>
                  <li><label><input type="radio" id="rt" name="rt" value="2stars.png"><span class="stars2">&nbsp</span></label></li>
                  <li><label><input type="radio" id="rt" name="rt" value="1stars.png"><span class="stars1">&nbsp</span></label></li>
                  <li><label><input type="radio" id="rt" name="rt" value="0stars.png"><span class="stars0">&nbsp</span></label></li>
                </ul>
                <br>
              </div>
              <div class="col-md-12"></div>
              <div style="margin-top:20px;" class="col-md-12 input group">
                <label>Review : <i style="color:red;">*</i></label>
                <textarea name="review" id="mytextarea" ></textarea>
              <?php echo br()?>
              </div>
            </div>
        </div>
        <i style="color:red;">(*) wajib diisi</i>
  </div>
</div>
<div class="col-md-3">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
        <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
        <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
        <h5>Tanggal    : <b><?php echo date('d M Y')?></b></h5>
        <button type="submit" class="simpan_review btn btn-success">Simpan Review</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<?php echo form_close();?>