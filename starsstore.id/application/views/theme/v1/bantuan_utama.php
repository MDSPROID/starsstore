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
<div class="bg-parallax-help ghy">
<div class="container">
	<div class="row">
	<ul class="breadcrumb ses" style="box-shadow: none;">
		<li><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-home"></i></a></li>
		<li>Bantuan</li>
	</ul>
		<?php
			$w = $this->Halaman_bantuan_m->get_all_bantuan();
        foreach($w->result() as $h)
         {
         	$kat_id = $h->id_kategori_halaman;
                 $cek_parent = $this->Halaman_bantuan_m->get_all_bantuan2($kat_id);
            echo "<div class='col-md-3 col-xs-12 dsg'><div class='hlp co_num1'><h3 class='djnl'>".$h->kategori."</h3>";
            echo "<ul class='list-unstyled'>";
         if(($cek_parent->num_rows())>0){
         	foreach($cek_parent->result() as $row2){
                echo "<li class='ct-sub'><a href='".base_url('bantuan/')."".$row2->slug."'>".$row2->judul." <i class='glyphicon glyphicon-play plb pull-right'></i></a></li>";
            }
            echo "</ul></div></div>";
         }else {		
          			echo "";
                }
         }		
		?>
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
<script src="//code.tidio.co/qjdpbjvaglwvz43wf5yqr8lj16zfxexu.js"></script>
<script type="text/javascript">
//var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
//(function(){
//var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
//s1.async=true;
//s1.src='https://embed.tawk.to/5a52c9604b401e45400be68d/default';
//s1.charset='UTF-8';
//s1.setAttribute('crossorigin','*');
//s0.parentNode.insertBefore(s1,s0);
//})();
</script>