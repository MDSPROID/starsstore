<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () { 

    $("#table_bestseller").DataTable();
    $('#datetimepicker1').datetimepicker({
      format: 'yyyy-MM-dd'
    });  
    $('#datetimepicker2').datetimepicker({
      format: 'yyyy-MM-dd'
    });    
  });
</script>
<div class="page-title">
  <h3>Best Seller
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
      <li class="active">Best seller</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<?php 
  $id = array('id' => 'form');
  echo form_open('', $id);
?>
  <div class="col-md-12">
      <div class="fil_best_seller">

        <div class="row">
          <div class="col-md-3 col-xs-12 form-group">
            <fieldset class="field-fix">
            <legend class="leg-fix">Tanggal</legend>
              <div class="row">
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
                <div class="col-md-12">
                  <button style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best" onclick="cari_best_seller()"><i class="glyphicon glyphicon-filter"></i> Cari Best Seller</button>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-3 col-xs-12 form-group">
            <fieldset class="field-fix">
            <legend class="leg-fix">Sort By</legend>
              <div class="row">
              <div class="col-md-12">
                <div class="controls" style="margin-top: -5px;">
                    <label>
                        <input type="radio" name="filter_by" value="nda" checked> New Develop Article
                    </label>
                    <label>
                        <input type="radio" name="filter_by" value="fm"> Best Seller By FM
                    </label>
                    <label>
                        <input type="radio" name="filter_by" value="bseller"> Best Seller By Sales
                    </label>
                </div>
              </div>
              </div>
            </fieldset>
          </div> 
          <div class="col-md-3 col-xs-12 form-group">
            <fieldset class="field-fix">
            <legend class="leg-fix">Jenis Artikel</legend>
              <div class="row">
                <div class="col-md-12">
                   <div class="controls" style="margin-top: -5px;">
                      <label><input type="radio" name="filter_by_jenis" value="own"> Own</label>
                      <label><input type="radio" name="filter_by_jenis" value="konsinyasi"> Konsinyasi</label>
                      <label><input type="radio" name="filter_by_jenis" value="branded"> Branded</label>
                      <label><input type="radio" name="filter_by_jenis" value="dropship"> Dropship</label>
                      <label><input type="radio" name="filter_by_jenis" value="all" checked> Semua</label>
                  </div>
                </div>
            </div>
            </fieldset>
          </div>
          <div class="col-md-3 col-xs-12">
            <fieldset class="field-fix">
            <legend class="leg-fix">Age</legend>
              <div class="row">
                <div class="col-md-12">
                    <div class="controls" style="margin-top: -5px;">
                      <label><input type="checkbox" name="st_or_diskontinu" value="standart" checked> standart</label>
                      <label><input type="checkbox" name="st_or_diskontinu" value="diskontinyu" checked> Diskontinyu</label>
                    </div>
                </div>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
<?php echo form_close();?>
<div class="col-md-12">
<div class="table-responsive">  
<div id="pesan"></div>
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
            <tr style="background-color:#1c2d3f;color:white;">
              <th style="text-align:center;">No <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Nama Project <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Artikel <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Harga Odv <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Harga Retail <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">FD <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
              <th style="text-align:center;">Jual PSG <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Stok <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Sisa Stok <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Jual RP <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Stok RP<span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Stok Level <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
          </tr>
          </thead>
          <tbody>
            <tr><td colspan=12>DATA KOSONG!!</td></tr>
          </tbody>
  </table>
</div>
</div>
  </div>
</div>