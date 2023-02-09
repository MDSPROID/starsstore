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
<!-- mt main start here -->
<main id="mt-main">
	<!-- Mt Product Detial of the Page -->
	<section class="mt-detail-sec toppadding-zero csm">
		<div class="container">
			<h3 class="tt-our"><span class="brandti">TOKO KAMI DI MARKETPLACE</span></h3>
			<?php echo br();?>
			<ul class="list-inline marketlace-icon text-center">
			<?php foreach($r as $data){?>
				<li>
					<a target="_new" href="<?php echo $data->link?>">
						<img src="<?php echo $data->gambar?>" class="img-responsive" style="border:0;margin-bottom: 0!important;">
						<h5 style="height: 25px;"><b><?php echo $data->nama?></b></h5>
					</a>
				</li>
			<?php }?>
			</ul>
		</div>
	</section><!-- Mt Product Detial of the Page end -->
</main><!-- mt main end here -->
