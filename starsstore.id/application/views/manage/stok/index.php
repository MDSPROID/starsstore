<div class="page-title">
  <h3>Stok
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
      <li class="active">Stok</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-4 col-xs-12"> 
    <div class="col-md-10 col-xs-9" style="background-color:#f22a1b;color:white;padding-bottom: 10px;">
      <h4>STOK KRITIS</h4>
      <h1 style="margin-top:-5px;"> 
      <?php
        $total = count($critical);
        if($total == 0){
          echo "0";
        }else{
          echo $total;
        }
      ?></h1>
    </div>
    <div class="col-md-2 col-xs-3 text-center" style="background-color:#cb271b;height:83px;">
      <i style="color:white;font-size:30px;padding-top:25px;"class="glyphicon glyphicon-exclamation-sign"></i>
  </div>
</div>
<div class="col-md-4 col-xs-12"> 
    <div class="col-md-10 col-xs-9" style="background-color:#ffc107;color:white;padding-bottom: 10px;">
      <h4>STOK CUKUP</h4>
      <h1 style="margin-top:-5px;"><?php
        $total = count($warning);
        if($total == 0){
          echo "0";
        }else{
          echo $total;
        }
      ?></h1>
    </div>
    <div class="col-md-2 col-xs-3 text-center" style="background-color:#e8b316;height:83px;">
      <i style="color:white;font-size:30px;padding-top:25px;"class="glyphicon glyphicon-info-sign"></i>
    </div>
</div>
<div class="col-md-4 col-xs-12" style="margin-bottom:30px;"> 
    <div class="col-md-10 col-xs-9" style="background-color:#4caf50;color:white;padding-bottom: 10px;">
      <h4>STOK BAIK</h4>
      <h1 style="margin-top:-5px;"><?php
        $total = count($good);
        if($total == 0){
          echo "0";
        }else{
          echo $total;
        }
      ?></h1>
    </div>
    <div class="col-md-2 col-xs-3 text-center" style="background-color:#418544;height:83px;">
      <i style="color:white;font-size:30px;padding-top:25px;"class="glyphicon glyphicon-ok-sign"></i>
    </div>
</div>

<div class="col-md-8 col-xs-12 hidden-xs"> 
    <div class="panel panel-primary" style="border-color:#cfcfcf;box-shadow:0px 0px 8px 0px #bababa;">
      <div class="panel-heading" style="background-color:#ffffff;border-color:#f22a1b;font-size:18px;color:#f22a1b;border:none;"><b>STOK KRITIS</b> <i class="glyphicon glyphicon-option-vertical pull-right"></i></div>
      <div class="panel-body">
        <div id ="mygraph2"></div>
      </div>
  </div>
</div>
<div class="col-md-2 col-xs-6"> 
  <div class="panel" style="border-top:3px solid #ffc107;padding-top:10px;box-shadow:0px 0px 8px 0px #bababa;background-color:white;">
      <div class="panel-heading text-center"><b>TOTAL STOK MINIMUM</b></div>
      <div class="panel-body" style="padding:10 0;">
        <div class="c100 center p<?php $totalw = count($warning); $totalc = count($critical); echo $totalw + $totalc;?> orange">
          <span><b><?php $totalw = count($warning); $totalc = count($critical); echo $totalw + $totalc;?></b></span>
          <div class="slice">
            <div class="bar"></div>
            <div class="fill"></div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="col-md-2 col-xs-6"> 
  <div class="panel" style="margin-bottom: 30px;border-top:3px solid #4caf50;padding-top:10px;box-shadow:0px 0px 8px 0px #bababa;background-color:white;">
      <div class="panel-heading text-center"><b>TOTAL SEMUA STOK</b></div>
      <div class="panel-body" style="padding:10 0;">
        <div class="c100 center p<?php $total = count($all); echo $total;?> green">
          <span><b><?php $total = count($all); echo $total;?></b></span>
          <div class="slice">
            <div class="bar"></div>
            <div class="fill"></div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="col-md-4 col-xs-12"> 
  <div class="panel" style="border-top:3px solid #434348;padding-top:0px;box-shadow:0px 0px 8px 0px #bababa;background-color:white;">
      <div style="padding:15px;padding-bottom:30px;background-color:white;box-shadow:0px 0px 8px 0px #bababa;">
        <div class="col-xs-12" style="margin-left:-15px;width:60%;"><b>INFO USER</b></div>
      </div>
      <div class="panel-body" style="margin-top:10px;padding-top:5px;">
        <?php 
      $user_log = info_user_login();
      foreach($user_log as $datas){
    echo "Info login : <b>" .$datas->nama_depan. "</b><br>";
    echo "Last Login : <b>" .$this->session->userdata('last_login'). "</b><br>";
    echo "Alamat IP : <b>" . $this->input->ip_address() . "</b><br/>";
      }?><br>
      <a class="btn btn-block btn-success" href="<?php echo base_url('trueaccon2194/stok/stok_taking');?>">STOK TAKING</a>
      </div>
    </div>
