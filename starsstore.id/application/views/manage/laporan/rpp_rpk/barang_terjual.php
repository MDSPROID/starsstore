<html>
<head>
<title>Laporan Barang Terjual</title>
<script type="text/javascript">var baseURL = '<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery/JQuery.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/clipboard.js');?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
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
             alert("Data berhasil ditambahkan, silahkan reload halaman");
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
<script type="text/javascript" src="<?php// echo base_url('assets/manage/js/sistem_adm.js');?>"></script>
<style type="text/css">
/*************************** END Frontend ************************************/
@media screen{
  .cover_count{
    display: block;
  }
  .cover_laporan{
    display: block;
  }
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
}
table {
  border-spacing: 0;
  
}
body {
  -webkit-print-color-adjust:exact;
  color-adjust: exact !important;  /*Firefox*/
  font-family: Arial, sans-serif;
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
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}
.label.label-success {
    background: #22BAA0;
}
.label-success {
    background-color: #19c323;
}
.label {
    margin-right: 10px;
    display: inline;
    padding: .2em .6em .0em;
    font-size: 75%;
    font-weight: bold;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25em;
}
label {
    font-size: 13px;
    font-weight: 400;
}
label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: bold;
}
.label.label-warning {
    background: #f6d433;
}
.label.label-danger {
    background: #f25656;
}
</style>
</head>
<body>
<label style="font-size: 20px;float: right;color: black;border:1px solid black;" class="label label-default print-btn" onclick="window.print()">Cetak</label>
<?php                  
//$totalsemuapendingan = 0;
$totalpendingbulanlaludanontime = 0;   
$pendingbulanlalu = 0;
$ontime = 0;
$total_harga_barang = 0; // buat cover penjualan closing
$totalrupiahpendingbulanlalu = 0;
$totalrupiahontimebulanini = 0;
// PENJUALAN ONTIME DAN ONWAY BULAN LALU
foreach($terjual as $datax){
  // membedakan jenis laporan (pendingan bulan lalu terselesaikan bulan ini, penjualan ontime, dan pendingan untuk bulan ini)

  if($datax->tanggal_waktu_order < $tgl1){ // pendingan dari bulan lalu yang terselesaikan bulan ini
    $pendingbulanlalu += $datax->qty;
    if($datax->harga_fix > $datax->retprc){
      $totalrupiahpendingbulanlalux = $datax->retprc*$datax->qty;
    }else{
      $totalrupiahpendingbulanlalux = $datax->harga_fix*$datax->qty;
    }
    $totalrupiahpendingbulanlalu += $totalrupiahpendingbulanlalux;
  }else { // PENJUALAN ONTIME
    $ontime += $datax->qty;
    if($datax->harga_fix > $datax->retprc){
      $totalrupiahontimebulaninix = $datax->retprc*$datax->qty;
    }else{
      $totalrupiahontimebulaninix = $datax->harga_fix*$datax->qty;
    }
    $totalrupiahontimebulanini += $totalrupiahontimebulaninix;
  }

  if($datax->harga_fix > $datax->retprc){
    $penyesuaianx = $datax->retprc*$datax->qty;
  }else{
    $penyesuaianx = $datax->harga_fix*$datax->qty;
  }
  $total_harga_barang += $penyesuaianx; //($datax->harga_fix*$datax->qty); // cover penjualan closing
}
$totalpendingbulanlaludanontime = $pendingbulanlalu + $ontime;
//$totalsemuapendingan = $totalpendinganbulanini + $totalpendinganbulanlalu;

