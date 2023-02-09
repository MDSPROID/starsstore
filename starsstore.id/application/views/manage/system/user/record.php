<script type="text/javascript">
  $(document).ready(function () {

      $("#table_slider").DataTable();
      
  });
</script> 
<div class="page-title">
  <h3>User Record Activity
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
      <li><a href="<?php echo base_url('trueaccon2194/user_preference')?>">User Management</a></li>
      <li>User Record Activity</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
  <br>
</div>
<?php if(empty($get_list)){?>
<div class="col-md-12">
  <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
    <div class="row">
      <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
    </div>
  </div>
</div>
<?php } else {?>
<div class="col-md-12 table-responsive">  
  <table id="table_slider" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Waktu</th>
                    <th style="text-align:center;">User</th>
                    <th style="text-align:center;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id;?>" /></td>
                  <td style="text-align:center;"><?php echo $data->log_time;?></td>
                  <td style="text-align:center;"><?php echo $data->nama_depan;?></td>
                  <td style="text-align:center;"><?php echo $data->log_desc;?></td>
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