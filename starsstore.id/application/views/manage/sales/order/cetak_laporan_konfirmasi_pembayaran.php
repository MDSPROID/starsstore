<html>

<head>

<title>Laporan Bukti Pembayaran</title>

<script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery/JQuery.min.js');?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/manage/js/clipboard.js');?>"></script>

<script type="text/javascript" src="<?php// echo base_url('assets/manage/js/sistem_adm.js');?>"></script>

<style type="text/css">

/*************************** END Frontend ************************************/
 
@media screen{

  .cover_count{

    display: none;

  }

  .cover_laporan{

    display: none;

  }

}

@media print {

  *{

    -webkit-print-color-adjust:exact; /*Chrome*/

    color-adjust: exact !important;  /*Firefox*/

  }

  .print-btn{

    display: none !important;

  }

  .cover_laporan{

    display: block;

  }

  .cover_count{

    display: block;

  }

}

table {

  border-spacing: 0;

  

}

body {

  -webkit-print-color-adjust:exact;

  color-adjust: exact !important;  /*Firefox*/

  font-family: Arial, sans-serif;

  font-size: 14px;

  line-height: 1.42857143;

  color: #333;

  background-color: white;

}

th {

  text-align: left;

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

.label.label-success {

    background: #22BAA0;

}

.label-success {

    background-color: #19c323;

}

.label {

    margin-right: 10px;

    display: inline;

    padding: .2em .6em .0em;

    font-size: 75%;

    font-weight: bold;

    line-height: 1;

    color: #fff;

    text-align: center;

    white-space: nowrap;

    vertical-align: baseline;

    border-radius: .25em;

}

label {

    font-size: 13px;

    font-weight: 400;

}

label {

    display: inline-block;

    max-width: 100%;

    margin-bottom: 5px;

    font-weight: bold;

}

.label.label-warning {

    background: #f6d433;

}

.label.label-danger {

    background: #f25656;

}

.nav-tabs {

}

.nav {

    padding-left: 0;

    margin-bottom: 0;

    list-style: none;

}



ul, ol {

    margin-top: 0;

    margin-bottom: 10px;

}

.nav-tabs > li {

    margin-bottom: 0px;

}

.nav > li {

    position: relative;

    display: block;

}

.active {

}

.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {

    color: #555;

    cursor: default;

    background-color: #fff;

    border-bottom-color: #fff;

}

.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {

    text-decoration: none;

    color: #595959;

    font-weight: bold;

    cursor: default;

    background-color: white;

    border: 1px solid #ddd;

    border-bottom-color: transparent;

}

.nav-tabs > li > a {

    background-color: transparent;

}

.nav-tabs>li>a {

    border-radius: 0!important;

    color: #777;

    border-bottom: 1px solid #DDD;

}

.nav-tabs > li > a {

    background-color: #e6e6e6;

    line-height: 1.42857143;

    border: 1px solid transparent;

}

.nav > li > a {

    position: relative;

    display: block;

    padding: 10px 15px;

}

.list-inline {

    padding-left: 0;

    margin-left: -5px;

    list-style: none;

}

.list-inline > li {

    display: inline-block;

    padding-right: 5px;

    padding-left: 5px;

}

</style>

</head>

<body>

<label style="font-size: 20px;float: right;color: black;border:1px solid black;" class="label label-default print-btn" onclick="window.print()">Cetak</label>



<div style="position: absolute;top: 430px;padding: 118px 118px 118px 195px;width: 425px;" class="cover_count">

  <table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">

    <thead>

        <tr style="border:none;">

            <th colspan="6" style="border:none;"></th>

        </tr>

    </thead>

    <tbody>        

        <tr style="border:none;">

          <td colspan="3" style="border:none;padding: 0;"><h4 style="margin-top: 0;margin-bottom: 0;"><b>TOTAL RUPIAH :</b></h4></td>

          <td colspan="3" style="text-align: right;border: none;padding: 0;"><h4 style="margin-top: 0;margin-bottom: 0;"><b>Rp. <?php echo number_format($jumlahtransfer,0,".",".");?></b></h4></td>

        </tr>

    </tbody>

    </table>

    <h4 style="font-size: 12px;margin-top:10;"><i>*Transfer akan diteruskan ke rekening stars BNI 1100020050 A.n I Gede Meindra Yasa Satria (online)</i></h4>

    <h2 style="border:2px solid black;text-align: center;margin-top: 40px;">Lampiran 3</h2>

</div>

<div style="margin-top:0px !important;margin-left: 20px;margin-bottom: 300px;" class="cover_laporan">

    <img src="<?php echo base_url('assets/images/c_bukti_transfer.jpg')?>" width="780">

</div>

<div id="main-wrapper">

<div class="row">

  <div class="col-md-12">

    <div class="tab-content">

      <div class="row">

        <div class="col-md-12">

          <div class="row">

            <?php foreach($hasil as $kl): ?>

            <div class="col-md-12 col-xs-12">

              <h2>#<?php echo $kl->id_pesanan?> (<?php echo $kl->buy_in?>)</h2>

              <table>

                <tbody>

                    <tr style="border:none;">

                        <th style="text-align: left;">Nama Customer </th>

                        <td>: <?php echo $kl->nama_lengkap?></td>

                    </tr>
                    <?php 
                      if($kl->email == ""){
                        $m = $kl->no_telp;
                      }else{
                        $m = $kl->email;
                      }
                    ?>

                    <tr style="border:none;">

                        <th style="text-align: left;">Email / Telepon</th>

                        <td>: <?php echo $m?></td>

                    </tr>

                    <tr style="border:none;display: none;">

                        <th style="text-align: left;">Tanggal Konfirmasi </th>

                        <td>: <?php echo date('d F Y H:i:s', strtotime($kl->tgl_input_data));?></td>

                    </tr>

                    <tr style="border:none;display: none;">

                        <th style="text-align: left;">Bank Transfer </th>

                        <td>: <?php echo $kl->bank?></td>

                    </tr>

                    <tr style="border:none;">

                        <th style="text-align: left;">Nominal Transfer</th>

                        <td>: Rp. <?php echo number_format($kl->total_belanja,0,".",".");?></td>

                    </tr>

                </tbody>

                </table>

            </div>

            <div class="col-md-12 col-xs-12" style="margin-top:20px;margin-bottom: 400px;">

              <ul class="nav nav-tabs" style="border-bottom: 1px solid #c9c9c9;">

                <li class="active"><a data-toggle="tab" href="#detail">Detail Bukti</a></li>

              </ul>

              <div class="row" style="height: 850px;">

                <div class="col-md-12 col-xs-12">

                  <h4 style="margin-left: 15px;margin-bottom: 10px;">Catatan :</h4>

                  <p style="margin-left: 15px;">

                  <?php 

                      if($kl->catatan == ""){ 

                          echo "-";

                      }else{

                          echo $kl->catatan;

                      }

                  ?>

                  </p>

                  <ul class="list-inline">

                  <?php 

                  $b = $kl->identity_pembayaran;

                  $detailbukti = $this->order_adm->getkonfirmasi_bukti($b);

                  foreach($detailbukti as $datax):?>

                    <li><img src="<?php echo $datax->gambar?>" class="img-responsive" style="max-height: 500px;"></li>

                  <?php endforeach;?>

                  </ul>

                </div>

              </div>

            </div>

          <?php endforeach;?>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

</div>

</body>

</html>