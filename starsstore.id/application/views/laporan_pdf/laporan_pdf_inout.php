<title>Laporan Barang Masuk & Keluar</title>
<style type="text/css">
/*************************** END Frontend ************************************/

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
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}
</style>
<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
    <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
      <div class="row">
          <div class="col-md-12">
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
                        <th style="text-align:center;border:1px solid #000;">TANGGAL</th>
                        <th style="text-align:center;border:1px solid #000;">NO. INV</th>
                        <th style="text-align:center;border:1px solid #000;">PASANG</th>
                        <th style="text-align:center;border:1px solid #000;">RUPIAH</th>
                        <th style="text-align:center;border:1px solid #000;">DARI</th>
                        <th style="text-align:center;border:1px solid #000;">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tc = 0;
                    $tr = 0;
                    if(count($get_list) > 0){
                    foreach($get_list as $data):
                      if($data->jenis == "masuk"){
                      //$tarif = $data->tarif;
                      //$act   = $data->actual_tarif;
                      $tc +=($data->pasang);
                      $tr +=($data->rupiah);

                      $idinvoice = $data->invoice;
                      $get_inv = $this->inout_adm->get_list_inv($idinvoice);
                      $invxx = array();
                      foreach($get_inv as $k){
                        $invxx[] = $k->inv;
                      }
                      $invx = implode(', ',$invxx);
                    ?>
                   <tr style="border:1px solid #000;">
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;"><?php echo date('d/m/y',strtotime($data->tanggal));?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;"><?php echo $data->invoice;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;"><?php echo $data->pasang;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;">Rp. <?php echo number_format($data->rupiah,0,".",".");?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;"><?php echo $data->source;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;"><?php echo $data->keterangan;?><br><span style="font-size: 8px;">No. Pesanan : <?php echo $invx?></span></td>                  
                  </tr>
                 <?php }endforeach;}else{ echo "<tr><td style='text-align:center;border:1px solid #000;' colspan='7'>Tidak ada barang masuk</td></tr>";}
                  ?>
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
                <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
                <thead>
                    <tr style="border:1px solid #000;">
                        <th style="text-align:center;border:1px solid #000;">TANGGAL</th>
                        <th style="text-align:center;border:1px solid #000;">NO. INV</th>
                        <th style="text-align:center;border:1px solid #000;">PASANG</th>
                        <th style="text-align:center;border:1px solid #000;">RUPIAH</th>
                        <th style="text-align:center;border:1px solid #000;">KE</th>
                        <th style="text-align:center;border:1px solid #000;">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tc = 0;
                    $tr = 0;
                    if(count($get_list) > 0){
                    foreach($get_list as $data):
                      if($data->jenis == "keluar"){
                      //$tarif = $data->tarif;
                      //$act   = $data->actual_tarif;
                      $tc +=($data->pasang);
                      $tr +=($data->rupiah);
                    ?>
                   <tr>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;"><?php echo date('d/m/y',strtotime($data->tanggal));?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;"><?php echo $data->invoice;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;"><?php echo $data->pasang;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;">Rp. <?php echo number_format($data->rupiah,0,".",".");?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;"><?php echo $data->source;?></td>
                      <td style="text-align:center;border:1px solid #000;font-size: 10px;"><?php echo $data->keterangan;?></td>                  
                  </tr>
                 <?php }endforeach;}else{ echo "<tr><td style='text-align:center;' colspan='7'>Tidak ada barang masuk</td></tr>";}
                  ?>
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
      </div>
    </div>
  </div>
</div>
</div>