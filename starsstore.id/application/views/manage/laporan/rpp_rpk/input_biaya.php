 <link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>

<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>

 <script type="text/javascript">

  $(document).ready( function () { 

   $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd'
      });               

  });

</script>

<div class="page-title">

  <h3>Input Biaya By Excel

    <?php 

      if($this->session->flashdata('success')):?>

        <label style="font-size: 12px;position: absolute;margin-left: 10px;padding: 5px 5px;font-weight:500;" class="label label-success"><?php echo $this->session->flashdata('success')?></label>

      <?php endif?>

      <?php 

      if($this->session->flashdata('error')):?>

        <label style="font-size: 12px;position: absolute;margin-left: 10px;padding: 5px 5px;font-weight:500;" class="label label-danger"><?php echo $this->session->flashdata('error')?></label>

    <?php endif?>

  </h3>

  <div class="page-breadcrumb">

    <ol class="breadcrumb">

      <li><a href="<?php echo base_url('trueaccon2194/info_type_user_log')?>">Home</a></li>

      <li><a href="<?php echo base_url('trueaccon2194/rpp_rpk')?>">RPP / RPK</a></li>

      <li class="active">Input Biaya By Excel</li>

    </ol>

  </div>

</div>

<div id="main-wrapper">

  <div class="row">

    <div class="col-md-9 col-xs-12">          

      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>

      <?php echo br(3);?> 

      <div class="row">        
        <div class="col-md-12 col-xs-12" style="margin-bottom: 10px;">
            <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
              <div id="general" class="tab-pane fade in active">
              <?php echo form_open_multipart('trueaccon2194/rpp_rpk/proses_input_biaya_by_excel', array('id'=>'form_produk_add'));?>
                  <div class="row">
                    <div class="col-md-12"><h3 style="margin-top: 0;">Upload Biaya - biaya marketplace</h3></div>
                    <div class="col-md-12 input group">
                      <label>Marketplace : </label> <i style="color:red;">*</i>
                      <select class="form-control cek_odv" name="market" required>
                        <option value="">-- pilih --</option>
                        <?php foreach($market as $gx){?>
                          <option value="<?php echo $gx->val_market?>"><?php echo $gx->market?></option>
                        <?php }?>
                      </select>
                      <br>
                    </div>
                    <div class="col-md-12 col-xs-12 input group ">
                      <label>Upload Excel : <i style="color:red;">*</i></label>
                      <input type="file" name="uploadexcel" class="form-control cek_tgl" placeholder="Upload Excel" required>
                      <br>
                    </div>                 
                  </div>
                  <button type="submit" class="simpan_review btn btn-success">Upload</button><br><br>
                    <a href="<?php echo base_url('trueaccon2194/rpp_rpk/template_biaya_shopee');?>" class="btn btn-primary" style="background-color:#f7730b;margin-bottom: 5px;">Download Template Biaya Shopee</a> 
                    <a href="<?php echo base_url('trueaccon2194/rpp_rpk/template_biaya_tokopedia');?>" class="btn btn-primary" style="background-color: green;margin-bottom: 5px;">Download Template Biaya Tokopedia</a> 
                    <a href="<?php echo base_url('trueaccon2194/rpp_rpk/template_biaya_bukalapak');?>" class="btn btn-primary" style="background-color: #f70b46;margin-bottom: 5px;">Download Template Biaya Bukalapak</a> 
                    <a href="<?php echo base_url('trueaccon2194/rpp_rpk/template_biaya_lazada');?>" class="btn btn-primary" style="background-color: #8d0bf7;margin-bottom: 5px;">Download Template Biaya Lazada</a>
                    <a href="<?php echo base_url('trueaccon2194/rpp_rpk/template_biaya_blibli');?>" class="btn btn-primary" style="background-color: #0b8ff7;margin-bottom: 5px;">Download Template Biaya Blibli</a>
                  <br><br>
                  <i style="color: red;">*Download Rincian Biaya dari marketplace berupa excel, setelah itu download template biaya-biaya yang ada dimenu ini (download template sesuai marketplace yang akan diupdate). setelah itu masukkan biaya dari excel yang didownload ke marketplace ke excel yang didownload dari menu ini. kemudian upload. maka secara otomatis biaya-biaya akan langsung terupdate per invoice.</i>
              <?php echo form_close();?>
              </div>

              <i style="color:red;">(*) wajib diisi</i>
          </div>
        </div>        
      </div>

</div>

<div class="col-md-3 col-xs-12">

  <div class="panel panel-primary" style="border-color:#d3d3d3;">

      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>

      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">

        <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>

        <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>

        <h5>Tanggal    : <b><?php echo date('d M Y')?></b></h5>

    </div>

    </div>

</div>