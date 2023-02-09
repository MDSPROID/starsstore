<div class="page-title">
  <h3><i class="glyphicon glyphicon-globe"></i> Edit Akun Market place
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
      <li><a href="<?php echo base_url('trueaccon2194/user_preference')?>">Marketplace</a></li>
      <li class="active">Edit Akun</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open_multipart('trueaccon2194/online_store/update_akun')?>
        <div class="col-md-9 m-t-lg" >
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <div class="col-md-12 col-xs-12 input group">
                              <label>Nama Akun :<i style="color:red;">*</i></label>
                                <input type="text" name="nama" class="form-control cek_stat" value="<?php echo $updatedata['nama_akun']?>" placeholder="Nama Akun" required>
                                <input type="hidden" name="dti" value="<?php echo $updatedata['id_akun']?>">
                              <br>
                            </div>
                            <div class="col-md-12 col-xs-12 input group">
                              <label>Email :</label>
                              <input type="email" name="email" class="form-control cek_kota" value="<?php echo $updatedata['email']?>" id="retail" placeholder="Email" required>
                              <br>
                            </div>
                           <div class="col-md-6 col-xs-12 input group">
                              <label>Password : </label> <i style="color:red;">*</i>
                              <input type="password" name="pass1" class="form-control cek_pass1" id="pass1" placeholder="Password">
                              <div id="notif1"></div>
                              <br>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Ulangi Password : </label> <i style="color:red;">*</i>
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
        </div>
  <div class="col-md-3 col-xs-12">
    <div class="panel panel-primary" style="border-color:#d3d3d3;">
        <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
        <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
          <h5>Diubah oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
          <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
          <h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Simpan Akun</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>