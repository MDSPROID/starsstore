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
                                    <div class="m-t-lg">
                                    <div class="info-success"><?php echo $this->session->flashdata('berhasil');?></div>
                                    <div class="info-error"><?php echo $this->session->flashdata('error');?></div>
                                    <h4 class="pd pan hin"><i class="fa fa-bookmark"></i> Daftar Favorit</h4>
                                        <div class="panel panel-white io">
                                            <div class="panel-bodyty">
                                                <div class="pan">
                                                <div class="row1">
                                                <div class="row-fav">
                                                    <?php if(count($list_favorit) > 0){?>
                                                        <?php 
                                                          foreach($list_favorit as $produk):
                                                        ?>
                                                        <div class="col-md-2 col-xs-6 pd-fav">
                                                            <div class="img-thumbnail" style="border-radius: 0;padding: 0;"> 
                                                                <?php if(empty($produk->harga_dicoret) || $produk->harga_dicoret == 0){
                                                                    echo "";
                                                                }else{
                                                                    $disc = round(($produk->harga_dicoret - $produk->harga_fix) / $produk->harga_dicoret * 100);
                                                                    echo "<label style='top:20px;' class='diskon'>$disc%</label>";
                                                                }?>
                                                                <a class="pull-right" style="position: absolute;right:0;" href="<?php echo base_url('customer/favorit/hapus_wishlist/')?><?php $id = $this->encrypt->encode($produk->id_produk); $idp = base64_encode($id); echo $idp?>"><i class="fa fa-trash" style="color: red;font-size: 18px;"></i></a>
                                                                <a class="product-image url-produk lkp" href="<?php echo base_url()?>produk/<?php echo $produk->slug?>"> 
                                                                <img src="<?php echo $produk->gambar;?>" data-original="<?php echo $produk->gambar;?>" class="lazy img-responsive" /> 
                                                                <div class="text-product text-center">
                                                                    <?php 
                                                                      if($produk->status != "on"){
                                                                        echo "<h5 style='height:70px;padding:5px;' class='harga_retail'>PRODUK TIDAK TERSEDIA<br>[ HABIS ]</h5>";
                                                                      }else{
                                                                        
                                                                    ?>
                                                                    <h5 class="product-title" style="padding: 5px;">
                                                                    <?php $nama = word_limiter($produk->nama_produk,3); echo $nama; ?></h5>
                                                                    <?php
                                                                        //$diskon = $produk->harga_retail-($produk->harga_retail*$produk->diskon/100);
                                                                        if($produk->harga_dicoret == 0 || empty($produk->harga_dicoret)){ 
                                                                            echo "<h5 style='height:30px;padding:5px;' class='harga_retail'>Rp.".number_format($produk->harga_fix,0,".",".")."</h5>"; 
                                                                        }else{
                                                                            echo "<h5 style='height:30px;padding:5px;'><s style='font-size:10px;' class='discount-title'>Rp.".number_format($produk->harga_dicoret,0,".",".")."</s> <harga class='harga_retail'>Rp.".number_format($produk->harga_fix,0,".",".")."</harga></h5>"; 
                                                                    }}?>
                                                                </div>
                                                              </a>
                                                            </div>
                                                        </div>
                                                        <?php endforeach;?>
                                                    <?php } else {?>
                                                    <div class="text-center" style="background-color: white;padding: 10px;">
                                                        <p style="font-size: 16px;">Tidak ada produk</p>
                                                    </div>
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
        <!-- Mt Detail Section of the Page end -->
      </main><!-- Main of the Page end -->
<?php }?>