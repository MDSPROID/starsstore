<html>
<head>
<title>Laporan Pengiriman</title>
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
<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
      <div class="row">
          <div class="col-md-12">
            <h2 style="text-align: center;"><b>LAPORAN PENGIRIMAN</b></h2>
            <h4 style="margin: 5 0;">Tanggal : <?php echo date("d F Y", strtotime($tgl1));?> - <?php echo date("d F Y", strtotime($tgl2));?></h4>
            <h4 style="margin: 5 0;">Market : <?php echo $market;?></h4>
            <h4 style="margin: 5 0;">Status Pesanan : <?php echo $status;?></h4>
            <h4 style="margin: 5 0;">Status Pembayaran : <?php echo $bayar;?></h4>
            <h4 style="margin: 5 0;">Ongkir Ditanggung : <?php if($ditanggung == "dari_penjualan"){echo "Dipotong langsung dari penjualan oleh marketplace";}else{echo $ditanggung;}?></h4>
            <h4 style="margin: 5 0;">Sort By : <?php if($sort_by == "tgl_order"){ echo "Tanggal Order";}else{ echo "Tanggal Selesai Pesanan";}?></h4>
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

                foreach($get_list as $data):
                  if($data->actual_tarif != ""){
                    $yy += $data->actual_tarif - $data->tarif;                    
                  }

                  $tarif = $data->tarif;
                  $act   = $data->actual_tarif;
                  $tc +=($tarif);
                  $tr +=($act);
                ?>
               <tr>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php 
                    if($sort_by == "tgl_order"){
                      echo date("d/m/Y", strtotime($data->tanggal_order));
                    }else{
                      echo date("d/m/Y", strtotime($data->tanggal_order_finish));
                    }
                  ?>
                  </td>
                  <td  style="text-align:center;border:1px solid #000;font-size: 12px;"><span style='font-size: 12px;font-weight:bold;'><?php echo $data->invoice?><br>[ <?php echo $data->buy_in?> ]<br><br>Resi : <?php echo $data->no_resi?><br><br>Dikirim Oleh :<br> <?php echo $data->nama_toko?> [<?php echo $data->kode_edp?>]</span></td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $data->alamat;?></td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;"><span style="font-size: 10px;"><?php echo $data->layanan;?></span></td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php 
                    //if($data->tarif == "gratis" || $data->tarif == "" || $data->tarif == 0){
                    //  echo "".$data->tarif."<br><label style ='font-size:10px;' class='label label-primary'>Gratis Ongkir</label>";
                    //}else{
                      echo "Rp. ".number_format($data->tarif,0,".",".");
                    //}
                  ?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php 
                    if($data->actual_tarif == ""){
                      echo "Belum Diinput";
                    }else{
                      echo "Rp. ".number_format($data->actual_tarif,0,".",".");
                    }
                  ?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php
                    if($data->actual_tarif == ""){
                      echo "Belum Diinput";
                    }else{
                      $t = $data->actual_tarif - $data->tarif; echo "Rp. ".number_format($t,0,".",".")."";
                    }
                    ?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                    <?php 
                      if($data->ongkir_ditanggung == "gratis"){
                        echo "Gratis Ongkir";
                      }else if($data->ongkir_ditanggung == "kantor"){
                        echo "Kantor";
                      }else if($data->ongkir_ditanggung == "toko"){
                        echo "Toko";
                      }else{
                        echo "Dipotong Langsung dari Penjualan oleh marketplace";
                      }
                    ?>
                  </td>
                  <td style="text-align:center;border:1px solid #000;font-size: 12px;">
                  <?php

                    if($data->status == "2hd8jPl613!2_^5"){
                     echo "<label class='label label-warning'>Menunggu Pembayaran</label>";
                    }else if($data->status == "*^56t38H53gbb^%$0-_-"){
                      echo "<label class='label label-primary'>Pembayaran Diterima</label>";
                    }else if($data->status == "Uywy%u3bShi)payDhal"){
                      echo "<label class='label label-primary'>Dalam Pengiriman</label>";
                    }else if($data->status == "ScUuses8625(62427^#&9531(73"){
                      echo "<label class='label label-success'>Diterima</label>";
                    }else if($data->status == "batal"){
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
</div>
</div>
</html>