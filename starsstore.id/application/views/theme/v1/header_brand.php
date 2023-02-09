<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content=""/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="index,follow"/>
    <meta name="copyright" content="This website has been registered and trademark of PT. STARS INTERNASIONAL, Inc "/>
    <meta name="author" content="PT. STARS INTERNASIONAL, Inc">
    <meta name="language" content="Indonesia">
    <meta name="revisit-after" content="7">
    <meta name="webcrawlers" content="all">
    <meta name="rating" content="general">
    <meta name="spiders" content="all">
    <?php
    $get_data_cst = info_customer_login();  
    foreach($get_data_cst as $tg){
        $hal = $tg->nama_lengkap;
    }?>
    <?php 
        echo $title; 
        echo $meta_desc; 
        echo $meta_key; 
    ?>
    <link rel="shortcut icon" href="<?php echo $bg_kategori;?>" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/bootstrap.css">
  	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/animate.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/icon-fonts.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/main.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/responsive.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/global/autoCom/jquery.autocomplete.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" type="text/css">
	<script src="<?php echo base_url('assets/global/jquery-3.1.1.min.js');?>"></script>
	<script src="<?php echo base_url('assets/global/JQuery.min.js');?>"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/4.1.4/lazysizes.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/global/jquery.dataTables.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/global/dataTables.bootstrap.min.js');?>"></script>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-78739398-3"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-78739398-3');
	</script>
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
			$('#owl-brand').owlCarousel({
			    loop:true,
			    lazyLoad: true,
			    nav:true,
			    autoplay:false,
				autoplayTimeout:5000,
				autoplayHoverPause:true,
				navText: ["<i class='left-brand-nav glyphicon glyphicon-chevron-left'></i>","<i class='right-brand-nav glyphicon glyphicon-chevron-right'></i>"],
			    responsive:{
			        0:{
			            items:3
			        },
			        500:{
			            items:4
			        },
			        1000:{
			            items:4
			        }
			    }
			});
			$('#owl-produk').owlCarousel({
			    loop:true,
			    lazyLoad: true,
			    nav:false,
			    autoplay:false,
				autoplayTimeout:5000,
				autoplayHoverPause:true,
				navText: ["<i class='glyphicon glyphicon-chevron-left'></i>","<i class='glyphicon glyphicon-chevron-right'></i>"],
			    responsive:{
			        0:{
			            items:2
			        },
			        500:{
			            items:4
			        },
			        1000:{
			            items:5
			        }
			    }
			});
			$('#owl-produk2').owlCarousel({
			    loop:true,
			    lazyLoad: true,
			    nav:false,
			    autoplay:false,
				autoplayTimeout:5000,
				autoplayHoverPause:true,
				navText: ["<i class='glyphicon glyphicon-chevron-left'></i>","<i class='glyphicon glyphicon-chevron-right'></i>"],
			    responsive:{
			        0:{
			            items:2
			        },
			        500:{
			            items:4
			        },
			        1000:{
			            items:5
			        }
			    }
			});
		});
	</script>
