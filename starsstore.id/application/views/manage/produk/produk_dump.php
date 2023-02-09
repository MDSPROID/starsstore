<style type="text/css">
  .input-group-addon, .input-group-btn, .input-group .form-control {
    display: flex;
}
</style>
<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/dropzone.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/basic.min.css');?>">
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/drupload_for_imagerim.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/dUp/dropzone.min.js')?>"></script>
<div class="page-title"> 
  <h3>Produk Nonaktif By Sistem
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
      <li class="active" href="<?php echo base_url('trueaccon2194/produk/produk')?>">Produk</li>
      <li>Produk Nonaktif By Sistem</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-12 menuss">
      <div class="fil_best_seller">
        <div class="row">
          <div class="col-md-6 col-xs-12 form-group">
            <fieldset class="field-fix">
              <legend class="leg-fix">Filter</legend>
              <div class="row">
                <div class="col-md-12 col-xs-12 input group ">
                  <label>Tanggal awal : <i style="color:red;">*</i></label>
                  <div id="datetimepicker1" class="input-append">
                    <input type="text" data-format="yyyy-MM-dd" name="tgl1" class="form-control cek_tgl awal" placeholder="Tanggal awal" required>
                    <span class="add-on">
                      <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>   
                  </div>
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group ">
                  <label>Tanggal akhir : <i style="color:red;">*</i></label>
                  <div id="datetimepicker2" class="input-append">
                    <input type="text" data-format="yyyy-MM-dd" name="tgl2" class="form-control cek_tgl akhir" placeholder="Tanggal akhir" required>
                    <span class="add-on">
                      <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>   
                  </div>
                  <br>
                </div>
                <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
                  <a style="margin-bottom: 5px;" class="btn btn-success btn-filter">Filter</a>
                </div>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 drpimg" style="margin: 20px 0 30px 0;display: none;">
      <div class="dropzone">
        <div class="dz-message">
          <h3 class="txtgb"> Klik atau Drop foto artikel terbaru <br>file maksimal 4 MB<br><span style="font-size: 12px;">file yang diijinkan : gif, jpg, jpeg, png<br>*Jika ingin menghapus foto Rim harap ke menu galeri.</span></h3>
          </div>
        </div>
    </div>
    <div id="table_produkx" class="col-md-12 table-responsive">  
    <div id="pesan"></div>
      <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
        <thead>
            <tr style="background-color:#34425a;color:white;">
                <th style="text-align:center;">Gambar</th>
                <th style="text-align:center;">Nama Project</th>
                <th style="text-align:center;">Artikel</th>
                <th style="text-align:center;">Stok Terakhir</th>
                <th style="text-align:center;">Tanggal OFF by system</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
          <tr style="background-color:#34425a;color:white;">
                <th style="text-align:center;">Gambar</th>
                <th style="text-align:center;">Nama Project</th>
                <th style="text-align:center;">Artikel</th>
                <th style="text-align:center;">Stok Terakhir</th>
                <th style="text-align:center;">Tanggal OFF by system</th>
            </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function(){
      //tampil_data_barang();   //pemanggilan fungsi tampil barang.
      //$("#table_produk").DataTable();
       //datatables
      table = $('#table_produk').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('trueaccon2194/produk/load_produk_dump')?>",
            "type": "POST",
            "data": function ( data ) {
                data.tgl1 = $('.awal').val();
                data.tgl2 = $('.akhir').val();
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //last column
            "orderable": false, //set not orderable
        },
        ],
    
      });

      $('.btn-filter').click(function(){ //button filter event click
          table.ajax.reload();  //just reload table
      });

      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd'
      });
  });
</script>