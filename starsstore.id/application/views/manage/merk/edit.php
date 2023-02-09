<div class="page-title">
  <h3>Edit Merk
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
      <li><a href="<?php echo base_url('trueaccon2194/merk')?>">Merk</a></li>
      <li class="active">Edit Merk</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-9">          
<a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
<?php echo br(3);?>
	<?php 
	$kat = array('id' => 'form-merk');
	echo form_open('trueaccon2194/merk/update_merk',$kat)?>
	<div style="box-shadow:rgb(186, 186, 186) 0px 0px 8px 0px;padding:10px;background-color:white;">
		<div class="input group">
			<label>Merk :</label>
			<input type="text" name="merk" class="form-control" id="merk" placeholder="Nama Merk" value="<?php echo $updatedata['merk'];?>" required>
			<input type="hidden" name="id" class="form-control" id="id_merk" value="<?php $a = $this->encrypt->encode($updatedata['merk_id']); $b = base64_encode($a); echo $b ?>" required>
			<br>
		</div>
		<div class="input group">
			<label>Logo :</label>
			<div class="input-group">
            <input type="text" name="logo" class="form-control" id="carfID" value="<?php echo $updatedata['logo'];?>" >
            <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
            </span>
            </div>
			<br>
		</div>
    <div class="input group">
      <label>Banner Promo :  <span style="color:red;">Jika ada, banner akan ditampilkan di halaman brand highlight</span></label>
      <div class="input-group">
            <input type="text" name="banner" class="form-control" id="carfID1" value="<?php echo $updatedata['banner'];?>" >
            <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif1"><i class="glyphicon glyphicon-search"></i></a>
            </span>
            </div>
      <br>
    </div>
		<div class="input group">
			<label>Slug : <span style="color:red;">(*tanpa spasi atau ganti spasi dengan tanda -), (*tidak boleh memakai huruf besar)</span></label>
			<input type="text" name="slug" class="form-control" id="slug" value="<?php echo $updatedata['slug'];?>" required>
			<br>
		</div>
		<div class="row">
		<div class="col-md-12">
      		<label>Status :</label>
            <div class="ios-switch switch-lg">
                <input type="checkbox" name="status" class="js-switch pull-right fixed-header-check" <?php echo $status1;?>>
            </div>
    	</div>
    	</div>
    	<br>
		<div class="input group">
			<label>Deskripsi :</label>
			<textarea name="desc" id="desc"><?php echo $updatedata['deskripsi'];?></textarea>
		</div>
	</div>
</div>
<div class="col-md-3">
	<div class="panel panel-primary" style="border-color:#d3d3d3;">
    	<div class="panel-heading" style="background-color:#1c2d3f;border-color:#f9f9f9;">Kategori</div>
    	<div class="panel-body">
    		<h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
        	<h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
        	<h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
        	<button type="submit" class="btn btn-primary">Update Merk</button>
 		</div>
    </div>
</div>
<?php echo form_close()?>
</div>
</div>