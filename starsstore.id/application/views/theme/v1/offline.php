
<!DOCTYPE html>
<html lang="en-us" class="no-js">
    
    <head>
        <meta charset="utf-8">
        <title>Website Sedang Maintenance</title>
        <meta name="google-site-verification" content=""/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="robots" content="index,follow"/>
		<meta name="copyright" content="This website has been registered and trademark of PT. STARS INTERNASIONAL, Inc "/>
        <meta name="description" content="Toko sedang maintenance">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="PT. Stars Internasional, Inc">
        <meta name="language" content="Indonesia">
	    <meta name="revisit-after" content="7">
	    <meta name="webcrawlers" content="all">
	    <meta name="rating" content="general">
	    <meta name="spiders" content="all">
        <?php $get_data_setting = for_header_front_end();?>
	    <?php foreach($get_data_setting as $data):?>
	        <link rel="shortcut icon" href="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" />
	    <?php endforeach;?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/font-awesome.css');?>">
		<link href="<?php echo base_url();?>assets/theme/v1/css/bootstrap.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			.hrf{
				background-color: #f12236;
				background-size: cover;
				background-repeat: no-repeat;
				background-position: center;
				height: 100%;
			}
		</style>
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
    </head>

	<body class="hrf">
		<div id="wrapper1" style="margin-top: 100px;">
			<div class="col-md-12">
				<!-- Header -->
				<header>
					<center>
					<?php $get_data_setting = for_header_front_end();?>
					<?php foreach($get_data_setting as $data):?>
					<img class="lazy img-responsive" src="<?php echo base_url('assets/images/');?><?php echo $data->konten;?>" data-original="<?php echo base_url('assets/images/');?><?php echo $data->konten;?>" style="width:180px;">
					<?php endforeach;?>
					<?php $get_data_set = toko_libur();?>
					<h3 style="color:white;"><?php echo $get_data_set['konten'];?></h3><br>
					<h4 style="color: white;"><b>KUNJUNGI TOKO KAMI LAINNYA</b></h4>
					<ul class="list-unstyled list-inline">
					<?php 
						$store = for_our_store();
						foreach($store as $data){
					?>
						<li>
							<a target="_blank" href="<?php echo $data->link?>">
								<img src="<?php echo $data->gambar?>" class="lazy img-responsive" width="50">
							</a>
						</li>
					<?php }?>
					</ul>
					<?php echo br(2);?>
					<div class="col-md-12">
						<ul class="list-inline">
							<li>
								<a href="https://www.twitter.com/starsallthebest" style="color:white;font-size: 20px;"><i class="fa fa-twitter"></i></a>
							</li>

							<li>
								<a href="https://www.facebook.com/starsallthebest" style="color:white;font-size: 20px;"><i class="fa fa-facebook"></i></a>
							</li>

							<li>
								<a href="https://www.youtube.com/channel/UCuy1wqC_-Wh8k5tFrm-q7sg" style="color:white;font-size: 20px;"><i class="fa fa-youtube"></i></a>
							</li>

							<li>
								<a href="https://www.instagram.com/stars.allthebest" style="color:white;font-size: 20px;"><i class="fa fa-instagram"></i></a>
							</li>
						</ul>
						<span class="copyright" style="color: white;">
							<?php $get_data_setting_footer = for_footer();?>
							<?php foreach($get_data_setting_footer as $data){?><?php echo $data->konten?><?php }?>
						</span>
					</div>
				</center>
				</header>

			</div>

		</div>
	</body>
</html>