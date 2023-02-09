<style type="text/css">
  @media print {
    .print{
      display: none;
    }
  }
  body {
  font-family: Futura, "Trebuchet MS", Arial, sans-serif;
  line-height: 1.42857143;
  margin: 0;
}
table {
  border-spacing: 0;
  border-collapse: collapse;
}
td,
th {
  padding: 0;
}
.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}
</style>
<script type="text/javascript">
  window.print();
</script>
<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
    <div class="tab-content" style="padding: 10px;">
      <div class="row">
        <div class="col-md-12">
          <label style="border:1px solid black;padding: 10px;font-size: 16px;float:right;" class="print" onclick="window.print();">Cetak</label>
          <?php $get_data_setting = for_header_front_end();?>
            <?php foreach($get_data_setting as $data):?>
              <img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" style="margin-top:-10px;margin-bottom: 20px;" height="50">
            <?php endforeach;?>
        </div>
        <div class="col-md-12">
          <h3 style="margin-bottom: 0px;margin-top: 0;">PT. STARS INTERNASIONAL</h3>
          <h4 style="margin-top:0;margin-bottom: 0px;">Jl. Rungkut Asri Utara VI no 2. Surabaya</h4>
          <h4 style="margin-top:0;margin-bottom: 0px;">Telepon : +62 31-8792478</h4>
        </div>
        <?php if(empty($standart)){?>
          <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
        <?php }else{?>
          <div class="col-md-12">
          <div class="row">
            <div class="col-md-4">
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
              <h5 style="margin-top:15px;margin-bottom: 0px;margin-top: 10;"><span style="margin-right: 40px;">Tanggal</span>: <?php echo date('d F Y', strtotime($tgl1))?> - <?php echo date('d F Y', strtotime($tgl2))?></h5>
              <h5 style="margin-top: 0;margin-bottom: 0px;"><span style="margin-right: 47px;margin-bottom: 0;">Status Pesanan</span> : <?php echo $stat?></h5> 
              <h5 style="margin-top: 0;"><span style="margin-right: 47px;margin-bottom: 0;">Status Bayar</span> : <?php echo $bayar?></h5> 
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-12">
              <?php// if(empty($standart)){?>
              <?php //}else{?>
              <h3 style="margin-top: 0;">Rasio Perolehan</h3>
              <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="border:1px solid #000;">
                    <thead>
                      <tr style="color:white;">
                        <th style="text-align:center;border:1px solid #000;color:#000;font-size: 12px;">Gambar</th>
                        <th style="text-align:center;border:1px solid #000;color:#000;font-size: 12px;">Nama Project</th>
                        <th style="text-align:center;border:1px solid #000;color:#000;font-size: 12px;">Artikel</th>
                        <th style="text-align:center;border:1px solid #000;color:#000;font-size: 12px;">Status Barang</th>
                        <th style="text-align:center;border:1px solid #000;color:#000;font-size: 12px;">Retail</th>
                        <th style="text-align:center;border:1px solid #000;color:#000;font-size: 12px;">Sales Pairs</th>
                        <th style="text-align:center;border:1px solid #000;color:#000;font-size: 12px;">Retail + Sales Pairs</th>
                        <th style="text-align:center;border:1px solid #000;color:#000;font-size: 12px;display: none;">Bisnis</th>
                        <th style="text-align:center;border:1px solid #000;color:#000;font-size: 12px;display: none;">Divisi</th>
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
                        //}
                        //if($margin >= 45){
                      ?>
                      <tr>
                        <td align="center" style="border:1px solid #000;"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="<?php echo $y->gambar?>" width="40"></td>
                        <td align="center" style="border:1px solid #000;font-size: 12px;"><?php echo $y->nama_produk?></td>
                        <td align="center" style="border:1px solid #000;font-size: 12px;"><?php echo $y->artikel?></td>
                        <td align="center" style="border:1px solid #000;font-size: 12px;"><?php// echo $jenis?></td>
                        <td align="center" style="border:1px solid #000;font-size: 12px;">Rp. <?php echo number_format($harga_jual,0,".",".")?></td>
                        <td align="center" style="border:1px solid #000;font-size: 12px;"><?php echo $y->total_terjual?><br></td>
                        <td align="center" style="border:1px solid #000;font-size: 12px;">Rp. <?php echo number_format($harga_jual,0,".",".")?></td>
                        <td align="center" style="border:1px solid #000;font-size: 12px;display: none;">Rp. <?php// echo number_format($bisnis*$y->total_terjual,0,".",".")?></td>
                        <td align="center" style="border:1px solid #000;font-size: 12px;display: none;">Rp. <?php// echo number_format($divisi*$y->total_terjual,0,".",".")?></td>
                      </tr>
                      <?php }?>
                    </tbody>
                    <tbody>
                      <tr style="color:white;">
                        <td align='left' colspan="4" style="border:1px solid #000;"></td>
                        <td align='center' style="border:1px solid #000;color:#000;font-size: 12px;"><b>Total</b></td>
                        <td align='center' style="border:1px solid #000;color:#000;font-size: 12px;"><b><?php echo $totalterjual?></b></td>
                        <td align='center' style="border:1px solid #000;color:#000;font-size: 12px;"><b>Rp. <?php echo number_format($totalretail,0,".",".")?>.-</b></td>
                        <td align='center' style="border:1px solid #000;color:#000;font-size: 12px;display: none;"><b>Rp. <?php //echo number_format($totalbisnis,0,".",".")?>.-</b></td>
                        <td align='center' style="border:1px solid #000;color:#000;font-size: 12px;display: none;"><b>Rp. <?php //echo number_format($totaldivisi,0,".",".")?>.-</b></td>
                      </tr>
                    </tbody>
                </table>
              </div>
              <?php echo br(2)?>
            </div>
          </div>
          </div>
        <?php }?>
      </div>
    </div>
  </div>
</div>
</div>