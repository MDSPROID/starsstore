<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
$(function(){
  $('#datetimepicker1').datetimepicker({});
  $('#datetimepicker2').datetimepicker({});  
});
</script>
<div class="page-title">
  <h3>Produk Group Promo
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
      <li><a href="<?php echo base_url('trueaccon2194/produk/')?>">Produk</a></li>
      <li><a href="<?php echo base_url('trueaccon2194/produk/produk_grouping/')?>">Produk Grouping</a></li>
      <li class="active">Group Promo</li>
    </ol>
  </div> 
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)" style="margin-right:10px;margin-bottom:10px;"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a> 
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/produk/create_grouping_promo', array('id'=>'form_produk_add'));?>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
        <div id="general" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-12 input group">
                <label>Nama Grup : </label> <i style="color:red;">*</i>
                <input type="text" name="name_grup" class="form-control cek_retail" id="retail" placeholder="Nama Grup" required>
                <br>
              </div>
              <div class="col-md-6 col-xs-12 input group">
                <label>Gambar : </label> <i style="color:red;">*</i> 
                <div class="input-group">
                <input type="text" name="gambar" class="form-control" id="carfID" required>
                <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
                </span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12 input group">
                <label>Keterangan : </label> <i style="color:red;">*</i>
                <input type="text" name="keterangan" class="form-control cek_retail" id="retail" placeholder="Keterangan" required>
                <br>
              </div>
              <div class="col-md-6 col-xs-12 input group">
                <label>Tanggal Mulai :<i style="color:red;">*</i></label>
                  <div id="datetimepicker1" class="input-append">
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
              <div class="col-md-12 col-xs-12 input group">
                <label>Diskon Masal :<i style="color:red;">*</i></label>
                  <div class="input-group">
                    <input type="number" name="diskon" class="form-control cek_tgl" placeholder="Masukkan diskon masal" required>
                    <span class="input-group-addon">%</span>
                  </div>
                <br>
              </div>
              <div class="col-md-12 input group">
                <label>Produk : <i style="color:red;">*PASTIKAN PRODUK TIDAK DALAM KEADAAN DISKON*</i></label>
                <div style="height: 350px;overflow-y: scroll;">
                  <ul class="list-unstyled">
                  <?php foreach($list as $g){
                    if($g->gambar == ""){
                      $gb = base_url('assets/images/default.jpg');
                    }else{
                      $gb = $g->gambar;
                    }
                  ?>
                    <li style="height:50px;margin-bottom:10px;">
                      <label>
                        <input type="checkbox" style="position: absolute;top:20px;" name="idproduk[]" value="<?php echo $g->id_produk?>">
                        <div style="padding-left: 30px;margin-top: -20px;">
                          <h5 style="margin-bottom:0;font-weight:700;margin-top: 0;">
                            <img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" class='img-responsive pull-left' style='display: initial;' src='<?php echo $gb?>' width='50'>
                            <div style="padding-left:60px;">
                              <?php echo $g->nama_produk;?><br>[<?php echo $g->artikel?>]<br>
                              <?php if($g->harga_dicoret == 0 || empty($g->harga_dicoret)){ 
                                  echo "Rp. ".number_format($g->harga_fix,0,".",".")."";
                              }else{
                                  echo "<s style='color:#989898 ;'>Rp. ".number_format($g->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($g->harga_fix,0,".",".")."</span>";
                              }?>
                            </div>
                          </h5>
                        </div>
                      </label>
                    </li>
                  <?php }?>
                  </ul>
                </div>
                <br>
              </div>
            </div>
        </div>
        <i style="color:red;">(*) wajib diisi</i><br>
        <i style="color:red;">(*) promo tidak dapat diubah / diedit</i><br>
  </div>
</div>
<div class="col-md-3">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
        <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
        <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
        <h5>Tanggal    : <b><?php echo date('d M Y')?></b></h5>
        <button type="submit" class="simpan_review btn btn-success">Simpan</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<?php echo form_close();?>