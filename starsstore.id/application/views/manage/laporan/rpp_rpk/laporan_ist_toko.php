<title>LAPORAN IST</title>
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
        <div id="IST_TOKO" class="col-md-12">
        <div class="row page-break">
          <div class="col-md-12">
            <h2 style="text-align: center;"><b>LAPORAN IST TOKO KE KODE EDP E-COMMERCE & MARKETPLACE</b></h2>
            <h4 style="margin: 5 0;">Tanggal : <?php echo date("d F Y", strtotime($tgl1));?> - <?php echo date("d F Y", strtotime($tgl2));?></h4>
            <h4 style="margin: 5 0;">Market : <?php echo $market;?></h4>
            <h4 style="margin: 5 0;">Status Pesanan : <?php echo $status2;?></h4>
            <h4 style="margin: 5 0;">Status Pembayaran : <?php echo $status1;?></h4>
            <h4 style="margin: 5 0;">EDP Toko : <?php echo $sender;?></h4>
            <h4 style="margin: 5 0;">Sort By : <?php if($terjual_by == "tgl_order"){ echo "Tanggal Order";}else{ echo "Tanggal Selesai Pesanan";}?></h4>
          </div>
          <div class="col-md-12 table-responsive" style="margin-top: 20px;"> 
            <?php 
            $this->load->model('sec47logaccess/rpp_rpk_adm');
            foreach($getStore as $store){
              $storeEdp = $store->kode_edp;
              //echo $storeEdp." - ".$marketx." - ".$tgl1." - ".$tgl2." - ".print_r($status1x)." - ".print_r($status2x);  
              if($terjual_by == "tgl_order"){
                $rekapOrder = $this->rpp_rpk_adm->get_order_for_comission_by_tgl_order($storeEdp,$tgl1,$tgl2,$status1x,$status2x,$marketx);
              }else{
                $rekapOrder = $this->rpp_rpk_adm->get_order_for_comission($storeEdp,$tgl1,$tgl2,$status1x,$status2x,$marketx);
              }
              echo "<h3 style='text-align:center;border:1px solid black;'>TOKO : ".$store->nama_toko." [".$store->kode_edp."]</h3>";
            ?> 
            <h3 style="text-align: center"><i style="font-size: 14px;"><span style="color:red;">Harap melakukan pemindahan artikel ke kode EDP yang sudah tertera dilaporan</span></i></h3>
            <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="border-top:1px solid black;">
              <thead>
                <tr style="border:1px solid #000;">
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Tanggal Order</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Nomor Invoice</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Pembelian Melalui</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">KODE EDP MARKETPLACE</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Artikel</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Size</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;">Qty</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Harga Barang</th>
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Harga Barang x QTY</th>                    
                    <th style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">Komisi Toko (5%)</th>
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
                    <td style="text-align:center;width:100px;border:1px solid #000;font-size: 12px;">
                      <?php 
                        if($data5->buy_in == "E-commerce"){
                          echo $data5->invoice;
                        }else{
                          echo $data5->no_order_pro;
                        }
                      ?>
                    </td>
                    <td style="text-align:center;width:100px;border:1px solid #000;font-size: 12px;">
                      <?php echo strtoupper($data5->buy_in);?>
                    </td>
                    <td style="text-align:center;width:100px;border:1px solid #000;font-size: 12px;">
                      <?php 
                        //if($data5->buy_in == "tokopedia"){
                        //  echo "10007";
                        //}else if($data5->buy_in == "shopee"){
                        //  echo "10006";
                        //}else if($data5->buy_in == "lazada"){
                        //  echo "10008";
                        //}else if($data5->buy_in == "blibli"){
                        //  echo "10009";
                        //}else if($data5->buy_in == "bukalapak"){
                        //  echo "10010";
                        //}else {
                          echo "10001";
                        //}
                      ?>
                    </td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo strtoupper($data5->artikel);?></td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data5->ukuran;?></td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data5->qty;?></td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">
                      <?php if($data5->harga_before != "" || $data5->harga_before > 0){?>
                        Rp. <?php echo number_format($data5->harga_before,0,".",".");?>
                      <?php }else{ 
                        echo"Rp. ".number_format($data5->harga_fix,0,".",".").""; 
                      }?>
                    </td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">
                      Rp. <?php echo number_format($data5->harga_fix*$data5->qty,0,".",".");?><br>
                    </td>
                    <td style="text-align:center;border:1px solid #000;font-size: 12px;display: none;">
                    <?php echo "Rp.".number_format($komisi3,0,".",".")."";?>
                    </td>
                </tr>
               <?php }?>
              </tbody>
              <tfoot style="display: table-row-group">
                <tr style="border:1px solid #000;">
                  <td style="border:1px solid #000;font-size: 12px;text-align: center;" colspan="6"><b>TOTAL</b></td>
                  <td style="text-align: center;border:1px solid #000;font-size: 12px;"><b><?php echo $total_pasang;?></b></td>
                  <td style="text-align: center;border:1px solid #000;font-size: 12px;display: none;"><b>Rp. <?php echo number_format($total_harga_barangx,0,".",".");?></b></td>
                  <td style="text-align: center;border:1px solid #000;font-size: 12px;display: none;"><b>Rp. <?php echo number_format($total_harga_barang_finalx,0,".",".");?></b></td>
                  <td style="text-align: center;border:1px solid #000;font-size: 12px;display: none;"><b>Rp. <?php echo number_format($total_komisi3,0,".",".");?></b></td>
                </tr>
              </tfoot>
            </table>
            <br><br><br>
            <?php }?>
            <br>
          </div>
        </div>
      </div>
      </div>
  </div>
</div>
</div>