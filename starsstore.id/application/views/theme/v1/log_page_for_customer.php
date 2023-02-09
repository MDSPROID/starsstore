<?php 
if($this->session->userdata('log_access') == "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
    redirect('/customer');
}else{
?>
<html lang="en" class="no-js">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  $get_data_setting = for_header_front_end();
  foreach($get_data_setting as $meta){
  if(empty($title) && empty($meta_desc) && empty($meta_key)){?>
    <title><?php echo $meta->site_title?></title>
    <meta name="description" content="<?php echo $meta->meta_desc?>" />
    <meta name="keywords" content="<?php echo $meta->meta_key?>"/>
  <?php }else{?>
  <?php 
    echo $title;
    echo $meta_desc;
    echo $meta_key;
  }}?>
  <meta name="google-site-verification" content=""/>
  <meta charset="utf-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index,follow"/>
  <meta name="copyright" content="This website has been registered and trademark of PT. STARS INTERNASIONAL, Inc "/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/icon-fonts.css">
  <script src="<?php echo base_url('assets/global/jquery-3.1.1.min.js');?>"></script>
  <script src="<?php echo base_url('assets/global/JQuery.min.js');?>"></script>
  <script src="<?php echo base_url('assets/global/js.cookie.js')?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/global/')?>s497sd_09.js"></script>

  <link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/main.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/responsive.css">
  <script type="text/javascript" src="<?php echo base_url('assets/global/autoCom/jquery.autocomplete.js')?>"></script>
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
<body style="background-image: url('assets/global/ic_email/not3_bg_image.jpg'); background-repeat: repeat;">
<?php echo form_open('#', array('id'=>'formlog_key_auth3'));?>
<input type="hidden" name="gexf" value="<?php $a = $this->encrypt->encode('K935$2&#1I.}[st53|-sgfw3(62Jfw'); $b = base64_encode($a); echo $b?>">
<div class="bg-parallax-log">
  <div class="container">
      <div class="col-md-8 col-xs-12 hidden-xs">
        <?php 
          $b = for_header_front_end_banner_3_utama();
          foreach($b as $u){
            if($u->posisi == "login"){
        ?>
        <img src="<?php echo $u->banner?>">
        <?php }}?>
      </div>
      <div class="text-center col-md-4 col-xs-12">
        <div class="row postlg">
          <h3 class="text-center kl">
            <?php $get_data_setting = for_header_front_end();?>
            <?php foreach($get_data_setting as $data):?>
              <img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" style="margin-top:-10px;width: 120px;display: initial;">
            <?php endforeach;?>
            <h3>Login Pelanggan</h3>
            <h5 class="text-center u">Belum Punya Akun? <i class="daftar_for_order"><a style="text-decoration: underline; " class="l" href="<?php echo base_url('mendaftar');?>">Daftar disini</a></i></h5><?php echo br(2);?>
          </h3>
          <div class="col-md-12 col-xs-12">
            <div class="info-success"><?php echo $this->session->flashdata('berhasil');?></div>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="info-error"><?php echo $this->session->flashdata('error');?></div>
          </div>
          <div class="col-md-12 col-xs-12 ra">
            <input type="email" name="em_ly" class="form-control list-form em emlog" placeholder="Email anda" required>
          </div>
          <div class="col-md-12 col-xs-12 re">
            <input type="Password" name="pw_ly" class="form-control list-form pa palog" placeholder="Masukkan Password" required>
          </div>
          <div class="col-md-12 col-xs-12">
            <input type="hidden" name="lreg" class="lreg" value="<?php $a = $this->encrypt->encode('Ub$2652%^725**$3231&%461'); $b = base64_encode($a); echo $b?>">
            <button onclick="logic_war_mask_key()" class="no-b btn btn-lg btn-block f-space log_order btn-danger btn-log-order btn-log-header" style="background-color:#d80e0e;" name="log_ac">LOGIN</button>
            <br>
            <span class="uinlogKey" style="display:none; color: #e40e0e;font-size: 14px;margin-bottom: 10px;"></span>
            <h5 class="text-center info-log-stat l"><a class="forgot_pw" href="<?php echo base_url('lupa-password');?>">Lupa Password?</a></h5>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="topic-menu" style="margin-bottom: 10px;">
            </div>
            <ul class="list-inline" style="display: none;">
              <li><a href="authenticationfacebook" style="border-radius: 50% !important;padding: 8px 13px;" class="btn btn-facebook no-b co_num1"><i class="pfb fa fa-facebook"></i></a></li>
              <li><a href="<?php echo base_url('authorization_google')?>" style="border-radius: 50% !important;padding: 8px;" class="btn btn-google no-b"><i class="pfb fa fa-google-plus"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
  </div>
<?php echo form_close();?>
<?php $get_data_setting_footer = for_footer();?>
<div class="text-center hidden" style="display:none;position: fixed;bottom:0;width: 100%;background-color:white;padding: 5px;z-index: 999;color: #676767;">
  <i class="glyphicon glyphicon-lock" style="color:#e6e610;"></i> IP anda : <?php echo $this->input->ip_address()?><br><?php foreach($get_data_setting_footer as $data){?><?php echo $data->konten?><?php }?>
</div>
</body>
</html>
<?php }?>