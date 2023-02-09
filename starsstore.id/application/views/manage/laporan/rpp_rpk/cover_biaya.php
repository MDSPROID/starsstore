<html>
<head>
<title>Laporan Barang Terjual</title>
<script type="text/javascript">var baseURL = '<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery/JQuery.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/clipboard.js');?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $(".btn-input-biaya").click(function(){
      var baseURL = window.location.href.match(/^.*\//);
      var thb = $(".total_harga_barang").val();
      var bp = $(".biaya_pajak").val();
      var pr = $(".periode").val();
      //simpan menjadi penjualan NETT
      $.ajax({
          url : baseURL + "trueaccon2194/rpp_rpk/input_biaya/?thb="+thb+"&bp="+bp+"&pr="+pr,
          type: "GET",
          success: function(data)
          {
             var total = parseInt(thb) - parseInt(bp);
             $(".penjualan_net").text(total);
             alert("Data berhasil ditambahkan, silahkan reload halaman");
             window.location.href = baseURL + "trueaccon2194/rpp_rpk";
             
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error');
          }
      });
    })
  });
</script>
<script type="text/javascript" src="<?php// echo base_url('assets/manage/js/sistem_adm.js');?>"></script>
<style type="text/css">
/*************************** END Frontend ************************************/
@media screen{
  .cover_count{
    display: block;
  }
  .cover_laporan{
    display: block;
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
</style>
</head>
<body>
<label style="font-size: 20px;float: right;color: black;border:1px solid black;" class="label label-default print-btn" onclick="window.print()">Cetak</label>

<div style="position: absolute;top: 375px;padding: 118px 118px 118px 135px;width: 450px;" class="cover_count">
  <table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr style="border:none;">
            <th colspan="6" style="border:none;"></th>
        </tr>
    </thead>
    <tbody>        
        <tr style="border:none;">
          <td colspan="3" style="border:none;padding: 0;"><h4 style="margin-top: 0;margin-bottom: 0;"><b>TOTAL BIAYA :</b></h4></td>
          <td colspan="3" style="text-align: right;border: none;padding: 0;"><h4 style="margin-top: 0;margin-bottom: 0;"><b>Rp. <?php echo number_format($periode['biaya_marketplace'],0,".",".");?></b></h4></td>
        </tr>
    </tbody>
    </table>
    <h4 style="font-size: 12px;margin-top:10;"><i>*Kami menggunakan penanda stabilo untuk memudahkan div. keuangan</i></h4>
    <h2 style="border:2px solid black;text-align: center;margin-top: 40px;">Lampiran 2</h2>
</div>
<div style="margin-top:0px !important;margin-left: 20px;margin-bottom: 300px;" class="cover_laporan">
    <img src="<?php echo base_url('assets/images/c_biaya.jpg')?>" width="680">
</div>
</body>
</html>