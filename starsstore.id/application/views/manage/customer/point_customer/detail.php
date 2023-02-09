<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
  });
</script>
<div class="page-title">
  <h3>Detail Point Customer
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
      <li><a href="<?php echo base_url('trueaccon2194/point_customer')?>">Point Customer</a></li>
      <li class="active">Detail Point Customer</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
<a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a><?php echo br(3)?>
</div>
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Invoice</th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Project</th>
                    <th style="text-align:center;">Artikel</th>
                    <th style="text-align:center;">Harga</th>
                    <th style="text-align:center;">Point per transaksi (per produk)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($tr as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id;?>" /></td>
                  <td style="text-align:center;">#<?php echo $data->invoice;?></td>
                  <td style="text-align:center;"><img src="
                  <?php 
                    if(empty($data->gambar)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->gambar;}?>" height="50"></td>
                  <td style="text-align:center;"><?php echo $data->nama_produk;?></td>
                  <td style="text-align:center;"><?php echo $data->artikel;?></td>
                  <td style="text-align:center;">Rp.<?php echo number_format($data->harga_fix,0,".",".");?></td>
                  <td style="text-align:center;"><?php echo $data->point;?></td>
              </tr>
             <?php endforeach;?>
            </tbody>
            <tfoot>
                <tr style="background-color:#34425a;color:white;">
                    <th colspan="5"></th>
                    <th style="text-align:center;">Total</th>
                    <th style="text-align:center;"><?php echo $total_point;?></th>
                </tr>
            </tfoot>
  </table>
</div>
  </div>
</div>