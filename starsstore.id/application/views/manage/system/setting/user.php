<div class="page-title">
  <h3><i class="glyphicon glyphicon-user"></i> Profile
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
      <li class="active">Profile</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open_multipart('trueaccon2194/setting/update_user')?>
        <div class="col-md-9 m-t-lg" >
        <?php 
          $user_log = info_user_login();
          foreach($user_log as $d){
        ?>
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <div class="col-md-12 col-xs-12 input group">
                              <label>Avatar :<i style="color:red;">*</i></label>
                              <input type="file" name="avatar" class="form-control cek_tags" id="gambar_utama" placeholder="Gambar">
                              <input type="hidden" name="gb" class="form-control" value="<?php echo $d->gb_user?>">
                              <input type="hidden" name="is" class="form-control" value="<?php $a = $this->encrypt->encode($d->id);
    $b = base64_encode($a); echo $b?>">
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Nama :<i style="color:red;">*</i></label>
                                <input type="text" name="nama" value="<?php echo $d->nama_depan?>" class="form-control cek_stat" placeholder="Nama" required>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Email :</label>
                              <input type="email" name="email" class="form-control cek_kota" value="<?php echo $d->email?>" id="retail" placeholder="Email" required>
                              <br>
                            </div>
                            <div class="col-md-12 col-xs-12 input group">
                              <label>Username :</label>
                              <input type="text" name="user" class="form-control cek_retail nm" id="user" value="<?php echo $d->username?>" placeholder="Username" required>
                              <div id="al" style="color: red;"></div>
                              <br>
                            </div>
                            <div class="col-md-12 col-xs-12"><h5>*untuk mengganti password, masukkan password baru anda disini.</h5></div>
                           <div class="col-md-6 col-xs-12 input group">
                              <label>Password : </label> <i style="color:red;">*</i>
                              <input type="password" name="pass1" class="form-control cek_pass1" id="pass1" placeholder="Password">
                              <div id="notif1"></div>
                              <br>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Masukkan Password : </label> <i style="color:red;">*</i>
                              <input type="password" name="pass2" class="form-control cek_pass2" id="pass2" placeholder="Masukkan Password yang sama">
                              <div id="notif"></div>
                              <br>
                              <br>
                            </div>
                        </div>                                        
                        <i style="color:red;">(*) Wajib diisi</i>
                    </div>
                </div>
            </div>
          <?php }?>
        </div>
  <div class="col-md-3 col-xs-12">
    <div class="panel panel-primary" style="border-color:#d3d3d3;">
        <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
        <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
          <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
          <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
          <h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Simpan User</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>