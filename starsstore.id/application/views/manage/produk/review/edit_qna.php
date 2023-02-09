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
  <h3>Edit Q&A Produk
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
      <li class="active">Edit Review Produk</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/review_produk/update_qna_produk', array('id'=>'form_produk_add'));?>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
        <div id="general" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-12 col-xs-12 input group">
                <label> Nama Produk : <i style="color:red;">*</i></label>
                <select class="form-control cek_nama" name="produk"> 
                  <?php foreach($produk as $data){ 
                  if($data['id_produk'] == $g['id_produk']){?>
                    <option value="<?php echo $data['nama_produk']?>" SELECTED><?php echo $data['nama_produk']?> [<?php echo $data['artikel']?>]</option>    
                      <?php }else{?>
                    <option value="<?php echo $data['nama_produk']?>"><?php echo $data['nama_produk']?> [<?php echo $data['artikel']?>]</option>    
                  <?php }}?>
                </select>
                <input type="hidden" name="id_qna" value="<?php echo $g['id_q_n_a']?>">
                <br>
              </div>
              <div class="col-md-6 col-xs-6 input group">
                <label>Nama Customer: </label> <i style="color:red;">*</i>
                <input type="text" name="nama_qna" class="form-control cek_slug" id="slug" value="<?php echo $g['nama']?>" placeholder="Nama Customer" >
                <br>
              </div>
              <div class="col-md-6 col-xs-6 input group">
                <label>Pertanyaan: </label> <i style="color:red;">*</i>
                <input type="text" name="pertanyaan" class="form-control cek_slug" id="slug" value="<?php echo $g['pertanyaan']?>" placeholder="Pertanyaan" >
                <br>
              </div>
              <div class="col-md-6 col-xs-6 input group">
                <label>Admin: </label> <i style="color:red;">*</i>
                <input type="text" name="admin" class="form-control cek_slug" id="slug" value="<?php echo $g['nama_balas']?>" placeholder="Admin" >
                <br>
              </div>
              <div class="col-md-6 col-xs-6 input group">
                <label>Balasan: </label> <i style="color:red;">*</i>
                <input type="text" name="balasan" class="form-control cek_slug" id="slug" value="<?php echo $g['balasan']?>" placeholder="Balasan" >
                <br>
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
        <button type="submit" class="simpan_review btn btn-success">Simpan</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<?php echo form_close();?>