<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {

      $("#table_pemindahan").DataTable();
      //$("#table_dmk").DataTable();
      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd'
      });  

      table = $('#table_dmk').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('trueaccon2194/inout/load_dmk_serverside')?>",
            "type": "POST",
            "data": function ( data ) {
                data.color = $('#marketplace').val();
                data.tgl1 = $('#tgl1').val();
                data.tgl2 = $('#tgl2').val();
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //last column
            "orderable": false, //set not orderable
        },
        ],
    
      });

      $('.btn-filter').click(function(){ //button filter event click
          table.ajax.reload();  //just reload table
      });       
  });
</script>
<div class="page-title"> 
  <h3>Laporan Barang masuk & Keluar
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/inout')?>">Laporan Barang Masuk & Keluar</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a  href="<?php echo base_url('trueaccon2194/inout/input');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Barang Masuk / Keluar</a><br><br><br>
</div>
  <div class="col-md-12">
      <div class="fil_best_seller">
        <div class="row">
          <?php 
            $id = array('id' => 'fill-form');
            echo form_open('trueaccon2194/inout/laporan_inout', $id);
          ?>
          <div class="col-md-4 col-xs-12 form-group">
            <fieldset class="field-fix">
            <legend class="leg-fix">Tanggal</legend>
              <div class="row">
                <div class="col-md-12 input group ">
                <label>Tanggal awal : <i style="color:red;">*</i></label>
                <div id="datetimepicker1" class="input-append">
                    <input type="text" data-format="yyyy-MM-dd" name="tgl1" class="form-control cek_tgl" placeholder="Tanggal awal" required>
                    <span class="add-on">
                      <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>   
                  </div>
                  <br>
                </div>
                <div class="col-md-12 input group ">
                <label>Tanggal akhir : <i style="color:red;">*</i></label>
                <div id="datetimepicker2" class="input-append">
                    <input type="text" data-format="yyyy-MM-dd" name="tgl2" class="form-control cek_tgl" placeholder="Tanggal akhir" required>
                    <span class="add-on">
                      <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>   
                  </div>
                  <br>
                </div>
                <div class="col-md-12 input group ">
                  <label>Marketplace : <i style="color:red;">*</i></label>
                  <select name="marketplace" id="marketplace" class="form-control">
                    <option value="">-- pilih --</option>
                    <option value="semua">Semua</option>
                    <?php foreach($market as $m){?>
                      <option value="<?php echo $m->val_market?>"><?php echo $m->market?></option>
                    <?php }?>
                  </select>
                  <br>
                </div>
                <div class="col-md-12">
                  <button type="submit" name="laporan" value="filter" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-filter"></i> Filter</button> <button type="submit" name="laporan" value="cetak" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button> <button type="submit" name="laporan" value="excel" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Export Excel</button>
                </div>
              </div>
            </fieldset>
          </div>
          <?php echo form_close();?>
          <div class="col-md-4 col-xs-12 form-group">
            <fieldset class="field-fix">
            <legend class="leg-fix">Upload DMK</legend>
              <div class="row">
                <div class="col-md-12 form-group">
                  <?php echo form_open_multipart('trueaccon2194/inout/upload_dmk_by_excel');?>
                  <input type="file" style="margin-bottom: 10px;" name="fileupload" class="form-control">
                  <button class="btn btn-danger mail_sb hj cek_stok" style="line-height: 14px;">Upload DMK dari RIMS (Excel)</button>
                  <?php echo form_close();?>
                  <i style="color:red">*File Harus .xls</i><br>
                  <a href="<?php echo base_url('inout/download_template_dmk');?>">>> Download Template DMK</a>
                </div>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
<table id="table_dmk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
  <thead>
      <tr style="background-color:#34425a;color:white;">
          <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
          <th style="text-align:center;">Tanggal</th>
          <th style="text-align:center;">Invoice</th>
          <th style="text-align:center;">Jenis</th>
          <th style="text-align:center;">Pasang</th>
          <th style="text-align:center;">Rupiah</th>
          <th style="text-align:center;">Dari / Ke</th>
          <th style="text-align:center;">Keterangan</th>
          <th style="text-align:center;">Opsi</th>
      </tr>
  </thead>
  <tbody></tbody>
</table>

<table id="table_pemindahan" class="hidden table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Tanggal</th>
                    <th style="text-align:center;">Invoice</th>
                    <th style="text-align:center;">Jenis</th>
                    <th style="text-align:center;">Pasang</th>
                    <th style="text-align:center;">Rupiah</th>
                    <th style="text-align:center;">Dari / Ke</th>
                    <th style="text-align:center;">Keterangan</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $this->load->model('sec47logaccess/inout_adm');
                foreach($get_list as $data):
                  $idinvoice = $data->invoice;
                  $get_inv = $this->inout_adm->get_list_inv($idinvoice);
                  $invxx = array();
                  foreach($get_inv as $k){
                    $invxx[] = $k->inv;
                  }
                  $invx = implode(', ',$invxx);
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_inout;?>" /></td>
                  <td style="text-align:center;"><?php echo date('d/m/y',strtotime($data->tanggal));?></td>
                  <td style="text-align:center;"><?php echo $data->invoice;?></td>
                  <td style="text-align:center;"><?php if($data->jenis == "masuk"){ echo "<label class='label label-success'>Masuk</label>";}else{ echo "<label class='label label-danger'>Keluar</label>";}?></td>
                  <td style="text-align:center;"><?php echo $data->pasang;?></td>
                  <td style="text-align:center;">Rp. <?php echo number_format($data->rupiah,0,".",".");?></td>
                  <td style="text-align:center;"><?php echo $data->source;?></td>
                  <td style="text-align:center;"><?php echo $data->keterangan;?><br>
                    <?php if($data->jenis == "masuk"){?>
                      <span style="font-size: 12px;margin-top: 10px;" class="label label-primary">No. Pesanan : <?php echo $invx?></span>
                    <?php }?>
                  </td>
                  <td style="text-align:center;">
                    <a href="<?php echo base_url()?>trueaccon2194/inout/edit/<?php $id = $this->encrypt->encode($data->invoice); $idp = base64_encode($id); echo $idp ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a href="<?php echo base_url()?>trueaccon2194/inout/hapus/<?php $id = $this->encrypt->encode($data->id_inout); $idp = base64_encode($id); echo $idp ?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
              </tr>
             <?php 
            endforeach;?>
            </tbody>
            <tfoot>
              <tr style="background-color:#34425a;color:white;">
                  <th style="text-align:right;" colspan="9"></th>
              </tr>
            </tfoot>
  </table>
</div>
  </div>
</div>