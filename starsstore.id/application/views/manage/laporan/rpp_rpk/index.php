
<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">var baseURL = '<?php echo base_url();?>';</script>
<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd'
      });      
      $('#datetimepicker3').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker4').datetimepicker({ 
        format: 'yyyy-MM-dd'
      });      
      $('#datetimepicker5').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker6').datetimepicker({
        format: 'yyyy-MM-dd'
      });   

      $(".btn-input-biaya").click(function(){
      var thb = $(".total_harga_barang").val();
      var kms = $(".total_komisi").val();
      var bp = $(".biaya_pajak").val();
      var pr = $(".periode").val();
      //simpan menjadi penjualan NETT
      $.ajax({
          url : baseURL + "trueaccon2194/rpp_rpk/input_biaya/?thb="+thb+"&bp="+bp+"&pr="+pr+"&kms="+kms,
          type: "GET",
          success: function(data)
          {
             var total = parseInt(thb) - parseInt(bp);
             $(".penjualan_net").text(total);
             alert("Biaya Marketplace berhasil ditambahkan");
             window.location.href = baseURL + "trueaccon2194/rpp_rpk";
             
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error');
          }
      });
    });

  });
</script>
<style type="text/css">
    @media print {
      .print{
        display: none; 
      }
      .navbar {
        display: none;
      }
      .label {
        border: 1px solid red;
      }
      .disc{
        color: red !important;
        font-weight: bold;
      }
      .table {
        border-collapse: collapse !important;
      }
      .table td,
      .table th {
        background-color: grey !important;
      }
      .table-bordered th,
      .table-bordered td {
        border: 1px solid black !important;
      }
      .row{
        padding-right: -15px;
        padding-left: -15px;
      }
      .lbl{
        background-color: #f5f5f5;
      }
    }

    td, th {
        padding: 5px;
    }
    .njr{
        padding: 8px;
    }
    .nav-tabs > li > a{
        background-color: transparent;
    }
    .tab-content {
    padding: 0px;
    }
</style>
<div class="page-title">
  <h3>RPP / RPK
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
      <li class="active" href="<?php echo base_url('trueaccon2194/produk/produk')?>">Laporan</li>
      <li class="active" href="#">RPP / RPK</li>
    </ol>
  </div>
</div> 
<div id="main-wrapper">
<div class="row">
<div class="col-md-12"> 
  <a href="javascript:void(0)" onclick="createRpprpk();" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Buat RPP / RPK</a>
  <a href="<?php echo base_url('trueaccon2194/rpp_rpk/pesanan_pending'); ?>" style="margin-right:10px;" class="btn btn-default"><b>PENDINGAN : <?php echo $pendingan?> Pesanan (<?php echo $pendingan_psg?> Psg)</b></a>
  <a href="javascript:void(0);" onclick="sales_comparison();" class="btn btn-default" style="margin-right:10px;"><b>Sales Comparison</a>
  <a href="javascript:void(0);"  onclick="printDiv('sales_comparison')" class="btn btn-default print" style="margin-right:10px;"><b>Cetak Sales Comparison</a> 
  <a href="javascript:void(0);"  onclick="entireidentitybank();" class="btn btn-default print" style="margin-right:10px;"><b>Mutasi</a>
