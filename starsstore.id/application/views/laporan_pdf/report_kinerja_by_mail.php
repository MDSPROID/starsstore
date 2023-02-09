<style type="text/css">
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
<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
    <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
      <div class="row">
        <div class="col-md-12">
          <?php $get_data_setting = for_header_front_end();?>
            <?php foreach($get_data_setting as $data):?>
              <center>
                <img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" style="margin-top:-10px;margin-bottom: -10px;" height="80">
              </center>
            <?php endforeach;?>
        </div>
        <div class="col-md-12">
          <center>
            <h3 style="margin-top: 0;">LAPORAN KERJA PROMOTION & E-COMMERCE</h3>
          </center><br>
          <?php if(count($g) == 0){ ?>
            <p style="text-align: center">Tidak ada progress kinerja hari ini!</p>
          <?php }else{ ?>
            <?php foreach($g as $y){ ?>
              <ul style="padding-left: 0;list-style: none;">
                <li>
                  <h4 style="margin-bottom:0;">
                    <span><b><?php echo $y->nama_depan?><b></span><br>
                    <span style="font-weight: 100;"><?php echo $y->deskripsi?></span>
                  </h4>
                </li>
              </ul>
          <?php }}?>
        </div><br>
        <p style="font-weight: 100;">Pesan ini dikirim otomatis oleh sistem, harap tidak membalas email ini.<br>Best Regard,<br><br><br>Stars E-commerce</p>
      </div>
    </div>
  </div>
</div>
</div>