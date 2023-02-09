<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Stars</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style type="text/css">
  .sosmed{
  	padding-left: 0;
  	margin-top:0;
  }
  	.sosmed li{
  		display: inline-block;
  		margin-right: 10px;
  	}
  </style>
</head>
<body style="margin: 0; padding: 0;font-family: myriad pro">
 <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td bgcolor="#f5f5f5" style="padding: 40px 30px">
 	<table border="0" cellpadding="0" cellspacing="0" width="100%">
 		<tr>
 			<td>
        <?php $get_data_setting = for_header_front_end();?>
        <?php foreach($get_data_setting as $data):?>
            <img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" width="150">
        <?php endforeach;?>
 		</tr>
  		<tr>
   			<td bgcolor="#ffffff" style="padding: 10px">
   				<h4>Nomor Order #<?php echo $invoice?><br>
   				<span style="font-size: 14px;">Status order : <?php echo $status?></span>
   				</h4>
   				<p><?php echo $content?></p>
   			</td>
  		</tr>
  		<tr>
   			<td style="padding: 10px 15px; text-align: center;color:#8c8c8c"><?php echo base_url();?></td>
  		</tr>
  		<tr style="text-align: center">
  			<td align="center">
  			<ul class="sosmed" style="list-style: none;">
  				<li><a href="http://www.facebook.com/starsallthebest" target="_blank"><img src="<?php echo base_url('assets/images/ic_email/icon-facebook.png');?>" alt="Facebook" width="30" style="width:30px; max-width:30px; display:block;"></a></li>
  				<li><a href="http://www.instagram.com/stars.allthebest" target="_blank"><img src="<?php echo base_url('assets/images/ic_email/icon-instagram.png');?>" alt="Instagram" width="30" style="width:30px; max-width:30px; display:block;"></a></li>
  				<li><a href="http://www.twitter.com/starsallthebest" target="_blank"><img src="<?php echo base_url('assets/images/ic_email/icon-twitter.png');?>" alt="Twitter" width="30" style="width:30px; max-width:30px; display:block;"></a></li>
  			</ul>
            </td>
  		</tr>
  		<tr>
  			<td align="center">
  				<span style="color:#8c8c8c;">© 2018 Stars. Hak Cipta Dilindungi.</span>
  			</td>
  		</tr>
 	</table>
</td>
 </tr>
</table>
</body>
</html>