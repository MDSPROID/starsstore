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
    display: none;
  }
  .cover_laporan{
    display: none;
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
$totalsemuapendingan = 0;
$totalpendingbulanlaludanontime = 0;   
$pendingbulanlalu = 0;
$ontime = 0;
$total_harga_barang = 0; // buat cover penjualan closing
foreach($getBiaya as $datax){
    $ontime += $datax->qty;
  $total_harga_barang += ($datax->harga_fix*$datax->qty); // cover penjualan closing
}
?>
<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
    <div class="tab-content">
      <div class="row">
          <div class="col-md-12">
          <div class="row">
              <div class="col-md-12">
                <h2 style="text-align: center;"><b>LAPORAN BIAYA - BIAYA MARKETPLACE</b></h2>
                <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr style="border:none;">
                        <th colspan="6" style="border:none;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border:none;">
                        <td colspan="3" style="text-align: right;border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">PERIODE : <?php echo date('d F Y', strtotime($tgl1));?> - <?php echo date('d F Y', strtotime($tgl2));?></h4></td>
                    </tr>
                    <tr style="border:none;">
                        <td colspan="3" style="text-align: right;border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">MARKETPLACE : <?php echo $marketx;?></h4></td>
                        
                    </tr>
                    <tr style="border:none;">
                      <td colspan="3" style="border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">STATUS PESANAN : <?php echo $status2;?></td>
                       <td colspan="3" style="text-align: right;border:none;"><h4 style="margin-top: 0;margin-bottom: 0;">STATUS BAYAR: <?php echo $status1?></h4></td>
                    </tr>
                </tbody>
                </table>
              </div>

            <?php if($marketx == "bukalapak"){?>
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
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Nomor Invoice</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Marketplace</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Artikel</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Size</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Qty</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga x QTY</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Keterangan Biaya 1</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Biaya 1</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Keterangan Biaya 2</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Biaya 2</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Keterangan Biaya 3</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Biaya 3</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Keterangan Biaya 4</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Biaya 4</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Keterangan Biaya 5</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Biaya 5</th>
                      <th style="text-align:center;border:1px solid #000;font-size: 12px;">Harga Final</th>
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
                    foreach($getBiaya as $data){

                      if($data->harga_before != "" || $data->harga_before > 0){
                        $diskon = ($data->harga_before-$data->harga_fix) * $data->qty;
                      }else{ 
                        $diskon = "0";
                      }

                      if($data->komisi_toko == ""){
                        $komisi1 = (($data->harga_fix*5)/100) + (($data->harga_fix*1)/100);
                      }else{
                        $komisi1 = $data->komisi_toko;
                      }

                      $total_diskon += $diskon; //($data->harga_before-$data->harga_fix) * $data->qty;
                      $total_komisi += round($komisi1);
                      //$total_disc_dan_biaya = $total_diskon;// + $total_biaya_marketplace;
                      $total_qty += $data->qty;
                      $total_harga_barang += ($data->harga_fix*$data->qty);//-($biaya_lazada+$vat_lazada+$vat_pencairan);
                    ?>

                   <tr style="border:1px solid #000;">
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                        <?php 
                            echo date('d F Y', strtotime($data->tanggal_waktu_order));
                        ?>
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
                      </td>
                      <td style="text-align:center;width:100px;border:1px solid #000;font-size: 12px;">
                        <?php echo $data->buy_in?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data->artikel;?></td>
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
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">Rp. 
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
                        Rp. <?php echo number_format($data->harga_fix,0,".",".");?>
                      </td>
                      <td style="text-align:center;border:1px solid #000;font-size: 12px;">
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
                    <td style="border:1px solid #000;font-size: 14px;text-align: center;" colspan="6"><b>TOTAL</b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b><?php echo $total_qty;?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_harga_barang+$total_diskon,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_diskon,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>
                      Rp. <?php echo number_format($total_harga_barang,0,".",".");?>
                    </b>
                    </td>
                    <td style="text-align: center;border:1px solid #000;font-size: 14px;"><b>Rp. <?php echo number_format($total_komisi,0,".",".");?></b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;display: none;"><b>Rp. <?php echo number_format($total_biaya_marketplace,0,".",".");?></b></td>
                    <td rowspan="2" style="vertical-align: middle !important;border:1px solid #000;font-size: 16px;text-align: center;display: none;"><b>Rp. <?php echo number_format($total_harga_barang - $total_biaya_marketplace,0,".",".");?></b></td>
                  </tr>
                  <tr style="border:1px solid #000;display: none;">
                    <td style="border:1px solid #000;font-size: 12px;text-align: center;" colspan="7"></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Penjualan Bersih</b></td>
                    <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b>Rp. <?php echo number_format($total_harga_barang,0,".",".");?></b><input type="hidden" name="total_harga_barang" placeholder="0"  class="total_harga_barang" value="<?php echo $total_harga_barang?>"><input type="hidden" name="total_komisi" placeholder="0"  class="total_komisi" value="<?php echo round($total_komisi);?>"></td>
                  </tr>                
                  <?php if($periodex = $periode['periode']){

                  }else{?>
                  <tr style="border:1px solid #000;">
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
            <?php }?>
          </div>
      </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>