<?php
require_once 'dgfhjqyker3yruifdcx23/CekMt.php';
//$this->load->library('mtransc');
    $config = [
        'credential' => [
            'username' => 'achammad2102',
            'password' => 'danny2102',
        ],
        'nomor_rekening' => '0423596591',
        'range' => [
            'tgl_akhir' => date('d-M-Y',strtotime($tgl2)),
            'tgl_awal' => date('d-M-Y',strtotime($tgl1))
        ],
];
        
    $bni = new CekMt($config);
    $getdata = $bni->toArray();    
?>
<script type="text/javascript">
  $(document).ready( function () {
      $("#table_produk").DataTable();
  });
</script>
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
</style>
<div class="col-md-12" style="margin-bottom: 30px;">
<label style="font-size: 20px;float: right;color: black;border:1px solid black;" class="label label-default print-btn" onclick="window.print()">Cetak</label>
<?php $get_data_setting = for_header_front_end();?>
<?php foreach($get_data_setting as $data):?>
    <img style="margin-top: 5px;" src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" width="100" class="pull-right">
<?php endforeach;?>
	<h4 style="margin-bottom: 0;"><span style="margin-right: 12px;">Nomor Rekening</span>: BNI 0423596591 A.n Mochammad Danny Setyawan</h4>
	<h4 style="margin-top: 5px;"><span style="margin-right: 16px;">Periode Tanggal</span>: <?php echo date('d F Y',strtotime($tgl1));?> - <?php echo date('d F Y',strtotime($tgl2));?></h4>
</div>
<div class="col-md-12 table-responsive">
<table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th style="text-align:center;border:1px solid #000;">Tanggal</th>
            <th style="text-align:center;border:1px solid #000;">Keterangan</th>
            <th style="text-align:center;border:1px solid #000;">Jenis Transaksi</th>
            <th style="text-align:center;border:1px solid #000;">Nominal</th>
            <th style="text-align:center;border:1px solid #000;">Saldo</th>
        </tr>
    </thead>
    <tbody>
    	<?php foreach($getdata as $key){?>
    	<tr>
    		<td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $key[0]?></td>
    		<td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $key[1]?></td>
    		<td style="text-align:center;border:1px solid #000;"><?php if($key[2] == "Cr"){echo "<label class='label label-success'>Cr</label>";}else if($key[2]=="Db"){echo "<label class='label label-danger'>Db</label>";}else{echo "<label class='label label-primary'>".$key[2]."</label>";}?></td>
    		<td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $key[3]?></td>
    		<td style="text-align:center;border:1px solid #000;font-size: 12px;"><?php echo $key[4]?></td>
    	</tr>
    	<?php }?>
    </tbody>
</table>
</div>