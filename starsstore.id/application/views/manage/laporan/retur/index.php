<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () { 

    $("#table_produk").DataTable();
    $('#datetimepicker1').datetimepicker({
      format: 'yyyy-MM-dd'
    });  
    $('#datetimepicker2').datetimepicker({
      format: 'yyyy-MM-dd'
    });  
       
  });
</script>
<div class="page-title">
  <h3>Laporan Retur
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
      <li>Laporan</li>
      <li class="active">Laporan Retur</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<?php 
  $id = array('id' => 'fill-form');
  echo form_open('trueaccon2194/laporan_retur/get_retur_report', $id);
?>
  <div class="col-md-12">
      <div class="fil_best_seller">
        <div class="row">
          <div class="col-md-5 col-xs-12 form-group">
            <fieldset class="field-fix">
            <legend class="leg-fix">Tanggal</legend>
              <div class="row">
                <div class="col-md-6 input group ">
                <label>Tanggal awal : <i style="color:red;">*</i></label>
                <div id="datetimepicker1" class="input-append">
                    <input type="text" data-format="yyyy-MM-dd" name="tgl1" class="form-control cek_tgl" placeholder="Tanggal awal" required>
                    <span class="add-on">
                      <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>   
                  </div>
                  <br>
                </div>
                <div class="col-md-6 input group ">
                <label>Tanggal akhir : <i style="color:red;">*</i></label>
                <div id="datetimepicker2" class="input-append">
                    <input type="text" data-format="yyyy-MM-dd" name="tgl2" class="form-control cek_tgl" placeholder="Tanggal akhir" required>
                    <span class="add-on">
                      <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>   
                  </div>
                  <br>
                </div>
                <div class="col-md-12">
                  <button type="submit" name="laporan" value="filter" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-filter"></i> Lihat Laporan</button> <button type="submit" name="laporan" value="cetak" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button> <button type="submit" name="laporan" value="excel" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Export Excel</button>
                </div>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
<?php echo form_close();?>
<?php if(empty($get_list)){?>
<div class="col-md-12">
  <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
    <div class="row">
      <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
    </div>
  </div>
</div>
<?php } else {?>
<div class="col-md-12 table-responsive">  
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Tanggal Retur</th>
                    <th style="text-align:center;">Nomor Retur</th>
                    <th style="text-align:center;">Invoice</th>
                    <th style="text-align:center;">Customer</th>
                    <th style="text-align:center;">Alasan Retur</th>
                    <th style="text-align:center;">Solusi</th>
                    <th style="text-align:center;">Tanggal Selesai Retur</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_retur_info;?>" /></td>
                  <td style="text-align:center;"><?php $t = $data->date_create; echo date('d F Y H:i:s', strtotime($t));?></td>
                  <td style="text-align:center;"><?php echo $data->id_retur_info;?></td>
                  <td style="text-align:center;"><?php echo $data->invoice;?></td>
                  <td style="text-align:center;"><?php echo $data->nama_lengkap;?></td>
                  <td style="text-align:center;"><?php echo $data->alasan;?></td>
                  <td style="text-align:center;"><?php if($data->solusi == ""){ }else{ echo $data->solusi_retur; }?></td>
                  <td style="text-align:center;"><?php if($data->date_end == "0000-00-00 00:00:00"){ echo "<label class='label label-danger'>Belum Selesai / Masih dalam Proses</label>";}else{ $x = $data->date_end; echo date('d F Y H:i:s', strtotime($x));}?></td>
                  <td style="text-align:center;">
                  <?php
                    if($data->status_retur == "JGErnoahs3721"){
                      echo "<label class='label label-danger'>Tidak Aktif / Dibatalkan</label>";
                    }else if($data->status_retur == "Kgh3YTsuccess"){
                      echo "<label class='label label-success'>Sukses</label>";
                    }else if($data->status_retur == "Ksgtvwt%t2ditangguhkan"){
                      echo "<label class='label label-warning'>Sedang diproses</label>";
                    }
                  ?></td>
                  <td style="text-align:center;">
                    <a href="<?php echo base_url()?>trueaccon2194/laporan_retur/cetak_laporan_retur/<?php $id = $this->encrypt->encode($data->id_retur_info); $idp = base64_encode($id); echo $idp ?>" class="btn btn-default cetak"><i class="glyphicon glyphicon-print"></i></a>
                  </td>
              </tr>
             <?php 
            endforeach;?>
            </tbody>
      </table>
    </div>
<?php }?>
</div>
</div>