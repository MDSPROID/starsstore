<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
<script type="text/javascript">
	$(document).ready(function(){
		$("#myCarousel").carousel();
	});
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1472453182816875&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<!--- notif -->
<?php 
	$get_notif_setting = notifikasi_homepage();
	if($get_notif_setting['aktif'] == "on"){
		if($get_notif_setting['konten'] == "newsletter"){
?>
<div class="text-center promopopup" style="background-image: url('assets/images/ic_email/not3_bg_image.jpg');">
	<h3 onclick="closepopup();" class="closepopup"><i style="padding: 2px 12px;font-style: normal;font-weight: 300;border: 1px solid white;border-radius: 50px;">X</i></h3>
	<?php echo $get_notif_setting['meta_desc'];?>
	<input type="hidden" name="token_session_config" id="session_token" value="<?php $a=$this->encrypt->encode('Jsd63)263&31).?'); $b=base64_encode($a); echo $b?>">
	<div class="input-group">
    	<input type="text" style="width:100%;height: 50px;" name="newsletter" class="newsletter form-control" id="email" placeholder="Email / whatsapp" required>
    	<span class="input-group-btn">
    		<button onclick="berlangganan();" style="height: 50px;" class="btn mail_sb"><i class="glyphicon glyphicon-envelope"></i></button>
    	</span>
    </div><br>
    <p><?php echo $get_notif_setting['meta_key'];?></p><br>
</div>
<span class="mt-side-custom notifutama active"></span>
<?php }else{ ?>
<div class="text-center promopopupbanner" style="background-color: transparent;">
	<h3 onclick="closepopup();" class="closepopup"><i style="padding: 2px 12px;font-style: normal;font-weight: 300;border: 1px solid white;border-radius: 50px;">X</i></h3>
	<img src="<?php echo $get_notif_setting['site_title'];?>">
</div>
<span class="mt-side-custom notifutama active"></span>
<?php }}?>
			<!-- mt main slider start here -->
			<div class="mt-main-slider">
				<!-- slider banner-slider start here -->
				<div class="slider">
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
						<?php foreach ($get_slider_utama as $i => $banner) { ?>
							<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"<?php echo !$i ? ' class="active"' : ''; ?>></li>
						<?php } ?>
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner">
						 <?php foreach ($get_slider_utama as $i => $row) { 
						 	$aff = $this->encrypt->encode($row->id_banner);
						 	$aff_x = base64_encode($aff);
						 ?>
							<div class="item<?php echo !$i ? ' active' : ''; ?>">
	   							<a data-affiliate="<?php echo $aff_x?>" onclick="banner_affiliate(this);" href="<?php echo $row->link ?>" target="_new">
	      						<img class="lazy img-responsive" src="<?php echo $row->banner ?>" data-original="<?php echo $row->banner;?>" >
	      						</a>
	      					</div>
      					<?php }?>
						</div>

						<!-- Left and right controls -->
						<a class="hidden-xs left carousel-control" href="#myCarousel" data-slide="prev">
							<span style="font-size:50px;margin-top:180px !important;display: none;" class="fa fa-caret-left"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="hidden-xs right carousel-control" href="#myCarousel" data-slide="next">
							<span style="font-size:50px;margin-top:180px !important;display: none;" class="fa fa-caret-right"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
				<!-- slider regular end here -->
			</div><!-- mt main slider end here -->
			<div>
				<div class="col-md-1 hidden-xs" style="display: none;"></div>
				<div class="">
					<?php 
						$b = for_header_front_end_banner_3_utama();
						foreach($b as $u){
							if($u->posisi == "utama_4"){
					?>
						<a href="<?php echo base_url(''.$u->link.'')?>">
							<img class="hidden-xs" src="<?php echo $u->banner?>" style="width: 100%;height: auto;">
							<img class="hidden-lg hidden-md" src="<?php echo $u->for_banner3?>" style="width: 100%;height: auto;">
						</a>
					<?php }}?>
				</div>
				<div class="col-md-1 hidden-xs" style="display: none;"></div>
			</div>
			<!-- mt main start here -->
			<main id="mt-main">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<!-- mt patners start here -->
							<div class="mt-patners brand-tab">
								<h2 class="text-center heading brandfont">TEMUKAN BRAND KAMU</h2>
								<!-- patner slider brand start here -->
								<!-- slide start here -->
								<div id="owl-brand" class="owl-carousel owl-theme hidden-lg hidden-md">
								<?php foreach($brand as $p){?>
									<a href="<?php echo base_url('merk/'.$p->slug.'');?>">
									<div class="item slide brand-sld">
										<!-- mt product start here -->
										<div class="brand-pos">
											<!-- img start here -->
											<div class="img img-brand tab-brand">
												<img alt="image description" src="<?php echo $p->logo?>">
											</div>
										</div>
									</div><!-- slide end here -->
									</a>
								<?php }?>
								</div>
								<ul class="list-inline tab-brand text-center hidden-xs">
									<!-- slide start here -->
									<?php foreach($brand as $br){?>
										<li>
											<a href="<?php echo base_url('merk/'.$br->slug.'');?>">
												<img src="<?php echo $br->logo?>" alt="img" data-name="<?php echo $br->merk?>">
											</a>
										</li>
									<?php }?>
									<!-- slide end here -->
								</ul>
							</div><!-- patner slider end here -->
							<!-- banner-frame start here -->
							<div class="banner-frame">
								<!-- banner-box fourth start here -->
								<div class="banner-box fourth">
									<!-- banner-box sixth start here -->
									<div class="banner-box sixth slider-promo">
										<!-- banner-17 white start here -->
											<?php 
												$b = for_header_front_end_banner_3_utama();
												foreach($b as $u){
													if($u->posisi == "utama_1"){
											?>
											<a class="slider-promoa" href="<?php echo base_url(''.$u->link.'')?>">
												<img class="slide-promo" src="<?php echo $u->banner?>" alt="image description">
											</a>
											<?php }}?>
										<!-- banner-18 right start here -->
										<?php 
											$b = for_header_front_end_banner_3_utama();
											foreach($b as $u){
												if($u->posisi == "utama_2"){
										?>
										<a class="slider-promoa" href="<?php echo base_url(''.$u->link.'')?>">
											<img class="slide-promo" src="<?php echo $u->banner?>" alt="image description">
										</a>
										<?php }}?>
										<!-- banner-21 right start here -->
										<?php 
											$b = for_header_front_end_banner_3_utama();
											foreach($b as $u){
												if($u->posisi == "utama_3"){
										?>
										<a class="slider-promoa" href="<?php echo base_url(''.$u->link.'')?>">
											<img class="slide-promo" src="<?php echo $u->banner?>" alt="image description">
										</a>
										<?php }}?>
										
									</div><!-- banner-box sixth end here -->
								</div><!-- banner-box fourth end here -->
							</div><!-- banner-frame end here -->

							<!-- mt producttabs style2 start here -->
							<div class="mt-producttabs style2 info-catalog wow fadeInUpx" data-wow-delay="0.6s">
								<!-- producttabs start here -->
								<ul class="producttabs">
									<li><a href="#tab1" class="active">TERBARU</a></li>
									<li><a href="#tab2">BEST SELLER</a></li>
								</ul>
								<!-- producttabs end here -->
								<div class="tab-content">
									<div id="tab1">
										<!-- slide start here -->
										<div id="owl-produk" class="owl-carousel owl-theme">
										<?php foreach($get_produk_last as $produkx){?>
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
														<img class="lazyloadedx" alt="image description" src="<?php echo $produkx->gambar?>">
														<div class='hidden curtain'>
															<div class='hidden shine'></div>
														</div>
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
												</div>
											</div><!-- slide end here -->
											</a>
										<?php }?>
										</div>
									</div>
									<div id="tab2">
										<!-- slide start here -->
										<div id="owl-produk2" class="owl-carousel owl-theme">
										<?php foreach($get_produk_discount as $produk){?>
											<a href="<?php echo base_url('produk/'.$produk->slug.'');?>">
											<div class="item slide">
												<!-- mt product start here -->
												<div class="product-3">
													<?php
													if($produk->harga_dicoret > 0 || $produk->harga_dicoret != ""){
													$diskon = round(($produk->harga_dicoret - $produk->harga_fix) / $produk->harga_dicoret * 100);

														echo "<span class='diskon-label'>-".$diskon."%</span>";	
													}?>
													<!-- img start here -->
													<div class="img mask-img">
														<img class="lazyloadedx" alt="image description" src="<?php echo $produk->gambar?>">
														<div class='curtain'>
															<div class='shine'></div>
														</div>
													</div>
													<!-- txt start here -->
													<div class="txt">
														<strong class="title"><?php $nama = word_limiter($produk->nama_produk,4); echo $nama; ?></strong>
														<span class="price">
															<?php if($produk->harga_dicoret == 0 || empty($produk->harga_dicoret)){ 
                                                                  echo "Rp. ".number_format($produk->harga_fix,0,".",".")."";
                                                            }else{
                                                                  echo "<s>Rp. ".number_format($produk->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($produk->harga_fix,0,".",".")."</span>";
                                                            }?>
														</span>
														<?php
															if($produk->rating_produk == 0){
																	echo "<div class='stars0'></div>";
															}elseif($produk->rating_produk <= 5){
																	echo "<div class='stars1'></div>";
															}elseif($produk->rating_produk <= 10){
																	echo "<div class='stars2'></div>";
															}elseif($produk->rating_produk <= 15){
																	echo "<div class='stars3'></div>";
															}elseif($produk->rating_produk <= 20){
																	echo "<div class='stars4'></div>";
															}elseif($produk->rating_produk <= 25 || $produk->rating_produk > 25){	
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
												</div>
											</div><!-- slide end here -->
											</a>
										<?php }?>
										</div>
									</div>
								</div>
							</div><!-- mt producttabs end here -->


							<div class="mt-producttabs style2 wow fadeInUpx" data-wow-delay="0.6s" style="display: none;">
								<!-- producttabs start here -->
								<ul class="producttabs">
									<?php
										$no = 2;
										foreach($get_produk_by_kategori_utama as $k){
										$no++;
										if($no == 3){
											$atv = "active";
										}else{
											$atv = "";
										}
									?>
									<li><a href="#tab<?php echo $no?>" class="<?php echo $atv?>"><?php echo $k->kategori?></a></li>
									<?php }?>
								</ul>
								<!-- producttabs end here -->
								<div class="tab-content">
									<?php 
										$no = 2;
										foreach($get_produk_by_kategori_utama as $j){
										$id_kat = $j->kat_id;
										$no++;
									?>
									<div id="tab<?php echo $no?>">
										<!-- tabs slider start here -->
										<div class="tabs-sliderlg">
											<!-- slide start here -->
											<?php 
												$get_produk = $this->home->get_produk_by_kat_utama($id_kat);
												foreach($get_produk as $h){
											?>
											<a href="<?php echo base_url('produk/'.$h->slug.'');?>">
											<div class="slide">
												<!-- mt product start here -->
												<div class="product-3">
													<!-- img start here -->
													<div class="img mask-img">
														<img alt="image description" src="<?php echo $h->gambar?>">
													</div>
													<!-- txt start here -->
													<div class="txt">
														<strong class="title"><?php $nama = word_limiter($h->nama_produk,4); echo $nama; ?></strong>
														<span class="price">
															<?php if($h->harga_dicoret == 0 || empty($h->harga_dicoret)){ 
                                                                  echo "Rp. ".number_format($h->harga_fix,0,".",".")."";
                                                            }else{
                                                                  echo "<s>Rp. ".number_format($h->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($h->harga_fix,0,".",".")."</span>";
                                                            }?>
														</span>
													</div>
												</div>
											</div><!-- slide end here -->
											</a>
											<?php }?>
										</div><!-- tabs slider end here -->
									</div>
									<?php }?>
								</div>
							</div><!-- mt producttabs end here -->					
						</div>
					</div>
				</div>
			</main>
			