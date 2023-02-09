<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () { 

    $("#table_report").DataTable();
    $('#datetimepicker1').datetimepicker({
      format: 'yyyy-MM-dd'
    });  
    $('#datetimepicker2').datetimepicker({
      format: 'yyyy-MM-dd' 
    });  
       
  });
</script>
<div class="page-title">
  <h3>Laporan Order
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
      <li class="active">Laporan Order</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<?php 
  $id = array('id' => 'fill-form');
  echo form_open('trueaccon2194/report_order/laporan_penjualan', $id);
?>
  <div class="col-md-12">
    <div class="fil_best_seller">
      <div class="row">
        <div class="col-md-3 col-xs-12 form-group">
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
                <button type="submit" name="laporan" value="filter" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-filter"></i> Lihat Laporan</button> <button type="submit" name="laporan" value="filter_detail" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-filter"></i>  Laporan Detail</button> <button type="submit" name="laporan" value="cetak" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button> <button type="submit" name="laporan" value="excel" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Export Excel</button>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="col-md-3 col-xs-12 form-group">
          <fieldset class="field-fix">
          <legend class="leg-fix">Jenis Artikel</legend>
            <div class="row">
              <div class="col-md-12">
                 <div class="controls" style="margin-top: -5px;">
                 <?php foreach($jenisoption as $h){?>
                    <label><input type="radio" name="jenis_artikel" value="<?php echo $h->jenis?>"><?php echo $h->jenis?></label>
                  <?php }?>
                  <label><input type="radio" name="jenis_artikel" value="gabungan" checked>Gabungan</label>
                </div>
              </div>
          </div>
          </fieldset>
        </div>
        <div class="col-md-3 col-xs-12 form-group">
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
        </div>
        <div class="col-md-3 col-xs-12 form-group">
          <fieldset class="field-fix">
          <legend class="leg-fix">Dibayar</legend>
            <div class="row">
              <div class="col-md-12">
                <div class="controls" style="margin-top: -5px;">
                  <label><input type="radio" name="bayar" value="belum"> Belum Dibayar Marketplace</label>
                  <label><input type="radio" name="bayar" value="bayar" checked> Telah Dibayar</label>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
<?php echo form_close();?>
  <div class="col-md-12">
    <?php if(empty($data)){?>
        <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
          <div class="row">
            <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
          </div>
        </div>
        <?php }else{?>
          <div class="row">
          <div class="col-md-12">
              <div class="table-responsive">
                <table id="table_report" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
                    <thead>
                      <tr style="background-color:#1c2d3f;color:white;">
                        <th style="text-align:center;">Gambar</th>
                        <th style="text-align:center;">Nama Project</th>
                        <th style="text-align:center;">Artikel</th>
                        <th style="text-align:center;">Status Barang</th>
                        <th style="text-align:center;">Retail</th>
                        <th style="text-align:center;">Sales Pairs</th>
                        <th style="text-align:center;">Retail + Sales Pairs</th>
                        <th style="text-align:center;">Bisnis</th>
                        <th style="text-align:center;">Divisi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $totalterjual = 0;           
                      $totalretail = 0;
                      $totalbisnis = 0;
                      $totaldivisi= 0; 
                      foreach($data as $y){
                        $odvmaster    = $y->odvM;
                        $retailmaster = $y->retailM;

                        // mencari margin dari data diatas
                        $margin = round(($retailmaster - $odvmaster) / $retailmaster * 100);

                        // memberi status barang berdasarkan hasil margin
                        if($margin >= 45){
                          //mencari ODV bisnis barang standart
                          $jenis = "Standart";
                          $odv_bisnis = 55 * $retailmaster / 100;
                          // hitung perolehan divisi dan bisnis
                          $bisnis   = $y->harga_fix * 45 / 100;
                          $divisi   = $y->harga_fix * 55 / 100;

                        }else if($margin >= 0 && $margin < 45){
                          //mencari ODV bisnis barang standart
                          $jenis = "Diskontinyu";
                          $odv_bisnis = ($retailmaster - $odvmaster) * 30 / 100 + $odvmaster;
                          // hitung perolehan divisi dan bisnis
                          $bisnis   = ($y->harga_fix - $odvmaster) * 70 / 100;
                          $divisi   = ($y->harga_fix - $odvmaster) * 30 / 100 + $odvmaster;
                        }
                        $totalterjual +=$y->total_terjual;
                        $totalretail  +=($y->harga_fix*$y->total_terjual);
                        $totalbisnis  +=($bisnis*$y->total_terjual);
                        $totaldivisi  +=($divisi*$y->total_terjual); 
                      ?>
                      <tr>
                        <td align="center"><img src="<?php echo $y->gambar?>" width="50"></td>
                        <td align="center"><?php echo $y->nama_produk?></td>
                        <td align="center"><?php echo $y->artikel?></td>
                        <td align="center"><?php echo $jenis?></td>
                        <td align="center">Rp. <?php echo number_format($y->harga_fix,0,".",".")?></td>
                        <td align="center"><?php echo $y->total_terjual?><br></td>
                        <td align="center">Rp. <?php echo number_format($y->total_terjual*$y->harga_fix,0,".",".")?></td>
                        <td align="center">Rp. <?php echo number_format($bisnis*$y->total_terjual,0,".",".")?></td>
                        <td align="center">Rp. <?php echo number_format($divisi*$y->total_terjual,0,".",".")?></td>
                      </tr>
                      <?php }?>
                    </tbody>
                    <tfoot>
                      <tr style="background-color:#34425a;color:white;">
                        <td align='left' colspan="4">Data ini belum difilter, status order : menunggu pembayaran, pembayaran diterima, dalam pengiriman, diterima, dan dibatalkan.</td>
                        <td align='center'><b>Total</b></td>
                        <td align='center'><b><?php echo $totalterjual?></b></td>
                        <td align='center'><b>Rp. <?php echo number_format($totalretail,0,".",".")?>.-</b></td>
                        <td align='center'><b>Rp. <?php echo number_format($totalbisnis,0,".",".")?>.-</b></td>
                        <td align='center'><b>Rp. <?php echo number_format($totaldivisi,0,".",".")?>.-</b></td>
                      </tr>
                    </tfoot>
                </table>
              </div>
            </div>
          </div>
        <?php }?>
  </div>
</div>
</div>