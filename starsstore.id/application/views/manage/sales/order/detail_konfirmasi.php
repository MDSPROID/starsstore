<style type="text/css">
    @media print {
      img{
        display: block;
      }
      .print{
        display: none;
      }
      .navbar {
        display: none;
      }
      .label {
        border: 1px solid red;
      }
      .disc{
        color: red !important;
        font-weight: bold;
      }
      .table {
        border-collapse: collapse !important; 
      }
      .table td,
      .table th {
        background-color: grey !important;
      }
      .table-bordered th,
      .table-bordered td {
        border: 1px solid black !important;
      }
      .row{
        padding-right: -15px;
        padding-left: -15px;
      }
      .lbl{
        background-color: #f5f5f5;
      }
      .col-md-2{
        width: 16.66666667%; 
      }
      .col-md-10{
        width: 83.33333333%;
      }
    }

    td, th {
        padding: 5px;
    }
    .njr{
        padding: 8px;
    }
    .nav-tabs > li > a{
        background-color: transparent;
    }
    .tab-content {
    padding: 0px;
    }
</style>
<div class="page-title">
  <h3>Detail Konfirmasi Pembayaran Customer
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
      <li><a href="<?php echo base_url('trueaccon2194/order/')?>">Order</a></li>
      <li class="active">Detail Konfirmasi Pembayaran Customer</li>
    </ol>
  </div>
</div>
<?php foreach($detailkonfirmasi as $kl): ?>
<div id="main-wrapper">
    <div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
        <br>
    </div>
    <div class="row-inv">
        <div class="col-md-12 m-t-lg">
        <h4 class="pd pan hin"><i class="glyphicon glyphicon-list-alt"></i> Detail Invoice #<?php echo $kl->id_pesanan?> (<?php echo $kl->buy_in?>) <label style="font-size: 12px;" class="pull-right label label-default print" onclick="printDiv('printableArea')"><i class="glyphicon glyphicon-print"></i> Cetak</label></h4>
            <div class="panel panel-white">
                <div class="panel-bodyty">
                    <div class="post-inv" id="printableArea">                                        
                        <div class="row">
                            <div class="col-md-12 col-xs-12" style="margin-bottom: 30px;">
                                <?php $get_data_setting = for_header_front_end();?>
                                <?php foreach($get_data_setting as $data):?>
                                    <img style="margin-top: 5px;" src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" width="100" class="pull-right">
                                <?php endforeach;?>
                                <h2>#<?php echo $kl->id_pesanan?> (<?php echo $kl->buy_in?>)</h2>
                                <table>
                                <tbody>
                                    <tr>
                                        <th>Nama Customer </th>
                                        <td>: <?php echo $kl->nama_lengkap?></td>
                                    </tr>
                                    <?php 
                                      if($kl->email == ""){
                                        $m = $kl->no_telp;
                                      }else{
                                        $m = $kl->email;
                                      }
                                    ?>
                                    <tr>
                                        <th>Email / Telepon</th>
                                        <td>: <?php echo $m?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Konfirmasi </th>
                                        <td>: <?php echo date('d F Y H:i:s', strtotime($kl->tgl_input_data));?></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <th>Bank Transfer </th>
                                        <td>: <?php echo $kl->bank?></td>
                                    </tr>
                                    <tr>
                                        <th>Nominal Transfer</th>
                                        <td>: Rp. <?php echo number_format($kl->total_belanja,0,".",".");?></td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <ul class="nav nav-tabs" style="    border-bottom: 1px solid #c9c9c9;">
                                  <li class="active"><a data-toggle="tab" href="#detail">Detail Bukti</a></li>
                                </ul>
                                <div class="row">
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
                                        <?php foreach($detailbukti as $datax):?>
                                          <li><img src="<?php echo $datax->gambar?>" class="img-responsive" style="max-height: 500px;"></li>
                                        <?php endforeach;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>                                        
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        </div>
    </div>
  </div>
</div>