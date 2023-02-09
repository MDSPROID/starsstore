<div class="page-title">
  <h3><i class="glyphicon glyphicon-user"></i> Edit Rekening
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
      <li class="active">Edit Rekening</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open_multipart('trueaccon2194/setting/update_rekening')?>
        <div class="col-md-9 m-t-lg" >
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Nama Bank :<i style="color:red;">*case sensitive (gunakan huruf kecil)</i></label>
                               <input type="hidden" name="ibn" value="<?php $a = $this->encrypt->encode($g['id']);$b = base64_encode($a); echo $b; ?>">
                              <input type="text" name="bank_name" class="form-control cek_ecom" placeholder="Nama Bank" value="<?php echo $g['name_bank']?>" required>
                              <input type="hidden" name="kry" value="<?php $a = $this->encrypt->encode('N7r2bskHr28');$b = base64_encode($a); echo $b; ?>">
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Code Network :<i style="color:red;">*</i></label>
                                <input type="number" name="code_network" value="<?php echo $g['code_network']?>" class="form-control cek_stat" placeholder="Code Network Bank" required>
                              <br>
                            </div>
                            <div class="col-md-6 input group">
                              <label>Bank Cabang :</label>
                              <input type="text" value="<?php echo $g['bank_cabang']?>" name="cabang" class="form-control cek_kota" id="retail" placeholder="Bank Cabang" required>
                              <br>
                            </div>
                            <div class="col-md-6 input group">
                              <label>No. Rekening :</label>
                              <input type="number" name="no_rek" value="<?php echo $g['no_rek']?>" class="form-control cek_retail nm" id="user" placeholder="Nomor Rekening" required>
                              <br>
                            </div>
                             <div class="col-md-12 input group">
                              <label>Atas Nama :</label>
                              <input type="text" name="a_n" class="form-control cek_odv nm" value="<?php echo $g['a_n']?>" id="user" placeholder="Nomor Rekening" required>
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
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Update Rekening</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>