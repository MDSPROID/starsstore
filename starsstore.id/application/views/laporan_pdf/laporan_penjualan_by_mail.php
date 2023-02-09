<style type="text/css">
  body {
  font-family: Futura, "Trebuchet MS", Arial, sans-serif;
  line-height: 1.42857143;
  margin: 0;
}
table {
  border-spacing: 0;
  border-collapse: collapse;
}
td,
th {
  padding: 0;
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
          <?php $get_data_setting = for_header_front_end();?>
            <?php foreach($get_data_setting as $data):?>
              <center>
                <img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" style="margin-top:-10px;margin-bottom: -10px;" height="80">
              </center>
            <?php endforeach;?>
        </div>
        <div class="col-md-12">
          <center>
            <h3 style="margin-top: 0;">LAPORAN PENJUALAN MARKETPLACE</h3>
          </center>
        </div>
          <div class="col-md-12">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;border:1px solid #000;">
                    <tbody>
                      <tr>
                        <?php foreach($month as $y){ ?>
                        <td align="center" style="border:1px solid #000;">
                          <h3 style="margin-bottom: 0;">BULAN INI</h3><br><span style="font-size: 40px;"><b><?php echo $y->total_penjualan_bulan_ini?></b></span>
                        </td>
                        <?php }?>
                        <?php foreach($week as $y){ ?>
                        <td align="center" style="border:1px solid #000;">
                          <h3 style="margin-bottom: 0;">MINGGU INI</h3><br><span style="font-size: 40px;"><b><?php echo $y->total_penjualan_bulan_ini?></b></span>
                        </td>
                        <?php }?>
                        <?php foreach($kemarin as $y){ ?>
                        <td align="center" style="border:1px solid #000;">
                          <h3 style="margin-bottom: 0;">KEMARIN</h3><br><span style="font-size: 40px;"><b><?php echo $y->total_penjualan_bulan_ini?></b></span>
                        </td>
                        <?php }?>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td align='left' colspan="3" style="border:1px solid #000;">
                        <center>
                          <h3>PRODUK TERJUAL KEMARIN</h3>
                        </center>
                        <?php if(count($detail) == 0){ ?>
                        <p style="text-align: center">Tidak ada produk terjual hari kemarin!</p>
                        <?php }else{ ?>
                        <?php foreach($detail as $y){ ?>
                        <div>
                          <ul style="padding-left: 0;list-style: none;">
                            <li style="height:50px;margin-bottom: 40px;">
                              <img src="<?php echo $y->gambar?>" height="70" style="float:left !important;">
                              <h4 style="margin-bottom:0;font-weight:700;">
                                <span style="padding-left:5px;"><?php echo $y->nama_produk?></span><br>
                                <?php if($y->harga_before > 0 || $y->harga_before != ""){
                                  $disc = round(($y->harga_before - $y->harga_fix) / $y->harga_before * 100);
                                  echo "<s style='padding-left:5px;color:#949494;'>Rp. $y->harga_before</s><br>";
                                  echo "<span style='padding-left:5px;'>Rp. $y->harga_fix</span> <i style='background-color:red;color:white;padding:3px;font-size:12px;'>$disc%</i> <i style='background-color:#505050;color:white;padding:3px;font-size:12px;'>$y->buy_in</i>";
                                }else{
                                  echo "<span style='padding-left:5px;'>Rp. $y->harga_fix</span> <i style='background-color:#505050;color:white;padding:3px;font-size:12px;'>$y->buy_in</i>";
                                }?>
                              </h4>
                            </li>
                          </ul>
                        </div>
                        <?php }}?>
                        </td>
                      </tr>
                    </tfoot>
                </table>
              </div>
              <p>Pesan ini dikirim otomatis oleh sistem, harap tidak membalas email ini.<br>Best Regard,<br><br><br>Stars E-commerce</p>
            </div>
          </div>
          </div>
      </div>
    </div>
  </div>
</div>
</div>