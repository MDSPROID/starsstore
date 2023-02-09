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
      <main id="mt-main" style="font-family: Montserrat, sans-serif">
        <!-- Mt Process Section of the Page -->
        <div class="mt-process-sec wow fadeInUpx paymentsucc" data-wow-delay="0.4s">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
               
              </div>
            </div>
          </div>
        </div><!-- Mt Process Section of the Page end -->
        <!-- Mt Detail Section of the Page -->
        <section class="mt-detail-sec toppadding-zero wow fadeInUpx" data-wow-delay="0.4s" style="margin-top: 0;">
          <div class="container">
            <center>
                <h3 class="jdlsucc" style="color:#2ebc73;">PESANAN SELESAI DIBUAT</h3>
                <h1 class="ui-title-page" style="margin-bottom: 30px;"><i class="fa fa-check icn-sc" style="color:#2ebc73;"></i></h1>
            </center>
            <div class="row">
                <div class="col-md-3 col-xs-12"></div>
                <div class="col-md-6 col-xs-12 textinfo" style="font-family: inherit;">
                  <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
                      Invoice :<m class="pull-right" id="payment"><b><?php echo $this->session->flashdata('notran');?></b></m>
                  </div>
                  <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
                      Nama :<m class="pull-right" id="payment"><b><?php echo $this->session->flashdata('nama');?></b></m>
                  </div>
                  <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
                      Email :<m class="pull-right" id="payment"><b><?php echo $this->session->flashdata('email');?></b></m>
                  </div>
                  <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
                      Total Belanja :<m class="pull-right" id="payment"><b>Rp. <?php echo number_format($this->session->flashdata('totbel'),0,".",".");?></b></m>
                  </div>
                  <div class="col-md-12 col-xs-12" style="margin-top: 20px;">
                      <div style="text-align: justify;"><?php echo $this->session->flashdata('instruksi');?></div>
                      <span>
                      <?php 
                        foreach($method_detail as $h){
                          echo $h['nama_bank'];
                          echo $h['cabang'];
                          echo $h['a_n'];
                          echo $h['nomor'];
                        }
                      ?>
                      </span>
                  </div>
                  <?php if($this->session->flashdata('method') == "transfer"){?>
                  <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
                      <p style="text-align: justify;">Silahkan transfer sejumlah <b>Rp. <?php echo number_format($this->session->flashdata('totbel'),0,".",".");?></b> sebelum jam <b><?php echo date('d F Y H:i:s',strtotime($this->session->flashdata('exp')));?></b> untuk menghindari keterlambatan pembayaran. Jika anda telah membayar silahkan klik tombol dibawah ini.</p><br>
                      <a class="btn btn-block" style="font-weight: bold;background-color: red;color: white;border:none;" href="<?php echo base_url('konfirmasi');?>">SAYA SUDAH BAYAR</a>
                  </div>
                  <?php }?>
                </div>
                <div class="col-md-3 col-xs-12"></div>                
            </div>
            <?php echo br(2);?>
          </div>
        </section>
        <!-- Mt Detail Section of the Page end -->
      </main><!-- Main of the Page end here -->