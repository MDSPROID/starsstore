<script type="text/javascript">
  $(document).ready( function () {

      $("#table_stok").DataTable();
  });
</script>
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
      <li><a href="<?php echo base_url('trueaccon2194/stok')?>">Stok</a></li>
      <li class="active">Stok Taking</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
</div>
<div class="col-md-12 col-xs-12 table-responsive"> 
  <h3>DATA HASIL STOK TAKING</h3>
<div id="pesan"></div>
<?php foreach($data_taking as $r){ }?>
<?php if(empty($r->stok_data)){?>
<div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
  <div class="row">
    <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
  </div>
</div>
<?php }else{?>
  <table id="table_stok" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Tanggal</th>
                    <th style="text-align:center;">Artikel</th>
                    <th style="text-align:center;">Size</th>
                    <th style="text-align:center;">Stok Database</th>
                    <th style="text-align:center;">Stok Fisik</th>
                    <th style="text-align:center;">Selisih Stok Database & Stok Fisik</th>
                    <th style="text-align:center;">User</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_stok_db = 0;
                $total_stok_taking = 0;
                $total_selisih = 0;
                foreach($data_taking as $data):
                  $total_stok_db      += $data->stok_data;
                  $total_stok_taking  += $data->stok_hasil_stok_taking;
                  $total_selisih      += $data->stok_hasil_stok_taking - $data->stok_data;
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" /></td>
                  <td style="text-align:center;"><?php echo date('d F Y H:i:s', strtotime($data->tanggal_stok))?></td>
                  <td style="text-align:center;"><?php echo $data->artikel;?></td>
                  <td style="text-align:center;"><?php echo $data->size;?></td>
                  <td style="text-align:center;"><?php echo $data->stok_data;?></td>
                  <td style="text-align:center;"><?php echo $data->stok_hasil_stok_taking;?></td>
                  <td style="text-align:center;"><?php echo $data->stok_hasil_stok_taking - $data->stok_data;?></td>
                  <td style="text-align:center;"><?php echo $data->nama_depan?></td>
              </tr>
             <?php 
            endforeach;?>
            </tbody>
            <tfoot>
              <tr style="background-color:#34425a;color:white;">
                <td style="text-align:center;" colspan="4">Hasil Stok taking</td>
                <td style="text-align:center;"><?php echo $total_stok_db?></td>
                <td style="text-align:center;"><?php echo $total_stok_taking?></td>
                <td style="text-align:center;"><?php echo $total_selisih?></td>
                <td style="text-align:center;"></td>
              </tr>
            </tfoot>
  </table>
<?php }?>
</div>
</div>
</div>