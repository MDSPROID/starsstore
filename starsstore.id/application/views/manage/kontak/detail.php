<div class="page-title">
  <h3>Detail
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
      <li><a href="<?php echo base_url('trueaccon2194/kontak')?>">Kontak</a></li>
      <li class="active">Detail</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
    <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
    <div id="general" class="tab-pane fade in active">
        <div class="row">
          <div class="col-md-6 input group">
            <label>Nama Pelanggan : <i style="color:red;">*</i></label>
            <input type="text" name="nama" class="form-control cek_nama" id="nama" placeholder="Nama lengkap" value="<?php echo $r['nama']?>" readonly>
          </div>
          <div class="col-md-6 input group">
            <label>Email : </label> <i style="color:red;">*tanpa spasi dan tanpa huruf besar</i>
            <input type="text" name="email" class="form-control cek_slug" id="slug" placeholder="Email" value="<?php echo $r['email']?>" readonly>
          </div>
          <div class="col-md-12"></div>
          <div style="margin-top:20px;" class="col-md-12 input group">
            <label>Deskripsi : <i style="color:red;">*</i></label>
            <textarea name="editor1"><?php echo $r['pertanyaan']?></textarea>
          </div>
        </div>
    </div>
  </div>
</div>
<div class="col-md-3">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
        <h5>Nomor Tiket     : <b><?php echo $r['no_kontak']?></b></h5>
        <h5>Kategori Keluhan  : <b><?php echo $r['kategori_keluhan']?></b></h5>
        <h5>Status  : <b><?php if($r['status'] == "ditangguhkanmenunggu"){ echo "<label class='label label-warning'>Menunggu Balasan</label>";}else if($r['status'] == "dibalaskan"){ echo "<label class='label label-success'>Dibalas</label>";}else{ echo "<label class='label label-danger'>Dibatalkan</label>";}?></b></h5>
        <h5>Tanggal    : <b><?php $t = $r['date_create']; echo date('d F Y H:i:s', strtotime($t));?></b></h5>
        <h5>IP Address     : <b><?php echo $r['ip']?></b></h5>
        <h5>Browser     : <b><?php echo $r['browser']?></b></h5>
        <h5>OS     : <b><?php echo $r['os']?></b></h5>
    </div>
    </div>
</div>
  </div>
</div>