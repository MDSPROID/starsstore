<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>login App</title>
	<script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery-3.1.1.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/manage/js/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/manage/js/js.cookie.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/manage/js/clipboard.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/manage/js/sistem_adm.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/manage/js/bootstrap-datepicker.js');?>"></script>
	<link href="<?php echo base_url('assets/manage/css/bootstrap.css');?>" rel="stylesheet" type="text/css">	
</head>
<body class="body-bg bg-lht" style="height:100vh;background-image:url('../../../assets/images/login-bg.fcb221668da96b8a1817.svg')">
	<div class="container">
		<div class="col-md-3 col-xs-12"></div>
		<div class="col-md-6 col-xs-12" style="margin-top:100px;">
			<?php echo form_open('#',array('id' => 'form-loginx','style'=>'box-shadow:0 25px 75px rgba(16,30,54,.25);'));?>
			<input type="hidden" name="classify" class="classify" value="<?php $a = $this->encrypt->encode('I.}[|-sgf(62Jfw'); $b = base64_encode($a); echo $b?>">
			<h3 style="margin-bottom: 30px;">LOGIN</h3>
			<input type="text" name="username" id="username" class="form-control inp usernamex list-form" placeholder="USERNAME" required><br>
			<input type="password" name="password" id="password" class="form-control inp passwordx list-form" placeholder="PASSWORD" required>
			<i class="steye glyphicon glyphicon-eye-open" onclick="seeP();"></i>
			<br><br><br>
			<div class="row">
				<div class="row">
					<div class="col-md-6 col-xs-6 log-dv"><button onclick="authDev();" style="background: transparent;border:none;" class="btn-block btn-login">LOGIN</button></div>
					<div class="col-md-6 col-xs-6 log-dv-can"><input type="button" value="RESET" onclick="resetForml();" style="background: transparent;border:none;" class="btn-block"></div>
				</div>
			</div>
			<?php echo form_close();?>
			<?php echo br();?>
			<div class="text-center sgh" style="color:white;">
				<?php $get_data_setting_footer = for_footer();?>
				<span><?php foreach($get_data_setting_footer as $data){?><?php echo $data->konten?><?php }?></span>
			</div>
			<div class="text-center sgh" style="color:white;">server time <strong>{elapsed_time}</strong> secs.</div>
			<?php echo br();?>
			<div class="row">
				<div class="col-md-12">
					<label style="display:;font-size: 14px;padding: 5px 0px;" class="col-md-12 col-xs-12 label label-danger gagal"><?php echo $this->session->flashdata('error')?></label>
					<label style="display:;font-size: 14px;padding: 5px 0px;" class="col-md-12 col-xs-12 label label-success sukses"><?php echo $this->session->flashdata('success')?></label>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-xs-12"></div>
	</div>
</body>
</html>