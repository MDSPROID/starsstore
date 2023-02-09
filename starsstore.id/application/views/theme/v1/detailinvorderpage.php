<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1472453182816875');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1472453182816875&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<script src="<?php echo base_url('assets/global/jquery-3.1.1.min.js');?>"></script>
<script src="<?php echo base_url('assets/global/JQuery.min.js');?>"></script>
<link href="<?php echo base_url('assets/manage/css/bootstrap.css');?>" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function(){
    window.onload = function() { 
        window.print();   
    }
});

function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     $(".print").hide();
     window.print();   

     document.body.innerHTML = originalContents;
}
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
        border:1px solid black !important;
    }
    .nav-tabs > li > a{
        background-color: transparent;
    }
    .tab-content {
    padding: 0px;
    }
</style>
<?php 
    foreach($produk as $tge){
    }
?>
<?php foreach($detailorder as $kl):
    $sts = $kl->status;
    $a = $this->encrypt->encode($kl->no_order_cus); 
    $b = base64_encode($a);
    if($sts == "2hd8jPl613!2_^5"){
        $statos = "<label class='label label-warning njr'><i class='glyphicon glyphicon-time'></i> Menunggu Pembayaran</label>";
        $retur = "<a href='retur/$b'><label class='label retur_btn label-primary'>Retur</label></a>";
    }else if($sts == "*^56t38H53gbb^%$0-_-"){
        $statos = "<label class='label label-primary njr'><i class='glyphicon glyphicon-ok'></i> Pembayaran diterima</label>";
        $retur = "";
    }else if($sts == "Uywy%u3bShi)payDhal"){
        $statos = "<label class='label label-primary njr'><i class='glyphicon glyphicon-send'></i> Dalam Pengiriman</label>";
        $retur = "";
    }else if($sts == "ScUuses8625(62427^#&9531(73"){
        $statos = "<label class='label label-success njr'><i class='glyphicon glyphicon-ok-sign'></i> Diterima</label>";
        $retur = "<a href='retur'><label class='label label-primary'>Retur</label></a>";
    }else if($sts == "batal"){
        $statos = "<label class='label label-danger njr'><i class='glyphicon glyphicon-remove'></i> Dibatalkan</label>";
        $retur = "";
    }
?>