</div>
<div class="col-md-12 table-responsive">  
<div class="col-md-12 col-xs-12" id="sales_comparison" style="background-color: white;box-shadow:0px 0px 8px 0px #bababa;margin-bottom: 30px;"></div>
  <div class="row">
    <div class="col-md-8 col-xs-12">  
      <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
        <thead>
            <tr style="background-color:#34425a;color:white;">
                <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                <th style="text-align:center;">Toko</th>
                <th style="text-align:center;">Bulan RPP / RPK</th>
                <th style="text-align:center;">Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $totalpnjontime = 0;
            $totalpnjpendingblnlalu = 0;
            $totalpnjpendingblnini = 0;
            foreach($get_list as $data):
              if(empty($data->pnjontime) || $data->pnjontime == 0){
                $pnjontimex = 0;
              }else{
                $pnjontimex = $data->pnjontime;
              }

              if(empty($data->pnjpendingblnlalu) || $data->pnjpendingblnlalu == 0){
                $pnjpendingblnlalux = 0;
              }else{
                $pnjpendingblnlalux = $data->pnjpendingblnlalu;
              }

              if(empty($data->pnjpendingblnini) || $data->pnjpendingblnini == 0){
                $pnjpendingblninix = 0;
              }else{
                $pnjpendingblninix = $data->pnjpendingblnini;
              }

              $totalpnjontime += $pnjontimex;
              $totalpnjpendingblnlalu += $pnjpendingblnlalux;
              $totalpnjpendingblnini += $pnjpendingblninix;

              $idrpp1 = $this->encrypt->encode($data->id_rpp);
              $idrpp = base64_encode($idrpp1);
            ?>
           <tr>
              <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_rpp;?>" /></td>
              <td style="text-align:center;"><b><?php echo $data->jenis_market?></b></td>
              <td style="text-align:center;"><b><?php echo $data->bulan;?></b><br><a href="<?php echo base_url('trueaccon2194/rpp_rpk/pesanan_ontime/'.$idrpp.'');?>" class="btn btn-success"><?php echo $pnjontimex;?></a><a href="<?php echo base_url('trueaccon2194/rpp_rpk/pesanan_pndblnlalu/'.$idrpp.'');?>" class="btn btn-warning"><?php echo $pnjpendingblnlalux;?></a><a href="<?php echo base_url('trueaccon2194/rpp_rpk/pesanan_pndblnini/'.$idrpp.'');?>" class="btn btn-danger"><?php echo $pnjpendingblninix;?></a>
              </td>
              <td style="text-align:center;">
                <a target="_new" href="<?php echo base_url()?>trueaccon2194/rpp_rpk/cetak_rpp_rpk/<?php $id = $this->encrypt->encode($data->id_rpp); $idp = base64_encode($id); echo $idp ?>" class="btn btn-default cetak"><i class="glyphicon glyphicon-print"></i></a>
                <a href="javascript:void(0)" class="btn btn-danger hapus" data-id="<?php $id = $this->encrypt->encode($data->id_rpp); $idp = base64_encode($id); echo $idp ?>" data-name="<?php echo $data->bulan;?>" onclick="hapus_rpp_rpk(this);"><i class="glyphicon glyphicon-trash"></i></a>
              </td>
          </tr>
         <?php endforeach;?>
        </tbody>
        <tfoot>
            <tr style="background-color:#34425a;color:white;">
                <th style="text-align:center;" colspan="2">Total</th>
                <th style="text-align:center;"><label class="btn btn-success"><?php echo $totalpnjontime; ?></label><label class="btn btn-warning"><?php echo $totalpnjpendingblnlalu; ?></label><label class="btn btn-danger"><?php echo $totalpnjpendingblnini; ?></label></th>
                <th style="text-align:center;"></th>
            </tr>
        </tfoot>
      </table>
    </div>
    <?php 
      $tgl = explode('|', $set['konten']);
      $tgl1 = $tgl[0];
      $tgl2 = $tgl[1];
    ?>
    <?php echo form_open('trueaccon2194/rpp_rpk/closing');?>
    <div class="col-md-4 col-xs-12">
      <div class="col-md-12 col-xs-12" style="background-color: white;box-shadow: 4px 4px 9px 1px #989898;">
        <h2 style="border-bottom: 1px solid grey;padding-bottom: 10px;">Closing Bulanan </h2>
        <div class="row">
          <div class="col-md-6 input group ">
          <label>Tanggal awal : <i style="color:red;">*</i></label>
          <div id="datetimepicker5" class="input-append">
              <input type="text" data-format="yyyy-MM-dd" name="tgl1x" class="form-control cek_tgl" value="<?php echo $tgl1;?>" placeholder="Tanggal awal" required>
              <span class="add-on">
                <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>   
            </div>
            <br>
          </div>
          <div class="col-md-6 input group ">
          <label>Tanggal akhir : <i style="color:red;">*</i></label> 
          <div id="datetimepicker6" class="input-append">
              <input type="text" data-format="yyyy-MM-dd" name="tgl2x" class="form-control cek_tgl" value="<?php echo $tgl2;?>" placeholder="Tanggal akhir" required>
              <span class="add-on">
                <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>   
            </div>
            <br>
          </div>
          <div class="col-md-12 input group ">
          <label>Marketplace : <i style="color:red;">*</i></label>
              <select name="marketplace" class="form-control">
                <option value="">-- pilih --</option>
                <option value="semua">Semua</option>
                <?php foreach($market as $m){?>
                  <option value="<?php echo $m->val_market?>"><?php echo $m->market?></option>
                <?php }?>
              </select>
            <br>
            <i style="font-size:10px;color:red">*Status Pembayaran dan pesanan dibuat otomatis (diterima & telah dibayar)</i>
            <br><br>
          </div>
          <div class="col-md-12 col-xs-12">
            <button type="submit" name="laporan" value="simpantanggal" style="margin-right:10px;margin-bottom:10px;" class="btn-block btn btn-success pull-left btn-best">Simpan & Kunci Tanggal Closing</button><br>
            <label class="hidden">Biaya Marketplace di Periode Closing : <i style="color:red;">*</i></label>
            <input type="hidden" name="total_harga_barang" placeholder="0"  class="total_harga_barang" value="<?php echo $total_harga_barang?>"><input type="hidden" name="total_komisi" placeholder="0"  class="total_komisi" value="<?php echo round($total_komisi);?>">
            <input type="hidden" readonly="readonly" name="periode" class="periode" value="<?php echo date('d F Y', strtotime($tgl1));?> - <?php echo date('d F Y', strtotime($tgl2));?>"><br>
            <?php 
            $periodex = date('d F Y', strtotime($tgl1)).' - '.date('d F Y', strtotime($tgl2));
            //if($periodex == $periode['periode']){
              //echo  number_format($periode['biaya_marketplace'],0,".",".");
            //}else{?>
              <input class="form-control biaya_pajak hidden" type="number" name="biaya_pajak" value="<?php echo $periode['biaya_marketplace'];?>" placeholder="Pajak Marketplace"><a href="javascript:void(0);" style="margin-top:10px;padding: 5px;font-weight: 100;text-align: center;display: none;" class="btn-success btn-block btn-input-biaya">Update Biaya Marketplace</a></b>
            <?php //}?>
            <a href="<?php echo base_url('trueaccon2194/rpp_rpk/laporan_biaya');?>" style="margin-right:10px;margin-bottom:5px;" class="btn-block btn btn-danger pull-left btn-best"><b>Input Biaya-biaya Marketplace</b></a> 
            <button type="submit" name="laporan" value="cetaklaporanclosing" style="margin-right:10px;margin-bottom:5px;" class="btn-block btn btn-success pull-left btn-best"><b>Cetak Laporan Closing</b></button> 
            <button type="submit" name="laporan" value="syncdatasales_ist_todbpos" style="margin-right:10px;margin-bottom:10px;" class="btn-block btn btn-success pull-left btn-best"><b>Sinkron Data Sales Dari Starsstore ke Database POS (local)</b></button> 
            <br><br>
            <ul class="list-unstyled">
              <li>1. Cek status pembayaran pesanan di Marketplace dan Starsstore</li>
              <li>2. Kunci Tanggal Closing</li>
              <li>3. Cek Semua Biaya-biaya</li>
              <li>4. Input Semua Real Ongkir</li>
              <li>5. Kirim Data Sales ke Database POS 10001 (online)</li>
              <li>6. Buat RPP / RPK</li>
              <li>6. Cetak Laporan Closing</li>
              <li>7. Sinkron Data Sales Dari Starsstore ke Database POS (untuk starsstore lokal)</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php echo form_close();?>
  </div>