</div>
<div class="col-md-6 col-xs-12"> 
  <div class="panel" style="border-top:3px solid #434348;padding-top:0px;box-shadow:0px 0px 8px 0px #bababa;background-color:white;">
      <div style="padding:15px;padding-bottom:30px;background-color:white;box-shadow:0px 0px 8px 0px #bababa;">
        <div class="col-xs-6"  style="margin-left:-15px;width:60%;"><b>PRODUK <label class="label label-success">> 30</label></b></div>
        <div class="col-xs-6" style="text-align:right;width:40%;"><b>UKURAN | STOK</b></div>
      </div>
      <div class="panel-body scroll-menu" style="margin-top:0px;height:350px;padding-top:5px;">
      <?php echo form_open('trueaccon2194/stok/updating_stok');?>
        <?php 
        if(count($good) == 0){
            echo "<div class='text-center' style='margin-top:100px;'><span style='font-size:100px;color:#ededed;' class='glyphicon glyphicon-search'></span><div class='col-xs-12'>Tidak Ada Data</div></div>";
          }else{
        foreach($good as $data){?>
          <input type="hidden" name="id_update_pro[]" value="<?php echo $data->id_produk;?>">
          <h5 style="padding-bottom: 5px;"><b>
          <i class="hidden-lg" style="font-style:normal;">[ <?php echo $data->artikel;?> ]</i>
          <i class="hidden-xs"><?php echo $data->nama_produk;?> [ <?php echo $data->artikel;?> ]</i>
          <label style='font-size:13px;' title="Color" class='label label-primary'><?php echo $data->opsi_color;?></label>
          </b> <input type="text" class="pull-right" style="width:10%;margin-left:5px;text-align:center;" id="update_stok" name="update_stok[]" value="<?php echo $data->stok?>">
          <input type="hidden" class="pull-right" style="width:10%;margin-left:5px;text-align:center;" id="size_stok" name="size_stok[]" value="<?php echo $data->id_opsi_get_size?>">
          <label style='font-size:13px;' title="Stok" class='label label-success pull-right'><?php echo $data->stok;?></label>
          <label style='font-size:13px;margin-right: 5px;' title="Size" class='label label-default pull-right'><?php echo $data->opsi_size;?></label>
          </h5>
        <?php }}?>
      </div>
      <div class="col-xs-12" style="margin-bottom:20px;margin-top:-5px;background-color:white;padding:6px;background-color:white;box-shadow:0px 0px 8px 0px #bababa;"><button type="submit" name="submit" class="btn btn-success">Simpan</button></div>
      <?php echo form_close();?>
    </div>
</div>

<div class="col-md-6 col-xs-12"> 
  <div class="panel" style="border-top:3px solid #434348;padding-top:0px;box-shadow:0px 0px 8px 0px #bababa;background-color:white;">
      <div style="padding:15px;padding-bottom:30px;background-color:white;box-shadow:0px 0px 8px 0px #bababa;">
        <div class="col-xs-6" style="margin-left:-15px;width:60%;"><b>PRODUK <label class="label label-warning">< 30</label></b></div>
        <div class="col-xs-6" style="text-align:right;width:40%;"><b>UKURAN | STOK</b></div>
      </div>
      <div class="panel-body scroll-menu" style="margin-top:0px;height:350px;padding-top:5px;">
      <?php echo form_open('trueaccon2194/stok/updating_stok');?>
        <?php 
        if(count($critical_plus_warning) == 0){
            echo "<div class='text-center' style='margin-top:100px;'><span style='font-size:100px;color:#ededed;' class='glyphicon glyphicon-search'></span><div class='col-xs-12'>Tidak Ada Data</div></div>";
          }else{
        foreach($critical_plus_warning as $data){?>
          <input type="hidden" name="id_update_pro[]" value="<?php echo $data->id_produk;?>">
          <h5 style="padding-bottom: 5px;"><b>
          <i class="hidden-lg" style="font-style:normal;">[ <?php echo $data->artikel;?> ]</i>
          <i class="hidden-xs"><?php echo $data->nama_produk;?> [ <?php echo $data->artikel;?> ]</i>
          <label style='font-size:13px;' title="Color" class='label label-primary'><?php echo $data->opsi_color;?></label>
          </b> <input type="text" class="pull-right" style="width:10%;margin-left:10px;text-align:center;" id="update_stok" name="update_stok[]" value="<?php echo $data->stok?>">
          <input type="hidden" class="pull-right" style="width:10%;margin-left:5px;text-align:center;" id="size_stok" name="size_stok[]" value="<?php echo $data->id_opsi_get_size?>">
          <?php 
          $stok = $data->stok;
          if($stok < 10){
            echo "<label style='font-size:13px;' class='label label-danger pull-right'>$stok</label>";
          }else{
            echo "<label style='font-size:13px;' class='label label-warning pull-right'>$stok</label>";
          }
          ?>
          <label style='font-size:13px;margin-right: 5px;' title="Size" class='label label-default pull-right'><?php echo $data->opsi_size;?></label>
          </h5>
        <?php }}?>
      </div>
      <div class="col-xs-12" style="margin-bottom:20px;margin-top:-5px;background-color:white;padding:6px;background-color:white;box-shadow:0px 0px 8px 0px #bababa;"><button type="submit" name="submit" class="btn btn-success">Simpan</button></div>
      <?php echo form_close();?>
    </div>
