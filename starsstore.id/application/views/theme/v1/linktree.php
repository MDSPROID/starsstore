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
    $get_data_setting = for_header_front_end();
    $get_data_cst = info_customer_login();
    foreach($get_data_cst as $tg){ 
        $hal = $tg->nama_lengkap;
    }
    foreach($get_data_setting as $meta){
    if(empty($title) && empty($meta_desc) && empty($meta_key)){?>
        <title><?php echo $meta->site_title?></title>
        <meta name="description" content="<?php echo $meta->meta_desc?>" />
        <meta name="keywords" content="<?php echo $meta->meta_key?>"/>
    <?php }else{?>
    <?php 
        echo $title;
        echo $meta_desc; 
        echo $meta_key; 
    }}?>
	<?php $get_data_setting = for_header_front_end();?>
    <?php foreach($get_data_setting as $data):?>
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" />
    <?php endforeach;?>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/bootstrap.css">
  	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/animate.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/icon-fonts.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/main.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/responsive.css">
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
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123807990-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-123807990-1');
		</script>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-WR7W935');</script>
		<!-- End Google Tag Manager -->
	<noscript><img height="1" width="1" style="display:none"
	  src="https://www.facebook.com/tr?id=1472453182816875&ev=PageView&noscript=1"
	/></noscript> 
</head>
<body class="right-side" id="bglinktree">
	<!-- mt main start here -->
	<main id="mt-main">
		<div style="width: 100%" class="product-detail-tab wow fadeInUpx" data-wow-delay="0.4s">
			<div class="container paddlinktree text-center">
				<div class="row">
					<div class="col-mxs-12 col-xs-12 text-center">
						<a href="<?php echo base_url();?>">
							<?php $get_data_setting = for_header_front_end();?>
			    			<?php foreach($get_data_setting as $data):?>
			    			<div class="btn" style="background-color: white;border-radius: 50%;height: 100px;width: 100px;">
								<img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" style="height: auto;width:100px;display: initial;padding-top: 35px;padding-right: 25px;" alt="loader">
							</div>
							<?php endforeach;?>	
						</a>
						<h5 style="color: white;font-size: 14px;font-weight: 300;margin-bottom: 20px;margin-top:20px;">@stars.footwear</h5>
						<div class="tombolwebsite" style="margin-bottom: 10px;">
							<a href="<?php echo base_url();?>" class="btn btn-default btn-block" style="color: red;font-weight:bold;height: 40px;font-size: 16px;"">Website Official</a>
						</div>
						<div class="tombolmarketplace" style="margin-bottom: 10px;">
							<a href="https://shopee.co.id/starsallthebest" class="btn btn-default btn-block" style="color: red;font-weight:bold;height: 40px;font-size: 16px;">Shopee</a>
						</div>
						<div class="tombolmarketplace" style="margin-bottom: 10px;">
							<a href="https://www.tokopedia.com/starsofficial" class="btn btn-default btn-block" style="color: red;font-weight:bold;height: 40px;font-size: 16px;" href="<?php echo base_url();?>">Tokopedia</a>
						</div>
						<div class="tombolmarketplace" style="margin-bottom: 10px;">
							<a href="https://www.blibli.com/merchant/stars-official-store/STO-60038" class="btn btn-default btn-block" style="color: red;font-weight:bold;height: 40px;font-size: 16px;">Blibli</a>
						</div>
						<div class="tombolmarketplace" style="margin-bottom: 10px;">
							<a href="https://www.lazada.co.id/shop/stars" class="btn btn-default btn-block" style="color: red;font-weight:bold;height: 40px;font-size: 16px;">Lazada</a>
						</div>
						<div class="tombolwa">
							<a href="https://api.whatsapp.com/send?phone=6282132645489&text=Hai%20Starsholic,%20Saya%20ingin%20menanyakan%20produk%20%20" class="btn btn-default btn-block" style="color: red;font-weight:bold;height: 40px;font-size: 16px;" href="<?php echo base_url();?>">Whatsapp Stars Official</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- related products start here -->
	</main><!-- mt main end here -->
	<div class="bgcloud"></div>
</body>
</html>