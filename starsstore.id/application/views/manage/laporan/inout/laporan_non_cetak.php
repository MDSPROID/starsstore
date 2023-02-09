<script type="text/javascript">
  $(document).ready( function () {
      $("#table_produk").DataTable();      
  });
</script>
<div class="page-title">
  <h3>Laporan Barang masuk & keluar
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
      <li><a href="<?php echo base_url('trueaccon2194/trueaccon2194/inout')?>">Laporan barang masuk & keluar</a></li>
      <li class="active">Preview Laporan</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
    <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
    <?php echo br(2);?>
  </div>
  <div class="col-md-12">
      <div class="row">
          <div class="col-md-12">
            <h2 class="text-center"><b>PERTELAAN BARANG MASUK - KELUAR</b></h2><br><br>
            <h4>ALAMAT : Toko E-Commerce<span class="pull-right">PERIODE : <?php echo date('d F Y', strtotime($tgl1));?> - <?php echo date('d F Y', strtotime($tgl2));?></span></h4>
            <h4>EDP CODE : 100-01 <span class="pull-right">MINGGU : .............................</span></h4>
          </div>
          <div class="col-md-12 table-responsive">  
            <h3>BARANG MASUK</h3>
            <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Tanggal</th>
                    <th style="text-align:center;">No. Invoice</th>
                    <th style="text-align:center;">Pasang</th>
                    <th style="text-align:center;">Rupiah</th>
                    <th style="text-align:center;">Dari</th>
                    <th style="text-align:center;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $tc = 0;
                $tr = 0;
                if(count($get_list) > 0){
                foreach($get_list as $data):
                  if($data->jenis == "masuk"){
                  //$tarif = $data->tarif;
                  //$act   = $data->actual_tarif;
                  $tc +=($data->pasang);
                  $tr +=($data->rupiah);
                  
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
                  <td style="text-align:center;"><?php echo $data->pasang;?></td>
                  <td style="text-align:center;">Rp. <?php echo number_format($data->rupiah,0,".",".");?></td>
                  <td style="text-align:center;"><?php echo $data->source;?></td>
                  <td style="text-align:center;"><?php echo $data->keterangan;?><br><span style="font-size: 12px;">No. Pesanan : <?php echo $invx?></span></td>                  
              </tr>
             <?php }endforeach;}else{ echo "<tr><td style='text-align:center;' colspan='7'>Tidak ada barang masuk</td></tr>";}
              ?>
            </tbody>
            <tfoot>
              <tr style="background-color:#34425a;color:white;">
                  <th style="text-align:right;text-align: center;" colspan="3">Total</th>
                  <th style="text-align:center;"><?php echo $tc;?></th>
                  <th style="text-align:center;">Rp. <?php echo number_format($tr,0,".",".");?></th>
                  <th style="text-align:center;" colspan="2"></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="col-md-12 table-responsive">  
            <h3>BARANG KELUAR</h3>
            <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Tanggal</th>
                    <th style="text-align:center;">No. Invoice</th>
                    <th style="text-align:center;">Pasang</th>
                    <th style="text-align:center;">Rupiah</th>
                    <th style="text-align:center;">Ke</th>
                    <th style="text-align:center;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $tc = 0;
                $tr = 0;
                if(count($get_list) > 0){
                foreach($get_list as $data):
                  if($data->jenis == "keluar"){
                  //$tarif = $data->tarif;
                  //$act   = $data->actual_tarif;
                  $tc +=($data->pasang);
                  $tr +=($data->rupiah);
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_inout;?>" /></td>
                  <td style="text-align:center;"><?php echo date('d/m/y',strtotime($data->tanggal));?></td>
                  <td style="text-align:center;"><?php echo $data->invoice;?></td>
                  <td style="text-align:center;"><?php echo $data->pasang;?></td>
                  <td style="text-align:center;">Rp. <?php echo number_format($data->rupiah,0,".",".");?></td>
                  <td style="text-align:center;"><?php echo $data->source;?></td>
                  <td style="text-align:center;"><?php echo $data->keterangan;?></td>                  
              </tr>
             <?php }endforeach;}else{ echo "<tr><td style='text-align:center;' colspan='7'>Tidak ada barang masuk</td></tr>";}
              ?>
            </tbody>
            <tfoot>
              <tr style="background-color:#34425a;color:white;">
                  <th style="text-align:right;text-align: center;" colspan="3">Total</th>
                  <th style="text-align:center;"><?php echo $tc;?></th>
                  <th style="text-align:center;">Rp. <?php echo number_format($tr,0,".",".");?></th>
                  <th style="text-align:center;" colspan="2"></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="col-md-12">
          <p style="line-height: 30px;">Surabaya, ..............................................<br>DEPT. E-COMMERCE<br><br><br><br></p>
        </div>
      </div>
  </div>
</div>
</div>