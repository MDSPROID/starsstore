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
      <?php if(!$this->cart->contents()){?>
      <div class="row border mar-cart" style="font-family: Montserrat, sans-serif;">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <center><img class="img-mar-cart" src="<?php echo base_url('assets/images/empty-basket.png');?>"></center>
          <h4>Keranjang belanja masih kosong. <br><br><a class="btn mail_sb" href="<?php echo base_url()?>">Belanja dulu yuk</a></h4>
        </div>
      </div>
      <!-- mt producttabs style3 start here -->
      <div class="wow fadeInUpx" data-wow-delay="0.4s">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <div class="mt-producttabs style3 wow fadeInUpx" data-wow-delay="0.4s">
                <h2 class="heading">MUNGKIN ANDA SUKA</h2>
                <!-- slide start here -->
                <div id="owl-produk" class="owl-carousel owl-theme">
                <?php foreach($get_rand as $produkx){?>
                  <a href="<?php echo base_url('produk/'.$produkx->slug.'');?>">
                  <div class="item slide">
                    <!-- mt product start here -->
                    <div class="product-3">
                      <?php
                      if($produkx->harga_dicoret > 0 || $produkx->harga_dicoret != ""){
                      $diskon = round(($produkx->harga_dicoret - $produkx->harga_fix) / $produkx->harga_dicoret * 100);

                        echo "<span class='diskon-label'>-".$diskon."%</span>"; 
                      }?>
                      <!-- img start here -->
                      <div class="img mask-img">
                        <img alt="image description" src="<?php echo $produkx->gambar?>">
                      </div>
                      <!-- txt start here -->
                      <div class="txt">
                        <strong class="title"><?php $nama = word_limiter($produkx->nama_produk,4); echo $nama; ?></strong>
                        <span class="price">
                          <?php if($produkx->harga_dicoret == 0 || empty($produkx->harga_dicoret)){ 
                                echo "Rp. ".number_format($produkx->harga_fix,0,".",".")."";
                          }else{
                                echo "<s>Rp. ".number_format($produkx->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($produkx->harga_fix,0,".",".")."</span>";
                          }?>
                        </span>
                        <?php
            							if($produkx->rating_produk == 0){
            									echo "<div class='stars0'></div>";
            							}elseif($produkx->rating_produk <= 5){
            									echo "<div class='stars1'></div>";
            							}elseif($produkx->rating_produk <= 10){
            									echo "<div class='stars2'></div>";
            							}elseif($produkx->rating_produk <= 15){
            									echo "<div class='stars3'></div>";
            							}elseif($produkx->rating_produk <= 20){
            									echo "<div class='stars4'></div>";
            							}elseif($produkx->rating_produk <= 25 || $produkx->rating_produk > 25){	
            									echo "<div class='stars5'></div>";
            							}
            						?>
                        <?php 
                        $ongkirset = free_ongkir_all_city();
                        $listcity = list_city_freeongkir();
                        if($ongkirset['aktif'] == "on" || $listcity['city'] > 0){
                          echo "<i class='fa fa-truck' style='font-size: 22px;position: absolute;margin-left: -65px;bottom:8px;color: #9741cd;'><i style='font-size: 6px;position: absolute;left: 8.5px;top: 7px;color: white;font-family: arial;'>Free</i></i>";
                        }?>
                      </div>
                    </div><!-- mt product1 center end here -->
                  </div><!-- slide end here -->
                  </a>
                <?php }?>
                </div>
                <!-- slide end here -->
              </div><!-- mt producttabs style3 end here -->
            </div>
          </div>
        </div>
      </div>
      <?php }else{ ?>  
        <!-- Mt Process Section of the Page -->
        <div class="mt-process-sec wow fadeInUpx" data-wow-delay="0.4s">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <ul class="list-unstyled process-list">
                  <li class="active">
                    <span class="counter">01</span>
                    <strong class="title">Keranjang Belanja</strong>
                  </li>
                  <li>
                    <span class="counter">02</span>
                    <strong class="title">Verifikasi Pesanan</strong>
                  </li>
                  <li>
                    <span class="counter">03</span>
                    <strong class="title">Pesanan Selesai</strong>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div><!-- Mt Process Section of the Page end -->
        <!-- Mt Product Table of the Page -->
        <div class="mt-product-table wow fadeInUpx" data-wow-delay="0.4s">
          <div class="container">
            <div class="row border">
              <div class="col-xs-12 col-md-12">
                <div class="woocommerce-message info-success" role="alert"><?php echo $this->session->flashdata('berhasil');?></div>
                <div class="woocommerce-message info-error" role="alert"><?php echo $this->session->flashdata('error');?></div>
              </div>
              <div class="col-xs-3 col-sm-6">
                <strong class="title">PRODUK</strong>
              </div>
              <div class="col-xs-3 col-sm-2">
                <strong class="title">HARGA</strong>
              </div>
              <div class="col-xs-3 col-sm-2">
                <strong class="title">QTY</strong>
              </div>
              <div class="col-xs-3 col-sm-2">
                <strong class="title">TOTAL</strong>
              </div>
            </div>
            <?php 
              $no = 0;
              foreach ($this->cart->contents() as $items): 
              $no++;
            ?>
            <div class="row border <?php echo $this->session->flashdata('notif'.$no.'')?>">
              <div class="col-xs-12 col-sm-2">
                <div class="img-holder">
                  <img src="<?php echo $items['image']?>" alt="image description">
                </div>
              </div>
              <div class="col-xs-3 col-sm-4">
                <strong class="product-name name-cart" style="padding-top: 25px;"><a href="<?php echo base_url('produk/'.$items['slug'].'');?>"><?php echo word_limiter($items['name'],2); ?></a></strong><br>
                <span class="name-cart">Artikel : <?php echo $items['artikel']?></span>
                <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                    <p class='opt-cart'>
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
              </div>
              <div class="col-xs-3 col-sm-2">
                <strong class="price price-cart" style="padding-top: 45px;">
                  <?php if($items['before'] == 0 || empty($items['before'])){ 
                      echo "Rp. ".number_format($items['price'],0,".",".")."";
                  }else{
                      echo "<s style='color:#989898 ;'>Rp. ".number_format($items['before'],0,".",".")."</s> <i style='color:red;font-size:12px;'>-".round(($items['before'] - $items['price']) / $items['before'] * 100)."%</i> <br><span>Rp. ".number_format($items['price'],0,".",".")."</span>";
                  }?>
                </strong>
              </div>
              <div class="col-xs-3 col-sm-2">
                <?php 
                  $a1 = $this->encrypt->encode($items['id']); 
                  $id = base64_encode($a1);

                  $a2 = $this->encrypt->encode($items['name']); 
                  $nm = base64_encode($a2);

                  $a3 = $this->encrypt->encode($items['optidcolor']); 
                  $idc = base64_encode($a3);

                  $a4 = $this->encrypt->encode($items['optidsize']); 
                  $ids = base64_encode($a4);
                ?>
                <fieldset>
                <?php if($items['gender'] != "free_item"){?>
                  <?php echo form_open('cart/update',array('class'=>'qyt-form','style'=>'padding-top: 45px;')); ?>
                  <?php echo form_hidden('rowid', $items['rowid']); ?>
                  <?php echo form_hidden('olbnm', $id);?>
                  <?php echo form_hidden('fqazx', $nm); ?>
                  <?php echo form_hidden('cf', $idc); ?>
                  <?php echo form_hidden('sfz', $ids); ?>
                  <input type="number" style="text-align: center;" name="qty" class="input-text qty text isiqty" step="1" min="0" max="" onkeypress="validate(event);" value="<?php echo $items['qty']; ?>" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric">
                  <button name="update" class="btn-primary" style="padding:3px 8px;border:none;"><i class="fa fa-refresh"></i></button>
                </fieldset>
                <?php echo form_close();?>
                <?php }else{
                  echo "<div style='padding-top:45px;'>1 pcs</div>";
                }?>
              </div>
              <div class="col-xs-3 col-sm-2">
                <strong class="price price-cart" style="padding-top: 45px;">Rp. <?php echo number_format($items['subtotal'],0,".","."); ?></strong>
                <a data-name="<?php echo $items['name'];?>" data-id="<?php echo $items['rowid'];?>" data-tipe="<?php echo $items['gender'];?>" onclick="delete_item(this);" class="remove" aria-label="Remove this item" href="javascript:void(0);"><i style="margin-top: 60px;" class="fa fa-close"></i></a> 
              </div>
              <div class="col-xs-12 col-sm-12">
                <i style="color:red;"><?php echo $this->session->flashdata('baca'.$no.'')?></i>
              </div>
            </div>
            <?php endforeach;?>
            <div class="row">
              <div class="col-xs-12 col-md-7">
                <div class="coupon-form">
                    <fieldset>
                      <div class="mt-holder">
                        <?php if($this->session->userdata('kupon') == ""){?>
                          <input type="text" name="voucherorcoupon" style="text-transform: uppercase;" class="form-control" id="voucher_and_coupon" placeholder="Kode Voucher">
                          <button type="submit" id="sbmtvou" onclick="vou_and_cou(this);">APPLY</button>
                        <?php }else{
                          $vIdx = $this->encrypt->encode($this->session->userdata('kupon'));
                          $Vid = base64_encode($vIdx);
                        ?>
                        <span>Anda menggunakan voucher :</span>
                        <h4><b><?php echo strtoupper($this->session->userdata('kupon'));?></b> <a href="<?php echo base_url('remove_voucher/'.$Vid.'');?>"><i style="float: unset;margin: 0;" class="fa fa-close"></i></a></h4>
                        <?php }?>
                      </div>
                    </fieldset>
                    <div style="color:red;display: none;margin-top: 10px;" class="info-voucher-error"></div>
                </div>
              </div>
              <div class="col-xs-12 col-md-5">
                <ul class="list-unstyled list-coupon">
                  <li style="background-color: inherit;">Voucher :</li>
                  <?php foreach($kupon as $d){?>
                  <li style="text-align: justify;"><input readonly id="<?php echo strtoupper($d->voucher_and_coupons);?>" value="<?php echo strtoupper($d->voucher_and_coupons);?>"><br><span style="font-size: 12px;color: #545454;"><?php echo $d->keterangan;?></span> <label onclick="copyVoucher('<?php echo strtoupper($d->voucher_and_coupons);?>');" class="btn-salin pull-right">salin</label></li>
                  <?php }?>
                </ul>
              </div>
            </div>
          </div>
        </div><!-- Mt Product Table of the Page end -->
        <!-- Mt Detail Section of the Page -->
        <section class="mt-detail-sec style1 wow fadeInUp" data-wow-delay="0.4s" style="margin-top: 0;">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-sm-6">
                <h2>CEK ONGKIR</h2>
                <div class="bill-detail">
                  <fieldset>
                    <div class="form-group">
                      <select class="form-control propKey" name="propinsi_tujuan" id="propinsi_tujuan" required>
                        <option value="">Pilih Provinsi</option>
                        <?php $this->load->view('rajaongkir/getProvince'); ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <select name="kota" id="destination" class="citKey form-control" required>
                        <option value="">Pilih Kota</option>
                      </select>
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
                    <div class="expedisi"></div>
                    <div class="form-group">
                      <button class="update-btn" type="button" onclick="cekValidcity();">CEK ONGKIR <i class="fa fa-refresh"></i></button>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6">
                <h2>TOTAL BELANJA</h2>
                <ul class="list-unstyled block cart">
                  <li>
                    <div class="txt-holder">
                      <strong class="title sub-title pull-left">SUBTOTAL</strong>
                      <div class="txt pull-right">
                        <span>Rp. <t class="subtotal_test">
                          <?php echo number_format($this->cart->total(),0,".","."); ?></t></span>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="txt-holder">
                      <strong class="title sub-title pull-left">VOUCHER</strong>
                      <div class="txt pull-right">
                        <strong class="voucher">
                          <?php if($this->session->userdata('type') == "disc_apply"){ // jika apply voucher disc 

                            //echo "Diskon ".$this->session->userdata('action')."% (".strtoupper($this->session->userdata('kupon')).")";
                            echo "Diskon Rp ".number_format($this->session->userdata('action'),0,".",".")." (".strtoupper($this->session->userdata('kupon')).")";

                          }else if($this->session->userdata("type") == "ongkir_apply"){ // jika apply free ongkir

                           echo "Gratis Pengiriman<br> Kode : ".strtoupper($this->session->userdata('kupon'))."";

                          }else{
                            echo "-";
                          }?>  
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
                        <span>Rp. <t class="subtotal_test"><?php echo $this->session->userdata('unik'); ?></t></span>
                      </div>
                    </div>
                  </li>
                  <li style="border-bottom: none;">
                    <div class="txt-holder">
                      <strong class="title sub-title pull-left">TOTAL</strong>
                      <div class="txt pull-right">
                        <span>
                          Rp. <t class="total_test">
                            <?php 
                            // kode unik sementara tidak dipakai
                            //+ $this->session->userdata('unik');
                            if($this->session->userdata('type') == "disc_apply"){ // jika apply voucher disc 
                              //echo number_format($this->cart->total() - ($this->cart->total() * $this->session->userdata('action') / 100),0,".",".");
                              echo number_format($this->cart->total() - $this->session->userdata('action'),0,".",".");
                            }else if($this->session->userdata("type") == "ongkir_apply"){ // jika apply free ongkir
                              echo number_format($this->cart->total(),0,".",".");
                            }else{ 
                              echo number_format($this->cart->total(),0,".",".");
                            }?>  
                        </t></span>
                      </div>
                    </div>
                  </li>
                </ul>
                <a href="<?php echo base_url('checkout/'.$id_transaksi.'')?>" class="process-btn">BAYAR PESANAN <i class="fa fa-check"></i></a>
              </div>
            </div>
          </div>
        </section>
        <!-- Mt Detail Section of the Page end -->
      <?php }?>
      </main><!-- Main of the Page end here -->