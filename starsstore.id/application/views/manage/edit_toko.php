<link href="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" rel="stylesheet" type="text/css"/>
 <script src="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.min.js');?>"></script>
<div class="page-title">
  <h3>Edit Toko (Shoplist)
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
      <li class="active" href="#">Edit Toko</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">

<?php 
  $kat = array('id' => 'form-toko');
  echo form_open('trueaccon2194/info_type_user_log/update_toko',$kat)?>
<div class="col-md-9 col-xs-12" style="margin-bottom: 15px;">          
<a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
<?php echo br(3);?>
<div class="col-md-12 col-xs-12" style="box-shadow:0px 0px 8px 0px #bababa;padding:10px;background-color:white;">
    <div class="col-md-6 col-xs-12 input group">
      <label>Nama Toko : <i style="color:red;">*</i></label>
      <input type="text" name="nama" class="form-control nama" value="<?php echo $r['nama_toko'];?>" placeholder="Nama Toko" required>
      <input type="hidden" name="id" value="<?php echo $r['id_toko']?>">
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>Alamat : <i style="color:red;">*</i></label>
      <input type="text" name="alamat" class="form-control alamat" value="<?php echo $r['alamat'];?>" placeholder="Alamat" required>
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>BDM : <i style="color:red;">*</i></label>
      <select class="form-control bdm" name="bdm" required>
          <option value="">-- pilih --</option>
          <?php 
            foreach($bdm as $xb){
              if($xb->id == $r['id_bdm']){
          ?>
            <option selected value="<?php echo $xb->id?>"><?php echo $xb->nama_bdm?> [<?php echo $xb->area?>]</option>
          <?php }else{?>
            <option value="<?php echo $xb->id?>"><?php echo $xb->nama_bdm?> [<?php echo $xb->area?>]</option>
          <?php }}?>
      </select>
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>Kode SMS : <i style="color:red;">*</i></label>
      <input type="text" name="sms" class="form-control sms" value="<?php echo $r['kode_sms'];?>" placeholder="Kode SMS" required>
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>Kode EDP : <i style="color:red;">*</i></label>
      <input type="text" name="edp" class="form-control edp" value="<?php echo $r['kode_edp'];?>" placeholder="Kode EDP" required>
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>SPV : <i style="color:red;">*</i></label>
      <input type="text" name="spv" class="form-control spv" value="<?php echo $r['spv'];?>" placeholder="Nama SPV" required>
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>Assisten : <i style="color:red;">*</i></label>
      <input type="text" name="ass" class="form-control ass" value="<?php echo $r['ass'];?>" placeholder="Assisten">
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>WA toko : </label>
      <input type="number" name="wa" class="form-control wa" value="<?php echo $r['wa_toko'];?>" placeholder="WA Toko">
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>Nomor SPV :</label>
      <input type="number" name="no_spv" class="form-control no_spv" value="<?php echo $r['spv_nomor'];?>" placeholder="Nomor SPV">
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>Nomor Assisten : </label>
      <input type="number" name="no_ass" class="form-control no_ass" value="<?php echo $r['ass_nomor'];?>" placeholder="Nomor Assisten">
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>Latitude : <i style="color:red;">*</i></label>
      <input type="text" name="lat" class="form-control lat" value="<?php echo $r['latitude'];?>" placeholder="Latitude" required>
      <br>
    </div>
    <div class="col-md-6 col-xs-12 input group">
      <label>Longitude : <i style="color:red;">*</i></label>
      <input type="text" name="lon" class="form-control lon" value="<?php echo $r['longitude'];?>" placeholder="Longitude" required>
      <br>
    </div>
</div>
</div>
<div class="col-md-3 col-xs-12">
	<div class="panel panel-primary" style="border-color:#d3d3d3;box-shadow:0px 0px 8px 0px #bababa;">
    	<div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Data Toko</div>
    	<div class="panel-body">
    		<h5>Diubah oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
    		<h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
    		<h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
     		<button type="submit" class="btn btn-success">Update Toko</button>
     		<?php echo br(2)?>
     		<div style="display:none;" class="alert-gagal"></div>
			<div style="display:none;" class="alert-sukses"></div>
 		</div>
    </div>
</div>
<?php echo form_close();?>
</div>
</div>