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
    $emailx = $this->encrypt->encode($tge->email);
    $email = base64_encode($emailx);

  }

  if($point == 0 || $point == ""){
      $pts = "<span style='color:red;'>Anda belum memiliki Point<br>Ayo Belanja Sekarang!</span>";
  }else{
      $pts = "<span style='color:green;'>Point anda :<i></i> $point</span>";
  }
?>
<script type="text/javascript">
  $(document).ready( function () {
      $("#table_order_list").DataTable();
    });
</script>
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
        <div class="toppadding-zero csm padd-user-page">
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
                                    <h3 class="pd">Retur</h3>
                                        <div class="panel panel-white io">
                                            <div class="panel-bodyty">
                                                <div class="pan">
                                                    <?php echo form_open('customer/posJudgereturvalidation', array('id'=>'JkqutOop2&j3'));?>
                                                    <input type="hidden" name="SukeyRet" class="SukeyRet" value="<?php $a = $this->encrypt->encode('LjgteRet_insialIsg36$4'); $b = base64_encode($a); echo $b?>">
                                                    <input type="hidden" name="ml" value="<?php echo $email?>">
                                                        <table id="table_order_list" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Pilih</th>
                                                                    <th class="hidden-xs" style="width:100px;">Gambar</th>
                                                                    <th>Pesanan</th>
                                                                    <th align="center">Qty</th>
                                                                    <th style="text-align: right;">Harga</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php 
                                                            foreach($detail_order as $kl):
                                                            if($kl->harga_before > 0 || $kl->harga_before != ""){
                                                                $d = round(($kl->harga_before - $kl->harga_fix) / $kl->harga_before * 100);
                                                                $discft = "<i class='disc' style='color:red;'>$d%</i>";
                                                            }else{
                                                                $discft ="";
                                                            }

                                                            if($kl->ukuran == ""){
                                                                $ukr = "";
                                                            }else{
                                                                $ukr = "<li class='gf'>Ukuran : $kl->ukuran</li>";
                                                            }

                                                            if($kl->warna == ""){
                                                                $wrn = "";
                                                            }else{
                                                                $wrn = "<li class='gf'>Warna : $kl->warna</li>";
                                                            }

                                                            if($kl->harga_before == 0 || $ft->harga_before == ""){
                                                                $hg_before = "";
                                                            }else{
                                                                $hg_before = "<s class='h_b'>Rp.".number_format($kl->harga_before)."</s>";
                                                            }
                                                            $sts = $kl->ini_retur;
                                                            if($sts == "sgsYtr^7^799%#)6"){
                                                                $statos = "<label class='label label-warning njr'><i class='glyphicon glyphicon-time'></i>Sedang diproses</label>";
                                                            }else if($sts == "*5#^%21&(5#72hvLhs"){
                                                                $statos = "<label class='label label-success njr'><i class='glyphicon glyphicon-ok-sign'></i>Retur diterima</label>";
                                                            }else{
                                                                $statos = "";
                                                            }
                                                            ?>
                                                                <tr>
                                                                    <td><input type="checkbox" class="pro_r" name="pro_retur[]" value="<?php echo $kl->idpr_order?>"></td>
                                                                    <td class="yut hidden-xs" align="left" style="width:100px;border-bottom: 1px solid #ccc;"><img src="<?php echo $kl->gambar?>" width="100">
                                                                    </td>
                                                                    <td class="yut" align="left" style="border-bottom: 1px solid #ccc;">
                                                                            <h4 style="margin-top:10px;margin-bottom: 10px;"><b><?php echo $kl->nama_produk?></b></h4>
                                                                            <ul class="list-unstyled" style="font-size: 12px;margin-top: 0;">
                                                                                <li class="gf">SKU : <?php echo $kl->artikel?></li><?php echo $wrn?><?php echo $ukr?>
                                                                            </ul>
                                                                        </td>
                                                                        <td class="yut" style="font-size: 14px;border-bottom: 1px solid #ccc;" align="left"><?php echo $kl->qty?> pcs
                                                                        </td>
                                                                        <td class="yut" style="border-bottom: 1px solid #ccc;" align="right">  
                                                                          <span style="font-size: 12px;"><?php echo $hg_before?><br><harga>Rp. <?php echo number_format($kl->harga_fix,0,".",".")?></harga><br><?php echo $discft?></span>
                                                                        </td>
                                                                </tr>                                       
                                                        <?php endforeach;?>
                                                            </tbody>
                                                        </table>
                                                        <input type="hidden" name="insInvRelog" class="insInvRelog" value="<?php $a = $this->encrypt->encode($kl->no_order_cus); $b = base64_encode($a); echo $b?>">
                                                        <div class="row">
                                                            <div class="col-md-6 col-xs-12 input group">
                                                                <label>No. Invoice</label>
                                                                <input type="text" name="retnu" class="no-b form-control" value="#<?php echo $kl->invoice?>" required disabled><br>
                                                            </div>
                                                            <div class="col-md-12 col-xs-12 input group">
                                                                <label>Keterangan/ Alasan Retur</label>
                                                               <textarea name="rincianretur" class="no-b form-control resndketre" rows="8" cols="2" required></textarea>
                                                               <i class="red-notif">* Cantumkan Jumlah barang yang diretur per produk.<br>* Retur akan diproses jika telah memenuhi <b>syarat dan ketentuan berlaku.</b></i><br><br>
                                                            </div>  
                                                            <div class="col-md-12 col-xs-12 input group">
                                                                <button type="submit" class="ret-block no-b btn btn-block btn-danger">Ajukan Retur</button>
                                                            </div>
                                                        </div>
                                                        <?php echo form_close();?>
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
            </div>
          </div>
        </div>
        <!-- Mt Detail Section of the Page end -->
      </main><!-- Main of the Page end -->
<?php }?>