</div>
<div class="col-md-12 col-xs-12"> 
  <div class="panel" style="border-top:3px solid #434348;padding-top:0px;box-shadow:0px 0px 8px 0px #bababa;background-color:white;">
      <div style="padding:15px;padding-bottom:30px;background-color:white;box-shadow:0px 0px 8px 0px #bababa;">
        <div class="col-xs-6" style="margin-left:-15px;width:60%;"><b>PRODUK | UKURAN</b></div>
        <div class="col-xs-6" style="text-align:right;width:40%;"><b>HARGA NET | HARGA AWAL | DISKON</b></div>
      </div>
      <div class="panel-body scroll-menu" style="margin-top:0px;height:350px;padding-top:5px;">
      <?php echo form_open('trueaccon2194/stok/updating_harga');?>
        <?php 
        if(count($harga) == 0){
            echo "<div class='text-center' style='margin-top:100px;'><span style='font-size:100px;color:#ededed;' class='glyphicon glyphicon-search'></span><div class='col-xs-12'>Tidak Ada Data</div></div>";
          }else{ 
        foreach($harga as $data){?>
          <input type="hidden" name="id_update_pro[]" value="<?php echo $data->id_produk;?>">
          <input type="hidden" name="id_update_size[]" value="<?php echo $data->id_opsi_get_size;?>">
          <h5 style="padding-bottom: 5px;"><b>
          <i class="hidden-lg" style="font-style:normal;">[ <?php echo $data->artikel;?> ]</i>
          <i class="hidden-xs"><?php echo $data->nama_produk;?> [ <?php echo $data->artikel;?> ]</i>
          <label style='font-size:13px;margin-right: 5px;' title="Size" class='label label-default'>Ukuran : <?php echo $data->opsi_size;?></label>
          <?php if($data->harga_dicoret == 0 || empty($data->harga_dicoret)){ 
                //echo "Rp. ".number_format($data->harga_fix,0,".",".")."";
                $harga_awal = "";
                $harga_net = $data->harga_fix;
                $diskon = 0;
          }else{
                //echo "<s>Rp. ".number_format($data->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($data->harga_fix,0,".",".")."</span>";
                $harga_awal = $data->harga_dicoret;
                $harga_net = $data->harga_fix;
                $diskon = round(($data->harga_dicoret - $data->harga_fix) / $data->harga_dicoret * 100);
          }?>
          <input type="text" class="pull-right" style="width:50px;margin-left:5px;text-align:center;" id="size_stok" name="diskon[]" value="<?php echo $diskon?>">
          <input type="text" class="pull-right" style="width:50px;margin-left:10px;text-align:center;text-decoration: line-through;" id="update_stok" name="update_harga_awal[]" value="<?php echo $harga_awal?>">
          <input type="text" class="pull-right" style="width:50px;margin-left:5px;text-align:center;" id="size_stok" name="update_hargafix[]" value="<?php echo $harga_net?>">
          </b>
          </h5>
        <?php }}?>
      </div>
      <div class="col-xs-12" style="margin-bottom:20px;margin-top:-5px;background-color:white;padding:6px;background-color:white;box-shadow:0px 0px 8px 0px #bababa;"><button type="submit" name="submit" class="btn btn-success">Simpan</button></div>
      <i style="color:red">Jika mengisi kolom diskon, harga jangan diubah. harga akan disesuaikan otomatis</i>
      <?php echo form_close();?>
    </div>
</div>
</div>
</div>
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
                text: 'Produk'
             },
             xAxis: {
                categories: ['Produk']
             },
             yAxis: {
                title: {
                   text: 'Sisa Stok'
                }
             },
                  series:             
                [
                    <?php
                      foreach($critical_graph as $data){                             
                    ?>
                        {
                          name: '<?php echo $data->nama_produk; ?>',
                          data: [<?php echo $data->stok_total; ?>]
                        },
                        <?php }?>
                    ]
          });
       });  
</script>