</div>
<div class="col-md-12">
<i style="color:red">Cetak RPP/RPK menggunakan kertas F4 dan cetak dengan format ukuran Legal dan Scale 100%</i><br>
<i><label class="label label-success">*Kolom hijau</label> Pesanan yang telah selesai diproses dan dibayar dibulan yang sama saat pemesanan.<br><label class="label label-warning">*Kolom kuning</label> Pesanan pada bulan lalu terselesaikan pembayarannya dibulan ini (maksimal cek 6 bulan kebelakang) / pendingan bulan lalu</i><br><i><label class="label label-danger">*Kolom merah</label> esanan dari bulan ini tapi masih pending untuk bulan depannya, karena status pembayaran belum dibayar oleh marketplace.</i>
</div> 
  </div>
</div>

<!-- Bootstrap modal edit-->
<div class="modal fade" id="modal_rpp" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Book Form</h3>
      </div>
      <div class="modal-body form">
        <?php 
        echo form_open('trueaccon2194/rpp_rpk/buat_rpp_rpk');
        ?>
          <div class="row">
            <div class="col-md-6 input group ">
            <label>Tanggal awal : <i style="color:red;">*</i></label>
            <div id="datetimepicker1" class="input-append">
                <input type="text" value="<?php echo $tgl1;?>" data-format="yyyy-MM-dd" name="tgl1" class="form-control cek_tgl" placeholder="Tanggal awal" required>
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
            <div class="col-md-6 input group ">
            <label>Tanggal akhir : <i style="color:red;">*</i></label> 
            <div id="datetimepicker2" class="input-append">
                <input type="text" value="<?php echo $tgl2;?>" data-format="yyyy-MM-dd" name="tgl2" class="form-control cek_tgl" placeholder="Tanggal akhir" required>
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
            <div class="col-md-12 input group ">
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
            <div class="col-md-6 input group ">
              <label>Status Bayar : <i style="color:red;">*</i></label>
               <select name="status_bayar" class="form-control" required>
                  <option value="">-- pilih --</option>
                  <option value="semua">Semua</option>
                  <option value="bayar">Dibayar</option>
                  <option value="belum">Belum Dibayar</option>
                </select>
              <br>
            </div>
            <div class="col-md-6 input group ">
              <label>Status Pesanan : <i style="color:red;">*</i></label>
               <select class="form-control cek_stat" name="status_pesanan" id="status" required>
                <option value="">-- pilih --</option>
                <option value="semua">Semua</option>
                <option value="2hd8jPl613!2_^5">Menunggu Pembayaran</option>
                <option value="*^56t38H53gbb^%$0-_-">Pembayaran Diterima</option>
                <option value="Uywy%u3bShi)payDhal">Dalam Pengiriman</option>
                <option value="ScUuses8625(62427^#&9531(73">Diterima</option>
                <option value="batal">Dibatalkan</option>
              </select>
              <br>
            </div>
            <div class="col-md-6 input group">
              <label>Sort By : <i style="color:red;">*</i></label><br>
                <label><input type="radio" name="sortby" class="form-control" value="tgl_order" required> Tanggal Order</label><br>
                <label><input type="radio" name="sortby" class="form-control" value="tgl_selesai" required checked> Tanggal Selesai Order (untuk closing)</label>
              <br>
              <br>
            </div>
            <div class="col-md-12 col-xs-12 input group">
              <label>Action : <i style="color:red;">*</i></label><br>
              <select name="laporan" class="form-control" required>
                <option value="">-- pilih --</option>
                <option value="syncdbwithpos">Kirim Data Sales ke Database POS 10001 (online) </option>
                <option value="generate_rpp_rpk">Buat RPP / RPK </option>
                <option value="detail_barang_terjual">Export Laporan Penjualan & Onway (PDF) </option>
                <option value="export_excel_laporan">Export laporan Penjualan & Onway (Excel) </option>
                <option value="cetak_cover_biaya"> Cetak Cover Biaya - Biaya </option>
                <option value="cetak_laporan_kalender_penjualan">Laporan Perhari (Kalender Penjualan)</option>
                <option value="cetak_penjualan_permarketplace">Laporan Penjualan Per Marketplace (excel)</option>
                <option value="cetak_laporan_penjualan_bydivisi">Laporan Produk Terjual By Divisi (excel)</option>
                <option value="cetak_ist_toko_daripenjualan">Laporan IST Toko dari Penjualan (excel) </option>
                <option value="cetak_komisi_toko_daripenjualan">Laporan Komisi Toko dari Penjualan (excel) </option>
              </select>
            <br>
            </div>
            <div class="col-md-12 col-xs-12 input group">
              <button type="submit" name="submit" class="btn btn-block btn-success">Buat Laporan</button>
            </div>
            <div class="col-md-12" style="display: none;">
              <div class="input-group">
                <button type="submit" name="laporan" value="syncdbwithpos" style="margin-right:10px;margin-bottom:10px;" class="btn btn-primary pull-left btn-best"><i class="glyphicon glyphicon-transfer"></i> Kirim Data Sales ke Database POS 10001</button> 
                <button type="submit" name="laporan" value="" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Buat RPP / RPK</button> 
                <button type="submit" name="laporan" value="detail_barang_terjual" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Barang Yang Terjual</button>
                <button type="submit" name="laporan" value="export_excel_laporan" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Export laporan Penjualan (Excel)</button>
                <button type="submit" name="laporan" value="cetak_cover_biaya" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Cetak Cover Biaya - Biaya</button>
                <button type="submit" name="laporan" value="cetak_laporan_kalender_penjualan" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Laporan Perhari (Kalender Penjualan)</button>
                <button type="submit" name="laporan" value="cetak_penjualan_permarketplace" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Laporan Penjualan Per Marketplace (telegram)</button>
                <button type="submit" name="laporan" value="cetak_laporan_penjualan_bydivisi" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Laporan Produk Terjual By Divisi (Telegram)</button>
                <button type="submit" name="laporan" value="cetak_ist_toko_daripenjualan" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Laporan IST Toko dari Penjualan</button>
              </div>
            </div>
            <div style="margin-top: 20px;" class="col-md-12">
              <div class="input-group">
                <ul class="list-unstyled">
                  <li>1. Jika Klik <b>RPP / RPK</b> pilih tanggal dan marketplace saja, sort sudah otomatis tanggal order dibuat</li>
                  <li>2. Jika Klik <b>Barang yang terjual</b> pilih tanggal, marketplace, status bayar, status pesanan, dan Sort By</li>
                  <li>3. Sebelum buat RPP/ RPK harap input biaya-biaya di tombol barang yang terjual</li>
                </ul>
              </div>
            </div>
          </div>
        <?php echo form_close();?>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
  <!-- End Bootstrap modal -->

