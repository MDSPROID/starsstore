<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {

      table = $('#table_pengiriman').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('trueaccon2194/laporan_pengiriman/load_all_serverside')?>",
            "type": "POST",
            "data": function ( data ) {
                //data.buy_in = $('#buy_in').val();
                data.tgl1         = $('#tgl1').val();
                data.tgl2         = $('#tgl2').val();
                data.status       = $("input[name='status']:checked").val(); 
                data.dibayar      = $("input[name='bayar']:checked").val();
                data.sortby       = $("input[name='sortby']:checked").val();
                data.marketplace  = $('#marketplace').val();
                data.ditanggung   = $('#dibayar').val();
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
<div class="page-title"> 
  <h3>Laporan Pengiriman
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/laporan_pengiriman')?>">Laporan Pengiriman</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a  href="<?php echo base_url('trueaccon2194/laporan_pengiriman/input_actual_tarif');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Input Actual Tarif</a><br><br><br>
</div>
<?php 
  $id = array('id' => 'fill-form');
  echo form_open('trueaccon2194/laporan_pengiriman/laporan_pengiriman_by_filter', $id);
?>
  <div class="col-md-12">
      <div class="fil_best_seller">
        <div class="row">
          <div class="col-md-4 col-xs-12 form-group">
            <fieldset class="field-fix">
            <legend class="leg-fix">Tanggal</legend>
              <div class="row">
                <div class="col-md-6 col-xs-12 input group ">
                <label>Tanggal awal : <i style="color:red;">*</i></label>
                <div id="datetimepicker1" class="input-append">
                    <input type="text" data-format="yyyy-MM-dd" name="tgl1" id="tgl1" class="form-control cek_tgl" placeholder="Tanggal awal" required>
                    <span class="add-on">
                      <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>   
                  </div>
                  <br>
                </div>
                <div class="col-md-6 col-xs-12 input group ">
                <label>Tanggal akhir : <i style="color:red;">*</i></label>
                <div id="datetimepicker2" class="input-append">
                    <input type="text" data-format="yyyy-MM-dd" name="tgl2" id="tgl2" class="form-control cek_tgl" placeholder="Tanggal akhir" required>
                    <span class="add-on">
                      <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>   
                  </div>
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group ">
                <label>Marketplace : <i style="color:red;">*</i></label>
                    <select name="marketplace" id="marketplace" class="form-control" required>
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
                <div class="col-md-12">
                  <a type="submit" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best btn-filter"><i class="glyphicon glyphicon-filter"></i> Filter Laporan</a> 
                  <button type="submit" name="laporan" value="filter" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button> 
                  <button type="submit" name="laporan" value="excel" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Export Excel</button>
                  <i style="color: red;">*Gunakan settingan kertas legal dengan scale fit to page</i>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-3 col-xs-12 form-group">
            <fieldset class="field-fix">
            <legend class="leg-fix">Status</legend>
              <div class="row">
                <div class="col-md-12">
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
            <br><br>
          </div>
          <div class="col-md-3 col-xs-12 form-group">
          <fieldset class="field-fix">
          <legend class="leg-fix">Pesanan dibayar oleh marketplace</legend>
            <div class="row">
              <div class="col-md-12">
                <div class="controls" style="margin-top: -5px;">
                  <label><input type="radio" name="bayar" value="belum"> Belum</label>
                  <label><input type="radio" name="bayar" value="bayar"> Sudah</label>
                  <label><input type="radio" name="bayar" value="semua" checked> Semua</label>
                </div>
              </div>
            </div>
          </fieldset>
          </div>
          <div class="col-md-2 col-xs-12 form-group">
          <fieldset class="field-fix">
          <legend class="leg-fix">Ongkir Ditanggung</legend>
            <div class="row">
              <div class="col-md-12">
                <select name="dibayar" id="dibayar" class="form-control">
                    <option value="semua">Semua</option>
                    <option value="gratis">Gratis Ongkir</option>
                    <option value="kantor">Kantor</option>
                    <option value="toko">Toko</option>
                    <option value="dari_penjualan">Dipotong langsung dari penjualan</option>
                  </select>        
              </div>
            </div>
          </div>
          </fieldset>
          </div>
        </div>
      </div>
    </div>
<?php echo form_close();?>
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
  <table id="table_pengiriman" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Tanggal Invoice</th>
                    <th style="text-align:center;">Invoice</th>
                    <th style="text-align:center;">Alamat Customer</th>
                    <th style="text-align:center;">Expedisi</th>
                    <th style="text-align:center;">Tarif (Click)</th>
                    <th style="text-align:center;">Tarif (Actual)</th>
                    <th style="text-align:center;">Selisih Tarif (Click & Actual)</th>
                    <th style="text-align:center;">Ongkir Ditanggung</th>
                    <th style="text-align:center;">Status Order</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
              <?php 
                $tc = 0;
                $tr = 0;
                $yy = 0;
                foreach($get_list as $data){
                  if($data->actual_tarif != ""){
                    $yy += $data->actual_tarif - $data->tarif;
                  }

                  $tarif = $data->tarif;
                  $act   = $data->actual_tarif;
                  $tc +=($tarif);
                  $tr +=($act);

                  if($data->bayar == "belum" || $data->bayar == ""){
                    $bayar = "";
                  }else{
                    $bayar = "style='background-color:#e6fde6;'";
                  }

                }
              ?>
              <tr style="background-color:#34425a;color:white;display: none;">
                  <th style="text-align:right;" colspan="5"> Total</th>
                  <th style="text-align:center;">Rp. <?php echo number_format($tc,0,".",".");?></th>
                  <th style="text-align:center;">Rp. <?php echo number_format($tr,0,".",".");?></th>
                  <th style="text-align:center;">Rp. <?php echo number_format($yy,0,".",".");?></th>
                  <th style="text-align:right;" colspan="3"></th>
              </tr>
            </tfoot>
  </table>
</div>
  </div>
</div>
