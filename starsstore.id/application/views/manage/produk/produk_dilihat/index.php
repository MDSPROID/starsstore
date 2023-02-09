<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
  });
</script> 
<div class="page-title">
  <h3>Produk Dilihat
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/produk_dilihat')?>">Produk Dilihat</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
  <div class="col-md-4 col-xs-12">
    <div class="col-xs-12" id="form-banner1" style="background-color: white;padding: 20;margin-bottom: 30px;">
      <label class="label" style="padding:0;font-size: 16px;color:#4E5E6A;">Total Kunjungan Produk </label> 
      <?php echo br(2);?>
      <div class="col-md-6 col-xs-6 text-center" style="padding-right: 0;padding-left: 0;">
      <label class="text-center" style="padding: 5px;">
        <b><span class="text-counter">Hari ini</span></b> 
        <?php 
          if($total_produk_view_per_day == 0){
            echo "0";
          }else{
        ?>
        <div class="font-c100 c100 center p<?php echo count($total_produk_view_per_day);?> green">
          <span><b><?php echo count($total_produk_view_per_day);?></b></span>
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
          if($total_produk_view_per_week == 0){
            echo "0";
          }else{
        ?>
        <div class="font-c100 c100 center p<?php echo count($total_produk_view_per_week);?> orange">
          <span><b><?php echo count($total_produk_view_per_week);?></b></span>
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
          if($total_produk_view_per_month == 0){
            echo "0";
          }else{
        ?>
         <div class="font-c100 c100 center p<?php echo count($total_produk_view_per_month);?> orange">
          <span><b><?php echo count($total_produk_view_per_month);?></b></span>
          <div class="slice">
            <div class="bar"></div>
            <div class="fill"></div>
          </div>
        </div>
        <?php }?>
      </label></div>
      <div class="col-md-6 col-xs-6 text-center" style="padding-right: 0;padding-left: 0;">
      <label class="text-center" style="padding: 5px;">
        <b>Tahun ini</b> 
        <?php 
          if($total_produk_view_per_year == 0){
            echo "0";
          }else{
        ?>
        <div class="font-c100 c100 center p<?php echo count($total_produk_view_per_year);?> orange">
          <span><b><?php echo count($total_produk_view_per_year);?></b></span>
          <div class="slice">
            <div class="bar"></div>
            <div class="fill"></div>
          </div>
        </div>
        <?php  }?>
      </label>
     </div>            
    </div>

    <div class="col-xs-12" id="form-banner1" style="background-color: white;padding: 20;margin-bottom: 30px;">
      <label class="label" style="padding:0;font-size: 16px;color:#4E5E6A;">Kunjungan produk dalam satu bulan<br>(per kategori)</label> 
      <?php echo br(2);?>
      <div class="col-md-4 col-xs-12" style="padding-right: 0;padding-left: 0;">
        <label class="text-center" style="padding: 5px;">
          <b>
            <span class="text-counter">
              Pria : 
              <?php 
                if($total_produk_view_pria == 0){
                  echo "0";
                }else{
                  echo count($total_produk_view_pria);
                }
              ?>
            </span>
          </b> 
        </label>
      </div>
      <div class="col-md-4 col-xs-12" style="padding-right: 0;padding-left: 0;">
        <label class="text-center" style="padding: 5px;">
          <b>
            <span class="text-counter">
              Wanita : 
              <?php 
                if($total_produk_view_wanita == 0){
                  echo "0";
                }else{
                  echo count($total_produk_view_wanita);
                }
              ?>
            </span>
          </b> 
        </label>
      </div>
      <div class="col-md-4 col-xs-12" style="padding-right: 0;padding-left: 0;">
        <label class="text-center" style="padding: 5px;">
          <b>
            <span class="text-counter">
              Anak : 
              <?php 
                if($total_produk_view_anak == 0){
                  echo "0";
                }else{
                  echo count($total_produk_view_anak);
                }
              ?>
            </span>
          </b> 
        </label>
      </div>
    </div>


  </div>
  <div class="col-md-8 col-xs-12" style="margin-bottom: 30px;">
    <div class="col-xs-12" id="form-banner1" style="background-color: white;padding: 20;">
      <label class="label" style="padding:0;font-size: 16px;color:#4E5E6A;">Produk Trending</label> 
      <?php echo br(2);?>
      <div class="panel">
        <div class="col-md-6 col-xs-12" style="padding-bottom:30px;background-color:white;">
          <h4>Hari Ini</h4>
          <div class="panel-body scroll-menu" style="margin-top:0px;height:155px;padding-top:5px;">
            <?php 
              if(count($total_produk_view_per_day) == 0){
                echo "<div class='text-center' style='margin-top:20px;'><span style='font-size:100px;color:#ededed;' class='glyphicon glyphicon-search'></span><div class='col-xs-12'>Tidak Ada Data</div></div>";
              }else{?>
                <ul style="margin-left: -35px;">
                <?php foreach($total_produk_view_per_day as $data3){?>
                  <li>
                    <h5><b><i style="font-style:normal;"><?php echo word_limiter($data3->nama_produk,2); ?></i> [ <?php echo $data3->artikel; ?> ] <i class="label label-primary"><?php echo $data3->total; ?>x</i><br /></b> </h5>
                  </li>
                <?php }?>
                </ul>
              <?php }?>
          </div>
        </div>
        <div class="col-md-6 col-xs-12" style="padding-bottom:30px;background-color:white;">
          <h4>Minggu Ini</h4>
          <div class="panel-body scroll-menu" style="margin-top:0px;height:155px;padding-top:5px;">
            <?php 
              if(count($total_produk_view_per_week) == 0){
                echo "<div class='text-center' style='margin-top:20px;'><span style='font-size:100px;color:#ededed;' class='glyphicon glyphicon-search'></span><div class='col-xs-12'>Tidak Ada Data</div></div>";
              }else{?>
                <ul style="margin-left: -35px;">
                <?php foreach($total_produk_view_per_week as $data4){?>
                  <li>
                    <h5><b><i style="font-style:normal;"><?php echo word_limiter($data4->nama_produk,2); ?></i> [ <?php echo $data4->artikel; ?> ] <i class="label label-primary"><?php echo $data4->total; ?>x</i><br /></b> </h5>
                  </li>
                <?php }?>
                </ul>
              <?php }?>
          </div>
        </div>
        <div class="col-md-6 col-xs-12" style="padding-bottom:30px;background-color:white;">
          <h4>Bulan Ini</h4>
          <div class="panel-body scroll-menu" style="margin-top:0px;height:155px;padding-top:5px;">
            <?php 
              if(count($total_produk_view_per_month) == 0){
                echo "<div class='text-center' style='margin-top:20px;'><span style='font-size:100px;color:#ededed;' class='glyphicon glyphicon-search'></span><div class='col-xs-12'>Tidak Ada Data</div></div>";
              }else{?>
                <ul style="margin-left: -35px;">
                <?php foreach($total_produk_view_per_month as $data2){?>
                  <li>
                    <h5><b><i style="font-style:normal;"><?php echo word_limiter($data2->nama_produk,2); ?></i> [ <?php echo $data2->artikel; ?> ] <i class="label label-primary"><?php echo $data2->total; ?>x</i><br /></b> </h5>
                  </li>
                <?php }?>
                </ul>
              <?php }?>
          </div>
        </div>
        <div class="col-md-6 col-xs-12" style="padding-bottom:30px;background-color:white;">
          <h4>Tahun Ini</h4>
          <div class="panel-body scroll-menu" style="margin-top:0px;height:155px;padding-top:5px;">
            <?php 
              if(count($total_produk_view_per_year) == 0){
                echo "<div class='text-center' style='margin-top:20px;'><span style='font-size:100px;color:#ededed;' class='glyphicon glyphicon-search'></span><div class='col-xs-12'>Tidak Ada Data</div></div>";
              }else{?>
                <ul style="margin-left: -35px;">
                <?php foreach($total_produk_view_per_year as $data1){?>
                  <li>
                    <h5><b><i style="font-style:normal;"><?php echo word_limiter($data1->nama_produk,2); ?></i>  [ <?php echo $data1->artikel; ?> ] <i class="label label-primary"><?php echo $data1->total; ?>x</i><br /></b> </h5>
                  </li>
                <?php }?>
                </ul>
              <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>  
<div class="col-md-12 table-responsive">  
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Project</th>
                    <th style="text-align:center;">Artikel</th>
                    <th style="text-align:center;">Produk Dilihat (Total)</th>
                    <th style="text-align:center;">Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($get_list) > 0){
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_produk_view;?>" /></td>
                  <td style="text-align:center;"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="
                  <?php 
                    if(empty($data->gambar)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->gambar;}?>" height="50"></td>
                  <td style="text-align:center;"><?php echo $data->nama_produk;?></td>
                  <td style="text-align:center;"><?php echo $data->artikel;?></td>
                  <td style="text-align:center;">
                  <?php
                  echo $data->total;
                  ?></td>
                  <td style="text-align:center;"><a href="<?php echo base_url()?>trueaccon2194/produk_dilihat/detail/<?php $a = $this->encrypt->encode($data->id_produk_view); $b = base64_encode($a); echo $b ?>" class="btn btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>
              </tr>
             <?php 
            endforeach;}
            else{ echo "<tr><td colspan=5>DATA KOSONG!!</td></tr>";
              }?>
            </tbody>
  </table>
</div>
<?php echo form_close();?>
  </div>
</div>