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
        <section class="mt-detail-sec toppadding-zero csm">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 ">
                <div class="page-content default-page">
                    <div class="container-fluid">
                        <div class="profile-cover1 row">
                            <div class="col-md-12 scrollmenu profile-image">
                                <nav class="text-center">
                                    <a class="<?php echo activate_menu('customer'); ?><?php echo activate_menu('customer/informasi-akun'); ?>" href="<?php echo base_url('customer')?>"><i class="ghu fa fa-user"></i><br>Akun</a>
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
                                    <div class="col-md-12 m-t-lg">
                                    <h4 class="pd pan hin"><i class="fa fa-user"></i> Informasi Pelanggan</h4>
                                        <div class="panel panel-white io">
                                            <div class="panel-bodyty">
                                                <div class="pan">
                                                <div class="row">
                                                <div class="col-md-12 col-xs-12 re">
                                                    <div class="col-md-12 col-xs-12 info-success"><?php echo $this->session->flashdata('berhasil');?></div>
                                                    <div class="col-md-12 col-xs-12 info-warning"><?php echo $this->session->flashdata('error');?></div>
                                                </div> 
                                                <?php echo form_open_multipart('PageChngInfo');?>
                                                <input type="hidden" name="GetchGinit" class="InisChgUse" value="<?php $a = $this->encrypt->encode('K935$2&#1I.}[st53|-sgfw3(62Jfw'); $b = base64_encode($a); echo $b?>">
                                                    <?php foreach($datacustomer as $p):?>
                                                        <div class="col-md-12 col-xs-12 re">
                                                          <?php $get_data_user = info_customer_login();?>
                                                          <?php foreach($get_data_user as $datauser){
                                                            $img_user = $datauser->gb_user;
                                                          }?>
                                                          <input type="hidden" name="gb" class="form-control" value="<?php echo $p->gb_user?>">
                                                        </div>
                                                        <div class="col-md-12 col-xs-12 re">
                                                            <span class="jud">Nama Lengkap*</span>
                                                            <input type="text" name="name_l" class="form-control list-form na" value="<?php echo $p->nama_lengkap?>" required>
                                                            <i class="inf-n o"></i><br>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12 re">
                                                            <span class="jud">Email*</span>
                                                            <input type="email" name="email_m" value="<?php echo $p->email?>" class="form-control list-form em" required>
                                                            <i class="inf-e o"></i><br>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12">
                                                            <span class="jud">Nomor Telepon*</span>
                                                            <input type="number" value="<?php echo $p->telp?>" name="no_l" class="form-control list-form no" required>
                                                            <i class="inf-t o"></i><br>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12 re">
                                                            <div class="radio"><label><input type="radio" name="gen" class="gen" <?php echo $pr?> value="pria" required>Pria</label></div>
                                                            <div class="radio"><label><input type="radio" name="gen" class="gen" <?php echo $wn?> value="wanita" required>Wanita</label></div>
                                                        </div>
                                                    <?php endforeach;?>  
                                                        <div class="col-md-12 col-xs-12 re">
                                                            <h4>Ganti Password :</h4>
                                                            <i>*Jika tidak mengganti password, kosongi saja</i>
                                                        </div>
                                                         <div class="col-md-12 col-xs-12 re">
                                                            <span class="jud">Password*</span>
                                                                <input type="password" name="ps_d1" id="ps1" class="form-control list-form pa passwordx" value="" placeholder="password" aria-describedby="basic-addon2">
                                                            <i class="inf-p1 o"></i><br>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12 re">
                                                            <span class="jud">Ulangi Password*</span>
                                                                <input type="password" onChange="pwsv();" name="ps_d2" id="ps2" class="form-control list-form pa passwordx" value="" placeholder="password" aria-describedby="basic-addon2">
                                                            <i class="inf-p2 o"></i><br>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12 re">
                                                            <button type="submit" class="btn-saving btn btn-block no-b btn-primary">Simpan</button>
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
        </section>
        <!-- Mt Detail Section of the Page end -->
      </main><!-- Main of the Page end -->
<?php }?>