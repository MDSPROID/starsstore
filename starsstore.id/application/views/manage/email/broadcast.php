<div class="page-title">
  <h3>Broadcast Email
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
      <li><a href="<?php echo base_url('trueaccon2194/email')?>">Email</a></li>
      <li class="active">Broadcast Email</li>
    </ol>
  </div> 
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/email/send_broadcast', array('id'=>'form_produk_add'));?>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
      	<div id="general" class="tab-pane fade in active">
            <div class="row">
               <div class="col-md-12 input group">
                <label>From: </label>
                <select name="from" class="from form-control" required>
                  <option value="admin@starsallthebest.com">admin@starsallthebest.com</option>
                  <option value="newsletter@starsallthebest.com">newsletter@starsallthebest.com</option>
                  <option value="custom">Kustom</option>
                </select>
                <input type="email" name="fromcustom" placeholder="Masukkan Email Kustom" class="fromcustom form-control" style="display: none;">
                <br>
              </div>
              <div class="col-md-12 input group">
                <label> Kepada : <i style="color:red;">*</i></label>
                <select class="form-control kategori_email" name="kategori_email" required>
                  <option value="newsletter">Newsletter</option>
                  <option value="customer">Customer</option>
                  <option value="admin">Admin</option>
                  <option value="finance">Finance</option>
                  <option value="support">Support</option>
                  <option value="sales">Sales</option>
                  <option value="cc">CC</option>
                  <option value="bcc">BCC</option>
                  <option value="custom">Kustom</option>
                </select><br>
                <div class="katmailcustom" style="display: none;">
                  <i style="color:red">*Jika email lebih dari satu pisahkan dengan koma (,)</i>
                  <input type="email" name="katmailcustom" placeholder="Masukkan Email Kustom" class="form-control">
                </div>
                <br>
              </div>
              <div class="col-md-12 input group">
                <label> Judul : <i style="color:red;">*</i></label>
                <input type="text" name="judul" class="form-control" placeholder="judul" required>                
                <br>
              </div>
              <div class="hidden col-md-12 input group">
                <label> Gunakan Template : <i style="color:red;">*</i></label><br>
                <label class="label label-primary tem1">Template 1</label>
                <label class="label label-primary tem2">Template 2</label>
                <label class="label label-primary tem3">Template 3</label>
                <label class="label label-primary tem4">Template 4</label>
                <label class="label label-primary tem5">Template 5</label>
              </div>
              <div style="margin-top:20px;" class="col-md-12 input group">
                <label>Pesan : <i style="color:red;">*</i></label>
                <textarea name="message" id="mytextarea"></textarea>
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
        <button type="submit" name="mailto" class="simpan_review btn btn-success" value="kirim"><i class="glyphicon glyphicon-send"></i> Kirim pesan</button> <button type="submit" name="mailto" value="simpan" class="simpan_review btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<?php echo form_close();?>