// PENJUALAN ONWAY BULAN INI
$total_harga_barang_pending_bulan_ini = 0;
foreach($pendingan_1_tahun_kebelakang as $data2x){
  if($data2x->harga_fix > $data2x->retprc){
    $penyesuaian2x = $data2x->retprc*$data2x->qty;
  }else{
    $penyesuaian2x = $data2x->harga_fix*$data2x->qty;
  }
  $total_harga_barang_pending_bulan_ini += $penyesuaian2x; //($datax->harga_fix*$datax->qty); // cover penjualan closing
}
?>
<div style="position: absolute;top: 400px;padding: 118px 118px 118px 350px;width: 520px;" class="cover_count">
  <table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr style="border:none;">
            <th colspan="6" style="border:none;"></th>
        </tr>
    </thead>
    <tbody>
        <tr style="border:none;">
            <td colspan="3" style="border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><label class="label label-warning"></label> PENJUALAN ONWAY BULAN LALU : Rp.<?php echo number_format($totalrupiahpendingbulanlalu,0,".",".");?></h5></td>
            <td colspan="3" style="text-align: right;border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><?php echo $pendingbulanlalu?> PSG</h5></td>
        </tr>
        <tr style="border:none;">
            <td colspan="3" style="border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><label class="label label-success"></label> PENJUALAN ONTIME : Rp.<?php echo number_format($totalrupiahontimebulanini,0,".",".");?></h5></td>
            <td colspan="3" style="text-align: right;border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><?php echo $ontime?> PSG</h5></td>
            
        </tr>
        <tr style="border:none;">
          <td colspan="3" style="border-top: 2px solid #0e0e0e;"><h4 style="margin-top: 0;margin-bottom: 0;margin-left: 25px;"><b>TOTAL : Rp.<?php echo number_format($total_harga_barang,0,".",".");?></b></h4></td>
           <td colspan="3" style="text-align: right;border-top: 2px solid #0e0e0e;"><h5 style="margin-top: 0;margin-bottom: 0;"><b><?php echo $totalpendingbulanlaludanontime;?> PSG</b></h5></td>
        </tr>
        <tr style="border:none;">
          <td colspan="3" style="border:none;"></td>
           <td colspan="3" style="text-align: right;border:none;"></td>
        </tr>
        <tr style="border:none;">
          <td colspan="3" style="border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><label class="label label-danger"></label> PENJUALAN ONWAY BULAN INI</h5></td>
           <td colspan="3" style="text-align: right;border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><?php echo $totalpendinganbulanini?> PSG</h5></td>
        </tr>
        <tr style="border:none;display: none">
          <td colspan="3" style="border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><label class="label label-danger"></label> PENJUALAN BULAN LALU MAKS CEK 12 BULAN KEBELAKANG</h5></td>
           <td colspan="3" style="text-align: right;border:none;"><h5 style="margin-top: 0;margin-bottom: 0;"><?php echo $totalpendinganbulanlalu?> PSG</h5></td>
        </tr>
        <tr style="border:none;">
          <td colspan="3" style="border-top: 2px solid #0e0e0e;"><h4 style="margin-top: 0;margin-bottom: 0;margin-left: 25px;"><b>TOTAL : Rp.<?php echo number_format($total_harga_barang_pending_bulan_ini,0,".",".");?></b></h4></td>
           <td colspan="3" style="text-align: right;border-top: 2px solid #0e0e0e;"><h5 style="margin-top: 0;margin-bottom: 0;"><b><?php echo $totalpendinganbulanlalu //$totalsemuapendingan;?> PSG</b></h5></td>
        </tr>
    </tbody>
  </table>
  <h2 style="border:2px solid black;text-align: center;margin-top: 40px;">Lampiran 1</h2>
</div>
<div style="margin-top:0px !important;margin-left: 250px;margin-bottom: 700px;" class="cover_laporan">
    <img src="<?php echo base_url('assets/images/c_laporan_penjualan.jpg')?>" width="720" heigh="750">
</div>

