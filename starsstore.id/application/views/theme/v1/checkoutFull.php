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
        <!-- Mt Process Section of the Page -->
        <div class="mt-process-sec wow fadeInUpx" data-wow-delay="0.4s">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <!-- Process List of the Page -->
                <ul class="list-unstyled process-list">
                  <li>
                    <span class="counter">01</span>
                    <strong class="title">Keranjang Belanja</strong>
                  </li>
                  <li class="active">
                    <span class="counter">02</span>
                    <strong class="title">Verifikasi Pesanan</strong>
                  </li>
                  <li>
                    <span class="counter">03</span>
                    <strong class="title">Pesanan Selesai</strong>
                  </li>
                </ul>
                <!-- Process List of the Page end -->
              </div>
            </div>
          </div>
        </div><!-- Mt Process Section of the Page end -->
        <!-- Mt Detail Section of the Page -->
        <section class="mt-detail-sec toppadding-zero wow fadeInUpx" data-wow-delay="0.4s">
          <div class="container">
            <?php echo form_open('confirm_order')?>
            <div class="row">
              <div class="col-xs-12 col-md-12">
                <div class="woocommerce-message info-success" role="alert"><?php echo $this->session->flashdata('berhasil');?></div>
                <div class="woocommerce-message info-error" role="alert"><?php echo $this->session->flashdata('error');?></div>
              </div>
              <div class="col-xs-12 col-sm-6">
                <h2>INFORMASI PELANGGAN</h2>
                <!-- Bill Detail of the Page -->
                <?php $ax = $this->encrypt->encode('Verify_order_withSecuresystem'); $bx = base64_encode($ax);?>
                <div class="bill-detail">
                  <fieldset>
                    <div class="form-group">
                      <input type="text" name="nm_customer" id="name" class="form-control" placeholder="Nama Lengkap" value="<?php echo $cs['nama_lengkap'];?>" required>
                      <input type="hidden" name="ex__randVer" class="ex_rand" value="<?php $a = $this->encrypt->encode('Verify_order_withSecuresystem'); $b = base64_encode($a); echo $b?>">
                    </div>
                    <?php if($this->session->userdata('cs_log_true_with_sess') == ""){?>
                    <div class="form-group" style="display: none;">
                      <label><input id="createaccount" type="checkbox" name="createaccount"> <span>Buat akun sekaligus?</span></label>
                    </div>
                    <?php }?>
                    <div class="form-group">
                      <div class="col">
                        <?php 
                          if($cs['email'] != ""){
                            $kunciemail = "readonly";
                            $styleemail = "style='background-color:#ededed;'";
                            $kuncinama = "readonly";
                            $stylenama = "style='background-color:#ededed;'";
                            $kuncitelpho = "readonly";
                            $stylenama = "style='background-color:#ededed;'";
                          }else{
                            $kunciemail = "";
                            $styleemail = "";
                            $kuncinama = "";
                            $stylenama = "";
                          }?>
                        <input type="email" class="form-control" placeholder="Email" name="ml_customer" id="mail" value="<?php echo $cs['email'];?>" <?php echo $kunciemail?> <?php echo $styleemail?> required>
                      </div>
                      <div class="col">
                        <input type="tel" class="form-control" name="tl_customer" id="nomor" value="<?php echo $cs['telp'];?>" placeholder="Telepon Number" required>
                      </div>
                      <?php if($total_berat < 1){
                        $aaa = $this->encrypt->encode('1000');
                        $www = base64_encode($aaa);
                      }else{ 
                        $yyy = $total_berat*1000;
                        $ttt = $this->encrypt->encode($yyy);
                        $www = base64_encode($ttt);
                      }?>
                      <input type="hidden" name="lock_t" class="lock_t" value="<?php echo $this->cart->total_items()?>">
                      <input type="hidden" name="lock_w" id="lock_w" class="form-control" value="<?php echo $www;?>">
                    </div>
                    <div class="form-group">
                      <select class="form-control propKey" name="propinsi_tujuan" id="propinsi_tujuan" required>
                        <option value="">Pilih Provinsi</option>
                        <?php $this->load->view('rajaongkir/getProvince'); ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <select name="kota" id="destination" class="citKey form-control" onchange="cekcityogk();" placeholder="Kota" required>
                        <option value="">Pilih Kota</option>
                      </select>
                    </div>
                    <div class="expedisi"></div>
                    <div class="form-group">
                      <textarea class="form-control" placeholder="Alamat Lengkap" name="alamat" required></textarea>
                    </div>
                    <div class="form-group">
                      <input type="number"  name="kdp_customer" id="kodepos" class="form-control" placeholder="Kode POS (optional)">
                    </div>
                    <div class="form-group">
                      <textarea class="form-control" name="note_order" placeholder="Catatan"></textarea>
                    </div>
                  </fieldset>
                </div>
                <!-- Bill Detail of the Page end -->
              </div>
              <div class="col-xs-12 col-sm-6">
                <div class="holder">
                  <h2>PESANAN ANDA</h2>
                  <ul class="list-unstyled block">
                    <li>
                      <div class="txt-holder">
                          <div class="text-wrap pull-left">
                            <strong class="title">PRODUK</strong>
                            <?php 
                            $i = 1;
                            foreach ($this->cart->contents() as $items): ?>
                              <span>
                                <a href="<?php echo base_url('produk/'.$items['slug'].'');?>"><?php echo word_limiter($items['name'],2); ?></a> x<?php echo $items['qty']; ?></span>
                                <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                  <p class='opt-cart' style="font-size: 10px;">
                                      <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                                          <?php if(empty($option_value)){ 
                                              echo"";
                                          ?>
                                          <?php }else{?>
                                              <?php echo $option_name; ?> : <?php echo $option_value; ?> | 
                                          <?php }?>                                       
                                      <?php endforeach; ?>
                                  </p>
                              <?php endif; ?>
                            <?php endforeach;?>
                          </div>
                        <div class="text-wrap txt text-right pull-right">
                          <strong class="title">TOTAL</strong>
                          <?php 
                            $i = 1; 
                            foreach ($this->cart->contents() as $items): ?>
                            <?php if($items['before'] == 0 || empty($items['before'])){ 
                                echo "<span style='font-size:14px;height:40px;'>Rp. ".number_format($items['price'],0,".",".")."</span>";
                            }else{
                                echo "<s style='color:#989898;font-size:12px;'>Rp. ".number_format($items['before'],0,".",".")."</s><br><span style='font-size:14px;'> <i style='color:red;font-size:12px;'>-".round(($items['before'] - $items['price']) / $items['before'] * 100)."%</i> Rp. ".number_format($items['price'],0,".",".")."</span>";
                            }?>
                          <?php endforeach;?>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="txt-holder">
                        <strong class="title sub-title pull-left">SUBTOTAL</strong>
                        <div class="txt pull-right">
                          <span>Rp. <t class="subtotal_test"><?php echo number_format($this->cart->total(),0,".","."); ?></t></span>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="txt-holder">
                        <strong class="title sub-title pull-left">VOUCHER</strong>
                        <div class="txt pull-right">
                          <strong class="voucher">
                            <i style="color:red;">
                              <?php if($this->session->userdata('type') == "disc_apply"){ // jika apply voucher disc 

                                //echo "Diskon ".$this->session->userdata('action')."% (".strtoupper($this->session->userdata('kupon')).")";
                                echo "Diskon Rp ".number_format($this->session->userdata('action'),0,".",".")." (".strtoupper($this->session->userdata('kupon')).")";

                              }else if($this->session->userdata("type") == "ongkir_apply"){ // jika apply free ongkir

                               echo "Gratis Pengiriman<br> Kode : ".strtoupper($this->session->userdata('kupon'))."";

                              }else{
                                echo "-";
                              }?>  
                            </i>
                          </strong>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="txt-holder">
                        <strong class="title sub-title pull-left">PENGIRIMAN</strong>
                        <div class="txt pull-right">
                          <strong class="shipping_test">-</strong>
                        </div>
                      </div>
                    </li>
                    <li style="display: none;">
                      <div class="txt-holder">
                        <strong class="title sub-title pull-left">KODE UNIK</strong>
                        <div class="txt pull-right">
                          <span>Rp. <?php echo $this->session->userdata('unik'); ?></span>
                        </div>
                      </div>
                    </li>
                    <?php 
                      $use_cashbackx = 0;
                      if($this->session->userdata('cs_log_true_with_sess') != ""){
                        $user_log = info_member_login(); 
                        foreach($user_log as $log){ 
                          $cb = $log->cashback;
                          if($cb > 0){
                    ?>
                    <li>
                      <div class="txt-holder">
                        <strong class="title sub-title pull-left">GUNAKAN SALDO KAS</strong>
                        <?php 
                          // TOTAL BELANJA KESELURUHAN
                          if($this->session->userdata('type') == "disc_apply"){ // jika apply voucher disc 

                            //$total_belanja = $this->cart->total() - ($this->cart->total() * $this->session->userdata('action') / 100) + $this->session->userdata('unik');
                            $total_belanja = $this->cart->total() - $this->session->userdata('action');

                          }else if($this->session->userdata("type") == "ongkir_apply"){ // jika apply free ongkir

                            $total_belanja = $this->cart->total() + $this->session->userdata('unik');

                          }else{ 

                            $total_belanja = $this->cart->total() + $this->session->userdata('unik');

                          }
                           
                          // JIKA TOTAL CASHBACK LEBIH BANYAK DARI PADA TOTAL BELANJA
                          if($cb > $total_belanja){

                            $cashxx        = $cb - $total_belanja; 
                            $cashx       = 0;
                            //$cashback      = 0;//(($cashxx) * $mit['kerjasama']/100); //+ $cashxx; //$cashback     = (($cashxx) * $mit['kerjasama']/100) + $cashxx; 
                            $use_cashbackx = $total_belanja; // JIKA CASHBACK LEBIH BESAR DARIPADA TOTAL BELANJA MAKA USE CASHBACKNYA SESUAI TOTAL BELANJA
                           // $totalcashback = $cashxx; //(($cashxx) * $mit['kerjasama']/100) + $cashxx;

                          }else if($total_belanja > $cb){

                            $cashxx      = $total_belanja - $cb; 
                            $cashx       = $cashxx;
                            //$cashback      = (($cashxx) * $mit['kerjasama']/100); // CASHBACK KAN DIPAKAI SEMUA, MAKA CASHBACK CUSTOMER JADI 0 + CASHBACK DARI TRANSAKSI
                            $use_cashbackx = $cb; // JIKA CASHBACK LEBIH KECIL DARIPADA TOTAL BELANJA MAKA USE CASHBACKNYA SESUAI CASHBACK
                            //$totalcashback = (($cashxx) * $mit['kerjasama']/100);
                          }
                        ?>
                        <div class="txt pull-right">
                          <span style="color:red;">- Rp. <?php echo number_format($use_cashbackx,0,".","."); ?></span>
                        </div>
                      </div>
                    </li>
                    <?php }}}?>
                    <span style="display:none;" class="cb"><?php echo $use_cashbackx?></span>
                    <li style="border-bottom: none;background-color: #cfcfcf;padding: 10px;">
                      <div class="txt-holder">
                        <strong class="title sub-title pull-left">TOTAL</strong>
                        <div class="txt pull-right">
                          <span>
                              Rp. <t class="total_test fgrand">
                                <?php 
                                // kode unik sementara dinonaktifkan
                                $tyh = 0;
                                if($this->session->userdata('type') == "disc_apply"){ // jika apply voucher disc 

                                  //echo number_format($this->cart->total() - ($this->cart->total() * $this->session->userdata('action') / 100) - $use_cashbackx,0,".",".");
                                  echo number_format($this->cart->total() - $this->session->userdata('action') - $use_cashbackx,0,".",".");

                                  //$tyh = $this->cart->total() - ($this->cart->total() * $this->session->userdata('action') / 100) - $use_cashbackx;
                                  $tyh = $this->cart->total() - $this->session->userdata('action') - $use_cashbackx;

                                }else if($this->session->userdata("type") == "ongkir_apply"){ // jika apply free ongkir

                                  echo number_format($this->cart->total() - $use_cashbackx,0,".",".");

                                  $tyh = $this->cart->total() - $use_cashbackx;

                                }else{ 

                                  echo number_format($this->cart->total() - $use_cashbackx,0,".",".");

                                  $tyh = $this->cart->total() - $use_cashbackx;

                                }?>   
                            </t>
                            <span class="tyh" style="display: none;"><?php echo $tyh?></span>
                          </span>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <h2>METODE PEMBAYARAN</h2>
                  <!-- Panel Group of the Page -->
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <!-- Panel Panel Default of the Page -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <input id="transfer" required class="payment otp pg_ins_bt" type="radio" style="display: none;" checked="checked" name="payment" value="<?php $a = $this->encrypt->encode('bank_t_ransfer'); $b = base64_encode($a); echo $b; ?>" />
                            BANK TRANSFER
                            <span class="check"><i class="fa fa-check"></i></span>
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          <p>Anda dapat melakukan pembayaran dengan bank transfer yang kami sediakan. dan konfirmasi pembayaran anda pada menu konfirmasi pembayaran.</p>
                        </div>
                      </div>
                    </div>
                    <!-- Panel Panel Default of the Page end -->
                    



                  </div>
                  <!-- Panel Group of the Page end -->
                </div>
                <div class="block-holder">
                  <input type="checkbox" checked class="agreement" name="aggre"> Saya membaca &amp; menyetujui <a href="<?php echo base_url('bantuan/syarat-dan-ketentuan');?>">syarat &amp; ketentuan pelanggan</a>
                </div>
                <button type="submit" class="process-btn pay-orderNow">SELESAIKAN PESANAN <i class="fa fa-check"></i></button>
            
              </div>
            </div>
          <?php echo form_close();?>
          </div>
        </section>
        <!-- Mt Detail Section of the Page end -->
      </main><!-- Main of the Page end here -->
     