<!-- Bootstrap modal edit-->
<div class="modal fade" id="sales_comp" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title srv">Book Form</h3>
      </div>
      <div class="modal-body form">
        <?php echo form_open('#',array('id'=>'salesform'));?>
        <div class="row">
          <div class="col-md-6 input group">
            <label>Comparison Type : <i style="color:red;">*</i></label><br>
              <label><input type="radio" name="comptype" id="comptype" onclick="comptypex(this);" class="form-control" value="bulanan" required checked> Bulanan</label><br>
              <label><input type="radio" name="comptype" id="comptype" onclick="comptypex(this);" class="form-control" value="tahunan" required> Tahunan</label>
            <br>
            <br> 
          </div>
          <div id="bulanx">
            <div class="col-md-6 col-xs-6 input group ">
            <label>Bulan 1 : <i style="color:red;">*</i></label>
                <select name="bulan1" id="bulan1" class="form-control">
                  <option value="">-- pilih --</option>
                  <?php foreach($bulan as $xc){?>
                    <option value="<?php echo $xc->id_rpp_closing?>"><?php echo $xc->bulan?></option>
                  <?php }?>
                </select>
              <br>
            </div>
            <div class="col-md-6 col-xs-6 input group ">
              <label>Bulan 2 : <i style="color:red;">*</i></label>
               <select name="bulan2" id="bulan2" class="form-control">
                  <option value="">-- pilih --</option>
                  <?php foreach($bulan as $xc){?>
                    <option value="<?php echo $xc->id_rpp_closing?>"><?php echo $xc->bulan?></option>
                  <?php }?>
                </select>
              <br>
            </div>
          </div>
          <div id="tahunx" class="hidden">
            <div class="col-md-6 col-xs-6 input group ">
            <label>Tahun 1 : <i style="color:red;">*</i></label>
                <select name="tahun1" id="tahun1" class="form-control">
                  <option value="">-- pilih --</option>
                  <option value="2018">2018</option>
                  <option value="2019">2019</option>
                  <option value="2020">2020</option>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                </select>
              <br>
            </div>
            <div class="col-md-6 col-xs-6 input group ">
              <label>Tahun 2 : <i style="color:red;">*</i></label>
               <select name="tahun2" id="tahun2" class="form-control">
                  <option value="">-- pilih --</option>
                  <option value="2018">2018</option>
                  <option value="2019">2019</option>
                  <option value="2020">2020</option>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                </select>
              <br>
            </div>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="input-group">
              <input type="button" onclick="filter_comparison();" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best1" value="Bandingkan Hasil ">
            </div>
          </div>
        </div>
      <?php echo form_close();?>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div>
