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
      <!-- Main of the Page -->
      <main id="mt-main">
        <?php 
          if($promo->num_rows() == 0){
        ?>
          <div class="container">
              <div class="row"> 
                  <div class="col-xs-12 ">
                      <div class="page-content default-page" style="margin-top: 100px;">
                        <center><img src='<?php echo base_url('assets/images/endpromox.jpg');?>' style="width: 400px;" class='img-responsive'></center>
                            <p class="text-center cart-empty">Promo sedang tidak ada, silahkan kembali besok harinya</p> 
                            <p class="return-to-shop text-center" style="margin-bottom: 50px;">
                                <a class="btn mail_sb wc-backward" href="<?php echo base_url();?>">Ayo Belanja</a>
                            </p>
                      </div>
                  </div>
              </div>
          </div>
        <?php }else{?>



        <section class="mt-team-sec" style="margin-top: 20px;">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <h3 class="text-center">PROMO MENARIK</h3>
                <div class="holder">
                  <!-- col of the Page -->
                  <?php 
                    foreach($promo->result() as $r){
                  ?>
                  <div class="col wow fadeInUpx" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                    <div class="img-holder">
                      <a href="<?php echo base_url('promo-menarik/'.$r->slug.'');?>">
                        <img src="<?php echo $r->gambar?>" alt="CLARA WOODEN">
                      </a>
                    </div>
                    <div class="mt-txt">
                      <h4 class=""><a href="#"><?php echo $r->name_group?></a></h4>
                      <span class="">
                        <p><?php echo $r->keterangan?></p>
                        <div class="">Promo sampai <?php echo date('d F Y', strtotime($r->berakhir))?></div>
                      </span>
                    </div>
                  </div>
                  <?php }?>
                  <!-- col of the Page end -->
                </div>
              </div>
            </div>
          </div>
        </section>


        <?php }?>
      </main><!-- Main of the Page end here -->