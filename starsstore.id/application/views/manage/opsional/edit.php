<script type="text/javascript">
	$(document).ready(function(){

	var ckeditor = CKEDITOR.config.toolbar = [
   ['Styles','Format','Font','FontSize'],
   '/',
   ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
   '/',
   ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
   ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source']
] ;
	});
</script>
<div style="margin-top:-70px;"><h2>Edit Merk</h2></div>
<?php echo br();?>
<div class="col-md-9">          
<a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
<?php echo br(3);?>
	<?php 
	$kat = array('id' => 'form-merk');
	echo form_open('',$kat)?>
		<div class="input group">
			<label>Merk :</label>
			<input type="text" name="merk" class="form-control" id="merk" placeholder="Nama Merk" value="<?php echo $updatedata['merk'];?>" required>
			<input type="hidden" name="id" class="form-control" id="id_merk" value="<?php echo $updatedata['merk_id'];?>" required>
			<br>
		</div>
		<div class="input group">
			<label>Slug : <span style="color:red;">(*tanpa spasi atau ganti spasi dengan tanda -), (*tidak boleh memakai huruf besar)</span></label>
			<input type="text" name="slug" class="form-control" id="slug" value="<?php echo $updatedata['slug'];?>" required>
			<br>
		</div>
		<div class="switch-field">
      		<div class="switch-title"><b>Status :</b></div>
      		<input type="radio" id="switch_left" name="aktif" value="Y" <?php echo $aktif1;?>/>
      		<label for="switch_left">Aktif</label>	
      		<input type="radio" id="switch_right" name="aktif" value="N" <?php echo $aktif2;?>/>
      		<label for="switch_right">Tidak Aktif</label>
    	</div>
		<div class="input group">
			<label>Deskripsi :</label>
			<textarea class="ckeditor" name="desc" id="desc"><?php echo $updatedata['deskripsi'];?></textarea>
		</div>
	<?php echo form_close()?>
</div>
<div class="col-md-3">
	<div class="panel panel-primary" style="border-color:#d3d3d3;">
    	<div class="panel-heading" style="background-color:#1c2d3f;border-color:#f9f9f9;">Kategori</div>
    	<div class="panel-body">
    		<h6>Diubah oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h6>
    		<h6>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h6>
    		<h6>Tanggal    : <b><?php echo date('Y-m-d H:i:s')?></b></h6>
     		<a href="javascript:void(0)" style="background-color:#1c2d3f;" class="btn btn-primary update_merk">Update Merk</a>
 		</div>
    </div>
</div>