<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
  });
</script>
<div class="page-title">
  <h3>Produk Dibeli 
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/produk_dibeli')?>">Produk Dibeli</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Project</th>
                    <th style="text-align:center;">Artikel</th>
                    <th style="text-align:center;">Produk Dibeli (Total)</th>
                    <th style="text-align:center;">Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($get_list) > 0){
                foreach($get_list as $data):
                ?>
               <tr>                  
                  <td style="text-align:center;"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="
                  <?php 
                    if(empty($data->gambar)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->gambar;}?>" height="50"></td>
                  <td style="text-align:center;"><?php echo $data->nama_produk;?></td>
                  <td style="text-align:center;"><?php echo $data->artikel;?></td>
                  <td style="text-align:center;">
                  <?php
                  echo $data->total;
                  ?></td>
                  <td style="text-align:center;"><a class="btn btn-default" href="<?php echo base_url()?>trueaccon2194/produk_dibeli/detail_produk/<?php $a = $this->encrypt->encode($data->artikel); $b = base64_encode($a); echo $b ?>"><i class="glyphicon glyphicon-eye-open"></i></a></td>
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