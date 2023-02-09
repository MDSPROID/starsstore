<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () { 

    $('#datetimepicker1').datetimepicker({
      format: 'yyyy-MM-dd hh:mm:ss'
    });         
  });
</script>
<div class="page-title">
  <h3>Tambah Voucher
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
      <li><a href="<?php echo base_url('trueaccon2194/voucher')?>">Voucher dan Kupon</a></li>
      <li class="active">Tambah Voucher</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/voucher/proses_tambah_voucher', array('id'=>'form_produk_add'));?>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
      	<div id="general" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-6 input group">
                <label> Nama voucher : <i style="color:red;">*</i></label>
                <input type="text" name="nama_voucher" class="form-control cek_nama" id="slug" placeholder="Nama Voucher" required>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Gambar / Banner : <i style="color:red;">*</i></label><i style="color:red;">Gambar tidak diupload jika melebihi 1MB</i>
                <div class="input-group">
                <input type="text" name="gambar" class="form-control cek_odv" id="carfID">
                <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
                </span>
                </div>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Keterangan : </label> <i style="color:red;">*</i>
                <input type="text" name="keterangan" class="form-control cek_tags" id="slug" placeholder="Keterangan" required>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Stok : </label> <i style="color:red;">*</i>
                <input type="text" name="stok" class="form-control cek_artikel" id="slug" placeholder="Stok" required>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Action : </label><br>
                <i style="color:red;">*jika menambahkan voucher gratis ongkir, kosongkan inputan ini.<br>*Jika Menambahkan voucher gratis artikel tertentu isikan dengan format free|nama artikel|harga</i>
                <input type="text" name="action" class="form-control cek_retail" id="slug" placeholder="Action" >
                <br>
              </div>
              <div class="col-md-6 input group ">
              <label>Masa Berlaku : <i style="color:red;">*</i></label>
              <div id="datetimepicker1" class="input-append">
                  <input type="text" data-format="yyyy-MM-dd" name="masa_berlaku" class="form-control cek_tgl" placeholder="Masa Berlaku" required>
                  <span class="add-on">
                    <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                  </span>   
                </div>
                <br>
              </div>
              <div class="col-md-12 input group">
                <label>Minim Pembelanjaan : </label> <i style="color:red;">*jika ada minimal pembelanjaan untuk mendapatkan voucher ini maka isikan nominal, atau kosongkan inputan ini.</i>
                <input type="number" name="action_minim" class="form-control cek_retail" id="slug" placeholder="Minimal Pembelanjaan" >
                <br>
              </div>
            </div>
        </div>
        <i style="color:red;">(*) wajib diisi</i><br>
        <i style="color:red;">(*) Jika ingin menambahkan voucher diskon++, pada inputan action gunakan tanda (,) contoh 10,30,50. artinya diskon pasang 1 10%, pasang ke 2 30%, dan pasang ke 3 50%. maksimal 3 diskon. diskon akan dihitung jika harga lebih besar maka diskonnya memakai yang terkecil, jika harga lebih rendah maka diskonnya memakai diskon terbesar.</i>
  </div>
</div>
<div class="col-md-3">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
        <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
        <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
        <h5>Tanggal    : <b><?php echo date('d M Y')?></b></h5>
        <button type="submit" class="simpan_review btn btn-success">Simpan Voucher</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<?php echo form_close();?>