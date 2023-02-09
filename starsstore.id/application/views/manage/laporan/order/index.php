<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () { 

    $("#table_report").DataTable();
    $('#datetimepicker1').datetimepicker({
      format: 'yyyy-MM-dd'
    });  
    $('#datetimepicker2').datetimepicker({
      format: 'yyyy-MM-dd' 
    });  
       
  });
</script>
<div class="page-title">
  <h3>Rasio Perolehan
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
      <li>Laporan</li>
      <li class="active">Rasio Perolehan</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<?php 
  $id = array('id' => 'fill-form');
  echo form_open('trueaccon2194/report_order/laporan_penjualan', $id);
?>
  <div class="col-md-12">
    <div class="fil_best_seller">
      <div class="row">
        <div class="col-md-4 col-xs-12 form-group">
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
                <button type="submit" name="laporan" value="filter" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-filter"></i> Lihat Laporan</button> <button type="submit" name="laporan" value="filter_detail" style="display:none;margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-filter"></i>  Laporan Detail</button> <button type="submit" name="laporan" value="cetak" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button> <button type="submit" name="laporan" value="excel" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Export Excel</button>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="col-md-4 col-xs-12 form-group">
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
                    <label><input type="radio" name="status" value="all" checked> Semua</label>
                </div>
              </div>
          </div>
          </fieldset>
        </div>
        <div class="col-md-4 col-xs-12 form-group">
          <fieldset class="field-fix">
          <legend class="leg-fix">Dibayar</legend>
            <div class="row">
              <div class="col-md-12">
                <div class="controls" style="margin-top: -5px;">
                  <label><input type="radio" name="bayar" value="belum"> Belum Dibayar Marketplace</label>
                  <label><input type="radio" name="bayar" value="bayar"> Telah Dibayar</label>
                  <label><input type="radio" name="bayar" value="all" checked> Semua</label>
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
    <div class="row">
      <div class="col-md-12">
          <div class="table-responsive">
            <table id="table_report" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
                <thead>
                  <tr style="background-color:#1c2d3f;color:white;">
                    <th style="text-align:center;">Invoice</th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Project</th>
                    <th style="text-align:center;">Artikel</th>
                    <th style="text-align:center;display: none">Status Barang</th>
                    <th style="text-align:center;">Retail</th>
                    <th style="text-align:center;">Sales Pairs</th>
                    <th style="text-align:center;">Retail + Sales Pairs</th>
                    <th style="text-align:center;">45%</th>
                    <th style="text-align:center;">55%</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $totalterjual = 0;           
                  $totalretail  = 0;
                  $totalbisnisx = 0;
                  $totaldivisix = 0; 
                  foreach($data as $y){
                    //$odvmaster    = $y->odvM;
                    //$retailmaster = $y->retailM;

                     // jika ada pengurangan dari biaya marketplace
                    if($y->buy_in == "lazada"){
                      $biaya_lazada = $y->total_terjual * $y->harga_fix * 1.804 / 100;
                      $vat_lazada   = $y->total_terjual * $y->harga_fix * 0.164 / 100;
                      //$vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100; // vat pencairan adanya di laporan closing karena diterbitkan per periode bukan per produk
                    }else{
                      $biaya_lazada = 0;
                      $vat_lazada = 0;
                      $vat_pencairan = 0;
                    }
                    $harga_jual = $y->harga_fix - $biaya_lazada - $vat_lazada; // - $vat_pencairan;

                    $bisnisx = ($harga_jual * 45)/100;
                    $divisix = ($harga_jual * 55)/100;

                    // mencari margin dari data diatas
                    //$margin = round(($retailmaster - $odvmaster) / $retailmaster * 100);

                    // memberi status barang berdasarkan hasil margin
                    // if($margin >= 45){
                      //mencari ODV bisnis barang standart
                    //  $jenis = "Standart";
                    //  $odv_bisnis = 55 * $retailmaster / 100;
                      // hitung perolehan divisi dan bisnis
                    //  $bisnis   = $harga_jual * 45 / 100;
                    //  $divisi   = $harga_jual * 55 / 100;

                    //}else if($margin >= 0 && $margin < 45){
                      //mencari ODV bisnis barang standart
                    //  $jenis = "Diskontinyu";
                    //  $odv_bisnis = ($retailmaster - $odvmaster) * 30 / 100 + $odvmaster;
                      // hitung perolehan divisi dan bisnis
                    //  $bisnis   = ($harga_jual - $odvmaster) * 70 / 100;
                    //  $divisi   = ($harga_jual - $odvmaster) * 30 / 100 + $odvmaster;
                    //}
                    $totalterjual += $y->total_terjual;
                    $totalretail  += ($harga_jual*$y->total_terjual);
                    $totalbisnisx += ($bisnisx*$y->total_terjual);
                    $totaldivisix += ($divisix*$y->total_terjual);
                    //$totalbisnis  +=($bisnis*$y->total_terjual);
                    //$totaldivisi  +=($divisi*$y->total_terjual); 
                    if($y->dibayar == "bayar"){
                      $bayar = "style='background-color: #e6fde6'";
                    }else{
                      $bayar = "";
                    }

                    $idxx = $this->encrypt->encode($y->no_order_cus); 
                    $id = base64_encode($idxx);
                  ?>
                  <tr <?php echo $bayar?>>
                    <td align="center"><a target="_new" href="<?php echo base_url('trueaccon2194/online_store/detail/'.$id.'');?>"><?php echo $y->invoice?><br><span style="font-size: 12px;"><?php echo $y->buy_in?></span></a></td>
                    <td align="center"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="<?php echo $y->gambar?>" width="50"></td>
                    <td align="center"><?php echo $y->nama_produk?></td>
                    <td align="center"><?php echo $y->artikel?></td>
                    <td align="center" style="display: none;"><?php// echo $jenis?></td>
                    <td align="center">Rp. <?php echo number_format($harga_jual,0,".",".")?></td>
                    <td align="center"><?php echo $y->total_terjual?><br></td>
                    <td align="center">Rp. <?php echo number_format($y->total_terjual*$harga_jual,0,".",".")?></td>
                    <td align="center">Rp. <?php echo number_format($bisnisx*$y->total_terjual,0,".",".")?></td>
                    <td align="center">Rp. <?php echo number_format($divisix*$y->total_terjual,0,".",".")?></td>
                  </tr>
                  <?php }?>
                </tbody>
                <tfoot>
                  <tr style="background-color:#34425a;color:white;">
                    <td align='left' colspan="3">Data ini hanya menampilkan status pesanan sukses (diterima & dibayar) </td>
                    <td align='center'><b>Total</b></td>
                    <td align='center'><b><?php echo $totalterjual?></b></td>
                    <td align='center'><b>Rp. <?php echo number_format($totalretail,0,".",".")?>.-</b></td>
                    <td align='center'><b>Rp. <?php echo number_format($totalbisnisx,0,".",".")?>.-</b></td>
                    <td align='center'><b>Rp. <?php echo number_format($totaldivisix,0,".",".")?>.-</b></td>
                  </tr>
                </tfoot>
            </table>
          </div>
        </div>
      </div>
  </div>
</div>
</div>