<head>
<title>Lupa Password anda</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google-site-verification" content=""/>
<meta name="description" content="bantuan pelanggan, lupa password" />
<meta name="keywords" content="reset password, lupa kata sandi, lupa password, bantuan pelanggan, kesulitan mengakses akun"/>
<meta charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="index,follow"/>
<meta name="copyright" content="This website has been registered and trademark of PT. STARS INTERNASIONAL, Inc "/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/font-awesome.css');?>">
<link href="<?php echo base_url();?>assets/theme/v1/css/responsive.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/theme/v1/css/main.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/theme/v1/css/bootstrap.css" rel="stylesheet" type="text/css">
<style type="text/css">
	.input-group{
		position: relative;
	    display: table;
	    border-collapse: separate;
	}
	.input-group-addon, .input-group-btn, .input-group .form-control {
    	display: table-cell;
	}
	.input-group .form-control {
	    position: relative;
	    z-index: 2;
	    float: left;
	    width: 100%;
	    margin-bottom: 0;
	}
	.input-group-btn > .btn {
	    position: relative;
	}
	.input-group-btn {
	    position: relative;
	    font-size: 0;
	    white-space: nowrap;
	    width: 1%;
    	white-space: nowrap;
    	vertical-align: middle;
	}
	.hj {
	    padding-top: 8px !important;
	    padding-bottom: 10px !important;
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
<body style="background-color: #f5f5f5;">
<div class="bg-lupa-password" style="background-color: #f5f5f5;">
	<div class="container product-content text-center" style="margin-bottom:20px;margin-top: 25px;">
		<div class="col-md-3 col-xs-12"></div>
		<div class="col-md-6 col-xs-12">
			<a href="<?php echo base_url();?>">
			<?php $get_data_setting = for_header_front_end();?>
				<?php foreach($get_data_setting as $data):?>
				<div class="text-center">
					<img class="lazy" src="<?php echo base_url('assets/images/');?><?php echo $data->konten;?>" style="width:150px;display: initial;">
				</div>
			<?php endforeach;?>
			</a>
			<h3>Kesulitan mengakses akun anda?</h3>
			<p>Masukkan email yang telah terdaftar. kami akan mengirimkan email dengan tautan untuk mereset password akun anda.</p>
			<?php echo form_open('reset');?>
				<div class="input-group">
					<input class="" type="hidden" name="sess_mail" id="session_token" value="<?php $a=$this->encrypt->encode('lh743hG82#19'); $b=base64_encode($a); echo $b?>">
			        <input type="email" name="mail_reset" class="form-control list-form" id="email" placeholder="Masukkan Email anda" required>
	            	<span class="input-group-btn">
	            		<button class="btn btn-danger mail_sb hj">Reset</button>
	            	</span>
	            </div>
			<?php echo form_close();?>
				<div class="col-md-12 col-xs-12 info-success"><?php echo $this->session->flashdata('berhasil');?></div>
				<div class="col-md-12 col-xs-12 info-error"><?php echo $this->session->flashdata('error');?></div>
		</div>
		<div class="col-md-3 col-xs-12"></div>
	</div>
</div>
</body>