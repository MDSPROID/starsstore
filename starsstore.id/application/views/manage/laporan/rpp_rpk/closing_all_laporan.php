<title>LAPORAN CLOSING BULANAN</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
</script>
<style type="text/css">
/*************************** END Frontend ************************************/
@media screen{
  /*.cover_count{
    display: none;
  }
  .cover_laporan{
    display: none;
  }*/ 
} 
@media print {
  *{
    -webkit-print-color-adjust:exact; /*Chrome*/
    color-adjust: exact !important;  /*Firefox*/
  }
  .print-btn{
    display: none !important;
  }
  .cover_laporan{
    display: block;
  } 
  .cover_count{
    display: block;
  }
  #cover_laporan{
    margin-top:150px;
  }
}
table {
  border-spacing: 0;
  
}
body {
  font-family: Futura, "Trebuchet MS", Arial, sans-serif;
  font-size: 14px;
  line-height: 1.42857143;
  color: #333;
  background-color: white;
}
th {
  text-align: left;
}

.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 5px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}
label {
  display: inline-block;
  max-width: 100%;
  margin-bottom: 5px;
  font-weight: bold;
}
.label {
  display: inline;
  padding: .2em .6em .3em;
  font-size: 75%;
  font-weight: bold;
  line-height: 1;
  color: #fff;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: .25em;
}
.label-default {
  background-color: #777;
}
.label-primary {
  background-color: #337ab7;
}
.label-success {
  background-color: #5cb85c;
}
.label-warning {
  background-color: #f0ad4e;
}
.label-danger {
  background-color: #d9534f;
}
.page-break{
  page-break-after: always;
}
.highcharts-legend { display: block !important; }
</style>
<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
    <div class="tab-content">
      <div class="row">

        <div id="INOUT" class="col-md-12 page-break">
          <div class="row">
            <div class="col-md-12">
              <h2 style="text-align: center;"><b>PERTELAAN BARANG MASUK - KELUAR</b></h2><br><br>
              <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
                  <tr style="border:none;">
                      <th colspan="6" style="border:none;"></th>
                  </tr>
              </thead>
              <tbody>
                  <tr style="border:none;">
                      <td colspan="3" style="border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">ALAMAT : Toko E-Commerce</td>
                      <td colspan="3" style="text-align: right;border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">PERIODE : <?php echo date('d F Y', strtotime($tgl1));?> - <?php echo date('d F Y', strtotime($tgl2));?></h4></td>
                  </tr>
                  <tr style="border:none;">
                      <td colspan="3" style="border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">EDP CODE : 100-01</td>
                      <td colspan="3" style="text-align: right;border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">MINGGU : .............</h4></td>
                  </tr>
              </tbody>
              </table>
            </div>
            <div class="col-md-12 table-responsive">  
              <h3>BARANG MASUK</h3>
              <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="border-top:1px solid black;">
                <thead>
                    <tr style="border:1px solid #000;">
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">TANGGAL</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">NO. INV</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">PASANG</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">RUPIAH</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">DARI</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tc = 0;
                    $tr = 0;
                    foreach($closing_inout as $data1){
                      if($data1->jenis == "masuk"){
                      //$tarif = $data->tarif;
                      //$act   = $data->actual_tarif;
                      $tc +=($data1->pasang);
                      $tr +=($data1->rupiah);

                      $idinvoice = $data1->invoice;
                      $get_inv = $this->rpp_rpk_adm->get_list_inv($idinvoice);
                      $invxx = array();
                      foreach($get_inv as $k){
                        $invxx[] = $k->inv;
                      }
                      $invx = implode(', ',$invxx);
                    ?>
                   <tr style="border:1px solid #000;">
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo date('d/m/Y',strtotime($data1->tanggal));?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data1->invoice;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data1->pasang;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">Rp. <?php echo number_format($data1->rupiah,0,".",".");?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data1->source;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data1->keterangan;?><br><span style="font-size: 8px;">No. Pesanan : <?php echo $invx?></span></td>                  
                  </tr>
                 <?php } }?>
                </tbody>
                <tfoot>
                  <tr>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;" colspan="2">TOTAL</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $tc;?></th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Rp. <?php echo number_format($tr,0,".",".");?></th>
                      <th style="text-align:center;border:1px solid #000;" colspan="2"></th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="col-md-12 table-responsive">  
                <h3>BARANG KELUAR</h3>
                <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr style="border:1px solid #000;">
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">TANGGAL</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">NO. INV</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">PASANG</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">RUPIAH</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">KE</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tc = 0;
                    $tr = 0;
                    
                    foreach($closing_inout as $data1){
                      if($data1->jenis == "keluar"){
                      //$tarif = $data->tarif;
                      //$act   = $data->actual_tarif;
                      $tc +=($data1->pasang);
                      $tr +=($data1->rupiah);
                    ?>
                   <tr>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo date('d/m/y',strtotime($data1->tanggal));?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data1->invoice;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data1->pasang;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">Rp. <?php echo number_format($data1->rupiah,0,".",".");?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data1->source;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data1->keterangan;?></td>                  
                  </tr>
                 <?php } }?>
                </tbody>
                <tfoot>
                  <tr style="border:1px solid #000;">
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;" colspan="2">TOTAL</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $tc;?></th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Rp. <?php echo number_format($tr,0,".",".");?></th>
                      <th style="text-align:center;border:1px solid #000;" colspan="2"></th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="col-md-12">
              <p style="line-height: 30px;">Surabaya, ..............................................<br>DEPT. E-COMMERCE<br><br><br><br></p>
            </div>
          </div>
        </div>

        <div id="LAPORAN_PENJUALAN" class="col-md-12">
          <?php                  
            $totalsemuapendingan = 0;
            $totalpendingbulanlaludanontime = 0;   
            $pendingbulanlalu = 0;
            $ontime = 0;
            $total_harga_barang = 0; // buat cover penjualan closing
            foreach($terjual as $datax){
              // membedakan jenis laporan (pendingan terselesaikan, penjualan ontime, atau pendingan untuk bulan berikutnya)
              if($datax->tanggal_waktu_order < $tgl1){ // pendingan dari bulan lalu yang terselesaikan bulan berikutnya
                $pendingbulanlalu += $datax->qty;
              }else { // PENJUALAN ONTIME
                $ontime += $datax->qty;
              }

              $total_harga_barang += ($datax->harga_fix*$datax->qty); // cover penjualan closing
            }
            $totalpendingbulanlaludanontime = $pendingbulanlalu + $ontime;
            $totalsemuapendingan = $totalpendinganbulanini + $totalpendinganbulanlalu;
          ?>
          <div style="padding: 118px;" class="page-break cover_count" id="cover_laporan">
            <table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
                  <tr style="border:none;">
                      <th colspan="12" style="border:none;"><h1 style="text-align: center;">LAPORAN PENJUALAN</h1></th>
                  </tr>
              </thead>
              <tbody>
                  <tr style="border:none;">
                      <td colspan="3" style="border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><label class="label label-warning" style="margin-right: 5px;font-size: 55%;"></label> PENJUALAN PENDING BULAN LALU :</h5></td>
                      <td colspan="3" style="text-align: right;border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><?php echo $pendingbulanlalu?> PSG</h5></td>
                  </tr>
                  <tr style="border:none;">
                      <td colspan="3" style="border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><label class="label label-success" style="margin-right: 5px;font-size: 55%;"></label> PENJUALAN ONTIME :</h5></td>
                      <td colspan="3" style="text-align: right;border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><?php echo $ontime?> PSG</h5></td>
                      
                  </tr>
                  <tr style="border:none;">
                    <td colspan="3" style="border-top: 2px solid #0e0e0e;"><h4 style="margin-top: 0;margin-bottom: 0;margin-left: 15px;"><b>TOTAL : Rp.<?php echo number_format($total_harga_barang,0,".",".");?></b></h4></td>
                     <td colspan="3" style="text-align: right;border-top: 2px solid #0e0e0e;"><h5 style="margin-top: 0;margin-bottom: 0;"><b><?php echo $totalpendingbulanlaludanontime;?> PSG</b></h5></td>
                  </tr>
                  <tr style="border:none;">
                    <td colspan="3" style="border:none;"></td>
                     <td colspan="3" style="text-align: right;border:none;"></td>
                  </tr>
                  <tr style="border:none;">
                    <td colspan="3" style="border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><label class="label label-danger" style="margin-right: 5px;font-size: 55%;"></label> PENJUALAN BULAN LALU MAKS CEK 12 BULAN KEBELAKANG</h5></td>
                     <td colspan="3" style="text-align: right;border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><?php echo $totalpendinganbulanlalu?> PSG</h5></td>
                  </tr>
                  <tr style="border:none;">
                    <td colspan="3" style="border-top: 2px solid #0e0e0e;"><h4 style="margin-top: 0;margin-bottom: 0;margin-left: 15px;"><b>TOTAL </b></h4></td>
                     <td colspan="3" style="text-align: right;border-top: 2px solid #0e0e0e;"><h5 style="margin-top: 0;margin-bottom: 0;"><b><?php echo $totalpendinganbulanlalu //$totalsemuapendingan;?> PSG</b></h5></td>
                  </tr>
              </tbody>
            </table>
            <h2 style="border:2px solid black;text-align: center;margin-top: 40px;">Lampiran 1</h2>
          </div>
          <div class="row page-break">
            <div class="col-md-12">
              <h2 style="text-align: center;"><b>LAPORAN PENJUALAN (PENDING BULAN LALU DAN ONTIME)</b></h2>
              <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
                  <tr style="border:none;">
                      <th colspan="6" style="border:none;"></th>
                  </tr>
              </thead>
              <tbody>
                  <tr style="border:none;">
                      <td colspan="3" style="border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">ALAMAT : Toko E-Commerce</td>
                      <td colspan="3" style="text-align: right;border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">PERIODE : <?php echo date('d F Y', strtotime($tgl1));?> - <?php echo date('d F Y', strtotime($tgl2));?></h4></td>
                  </tr>
                  <tr style="border:none;">
                      <td colspan="3" style="border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">EDP CODE : 100-01</td>
                      <td colspan="3" style="text-align: right;border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">MARKETPLACE : <?php echo $market;?></h4></td>
                      
                  </tr>
                  <tr style="border:none;">
                    <td colspan="3" style="border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">STATUS PESANAN : <?php echo $status2;?></td>
                     <td colspan="3" style="text-align: right;border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">STATUS BAYAR: <?php echo $status1?></h4></td>
                  </tr>
              </tbody>
              </table>
            </div>
            
            <div class="col-md-12 table-responsive">  
              <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="border-top:1px solid black;">
                <thead>
                  <tr style="border:1px solid #000;">
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Order</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Selesai Order</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Nomor Invoice</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Toko Pengirim</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Artikel</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Size</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Qty</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Barang</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Diskon</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Final & Diskon</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none">Komisi Toko (5%)</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Diskon + Biaya Marketplace</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px; display: none;">Biaya Marketplace</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px; display: none;">Harga Barang - Biaya Marketplace (Final Price)</th>
                  </tr>
                </thead>
                <tbody>
                    <?php                     
                    $total_komisi = 0;
                    $total_diskon = 0;
                    $total_biaya_marketplace = 0;
                    //$total_disc_dan_biaya = 0;
                    $total_qty = 0;
                    $total_harga_barang = 0;

                    $total_harga_barang_final1 = 0;
                    $total_diskon_barang1 = 0;

                    foreach($terjual as $data){
                      if($data->harga_before == "" || $data->harga_before == 0){ 
                        $total_diskon_barangx = 0;
                      }else{ 
                        $total_diskon_barangx = ($data->harga_before-$data->harga_fix)*$data->qty;
                      }

                      $total_diskon_barang1 += $total_diskon_barangx;

                      if($data->buy_in == "lazada"){
                        $biaya_lazada = $data->harga_fix * 1.804 / 100;
                        $vat_lazada   = $data->harga_fix * 0.164 / 100;
                        //$vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
                      }else{
                        $biaya_lazada = 0;
                        $vat_lazada = 0;
                        //$vat_pencairan = 0; 
                      }

                      $total_biaya_marketplace += ($biaya_lazada + $vat_lazada); // + $vat_pencairan
                      if($data->harga_before != "" || $data->harga_before > 0){
                        $diskon = ($data->harga_before-$data->harga_fix) * $data->qty;
                      }else{ 
                        $diskon = "0";
                      }

                      if($data->komisi_toko == ""){
                        $komisi1 = (($data->harga_fix*3)/100) + (($data->harga_fix*1)/100);
                      }else{
                        $komisi1 = $data->komisi_toko;
                      }

                      $total_diskon += $diskon; //($data->harga_before-$data->harga_fix) * $data->qty;
                      $total_komisi += round($komisi1);
                      //$total_disc_dan_biaya = $total_diskon;// + $total_biaya_marketplace;
                      $total_qty += $data->qty;
                      $total_harga_barang += ($data->harga_fix*$data->qty);//-($biaya_lazada+$vat_lazada+$vat_pencairan);
                      $total_harga_barang_final1 += ($data->harga_fix*$data->qty);
                      // membedakan jenis laporan (pendingan terselesaikan, penjualan ontime, atau pendingan untuk bulan berikutnya)
                      if($data->tanggal_waktu_order < $tgl1){ // pendingan dari bulan lalu yang terselesaikan bulan berikutnya
                        $jenis_laporan = "warning";
                      }else { // PENJUALAN ONTIME
                        $jenis_laporan = "success";
                      }
                    ?>

                   <tr style="border:1px solid #000;<?php echo $jenis_laporan?>">
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                            echo date('d/m/Y', strtotime($data->tanggal_waktu_order));
                        ?>
                        <label style="margin-left: 5px;" class="label label-<?php echo $jenis_laporan?>"> </label> 
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                            if($data->tanggal_waktu_order_finish == "0000-00-00 00:00:00"){
                              echo "Belum Selesai";
                            }else{
                              echo date('d/m/Y', strtotime($data->tanggal_waktu_order_finish));
                            }
                        ?>
                      </td>
                      <td style="text-align:center;width:100px;border:1px solid #000;font-size: 12px;">
                        <?php 
                          if($data->buy_in == "E-commerce"){
                            echo $data->invoice;
                          }else{
                            echo $data->no_order_pro;
                          }
                        ?>
                        <br>[ <?php echo $data->buy_in?> ]</td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data->sender;?><br><?php echo $data->nama_toko?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo strtoupper($data->artikel);?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data->ukuran;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data->qty;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php if($data->harga_before != "" || $data->harga_before > 0){?>
                          Rp. <?php echo number_format($data->harga_before,0,".",".");?>
                        <?php }else{ 
                          echo"Rp. ".number_format($data->harga_fix,0,".",".").""; 
                        }?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none">
                        <?php if($data->harga_before != "" || $data->harga_before > 0){?>
                        <i style="text-decoration:line-through;">Rp. <?php echo number_format($data->harga_before,0,".",".");?></i><br>Rp. <?php echo number_format($data->harga_fix,0,".",".");?><?php }else{ echo"Rp. ".number_format($data->harga_fix,0,".",".").""; }?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Rp. 
                        <?php if($data->harga_before == "" || $data->harga_before == 0){ 
                          echo "0"; 
                        }else{ 
                          echo number_format(($data->harga_before-$data->harga_fix)*$data->qty,0,".",".")." <span style='color:red;'>(".round(($data->harga_before - $data->harga_fix) / $data->harga_before * 100) * $data->qty."%)</span>";
                        }?> 
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                        // mencari komisi toko
                        //if($data->komisi_toko == ""){
                        //  $komisi1 = ($data->harga_fix*4)/100;
                        //}else{
                        //  $komisi1 = $data->komisi_toko;
                        //}?>
                        Rp. <?php echo number_format($data->harga_fix,0,".",".");?><br>
                        <i style="color: red;font-size: 10px;">
                          Rp. <?php if($data->harga_before == "" || $data->harga_before == 0){ echo "0"; }else{ echo number_format(($data->harga_before-$data->harga_fix)*$data->qty,0,".",".")." <span style='color:red;font-weight:bold;'>(".round(($data->harga_before - $data->harga_fix) / $data->harga_before * 100) * $data->qty."%)</span>";
                          }?>
                        </i> 
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">
                      <?php if($data->komisi_toko == ""){
                        echo "Rp.".number_format(($data->harga_fix*5)/100,0,".",".")."";
                      }else{
                        echo "Rp.".number_format($data->komisi_toko,0,".",".")."";
                      }?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none">
                      <?php 
                      //if($data->buy_in == "lazada"){
                      //  $biaya_lazada = $data->harga_fix * 1.804 / 100;
                      //  $vat_lazada   = $data->harga_fix * 0.164 / 100;
                      //  $vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
                      //  $biaya_marketplace = $biaya_lazada+$vat_lazada+$vat_pencairan;
                      //  if($data->harga_before == 0){
                      //    echo "Rp. ".number_format($biaya_marketplace,0,".",".");
                      //  }else{
                      //    echo "Rp. ".number_format($biaya_marketplace + ($data->harga_before-$data->harga_fix),0,".",".");
                      //  }
                      //}else{
                      //  if($data->harga_before == 0){
                      //    echo "Rp. 0";
                      //  }else{
                      //    echo "Rp. ".number_format($data->harga_before-$data->harga_fix,0,".",".");
                      //  }
                      //}?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">
                      <?php if($data->buy_in == "lazada"){
                        $biaya_lazada = ($data->harga_fix * $data->qty) * 1.804 / 100;
                        $vat_lazada   = ($data->harga_fix * $data->qty) * 0.164 / 100;
                        //$vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
                        echo "Biaya Lazada<br>Rp.".number_format($biaya_lazada,2)."<br>";
                        echo "Vat Lazada<br>Rp.".number_format($vat_lazada,2)."<br>";
                        //echo "Vat Pencairan<br>Rp.".number_format($vat_pencairan,2)."<br>";
                      }else{
                        echo "Rp. 0";
                      }?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px; display: none;">
                      <small style="color:#f12121;">
                      <?php 
                      //if($data->harga_before == "" || $data->harga_before == 0){ 
                      //    $hg_barang = 0;
                      //}else{ 
                      //  $hg_barang = ($data->harga_before-$data->harga_fix)*$data->qty;
                      //}
                      $hg_barang = $data->harga_fix*$data->qty;

                      if($data->buy_in == "lazada"){ //+ $vat_pencairan
                        $biaya_market = ($biaya_lazada+$vat_lazada )*$data->qty;
                      }else{
                        $biaya_market = 0;
                      }
                      echo "Rp. ".number_format($hg_barang,0,".",".")." - Rp. ".number_format($biaya_market,0,".",".")." = Rp. ".number_format($hg_barang - $biaya_market,0,".",".")."";?>
                      </small><br>
                      <b>Rp.</b>
                      <?php 
                      if($data->buy_in == "lazada"){
                        echo "<b>".number_format($hg_barang - $biaya_market,0,".",".")."</b>"; // + $vat_pencairan
                      }else{
                        echo "<b>".number_format($hg_barang,0,".",".")."</b>";
                      }
                      ?>
                      </td>
                  </tr>
                 <?php }?>
                </tbody>
                <tfoot style="display: table-row-group">
                  <tr style="border:1px solid #000;">
                    <td style="border:1px solid #000;font-size: 14px;text-align: center;" colspan="6"><b>TOTAL</b><br><i style="font-size: 10px;">TOTAL DISKON = <?php echo number_format($total_diskon_barang1,0,".",".");?></i></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b><?php echo $total_qty;?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_harga_barang+$total_diskon,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;display: none;"><b>Rp. <?php echo number_format($total_diskon,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>
                      Rp. <?php echo number_format($total_harga_barang_final1,0,".",".");?>
                    </b>
                    </td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;display: none;"><b>Rp. <?php echo number_format($total_komisi,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;display: none;"><b>Rp. <?php echo number_format($total_biaya_marketplace,0,".",".");?></b></td>
                    <td rowspan="2" style="vertical-align: middle !important;border:1px solid #000;font-size: 16px;text-align: center;display: none;"><b>Rp. <?php echo number_format($total_harga_barang - $total_biaya_marketplace,0,".",".");?></b></td>
                  </tr>
                  <tr style="border:1px solid #000;display: none;">
                    <td style="border:1px solid #000;font-size: 12px;text-align: center;" colspan="7"></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Penjualan Bersih</b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Rp. <?php echo number_format($total_harga_barang,0,".",".");?></b><input type="hidden" name="total_harga_barang" placeholder="0"  class="total_harga_barang" value="<?php echo $total_harga_barang?>"><input type="hidden" name="total_komisi" placeholder="0"  class="total_komisi" value="<?php echo round($total_komisi);?>"></td>
                  </tr>                
                  <tr style="border:1px solid #000;display: none;">
                    <td style="border:1px solid #000;font-size: 16px;text-align: center;" colspan="7"></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Penjualan NETT</b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Rp. 
                      <?php 
                      $periodex = date('d F Y', strtotime($tgl1)).' - '.date('d F Y', strtotime($tgl2));
                      if($periodex == $periode['periode']){
                        echo  number_format($periode['penjualan_fix'],0,".",".");
                      }else{?>
                          <span class="penjualan_net"></span>
                      <?php }?>
                    </b></td>
                  </tr>
                </tfoot>
              </table>
              <br><br>
              <i style="font-size: 12px;"><label class="label label-success">*Kolom hijau</label> Pesanan yang telah selesai diproses dan dibayar dibulan yang sama saat pemesanan.<br><label class="label label-warning">*Kolom kuning</label> Pesanan pada bulan lalu terselesaikan pembayarannya dibulan ini.<br><span style="color:red;">Harga Final Belum dikurangi komisi toko 5%</span></i>
            </div>
          </div>
          <div class="row page-break">
            <div class="col-md-12">
              <h2 style="text-align: center;"><b>LAPORAN PENJUALAN (PENDINGAN BULAN LALU)</b><br><span style="font-size: 14px;">MAKSIMAL CEK 12 BULAN KEBELAKANG</span></h2>
            </div>
            <div class="col-md-12 table-responsive" style="margin-top: 20px;">  
              <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="border-top:1px solid black;">
                <thead>
                  <tr style="border:1px solid #000;">
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Order</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Selesai Order</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Nomor Invoice</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Toko Pengirim</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Artikel</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Size</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Qty</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Barang</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Diskon</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Final & Diskon</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Komisi Toko (5%)</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Diskon + Biaya Marketplace</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px; display: none;">Biaya Marketplace</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px; display: none;">Harga Barang - Biaya Marketplace (Final Price)</th>
                  </tr>
                </thead>
                <tbody>
                    <?php            
                    $total_komisi3 = 0;         
                    $total_diskon = 0;
                    $total_biaya_marketplace = 0;
                    //$total_disc_dan_biaya = 0;
                    $total_qty = 0;
                    $total_harga_barang3 = 0;
                    $total_harga_barang_final = 0;;
                    $total_diskon_barang = 0;
                    foreach($pendingan_1_tahun_kebelakang as $data2){

                      if($data2->harga_before == "" || $data2->harga_before == 0){ 
                        $total_diskon_barangx = 0;
                      }else{ 
                        $total_diskon_barangx = ($data2->harga_before-$data2->harga_fix)*$data2->qty;
                      }

                      $total_diskon_barang += $total_diskon_barangx;

                      if($data2->buy_in == "lazada"){
                        $biaya_lazada = $data2->harga_fix * 1.804 / 100;
                        $vat_lazada   = $data2->harga_fix * 0.164 / 100;
                        //$vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
                      }else{
                        $biaya_lazada = 0;
                        $vat_lazada = 0;
                        //$vat_pencairan = 0;
                      }

                      $total_biaya_marketplace += ($biaya_lazada + $vat_lazada); // + $vat_pencairan
                      if($data2->harga_before != "" || $data2->harga_before > 0){
                        $diskon = ($data2->harga_before-$data2->harga_fix) * $data2->qty;
                      }else{ 
                        $diskon = "0";
                      }

                      if($data2->komisi_toko == ""){
                        $komisi3 = ($data2->harga_fix*5)/100;
                      }else{
                        $komisi3 = $data2->komisi_toko;
                      }

                      $total_diskon += $diskon; //($data->harga_before-$data->harga_fix) * $data->qty;
                      $total_komisi3 += $komisi3;
                      //$total_disc_dan_biaya = $total_diskon;// + $total_biaya_marketplace;
                      $total_qty += $data2->qty;
                      $total_harga_barang3 += ($data2->harga_fix*$data2->qty);//-($biaya_lazada+$vat_lazada+$vat_pencairan);
                      $total_harga_barang_final += ($data2->harga_fix*$data2->qty);
                      $jenis_laporan = "background-color:#ffb1b1;";
                    ?>

                   <tr style="border:1px solid #000;<?php echo $jenis_laporan?>">
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                            echo date('d/m/Y', strtotime($data2->tanggal_waktu_order));
                        ?>
                        <label style="margin-left: 5px;" class="label label-danger"> </label> 
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                            if($data2->tanggal_waktu_order_finish == "0000-00-00 00:00:00"){
                              echo "Belum Selesai";
                            }else{
                              echo date('d/m/Y', strtotime($data2->tanggal_waktu_order_finish));
                            }
                        ?>
                      </td>
                      <td style="text-align:center;width:100px;border:1px solid #000;font-size: 12px;">
                        <?php 
                          if($data2->buy_in == "E-commerce"){
                            echo $data2->invoice;
                          }else{
                            echo $data2->no_order_pro;
                          }
                        ?>
                        <br>[ <?php echo $data2->buy_in?> ]</td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data2->sender;?><br><?php echo $data2->nama_toko;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data2->artikel;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data2->ukuran;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data2->qty;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php if($data2->harga_before != "" || $data2->harga_before > 0){?>
                          Rp. <?php echo number_format($data2->harga_before,0,".",".");?>
                        <?php }else{ 
                          echo"Rp. ".number_format($data2->harga_fix,0,".",".").""; 
                        }?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">
                        <?php if($data2->harga_before != "" || $data2->harga_before > 0){?>
                        <i style="text-decoration:line-through;">Rp. <?php echo number_format($data2->harga_before,0,".",".");?></i><br>Rp. <?php echo number_format($data2->harga_fix,0,".",".");?><?php }else{ echo"Rp. ".number_format($data2->harga_fix,0,".",".").""; }?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Rp. 
                        <?php if($data2->harga_before == "" || $data2->harga_before == 0){ 
                          echo "0"; 
                        }else{ 
                          echo number_format(($data2->harga_before-$data2->harga_fix)*$data2->qty,0,".",".")." <span style='color:red;font-weight:bold;'>(".round(($data2->harga_before - $data2->harga_fix) / $data2->harga_before * 100) * $data2->qty."%)</span>";
                        }?> 
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                        // mencari komisi toko
                        //if($data2->komisi_toko == ""){
                        //  $komisi = ($data2->harga_fix*4)/100;
                        //}else{
                       //   $komisi = $data2->komisi_toko;
                        //}?>
                        Rp. <?php echo number_format($data2->harga_fix,0,".",".");?><br>
                        <i style="color: red;font-size: 10px;">
                          Rp. <?php if($data2->harga_before == "" || $data2->harga_before == 0){ echo "0"; }else{ echo number_format(($data2->harga_before-$data2->harga_fix)*$data2->qty,0,".",".")." <span style='color:red;font-weight:bold;'>(".round(($data2->harga_before - $data2->harga_fix) / $data2->harga_before * 100) * $data2->qty."%)</span>";
                          }?>
                        </i> 
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">
                      <?php if($data2->komisi_toko == ""){
                        echo "Rp.".number_format(($data2->harga_fix*5)/100,0,".",".")."";
                      }else{
                        echo "Rp.".number_format($data2->komisi_toko,0,".",".")."";
                      }?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none">
                      <?php 
                      //if($data->buy_in == "lazada"){
                      //  $biaya_lazada = $data->harga_fix * 1.804 / 100;
                      //  $vat_lazada   = $data->harga_fix * 0.164 / 100;
                      //  $vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
                      //  $biaya_marketplace = $biaya_lazada+$vat_lazada+$vat_pencairan;
                      //  if($data->harga_before == 0){
                      //    echo "Rp. ".number_format($biaya_marketplace,0,".",".");
                      //  }else{
                      //    echo "Rp. ".number_format($biaya_marketplace + ($data->harga_before-$data->harga_fix),0,".",".");
                      //  }
                      //}else{
                      //  if($data->harga_before == 0){
                      //    echo "Rp. 0";
                      //  }else{
                      //    echo "Rp. ".number_format($data->harga_before-$data->harga_fix,0,".",".");
                      //  }
                      //}?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">
                      <?php if($data2->buy_in == "lazada"){
                        $biaya_lazada = ($data2->harga_fix * $data2->qty) * 1.804 / 100;
                        $vat_lazada   = ($data2->harga_fix * $data2->qty) * 0.164 / 100;
                        //$vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
                        echo "Biaya Lazada<br>Rp.".number_format($biaya_lazada,2)."<br>";
                        echo "Vat Lazada<br>Rp.".number_format($vat_lazada,2)."<br>";
                        //echo "Vat Pencairan<br>Rp.".number_format($vat_pencairan,2)."<br>";
                      }else{
                        echo "Rp. 0";
                      }?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px; display: none;">
                      <small style="color:#f12121;">
                      <?php 
                      //if($data->harga_before == "" || $data->harga_before == 0){ 
                      //    $hg_barang = 0;
                      //}else{ 
                      //  $hg_barang = ($data->harga_before-$data->harga_fix)*$data->qty;
                      //}
                      $hg_barang = $data2->harga_fix*$data2->qty;

                      if($data2->buy_in == "lazada"){ //+ $vat_pencairan
                        $biaya_market = ($biaya_lazada+$vat_lazada )*$data2->qty;
                      }else{
                        $biaya_market = 0;
                      }
                      echo "Rp. ".number_format($hg_barang,0,".",".")." - Rp. ".number_format($biaya_market,0,".",".")." = Rp. ".number_format($hg_barang - $biaya_market,0,".",".")."";?>
                      </small><br>
                      <b>Rp.</b>
                      <?php 
                      if($data2->buy_in == "lazada"){
                        echo "<b>".number_format($hg_barang - $biaya_market,0,".",".")."</b>"; // + $vat_pencairan
                      }else{
                        echo "<b>".number_format($hg_barang,0,".",".")."</b>";
                      }
                      ?>
                      </td>
                  </tr>
                 <?php }?>
                </tbody>
                <tfoot style="display: table-row-group">
                  <tr style="border:1px solid #000;">
                    <td style="border:1px solid #000;font-size: 14px;text-align: center;" colspan="6"><b>TOTAL</b><br><i style="font-size: 10px;">TOTAL DISKON = <?php echo number_format($total_diskon_barang,0,".",".");?></i></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b><?php echo $total_qty;?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_harga_barang3+$total_diskon,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;display: none;"><b>Rp. <?php echo number_format($total_diskon,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>
                      Rp. <?php echo number_format($total_harga_barang_final,0,".",".");?>
                    </td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;display: none;"><b>Rp. <?php echo number_format($total_komisi3,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;display: none;"><b>Rp. <?php echo number_format($total_biaya_marketplace,0,".",".");?></b></td>
                    <td rowspan="2" style="vertical-align: middle !important;border:1px solid #000;font-size: 16px;text-align: center;display: none;"><b>Rp. <?php echo number_format($total_harga_barang3 - $total_biaya_marketplace,0,".",".");?></b></td>
                  </tr>
                </tfoot>
              </table>
              <br><br>
              <i style="font-size: 12px;"><label class="label label-danger">*Kolom merah</label> Pesanan dari bulan sekarang atau bulan lalu (maksimal cek 1 tahun kebelakang) tapi masih belum selesai hingga bulan ini, karena status pembayaran belum dibayar oleh marketplace / masalah pada order atau sistem marketplace (tidak ikut closing bulan ini).<br><span style="color:red;">Harga Final Belum dikurangi komisi toko 5%</span></i>
            </div>
      </div>

      <div id="PRODUK" class="col-md-12" style="text-align: center;display: none;"> <?php // dimatikan karena terlalu memakan banyak kertas?>
        <div style="margin-top:50px;" class="page-break cover_count">
          <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="border-top:1px solid black;">
            <thead>
              <tr style="border:1px solid #000;">
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Gambar</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Artikel</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Total Penjualan</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $total = 0;
                foreach($produk_best_seller_bulan_ini as $data){
                  $total += $data->total;
              ?>
              <tr style="border:1px solid #000;">
                <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <img style="width:70px;height: auto;" src="<?php echo $data->gambar;?>">
                </td>
                <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php echo $data->artikel;?>
                </td>
                <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php echo $data->total;?> PSG
                </td>
              </tr>
              <?php }?>
            </tbody>
            <tfoot style="display: table-row-group">
              <tr style="border:1px solid #000;">
                <td style="border:1px solid #000;font-size: 14px;text-align: center;" colspan="2"><b>TOTAL</b></td>
                <td style="border:1px solid #000;font-size: 14px;text-align: center;" ><b><?php echo $total?> PSG</b></td>
              </tr>
            </tfoot>
          </table>
          <br>
        </div>
      </div>
      <div id="GRAFIK_MARKETPLACE_DAN_DIVISI" class="col-md-12" style="text-align: center;">
        <div style="margin-top:50px;" class="page-break cover_count">
          <h3>PENJUALAN DARI SEMUA PLATFORM</h3>
          <div id="grafikmarketplace">
            <script type="text/javascript">
              $('#grafikmarketplace').highcharts({
                  chart: {
                    type: 'pie',
                    //marginTop: 10
                  },
                  credits: {
                    enabled: false
                  }, 
                  //tooltip: {
                  //  pointFormat: '{series.name}: <b>{series.data.}pasang</b>'
                  //},
                  title: {
                    text: ''
                  },
                  subtitle: {
                    text: ''
                  },
                  xAxis: {
                    categories: [''],
                    labels: {
                     style: {
                      fontSize: '10px',
                      fontFamily: 'Verdana, sans-serif'
                     }
                    }
                  },
                  legend: {
                    enabled: true
                  },
                  plotOptions: {
                     pie: {
                       allowPointSelect: true,
                       cursor: 'pointer',
                       dataLabels: {
                         enabled: false
                       },
                       showInLegend: true
                     }
                  },

                  series: [{
                     'name':'Terjual',
                     'data':[
                      <?php
                      $getMarket = $this->onlinestore_adm->get_marketplace();
                      foreach($getMarket as $m){
                        $marketx = $m->val_market;
                        $getData = $this->rpp_rpk_adm->penj_by_sosmed_dan_mp($tgl1, $tgl2, $status1x, $status2x, $marketx);
                        foreach($getData as $pnj_type){                             
                      ?>
                       ['<?php echo $marketx; ?> (<?php echo $pnj_type->jual_pasang; ?> psg)',<?php echo $pnj_type->jual_pasang; ?>],
                      <?php }}?>
                     ]
                  }]
              });
            </script>
          </div><br><br><br>
          <div id="graph_divisi">
            <script type="text/javascript">
              $('#graph_divisi').highcharts({
                  chart: {
                    type: 'column',
                  },
                  title: {
                    text: 'PRODUK TERJUAL BY DIVISI'
                  },
                  xAxis: {
                    categories: ['Divisi'],                    
                  },
                  yAxis: {
                      title: {
                          text: 'Total Pasang Terjual'
                      }
                  },
                  series: [
                      <?php
                      $getDivisi = $this->rpp_rpk_adm->getDivisi();
                      foreach($getDivisi as $d){
                        $milik = $d->id_milik;
                        $produk_terjual_bydivisi_bulan_ini = $this->rpp_rpk_adm->produk_terjual_bydivisi_bulan_ini($tgl1, $tgl2, $status1x, $status2x, $milik);
                        foreach($produk_terjual_bydivisi_bulan_ini as $datax){                             
                      ?>
                          {
                            name: '<?php echo $d->milik; ?> (<?php echo $datax->total; ?> PSG)',
                            data: [<?php echo $datax->total; ?>]
                          },
                      <?php }}?>
                  ],
                  responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                align: 'center', 
                                verticalAlign: 'bottom',
                                layout: 'horizontal'
                            },
                            yAxis: {
                                labels: {
                                    align: 'left',
                                    x: 0,
                                    y: -5
                                },
                                title: {
                                    text: null
                                }
                            },
                            subtitle: {
                                text: null
                            },
                            credits: {
                                enabled: false
                            }
                        }
                    }]
                  }
              });
          </script>
          </div>
        </div>
      </div>

      <div id="RETUR" class="row page-break">
        <div class="col-md-12">
          <h2 style="text-align: center;"><b>LAPORAN RETUR</b></h2>
        </div>
        <div class="col-md-12 table-responsive" style="margin-top: 20px;">  
          <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="border-top:1px solid black;">
            <thead>
              <tr style="border:1px solid #000;">
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Retur</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Nomor Retur</th>
                  <th style="text-align:left;border:1px solid #000;font-size: 12px;">Invoice Retur dan Invoice Pengganti</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Alasan</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Solusi</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Artikel Retur</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Artikel Pengganti</th>
              </tr>
            </thead>
            <tbody>
                <?php            
                foreach($laporan_retur as $rtr){
                  if($rtr->status == "2hd8jPl613!2_^5"){
                      $status = "<label class='label label-warning'>Menunggu Pembayaran</label>";
                  }else if($rtr->status == "*^56t38H53gbb^%$0-_-"){
                      $status = "<label class='label label-primary'>Pembayaran Diterima</label>";
                  }else if($rtr->status == "Uywy%u3bShi)payDhal"){
                      $status = "<label class='label label-primary'>Dalam Pengiriman</label>";
                  }else if($rtr->status == "ScUuses8625(62427^#&9531(73"){
                      $status = "<label class='label label-success'>Diterima</label>";
                  }else if($rtr->status == "batal"){
                    $status = "<label class='label label-danger'>Dibatalkan</label>";
                  }

                  if($rtr->id_invoice_pengganti == 0){ 
                    $invoicepengganti = " - ";
                  }else{ 
                    $invoicepengganti = $rtr->id_invoice_pengganti;
                  }
                ?>

               <tr style="border:1px solid #000;">
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                    <?php echo date('d/m/Y', strtotime($rtr->date_filter));?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                    <?php echo $rtr->id_retur_info;?>
                  </td>
                  <td style="text-align:left;border:1px solid #000;font-size: 12px;">
                    <?php 
                      echo "Invoice Retur :<br><i><b>".$rtr->id_invoice_real."</i></b><br><br>Invoice Pengganti :<br><i><b>".$invoicepengganti."</i></b>";
                    ?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $rtr->alasan;?></td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $rtr->solusi_retur;?></td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                    <?php 
                      foreach($produk_retur as $ft){
                      if($ft->id_invoicepro == $rtr->id_invoice_real){
                        echo $ft->id_produk_from_order_produk."<br>";
                      }}
                    ?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                    <?php 
                      foreach($produk_retur as $ft){
                      if($ft->id_invoicepro == $rtr->id_invoice_pengganti){
                        echo $ft->id_produk_from_order_produk."<br>";
                      }}
                    ?>
                  </td>
              </tr>
             <?php }?>
            </tbody>
          </table>
        </div>
      </div>

      <div id="BIAYA" class="col-md-12">
        <div style="padding: 118px;" class="page-break cover_count" id="cover_laporan">
          <table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr style="border:none;">
                    <th colspan="12" style="border:none;"><h1 style="text-align: center">BUKTI BIAYA - BIAYA</h1></th>
                </tr>
            </thead>
            <tbody>        
              <tr style="border:none;">
                <td colspan="3" style="border:none;padding: 0;"><h4 style="margin-top: 0;margin-bottom: 0;"><b>TOTAL BIAYA :</b></h4></td>
                <td colspan="3" style="text-align: right;border: none;padding: 0;"><h4 style="margin-top: 0;margin-bottom: 0;"><b>Rp. <?php echo number_format($total_biaya,0,".",".");?></b></h4></td>
              </tr>
            </tbody>
          </table>
          <h4 style="font-size: 12px;margin-top:10;"><i>*Biaya yang dicatat adalah komisi toko, penggantian ongkir</i></h4>
          <h2 style="border:2px solid black;text-align: center;margin-top: 40px;">Lampiran 2</h2>
        </div>
      </div>
      <div id="LAPORAN-ONGKIR" class="col-md-12">
        <div class="row page-break">
          <div class="col-md-12" style="margin-top: 20px;">
            <h2 style="text-align: center;"><b>LAPORAN ONGKOS KIRIM</b></h2>
            <h4 style="margin: 5 0;">Tanggal : <?php echo date("d F Y", strtotime($tgl1));?> - <?php echo date("d F Y", strtotime($tgl2));?></h4>
            <h4 style="margin: 5 0;">Market : <?php echo $market;?></h4>
            <h4 style="margin: 5 0;">Status Pesanan : <?php echo $status2;?></h4>
            <h4 style="margin: 5 0;">Status Pembayaran : <?php echo $status1;?></h4>
            <h4 style="margin: 5 0;">Ongkir Ditanggung : Dipotong dari penjualan oleh marketplace & Ditanggung Toko</h4>
            <h4 style="margin: 5 0;">Sort By : <?php if($terjual_by == "tgl_order"){ echo "Tanggal Order";}else{ echo "Tanggal Selesai Pesanan";}?></h4>
          </div>
          <div class="col-md-12 table-responsive">  
            <div id="pesan"></div>
              <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" >
            <thead>
                <tr style="border:1px solid #000;">
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Invoice</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Invoice</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Alamat Customer</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Expedisi</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tarif (Click)</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tarif (Actual)</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Selisih Tarif (Click & Actual)</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Dibayar Oleh</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Status Order</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $tc = 0;
                $tr = 0;
                $yy = 0;

                foreach($laporan_pengiriman as $data9):
                  if($data9->actual_tarif != ""){
                    $yy += $data9->actual_tarif - $data9->tarif;                    
                  }

                  $tarif = $data9->tarif;
                  $act   = $data9->actual_tarif;
                  $tc +=($tarif);
                  $tr +=($act);
                ?>
               <tr>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php 
                    if($terjual_by == "tgl_order"){
                      echo date("d/m/Y", strtotime($data9->tanggal_order));
                    }else{
                      echo date("d/m/Y", strtotime($data9->tanggal_order_finish));
                    }
                  ?>
                  </td>
                  <td  style="text-align:center;border:1px solid #000;font-size: 12px;"><span style='font-size: 12px;font-weight:bold;'><?php echo $data9->invoice?><br>[ <?php echo $data9->buy_in?> ]<br><br>Resi : <?php echo $data9->no_resi?><br><br>Dikirim Oleh :<br> <?php echo $data9->nama_toko?> [<?php echo $data9->kode_edp?>]</span></td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data9->alamat;?></td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;"><span style="font-size: 10px;"><?php echo $data9->layanan;?></span></td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php 
                    //if($data->tarif == "gratis" || $data->tarif == "" || $data->tarif == 0){
                    //  echo "".$data->tarif."<br><label style ='font-size:10px;' class='label label-primary'>Gratis Ongkir</label>";
                    //}else{
                      echo "Rp. ".number_format($data9->tarif,0,".",".");
                    //}
                  ?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php 
                    if($data9->actual_tarif == ""){
                      echo "Belum Diinput";
                    }else{
                      echo "Rp. ".number_format($data9->actual_tarif,0,".",".");
                    }
                  ?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php
                    if($data9->actual_tarif == ""){
                      echo "Belum Diinput";
                    }else{
                      $t = $data9->actual_tarif - $data9->tarif; echo "Rp. ".number_format($t,0,".",".")."";
                    }
                    ?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                    <?php 
                      if($data9->ongkir_ditanggung == "gratis"){
                        echo "Gratis Ongkir";
                      }else if($data9->ongkir_ditanggung == "kantor"){
                        echo "Kantor";
                      }else if($data9->ongkir_ditanggung == "toko"){
                        echo "Toko";
                      }else{
                        echo "Dipotong Langsung dari Penjualan oleh marketplace";
                      }
                    ?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php

                    if($data9->status == "2hd8jPl613!2_^5"){
                     echo "<label class='label label-warning'>Menunggu Pembayaran</label>";
                    }else if($data9->status == "*^56t38H53gbb^%$0-_-"){
                      echo "<label class='label label-primary'>Pembayaran Diterima</label>";
                    }else if($data9->status == "Uywy%u3bShi)payDhal"){
                      echo "<label class='label label-primary'>Dalam Pengiriman</label>";
                    }else if($data9->status == "ScUuses8625(62427^#&9531(73"){
                      echo "<label class='label label-success'>Diterima</label>";
                    }else if($data9->status == "batal"){
                      echo "<label class='label label-danger'>Dibatalkan</label>";
                    }
                  ?></td>
              </tr>
             <?php endforeach;?>
            </tbody>
            <tfoot style="display: table-row-group">
              <tr>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;" colspan="4"> Total</th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Rp. <?php echo number_format($tc,0,".",".");?></th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Rp. <?php echo number_format($tr,0,".",".");?></th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;">Rp. <?php echo number_format($yy,0,".",".");?></th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;"></th>
                  <th style="text-align:center;border:1px solid #000;font-size: 12px;"></th>
              </tr>
            </tfoot>
          </table> 
        </div>
        </div>
      </div>
      <div id="BIAYA-DETAIL" class="col-md-12">
        <div class="row page-break">
          <div class="col-md-12">
            <h2 style="text-align: center;"><b>KOMISI TOKO & PENGGANTIAN ONGKIR</b></h2>
          </div>
          <div class="col-md-12 table-responsive" style="margin-top: 20px;"> 
            <?php 
            foreach($getStore as $store){
              $storeEdp = $store->kode_edp;
              $rekapOrder = $this->rpp_rpk_adm->get_order_for_comission_rpp($storeEdp,$tgl1,$tgl2);
              $rekapExp   = $this->rpp_rpk_adm->get_order_for_actual_ongkir($storeEdp,$tgl1,$tgl2);
              echo "<h3 style='text-align:center;border:1px solid black;'>TOKO : ".$store->nama_toko." [".$store->kode_edp."]</h3>KOMISI";
            ?> 
            <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="border-top:1px solid black;">
              <thead>
                <tr style="border:1px solid #000;">
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Order</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Selesai</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Nomor Invoice</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Artikel</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Size</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Qty</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Barang</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Barang x QTY & Diskon</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Komisi Toko (5%)</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Ongkir Yang Ditanggung</th>
                </tr>
              </thead>
              <tbody>
                  <?php        
                  $nomortransaksi = 0;    
                  $total_komisi3 = 0;         
                  $total_biaya_marketplace = 0;
                  $total_ongkir_ditanggung = 0;
                  $total_pasang = 0;
                  $total_harga_barangx = 0;
                  $total_harga_barang_finalx = 0;
                  foreach($rekapOrder as $data5){

                    // PAJAK MARKETPLACE

                    // LAZADA
                    if($data5->buy_in == "lazada"){
                      $biaya_lazada = $data5->harga_fix * 1.804 / 100;
                      $vat_lazada   = $data5->harga_fix * 0.164 / 100;
                      //$vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
                    }else{
                      $biaya_lazada = 0;
                      $vat_lazada = 0;
                      //$vat_pencairan = 0;
                    }
                    $total_biaya_marketplace += ($biaya_lazada + $vat_lazada);

                    // SHOPEE
                    // BUKALAPAK
                    // TOKOPEDIA

                    // END PAJAK MARKETPLACE

                    // KOMISI TOKO
                    if($data5->komisi_toko == ""){
                      $komisi3 = (($data5->harga_fix*5)/100)*$data5->qty;
                    }else{
                      $komisi3 = $data5->komisi_toko*$data5->qty;
                    }
                    $total_komisi3 += round($komisi3);
                    // END KOMISI TOKO

                    // TOTAL 
                    $total_pasang += $data5->qty;
                    if($data5->harga_before != "" || $data5->harga_before > 0){
                      $total_harga_barangxx = $data5->harga_before;
                    }else{ 
                      $total_harga_barangxx = $data5->harga_fix;
                    }
                    $total_harga_barangx += $total_harga_barangxx;
                    $total_harga_barang_finalx += $data5->harga_fix;
                    // END TOTAL 
                  ?>

                 <tr style="border:1px solid #000;">
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                      <?php 
                          echo date('d/m/Y', strtotime($data5->tanggal_waktu_order));
                      ?>
                    </td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                      <?php 
                          if($data5->tanggal_waktu_order_finish == "0000-00-00 00:00:00"){
                            echo "Belum Selesai";
                          }else{
                            echo date('d/m/Y', strtotime($data5->tanggal_waktu_order_finish));
                          }
                      ?>
                    </td>
                    <td style="text-align:center;width:100px;border:1px solid #000;font-size: 12px;">
                      <?php 
                        if($data5->buy_in == "E-commerce"){
                          echo $data5->invoice;
                        }else{
                          echo $data5->no_order_pro;
                        }
                      ?>
                      <br>[ <?php echo $data5->buy_in?> ]
                    </td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo strtoupper($data5->artikel);?></td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data5->ukuran;?></td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data5->qty;?></td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                      <?php if($data5->harga_before != "" || $data5->harga_before > 0){?>
                        Rp. <?php echo number_format($data5->harga_before,0,".",".");?>
                      <?php }else{ 
                        echo"Rp. ".number_format($data5->harga_fix,0,".",".").""; 
                      }?>
                    </td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                      Rp. <?php echo number_format($data5->harga_fix*$data5->qty,0,".",".");?><br>
                      <i style="color: red;font-size: 10px;">
                        Rp. <?php if($data5->harga_before == "" || $data5->harga_before == 0){ echo "0"; }else{ echo number_format(($data5->harga_before-$data5->harga_fix)*$data5->qty,0,".",".")." <span style='color:red;font-weight:bold;'>(".round(($data5->harga_before - $data5->harga_fix) / $data5->harga_before * 100) * $data5->qty."%)</span>";
                        }?>
                      </i> 
                    </td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                    <?php echo "Rp.".number_format($komisi3,0,".",".")."";?>
                    </td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">
                        <?php echo "Rp.".number_format($ongkir_ditanggung,0,".",".").""; ?><br>
                        <i style="color: red;font-size: 10px;"><?php echo $ket_onngkir;?></i>
                    </td>
                </tr>
               <?php }?>
              </tbody>
              <tfoot style="display: table-row-group">
                <tr style="border:1px solid #000;">
                  <td style="border:1px solid #000;font-size: 12px;text-align: left;" colspan="5"><b>TOTAL KOMISI</b></td>
                  <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b><?php echo $total_pasang;?></b></td>
                  <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Rp. <?php echo number_format($total_harga_barangx,0,".",".");?></b></td>
                  <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Rp. <?php echo number_format($total_harga_barang_finalx,0,".",".");?></b></td>
                  <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Rp. <?php echo number_format($total_komisi3,0,".",".");?></b></td>
                </tr>
              </tfoot>
            </table><br><br>
            ONGKIR YANG DITANGGUNG
            <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="border-top:1px solid black;">
              <thead>
                <tr style="border:1px solid #000;">
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Nomor Invoice</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Ongkir Yang Ditanggung Toko</th>
                </tr>
              </thead>
              <tbody>
                  <?php        
                  $ongkir_ditanggung = 0;
                  $total_ongkir_ditanggung = 0;
                  foreach($rekapExp as $data6){
                  if($data6->ongkir_ditanggung == "toko"){

                    // ACTUAL TARIF YANG DITANGGUNG TOKO
                    //if($data6->ongkir_ditanggung == "toko"){
                      if($data6->actual_tarif == ""){
                        $ongkir_ditanggungx = 0;
                        $ket_onngkir = "Real Ongkir belum diinput";
                      }else{
                        $ongkir_ditanggungx = $data6->actual_tarif;
                        $ket_onngkir = "";
                      }
                    //}else if($data6->ongkir_ditanggung == ""){
                    //  $ongkir_ditanggungx = 0;
                    //  $ket_onngkir = "Real Ongkir belum diinput";
                    //}else{
                    //  $ongkir_ditanggungx = 0;
                    //  $ket_onngkir = "";
                    //}

                    $total_ongkir_ditanggung += $ongkir_ditanggungx;
                    // END ACTUAL TARIF YANG DITANGGUNG TOKO
                  ?>

                 <tr style="border:1px solid #000;">
                    <td style="text-align:center;width:100px;border:1px solid #000;font-size: 12px;">
                      <?php 
                        if($data6->buy_in == "E-commerce"){
                          echo $data6->invoice;
                        }else{
                          echo $data6->no_order_cus;
                        }
                      ?>
                      <br>[ <?php echo $data6->buy_in?> ]
                    </td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php echo "Rp.".number_format($ongkir_ditanggungx,0,".",".").""; ?><br>
                        <i style="color: red;font-size: 10px;"><?php echo $ket_onngkir;?></i>
                    </td>
                </tr>
               <?php }}?>
              </tbody>
              <tfoot style="display: table-row-group">
                <tr style="border:1px solid #000;">
                  <td style="border:1px solid #000;font-size: 12px;text-align: left;"><b>TOTAL PENGGANTIAN ONGKIR</b></td>
                  <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Rp. <?php echo number_format($total_ongkir_ditanggung,0,".",".");?></b></td>
                </tr>
              </tfoot>
            </table>
            <br><br>
            <h3 style="border:1px solid black;text-align: center">TOTAL KOMISI DAN PENGGANTIAN ONGKIR <?php echo $store->nama_toko;?> [<?php echo $store->kode_edp;?>]<br>Rp. <?php echo number_format($total_komisi3+$total_ongkir_ditanggung,0,".",".");?><br>
            <i style="font-size: 12px;"><span style="color:red;">Komisi Toko sebesar 5% dan penggantian ongkir akan ditransfer ke rekening supervisor</span></i></h3><br><br><br>
            <?php }?>
            <br>
          </div>
        </div>
      </div>

      <div id="BUKTI_TRANSFER" class="col-md-12">
        <div style="padding: 118px;" class="page-break cover_count" id="cover_laporan">
          <table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr style="border:none;">
                    <th colspan="12" style="border:none;"><h1 style="text-align: center">BUKTI TRANSFER</h1></th>
                </tr>
            </thead>
            <tbody>        
              <tr style="border:none;">
                <td colspan="3" style="border:none;padding: 0;"><h4 style="margin-top: 0;margin-bottom: 0;"><b>TOTAL RUPIAH :</b></h4></td>
                <td colspan="3" style="text-align: right;border: none;padding: 0;"><h4 style="margin-top: 0;margin-bottom: 0;"><b>Rp. <?php echo number_format($total_transfer,0,".",".");?></b></h4></td>
              </tr>
            </tbody>
          </table>
          <h4 style="font-size: 12px;margin-top:10;"><i>*Transfer akan diteruskan ke rekening stars BNI 2018002222 A.n STARS INTERNASIONAL PT</i><</h4>
          <h2 style="border:2px solid black;text-align: center;margin-top: 40px;">Lampiran 3</h2>
        </div>
      </div>

    </div>
  </div>
</div>
</div>