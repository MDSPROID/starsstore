<div class="page-title">
  <h3>Edit Broadcast Email
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
      <li class="active">Edit Email</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/email/update_email', array('id'=>'form_produk_add'));?>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
        <div id="general" class="tab-pane fade in active">
            <div class="row">
               <div class="col-md-12 input group">
                <label>From: </label>
                <?php 
                  $a = $this->encrypt->encode($g['id']);
                  $b = base64_encode($a);
                ?> 
                <input type="hidden" name="mail" value="<?php echo $b?>">
                <select name="from" class="form-control" required>
                  <?php if($g['from'] == "admin@starsallthebest.com"){?>
                  <option selected value="admin@starsallthebest.com">admin@starsallthebest.com</option>
                  <option value="newsletter@starsallthebest.com">newsletter@starsallthebest.com</option>
                  <option value="custom">Kustom</option>
                  <?php }else if($g['from'] == "newsletter@starsallthebest.com"){?>
                  <option value="admin@starsallthebest.com">admin@starsallthebest.com</option>
                  <option selected value="newsletter@starsallthebest.com">newsletter@starsallthebest.com</option>
                  <option value="custom">Kustom</option>
                  <?php }else{?>
                  <option value="admin@starsallthebest.com">admin@starsallthebest.com</option>
                  <option value="newsletter@starsallthebest.com">newsletter@starsallthebest.com</option>
                  <option value="custom" selected>Kustom</option>
                  <?php }?>
                </select>
                <?php if($g['to_type'] == "custom"){
                  $tampilfrom = "";
                }else{
                  $tampilfrom = "none";
                }?>
                <input type="email" name="fromcustom" value="<?php echo $g['from']?>" placeholder="Masukkan Email Kustom" class="fromcustom form-control" style="display: <?php echo $tampilfrom?>;">
                <br>
              </div>
              <div class="col-md-12 input group">
                <label> Kepada : <i style="color:red;">*</i></label>
                <select class="form-control cek_nama" name="kategori_email" required>
                  <?php if($g['to_type'] == "newsletter"){?>
                    <option selected value="newsletter">Newsletter Customer</option>
                    <option value="admin">Admin</option>
                    <option value="finance">Finance</option>
                    <option value="support">Support</option>
                    <option value="sales">Sales</option>
                    <option value="cc">CC</option>
                    <option value="bcc">BCC</option>
                    <option value="custom">Kustom</option>
                  <?php }else if($g['to_type'] == "admin"){?>
                    <option value="newsletter">Newsletter Customer</option>
                    <option selected value="admin">Admin</option>
                    <option value="finance">Finance</option>
                    <option value="support">Support</option>
                    <option value="sales">Sales</option>
                    <option value="cc">CC</option>
                    <option value="bcc">BCC</option>
                    <option value="custom">Kustom</option>
                  <?php }else if($g['to_type'] == "finance"){?>
                    <option value="newsletter">Newsletter Customer</option>
                    <option value="admin">Admin</option>
                    <option selected value="finance">Finance</option>
                    <option value="support">Support</option>
                    <option value="sales">Sales</option>
                    <option value="cc">CC</option>
                    <option value="bcc">BCC</option>
                    <option value="custom">Kustom</option>
                  <?php }else if($g['to_type'] == "support"){?>
                    <option value="newsletter">Newsletter Customer</option>
                    <option value="admin">Admin</option>
                    <option value="finance">Finance</option>
                    <option selected value="support">Support</option>
                    <option value="sales">Sales</option>
                    <option value="cc">CC</option>
                    <option value="bcc">BCC</option>
                    <option value="custom">Kustom</option>
                  <?php }else if($g['to_type'] == "sales"){?>
                    <option value="newsletter">Newsletter Customer</option>
                    <option value="admin">Admin</option>
                    <option value="finance">Finance</option>
                    <option value="support">Support</option>
                    <option selected value="sales">Sales</option>
                    <option value="cc">CC</option>
                    <option value="bcc">BCC</option>
                    <option value="custom">Kustom</option>
                  <?php }else if($g['to_type'] == "cc"){?>
                    <option value="newsletter">Newsletter Customer</option>
                    <option value="admin">Admin</option>
                    <option value="finance">Finance</option>
                    <option value="support">Support</option>
                    <option value="sales">Sales</option>
                    <option selected value="cc">CC</option>
                    <option value="bcc">BCC</option>
                    <option value="custom">Kustom</option>
                  <?php }else if($g['to_type'] == "bcc"){?>
                    <option value="newsletter">Newsletter Customer</option>
                    <option value="admin">Admin</option>
                    <option value="finance">Finance</option>
                    <option value="support">Support</option>
                    <option value="sales">Sales</option>
                    <option value="cc">CC</option>
                    <option selected value="bcc">BCC</option>
                    <option value="custom">Kustom</option>
                  <?php }else{?>
                    <option value="newsletter">Newsletter Customer</option>
                    <option value="admin">Admin</option>
                    <option value="finance">Finance</option>
                    <option value="support">Support</option>
                    <option value="sales">Sales</option>
                    <option value="cc">CC</option>
                    <option value="bcc">BCC</option>
                    <option selected value="custom">Kustom</option>
                  <?php }?>
                </select>
                <br>
                <div class="katmailcustom" style="display: <?php echo $tampilfrom?>;">
                  <i style="color:red">*Jika email lebih dari satu pisahkan dengan koma (,)</i>
                  <input type="email" name="katmailcustom" value="<?php echo $g['to'];?>" placeholder="Masukkan Email Kustom" class="form-control">
                </div>
                <br>
              </div>
              <div class="col-md-12 input group">
                <label> Judul : <i style="color:red;">*</i></label>
                <input type="text" name="judul" class="form-control" placeholder="judul" value="<?php echo $g['judul']?>" required>
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
                <textarea name="message" id="mytextarea" required><?php echo $g['message']?></textarea>
                <input type="hidden" name="stat" value="<?php echo $g['status']?>">
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
        <button type="submit" name="mailto" value="simpan" class="simpan_review btn btn-primary"><i class="glyphicon glyphicon-save"></i> Update</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<?php echo form_close();?>
