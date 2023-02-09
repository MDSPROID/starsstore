<script type="text/javascript">
  $(document).ready( function () { 
    $("#table_report").DataTable();       
    $("#table_report2").DataTable();   
  });
</script>
<div class="page-title">
  <h3>Rasio perolehan
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
      <li>Rasio Perolehan</li>
      <li class="active">Cetak Laporan Order</li>
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
    <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
      <div class="row">
        <?php if(empty($standart)){?> <?php //&& empty($diskontinyu)){?>
          <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
        <?php }else{?>
          <div class="col-md-12">
          <div class="row">
            <div class="col-md-8">
              <?php
                  if($status == "2hd8jPl613!2_^5"){
                    $stat = "<label class='label label-warning'>Menunggu Pembayaran</label>";
                  }else if($status == "*^56t38H53gbb^%$0-_-"){
                    $stat = "<label class='label label-primary'>Pembayaran Diterima</label>";
                  }else if($status == "Uywy%u3bShi)payDhal"){
                    $stat = "<label class='label label-primary'>Dalam Pengiriman</label>";
                  }else if($status == "ScUuses8625(62427^#&9531(73"){
                    $stat = "<label class='label label-success'>Diterima</label>";
                  }else if($status == "batal"){
                    $stat = "<label class='label label-danger'>Dibatalkan</label>";
                  }else{
                    $stat = "<label class='label label-default'>Semua</label>";
                  }
                ?>
              <h4><span style="margin-right: 46px;">Tanggal</span>: <?php echo date('d F Y',strtotime($tgl1));?> - <?php echo date('d F Y',strtotime($tgl2));?></h4>
              <h4><span style="margin-right: 10px;">Status Pesanan</span> : <?php echo $stat?></h4>
              <h4><span style="margin-right: 10px;">Status Bayar</span> : <?php echo $bayar?></h4> 
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-12">
              <?php //if(empty($standart)){?>
              <?php //}else{?>
              <h3>Rasio Perolehan</h3>
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
                        <th style="text-align:center;display: none;">Bisnis</th>
                        <th style="text-align:center;display: none;">Divisi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php                     
                      $totalterjual = 0;           
                      $totalretail = 0;
                      $totalbisnis = 0;
                      $totaldivisi= 0; 
                      $bisnis = 0;
                      $divisi = 0;
                      foreach($standart as $y){
                        //$odvmaster    = $y->odvM;
                        //$retailmaster = $y->retailM;

                         // jika ada pengurangan dari biaya marketplace
                        if($y->buy_in == "lazada"){
                          $biaya_lazada = $y->harga_fix * 1.804 / 100;
                          $vat_lazada   = $y->harga_fix * 0.164 / 100;
                          //$vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
                        }else{
                          $biaya_lazada = 0;
                          $vat_lazada = 0;
                          $vat_pencairan = 0;
                        }
                        $harga_jual =($y->harga_fix - $biaya_lazada - $vat_lazada) * $y->total_terjual;// - $vat_pencairan;

                        // mencari margin dari data diatas
                        //$margin = round(($retailmaster - $odvmaster) / $retailmaster * 100);

                        // memberi status barang berdasarkan hasil margin
                        //if($margin >= 45){
                          //mencari ODV bisnis barang standart
                          //$jenis = "Standart";
                          //$odv_bisnis = 55 * $retailmaster / 100;
                          // hitung perolehan divisi dan bisnis
                          //$bisnis   = $harga_jual * 45 / 100;
                          //$divisi   = $harga_jual * 55 / 100;

                          $totalterjual +=$y->total_terjual;
                          $totalretail  +=$harga_jual;
                          //$totalbisnis  +=($bisnis*$y->total_terjual);
                          //$totaldivisi  +=($divisi*$y->total_terjual); 
                       // }
                        //if($margin >= 45){
                      ?>
                      <tr>
                        <td align="center"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="<?php echo $y->gambar?>" width="50"></td>
                        <td align="center"><?php echo $y->nama_produk?></td>
                        <td align="center"><?php echo $y->artikel?></td>
                        <td align="center"><?php// echo $jenis?></td>
                        <td align="center">Rp. <?php echo number_format($harga_jual,0,".",".")?></td>
                        <td align="center"><?php echo $y->total_terjual?><br></td>
                        <td align="center">Rp. <?php echo number_format($harga_jual,0,".",".")?></td>
                        <td align="center" style="display: none;">Rp. <?php //echo number_format($bisnis*$y->total_terjual,0,".",".")?></td>
                        <td align="center" style="display: none;">Rp. <?php// echo number_format($divisi*$y->total_terjual,0,".",".")?></td>
                      </tr>
                      <?php }?>
                    </tbody>
                    <tfoot>
                      <tr style="background-color:#34425a;color:white;">
                        <td align='left' colspan="4"></td>
                        <td align='center'><b>Total</b></td>
                        <td align='center'><b><?php echo $totalterjual?></b></td>
                        <td align='center'><b>Rp. <?php echo number_format($totalretail,0,".",".")?>.-</b></td>
                        <td align='center' style="display: none;"><b>Rp. <?php //echo number_format($totalbisnis,0,".",".")?>.-</b></td>
                        <td align='center' style="display: none;"><b>Rp. <?php //echo number_format($totaldivisi,0,".",".")?>.-</b></td>
                      </tr>
                    </tfoot>
                </table>
              </div>
              <?php echo br(2)?>
              <?php// }?>              
            </div>
          </div>
          </div>
        <?php }?>
      </div>
    </div>
  </div>
</div>
</div>