</head>
<body class="right-side">
	<div class="gotoHome" style="display: none">
		<?php $get_data_setting = for_header_front_end();?>
		<?php foreach($get_data_setting as $data):?>
		<a href="<?php echo base_url();?>" style="font-size: 20px;font-family: monospace;color: grey;"><<img style="height: 20px;width: auto;display: initial;" src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" alt="loader"></a>
		<?php endforeach;?>	
	</div>
	<div id="mySidenav" class="sidenav"> 
		<div class="head-side-menu text-center">
			<div class="top-menu-slide">
				<label class="inf-log"><?php echo $name_brand?></label>
				<h3 class="pull-right" onclick="closeNavhome();">X</h3>
			</div>
		</div>
	  	<div class="menu-menu">						
	  		<ul class="list-unstyled menu-tab1">
	  			<li style="display: none;">
	  				<?php $get_data_setting = for_header_front_end();?>
					<?php foreach($get_data_setting as $data):?>
					<a href="<?php echo base_url();?>" style="font-size: 20px;font-family: monospace;color: grey;"><<img style="height: 20px;width: auto;display: initial;" src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" alt="loader"></a>
					<?php endforeach;?>	
				</li>
				<li>
					<a href="<?php echo base_url();?>">KE STARSSTORE.ID</a>
				</li>
				<li>
					<a href="<?php echo base_url('merk/'.$slug.'');?>">HOME</a>
				</li>
				<li>
					<a href="<?php echo base_url('terbaru/'.$slug.'');?>">NEW ARRIVAL</a>
				</li>
				<li style="display: none;">
					<a href="<?php echo base_url('promo-menarik');?>">PROMO</a>
				</li>
				<li><a href="<?php echo base_url('toko-kami');?>">MARKETPLACE</a></li>
				<li style="border-bottom: 1px solid black;padding-bottom: 10px;">
					<a href="<?php echo base_url('konfirmasi');?>">KONFIRMASI PEMBAYARAN</a>
				</li>
				<li style="padding-top: 10px;line-height: initial;">
					<a href="<?php echo base_url('customer');?>" style="font-size:12px;"><i class="fa fa-user"></i> Akun Saya</a>
				</li>
				<?php if($this->session->userdata('log_access') == "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){?>
				<li style="padding-top: 10px;line-height: initial;">
					<a href="<?php echo base_url('Keluar Akun');?>" style="font-size:12px;"><i class="fa fa-sign-out"></i> keluar Akun</a>
				</li>
				<?php }?>
				<li>
					<a href="<?php echo base_url('lacak-pesanan');?>" style="font-size:12px;"><i class="icon-magnifier"></i> Lacak Pesanan</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- main container of all the page elements -->
	<div id="wrapper">
		<!-- Page Loader -->
		<div id="pre-loader" class="loader-container">
			<div class="loader">
				<img src="<?php echo base_url('assets/images/load-stars.gif')?>" alt="loader">
			</div>
		</div>
		<!-- W1 start here -->
		<div class="w1">
			<!-- mt header style4 start here -->
			<header id="mt-header" class="style4 hd">
				<!-- mt bottom bar start here -->
				<div class="mt-bottom-bar bx">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<!-- mt icon list right start here -->
								<ul class="hidden-lg hidden-md mt-icon-list right">
									
								</ul><!-- mt icon list right end here -->
								<ul class="mt-icon-list navmodemobile">		
								<!-- mt icon list start here tambahkan class side-opener di bar-opener -->
									<li class="marginzero hidden-lg hidden-md">
										<a class="bar-opener " href="javascript:void(0);" onclick="openNavhome();">
											<span class="bar"></span>
											<span class="bar small"></span>
											<span class="bar"></span>
										</a>
									</li>
									<li class="hidden-lg hidden-md seacrh-bar-mobile"><?php echo form_open('pencarian/cari',array('method'=>'get'));?>
												<input name="keywords" type="text" placeholder="Cari sepatu atau sandal?" autofocus>
												<i class="icon-magnifier" style="display: none;"></i>
										<?php echo form_close();?>
									</li>
									<li class="hidden-xs">
										<a href="#" class="icon-magnifier"></a>
									</li>				
									<li class="hidden-xs">
										<a href="<?php echo base_url('login-pelanggan');?>" class="icon-user"></a>
									</li>				
									<li class="drop">
										<a href="#" class="cart-opener">
											<span class="icon-handbag"></span>
											<span class="num"><?php echo $this->cart->total_items()?></span>
										</a>
										<!-- mt drop start here -->
										<div class="mt-drop">
											<!-- mt drop sub start here -->
											<div class="mt-drop-sub">
												<!-- mt side widget start here -->
												<div class="mt-side-widget">
													<?php if(!$this->cart->contents()){?>
														<h4 class="text-center" style="font-family: 'Montserrat', sans-serif;">Keranjang belanja masih kosong. <br><a style="font-family: 'Montserrat', sans-serif;color: grey;" href="<?php echo base_url()?>">Belanja dulu yuk</a></h4>
													<?php }else{ ?>  
													<!-- cart row start here -->
													<?php foreach ($this->cart->contents() as $items): ?>
													<div class="cart-row">
														<a href="<?php echo base_url('produk/'.$items['slug'].'');?>" class="img"><img src="<?php echo $items['image']?>" alt="image" class="img-responsive"></a>
														<div class="mt-h">
															<span class="mt-h-title"><a href="#"><?php echo $items['name']; ?></a></span>
															<span class="price">
																<?php if($items['before'] == 0 || empty($items['before'])){ 
												                    echo "Rp. ".number_format($items['price'],0,".",".")."";
												                }else{
												                    echo "<s style='color:#989898 ;'>Rp. ".number_format($items['before'],0,".",".")."</s><br><span>Rp. ".number_format($items['price'],0,".",".")."</span>";
												                }?>
															</span>
															<span class="mt-h-title">Qty: <?php echo $items['qty']; ?></span>
														</div>
														<a href="javascript:void(0);" data-name="<?php echo $items['name'];?>" data-id="<?php echo $items['rowid'];?>" onclick="delete_item(this);" class="close fa fa-times"></a>
													</div>
												<?php endforeach; }?>
													<!-- cart row end here -->

													<!-- cart row total start here -->
													<div class="cart-row-total">
														<span class="mt-total" style="font-family: 'Montserrat', sans-serif;">Sub Total</span>
														<span style="font-family: 'Montserrat', sans-serif;" class="mt-total-txt">Rp. <?php echo number_format($this->cart->total(),0,".","."); ?></span>
													</div>
													<!-- cart row total end here -->
													<div class="cart-btn-row">
														<a href="<?php echo base_url('cart');?>" class="btn-type2">KERANJANG BELANJA</a>
													</div>
												</div><!-- mt side widget end here -->
											</div>
											<!-- mt drop sub end here -->
										</div><!-- mt drop end here -->
										<span class="mt-mdropover"></span>
									</li>
								</ul><!-- mt icon list end here -->
								<ul class="mt-icon-list" style="width: 83%;display: none;">		
									<li class="hidden-lg hidden-md" style="width: 100%;padding-right: 15px;">
									<?php echo form_open('pencarian/cari',array('method'=>'get'));?>
										<input style="border: none;box-shadow: none;border-radius: 0;text-align: center;background-color: #f3f3f3;text-align: center;" name="keywords" type="text" placeholder="Cari sepatu atau sandal?" autofocus><i class="icon-magnifier"></i>
									<?php echo form_close();?>
									</li>
								</ul>
								<!-- mt logo start here -->
								<div class="mt-logo logo-brand hidden-xs">
									<a href="<?php echo base_url();?>">
										<img src="<?php echo $bg_kategori;?>" alt="loader">
									</a>
								</div>
								<!-- navigation start here -->
								<nav id="nav">
									<ul>
										<li>
											<a href="<?php echo base_url();?>">KE STARSSTORE.ID</a>
										</li>
										<li>
											<a href="<?php echo base_url('merk/'.$slug.'');?>">HOME <i class="fa fa-angle-down hidden-lg hidden-md" aria-hidden="true"></i></a>
										</li>
										<li>
											<a href="<?php echo base_url('terbaru/'.$slug.'');?>">NEW ARRIVAL</a>
										</li>
										<li style="display: none;">
											<a href="<?php echo base_url('promo-menarik');?>">PROMO</a>
										</li>
										<li><a href="<?php echo base_url('toko-kami');?>">MARKETPLACE</a></li>
										<li><a href="<?php echo base_url('konfirmasi');?>">KONFIRMASI PEMBAYARAN</a></li>
									</ul>
								</nav>
								<!-- mt icon list end here -->
							</div>
						</div>
					</div>
				</div>
				<!-- mt bottom bar end here mt-side-over -->
				<span class="mt-side-custom"></span>
			</header><!-- mt header style4 end here -->
			<div class="mt-side-menu">
				<!-- mt holder start here -->
				<div class="mt-holder">
					<a href="#" class="side-close"><span></span><span></span></a>
					<strong class="mt-side-title">MENU</strong>
					<!-- mt logo search dan user start here -->
					<div class="col-md-12 col-xs-12">
						<ul class="list-inline text-center">
							<li><a href="#" style="position: inherit;" class="side-close icon-magnifier ico-circle-line"></a></li>
							<li><a href="<?php echo base_url('login-pelanggan');?>" class="icon-user ico-circle-line"></a></li>
						</ul>
					</div>
					<?php 
						if($this->session->userdata('log_access') == "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
					?>
					<div class="col-md-12 col-xs-12" style="margin-top: 15px;">
						<ul class="list-inline text-center addlisting">
							<li><a href="#" style="position: inherit;" class="side-close ico-circle-line">Keluar</a></li>
							<li><a href="<?php echo base_url('login-pelanggan');?>" class="ico-circle-line">Pesanan</a></li>
							<li><a href="<?php echo base_url('login-pelanggan');?>" class=" ico-circle-line">Favorit</a></li>
						</ul>
					</div>
					<?php }?>
					<!-- mt logo search dan user start end here -->
					<!-- mt side widget start here -->
					<div class="mt-side-widget borderbottom">
						<nav class="mt-side-nav">
							<ul>
								<li>
									<a href="<?php echo base_url();?>" class="drop-link">HOME</a>
								</li>
								<li>
									<a href="<?php echo base_url('promo-menarik');?>" class="promosi">PROMO</a>
								</li>
								<?php 
                                	$kat = for_header_front_end_kategori();
                                	foreach($kat as $t){
                                ?>
								<li>
									<a href="<?php echo base_url('kategori/'.$t->slug.'');?>" class="drop-link"><?php echo $t->kategori?> <i aria-hidden="true" class="fa fa-angle-down"></i></a>
									<div class="drop">
										<ul>
											<?php 
                                            	// get parent kategori 
                                            	$ikat = $t->kat_id;
                                            	$get_pk = $this->preference->front_end_header_parent_kategori($ikat);
                                            	foreach($get_pk as $y){
                                            ?>
											<li><a href="<?php echo base_url('sub-kategori/'.$y->slug_parent.'');?>"><?php echo $y->parent_kategori?></a></li>
											<?php }?>
										</ul>
									</div>
								</li>  
								<?php }?>
								<li><a href="<?php echo base_url('bantuan/cara-belanja');?>">CARA BELANJA</a></li>
								<li><a href="<?php echo base_url('toko-kami');?>">MARKETPLACE</a></li>
								<li><a href="<?php echo base_url('konfirmasi');?>">KONFIRMASI PEMBAYARAN</a></li>
								<li><a href="<?php echo base_url('bantuan');?>">BANTUAN</a></li>
							</ul>
						</nav>
					</div><!-- mt side widget end here -->
				</div><!-- mt holder end here -->
			</div><!-- mt side menu end here -->
			<!-- mt search popup start here -->
			<div class="mt-search-popup">
				<div class="mt-holder bgsearch">
					<a href="#" class="search-close hidden-xs"><span></span><span></span></a>
					<div class="mt-frame">
						<?php echo form_open('pencarian/cari',array('method'=>'get'));?>
							<fieldset>
								<center>
								<input style="background-color: white;" name="keywords" type="text" placeholder="Cari sepatu atau sandal?" autofocus>
								<i class="icon-magnifier" style="display: none;"></i>
								</center>
							</fieldset>
						<?php echo form_close();?>
					</div>
				</div>
			</div><!-- mt search popup end here -->