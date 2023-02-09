<script type="text/javascript">
  $(document).ready(function () {

      $("#table_slider").DataTable();
      
  });
</script> 
<div class="page-title">
  <h3>User Management 
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
      <li>User Management</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a href="<?php echo base_url('trueaccon2194/user_preference/tambah_user');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah User</a>
  <?php echo form_open_multipart('trueaccon2194/produk/delete_select', array('class' => 'input-group'));?>
  <button name="submit" class="btn btn-danger" style="margin-right: 10px;"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
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
                    <th style="text-align:center;">Avatar</th>
                    <th style="text-align:center;">Nama</th>
                    <th style="text-align:center;">Email</th>
                    <th style="text-align:center;">Akses</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Last Login</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id;?>" /></td>
                  <td style="text-align:center;"><img src="
                  <?php 
                    if(empty($data->gb_user)){echo base_url('assets/images/produk/default.jpg');}else{echo base_url('assets/images/user/'.$data->gb_user.'');}?>" height="50"></td>
                  <td style="text-align:center;"><?php echo $data->nama_depan;?></td>
                  <td style="text-align:center;"><?php echo $data->email;?></td>
                  <td style="text-align:center;"><?php if($data->akses == "G7)*#_fsRe"){ echo "<label class='label label-primary'>Administrator</label>";}else if($data->akses == "FnC%4%7d8B"){ echo "<label class='label label-success' >Finance</label>"; }else if($data->akses == "pG5Y$7(#1@"){ echo "<label class='label label-success'>Support</label>"; }else if($data->akses == "WrTd3*6)^@"){ echo "<label class='label label-default'>Writer</label>"; }else if($data->akses == "S_lf63*%@)"){ echo "<label class='label label-default'>Sales</label>"; } ?></td>
                  <td style="text-align:center;"><?php if($data->status == "Non36en&5*93#*"){ echo "<label class='label label-danger'>Nonaktif</label>";}else if($data->status == "AEngOn73#43"){ echo "<label class='label label-success'>Aktif</label>";}?></td>
                  <td style="text-align:center;"><?php if($data->last_login == "0000-00-00 00:00:00"){ echo "-";}else{echo date('d F Y H:i:s', strtotime($data->last_login));}?></td>
                  <td style="text-align:center;">
                    <?php 
                    $a = $this->encrypt->encode($data->id);
                    $b = base64_encode($a);

                    if($data->status == "Non36en&5*93#*"){
                      $xh = "OFF";
                    }else{
                      $xh = "ON";
                    }?>    

                    <?php if($xh == "OFF"){
                      echo "<a href='user_preference/on/$b' style='padding:3px 8px;margin-bottom:5px;' class='btn btn-success'>ON</a>"; 
                    }else {
                      echo "<a href='user_preference/off/$b' style='padding:3px 8px;margin-bottom:5px;' class='btn btn-danger'>OFF</a>"; 
                    }?>
                    <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/user_preference/edit/<?php echo $b?>" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/user_preference/hapus/<?php echo $b ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                    <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/user_preference/tracking_user/<?php echo $b ?>" class="btn btn-default track"><i class="glyphicon glyphicon-eye-open"></i></a>
                  </td>
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