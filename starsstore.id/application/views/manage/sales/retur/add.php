<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<div class="page-title">
  <h3>Tambah Retur
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
      <li><a href="<?php echo base_url('trueaccon2194/retur')?>">Retur</a></li>
      <li class="active">Edit Retur</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9 col-xs-12">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/retur/proses_tambah_retur', array('id'=>'form_produk_add'));?>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
        <div id="general" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-6 col-xs-12 input group">
                <label>Kode Retur : </label>
                <input type="text" style="font-weight: bold;" name="kode_retur" readonly="readonly" value="<?php echo $kode_retur?>" class="form-control cek_slug" id="slug" placeholder="ID Retur" required>
                <br>
              </div>
              <div class="col-md-6 col-xs-12 input group ">
                <label>Tanggal Retur : <i style="color:red;">*</i></label>
                <div id="datetimepicker1" class="input-append">
                  <input type="text" data-format="yyyy-MM-dd" id="tgl1" name="tglretur" class="form-control cek_tgl" placeholder="Tanggal Retur" required>
                  <span class="add-on">
                    <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                  </span>   
                </div>
                <br>
              </div>
              <div class="col-md-6 col-xs-6 input group">
                <label>Invoice Retur : </label> <i style="color:red;">*</i>
                <input type="text" name="invoiceretur" class="form-control cek_slug" id="slug" placeholder="Invoice Yang Diretur" required>
                <br>
              </div>
              <div class="col-md-6 col-xs-6 input group">
                <label>Invoice Pengganti : </label> <i style="color:red;">diisi ketika ada invoice penggantinya</i>
                <input type="text" name="invoicepengganti" class="form-control cek_slug" id="slug" placeholder="Invoice Pengganti" >
                <br>
              </div>
              <div class="col-xs-6 col-md-6">
                <label>Produk di Retur : </label>
                <div id="produkretur" class="urlmode">
                  <div class="toclone">
                    <a href="#" class="clone" style="color: green;margin-right: 5px;"><i class="glyphicon glyphicon-plus"></i></a>
                    <a href="#" class="delete" style="color: red;"><i class="glyphicon glyphicon-remove"></i></a>
                    <input type="text" name="produk1[]" class="form-control cek_slug" placeholder="PRODUK DIRETUR - TULIS ARTIKEL DAN UKURAN" required>
                    <br>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xs-6">
                <label>Produk Pengganti: </label>
                <div id="produkpengganti" class="urlmode">
                  <div class="toclone">
                    <a href="#" class="clone" style="color: green;margin-right: 5px;"><i class="glyphicon glyphicon-plus"></i></a>
                    <a href="#" class="delete" style="color: red;"><i class="glyphicon glyphicon-remove"></i></a>
                    <input type="text" name="produk2[]" class="form-control cek_slug" placeholder="PRODUK PENGGANTI - TULIS ARTIKEL DAN UKURAN" required>
                    <br>
                  </div>
                </div>
              </div>
              <div class="col-md-6 input group">
                <label>Alasan Retur : </label> <i style="color:red;">*</i>
                <input type="text" name="alasan" class="form-control cek_slug" id="slug" placeholder="Alasan Retur" required>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label> Solusi : <i style="color:red;">*</i></label>
                <select class="form-control cek_nama" name="solusi" required> 
                  <option>--- pilih ---</option>
                  <?php foreach($solusi as $data){?>
                      <option value="<?php echo $data['id_solusi']?>"><?php echo $data['solusi_retur']?></option>    
                  <?php }?>
                </select>
                <br>
              </div>
              <div class="col-md-12 input group">
                  <label>Keterangan : <br><i style="color:red;">Isi nama toko pengirim awal dan nama toko pengirim produk pengganti serta nomor resi pengiriman produk pengganti</i></label></label>
                  <textarea name="keterangan" id="mytextarea" ></textarea>
                <?php echo br()?>
              </div>
            </div>
        </div>
        <i style="color:red;">(*) wajib diisi</i>
  </div>
</div>
<div class="col-md-3 col-xs-12">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
    <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
    <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
      <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
      <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
      <h5>Tanggal    : <b><?php echo date('d M Y')?></b></h5>
      <button type="submit" class="simpan_review btn btn-success">Simpan</button>
      <?php echo br(2)?>
    </div>
  </div>
</div>
<?php echo form_close();?>
</div>
</div>
<script src="<?php echo base_url('assets/manage/js/cloneya/jquery-cloneya.js');?>"></script>
<script>
  $('#produkretur').cloneya();
  $('#produkpengganti').cloneya();
  $('#datetimepicker1').datetimepicker({
    format: 'yyyy-MM-dd'
  });    
</script>