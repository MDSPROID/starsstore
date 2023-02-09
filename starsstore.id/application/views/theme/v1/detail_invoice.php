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
<?php 
if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
    redirect('/login-pelanggan');
}else{
 
  $get_data_cst2 = info_customer_login();
  foreach($get_data_cst2 as $tge){
    $nam = $tge->nama_lengkap;
        $point = $tge->point_terkumpul;
  }

  if($point == 0){
      $pts = "<span style='color:red;'>Anda belum memiliki Point<br>Ayo Belanja Sekarang!</span>";
  }else{
      $pts = "<span style='color:green;'>Point anda :<i></i> $point</span>";
  }
?>
      <!-- Main of the Page -->
      <main id="mt-main">
        <!-- Mt About Section of the Page -->
        <section class="mt-about-sec" style="padding-bottom: 0;padding-top: 0;">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <div class="txt">
                  <h2></h2>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Mt About Section of the Page -->
        <!-- Mt Detail Section of the Page -->
        <div class="toppadding-zero padd-user-page">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 ">
                <div class="page-content default-page">
                    <div class="container-fluid">
                        <div class="profile-cover1 row">
                            <div class="col-md-12 scrollmenu">
                                <nav class="text-center">
                                    <a class="<?php echo activate_menu('customer'); ?><?php echo activate_menu('customer/informasi-akun'); ?>" href="<?php echo base_url('customer')?>"><i class="ghu fa fa-user"></i><br>Akun</a>
                                    <a class="<?php echo activate_menu('member'); ?><?php echo activate_menu('customer/informasi-akun'); ?>" href="<?php echo base_url('customer')?>"><i class="ghu fa fa-credit-card"></i><br>Member Saya</a>
                                    <a class="<?php echo activate_menu('customer/riwayat-pesanan'); ?><?php echo activate_menu('customer/retur'); ?>" href="<?php echo base_url('customer/riwayat-pesanan')?>"><i class="ghu fa fa-shopping-cart"></i><br>Pesanan</a>
                                    <a class="<?php echo activate_menu('customer/favorit'); ?>" href="<?php echo base_url('customer/favorit')?>"><i class="ghu fa fa-heart"></i><br>Favorit</a>
                                    <?php $seller1 = seller();
                                    foreach($seller1 as $s){
                                        $sell_stat = $s->status_seller;
                                    }
                                    if(empty($sell_stat)){?>
                                    <a style="display: none;" class="hidden <?php echo activate_menu('jadi-seller'); ?><?php echo activate_menu('form-pengajuan-seller'); ?>" href="<?php echo base_url('jadi-seller')?>"><i class="ghu fa fa-bullhorn"></i><br>Jadi Seller</a>
                                    <?php }else if($sell_stat == "ditangguhkan"){?>
                                    <a href="#"><i class="ghu glyphicon glyphicon-time"></i><br>Dalam proses</a>
                                    <?php }else{?>
                                    <a class="<?php echo activate_menu('dashboard-seller'); ?>" href="<?php echo base_url('dashboard-seller')?>"><i class="ghu glyphicon glyphicon-bullhorn"></i><br>Seller</a>
                                    <?php }?>
                                    <a class="<?php echo activate_menu('bantuan'); ?>" href="<?php echo base_url('bantuan')?>"><i class="ghu fa fa-phone"></i><br>Bantuan</a>
                                </nav>
                            </div>
                        </div>    
                        <div id="main-wrapper">
                            <div class="row">
                                <div class="row-inv">
                                    <div class="info-success"><?php echo $this->session->flashdata('berhasil');?></div>
                                    <div class="info-error"><?php echo $this->session->flashdata('error');?></div>
                                    <div class="m-t-lg">
                                        <?php foreach($detail_inv as $kl):
                                            $sts = $kl->status;
                                            $a = $this->encrypt->encode($kl->no_order_cus); 
                                            $b = base64_encode($a);
                                            if($sts == "2hd8jPl613!2_^5"){
                                                $statos = "<label class='label label-warning njr'>Menunggu Pembayaran</label>";
                                                $retur = "<a href='retur/$b'><label class='label retur_btn label-primary'>Retur</label></a>";
                                            }else if($sts == "*^56t38H53gbb^%$0-_-"){
                                                $statos = "<label class='label label-primary njr'>Pembayaran diterima</label>";
                                                $retur = "";
                                            }else if($sts == "Uywy%u3bShi)payDhal"){
                                                $statos = "<label class='label label-primary njr'>Dalam Pengiriman</label>";
                                                $retur = "";
                                            }else if($sts == "ScUuses8625(62427^#&9531(73"){
                                                $statos = "<label class='label label-success njr'>Diterima</label>";
                                                $retur = "<a href='retur'><label class='label label-primary'>Retur</label></a>";
                                            }else if($sts == "batal"){
                                                $statos = "<label class='label label-danger njr'>Dibatalkan</label>";
                                                $retur = "";
                                            }
                                        ?>
                                            <div class="panel panel-white">
                                                <div class="panel-bodyty">
                                                    <div class="post-inv">                                        
                                                        <div class="row">
                                                            <div class="col-md-12 col-xs-12" style="margin-bottom: 30px;">
                                                                <h4>#<?php echo $kl->invoice?></h4>
                                                                <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <th class="nbl">Tanggal Pesanan </th>
                                                                        <td>: <?php echo date('d F Y H:i:s', strtotime($kl->tanggal_waktu_order));?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="nbl">Expired </th>
                                                                        <td>: <?php echo date('d F Y H:i:s', strtotime($kl->tanggal_jatuh_tempo));?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="nbl">Status </th>
                                                                        <td>: <?php echo $statos;?></td>
                                                                    </tr>
                                                                </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6 col-xs-12" style="margin-bottom: 30px;">
                                                                <h4>Detail Pelanggan</h4>
                                                                <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <th>Nama </th>
                                                                        <td>: <?php echo $kl->nama_lengkap?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Email </th>
                                                                        <td>: <?php echo $kl->email?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Telepon </th>
                                                                        <td>: <?php echo $kl->no_telp?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            </div>
                                                            <div class="col-md-6 col-xs-12" style="margin-bottom: 30px;">
                                                                <h4>Expedisi dan Pembayaran</h4>
                                                                <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <th>Alamat </th>
                                                                        <td>: <?php echo $kl->alamat?>, <?php echo $kl->kota?>, <?php echo $kl->provinsi?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Expedisi </th>
                                                                        <td>: 
                                                                        <?php 
                                                                            if($kl->no_resi != ""){
                                                                        ?>
                                                                        <?php 
                                                                            //if(preg_match("/JNE/", $kl->layanan)){
                                                                            //    echo "JNE";
                                                                            //}else if(preg_match("/TIKI/", $kl->layanan)){
                                                                            //    echo "TIKI";
                                                                            //}else if(preg_match("/POS/", $kl->layanan)){
                                                                            //    echo "POS";
                                                                            //}
                                                                            echo $kl->layanan;
                                                                        ?> - <?php //echo $kl->etd?>
                                                                        <?php }else{
                                                                            echo "<i style='color:red'>Nomor Resi Belum Diupdate.</i>";
                                                                        }?>
                                                                        </td> 
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Pembayaran </th>
                                                                        <td>: 
                                                                            <?php if($kl->jenis_pembayaran == "transfer"){
                                                                                echo "Bank Transfer";
                                                                            }else{
                                                                                echo "Multi Payment";
                                                                            }?></td>
                                                                    </tr>
                                                                </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-12 col-xs-12">
                                                                <table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-hover re_border">
                                                                    <tr style="margin-top: 20px;font-size: 16px;">
                                                                         <th align="left" class="hidden-xs" style="width:100px;">Gambar</th>
                                                                        <th align="left">Pesanan</th>
                                                                        <th align="center">Qty</th>
                                                                        <th style="text-align: right;">Harga</th>
                                                                    </tr>
                                                                    <?php foreach($detail_order as $ft):
                                                                        if($ft->harga_before > 0 || $ft->harga_before != ""){
                                                                            $d = round(($ft->harga_before - $ft->harga_fix) / $ft->harga_before * 100);
                                                                            $discft = "<i class='disc' style='color:red;'>$d%</i>";
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
                                                                            $hg_before = "<s class='h_b'>Rp.".number_format($ft->harga_before,0,".",".")."</s>";
                                                                        }
                                                                    ?>
                                                                    <tr> 
                                                                        <td class="yut hidden-xs" align="left" style="width:100px;border-bottom: 1px solid #ccc;">
                                                                            <img src="<?php echo $ft->gambar?>" width="100">
                                                                        </td>
                                                                        <td class="yut" align="left" style="border-bottom: 1px solid #ccc;">
                                                                            <h5 style="margin-top:10px;margin-bottom: 10px;"><b><?php echo $ft->nama_produk?></b></h5>
                                                                            <ul class="list-unstyled list-inline" style="font-size: 12px;margin-top: 0;">
                                                                                <li class="gf">SKU : <?php echo $ft->artikel?></li><?php echo $wrn?><?php echo $ukr?>
                                                                            </ul>
                                                                        </td>
                                                                        <td class="yut" style="font-size: 14px;border-bottom: 1px solid #ccc;" align="left"><?php echo $ft->qty?> pcs
                                                                        </td>
                                                                        <td class="yut" style="border-bottom: 1px solid #ccc;" align="right">  
                                                                          <span style="font-size: 12px;"><?php echo $hg_before?><br><harga>Rp.<?php echo number_format($ft->harga_fix,0,".",".")?></harga><br><?php echo $discft?></span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php endforeach;?>
                                                                  <tr style="font-size: 14px;background-color: #f5f5f5;">
                                                                    <td colspan="2" align="left" style="padding-left:10px;border-bottom: 1px solid #ccc;padding-bottom: 10px;padding-top: 10px;">Pengiriman</td>
                                                                    <td colspan="2" align="right" style="padding-right:10px;border-bottom: 1px solid #ccc;padding-bottom: 10px;padding-top: 10px;"><?php if($kl->tarif == "gratis"){?>
                                                                            <?php echo "<label class='label label-primary'>Gratis Pengiriman</label>";?>
                                                                        <?php }else{?>
                                                                            Rp.<?php echo number_format($kl->tarif,0,".",".")?>
                                                                        <?php }?>
                                                                    </td>
                                                                  </tr>
                                                                  <tr style="font-size: 14px;background-color: #f5f5f5;display: none;">
                                                                    <td colspan="2" align="left" style="display:none;padding-left:10px;border-bottom: 1px solid #ccc;padding-bottom: 10px;padding-top: 10px;">Kode Pembayaran</td>
                                                                    <td colspan="2" align="right" style="display:none;padding-right:10px;border-bottom: 1px solid #ccc;padding-bottom: 10px;padding-top: 10px;">Rp. <?php echo $ft->kode_pembayaran?></td>
                                                                  </tr>
                                                                  <tr style="font-size: 14px; font-weight: bold;background-color: #f5fz5f5;">
                                                                    <td colspan="2" align="left" style="padding-left:10px;padding-bottom: 10px;padding-top: 10px;">Kupon / Voucher</td>
                                                                    <td colspan="2" align="right" style="padding-right:10px;padding-bottom: 10px;padding-top: 10px;">
                                                                    <?php if(empty($kl->voucher)){
                                                                        echo "-";
                                                                    }else{
                                                                        echo "<i class='cou'>$kl->voucher</i> [$kl->action_voucher%]";
                                                                        }?>
                                                                    </td>
                                                                  </tr>
                                                                  <tr style="font-size: 14px; font-weight: bold;background-color: #f5f5f5;">
                                                                    <td colspan="2" align="left" style="padding-left:10px;padding-bottom: 10px;padding-top: 10px;">Total</td>
                                                                    <td colspan="2" align="right" style="padding-right:10px;padding-bottom: 10px;padding-top: 10px;width: 150px;"> 
                                                                    <?php 
                                                                    if($kl->action_voucher == ""){
                                                                        echo "Rp.".number_format($ft->total_belanja,0,".",".")."";    
                                                                    }else{
                                                                        echo "Rp.".number_format($ft->total_belanja,0,".",".")."";
                                                                    }
                                                                    ?></td>
                                                                  </tr>
                                                                 </table>
                                                                 <table class="table table-striped table-hover re_border" style="margin-bottom: 0;width:100%;margin-top: 20px;padding:10px;background-color: #f5f5f5;">
                                                                  <tr> 
                                                                    <td class="yut" align="left" style="font-size: 16px;color: #5a5a5a;">
                                                                    <span style="font-size: 16px;color: #757575;font-weight: bold;">Catatan :</span>
                                                                      <b><?php echo $kl->catatan_pembelian?></b>
                                                                    </td>
                                                                  </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-12 col-xs-12">
                                                                <div class="track-order">
                                                                    <h4 class="text-center">Lacak Pesanan</h4>
                                                                    <p class="text-center">Masih dalam pengembangan</p>
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
                    </div>
                </div> 
            </div>
            </div>
          </div>
        </div>
        <!-- Mt Detail Section of the Page end -->
      </main><!-- Main of the Page end -->
<?php }?>