<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {

      $("#table_utang").DataTable();
      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
  });
</script>
<div class="page-title"> 
  <h3>Laporan Hutang & Piutang Pesanan
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/utang_dan_piutang')?>">Laporan Hutang & Piutang Pesanan</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<?php 
  $id = array('id' => 'fill-form');
  echo form_open('#', $id);
?>
  <div class="col-md-12">
      <div class="fil_best_seller">
        <div class="row">
          <div class="col-md-6 col-xs-12 form-group">
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
          <div class="col-md-6 col-xs-12 form-group">
            <fieldset class="field-fix">
            <legend class="leg-fix">Status</legend>
              <div class="row">
                <div class="col-md-12">
                   <div class="controls" style="margin-top: -5px;">
                      <label><input type="radio" name="status" value="2hd8jPl613!2_^5"> Menunggu Pembayaran</label>
                      <label><input type="radio" name="status" value="*^56t38H53gbb^%$0-_-"> Pembayaran Diterima</label>
                      <label><input type="radio" name="status" value="Uywy%u3bShi)payDhal"> Dalam Pengiriman</label>
                      <label><input type="radio" name="status" value="ScUuses8625(62427^#&9531(73" checked> Diterima</label>
                      <label><input type="radio" name="status" value="batal"> Dibatalkan</label>
                  </div>
                </div>
            </div>
            </fieldset>
            <br><br>
          </div>
        </div>
      </div>
    </div>
<?php echo form_close();?>
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
  <table id="table_utang" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:left;">Detail Order</th>
                    <th style="text-align:center;">Dibayar</th>
                    <th style="text-align:center;">Belum Dibayar</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //$tc = 0;
                //$tr = 0;
                if(count($get_list) > 0){ 

                foreach($get_list as $data):

                  //$tarif = $data->tarif;
                  //$act   = $data->actual_tarif;
                  //$tc +=($tarif);
                  //$tr +=($act);

                  if($data->dibayar == "belum" || $data->dibayar == ""){
                    $bayar = "";
                  }else{
                    $bayar = "style='background-color:#e6fde6;'";
                  }
                ?>
               <tr>
                  <td style="text-align:left;">
                    <span><b><?php echo $data->invoice;?> [ <?php echo $data->buy_in;?> ]</b> <?php echo date('d F Y',strtotime($data->tanggal_order));?></span><br>
                    <?php echo $data->nama_produk?> [<?php echo $data->artikel?>]<br>
                    <?php if($data->harga_before != "" || $data->harga_before > 0){echo "Rp. <s>".number_format($data->harga_before,0,".",".")."</s>"; }?> Rp. <?php echo number_format($data->harga_fix,0,".",".");?> <?php if($data->harga_before > 0 || $data->harga_before != ""){ $d = round(($data->harga_before - $data->harga_fix) / $data->harga_before * 100); echo"<i class='disc_la' class='label-diskon-detail'>$d%</i>";}?> x <?php echo $data->qty;?><br>Ukuran : <?php echo $data->ukuran;?><br>Sub Total : Rp. <?php echo number_format($data->harga_fix*$data->qty,0,".",".");?><br><br> 
                    <b>Ongkir</b><br>
                    Ongkir by Click <?php if($data->tarif == 0 || $data->tarif == ""){ echo "<i class='disc_la'>Gratis Ongkir</i>"; }else{ echo "Rp. $data->tarif";}?><br>
                    Actual Ongkir Rp. <?php echo $data->actual_tarif;?><br><br>
                    <b>Potongan / Pajak Marketplace</b><br>
                    <?php if($data->buy_in == "lazada"){?>
                      - Biaya Lazada Rp. <?php echo $data->harga_fix*1.804/100;?><br>
                      - VAT Lazada Rp. <?php echo $data->harga_fix*0.164/100;?><br>
                      - VAT Per pencairan Rp. <?php echo ($data->harga_fix*1.804/100 - $data->harga_fix*0.164/100)*10/100;?>
                    <?php }else{?> - <?php }?><br><br>
                    <b>Penjualan Bersih</b><br>
                    Rp. 
                    <?php 
                    if($data->buy_in == "lazada"){
                      $biaya_lazada = $data->harga_fix*1.804/100;
                      $vat = $data->harga_fix*0.164/100;
                      $vat_per_pencairan = ($data->harga_fix*1.804/100 - $data->harga_fix*0.164/100)*10/100;
                      echo number_format($data->harga_fix*$data->qty - ( $biaya_lazada + $vat + $vat_per_pencairan),0,".",".");
                    }else{
                      echo number_format($data->harga_fix*$data->qty,0,".",".");
                    }
                    ?>
                  </td>
                  <td style="text-align:center;">
                  <?php 
                  if($data->bayar == "sudah"){
                    echo "<br><br><br><br><br><br><br>";
                    echo "<i class='glyphicon glyphicon-ok' style='font-size:20px;'></i><br><br><br><br>";
                  }else{
                    echo "<br><br><br><br><br><br><br><br><br><br>";
                  }
                  if($data->dibayar == "bayar"){
                    echo "<i class='glyphicon glyphicon-ok' style='font-size:20px;'></i><br><br><br><br>";
                  }
                  if($data->dibayar == "bayar"){
                    echo "<i class='glyphicon glyphicon-ok' style='font-size:20px;'></i>";
                  }
                  ?>
                  </td>
                  <td style="text-align:center;">
                  <?php 
                  if($data->bayar == "belum" || $data->bayar == ""){
                    echo "<br><br><br><br><br><br><br>";
                    echo "<i class='glyphicon glyphicon-ok' style='font-size:20px;'></i><br><br><br><br>";
                  }else{
                    echo "<br><br><br><br><br><br><br>";
                  }
                  if($data->dibayar == "belum"){
                    echo "<i class='glyphicon glyphicon-ok' style='font-size:20px;'></i><br><br><br><br>";
                  }
                  if($data->dibayar == "belum"){
                    echo "<i class='glyphicon glyphicon-ok' style='font-size:20px;'></i>";
                  }
                  ?>
                  </td>
              </tr>
             <?php 
            endforeach;}
            else{ echo "<tr><td colspan='3'>DATA KOSONG!!</td></tr>";
              }?>
            </tbody>
  </table>
</div>
  </div>
</div>