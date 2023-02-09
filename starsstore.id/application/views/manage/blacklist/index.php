<script type="text/javascript">
  $(document).ready( function () {

      $("#table_black").DataTable();
  });
</script>
<div class="page-title">
  <h3>Blacklist
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/blacklist')?>">Blacklist</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<?php if(empty($list)){?>
<div class="col-md-12">
  <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
    <div class="row">
      <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
    </div>
  </div>
</div>
<?php } else {?>
<div class="col-md-12 table-responsive">  
  <table id="table_email" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="width:180px;text-align:center;">IP Address</th>
                    <th style="width:180px;text-align:center;">Browser</th>
                    <th style="text-align:center;">Platform</th>
                    <th style="text-align:center;">Aktifitas</th>
                    <th style="text-align:center;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><?php echo $data->ip?></td>
                  <td style="text-align:center;"><?php echo $data->browser?></td>
                  <td style="text-align:center;"><?php echo $data->platform?></td>
                  <td style="text-align:center;"><?php echo $data->aktifitas?></td>
                  <td style="text-align:center;"><?php echo date('d F Y H:i:s',strtotime($data->date_time));?></td>
              </tr>
             <?php 
            endforeach;?>
            </tbody>
      </table>
    </div>
<?php }?>
</div>
</div>
<?php echo form_close();?>