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
      .col-md-2{
        width: 16.66666667%; 
      }
      .col-md-10{
        width: 83.33333333%;
      }
    }

    td, th {
        padding: 5px;
    }
    .njr{
        padding: 8px;
    }
    .nav-tabs > li > a{
        background-color: transparent;
    }
    .tab-content {
    padding: 0px;
    }
</style> 
<script type="text/javascript">
$(function(){
  // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
  var baseURL = window.location.origin + '/';
  $('#sender').autocomplete({
      serviceUrl: baseURL + 'trueaccon2194/order/searchstore',
      onSelect: function (res) {
        $('.sender').val(''+res.kode_toko); // membuat id 'v_jurusan' untuk ditampilkan
      }
  });
});
</script>
<div class="page-title">
  <h3>Detail Order
    <?php 
      if($this->session->flashdata('success')):?>
        <label style="font-size: 12px;position: absolute;margin-left: 10px;padding: 5px 5px;font-weight:500;" class="label label-success"><?php echo $this->session->flashdata('success')?></label>
      <?php endif?>
      <?php 
      if($this->session->flashdata('error')):?>
        <label style="font-size: 12px;position: absolute;margin-left: 10px;padding: 5px 5px;font-weight:500;" class="label label-danger"><?php echo $this->session->flashdata('error')?></label>
    <?php endif?>
  </h3>
  <div class="page-breadcrumb">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('trueaccon2194/info_type_user_log')?>">Home</a></li>
      <li><a href="<?php echo base_url('trueaccon2194/order/')?>">Order</a></li>
      <li class="active">Detail Order</li>
    </ol>
  </div>
