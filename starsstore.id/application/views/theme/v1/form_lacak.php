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
	<div class="contentpagesettings" data-wow-delay="0.4s">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4><b>Lacak Pesanan</b></h4>
					<p style="text-align: justify;">Anda dapat melakukan pengecekan terhadap pesanan anda, baik anda memesan pesanan anda di website resmi stars maupun di toko kami yang ada di marketplace</p>
					<br>
				</div>
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<?php echo form_open('proses');?>
						<div class="col-md-6 col-xs-12">
					    	<label>Nomor Invoice : <i style="color:red;">*<?php echo $this->session->flashdata('error')?></i></label>
				            <input type="text" name="invoiceNo" class="form-control cek_invoice list-form" placeholder="Masukkan Nomor Invoice" required>
				            <br>
					    </div>
					    <div class="col-md-12 col-xs-12">
					    	<button class="btn mail_sb">Cek Pesanan</button>
					    	<br><br><br>
					    </div>
				    	<?php echo form_close();?>
				    </div>
				 </div>
			</div>
		</div>
	</div>
	<!-- related products start here -->

</main><!-- mt main end here -->