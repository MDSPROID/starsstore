<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/dUp/dropzone.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/dUp/basic.min.css');?>">
<script type="text/javascript" src="<?php echo base_url('assets/global/dUp/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/global/dUp/dropzone.min.js')?>"></script>
<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {
      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
  });
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
<style type="text/css">
	.dropzone{
		border:2px dashed #9e9e9e;
	}
	.dropzone .dz-preview .dz-error-message{
		color: white;
	}
</style>

<!-- mt main start here -->
<main id="mt-main">
	<!-- Mt Contact Banner of the Page -->
	<section class="mt-contact-banner style4 konfirm-page wow fadeInUpx" data-wow-delay="0.4s" style="margin-top:0;background-color: grey;color: white;">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center">
					<h3 class="bg-txt">KONFIRMASI PEMBAYARAN</h3>
				</div>
			</div>
		</div>
	</section><!-- Mt Contact Banner of the Page end -->
	<!-- Mt Product Detial of the Page -->
	<section class="mt-detail-sec toppadding-zero csm">
		<div class="container">
			<div class="row"> 
				<div class="col-xs-12 col-md-12">
	                <div class="woocommerce-message info-success" role="alert"><?php echo $this->session->flashdata('berhasil');?><?php echo $this->session->flashdata('error');?></div>
	            </div>
				<div class="col-md-12 col-xs-12 re">
					<div class="warning-text">
						<p style="display:none;float:left;color:black;padding-right: 25px;">
							<i class="glyphicon glyphicon-warning-sign" style="font-size: 40px;"></i>
						</p>
						<p style="text-align: left;color:black;font-weight: 400;">
						Harap pastikan hanya melakukan transfer ke salah satu rekening yang terdaftar di https://www.starsstore.id. Kami tidak akan pernah meminta Anda untuk membuat permintaan transfer ke rekening lain. Harap berhati-hati terhadap penipuan mengatas nama kan stars official store.</p>
					</div>
				</div>
				<div class="col-md-12 col-xs-12 re pldgbr">
					<span class="jud">Bukti pembayaran*</span>
					<div class="dropzone">
						<div class="dz-message">
							<h3 class="txtgb"> Klik atau Drop bukti transfer anda disini<br>file maksimal 4 MB<br><span style="font-size: 12px;">file yang diizinkan : gif, jpg, jpeg, png</span></h3>
					  	</div>
					  </div>
					<i class="inf-ktp o"></i>
				</div>
				<div class="sd" style="display: none;">
					<div class="col-md-12 col-xs-12">
						<h3>Isi Data Dibawah</h3>
					</div>
					<?php echo form_open('konfirmasi_pesanan');?>
					<input type="hidden" name="sku_m" class="sku_m" value="<?php echo $identity?>">
					<input type="hidden" name="kIns" class="kIns" value="<?php $a = $this->encrypt->encode('KntJs628%243@729&2!46'); $b = base64_encode($a); echo $b?>">
					<div class="col-md-12 col-xs-12 re">
						<span class="jud">Nomor Pesanan* (contoh : STxxxxx)</span>
						<input type="text" name="id_pesanan" class="form-control list-form na chkid" required>
						<i class="info-error" style="color: red;"></i>
						<i class="inf-n o"></i>
					</div>
					<div class="col-md-12 col-xs-12 re" style="display: none;">
						<span class="jud">Nama Pemilik Rekening (Anda)*</span>
						<input type="text" name="nama" class="form-control list-form na">
						<i class="inf-n o"></i>
					</div>
					<div class="col-md-12 col-xs-12 re" style="display: none;">
						<span class="jud">Email*</span>
						<input type="email" name="email" class="form-control list-form em">
						<i class="inf-e o"></i>
					</div>
					<div class="col-md-12 col-xs-12 re" style="display: none;">
						<span class="jud">Bank*</span>
						<select name="bank" class="form-control ktP list-form">
							<option value="">pilih</option>
							<?php 
								foreach($bank as $k){
									$name = base64_encode($k->name_bank);
									$no = base64_encode($k->no_rek);
							?>
								<option value="<?php echo $name;?>|<?php echo $no?>"><?php echo $k->name_bank ?> [<?php echo $k->no_rek?>]</option>
							<?php } ?>	
						</select>
						<i class="inf-k o"></i>
					</div>
					<div class="col-md-12 col-xs-12 re" style="display: none;">
						<span class="jud">Nilai Transfer*</span>
						<input type="number" name="nominal" class="form-control list-form em">
						<i class="inf-l o"></i>
					</div>
					<div class="col-md-12 col-xs-12 re">
						<span class="jud">Catatan</span>
						<textarea name="catatan" class="form-control klh" rows="8" cols="5"></textarea>
					</div>
					<div class="col-md-12 col-xs-12 re">
						<button class="btn btn-danger">Konfirmasi Pembayaran</button>
					</div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</section>
</main>
<script type="text/javascript" src="<?php echo base_url('assets/global/dUp/druploadforkonfirm.js');?>"></script>