<!-- End Bootstrap modal -->

<!-- Bootstrap modal edit-->
<div class="modal fade" id="mutasi" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title srv">Book Form</h3>
      </div>
      <div class="modal-body form">
      <?php 
        if($this->session->userdata('dOption') == ""){
        echo form_open('trueaccon2194/rpp_rpk/asjhf72mutation'); 
      ?>
          <div class="row">
            <div class="col-md-6 input group ">
            <label>ID1 : <i style="color:red;">*</i></label>
              <input type="text" id="id1" name="id1" class="form-control cek_tgl" required>
              <br>
            </div>
            <div class="col-md-6 input group ">
            <label>ID2 : <i style="color:red;">*</i></label> 
              <input type="text" id="id2" name="id2" class="form-control cek_tgl" required>
              <br>
            </div>
            <div class="col-md-12">
              <div class="input-group">
                <button type="submit" name="laporan" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"> verifikasi</button> 
              </div>
            </div>
          </div>
        <?php 
          echo form_close(); }else{
          echo form_open('trueaccon2194/rpp_rpk/cekmutation'); 
        ?>
          <div class="row">
            <div class="col-md-6 input group ">
            <label>Tanggal awal : <i style="color:red;">*</i></label>
            <div id="datetimepicker3" class="input-append">
                <input type="text" data-format="yyyy-MM-dd" name="tgl1" class="form-control cek_tgl" placeholder="Tanggal awal" required>
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
            <div class="col-md-6 input group ">
            <label>Tanggal akhir : <i style="color:red;">*</i></label> 
            <div id="datetimepicker4" class="input-append">
                <input type="text" data-format="yyyy-MM-dd" name="tgl2" class="form-control cek_tgl" placeholder="Tanggal akhir" required>
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
            <div class="col-md-12">
              <div class="input-group">
                <button type="submit" name="laporan" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"> Cek Mutasi</button> 
              </div>
            </div>
            <div class="col-md-12">
              <i style="color:red">Dilarang login I-Banking dalam tab browser lain</i>
            </div>
          </div>
        <?php }?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div>
<!-- End Bootstrap modal -->