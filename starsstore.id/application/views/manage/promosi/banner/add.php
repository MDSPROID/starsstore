<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
$(function(){
  $('#datetimepicker').datetimepicker({});
  $('#datetimepicker2').datetimepicker({});  
});
</script>
<div class="page-title">
  <h3>Tambah Banner
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
      <li><a href="<?php echo base_url('trueaccon2194/media_promosi')?>">Banner & Slider</a></li>
      <li class="active">Tambah Banner</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open('trueaccon2194/media_promosi/add_banner')?>
        <div class="col-md-9 m-t-lg">
            <div class="panel panel-white">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Posisi :<i style="color:red;">*</i></label>
                              <select class="form-control cek_odv" name="posisi" required>
                                <option value="utama">Utama</option>
                              </select>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Banner :<i style="color:red;">*</i></label>
                              <div class="input-group">
                                <input type="text" name="banner" class="form-control cek_stat" id="carfID" required>
                                <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
                                </span>
                              </div>
                              <br>
                            </div>
                            <div class="col-md-6 input group">
                              <label>Perclick :</label>
                              <div class="input-group">
                              <span class="input-group-addon">Rp.</span>
                              <input id="amount" type="number" name="perclick" class="form-control cek_retail" id="retail" value="0" placeholder="Harga Perclick" >
                              </div>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>URL :<i style="color:red;">*</i></label>
                              <input type="text" name="url" class="form-control cek_slug" placeholder="URL / Link" required>
                              <br>
                            </div>
                             <div class="col-md-12 col-xs-12 input group">
                              <label>Keterangan :<i style="color:red;">*</i></label>
                              <input type="text" name="ket" class="form-control cek_nama" placeholder="Keterangan" required>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Tanggal Mulai :<i style="color:red;">*</i></label>
                                <div id="datetimepicker" class="input-append">
                                  <input type="text" data-format="yyyy-MM-dd" name="tgl_mulai" class="form-control cek_tgl" placeholder="Tanggal Mulai" required>
                                  <span class="add-on">
                                    <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                  </span>   
                                </div>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Tanggal Akhir :<i style="color:red;">*</i></label>
                                <div id="datetimepicker2" class="input-append">
                                  <input type="text" data-format="yyyy-MM-dd" name="tgl_akhir" class="form-control cek_tgl" placeholder="Tanggal Berakhir" required>
                                  <span class="add-on">
                                    <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                  </span>   
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
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Simpan Banner</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>