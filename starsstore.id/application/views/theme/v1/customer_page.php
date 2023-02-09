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
  $get_data_cst2 = info_customer_login();
  foreach($get_data_cst2 as $tge){
    $nam = $tge->nama_lengkap;
    $point = $tge->point_terkumpul;
  }

  if($point == 0 || $point == ""){
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
                                    <a class="<?php echo activate_menu('member'); ?><?php echo activate_menu('customer/member'); ?>" href="<?php echo base_url('customer/member')?>"><i class="ghu fa fa-credit-card"></i><br>Member Saya</a>
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
                                    <div class="col-md-3 col-xs-12 user-profile">
                                        <h4 class="text-center">Hai, <?php echo $nam?></h4>
                                        <ul class="list-unstyled text-center">
                                            <li><i></i></li>
                                        </ul>
                                        <a href="<?php echo base_url('/customer/informasi-akun');?>" style="border:1px solid #ccc;margin-bottom: 10px;" class="btn btn-default btn-block">Informasi Akun</a>
                                        <?php $seller1 = seller();
                                        foreach($seller1 as $s){
                                            $sell_stat = $s->status_seller;
                                        }
                                        if(empty($sell_stat)){?>
                                            <a style="display: none;" href="<?php echo base_url('jadi-seller/');?>" class="hidden btn btn-danger btn-block"><i class="glyphicon glyphicon-bullhorn"></i> Jadi Seller <span class="badge">Baru</span></a>
                                        <?php }else if($sell_stat == "ditangguhkan"){?>
                                            <a href="javascript:void(0);" class="hidden-xs btn btn-warning btn-block"><i class="glyphicon glyphicon-time"></i> Menunggu Proses</a>
                                        <?php }else{?>
                                            <a href="<?php echo base_url('dashboard-seller');?>" class="hidden-xs btn btn-default btn-block"><i class="glyphicon glyphicon-user"></i> Seller</a>
                                        <?php }?>
                                        <a href="<?php echo base_url('keluar_akun')?>" class="hidden-xs gby btn btn-block btn-danger">Keluar Akun</a>
                                        <hr class="hidden-xs">
                                    </div>
                                    <div class="col-md-9 col-xs-12 m-t-lg">
                                        <div class="panel panel-white io">
                                            <div class="panel-bodyty">
                                                <div class="post">
                                                    <div class="row">
                                                        <div class="col-md-6 col-xs-6">
                                                            <div  style="background-color: #eeeeee;padding: 10px 0;">
                                                                <a class="no_dec" href="<?php echo base_url('customer/riwayat-pesanan');?>">
                                                                    <div class="pan text-center orlis">
                                                                        <?php if(count($list_order) > 0){?>
                                                                            <h4>Pesanan</h4>
                                                                            <h1><?php echo count($list_order);?></h1>
                                                                        <?php } else {?>
                                                                            <h4>Pesanan</h4>
                                                                            <h1><?php echo count($list_order);?></h1>
                                                                        <?php }?>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>     
                                                        <div class="col-md-6 col-xs-6">
                                                            <div  style="background-color: #eeeeee;padding: 10px 0;">
                                                                <a class="no_dec" href="<?php echo base_url('customer/favorit');?>">
                                                                    <div class="pan text-center wili">
                                                                        <?php if(count($wishlist) > 0){?>
                                                                            <h4>Favorit</h4>
                                                                            <h1><?php echo count($wishlist);?></h1>
                                                                        <?php } else {?>
                                                                            <h4>Favorit</h4>
                                                                            <h1><?php echo count($wishlist);?></h1>
                                                                        <?php }?>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12 han">
                                                            <div class="pan">
                                                            <?php if(count($review) > 0){?>
                                                                <table id="table_rev" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Review Produk</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            foreach($review as $klo):
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <h4 class="olp">
                                                                                    <span class="inv-e"><b><?php echo $klo->nama_produk?></b></span> <img src="<?php echo base_url('assets/images/rating/')?><?php echo $klo->rating?>" width="80"><br>
                                                                                    <span class="njk"><i><?php echo $klo->review?></i></span><br>
                                                                                    <span class="nj"><?php echo $klo->tgl_review;?></span>
                                                                                </h4>
                                                                            </td>  
                                                                        </tr>                                       
                                                                        <?php endforeach;?>
                                                                    </tbody>
                                                                </table>
                                                            <?php } else {?>                                                        
                                                                <div class="text-center" style="background-color: white;padding: 10px;">Belum ada Review</div>
                                                            <?php }?>
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
            </div>
          </div>
        </div>
        <!-- Mt Detail Section of the Page end -->
      </main><!-- Main of the Page end -->