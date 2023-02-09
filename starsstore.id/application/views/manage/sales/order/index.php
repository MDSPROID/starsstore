<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () { 

    //$("#table_order").Dataable();
      table = $('#table_order').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('trueaccon2194/order/load_all_serverside')?>",
            "type": "POST",
            "data": function ( data ) {
                data.tgl1 = $('.awal').val();
                data.tgl2 = $('.akhir').val();
                data.status = $('#status').val();
                data.dibayar = $('#dibayar').val();
                data.sender = $('#sender').val();
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

      table1 = $('#table_konfirmasi').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [],
        // Load data for the table's content from an Ajax source 
        "ajax": {
            "url": "<?php echo base_url('trueaccon2194/order/load_all_bukti_pembayaran')?>",
            "type": "POST",
            "data": function ( data ) {
              
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

    $("#table_konfirmasi").DataTable();
    $('#datetimepicker1').datetimepicker({
      format: 'yyyy-MM-dd'
    });  
    $('#datetimepicker2').datetimepicker({
      format: 'yyyy-MM-dd'
    });  
  });
</script>

<div class="page-title"> 
  <h3>Order & Konfirmasi
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
      <li class="active">Order</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a class="btn btn-primary pull-left" style="margin-right: 15px;" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
  <?php echo br(3)?>
  <div class="row">
    <div class="col-md-6 col-xs-12">
      <fieldset class="field-fix">
        <legend class="leg-fix">Filter</legend>
        <?php 
          echo form_open('trueaccon2194/produk/filter_produk_excel');
        ?>
        <div class="row">
          <div class="col-md-6 col-xs-12 input group ">
            <label>Tanggal awal : <i style="color:red;">*</i></label>
            <div id="datetimepicker1" class="input-append">
              <input type="text" data-format="yyyy-MM-dd" name="tgl1" class="form-control cek_tgl awal" placeholder="Tanggal awal" required>
              <span class="add-on">
                <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>   
            </div>
            <br>
          </div>
          <div class="col-md-6 col-xs-12 input group ">
            <label>Tanggal akhir : <i style="color:red;">*</i></label>
            <div id="datetimepicker2" class="input-append">
              <input type="text" data-format="yyyy-MM-dd" name="tgl2" class="form-control cek_tgl akhir" placeholder="Tanggal akhir" required>
              <span class="add-on">
                <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>   
            </div>
            <br>
          </div>
          <div class="col-md-4 col-xs-12">
            <label>Status Pesanan*</label>
            <select class="form-control" name="status" id="status">
              <option value="all">Semua</option>
              <option value="2hd8jPl613!2_^5">Menunggu Pembayaran</option>
              <option value="*^56t38H53gbb^%$0-_-">Pembayaran Diterima</option>
              <option value="Uywy%u3bShi)payDhal">Dalam Pengiriman</option>
              <option value="ScUuses8625(62427^#&9531(73">Diterima</option>
              <option value="batal">Batal</option>
            </select>
          </div>
          <div class="col-md-4 col-xs-12">
            <label>Status Dibayar*</label>
            <select class="form-control" name="dibayar" id="dibayar">
              <option value="">Semua</option>
              <option value="belum">Belum</option>
              <option value="bayar">Sudah</option>
            </select>
          </div>
          <div class="col-md-4 col-xs-12">
            <label>Toko Pengirim*</label>
            <select id="sender" name="sender" class="form-control">
              <option value="">Semua</option>
              <?php foreach($store_list as $xx){?>
                <option value="<?php echo $xx->kode_edp?>"><?php echo $xx->nama_toko?> [<?php echo $xx->kode_edp?>]</option>
              <?php }?>
            </select>
          </div>
          <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
            <a class="btn btn-success btn-filter">Filter</a>
          </div>
        </div>
        <?php echo form_close();?>
      </fieldset>
      <?php echo br(2);?>
    </div>
  </div>
</div>
<div class="col-md-12">
<div class="table-responsive">  
  <table id="table_order" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
            <tr style="background-color:#1c2d3f;color:white;">
              <th style="text-align:center;"><input type="checkbox" class="form-control" name="checklist[]" /></th>
              <th style="text-align:center;">Invoice <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Pembelian Melalui <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Tanggal Order <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
              <th style="text-align:center;">Expired Order<span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Finish Order<span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Customer <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Total Belanja <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Status <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Opsi <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
          </tr>
          </thead>
          <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="col-md-12" style="margin-top: 30px;">
        <h2>Bukti Pembayaran Pesanan</h2>
        <?php 
          $id = array('id' => 'fill-form');
          echo form_open('trueaccon2194/order/laporan_konfirmasi_pembayaran', $id);
        ?>
            <div class="fil_best_seller">
              <div class="row">
                <div class="col-md-4 col-xs-12 form-group">
                  <fieldset class="field-fix">
                  <legend class="leg-fix">Tanggal</legend>
                    <div class="row">
                      <div class="col-md-6 col-xs-12 input group ">
                      <label>Tanggal awal : <i style="color:red;">*</i></label>
                      <div id="datetimepicker1" class="input-append">
                          <input type="text" data-format="yyyy-MM-dd" name="tgl1" class="form-control cek_tgl" placeholder="Tanggal awal" required>
                          <span class="add-on">
                            <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                          </span>   
                        </div>
                        <br>
                      </div>
                      <div class="col-md-6 col-xs-12 input group ">
                      <label>Tanggal akhir : <i style="color:red;">*</i></label>
                      <div id="datetimepicker2" class="input-append">
                          <input type="text" data-format="yyyy-MM-dd" name="tgl2" class="form-control cek_tgl" placeholder="Tanggal akhir" required>
                          <span class="add-on">
                            <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                          </span>   
                        </div>
                        <br> 
                      </div> 
                      <div class="col-md-12 col-xs-12 input group ">
                      <label>Marketplace : <i style="color:red;">*</i></label>
                        <select name="marketplace" class="form-control" required>
                          <option value="">-- pilih --</option>
                          <option value="semua">Semua</option>
                          <?php foreach($market as $m){?>
                            <option value="<?php echo $m->val_market?>"><?php echo $m->market?></option>
                          <?php }?>
                        </select>
                        <br>
                      </div>
                      <div class="col-md-12 col-xs-12 input group">
                        <label>Sort By : <i style="color:red;">*</i></label><br>
                        <label><input type="radio" name="sortby" class="form-control" value="tgl_order" required> Tanggal Order</label><br>
                        <label><input type="radio" name="sortby" class="form-control" value="tgl_selesai" required checked> Tanggal Selesai Order (untuk closing)</label>
                        <br>
                      </div>
                      <div class="col-md-12 col-xs-12">
                        <button type="submit" name="laporan" value="filter" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button> 
                      </div>
                    </div>
                  </fieldset>
                </div>
                <div class="col-md-4 col-xs-12 form-group">
                  <fieldset class="field-fix">
                  <legend class="leg-fix">Status</legend>
                    <div class="row">
                      <div class="col-md-12 col-xs-12">
                         <div class="controls" style="margin-top: -5px;">
                            <label><input type="radio" name="status" value="2hd8jPl613!2_^5"> Menunggu Pembayaran</label>
                            <label><input type="radio" name="status" value="*^56t38H53gbb^%$0-_-"> Pembayaran Diterima</label>
                            <label><input type="radio" name="status" value="Uywy%u3bShi)payDhal"> Dalam Pengiriman</label>
                            <label><input type="radio" name="status" value="ScUuses8625(62427^#&9531(73"> Diterima</label>
                            <label><input type="radio" name="status" value="batal"> Dibatalkan</label>
                            <label><input type="radio" name="status" value="semua" checked> Semua</label>
                        </div>
                      </div>
                  </div>
                  </fieldset>
                </div>
                <div class="col-md-4 col-xs-12 form-group">
                  <fieldset class="field-fix">
                  <legend class="leg-fix">Dibayar</legend>
                    <div class="row">
                      <div class="col-md-12 col-xs-12">
                        <div class="controls" style="margin-top: -5px;">
                          <label><input type="radio" name="bayar" value="belum"> Belum Dibayar Marketplace</label>
                          <label><input type="radio" name="bayar" value="bayar"> Telah Dibayar</label>
                          <label><input type="radio" name="bayar" value="semua" checked> Semua</label>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
            </div>
        <?php echo form_close();?>
        <h2>Konfirmasi Pesanan</h2>
        <a href="<?php echo base_url('trueaccon2194/order/tambah_konfirmasi');?>" class="btn btn-primary" style="display:none;margin-bottom: 20px;">+ Tambah Konfirmasi Manual (Khusus non E-commerce)</a>
        <div class="table-responsive">  
          <table id="table_konfirmasi" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
              <tr style="background-color:#1c2d3f;color:white;">
                <th style="text-align:center;"><input type="checkbox" class="form-control" name="checklist[]" /></th>
                <th style="text-align:center;">Invoice <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
                <th style="text-align:center;">Tanggal Konfirmasi <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                <th style="text-align:center;">Customer <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
                <th style="text-align:center;">Email / No. Telepon <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
                <th style="text-align:center;">Nominal Transfer <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
                <th style="text-align:center;">Opsi <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>