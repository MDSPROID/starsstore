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
	$merkdisplay = "";
	if($this->uri->segment(1) == "terbaru" || $this->uri->segment(1) == "merk"){
	if($this->uri->segment(2) != "highlight"){
		$merkdisplay = "style='display:none;'";
	}}else{
		$merkdisplay = "";
	} 
?>
		<?php 
			$margin_katalog = "";
			if($this->uri->segment(1) == "terbaru" || $this->uri->segment(1) == "merk"){
			if($this->uri->segment(2) != "highlight"){
			$margin_katalog = "marg-catalog";//"marg-catalog";
			if($banner != ""){
		?>
			<!-- Wrapper for slides -->
			<main id="mt-main">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<div class="banner-brand-utama">
								<img class="lazy img-responsive" src="<?php echo $banner?>" data-original="<?php echo $banner;?>" >
							</div>
						</div>
					</div>
				</div>
			</main>
			<?php }}}?>

			<!-- mt main start here -->
			<main id="mt-main">
				<!-- Mt Contact Banner of the Page -->
				<section class="mt-contact-banner style4 wow fadeInUpx" data-wow-delay="0.4s" style="background-image: url(http://placehold.it/1920x205);display: none;">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h1></h1>
								<!-- Breadcrumbs of the Page --> 
								<nav class="breadcrumbs">
									<ul class="list-unstyled">
										<li><a href="<?php echo base_url()?>">Home <i class="fa fa-angle-right"></i></a></li>
										<li><a href="">Products <i class="fa fa-angle-right"></i></a></li>
										<li></li>
									</ul>
								</nav><!-- Breadcrumbs of the Page end -->
							</div>
						</div>
					</div>
				</section><!-- Mt Contact Banner of the Page end -->
				<div class="container"> 
					<div class="row">
						<input type="hidden" id="ftj" name="ftj" value="<?php echo $kategori_ins?>">
						<input type="hidden" id="bds" value="<?php echo $this->uri->segment(1)?>">
						<!-- sidebar of the Page start here -->
						<aside id="sidebar" class="sidebar-filter sidebar-filter-row col-xs-12 col-sm-4 col-md-3 wow fadeInUpx" data-wow-delay="0.4s">
							<!-- shop-widget filter-widget of the Page start here -->
							<section class="shop-widget filter-widget bg-grey" style="padding: 16px 20px;">
								<h2>FILTER PRODUK <span class="btn-x-filter hidden-lg hidden-md closefilter">X</span></h2>
								<span class="sub-title">Kisaran harga</span>
								<div class="price-range pd-filter">
									<input type="number" id="minH" class="form-control" name="min_price" placeholder="Harga Terendah" style="margin-bottom: 10px;" />
									<input type="number" id="maxH" name="max_price" class="form-control" placeholder="Harga Tertinggi" style="margin-bottom: 10px;" />
									<button type="submit" class="btn filter-btn" onclick="searchFilter();">Filter harga</button>
								</div>
								<span <?php echo $merkdisplay?> class="sub-title">Merk</span>
								<div class="pd-filter" <?php echo $merkdisplay?>>
									<!-- nice-form start here -->
									<select id="brand" class="form-control no-b" onchange="searchFilter();">
										<option value="">Pilih Merk</option>
									<?php foreach($brand as $b):?>
										<option value="<?php echo $b->merk_id?>"><?php echo $b->merk?></option>
									<?php endforeach;?>
									</select>
								</div>
								<span class="sub-title">Ukuran</span>
								<div class="pd-filter">
									<select name="sizee" class="form-control no-b get_sie" style="display: block;" onchange="searchFilter();">
										<option value="">Semua Ukuran</option>
									<?php 
										foreach($ukuran as $k):
										$idz = $this->encrypt->encode($k->id_opsi_size); 
										$id_size = base64_encode($idz);
										if($k->opsi_size != "Semua"){
									?>		
									<option value="<?php echo $id_size?>"><?php echo $k->opsi_size?></option>						
									<?php }endforeach;?>
									</select>
								</div>
								<span class="sub-title">Warna</span>
								<div class="pd-filter">
									<?php 
										foreach($warna as $opt):
										$idc = $this->encrypt->encode($opt->id_opsi_color); 
										$id_color = base64_encode($idc);
										// Manajement Color
						                if($opt->opsi_color == "Hitam"){
						                    $bgcl = "black";
						                    $bginfo = "Hitam";
						                }else if($opt->opsi_color == "Biru"){
						                    $bgcl = "blue";
						                    $bginfo = "Biru";
						                }else if($opt->opsi_color == "Coklat"){
						                    $bgcl = "brown";
						                    $bginfo = "Coklat";
						                }else if($opt->opsi_color == "Hijau"){
						                    $bgcl = "green";
						                    $bginfo = "Hijau";
						                }else if($opt->opsi_color == "Oranye"){
						                    $bgcl = "orange";
						                    $bginfo = "Oranye";
						                }else if($opt->opsi_color == "Pink"){
						                    $bgcl = "pink";
						                    $bginfo = "Pink";
						                }else if($opt->opsi_color == "Ungu"){
						                    $bgcl = "purple";
						                    $bginfo = "Ungu";
						                }else if($opt->opsi_color == "Merah"){
						                    $bgcl = "red";
						                    $bginfo = "Merah";
						                }else if($opt->opsi_color == "Putih"){
						                    $bgcl = "white;border:1px solid #ccc;";
						                    $bginfo = "Putih";
						                }else if($opt->opsi_color == "Kuning"){
						                    $bgcl = "yellow";
						                    $bginfo = "Kuning";
						                }else if($opt->opsi_color == "Abu-Abu"){
						                    $bgcl = "grey";
						                    $bginfo = "Abu-Abu";
						                }else if($opt->opsi_color == "Semua"){
						                	$bgcl = "-";
						                    $bginfo = "-";
						                }
									?>
									<input type="checkbox" onclick="searchFilter();" class="forms__check hidden get_clx" id="check-<?php echo $id_color?>" name="colourr[]" value="<?php echo $id_color?>">
						            <label class="b-filter__check forms__label forms__label-check forms__label-check-3" for="check-<?php echo $id_color?>" style="background-color:<?php echo $bgcl;?>;border-radius: 50px;width:15px;height:15px;margin:0;margin-right: 4px !important;"></label>
								<?php endforeach;?>
								</div>
								<span class="btn-filter-sort bt-sort-fil">TUTUP</span>
							</section><!-- shop-widget filter-widget of the Page end here -->
							<!-- shop-widget of the Page start here -->
						</aside>
						<!-- sidebar of the Page end here col-xs-12 col-sm-8 col-md-9 -->
						<div class="col-xs-12 col-sm-8 col-md-9 wow fadeInRightx" data-wow-delay="0.4s">
							<!-- mt shoplist header start here -->
							<header class="mt-shoplist-header <?php echo $margin_katalog?>">
								<!-- btn-box start here -->
								<div class="btn-box filter-sort-btn">
									<h4 class="hidden-lg hidden-md fil-btn"><i class="fa fa-filter"></i> Filter</h4>
								</div>
								<div class="btn-box">
									<select style="border-radius: 0;" name="orderby" class="orderby form-control" id="sortBy" onchange="searchFilter();">
										<option value="">Sort by</option>
				                        <option value="asc">Nama (A > Z)</option>
				                        <option value="desc">Nama (Z > A)</option>
				                        <option value="asc_price">Harga Terendah > Harga Tertinggi</option>
				                        <option value="desc_price">Harga Tertinggi > Harga Terendah</option>
									</select>												
								</div>
								<!-- btn-box end here -->
							</header><!-- mt shoplist header end here -->
							<!-- mt productlisthold start here -->
							<ul class="mt-productlisthold list-inline" id="postList">
								<?php if(!empty($posts)): foreach($posts as $pk): ?>
								<li>
									<!-- mt product1 large start here -->
									<div class="product-3 product-on-catalog">
										<?php 
											if($pk->harga_dicoret > 0 || $pk->harga_dicoret != ""){
												$diskon = round(($pk->harga_dicoret - $pk->harga_fix) / $pk->harga_dicoret * 100);
												echo "<span style='float:right;color:white;background-color:red;width:32px;font-family: Montserrat, sans-serif;padding: 9px 5px;border-radius:50px;font-size:10px;position:absolute;margin-left:50px;'>-".$diskon."%</span>";	
										}?>
										<div class="box mask-img-cat">
											<div class="b1">
												<div class="b2">
													<a href="<?php echo base_url('produk/'.$pk->slug_produk.'');?>">
														<img src="<?php echo $pk->gambar?>" alt="image description">
													</a>
												</div>
											</div>
										</div> 
										<div class="txt">
											<strong class="title"><a href="<?php echo base_url('produk/'.$pk->slug_produk.'');?>"><?php $nama = word_limiter($pk->nama_produk,4); echo $nama; ?></a></strong>
											<span class="price">
												<?php if($pk->harga_dicoret == 0 || empty($pk->harga_dicoret)){ 
                                                      echo "Rp. ".number_format($pk->harga_fix,0,".",".")."";
                                                }else{
                                                      echo "<s>Rp. ".number_format($pk->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($pk->harga_fix,0,".",".")."</span>";
                                                }?>
											</span>
											<?php 
				                            $ongkirset = free_ongkir_all_city();
				                            $listcity = list_city_freeongkir();
				                            if($ongkirset['aktif'] == "on" || $listcity['city'] > 0){
				                             	$freeongkir = "<i class='fa fa-truck' style='font-size: 22px;bottom:8px;color: #9741cd;margin-right:110px;'><i style='font-size: 6px;position: absolute;left: 8.5px;top: 7px;color: white;font-family: arial;'>Free</i></i>";
				                            }else{
				                            	$freeongkir = "";
				                            }?>
											<?php
												if($pk->rating_produk == 0){
														echo "<div class='stars0'>".$freeongkir."</div>";
												}elseif($pk->rating_produk <= 5){
														echo "<div class='stars1'>".$freeongkir."</div>";
												}elseif($pk->rating_produk <= 10){
														echo "<div class='stars2'>".$freeongkir."</div>";
												}elseif($pk->rating_produk <= 15){
														echo "<div class='stars3'>".$freeongkir."</div>";
												}elseif($pk->rating_produk <= 20){
														echo "<div class='stars4'>".$freeongkir."</div>";
												}elseif($pk->rating_produk <= 25 || $pk->rating_produk > 25){	
														echo "<div class='stars5'>".$freeongkir."</div>";
												}
											?>
										</div>
									</div><!-- mt product1 center end here -->
								</li>
								<?php endforeach; else: ?>
								<li>
									<div class="col-md-12 text-center" style="padding: 15px;"><h5 style="margin-top: 60px;">Pencarian tidak ditemukan, coba kata kunci lain.</h5></div>
								</li>
								<?php endif; ?>
								<div class="col-xs-12 text-center"><?php echo $this->ajax_pagination->create_links(); ?></div>
							</ul><!-- mt productlisthold end here -->
						</div>
					</div>
				</div>
			</main><!-- mt main end here -->
		