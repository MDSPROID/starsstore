<div class="page-title">
  <h3><i class="glyphicon glyphicon-user"></i> Tambah Toko Lain
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
      <li><a href="<?php echo base_url('trueaccon2194/setting')?>">Setting</a></li>
      <li class="active">Tambah Toko Lain</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open_multipart('trueaccon2194/setting/update_toko')?>
        <div class="col-md-9 m-t-lg" >
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Nama akun :<i style="color:red;">*</i></label>
                              <input type="text" name="akun" class="form-control cek_ecom" placeholder="Nama akun" value="<?php echo $g['nama']?>" required>
                              <input type="hidden" name="kry" value="<?php $a = $this->encrypt->encode($g['id']);$b = base64_encode($a); echo $b; ?>">
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Link :<i style="color:red;">*</i></label>
                                <input type="text" name="link" class="form-control cek_stat" value="<?php echo $g['link']?>" placeholder="Link" required>
                              <br>
                            </div>
                            <div class="col-md-6 input group">
                              <label>Keterangan :</label>
                              <input type="text" name="keterangan" class="form-control cek_kota" id="retail" value="<?php echo $g['keterangan']?>" placeholder="Keterangan" required>
                              <br>
                            </div>
                            <div class="col-md-6 input group">
                              <label>Gambar : <i style="color:red;">*</i></label><i style="color:red;">Gambar tidak diupload jika melebihi 1MB</i>
                              <div class="input-group">
                              <input type="text" name="gambar" class="form-control" id="carfID" value="<?php echo $g['gambar']?>">
                              <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
                              </span>
                              </div>
                              <br>
                            </div>
                            <div class="col-md-12">
                              <label>Status :</label>
                              <div class="ios-switch switch-lg">
                                  <input type="checkbox" name="status" class="js-switch pull-right fixed-header-check" <?php if($g['status'] == "on"){ echo "checked";}else{ }?>>
                              </div>
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
          <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
          <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
          <h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Simpan Toko</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>