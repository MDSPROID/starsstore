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

function printDivlabel(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     $(".print").hide();
     $(".warning-label").hide();
     window.print();   

     document.body.innerHTML = originalContents;
}
</script>
<style type="text/css">
    @media print {
      .warning-label{
        display: none;
      }
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

<body onload="printDivlabel();">
<div id="main-wrapper">
    <div class="row">
    <div class="row-inv">
        <div class="col-md-12 m-t-lg">
            <div class="panel panel-white">
                <div class="panel-bodyty" id="printableArea">
                    <div class="text-center"><label style="font-size: 20px;" class="label label-danger print" onclick="printDivlabel('printableArea')"><i class="glyphicon glyphicon-print"></i> Cetak</label></div>
                    <div class="post-inv">                                        
				        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="tab-content" style="padding: 0;">
                                  <div id="detail" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12" style="padding: 10px;margin-bottom:5px;border-bottom: 1px solid black;">
                                            <div style="margin-right:-10px;font-weight:bold;float:right;text-align: right;">Label Pengiriman<br>Kode Booking / Resi : <?php if(empty($kl->no_resi)){echo "-";}else{echo $kl->no_resi;}?></div>
                                            <?php $get_data_setting = for_header_front_end();?>
                                            <?php foreach($get_data_setting as $data):?>
                                                <div class="pull-left" style="margin-left: -10px;">
                                                    <img class="lazy" src="<?php echo base_url('assets/images/');?><?php echo $data->konten;?>" style="width:100px;display: initial;margin-bottom: 0px;">
                                                </div>
                                            <?php endforeach;?>
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-12" style="font-weight:bold;text-align: center;margin-bottom: 5px;margin-top: 5px;">NO. PESANAN<span style="margin-left: 5px;">:</span> <?php echo $kl->invoice?> (<?php echo $kl->buy_in?>)</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-xs-12" style="margin-top:5px;border-top: 1px solid black;margin-bottom: 10px;">
                                          <div class="row">
                                            <h5><b>PENGIRIM</b></h5>
                                            PT. Stars Internasional<br>Divisi E-commerce - 0821-3264-5489<br>Jl. Rungkut Asri Utara VI no. 2 Kali Rungkut, Surabaya Jawa Timur 60293
                                          </div>
                                        </div>
                                        <div class="col-md-12 col-xs-12" style="margin-top:5px;border-top: 1px solid black;margin-bottom: 10px;">
                                          <div class="row">
                                            <h5><b>PENERIMA</b></h5>
                                            <?php echo $kl->nama_lengkap?> - <?php echo $kl->no_telp?><br><?php echo $kl->alamat?>
                                          </div>
                                        </div>
                                        <table cellpadding="0" cellspacing="0" class="table table-striped table-hover re_border">
                                            <tr style="margin-top: 20px;font-size: 12px;border-top: 1px solid black;border-bottom: 1px solid black;">
                                                <th align="left" style="padding: 10px 10px 10px 0 !important;">PRODUK</th>
                                            </tr>
                                            <?php foreach($produk as $ft):

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
                                            ?>
                                            <tr> 
                                                <td class="yut" align="left" style="border-bottom: 1px solid black;padding-left: 0;">
                                                    <h4 style="margin-top:5px;margin-bottom: 0px;font-size: 12px;"><b><?php echo word_limiter($ft->nama_produk,4);?></b></h4>
                                                    <ul class="list-inline" style="margin-bottom:0;font-size: 14px;margin-top: 0;">
                                                        <li class="gf"><?php echo $ft->artikel?></li> | <?php echo $ukr?> | <li class="gf"><?php echo $ft->qty?> PSG</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                            <tr style="background-color: transparent;">
                                                <td colspan="2" align="left" style="padding-left: 0px;">
                                                    <h5 style="margin-top: 0;margin-bottom: 5px;">Catatan Pembeli</h5>
                                                    <i style="font-size: 14px;"><?php echo $kl->catatan_pembelian?></i><br>
                                                </td>
                                            </tr>
                                         </table>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>                                        
                    </div>
                </div>
                <h3 class="warning-label" style="text-align: center;color:red;display: none;"><b>Cek Kode Booking pada bagian pojok kanan atas jika ada, jangan bayar ke expedisi. cukup beri tahu kode booking tersebut.<br>Jika tidak ada kode, toko bayar ke expedisi terlebih dahulu. dan kantor pusat akan mengganti biaya tersebut dan sebutkan alamat toko anda ke expedisi, agar toko tidak menanggung biaya terlalu mahal.</b></h3>
            </div>
        <?php endforeach;?>
        </div>
    </div>
</div>
</div>
</body>