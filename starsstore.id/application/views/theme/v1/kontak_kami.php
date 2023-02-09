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
<div class="bg-parallax-help">
<div class="container">
	<div class="row">
		<div class="col-md-5 col-xs-12">
			<div class="col-md-12">
				<h3><b>Kontak Kami</b></h3>
				<p>Kami dengan senang hati akan melayani anda.Temukan semua jawaban dari pertanyaan seputar Starsstore.	</p>
			</div>
			<div class="col-md-12">
				<h4><b>Jam kerja</b></h4>
				<i class="fa fa-clock-o"></i> Senin - Jum'at 08:00 - 17:00
				<h4 style="margin-top: 20px;"><b>Kontak Sosial Media</b></h4>
                    <ul class="social-icons">
						<li><a class="facebook social-icon" title="facebook" target="_parent" href="https://www.facebook.com/starsstore.id"><i class="fa fa-facebook"></i></a></li>
						<li><a class="twitter social-icon" title="twitter" target="_parent" href="https://www.twitter.com/starsallthebest"><i class="fa fa-twitter"></i></a></li>
						<li><a class="pinterest social-icon" title="instagram" target="_new" href="https://www.instagram.com/stars.footwear"><i class="fa fa-instagram"></i></a></li>
					</ul>
				<h4><b>Hubungi Kami di Whatsapp & Email</b></h4>
				<ul class="list-unstyled">
					<li style="margin-bottom: 10px;"><i class="fa fa-phone"></i> <a class="pinterest social-icon" title="whatsapp" target="_new" href="https://wa.me/6282132645485?text=Hai%20Saya%20ingin%20menanyakan...">+62 821-3264-5485</a></li>
					<li><i class="fa fa-envelope"></i> <a class="pinterest social-icon" title="whatsapp" target="_new" href="mailto:cs@starsstore.id">cs@starsstore.id</a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-7 col-xs-12">
			<div class="col-md-12 col-xs-12 re">
				<h3><b>Isi Form dibawah ini</b></h3>
			</div>
			<input type="hidden" name="kIns" class="kIns" value="<?php $a = $this->encrypt->encode('KntJs628%243@729&2!46'); $b = base64_encode($a); echo $b?>">
			<div class="col-md-12 col-xs-12 re">
				<span class="jud">Nama Anda*</span>
				<input type="email" name="na_m" class="form-control list-form na" required>
				<i class="inf-n o"></i>
			</div>
			<div class="col-md-12 col-xs-12 re">
				<span class="jud">Email*</span>
				<input type="email" name="email_m" class="form-control list-form em" required>
				<i class="inf-e o"></i>
			</div>
			<div class="col-md-12 col-xs-12 re">
				<span class="jud">Kategori Pertanyaan*</span>
				<select name="ktP" class="form-control ktP list-form" required="">
					<option value="">pilih</option>
					<?php foreach($kat_help as $k){?>
						<option value="<?php echo $k->kategori ?>"><?php echo $k->kategori ?></option>
					<?php } ?>	
					<option value="Lainnya">Lainnya</option>
				</select>
				<i class="inf-k o"></i>
			</div>
			<div class="col-md-12 col-xs-12 re">
				<span class="jud">Pertanyaan*</span>
				<textarea name="klh" class="form-control klh" rows="8" cols="5"></textarea>
				<i class="inf-l o"></i>
			</div>
			<div class="col-md-12 col-xs-12 re">
				<button onclick="BtSubCont();" class="btn-kontak btn btn-block btn-danger list-form">Kirim</button>
			</div>
		</div>
	</div>
</div>
<?php $get_data_setting_footer = for_footer();?>
<p class="text-center" style="margin-top:30px;"><?php foreach($get_data_setting_footer as $data){?><?php echo $data->konten?><?php }?></p>
</div>