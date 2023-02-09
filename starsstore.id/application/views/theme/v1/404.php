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
<!-- mt main start here -->
<main id="mt-main">
	<div style="width: 100%" class="product-detail-tab wow fadeInUpx" data-wow-delay="0.4s">
		<div class="container">
			<div class="row">
				<div class="col-mxs-12 col-xs-12 text-center" style="margin-top: 80px;">
					<div class="bg-not-found"></div>
					<h2 class="text-center textsorry">Maaf kami tidak bisa menemukan yang anda cari.</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- related products start here -->
	<!-- mt producttabs style3 start here -->
	<div class="wow fadeInUp" data-wow-delay="0.4s">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="mt-producttabs style3 wow fadeInUp" data-wow-delay="0.4s">
						<h2 class="heading">PRODUK LAIN YANG ANDA SUKA</h2>
						<!-- slide start here -->
						<div id="owl-produk" class="owl-carousel owl-theme">
						<?php foreach($produk_lain as $produkx){?>
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
										<strong class="title"><?php $nama = word_limiter($produkx->nama_produk,5); echo $nama; ?></strong>
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
</main><!-- mt main end here -->