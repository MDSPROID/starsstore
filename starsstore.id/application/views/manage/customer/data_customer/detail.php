<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
  });
</script>
<div class="page-title">
  <h3>Tracking Login Customer
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
      <li><a href="<?php echo base_url('trueaccon2194/customer')?>">Customer</a></li>
      <li class="active">Tracking Login Customer</li>
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
                    <th style="text-align:center;">Email</th>
                    <th style="text-align:center;">IP</th>
                    <th style="text-align:center;">Browser</th>
                    <th style="text-align:center;">Platform</th>
                    <th style="text-align:center;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($tr as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_user_track;?>" /></td>
                  <td style="text-align:center;"><?php echo $data->email;?></td>
                  <td style="text-align:center;"><?php echo $data->ip;?></td>
                  <td style="text-align:center;"><?php echo $data->browser;?></td>
                  <td style="text-align:center;"><?php echo $data->platform;?></td>
                  <td style="text-align:center;"><?php $r = $data->tanggal; echo date('d F y H:i:s', strtotime($r));?></td>
              </tr>
             <?php endforeach;?>
            </tbody>
  </table>
</div>
<?php echo form_close();?>
  </div>
</div>