<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
    <div class="tab-content">
      <div class="row">
          <div class="col-md-12">
          <div class="row">
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
                        <?php if($terjual_by == "tgl_order"){?>
                          <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Order</th>
                          <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Selesai Order</th>
                        <?php }else{?>
                          <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Order</th>
                          <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Selesai Order</th>
                        <?php }?>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Nomor Transaksi</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Pengirim</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Artikel</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Size</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Qty</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none">ODV</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga RIMS (A)</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Diskon (Harga RIMS - Harga Net)</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Diskon</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Net</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Net X Qty</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Komisi Toko (5%)</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Selisih (Harga Net - Harga RIMS)</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Penyesuaian dengan RIMS (Untuk Harga Net Yang Melebihi Harga RIMS)</th>
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

                    $total_rims = 0;
                    $total_harga_net = 0;
                    $total_harga_net_qty = 0;
                    $total_komisi = 0;
                    $total_selisih = 0;
                    $total_penyesuaian = 0;
                    $total_diskon_rims_net = 0;

                    foreach($terjual as $data){
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
                        $komisi1 = (($data->harga_fix*5)/100*$data->qty);
                      }else{
                        $komisi1 = $data->komisi_toko*$data->qty;
                      }

                      $total_diskon += $diskon; //($data->harga_before-$data->harga_fix) * $data->qty;
                      //$total_komisi += round($komisi1);
                      //$total_disc_dan_biaya = $total_diskon;// + $total_biaya_marketplace;                      
                      $total_harga_barang += ($data->harga_fix*$data->qty);//-($biaya_lazada+$vat_lazada+$vat_pencairan);

                      $total_qty += $data->qty;
                      $total_rims += $data->retprc*$data->qty;
                      $total_harga_net += $data->harga_fix;
                      $total_harga_net_qty += $data->harga_fix*$data->qty;
                      $total_komisi +=  round(($data->harga_fix*5)/100*$data->qty);

                      if($data->harga_fix > $data->retprc){
                        $total_selisihx = ($data->harga_fix - $data->retprc)*$data->qty;
                        $penyesuaian = $data->retprc*$data->qty;
                        $diskon_rims_net = 0;
                      }else{
                        $total_selisihx = 0;
                        $penyesuaian = $data->harga_fix*$data->qty;
                        $diskon_rims_net = ($data->retprc - $data->harga_fix)*$data->qty;
                      }
                      $total_selisih += $total_selisihx;
                      $total_penyesuaian += $penyesuaian;
                      $total_diskon_rims_net += $diskon_rims_net;

                      // membedakan jenis laporan (pendingan terselesaikan, penjualan ontime, atau pendingan untuk bulan berikutnya)
                      if($data->tanggal_waktu_order < $tgl1){ // pendingan dari bulan lalu yang terselesaikan bulan berikutnya
                        $jenis_laporan = "<label class='label' style='background-color:#f6d433;'>&nbsp</label>";
                      }else { // PENJUALAN ONTIME
                        $jenis_laporan = "<label class='label' style='background-color:#22BAA0;'>&nbsp</label>";
                      }
                    ?>

                   <tr style="border:1px solid #000;">
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                            echo date('d F Y', strtotime($data->tanggal_waktu_order));
                        ?><br>
                        <?php echo $jenis_laporan?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                            if($data->tanggal_waktu_order_finish == "0000-00-00 00:00:00"){
                              echo "Belum Selesai";
                            }else{
                              echo date('d F Y', strtotime($data->tanggal_waktu_order_finish));
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
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data->sender;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data->artikel;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data->ukuran;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data->qty;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;"></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                        //if($data->harga_before != "" || $data->harga_before > 0){?>
                          Rp. <?php echo number_format($data->retprc,0,".","."); //echo number_format($data->harga_before,0,".",".");?>
                        <?php //}else{ 
                          //echo"Rp. ".number_format($data->retprc,0,".",".").""; 
                        //}?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                          Rp. <?php echo number_format($diskon_rims_net,0,".",".");?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none">
                        <?php if($data->harga_before != "" || $data->harga_before > 0){?>
                        <i style="text-decoration:line-through;">Rp. <?php echo number_format($data->harga_before,0,".",".");?></i><br>Rp. <?php echo number_format($data->harga_fix,0,".",".");?><?php }else{ echo"Rp. ".number_format($data->harga_fix,0,".",".").""; }?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">Rp. 
                        <?php 
                        //if($data->harga_before == "" || $data->harga_before == 0){ 
                        //  echo "0"; 
                        //}else{ 
                          echo number_format(($data->retprc-$data->harga_fix)*$data->qty,0,".",".")." <span style='color:red;'>(".round(($data->retprc - $data->harga_fix) / $data->retprc * 100) * $data->qty."%)</span>";
                        //}?> 
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        Rp. <?php echo number_format($data->harga_fix,0,".",".");?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        Rp. <?php echo number_format($data->harga_fix*$data->qty,0,".",".");?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                      <?php if($data->komisi_toko == ""){
                        echo "Rp.".number_format(($data->harga_fix*5)/100*$data->qty,0,".",".")."";
                      }else{
                        echo "Rp.".number_format($data->komisi_toko*$data->qty,0,".",".")."";
                      }?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        Rp. <?php echo number_format($total_selisihx,0,".",".");?>
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
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                        if($data->harga_fix > $data->retprc){
                          //$total_selisihx = $data->harga_fix - $data->retprc;
                          echo "<span style='color:red;'>Rp.".number_format($data->retprc,0,".",".")."</span>";
                        }else{
                          echo "Rp.".number_format($data->harga_fix,0,".",".");
                        }
                        ?>
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
                    <td style="border:1px solid #000;font-size: 14px;text-align: center;" colspan="6"><b>TOTAL</b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b><?php echo $total_qty;?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;display: none;"></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_rims,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_diskon_rims_net,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_harga_net,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>
                      Rp. <?php echo number_format($total_harga_net_qty,0,".",".");?>
                    </b>
                    </td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_komisi,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_selisih,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_penyesuaian,0,".",".");?></b></td>
                  </tr>
                  <tr style="border:1px solid #000;display: none;">
                    <td style="border:1px solid #000;font-size: 12px;text-align: center;" colspan="7"></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Penjualan Bersih</b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Rp. <?php echo number_format($total_harga_barang,0,".",".");?></b><input type="hidden" name="total_harga_barang" placeholder="0"  class="total_harga_barang" value="<?php echo $total_harga_barang?>"><input type="hidden" name="total_komisi" placeholder="0"  class="total_komisi" value="<?php echo round($total_komisi);?>"></td>
                  </tr>                
                  <?php if($periodex = $periode['periode']){

                  }else{?>
                  <tr style="border:1px solid #000;display: none;">
                    <input type="hidden" name="periode" class="periode" value="<?php echo date('d F Y', strtotime($tgl1));?> - <?php echo date('d F Y', strtotime($tgl2));?>">
                    <td style="border:1px solid #000;font-size: 12px;text-align: center;" colspan="9"><i style="font-size: 12px;">*Input biaya meliputi : pajak, keperluan yang memakai uang ecommerce<br>*Setelah input biaya, lalu cetak cover. jika ada yang ingin diubah, hapus di menu RPP/ RPK</i></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Biaya dan pajak marketplace</b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Rp. 
                      <?php 
                      $periodex = date('d F Y', strtotime($tgl1)).' - '.date('d F Y', strtotime($tgl2));
                      if($periodex == $periode['periode']){
                        echo  number_format($periode['biaya_marketplace'],0,".",".");
                      }else{?>
                        <input type="number" name="biaya_pajak" placeholder="0" class="biaya_pajak"><button class="btn-input-biaya">Simpan</button></b></td>
                      <?php }?>
                  </tr>
                  <?php }?>
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
              <br>
              <i style="font-size: 12px;"><label class="label label-success">*Kolom hijau</label> Pesanan yang telah selesai diproses dan dibayar dibulan yang sama saat pemesanan.<br><label class="label label-warning">*Kolom kuning</label> Pesanan pada bulan lalu terselesaikan pembayarannya dibulan ini.<br><span style="color:red;">Komisi Toko sebesar 5%, dan akan ditransfer ke rekening supervisor</span><br><span style="color:red;">Harga Final Belum dikurangi komisi toko 5%</span></i>
            </div>


            <div class="col-md-12" style="margin-top: 50px;">
                <h2 style="text-align: center;"><b>LAPORAN PENJUALAN (PENDINGAN BULAN LALU)</b><br><span style="font-size: 14px;">MAKSIMAL CEK 12 BULAN KEBELAKANG</span></h2>
            </div>
            <div class="col-md-12 table-responsive" >  
                <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="border-top:1px solid black;">
                <thead>
                    <tr style="border:1px solid #000;">
                        <?php if($terjual_by == "tgl_order"){?>
                          <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Order</th>
                          <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Selesai Order</th>
                        <?php }else{?>
                          <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Order</th>
                          <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Selesai Order</th>
                        <?php }?>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Nomor Transaksi</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Pengirim</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Artikel</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Size</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Qty</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">ODV</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga RIMS (A)</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Diskon</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Net</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Net X Qty</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Komisi Toko (5%)</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Selisih Harga Net & Harga RIMS</th>
                        <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Penyesuaian dengan RIMS (Untuk Harga Net Yang Melebihi Harga RIMS)</th>
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
                    $total_qty2 = 0;
                    $total_harga_barang3 = 0;

                    $total_rims2 = 0;
                    $total_harga_net2 = 0;
                    $total_harga_net_qty2 = 0;
                    $total_komisi2 = 0;
                    $total_selisih2 = 0;
                    $total_penyesuaian2 = 0;

                    foreach($pendingan_1_tahun_kebelakang as $data2){
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
                        $komisi3 = ($data2->harga_fix*5)/100*$data2->qty;
                      }else{
                        $komisi3 = $data2->komisi_toko*$data2->qty;
                      }

                      $total_diskon += $diskon; //($data->harga_before-$data->harga_fix) * $data->qty;
                      //$total_komisi3 += $komisi3;
                      //$total_disc_dan_biaya = $total_diskon;// + $total_biaya_marketplace;
                      $total_harga_barang3 += ($data2->harga_fix*$data2->qty);//-($biaya_lazada+$vat_lazada+$vat_pencairan);

                      $total_qty2 += $data2->qty;
                      $total_rims2 += $data2->retprc;
                      $total_harga_net2 += $data2->harga_fix;
                      $total_harga_net_qty2 += $data2->harga_fix*$data2->qty;
                      $total_komisi2 +=  round(($data2->harga_fix*5)/100*$data2->qty);
                      if($data2->harga_fix > $data2->retprc){
                        $total_selisih2x = $data2->harga_fix - $data2->retprc;
                        $penyesuaian2 = $data2->retprc*$data2->qty;
                      }else{
                        $total_selisih2x = 0;
                        $penyesuaian2 = $data2->harga_fix*$data2->qty;
                      }
                      $total_selisih2 += $total_selisih2x;
                      $total_penyesuaian2 += $penyesuaian2;                      

                    ?>

                   <tr style="border:1px solid #000;">
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                            echo date('d F Y', strtotime($data2->tanggal_waktu_order));
                        ?><br>
                        <label class='label' style='background-color:#f25656;'>&nbsp</label>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                            if($data2->tanggal_waktu_order_finish == "0000-00-00 00:00:00"){
                              echo "Belum Selesai";
                            }else{
                              echo date('d F Y', strtotime($data2->tanggal_waktu_order_finish));
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
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data2->sender;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data2->artikel;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data2->ukuran;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data2->qty;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                        //if($data->harga_before != "" || $data->harga_before > 0){?>
                          Rp. <?php echo number_format($data2->retprc,0,".","."); //echo number_format($data->harga_before,0,".",".");?>
                        <?php //}else{ 
                          //echo"Rp. ".number_format($data->retprc,0,".",".").""; 
                        //}?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none">
                        <?php if($data2->harga_before != "" || $data2->harga_before > 0){?>
                        <i style="text-decoration:line-through;">Rp. <?php echo number_format($data2->harga_before,0,".",".");?></i><br>Rp. <?php echo number_format($data2->harga_fix,0,".",".");?><?php }else{ echo"Rp. ".number_format($data2->harga_fix,0,".",".").""; }?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">Rp. 
                        <?php 
                        //if($data->harga_before == "" || $data->harga_before == 0){ 
                        //  echo "0"; 
                        //}else{ 
                          echo number_format(($data2->retprc-$data2->harga_fix)*$data2->qty,0,".",".")." <span style='color:red;'>(".round(($data2->retprc - $data2->harga_fix) / $data2->retprc * 100) * $data2->qty."%)</span>";
                        //}?> 
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        Rp. <?php echo number_format($data2->harga_fix,0,".",".");?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        Rp. <?php echo number_format($data2->harga_fix*$data2->qty,0,".",".");?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                      <?php if($data2->komisi_toko == ""){
                        echo "Rp.".number_format(($data2->harga_fix*5)/100*$data2->qty,0,".",".")."";
                      }else{
                        echo "Rp.".number_format($data2->komisi_toko*$data2->qty,0,".",".")."";
                      }?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        Rp. <?php echo number_format($total_selisihx,0,".",".");?>
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
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                        if($data2->harga_fix > $data2->retprc){
                          //$total_selisihx = $data->harga_fix - $data->retprc;
                          echo "<span style='color:red;'>Rp.".number_format($data2->retprc,0,".",".")."</span>";
                        }else{
                          echo "Rp.".number_format($data2->harga_fix,0,".",".");
                        }
                        ?>
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
                    <td style="border:1px solid #000;font-size: 14px;text-align: center;" colspan="6"><b>TOTAL</b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b><?php echo $total_qty2;?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_rims2,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_harga_net2,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;">
                      <b>Rp. <?php echo number_format($total_harga_net_qty2,0,".",".");?></b>
                    </td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_komisi2,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_selisih2,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_penyesuaian2,0,".",".");?></b></td>
                  </tr>
                </tfoot>
              </table>
              <br>
              <i style="font-size: 12px;"><label class="label label-danger">*Kolom merah</label> Pesanan dari bulan lalu (maksimal cek 1 tahun kebelakang) tapi masih belum selesai, karena status pembayaran belum dibayar oleh marketplace / masalah pada order atau sistem marketplace (tidak ikut closing bulan ini).<br><span style="color:red;">Komisi Toko sebesar 5%, dan akan ditransfer ke rekening supervisor</span><br><span style="color:red;">Harga Final Belum dikurangi komisi toko 5%</span></i>
            </div>

          </div>
      </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>