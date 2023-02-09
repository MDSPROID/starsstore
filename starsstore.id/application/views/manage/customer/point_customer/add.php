<div class="page-title">
  <h3>Tambah Customer
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
      <li><a href="<?php echo base_url('trueaccon2194/customer')?>">Customer</a></li>
      <li class="active">Tambah Customer</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/customer/proses_tambah_customer', array('id'=>'form_produk_add'));?>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
      	<div id="general" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-6 input group">
                <label> Nama Lengkap : <i style="color:red;">*</i></label>
                <input type="text" name="nama" class="form-control cek_nama" id="slug" placeholder="Nama Lengkap" >
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Email : </label> <i style="color:red;">*</i>
                <input type="email" name="email" class="form-control cek_email" id="slug" placeholder="Email" >
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Password : </label> <i style="color:red;">*</i>
                <input type="password" name="pass1" class="form-control cek_pass1" id="pass1" placeholder="Password" >
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Masukkan Password : </label> <i style="color:red;">*</i>
                <input type="password" name="pass2" class="form-control cek_pass2" id="pass2" placeholder="Masukkan Password yang sama" >
                <div id="notif"></div>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Telpon : <i style="color:red;">*</i></label>
                <input type="number" name="telpon" class="form-control cek_telp" id="slug" placeholder="Nomor Telpon" >
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Gambar Profil : <i style="color:red;">*</i></label><i style="color:red;">Gambar tidak diupload jika melebihi 1MB</i>
                <div class="input-group">
                <input type="text" name="gambar" class="form-control cek_kota" id="carfID">
                <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
                </span>
                </div>
                <br>
              </div>
              <div class="col-md-12 input group">
                <label>Gender : <i style="color:red;">*</i></label>
                <ul class="list-unstyled">
                <input type="hidden" name="ins" value="<?php $a = $this->encrypt->encode('Hl0d!GJ5623bvhj3'); $b = base64_encode($a); echo $b?>">
                  <li><label><input type="radio" name="gender" class="form-control" value="pria" checked>Pria</label></li>
                  <li><label><input type="radio" name="gender" class="form-control" value="wanita">Wanita</label></li>
                </ul>
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
        <button type="submit" class="simpan_review btn btn-success">Simpan Data Customer</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<?php echo form_close();?>