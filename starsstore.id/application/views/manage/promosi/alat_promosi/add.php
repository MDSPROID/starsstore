<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
$(function(){
  $('#datetimepicker').datetimepicker({});
  $('#datetimepicker2').datetimepicker({});  
});
</script>
<div class="page-title">
  <h3>Tambah Promo
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
      <li>Promosi</li>
      <li><a href="<?php echo base_url('trueaccon2194/promo_slide_utama')?>">Promosi Slide Utama</a></li>
      <li class="active">Tambah Promo</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open('trueaccon2194/promo_slide_utama/proses_tambah_promo')?>
        <div class="col-md-9 m-t-lg">
            <div class="panel panel-white">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Nama Promo /slug</label>
                              <input type="text" name="nama_promo" class="form-control">
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Banner</label>
                              <div class="input-group">
                                <input type="text" name="banner_promo" class="form-control" id="carfID">
                                <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
                                </span>
                              </div>
                              <br>
                            </div>
                            <div class="col-md-12"><i style="color: red;">*Pilih Salah satu group diskon</i><br></div>
                            <div class="col-md-4 col-xs-12 input group">
                              <label>Grup Satu Diskon</label>
                              <select class="form-control promo1" name="jenis_promo1" id="promo1">
                                <option value="">-- Kosongi atau Banner Saja --</option>
                                <?php foreach($get_kriteria as $u){?>
                                  <option value="<?php echo $u->diskon?>,<?php echo $u->id_parent?>">Diskon <?php echo $u->diskon?>% (Kategori <?php echo $u->parent_kategori?>)</option>
                                <?php }?>
                              </select>
                              <br>
                            </div>
                            <div class="col-md-4 col-xs-12 input group">
                              <label>Grup Rentang Diskon</label>
                              <select class="form-control promo2" name="jenis_promo2" id="promo2">
                                <option value="">-- Kosongi atau Banner Saja --</option>
                                <?php foreach($get_kriteria_rentang as $u){
                                  if($u->diskon_min > $u->diskon_max){
                                    $min = $u->diskon_max;
                                    $max = $u->diskon_min;
                                ?>
                                <option value="<?php echo $min?>,<?php echo $max?>,<?php echo $u->id_parent?>">Diskon <?php echo $min?>% - <?php echo $max?>% (Kategori <?php echo $u->parent_kategori?>)</option>
                                <?php }else{
                                    $min = $u->diskon_min;
                                    $max = $u->diskon_max;
                                ?>
                                  <option value="<?php echo $min?>,<?php echo $max?>,<?php echo $u->id_parent?>">Diskon <?php echo $min?>% - <?php echo $max?>% (Kategori <?php echo $u->parent_kategori?>)</option>
                                <?php }}?>
                              </select>
                              <br>
                            </div>
                            <div class="col-md-4 col-xs-12 input group">
                              <label>Grup Rentang Harga per Kategori</label>
                              <select class="form-control promo3" name="jenis_promo3" id="promo3">
                                <option value="">-- Kosongi atau Banner Saja --</option>
                                <?php foreach($get_kriteria_rentang_harga as $u){
                                  if($u->harga_min == $u->harga_max){

                                  }else{
                                ?>
                                  <option value="<?php echo $u->harga_min?>,<?php echo $u->harga_max?>,<?php echo $u->id_parent?>">Harga Rp.<?php echo $u->harga_min?> - Rp.<?php echo $u->harga_max?> (Kategori <?php echo $u->parent_kategori?>)</option>
                                <?php }}?>
                              </select>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Tanggal Mulai</label>
                                <div id="datetimepicker" class="input-append">
                                  <input type="text" data-format="yyyy-MM-dd HH:mm:ss" name="tgl_mulai" class="form-control cek_tgl" placeholder="Tanggal Order" required>
                                  <span class="add-on">
                                    <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                  </span>   
                                </div>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Tanggal Akhir</label>
                                <div id="datetimepicker2" class="input-append">
                                  <input type="text" data-format="yyyy-MM-dd HH:mm:ss" name="tgl_akhir" class="form-control cek_tgl" placeholder="Tanggal Order" required>
                                  <span class="add-on">
                                    <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                  </span>   
                                </div>
                              <br>
                            </div>
                        </div>                                        
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
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Simpan Promo</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>