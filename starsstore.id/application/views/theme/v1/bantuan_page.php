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
foreach($info as $b){
}
?>
<div class="bg-parallax-help ghy">
	<div class="container">
		<div class="row">
			<ul class="breadcrumb ses" style="box-shadow: none;">
					<li><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-home"></i></a></li>
					<li><a href="<?php echo base_url('bantuan');?>">Bantuan</a></li>
					<li><?php echo $b->judul?></li>
				</ul>
			<div class="col-md-12">
			<?php foreach($info as $r){?>
				<h3><?php echo $r->judul?></h3>
				<div class="dv"><?php echo $r->konten?></div>
			<?php }?>
			</div>
		</div>
	</div>
</div>
<div class="bg-parallax-help2 dpf">
	<div cass="container">
		<h5 class="text-center">Masih Belum Menemukan Jawaban?. <a href="<?php echo base_url('kontak-kami/');?>" class="label label-success lg hidden-xs"><i class="glyphicon glyphicon-earphone"></i> Hubungi Kami</a></h5>
		<div class="text-center"><a href="<?php echo base_url('kontak-kami/');?>" class="label label-success lg hidden-lg hidden-md"><i class="glyphicon glyphicon-earphone"></i> Hubungi Kami</a></div>
	</div>
</div>
<?php $get_data_setting_footer = for_footer();?>
<p class="text-center" style="margin-top:30px;"><?php foreach($get_data_setting_footer as $data){?><?php echo $data->konten?><?php }?></p>