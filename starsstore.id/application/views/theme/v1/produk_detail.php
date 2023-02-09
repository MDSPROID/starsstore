<link rel="stylesheet" href="<?php echo base_url('assets/global/style.css');?>" type="text/css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/global/functions.js');?>"></script>
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
<script type="text/javascript">
	$(document).ready(function(){
		$('.show').zoomImage();
		$('.show-small-img:first-of-type').css({'border': 'solid 1px #951b25', 'padding': '2px'})
		$('.show-small-img:first-of-type').attr('alt', 'now').siblings().removeAttr('alt')
		$('.show-small-img').click(function () {
		  	$('#show-img').attr('src', $(this).attr('src'))
		  	$('#big-img').attr('src', $(this).attr('src'))
		  	$(this).attr('alt', 'now').siblings().removeAttr('alt')
		  	$(this).css({'border': 'solid 1px #951b25', 'padding': '2px'}).siblings().css({'border': 'none', 'padding': '0'})
		  	if ($('#small-img-roll').children().length > 4) {
		    	if ($(this).index() >= 3 && $(this).index() < $('#small-img-roll').children().length - 1){
			      $('#small-img-roll').css('left', -($(this).index() - 2) * 76 + 'px')
			    } else if ($(this).index() == $('#small-img-roll').children().length - 1) {
			      $('#small-img-roll').css('left', -($('#small-img-roll').children().length - 4) * 76 + 'px')
			    } else {
			      $('#small-img-roll').css('left', '0')
			    }
		  	}
		});
		$('#next-img').click(function (){
		  	$('#show-img').attr('src', $(".show-small-img[alt='now']").next().attr('src'))
		  	$('#big-img').attr('src', $(".show-small-img[alt='now']").next().attr('src'))
		  	$(".show-small-img[alt='now']").next().css({'border': 'solid 1px #951b25', 'padding': '2px'}).siblings().css({'border': 'none', 'padding': '0'})
		  	$(".show-small-img[alt='now']").next().attr('alt', 'now').siblings().removeAttr('alt')
		  	if ($('#small-img-roll').children().length > 4) {
		    	if ($(".show-small-img[alt='now']").index() >= 3 && $(".show-small-img[alt='now']").index() < $('#small-img-roll').children().length - 1){
		      		$('#small-img-roll').css('left', -($(".show-small-img[alt='now']").index() - 2) * 76 + 'px')
		    	} else if ($(".show-small-img[alt='now']").index() == $('#small-img-roll').children().length - 1) {
		      		$('#small-img-roll').css('left', -($('#small-img-roll').children().length - 4) * 76 + 'px')
		    	} else {
		      		$('#small-img-roll').css('left', '0')
		    	}
		  	}
		});

		$('#prev-img').click(function (){
  			$('#show-img').attr('src', $(".show-small-img[alt='now']").prev().attr('src'))
  			$('#big-img').attr('src', $(".show-small-img[alt='now']").prev().attr('src'))
  			$(".show-small-img[alt='now']").prev().css({'border': 'solid 1px #951b25', 'padding': '2px'}).siblings().css({'border': 'none', 'padding': '0'})
  			$(".show-small-img[alt='now']").prev().attr('alt', 'now').siblings().removeAttr('alt')
  			if ($('#small-img-roll').children().length > 4) {
    			if ($(".show-small-img[alt='now']").index() >= 3 && $(".show-small-img[alt='now']").index() < $('#small-img-roll').children().length - 1){
      				$('#small-img-roll').css('left', -($(".show-small-img[alt='now']").index() - 2) * 76 + 'px')
    			} else if ($(".show-small-img[alt='now']").index() == $('#small-img-roll').children().length - 1) {
      				$('#small-img-roll').css('left', -($('#small-img-roll').children().length - 4) * 76 + 'px')
    			} else {
      				$('#small-img-roll').css('left', '0')
    			}
  			}
		});
	});