</div>
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
<div id="main-wrapper">
    <div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
        <div class="addresi">
            <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="input-group">
                    <input type="text" name="resi" class="form-control" id="resi" placeholder="Masukkan No. Resi" value="<?php echo $kl->no_resi?>">
                    <input type="hidden" name="email" class="email_and_ex" value="<?php echo $kl->email?>|<?php echo $kl->layanan?>">
                    <span class="input-group-btn"><button onclick="addnoResi();" class="btn btn-success">Update</button></span>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <?php echo form_open('trueaccon2194/order/sender');?>
                <div class="input-group">
                    <input type="hidden" name="iorder" value="<?php echo $b?>">
                    <input type="text" name="sender" class="form-control sender" id="sender" placeholder="Toko Pengirim" value="<?php echo $kl->sender?>">
                    <span class="input-group-btn"><button type="submit" class="btn btn-success">Update</button></span>
                </div>
                <?php echo form_close();?>
            </div>
            </div>
            <input type="hidden" name="inv" class="inv form-control" value="<?php echo $kl->invoice ?>">
        </div>
        <br>
    </div>



    <div class="row-inv">
        <div class="col-md-12 m-t-lg">
        <h4 class="pd pan hin"><i class="glyphicon glyphicon-list-alt"></i> Detail Invoice #<?php echo $kl->invoice?> (<?php echo $kl->buy_in?>) <label style="font-size: 12px;" class="pull-right label label-default print" onclick="printDiv('printableArea')"><i class="glyphicon glyphicon-print"></i> Cetak</label></h4>
            <div class="panel panel-white">
                <div class="panel-bodyty">
                    <div class="post-inv" id="printableArea">                                        
                        <div class="row">
                            <div class="col-md-12 col-xs-12" style="margin-bottom: 30px;">
                                <?php $get_data_setting = for_header_front_end();?>
                                <?php foreach($get_data_setting as $data):?>
                                    <img style="margin-top: 5px;" src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" width="100" class="pull-right">
                                <?php endforeach;?>
                                <h2>#<?php echo $kl->invoice?> (<?php echo $kl->buy_in?>)</h2>
                                <table>
                                <tbody>
                                    <tr>
                                        <th>Tanggal Pesanan </th>
                                        <td>: <?php echo date('d F Y H:i:s', strtotime($kl->tanggal_waktu_order));?></td>
                                    </tr>
                                    <tr>
                                        <th>Expired</th>
                                        <td>: <?php if($kl->buy_in == "E-commerce"){ echo date('d F Y H:i:s', strtotime($kl->tanggal_jatuh_tempo)); }else{ echo "-"; }?></td>
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
                                        <h3><?php echo $kl->nama_lengkap?></h3>
                                        <?php echo $kl->alamat?><br>
                                        <?php echo $kl->no_telp?>
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
                                                $hg_before = "<s class='h_b' style='color:red;'>Rp. ".number_format($ft->harga_before,0,".",".")."</s><br>";
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
                                              <span style="font-size: 12px;"><?php echo $hg_before?><harga>Rp. <?php echo number_format($ft->harga_fix,0,".",".");?></harga><br><?php echo $discft?></span>
                                            </td>
                                            <td class="yut" style="font-size: 12px;border-bottom: 1px solid #ccc;" align="right">Rp. <?php echo number_format($ft->harga_fix * $ft->qty,0,".",".")?></td>
                                        </tr>
                                        <?php endforeach;?>
                                        <tr style="background-color: transparent;">
                                            <td colspan="2" align="left">
                                                <h3>Catatan Pembeli</h3>
                                                <i style="font-size: 14px;"><?php echo $kl->catatan_pembelian?></i><br><br>
                                                <i style="font-size: 10px;">Dengan dikeluarkan invoice ini, Pembeli telah menyetujui syarat dan ketentuan toko.</i>
                                            </td>
                                            <td colspan="3" align="right" style="font-size: 12px;">
                                                Sub-Total : Rp. <?php echo number_format($ft->subtotal,0,".",".")?><br>
                                                Voucher : 
                                                <?php if(empty($kl->voucher)){
                                                    echo "-<br>";
                                                }else{
                                                    echo "<i class='cou'>$kl->voucher</i> <i style='color:red;'>(- $kl->action_voucher%)</i><br>";
                                                }?>
                                                Ongkir : 
                                                <?php if($kl->tarif == "gratis" || $kl->tarif == 0){?>
                                                    <?php echo "<b>Gratis Pengiriman</b>";?>
                                                <?php }else{?>
                                                    Rp. <?php echo number_format($kl->tarif,0,".",".")?>
                                                <?php }?><br>
                                                <span style="display: none;">Kode unik : <?php if($ft->kode_pembayaran == ""){ echo "-"; }else{ echo  'Rp '.$ft->kode_pembayaran;}?><br></span>
                                                <h2 style="margin-top: 5px;">
                                                    <?php 
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
                                     <div class="row">
                                        <div class="col-md-12 col-xs-12"><hr style="margin:0;"></div>
                                        <div class="col-md-6 col-xs-6">
                                            <table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-hover re_border" style="width: 100%;z-index: 9999;margin-top: 10px;margin-bottom: 0;">
                                                <tr style="margin-top: 20px;font-size: 14px;">
                                                    <th colspan="2" align="center" style="width:300px;padding-top: 5px;font-size: 14px;text-align: center;">Terima Kasih Telah Berbelanja Di<br>Stars Official Store</th>
                                                </tr>
                                                <tr> 
                                                    <td class="yut" align="left" style="color: #5a5a5a;border-left: 1px solid black;border-bottom: 1px solid black;width: 100px;">
                                                      <img src="<?php echo base_url('assets/images/93ab7257-8e29-47e9-b4b1-4de83abcbc36.jpg');?>" width="130" style="margin-left: 5px;margin-bottom: 5px;">
                                                    </td>
                                                    <td class="yut" align="left" style="width:145px;font-size: 10px;color: #5a5a5a;padding:5px;border-right: 1px solid black;border-bottom: 1px solid black;">
                                                      <?php
                                                        // CEK TOKO YANG MENGIRIM
                                                        //if(empty($tokopengirim)){
                                                        ?>
                                                            <b>PT. Stars Internasional<br>Divisi E-commerce<br>Jl. Rungkut Asri Utara VI no. 2 Kali Rungkut, Surabaya Jawa Timur 60293</b><br>
                                                        <?php 
                                                        //    }else{
                                                        //    foreach($tokopengirim->result() as $toko){
                                                        ?>
                                                            <?php //echo "<b>STARS E-COMMERCE<br>Toko Stars <?php echo $toko->nama_toko?><br><?php //echo $toko->alamat?><br>
                                                        <?php //}}?>
                                                      <img src="<?php echo base_url('assets/images/store.png');?>" width="50" style="margin-right:10px;"> <img src="<?php echo base_url('assets/images/store-online.png');?>" width="50">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <table class="table table-striped table-hover re_border" style="margin-bottom: 0;width:100%;margin-top: 10px;padding-top:10px;border:1px solid #cccccc;">
                                                <tr style="text-align: center;background-color: #f5f5f5;"> 
                                                  <td class="yut lbl" style="background-color: #f5f5f5;width:525px;font-size: 12px;color: #5a5a5a;padding:5px;">
                                                    <img src="<?php echo base_url('assets/images/93ab7257-8e29-47e9-b4b1-4de83abcbc36.jpg');?>" width="80"><br>
                                                    <h4><?php echo $kl->nama_lengkap?></h4><?php echo $kl->no_telp?><br><?php echo $kl->alamat?><br>Buy in : <?php echo $kl->buy_in?> | Expedisi : <?php echo $kl->layanan?> | Resi : <?php if(empty($kl->no_resi)){echo "-";}else{echo $kl->no_resi;}?>
                                                  </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                  </div>
                                  <div id="track" class="tab-pane fade">
                                    <h4 style="margin-top: 0px;">No Resi : <?php echo $kl->no_resi?><br>Expedisi : <?php echo $kl->layanan?><br>Pengirim : <?php echo $kl->nama_toko;?> [<?php echo $kl->kode_edp?>]</h4>
                                    <div id="gdresi-widget"></div>
                                    <script type="text/javascript" src="//ongkos-kirim.com/gdwidget/gdwresi.js"></script>
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
                                            <td style="padding: 10px !important;"><?php echo date('d F Y H:i:s', strtotime($kl->tanggal_dikirim));?></td>
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