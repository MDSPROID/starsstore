<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Lock Screen Account</title>
    <link href="<?php echo base_url('assets/manage/css/bootstrap.css');?>" rel="stylesheet" type="text/css">
    <script type="text/javascript">var baseURL = '<?php echo base_url();?>';</script>
</head>
    <body class="page-lock-screen" style="background-color: #f1f4f9">
        <div class="container">
            <div class="col-md-4"></div>
            <div class="col-md-4 center" style="margin-top:100px;">
            <?php
                $user_log = info_user_login();
                foreach($user_log as $datas){
            ?>
                <div class="login-box">
                    <div class="user-box m-t-lg row">
                        <div class="col-md-12 m-b-md text-center" style="margin-bottom: 20px;">
                            <?php  if(empty($datas->gb_user)){?>
                                <img src="<?php echo base_url('assets/images/default.png')?>" class="img-circle m-t-xxs" alt="" width="50" height="50">
                            <?php }else{?>
                                <img src="<?php echo base_url('assets/images/user/'.$datas->gb_user)?>" class="img-circle m-t-xxs" alt="" width="50" height="50">
                            <?php }?>
                        </div>
                        <div class="col-md-12">
                            <p style="font-size: 18px;" class="no-m text-center">Welcome Back, <?php echo $datas->nama_depan?>!</p>
                            <p class="text-sm text-center">Enter password to unlock</p>
                            <?php echo form_open('unlock',array('class'=> 'form-inline text-center'));?>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control no-b list-form" style="height: 34px !important;" placeholder="Password" required>
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-lock"></i> Unlock</button>
                                    </div><!-- /btn-group -->
                                </div><!-- /input-group -->
                            <input type="hidden" name="inialisasi_config" value="<?php echo $this->session->userdata('usergaet');?>">
                            <?php echo form_close();?>
                            <div style="margin-top: 15px;" class="col-md-12 col-xs-12 info-warning"><?php echo $this->session->flashdata('error');?></div>
                        </div>
                    </div>
                </div>
            <?php }?>
            </div>
            <div class="col-md-4"></div>
        </div><!-- Row -->
        <!-- Javascripts -->
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery-3.1.1.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/bootstrap.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/js.cookie.js')?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/clipboard.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/sistem_adm.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/bootstrap-datepicker/js/bootstrap-datepicker.js');?>"></script>     
    </body>
</html>