</script>
<?php
foreach($detail_k as $produk):
foreach($kategori as $kat): 
?> 
<!-- mt main start here -->
<main id="mt-main">
	<!-- Mt Product Detial of the Page -->
	<section class="mt-product-detial wow fadeInUpx" data-wow-delay="0.4s">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 prd">
					<div class="woocommerce-message info-success" role="alert"><?php echo $this->session->flashdata('berhasil');?><?php echo $this->session->flashdata('error');?></div>
					<?php foreach($kupon as $gc){?>
						<div style="display:none;padding: 15px 5px;border-radius: 50px;color: white;font-weight: bold;background-color: red;position: absolute;right: 10px;top: -10px;font-size: 7px;">VOUCHER</div>
						<div class="woocommerce-message coupon-label-produk" style="display:none;">
							<b style="font-weight: bold;">GUNAKAN VOUCHER</b><br>
							<b style="color: red;"><input style="border:none;" readonly id="<?php echo strtoupper($gc->voucher_and_coupons);?>" value="<?php echo strtoupper($gc->voucher_and_coupons);?>"></b><br>
							<span style="font-size: 12px;color: #545454;">Saat berbelanja di starsstore.id</span> 
							<label onclick="copyVoucher('<?php echo strtoupper($gc->voucher_and_coupons);?>');" class="btn-salin pull-right">salin</label>
						</div>
					<?php }?>
					<!-- PRODUCT -->
					<div class="slider">
						<?php 
							$gambarutama = 0;
							foreach ($gambar_tambahan as $i => $gbrutama){ 
							$gambarutama++;
							if($gambarutama == 1){
						?>
						<div class="show" href="<?php echo $gbrutama->gambar_tambah;?>">
						  	<img src="<?php echo $gbrutama->gambar_tambah;?>" id="show-img">
						</div>
						<?php }}?>
						<div class="small-img">
						  	<div class="small-container">
						    	<div id="small-img-roll">
						    		<?php foreach ($gambar_tambahan as $i => $gbrt){ ?>
						      			<img src="<?php echo $gbrt->gambar_tambah;?>" class="show-small-img" alt="">
						      		<?php }?>
						    	</div>
						  	</div>
						</div>
					</div>

					<div class="slider" style="display: none;">
						<!-- Comment List of the Page -->
						<!-- Product Slider of the Page -->
						<div class="">
							<?php foreach ($gambar_tambahan as $i => $gbrt){ ?>
							<div class="slide">
								<img src="<?php echo $gbrt->gambar_tambah;?>" alt="image descrption">
							</div>
							<?php }?>
						</div>
						<!-- Product Slider of the Page end -->
						<!-- Pagg Slider of the Page -->
						<ul class="list-unstyled slick-slider pagg-slider">
						<?php foreach ($gambar_tambahan as $i => $gbrt){ ?>
							<li><div class="img"><img src="<?php echo $gbrt->gambar_tambah;?>" alt="image description"></div></li>
						<?php }?>
						</ul>
						<!-- PRODUCT end -->
					</div>
					<!-- Slider of the Page end -->
					<!-- Detail Holder of the Page -->
					<div class="detial-holder" style="padding:0;">
						<a style="border:1px solid #ccc;padding:5px 8px;background-color:white;position: absolute;right: 0px;" href="<?php echo base_url('produk/'.$next_produk['slug'].'');?>"><i class="fa fa-arrow-right"></i></a>
						<h2><?php echo $produk->nama_produk;?></h2>
						<div class="text-holder">
							<span class="text-holder b-goods-det__price">
								<?php if($produk->harga_dicoret == 0 || empty($produk->harga_dicoret)){ 
                                      echo "<span class='price'>Rp. ".number_format($produk->harga_fix,0,".",".")."</span>";
                                      $get_be = "0";
                                      $get_atx = $this->encrypt->encode($produk->harga_fix);
                                      $get_at = base64_encode($get_atx);
                                }else{
                                      echo "<span class='price'>Rp. ".number_format($produk->harga_fix,0,".",".")." <del>Rp. ".number_format($produk->harga_dicoret,0,".",".")."</del><label class='label-diskon-detail'>".round(($produk->harga_dicoret - $produk->harga_fix) / $produk->harga_dicoret * 100)."%</label></span> ";
                                      $get_bex = $this->encrypt->encode($produk->harga_dicoret);
                                      $get_be = base64_encode($get_bex);
                                      $get_atx = $this->encrypt->encode($produk->harga_fix);
                                      $get_at = base64_encode($get_atx);
                                }?>
                                <label style="background-color: #9741cd;color: white;padding: 5px 8px;border-radius: 50px;">
                                <?php 
	                            $ongkirset = free_ongkir_all_city();
	                            $listcity = list_city_freeongkir();
	                            if($ongkirset['aktif'] == "on" || $listcity['city'] > 0){
	                             	echo "<i class='fa fa-truck' style='font-size: 14px;bottom:8px;color: white;margin-right:5px;'></i><i style='font-size:14px;color: white;font-family: arial;'>Free Ongkir</i>";
	                            }?>
	                        	</label>
	                        </span> 
						</div>
						<!-- Product Form of the Page -->
						<?php echo form_open('#',array('class'=>'product-form','style'=>'margin-bottom:20px;'));?>
							<fieldset>
								<div class="row-val row">
									<div class="row">
										<div class="col-md-12 col-xs-12" style="margin-bottom: 20px;">
											<label for="pa_color" class="inf-clx">Warna</label>
											<?php
												foreach($get_option_color as $opt){

												if($opt->id_opsi_color == 1){
													$clx = "-";
													echo "<span style='color:black;font-size:25px;'>-</span>";
												}else{

													$clx = "";

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
	                                                }

	                                                if($opt->stok > 0){
	                                                    $copt   = $opt->opsi_color;
	                                                    $idcopt = $opt->id_opsi_get_color;

	                                                    $a1x = $this->encrypt->encode($idcopt); 
	                                                    $b1x = base64_encode($a1x);
	                                                    // size dengan warna yang sama
	                                                    $a2x = $this->encrypt->encode($copt); 
	                                                    $b2x = base64_encode($a2x);

	                                                    if($opt->opsi_color == "Putih"){
	                                                        $ic = "<i class='glyphicon glyphicon-ok' style='color:#949494;'></i>";
	                                                    }else{
	                                                        $ic ="<i class='glyphicon glyphicon-ok'></i>";
	                                                    }
											?>	
											<?php //echo $bgcl;?>
												<input type="radio" onclick="selClx();" class="forms__check hidden get_clx" id="check-<?php echo $opt->id_opsi_get_color?>" name="opt_clx[]" value="<?php echo $b1x.'|'.$b2x?>" checked>
	                            				<label class="b-filter__check forms__label forms__label-check forms__label-check-3" for="check-<?php echo $opt->id_opsi_get_color?>" style="background-color:white;width: auto;height: 30px;font-size: 12px;font-weight: bold;padding: 6.5px 20px !important;line-height: normal;margin-left: 5px;"><?php echo $bginfo?></label>
												<?php }}}?>
										</div>

										<div class="col-md-12 col-xs-12" style="margin-bottom: 20px;">
											<label for="pa_color" class="inf-szx">Ukuran</label>
											<?php foreach($get_option_size as $size){
												if($size->id_opsi_size == 1){
													$szx = "-";
													echo "<span style='color:black;font-size:25px;'>-</span>";
												}else{
													$szx = "";
	                                                if($size->stok > 0){
	                                                    $a1 = $this->encrypt->encode($size->id_opsi_get_size); 
	                                                    $b1 = base64_encode($a1);
	                                                    // size dengan warna yang sama
	                                                    $a2 = $this->encrypt->encode($size->opsi_size); 
	                                                    $b2 = base64_encode($a2);
	                                        ?>
											<input type="radio" onclick="getPr();" class="forms__check hidden get_sie" id="check-<?php echo $size->id_opsi_get_size?>" name="opt[]" value="<?php echo $b1.'|'.$b2?>">
	                                        <label style="padding-top: 4px;" class="b-filter__check forms__label forms__label-check forms__label-check-3" for="check-<?php echo $size->id_opsi_get_size?>"><?php echo $size->opsi_size?></label>
	                                        <?php }}}?>
										</div>
									</div>
									<?php 
					                  $get_data_set = company_profile();
					                  if($get_data_set['aktif'] == "on"){
					                ?>
					                <div class="col-md-12 col-xs-12" style="margin-bottom: 20px;">
					                	<h5 class="text-center" style="color:red;"><i>Dapatkan di toko stars terdekat dikota anda.</i></h5>
					                </div>
					                <?php }else{?>
									<div class="col-md-12 col-xs-12" style="margin-bottom: 20px;">
										<div class="row-val">
											<label for="qty" style="margin-right: 53px;">qty</label>
											<input type="number" id="qty" class="rowcount qty" step="1" min="1" name="quantity" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" placeholder="1">
										</div>
										<div class="row-val">
											<button type="button" class="b-goods-det__btn" onclick="one_logic_key()">BELI <i class="fa fa-basket"></i></button>
										</div>
										<a class="hidden-xs" style="font-size: 25px;" href="<?php echo base_url('add-to-wishlist/')?><?php $a = $this->encrypt->encode($produk->idp); $b = base64_encode($a); echo $b?>"><i style="color:#959595;" class="fa fa-heart"></i></a>
									</div>
									<?php }?>
								</div>
							</fieldset>
							<input type="hidden" name="get_moderate" id="get_m" value="<?php $a = $this->encrypt->encode($produk->idp); $b = base64_encode($a); echo $b?>">
                            <input type="hidden" name="get_cl" id="get_cl" value="<?php echo $clx?>">
                            <input type="hidden" name="get_sz" id="get_sz" value="<?php echo $szx?>">
                            <input type="hidden" name="get_gm" id="get_gm" value="<?php $a = $this->encrypt->encode($produk->gbr); $b = base64_encode($a); echo $b?>">
                            <input type="hidden" name="get_pd_n" id="get_pd_n" value="<?php $a = $this->encrypt->encode($produk->nama_produk); $b = base64_encode($a); echo $b?>">
                            <input type="hidden" name="gsg" id="gsg" value="<?php $a = $this->encrypt->encode($produk->slug_produk); $b = base64_encode($a); echo $b?>">
                            <input type="hidden" name="atl" id="atl" value="<?php $a = $this->encrypt->encode($produk->artikel); $b = base64_encode($a); echo $b?>">
                            <input type="hidden" name="get_mr" id="get_mr" value="<?php $a = $this->encrypt->encode($produk->merk); $b = base64_encode($a); echo $b?>">
                            <input type="hidden" name="get_pt" id="get_pt" value="<?php $a = $this->encrypt->encode($produk->point); $b = base64_encode($a); echo $b?>">
                            <input type="hidden" name="get_bt" id="get_bt" value="<?php $a = $this->encrypt->encode($produk->berat); $b = base64_encode($a); echo $b?>">
                            <input type='hidden' name='get_be' id='get_be' value="<?php echo $get_be?>"> 
                            <input type='hidden' name='get_at' id='get_at' value="<?php echo $get_at?>">
						<?php echo form_close();?>
						<div class="txt-wrap">
							<?php echo $produk->keterangan?>
							<?php 
							    $g = $get_size_produk->row_array();
							    echo "Kode Produk : ".$g['artikel']."<br>Size Chart (EU) :<br>";
							    $j2 = array();
							    foreach($get_size_produk->result() as $u){
							      $j2[] = "Size ".$u->opsi_size." Panjang ".$u->cm."cm <br>";
							    }
							    $size1 = implode('|',$j2);
							    $size = str_replace('|', '', $size1);
							    echo $size;
							    echo "<br>*Tanyakan ketersediaan stok kepada kami*<br>Happy Shopping !";
							?>
							<div style="display: none;">
							Kode Produk : <?php echo $produk->artikel?><br>
							Ukuran Tersedia : 
							<?php foreach($get_option_size as $size){
								if($size->id_opsi_size == 1){
									$szx = "-";
									echo "<span style='color:black;font-size:25px;'>-</span>";
								}else{
									$szx = "";
                                    if($size->stok > 0){
                                        $a1 = $this->encrypt->encode($size->id_opsi_get_size); 
                                        $b1 = base64_encode($a1);
                                        // size dengan warna yang sama
                                        $a2 = $this->encrypt->encode($size->opsi_size); 
                                        $b2 = base64_encode($a2);
                            ?>
                            <?php echo $size->opsi_size?>, 
                            <?php }}}?>
                            <br>
                            <i style="font-size: 10px;display: none;">*mohon tanyakan terlebih dahulu ketersediaan stok ukuran yang anda pilih</i><br><br>
                        	</div>
						</div>
						<!-- Product Form of the Page end -->
						<ul class="list-unstyled list sosmed">
							<li class="hidden-xs" style="font-size: 12px;font-weight: bold;">Share produk ini </li>
							<li><a class="facebook social-icon" title="facebook" onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $produk->nama_produk; ?>&amp;p<?php echo base_url('produk/')?><?php echo $produk->slug_produk?>', 'sharer', 'toolbar=0,status=0,width=550,height=400');" target="_parent" href="javascript: void(0);"><i class="fa fa-facebook"></i></a></li>
							<li><a class="twitter social-icon" title="twitter" onClick="window.open('http://twitter.com/share?source=sharethiscom&text=<?php echo $produk->nama_produk;?>&url=<?php echo base_url('produk/')?><?php echo $produk->slug_produk?>&via=starsallthebest');" target="_parent" href="javascript: void(0);"><i class="fa fa-twitter"></i></a></li>
							
							<li><a class="pinterest social-icon" title="whatsapp" target="_new" href="https://api.whatsapp.com/send?text=<?php echo base_url('produk/')?><?php echo $produk->slug_produk?>"><i class="fa fa-whatsapp"></i></a></li>

							<li><a target="_new" title="line" href="http://www.addtoany.com/add_to/line?linkurl=<?php echo base_url('produk/detail/')?><?php echo $produk->slug_produk?>"><label class="line"></label></a></li>
							<li><a class="hidden-lg hidden-md" href="<?php echo base_url('add-to-wishlist/')?><?php $a = $this->encrypt->encode($produk->idp); $b = base64_encode($a); echo $b?>"><i style="color:#959595;" class="fa fa-heart"></i></a></li>
						</ul>
					</div>
					<!-- Detail Holder of the Page end -->
				</div>
			</div>
		</div>
	</section><!-- Mt Product Detial of the Page end -->
	<div class="product-detail-tab wow fadeInUpx" data-wow-delay="0.4s">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<ul class="mt-tabs texttabs text-center text-uppercase">
						<li><a href="#tab1">TANYA PRODUK</a></li>
						<li><a href="#tab2" class="active">REVIEW PRODUK</a></li>
					</ul>
					<div class="tab-content">
						<div id="tab1">
							<div class="product-comment">
								<div class="col-md-12 col-xs-12 text-center" style="margin-bottom: 20px;">
			    					<a class="btn btn-success" style="color: white;" target="_new" href="https://api.whatsapp.com/send?phone=6281377711300&text=Hai%20Starsholic,%20Saya%20ingin%20menanyakan%20produk%20<?php echo $produk->nama_produk?>%20-%20<?php echo $produk->artikel?>"><i class="fa fa-whatsapp"></i> Tanya via whatsapp</a>
			    				</div>
								<?php echo form_open('sb_qna', array('class'=>'pertanyaan p-commentform'))?>
								<?php 
									$idp1 = $this->encrypt->encode($produk->idp);
									$idp2 = base64_encode($idp1);
				    			?>
									<fieldset>
										<input type="hidden" name="qnaP" value="<?php echo $idp2?>">
										<input type="hidden" name="nmp" value="<?php echo $produk->nama_produk?>">
										<div class="mt-row">
											<label>NAMA</label>
											<input type="text" name="nm_qna" class="form-control" required>
										</div>
										<div class="mt-row">
											<label>PERTANYAAN</label>
											<textarea name="qna" class="form-control" required></textarea>
										</div>
										<button type="submit" class="btn-type4">KIRIM PERTANYAAN</button>
									</fieldset>
								<?php echo form_close();?>
								<?php 
					    			if(count($qna) == 0){
					    				echo "<div class='col-md-12 col-xs-12 text-center df_komen' style='border-bottom:1px solid #929292;'>Jadilah orang pertama yang menanyakan produk ini.</div>";
					    			}else{
					    				echo "<div class='col-md-12 col-xs-12 df_komen'>
						    					<div id='reviews' class='woocommerce-Reviews'>
													<div id='comments'>
														<ul class='commentlist list-unstyled'>";
					    				foreach($qna as $t){
						    					echo "<li class='comment byuser comment-author-admin bypostauthor even thread-even depth-1'>
														<div id='comment-62' class='comment_container'>
															<div class='comment-text'>
																<p class='meta' style='margin-bottom:0;'>
																	<strong class='woocommerce-review__author'>".$t->nama." </strong>
																	<span class='woocommerce-review__dash'>&ndash;</span> <time class='woocommerce-review__published-date'>".date('d F Y H:i:s', strtotime($t->tgl_q_n_a))."</time>
																</p>
																<div class='description'><p>".$t->pertanyaan."</p>
																</div>
															</div>
														</div>
													</li>";
													if(!empty($t->nama_balas)){
														echo "<li class='comment byuser comment-author-admin bypostauthor even thread-even depth-1' style='margin-left:50px;'>
															<div id='comment-62' class='comment_container'>
															<div class='comment-text'>
																<p class='meta' style='margin-bottom:0;'>
																	<strong class='woocommerce-review__author'>".$t->nama_balas." </strong>
																	<span class='woocommerce-review__dash'>&ndash;</span> <time class='woocommerce-review__published-date'>".date('d F Y H:i:s', strtotime($t->tgl_balas))."</time>
																</p>
																<div class='description'><p>".$t->balasan."</p>
																</div>
															</div>
														</div>
														</li>";
													}
						    			}
						    			echo "</ul></div></div></div>";
						    		}
					    		?>
				    		</div>
						</div>
						<div id="tab2">
							<div class="product-comment review">
								<?php
					    			if($rev->num_rows() == 0 ){
					    				echo "<center><img src=".base_url('assets/images/no-review.png')." style='height:80px;width:auto;'>Belum ada Review!</center>";
					    			}else{
					    				foreach($rev->result() as $g){
					    				echo"<div class='review_box text-center' style='padding-bottom: 10px;border-bottom: 1px dashed grey;margin-bottom: 10px;'>
					    						<h5 class='pereview'>
					    							<b>$g->nama_review</b><br>
					    							<img src='".base_url('assets/images/rating/'.$g->grating.'')."' style='height:15px;width:auto;margin-bottom:10px;'>
					    						</h5>
					    						<p class='koment'>$g->review</p>
					    						<i style='font-size:12px;'>".date('d F Y H:i:s',strtotime($g->tgl_review))."</i>
					    					</div>";
					    				}
					    			}
					    		?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- related products start here -->
	<!-- mt producttabs style3 start here -->
	<div class="wow fadeInUpx" data-wow-delay="0.4s">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="mt-producttabs style3 wow fadeInUpx" data-wow-delay="0.4s">
						<h2 class="heading">PRODUK LAIN</h2>
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
	<div class="vertical-nav-holder" style="display: none;">
		<a href="#" class="vertical-nav-btn"><i class="fa fa-share-alt"></i></a>

		<div class="vertical-nav" style="display: none;">
			<ul>
				<li>
					<a class="facebook social-icon" title="facebook" onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $produk->nama_produk; ?>&amp;p<?php echo base_url('produk/')?><?php echo $produk->slug_produk?>', 'sharer', 'toolbar=0,status=0,width=550,height=400');" target="_parent" href="javascript: void(0);"><i class="fa fa-facebook"></i></a>
				</li>

				<li>
					<a class="twitter social-icon" title="twitter" onClick="window.open('http://twitter.com/share?source=sharethiscom&text=<?php echo $produk->nama_produk;?>&url=<?php echo base_url('produk/')?><?php echo $produk->slug_produk?>&via=starsallthebest');" target="_parent" href="javascript: void(0);"><i class="fa fa-twitter"></i></a>
				</li>

				<li>
					<a class="pinterest social-icon" title="whatsapp" target="_new" href="https://api.whatsapp.com/send?text=<?php echo base_url('produk/')?><?php echo $produk->slug_produk?>"><i class="fa fa-whatsapp"></i></a>
				</li>
				<li>
					<a class="gplus social-icon" title="google" href="javascript:void(0);" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo base_url('produk/')?><?php echo $produk->slug_produk?>','popupwindow','scrollbars=yes,width=800,height=400');popUp.focus();return false"><i class="fa fa-google-plus"></i></a>
				</li>
				<li>
					<a target="_new" title="line" href="http://www.addtoany.com/add_to/line?linkurl=<?php echo base_url('produk/detail/')?><?php echo $produk->slug_produk?>"><label class="line"></label></a>
				</li>

			</ul>
		</div><!-- /.vertical-nav -->
	</div><!-- /.vertical-nav-holder -->

	<div class="vertical-nav-overlay"></div><!-- /.vertical-nav-overlay -->
</main><!-- mt main end here -->
<?php 
endforeach;
endforeach;
?>