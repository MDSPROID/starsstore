<div class="page-title">
  <h3>Performa Banner & Slider
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
      <li><a href="<?php echo base_url('trueaccon2194/media_promosi')?>">Banner & Slider</a></li>
      <li class="active">Performa Banner & Slider</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br><br><br>
      </div>
      <div class="col-md-12 col-xs-12">
        <div id="form-banner1" style="background-color: white;padding: 20;margin-bottom: 30px;">
          <div id="mygraph2"></div>
        </div>
      </div>
      <div class="col-md-4 col-xs-12"> 
      <?php foreach ($slide_preview as $d){?>
        <div id="form-banner1" style="background-color: white;padding: 20;margin-bottom: 30px;">
            <label class="label" style="padding:0;font-size: 16px;color:#4E5E6A;">Informasi Banner</label> 
            <?php echo br(2);?>
            <?php 
              if($d->jenis == "gambar"){
                echo "<img src='$d->banner' class='img-resposive img-thumbnail' width='150'>";
              }else if($d->jenis == "video"){
                echo "<iframe id='video' width='230' height='150' src='https://www.youtube.com/embed/$d->banner' frameborder='0' allowfullscreen></iframe>";
              }
            ?>
            <?php echo br(2);?>
            <ul class="list-unstyled">
              <li><b style="padding-right: 47px;">Posisi </b>: <?php echo $d->posisi;?></li>
              <li><b style="padding-right: 4px;">Jenis Banner </b>: <?php echo $d->jenis;?></li>
              <li><b style="padding-right: 59px;">Link </b>: <?php echo $d->link;?></li>
              <li><b>Tanggal Mulai </b>: <?php echo date('d F Y', strtotime($d->tgl_mulai));?></li>
              <li><b>Tanggal Akhir </b>: <?php echo date('d F Y', strtotime($d->tgl_akhir));?></li>
              <li><b style="padding-right: 46px;">Status</b> : <?php echo $d->status_banner;?></li>
            </ul>
        </div>
      <?php }?>
      </div>
      <div class="col-md-4 col-xs-12">
          <div class="col-xs-12" id="form-banner1" style="background-color: white;padding: 20;margin-bottom: 30px;">
            <label class="label" style="padding:0;font-size: 16px;color:#4E5E6A;">Total Klik Iklan </label> 
            <?php echo br(2);?>
            <div class="col-md-6 col-xs-6 text-center" style="padding-right: 0;padding-left: 0;">
            <label class="text-center" style="padding: 5px;">
              <b><span class="text-counter">Total Klik</span></b> 
              <?php 
                if($total_counter_slide == 0){
                  echo "0";
                }else{
              ?>
              <div class="font-c100 c100 center p<?php echo count($total_counter_slide);?> green">
                <span><b><?php echo count($total_counter_slide);?></b></span>
                <div class="slice">
                  <div class="bar"></div>
                  <div class="fill"></div>
                </div>
              </div>
              <?php }?>
            </label></div>
            <div class="col-md-6 col-xs-6 text-center" style="padding-right: 0;padding-left: 0;">
            <label class="text-center" style="padding: 5px;">
              <b>Hari ini</b> 
              <?php 
                if($total_counter_slide_per_day == 0){
                  echo "0";
                }else{
              ?>
              <div class="font-c100 c100 center p<?php echo count($total_counter_slide_per_day);?> orange">
                <span><b><?php echo count($total_counter_slide_per_day);?></b></span>
                <div class="slice">
                  <div class="bar"></div>
                  <div class="fill"></div>
                </div>
              </div>
              <?php }?>
            </label></div>
            <div class="col-md-6 col-xs-6 text-center" style="padding-right: 0;padding-left: 0;">
            <label class="text-center" style="padding: 5px;">
              <b>Minggu ini</b> 
              <?php 
                if($total_counter_slide_per_week == 0){
                  echo "0";
                }else{
              ?>
               <div class="font-c100 c100 center p<?php echo count($total_counter_slide_per_week);?> orange">
                <span><b><?php echo count($total_counter_slide_per_week);?></b></span>
                <div class="slice">
                  <div class="bar"></div>
                  <div class="fill"></div>
                </div>
              </div>
              <?php }?>
            </label></div>
            <div class="col-md-6 col-xs-6 text-center" style="padding-right: 0;padding-left: 0;">
            <label class="text-center" style="padding: 5px;">
              <b>Bulan ini</b> 
              <?php 
                if($total_counter_slide_per_month == 0){
                  echo "0";
                }else{
              ?>
              <div class="font-c100 c100 center p<?php echo count($total_counter_slide_per_month);?> orange">
                <span><b><?php echo count($total_counter_slide_per_month);?></b></span>
                <div class="slice">
                  <div class="bar"></div>
                  <div class="fill"></div>
                </div>
              </div>
              <?php  }?>
            </label>
           </div>            
          </div>
        </div>
        <div class="col-md-4 col-xs-12" style="margin-bottom: 30px;">
          <div class="col-xs-12" id="form-banner1" style="background-color: white;padding: 20;">
            <label class="label" style="padding:0;font-size: 16px;color:#4E5E6A;">Data Pengunjung</label> 
            <?php echo br(2);?>
            <div class="panel" style="border-top:3px solid #434348;border-left:1px solid #ccc;border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding-top:0px;">
              <div style="padding:15px;padding-bottom:30px;background-color:white;">
                <div class="panel-body scroll-menu" style="margin-top:0px;height:200px;padding-top:5px;">
                  <?php 
                    if(count($total_counter_slide) == 0){
                      echo "<div class='text-center' style='margin-top:20px;'><span style='font-size:100px;color:#ededed;' class='glyphicon glyphicon-search'></span><div class='col-xs-12'>Tidak Ada Data</div></div>";
                    }else{
                      foreach($total_counter_slide as $datas){?>
                    <ul style="margin-left: -35px;">
                    <li>
                  <h5>
                    <b>
                      <i style="font-style:normal;"><?php echo $datas->ip; ?></i><br />
                      <i style="font-style:normal;"><?php echo $datas->device; ?></i><br />
                    </b> 
                    <i style="font-size: 12px;"><?php echo $datas->tgl; ?></i>
                  </h5>
                  </li>
                  </ul>
                  <?php }}?>
                </div>
              </div>
            </div>
          </div>
        </div>
  </div>
</div>
<?php
   foreach($slide_periode as $gf){   
    $month = array();
   	$month = $gf->bulan;
?>
<script>
    var chart1; 
    $(document).ready(function() {
          chart1 = new Highcharts.Chart({
             chart: {
                renderTo: 'mygraph2',
                type: 'column',
                options3d: {
              enabled: true,
              alpha: 0,
              beta: 20
                  },
             },   
             title: {
                text: 'Laporan Performance Banner Periode'
             },
             xAxis: {
                categories: ['Bulan']
             },
             yAxis: {
                title: {
                   text: 'Jumlah Klik Perbulan'
                }
             },
                  series:             
                [
                    <?php
                      foreach($slide_periode as $grafik){   

                    ?>
                        {
                          name: '<?php echo $grafik->bulan; ?>',
                          data: [<?php echo $grafik->total_klik_per_bulan; ?>]
                        },
                        <?php }?>
                    ]
          });
       });  
</script>
<?php }?>