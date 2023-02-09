<script type="text/javascript">
  $(document).ready( function () {

      $("#table_stok").DataTable();
  });
</script>
<div class="page-title">
  <h3>Stok
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
      <li><a href="<?php echo base_url('trueaccon2194/stok')?>">Stok</a></li>
      <li class="active">Stok Taking</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-6 col-xs-12"> 
  <h3><i>HARAP LAKUKAN STOK TAKING SAMPAI SELESAI!</i></h3>
  <div class="panel" style="border-top:3px solid #434348;padding-top:0px;box-shadow:0px 0px 8px 0px #bababa;background-color:white;">
      <div style="padding:15px;padding-bottom:30px;background-color:white;box-shadow:0px 0px 8px 0px #bababa;">
        <div class="col-xs-8" ><b>PRODUK</b></div>
        <div class="col-xs-2" style="text-align:right;"><b>SIZE</b></div>
        <div class="col-xs-2" style="text-align:right;"><b>STOK</b></div>
      </div>
      <div class="panel-body scroll-menu" style="margin-top:0px;height:350px;padding-top:5px;">
      <?php echo form_open('trueaccon2194/stok/insert_taking');?>
        <?php 
        if(count($produk_taking) == 0){
            echo "<div class='text-center' style='margin-top:100px;'><span style='font-size:100px;color:#ededed;' class='glyphicon glyphicon-search'></span><div class='col-xs-12'>Tidak Ada Data</div></div>";
          }else{
          $jumlah = 0;
          foreach($produk_taking as $data){
          if($data->lokasi_barang == "ecommerce"){
        ?>
          <input type="hidden" name="id_update_pro[]" value="<?php echo $data->id_produk;?>">
          <input type="hidden" name="artikel[]" value="<?php echo $data->artikel;?>">
          <input type="hidden" name="size[]" value="<?php echo $data->opsi_size;?>">
          <h5 style="padding-bottom: 5px;"><b>
          <i class="hidden-lg" style="font-style:normal;">[ <?php echo $data->artikel;?> ]</i>
          <i class="hidden-xs"><?php echo $data->nama_produk;?> [ <?php echo $data->artikel;?> ]</i>
          <label style='font-size:13px;' title="Color" class='label label-primary'><?php echo $data->opsi_color;?></label>
          <input type="hidden" class="pull-right" style="width:10%;margin-left:5px;text-align:center;" id="size_stok" name="size_stok[]" value="<?php echo $data->stok?>">
          </b> <input type="text" class="pull-right" style="width:10%;margin-left:10px;text-align:center;" id="update_stok" name="stok_taking[]" onblur="totalTaking();">
          <?php 
          $stok = $data->stok;
          $jumlah += $data->stok;
          if($stok < 10){
            echo "<label style='font-size:13px;' class='label label-danger pull-right'>$stok</label>";
          }else{
            echo "<label style='font-size:13px;' class='label label-warning pull-right'>$stok</label>";
          }
          ?>
          <label style='font-size:13px;margin-right: 5px;' title="Size" class='label label-default pull-right'><?php echo $data->opsi_size;?></label>
          </h5>
        <?php }}}?>
      </div>
      <div class="col-xs-12" style="margin-bottom:20px;margin-top:-5px;background-color:white;padding:6px;background-color:white;box-shadow:0px 0px 8px 0px #bababa;"><button type="submit" name="submit" class="btn btn-success">Selesai</button> <div class="pull-right" style="margin-top: 10px;"><b style="margin-right: 20px;"><?php echo $jumlah?></b><b class="total_taking" style="margin-right: 20px;"></b></div></div>
      <?php echo form_close();?>
    </div>
</div>
<div class="col-md-6 col-xs-12 table-responsive"> 
  <h3>HASIL STOK TAKING</h3>
<div id="pesan"></div>
<?php foreach($hasil_taking as $r){ }?>
<?php if(empty($r->stok_fisik)){?>
<div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
  <div class="row">
    <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
  </div>
</div>
<?php }else{?>
  <table id="table_stok" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Tanggal</th>
                    <th style="text-align:center;">User</th>
                    <th style="text-align:center;">Stok Database</th>
                    <th style="text-align:center;">Stok Fisik</th>
                    <th style="text-align:center;">Selisih Stok Database & Stok Fisik</th>
                    <th style="text-align:center;">Hasil</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($hasil_taking as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" /></td>
                  <td style="text-align:center;"><?php echo date('d F Y H:i:s', strtotime($data->tanggal_stok))?></td>
                  <td style="text-align:center;"><?php echo $data->nama_depan?></td>
                  <td style="text-align:center;"><?php echo $data->stok_db;?></td>
                  <td style="text-align:center;"><?php echo $data->stok_fisik;?></td>
                  <td style="text-align:center;"><?php echo $data->stok_fisik - $data->stok_db;?></td>
                  <td style="text-align:center;"><a class="btn btn-default" href="<?php echo base_url('trueaccon2194/stok/result_taking/'.$data->tgl.'');?>"><i class="glyphicon glyphicon-eye-open"></i></a> <a class="btn btn-danger" href="<?php echo base_url('trueaccon2194/stok/hapus_result_taking/'.$data->tgl.'');?>"><i class="glyphicon glyphicon-trash"></i></a></td>
              </tr>
             <?php 
            endforeach;?>
            </tbody>
  </table>
<?php }?>
</div>
</div>
</div>