<body onload="printDiv();">
<div id="main-wrapper">
    <div class="row">
    <div class="row-inv">
        <div class="col-md-12 m-t-lg">
            <div class="panel panel-white">
                <div class="panel-bodyty">
                    <div class="post-inv" id="printableArea"> 
                        <div class="row">                                       
                            <?php 
                                foreach($produk as $ft){ }
                                $toko = $tokopengirim->row_array();
                                $maxword = 4;
                                //$d = $this->mitra_m21->get_data_transaksi($id_transaksi);
                                $kode_transaksi = md5($kl->invoice);
                                $telp = substr($tge->no_telp, -4, $maxword);
                                echo "  <h4 style='text-align:center;margin-top:0;margin-bottom:10px;'><b>STARS OFFICIAL STORE</b></h4>
                                        <div style='border-bottom:2px dashed black;width:100%;margin-bottom:10px;'></div>
                                        <span>Invoice : ".$kl->invoice." (".$kl->buy_in.")</span><br>
                                        <span>Tanggal : ".date('d/m/Y', strtotime($kl->tanggal_waktu_order))."</span><br>
                                        <h5 style='margin-bottom:0;'><b>CUSTOMER</b></h5>
                                        ".strtoupper($tge->nama_lengkap)."<br>
                                        *** *** ".$telp."<br>
                                    ";
                                echo "<h5 style='margin-bottom:0;'><b>PRODUK</b></h5>";
                                foreach($produk as $ft){ 
                                    if($ft->harga_before > 0 || $ft->harga_before != ""){
                                        $d = round(($ft->harga_before - $ft->harga_fix) / $ft->harga_before * 100);
                                        $discft = "<label class='disc' style='color:red;'>$d%</label>";
                                    }else{
                                        $discft ="";
                                    }

                                    if($ft->ukuran == ""){
                                        $ukr = "";
                                    }else{
                                        $ukr = "<span class='gf'><b>Ukuran : $ft->ukuran</b></span>";
                                    }

                                    if($ft->warna == ""){
                                        $wrn = "";
                                    }else{
                                        $wrn = "<li class='gf'>Warna : $ft->warna</li>";
                                    }

                                    if($ft->harga_before == 0 || $ft->harga_before == ""){
                                        $hg_before = "";
                                    }else{
                                        $hg_before = "<s class='h_b' style='color:red;'>Rp. ".number_format($ft->harga_before,0,".",".")."</s>";
                                    }
                                    echo "<h5><ul style='padding-left:0;'><li>".$ft->artikel."</li>".$ukr." <span class='gf'><b>( ".$ft->qty." Psg )</b></span> <span style='float:right'>Rp. ".number_format($ft->harga_fix * $ft->qty,0,".",".")."</span></h5>";
                                }
                                if($kl->tarif == "gratis" || $kl->tarif == 0){
                                    $ongkir = "Gratis Pengiriman Rp. 0";
                                }else{
                                    $ongkir = "Rp. ".number_format($kl->tarif,0,".",".");
                                }
                                echo " 
                                        <div style='border-bottom:1px dashed black;width:100%;margin-bottom:10px;'></div>
                                        <h5>TOTAL PRODUK<span style='float:right'>Rp. ".number_format($ft->subtotal,0,".",".")."</span></h5>
                                        <div style='margin-bottom:10px;'>ONGKIR <span style='float:right;margin-bottom'>".$ongkir."</span></div>
                                        <div style='border-bottom:1px dashed black;width:100%;margin-bottom:10px;'></div>
                                        <div><b>GRAND TOTAL <span style='float:right;'>Rp. ".number_format($ft->total_belanja,0,".",".")."</span></b></div><br>

                                        T-Enc : ".$kode_transaksi."<br>
                                        <i style='font-size:10px;'>Dengan dikeluarkan struk ini, Pembeli telah menyetujui syarat dan ketentuan toko stars.</i><br><br>
                                        <h5>Follow Instagram Kami @stars.footwear<br><br>Tokopedia : www.tokopedia.com/starsofficial<br>Shopee : www.shopee.co.id/starsallthebest<br>Lazada : www.lazada.co.id/shop/stars-official-store<br>Bukalapak : www.bukalapak.com/u/starsallthebest<br>Blibli Dewasa : www.blibli.com/merchant/stars-official-store/STO-60038<br>Blibli Anak : www.blibli.com/merchant/stars-kids-official-store/STK-60038<br> Website Official : www.starsstore.id</h5>
                                        ";
                            ?>
                        </div>
				        <div class="row" style="display: none;">
                            <div class="col-md-12 col-xs-12" style="margin-bottom: 30px;">
                                <h2>#<?php echo $kl->invoice?> (<?php echo $kl->buy_in?>) <label style="font-size: 20px;" class="pull-right label label-danger print" onclick="printDiv('printableArea')"><i class="glyphicon glyphicon-print"></i> Cetak</label></h2>
                                <table>
                                <tbody>
                                    <tr>
                                        <th>Tanggal Pesanan </th>
                                        <td>: <?php echo date('d F Y H:i:s', strtotime($kl->tanggal_waktu_order));?></td>
                                    </tr>
                                    <tr>
                                        <th>Status </th>
                                        <td>: <?php echo $statos;?></td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <ul class="nav nav-tabs" style="    border-bottom: 1px solid #c9c9c9;">
                                  <li class="active"><a data-toggle="tab" href="#detail">Detail</a></li>
                                  <li><a data-toggle="tab" href="#track">Lacak Pesanan</a></li>
                                  <li><a data-toggle="tab" href="#history">History</a></li>
                                </ul>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <h3><?php echo $tge->nama_lengkap?></h3>
                                        <?php echo $kl->alamat?><br>
                                        <?php echo $tge->no_telp?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12"><hr style="border-style: solid;"></div>
                            <div class="col-md-12 col-xs-12">
                                <div class="tab-content" style="padding: 0;">
                                  <div id="detail" class="tab-pane fade in active">
                                    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover re_border">
                                        <tr style="margin-top: 20px;font-size: 12px;">
                                            <th align="left" style="width:100px;padding: 10px !important;">Gambar</th>
                                            <th align="left" style="padding: 10px !important;">Keterangan</th>
                                            <th align="center" style="width:80px;padding: 10px !important;">Quantity</th>
                                            <th style="width:100px;text-align: right;padding: 10px !important;">Harga Item</th>
                                            <th style="width:100px;text-align: right;padding: 10px !important;">Subtotal</th>
                                        </tr>
                                        <?php foreach($produk as $ft):
                                            if($ft->harga_before > 0 || $ft->harga_before != ""){
                                                $d = round(($ft->harga_before - $ft->harga_fix) / $ft->harga_before * 100);
                                                $discft = "<label class='disc' style='color:red;'>$d%</label>";
                                            }else{
                                                $discft ="";
                                            }

                                            if($ft->ukuran == ""){
                                                $ukr = "";
                                            }else{
                                                $ukr = "<li class='gf'>Ukuran : $ft->ukuran</li>";
                                            }

                                            if($ft->warna == ""){
                                                $wrn = "";
                                            }else{
                                                $wrn = "<li class='gf'>Warna : $ft->warna</li>";
                                            }

                                            if($ft->harga_before == 0 || $ft->harga_before == ""){
                                                $hg_before = "";
                                            }else{
                                                $hg_before = "<s class='h_b' style='color:red;'>Rp. ".number_format($ft->harga_before,0,".",".")."</s>";
                                            }
                                        ?>
                                        <tr> 
                                            <td class="yut" align="left" style="width:100px;border-bottom: 1px solid #ccc;">
                                                <img src="<?php echo $ft->gambar?>" onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" width="55">
                                            </td>
                                            <td class="yut" align="left" style="border-bottom: 1px solid #ccc;">
                                                <h4 style="margin-top:10px;margin-bottom: 10px;font-size: 12px;"><b><?php echo word_limiter($ft->nama_produk,4);?></b></h4>
                                                <ul class="list-inline" style="font-size: 14px;margin-top: 0;">
                                                    <li class="gf"><?php echo $ft->artikel?></li> | <?php echo $wrn?> | <?php echo $ukr?>
                                                </ul>
                                            </td>
                                            <td class="yut" style="font-size: 12px;border-bottom: 1px solid #ccc;" align="left"><?php echo $ft->qty?> pasang
                                            </td>
                                            <td class="yut" style="border-bottom: 1px solid #ccc;" align="right">  
                                              <span style="font-size: 12px;"><?php echo $hg_before?><br><harga>Rp. <?php echo number_format($ft->harga_fix,0,".",".");?></harga><br><?php echo $discft?></span>
                                            </td>
                                            <td class="yut" style="font-size: 12px;border-bottom: 1px solid #ccc;" align="right">Rp. <?php echo number_format($ft->harga_fix * $ft->qty,0,".",".")?></td>
                                        </tr>
                                        <?php endforeach;?>
                                        <tr style="background-color: transparent;">
                                            <td colspan="2" align="left">
                                                <h3>Catatan Pembeli</h3>
                                                <i style="font-size: 14px;"><?php echo $kl->catatan_pembelian?></i><br><br>
                                                <i style="font-size: 10px;">Dengan dikeluarkan invoice ini, Pembeli telah menyetujui syarat dan ketentuan toko stars.</i>
                                            </td>
                                            <td colspan="3" align="right" style="font-size: 12px;">
                                                Sub-Total : Rp. <?php echo number_format($ft->subtotal,0,".",".")?><br>
                                                Voucher : 
                                                <?php if(empty($kl->voucher)){
                                                    echo "-";
                                                }else{
                                                    echo "<i class='cou'>$kl->voucher</i>";
                                                }?><br>
                                                Ongkir : 
                                                <?php if($kl->tarif == "gratis" || $kl->tarif == 0){?>
                                                    <?php echo "<b>Gratis Pengiriman</b>";?>
                                                <?php }else{?>
                                                    Rp. <?php echo number_format($kl->tarif,0,".",".")?>
                                                <?php }?><br>
                                                <span style="display: none">Kode unik : <?php if($ft->kode_pembayaran == ""){ echo "-"; }else{ echo  'Rp '.$ft->kode_pembayaran;}?><br></span>
                                                <h2 style="margin-top: 5px;"><?php 
                                                    if($kl->action_voucher == ""){
                                                        echo "Rp. ".number_format($ft->total_belanja,0,".",".")."";    
                                                    }else{
                                                        echo "Rp. ".number_format($ft->total_belanja,0,".",".")."";
                                                    }
                                                    ?>
                                                </h2>
                                            </td>
                                        </tr>
                                     </table>
                                  </div>
                                  <div id="track" class="tab-pane fade">
                                    <h4 style="margin-top: 0px;">No Resi : <?php echo $tge->no_resi?><br>Expedisi : <?php echo $kl->layanan?></h4>
                                     <table class="table table-striped table-hover re_border" style="margin-bottom: 0;width:100%;margin-top: 20px;padding:10px;background-color: #f5f5f5;font-size: 12px;">
                                        <tr>
                                            <th style="padding: 10px !important;">Keterangan</th>
                                            <th style="padding: 10px !important;">Tanggal</th>
                                            <th style="padding: 10px !important;">Status</th>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px !important;"></td>
                                            <td style="padding: 10px !important;"></td>
                                            <td style="padding: 10px !important;"></td>
                                        </tr>
                                    </table>
                                  </div>
                                  <div id="history" class="tab-pane fade">
                                    <table class="table table-striped table-hover re_border" style="margin-bottom: 0;width:100%;padding:10px;background-color: #f5f5f5;font-size: 12px;">
                                        <tr>
                                            <th style="padding: 10px !important;">#</th>
                                            <th style="padding: 10px !important;">Keterangan</th>
                                            <th style="padding: 10px !important;">Tanggal</th>
                                            <th style="padding: 10px !important;">Status</th>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px !important;">1</td>
                                            <td style="padding: 10px !important;">Pesanan Dibuat</td>
                                            <td style="padding: 10px !important;"><?php echo date('d F Y H:i:s', strtotime($kl->tanggal_waktu_order));?></td>
                                            <td style="padding: 10px !important;"><label class="label label-default">Pending</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px !important;">2</td>
                                            <td style="padding: 10px !important;">Pembayaran Diterima</td>
                                            <td style="padding: 10px !important;"><?php echo date('d F Y H:i:s', strtotime($kl->tanggal_waktu_order));?></td>
                                            <td style="padding: 10px !important;"><label class="label label-default">Pembayaran Terverifikasi</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px !important;">3</td>
                                            <td style="padding: 10px !important;">Pesanan Dikirim</td>
                                            <td style="padding: 10px !important;">-</td>
                                            <td style="padding: 10px !important;"><label class="label label-default">Pending</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px !important;">4</td>
                                            <td style="padding: 10px !important;">Pesanan Diterima</td>
                                            <td style="padding: 10px !important;"><?php if($kl->tanggal_waktu_order_finish == "0000-00-00 00:00:00"){ echo "-";}else{ echo date('d F Y H:i:s', strtotime($kl->tanggal_waktu_order_finish)); }?></td>
                                            <td style="padding: 10px !important;"><label class="label label-default" style="color:green;">Diterima</td>
                                        </tr>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>                                        
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        </div>
    </div>
</div>
</div>
</body>