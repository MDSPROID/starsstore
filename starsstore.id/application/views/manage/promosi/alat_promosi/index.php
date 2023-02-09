<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {

      $("#table_promotion").DataTable();
      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd'
      });       
  });
</script>
<style type="text/css">
  .navpromo a{
    height: 100px;
  }
</style>
<div class="page-title">
  <h3>Alat Promosi
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/alat_promosi')?>">Alat Promosi</a> </li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">  
    <div class="panel-body">  
      <div class="row">
        <div class="col-md-3 col-xs-6 text-center">
          <a href="<?php echo base_url('trueaccon2194/alat_promosi/popup_homepage');?>">
          <div class="bt_mart" style="background-color: white;color: grey;border: 1px solid gainsboro;box-shadow: 0 0 7px gainsboro;height: auto;padding: 15px;">
              <h1 style="margin-top: 5px;"><i class="glyphicon glyphicon-comment"></i></h1>
              Popup Homepage
          </div>
          </a>
        </div>
        <div class="col-md-3 col-xs-6 text-center">
          <a href="<?php echo base_url('trueaccon2194/produk/daftar_grup');?>">
          <div class="bt_mart" style="background-color: white;color: grey;border: 1px solid gainsboro;box-shadow: 0 0 7px gainsboro;height: auto;padding: 15px;">
            <h1 style="margin-top: 5px;"><i class="glyphicon glyphicon-tags"></i></h1>
            Grup Promo Produk
          </div>
          </a>
        </div>
        <div class="col-md-3 col-xs-6 text-center">
          <a href="<?php echo base_url('trueaccon2194/merk');?>">
          <div class="bt_mart" style="background-color: white;color: grey;border: 1px solid gainsboro;box-shadow: 0 0 7px gainsboro;height: auto;padding: 15px;">
            <h1 style="margin-top: 5px;"><i class="glyphicon glyphicon-tag"></i></h1>
            Banner Promo Merk
          </div>
          </a>
        </div>
        <div class="col-md-3 col-xs-6 text-center">
          <a href="<?php echo base_url('trueaccon2194/media_promosi');?>">
          <div class="bt_mart" style="background-color: white;color: grey;border: 1px solid gainsboro;box-shadow: 0 0 7px gainsboro;height: auto;padding: 15px;">
            <h1 style="margin-top: 5px;"><i class="glyphicon glyphicon-picture"></i></h1>
            Banner & Slider
          </div>
          </a>
        </div>
        <div class="col-md-3 col-xs-6 text-center">
          <a href="<?php echo base_url('trueaccon2194/voucher');?>">
          <div class="bt_mart" style="background-color: white;color: grey;border: 1px solid gainsboro;box-shadow: 0 0 7px gainsboro;height: auto;padding: 15px;">
            <h1 style="margin-top: 5px;"><i class="glyphicon glyphicon-gift"></i></h1>
            Voucher & Kupon
          </div>
          </a>
        </div>
        <div class="col-md-3 col-xs-6 text-center">
          <a href="<?php echo base_url('trueaccon2194/alat_promosi/free_ongkir');?>">
          <div class="bt_mart" style="background-color: white;color: grey;border: 1px solid gainsboro;box-shadow: 0 0 7px gainsboro;height: auto;padding: 15px;">
            <h1 style="margin-top: 5px;"><i class="fa fa-truck"></i></h1>
            Free Ongkir Kota
          </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap modal tambah-->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Book Form</h3>
      </div>
      <div class="modal-body form">
        <?php 
        $id = array('id' => 'form_edit_judul');
        echo form_open('', $id);
        ?>
          <input type="hidden" value="" name="id"/>
          <div class="row">
          <div class="col-md-12 col-xs-12 input group">
            <label>Ubah Judul :</label>
            <input type="text" name="judul" class="form-control" id="judul" placeholder="Judul" required>
            <input type="hidden" name="id_judul" class="form-control" id="id_judul">
            <br>
          </div>
        <?php echo form_close();?>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" class="simpan_judul btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
  <!-- End Bootstrap modal -->

  <!-- Bootstrap modal tambah-->
  <div class="modal fade" id="home_flag" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Book Form</h3>
      </div>
      <div class="modal-body form">
        <?php 
        $id = array('id' => 'form_edit_home_flag');
        echo form_open('', $id);
        ?>
          <div class="row">
          <div class="col-md-12 col-xs-12 input group">
            <label>Judul :</label>
            <input type="text" name="flag" class="form-control" id="flag" placeholder="Judul" required>
            <input type="hidden" name="id_flag" class="form-control" id="id_flag">
            <br>
          </div>
          <div class="col-md-6 input group ">
            <label>Tanggal awal : <i style="color:red;">*</i></label>
            <div id="datetimepicker1" class="input-append">
                <input type="text" data-format="yyyy-MM-dd" name="tgl1" class="form-control cek_tgl" placeholder="Tanggal awal" required>
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
          <div class="col-md-6 input group ">
            <label>Tanggal akhir : <i style="color:red;">*</i></label>
            <div id="datetimepicker2" class="input-append">
                <input type="text" data-format="yyyy-MM-dd" name="tgl2" class="form-control cek_tgl" placeholder="Tanggal akhir" required>
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
        <?php echo form_close();?>
        </div>
          <div class="modal-footer">
            <button type="button" id="btnSavehomeflag" class="simpan_home_flag btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            <button type="button" id="btnnonaktif" class="disabled_home_flag btn btn-warning" data-dismiss="modal">Nonaktifkan</button>
            <button type="button" id="btnaktif" class="enable_home_flag btn btn-success" data-dismiss="modal">aktifkan</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
  <!-- End Bootstrap modal -->