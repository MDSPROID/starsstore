<title>Laporan Pengiriman</title>
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
              <img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" style="margin-top:-10px;margin-bottom: 10px;" height="30">
            <?php endforeach;?>
        </div>
        <div class="col-md-12">
          <h3 style="margin-bottom: 0px;margin-top: 0;">PT. STARS INTERNASIONAL</h3><br>
        </div>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4">
              <?php
                  if($status == "2hd8jPl613!2_^5"){
                    $stat = "Menunggu Pembayaran";
                  }else if($status == "*^56t38H53gbb^%$0-_-"){
                    $stat = "Pembayaran Diterima";
                  }else if($status == "Uywy%u3bShi)payDhal"){
                    $stat = "Dalam Pengiriman";
                  }else if($status == "ScUuses8625(62427^#&9531(73"){
                    $stat = "Diterima";
                  }else if($status == "batal"){
                    $stat = "Dibatalkan";
                  }else{
                    $stat = $status;
                  }

                  if($sortby == "tgl_selesai"){
                    $sortbyx = "Tanggal Selesai Order";
                  }else{
                    $sortbyx = "Tanggal Order";
                  }
                ?>
              <h5 style="margin-top:5px;">
                <span style="margin-right: 60px;">Tanggal</span>: <?php echo date('d F Y', strtotime($tgl1));?> - <?php echo date('d F Y', strtotime($tgl2));?><br>
                <span style="margin-right: 5px;">Status Pesanan </span> : <?php echo $stat?><br>
                <span style="margin-right: 26px;">Status Bayar</span> : <?php echo $bayar?><br>
                <span style="margin-right: 30px;">Marketplace</span> : <?php echo $market?><br>
                <span style="margin-right: 60px;">Sort By</span> : <?php echo $sortbyx?>
              </h5><br>
              <h3 style="text-align: center;">LAPORAN PENGIRIMAN</h3>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
                    <thead>
                      <tr style="background-color:#1c2d3f;border: 1px solid #000;">
                        <th style="text-align:center;border: 1px solid #000;font-size: 14px;">Tanggal</th>
                        <th style="text-align:center;border: 1px solid #000;font-size: 14px;">Invoice</th>
                        <th style="text-align:center;border: 1px solid #000;font-size: 14px;">Alamat</th>
                        <th style="text-align:center;border: 1px solid #000;font-size: 14px;">Layanan</th>
                        <th style="text-align:center;border: 1px solid #000;font-size: 14px;">Tarif (Click)</th>
                        <th style="text-align:center;border: 1px solid #000;font-size: 14px;">Tarif (Actual)</th>
                        <th style="text-align:center;border: 1px solid #000;font-size: 14px;">Selisih Tarif (Click & Actual)</th>
                        <th style="text-align:center;border: 1px solid #000;font-size: 14px;">Status Order</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                      $tc = 0;
                      $tr = 0;
                      $yy = 0;
                      foreach($get_list as $g){
                      if(empty($g->actual_tarif)){

                      }else{
                        $yy += $g->tarif - $g->actual_tarif;
                      }

                      $tarif = $g->tarif;
                      $act   = $g->actual_tarif;
                      $tc +=($tarif);
                      $tr +=($act);
                      $invoice = $g->invoice
                      ?>
                      <tr>

                        <td style="text-align:center;border: 1px solid #000;font-size: 10px;">
                        <?php 
                          if($sort_by == "tgl_order"){
                            echo date("d/m/Y", strtotime($g->tanggal_order));
                          }else{
                            echo date("d/m/Y", strtotime($g->tanggal_order_finish));
                          }
                        ?>
                        </td>
                        <td style="border: 1px solid #000;"><span style='font-size: 12px;font-weight:bold;'><?php echo $g->invoice?><br>[ <?php echo $g->buy_in?> ]<br><br>Resi : <?php echo $g->no_resi?><br><br>Dikirim Oleh :<br> <?php echo $g->sender?></span></td>
                        <td style="text-align:center;border: 1px solid #000;font-size: 10px;"><?php echo $g->alamat;?></td>
                        <td style="text-align:center;border: 1px solid #000;font-size: 12px;"><?php echo $g->layanan;?></td>
                        <td style="text-align:center;border: 1px solid #000;font-size: 12px;">
                        <?php 
                        if($g->tarif == "gratis" || $g->tarif == "" || $g->tarif == 0){
                          echo "".$g->tarif."<br><label class='label label-primary'>Gratis Ongkir</label>";
                        }else{
                          echo "Rp. ".number_format($g->tarif,0,".",".")."";
                        }
                        ?>
                        </td>
                        <td style="text-align:center;border: 1px solid #000;font-size: 12px;">
                        <?php 
                          if(empty($g->actual_tarif)){
                            echo "Rp. 0";
                          }else{
                            echo "Rp. ".number_format($g->actual_tarif,0,".",".")."";
                          }
                        ?>
                        </td>
                        <td style="text-align:center;border: 1px solid #000;font-size: 12px;">
                        <?php 
                          if(empty($g->actual_tarif)){
                            echo "Rp. 0";
                          }else{
                            $t = $g->tarif - $g->actual_tarif; echo "Rp. ".number_format($t,0,".",".")."";
                          }
                          ?>
                        </td>
                        <td style="text-align:center;border: 1px solid #000;font-size: 12px;">
                          <?php 
                            if($g->status == "2hd8jPl613!2_^5"){
                              echo "Menunggu Pembayaran";
                            }else if($g->status == "*^56t38H53gbb^%$0-_-"){
                              echo "Pembayaran Diterima";
                            }else if($g->status == "Uywy%u3bShi)payDhal"){
                              echo "Dalam Pengiriman";
                            }else if($g->status == "ScUuses8625(62427^#&9531(73"){
                              echo "Diterima";
                            }else if($g->status == "batal"){
                              echo "Dibatalkan";
                            }
                          ?>
                        </td>
                      </tr>
                      <?php }?>
                    </tbody>
                    <tfoot>
                      <tr style="background-color:#34425a;border: 1px solid #000;">
                        <th style="text-align:right;border: 1px solid #000;" colspan="4"></th>
                        <th style="text-align:center;border: 1px solid #000;">Rp. <?php echo number_format($tc,0,".",".");?></th>
                        <th style="text-align:center;border: 1px solid #000;">Rp. <?php echo number_format($tr,0,".",".");?></th>
                        <th style="text-align:center;border: 1px solid #000;">Rp. <?php echo number_format($yy,0,".",".");?></th>
                        <th style="text-align:center;border: 1px solid #000;"></th>
                      </tr>
                    </tfoot>
                </table>
              </div>              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>