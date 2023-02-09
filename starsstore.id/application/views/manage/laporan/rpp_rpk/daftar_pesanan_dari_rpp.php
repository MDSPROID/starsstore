<script type="text/javascript">
  $(document).ready( function () {
      $("#table_produk").DataTable();      
  });
</script>
<div class="page-title">
  <h3>Daftar Pesanan <?php echo $caption?>
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
      <li><a href="javascript:void(0);">Daftar Pesanan <?php echo $caption?></a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
    <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
    <?php echo br(2);?>
  </div>
  <div class="col-md-12">
      <div class="row">
          <div class="col-md-12 table-responsive">  
            <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">Tanggal Order</th>
                    <th style="text-align:center;">Tanggal Selesai Order</th>
                    <th style="text-align:center;">No. Invoice</th>
                    <th style="text-align:center;">Buy In</th>
                    <th style="text-align:center;">Pasang</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 0;
                $jmlPesanan = 0;
                $jmlPsg = 0;
                foreach($getdata as $data):
                  $id = $this->encrypt->encode($data->no_order_cus); 
                  $idx = base64_encode($id);
                  $no++;
                  if($caption == "Tepat Waktu"){
                    $inv = $data->inv_ontime;
                    $qty = $data->qty_ontime;
                  }else if($caption == "Pending Bulan Lalu"){
                    $inv = $data->inv_pending_bln_lalu;
                    $qty = $data->qty_pending_bln_lalu;
                  }else{
                    $inv = $data->inv_pending_bln_ini;
                    $qty = $data->qty_pending_bln_ini;
                  }

                  $jmlPesanan += count($data->invoice);
                  $jmlPsg += ($qty);
                ?>
               <tr>
                  <td style="text-align:center;"><?php echo $no?></td>
                  <td style="text-align:center;"><?php echo date('d F Y',strtotime($data->tanggal_order));?></td>
                  <td style="text-align:center;"><?php if($data->tanggal_order_finish == "0000-00-00" || $data->tanggal_order_finish == "1970-01-01"){ echo "-";}else{ echo date('d F Y',strtotime($data->tanggal_order_finish)); }?></td>
                  <td style="text-align:center;"><?php echo $inv;?></td>
                  <td style="text-align:center;"><?php echo $data->buy_in;?></td>
                  <td style="text-align:center;"><?php echo $qty;?></td>
                  <td style="text-align:center;"><a class="btn btn-default" href="<?php echo base_url('trueaccon2194/online_store/detail/'.$idx.'');?>"><i class="glyphicon glyphicon-eye-open"></i></a></td>                  
              </tr>
             <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr style="background-color:#34425a;color:white;">
                  <th style="text-align:right;text-align: center;" colspan="5">Total Pesanan : <?php echo $jmlPesanan?></th>
                  <th style="text-align:center;"><?php echo $jmlPsg;?></th>
                  <th style="text-align:center;"></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
  </div>
</div>
</div>