<link href="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" rel="stylesheet" type="text/css"/>
 <script src="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.min.js');?>"></script>
<div class="page-title">
  <h3>Edit Kategori 
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
      <li><a href="<?php echo base_url('trueaccon2194/kategori')?>">Kategori</a></li>
      <li class="active" href="#">Edit Kategori</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">

<?php 
  $kat = array('id' => 'form-kategori');
  echo form_open('trueaccon2194/kategori_divisi/update_kategori',$kat)?>
<div class="col-md-9">          
<a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
<?php echo br(3);?>
<div style="box-shadow:0px 0px 8px 0px #bababa;padding:10px;background-color:white;">
		<div class="input group">
			<label>Kode Kategori :</label>
			<input type="text" name="kat" class="form-control" id="kat" placeholder="Nama Kategori" value="<?php echo $updatedata['kode_kategori'];?>" required>
			<input type="hidden" name="id_kategori" class="form-control" id="id_kat" value="<?php $kat = $this->encrypt->encode($updatedata['kat_divisi_id']); $id = base64_encode($kat); echo $id ?>" required>
			<br>
		</div>
		<div class="input group">
			<label>Kategori Divisi :</label>
			<input type="text" name="divisi" class="form-control" id="slug" value="<?php echo $updatedata['nama_kategori_divisi'];?>" required>
			<br>
		</div>
		<div class="input-group">
      <label>Status :</label>
          <div class="ios-switch switch-lg">
            <input type="checkbox" name="status" class="js-switch pull-right fixed-header-check" <?php echo $aktif1;?>>
          </div>  		
    </div>
</div>
</div>
<div class="col-md-3">
	<div class="panel panel-primary" style="border-color:#d3d3d3;box-shadow:0px 0px 8px 0px #bababa;">
    	<div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Kategori</div>
    	<div class="panel-body">
    		<h5>Diubah oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
    		<h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
    		<h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
     		<button type="submit" class="btn btn-success">Simpan Kategori</button>
     		<?php echo br(2)?>
     		<div style="display:none;" class="alert-gagal"></div>
			<div style="display:none;" class="alert-sukses"></div>
 		</div>
    </div>
</div>
<?php echo form_close();?>
</div>
</div>