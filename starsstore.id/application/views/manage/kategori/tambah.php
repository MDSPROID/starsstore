<div class="col-md-9">          
<a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
<?php echo br(3);?>
	<?php 
	$kat = array('id' => 'form-kategori');
	echo form_open('',$kat)?>
		<div class="input group">
			<label>Kategori :</label>
			<input type="text" name="kat" class="form-control" id="kat" placeholder="Nama Kategori" required>
			<br>
		</div>
		<div class="input group">
			<label>Parent kategori :</label>
			<select class="form-control" name="parent" id="parent">
					<option value="0">-- jadikan Menu Utama --</option>
				<?php foreach($datacat as $data){	?>
					<option value="<?php echo $data['kat_id'];?>"><?php echo $data['kategori'];?></option>
				<?php	}?>
			</select>
			<br>
		</div>
		<div class="input group">
			<label>Slug : <span style="color:red;">(*tanpa spasi atau ganti spasi dengan tanda -), (*tidak boleh memakai huruf besar)</span></label>
			<input type="text" name="slug" class="form-control" id="slug" placeholder="link kategori" required>
			<br>
		</div>
		<div class="input group">
			<label>Status :</label>
			<select class="form-control" name="aktif" id="stat">
				<option value="Y">Aktif</option>	
				<option value="N">Tidak Aktif</option>	
			</select>
			<br>
		</div>
		<div class="input group">
			<label>Deskripsi :</label>
			<textarea class="ckeditor" name="desc" id="desc"></textarea>
		</div>
	<?php echo form_close()?>
</div>
<div class="col-md-3">
	<div class="panel panel-primary" style="border-color:#d3d3d3;">
    	<div class="panel-heading" style="background-color:#1c2d3f;border-color:#f9f9f9;">Kategori</div>
    	<div class="panel-body">
    		<h6>Dibuat     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ $datas->nama_depan}?></b></h6>
    		<h6>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h6>
    		<h6>Tanggal    : <b><?php echo date('Y-m-d H:i:s')?></b></h6>
     		<a href="javascript:void(0)" style="background-color:#1c2d3f;" class="btn btn-primary simpan_kat">Simpan Kategori</a>
     		<?php echo br(2)?>
     		<div style="display:none;" class="alert-gagal"></div>
			<div style="display:none;" class="alert-sukses"></div>
 		</div>
    </div>
</div>