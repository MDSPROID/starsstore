<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
  });
</script>
<div class="page-title">
  <h3>Customer
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/customer')?>">Customer</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a href="<?php echo base_url('trueaccon2194/customer/tambah_customer');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah Customer</a>
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
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Customer</th>
                    <th style="text-align:center;">ID Seller</th>
                    <th style="text-align:center;">Gender</th>
                    <th style="text-align:center;">Email</th>
                    <th style="text-align:center;">Telpon</th>
                    <th style="text-align:center;">Tanggal Mendaftar</th>
                    <th style="text-align:center;">IP Register</th>
                    <th style="text-align:center;">Login Terakhir</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($get_list as $data){
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id;?>" /></td>
                  <td style="text-align:center;"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="
                  <?php 
                    if(empty($data->gb_user)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->gb_user;}?>" height="50"></td>
                  <td style="text-align:center;"><?php echo $data->nama_lengkap;?> <?php if($data->baca == "belum"){?><span class="badge badge-success">baru</span><?php }else{ }?></td>
                  <td style="text-align:center;"><?php if(empty($data->id_seller)){ }else { echo $data->id_seller;}?></td>
                  <td style="text-align:center;"><?php echo $data->gender;?></td>
                  <td style="text-align:center;"><?php echo $data->email;?></td>
                  <td style="text-align:center;"><?php echo $data->telp;?></td>
                  <td style="text-align:center;"><?php $t = $data->created; echo date('d F Y H:i:s', strtotime($t));?></td>
                  <td style="text-align:center;"><label class="label label-default"><?php echo $data->ip_register_first;?></label></td>
                  <td style="text-align:center;"><?php if($data->last_login == ""){}else{ $r = $data->last_login; echo date('d F Y H:i:s', strtotime($r)); }?></td>
                  <td style="text-align:center;">
                  <?php
                    if($data->status == "Nh3825(*hhb"){
                      echo "<label class='label label-danger'>Tidak Aktif</label>";
                    }else if($data->status == "Kj(*62&*^#)_"){
                      echo "<label class='label label-warning'>Belum Dikonfirmasi by Email</label>";
                    }else if($data->status == "a@kti76f0"){
                      echo "<label class='label label-success'>Aktif</label>";
                    }
                  ?></td>
                  <td style="text-align:center;">
                    <?php
                    $idf = $this->encrypt->encode($data->id);
                    $id = base64_encode($idf);
                    if($data->status == "a@kti76f0"){
                      echo "<a style='margin-bottom: 10px; padding:3px 8px;' href='customer/off/$id' class='btn btn-danger edit'>OFF</a>";
                    }else if($data->status == "Nh3825(*hhb"){
                      echo "<a style='margin-bottom: 10px; padding:3px 8px;' href='customer/on/$id' class='btn btn-success edit'>ON</a>";
                    }
                    ?>
                    <a style="margin-bottom: 10px;" href="<?php echo base_url()?>trueaccon2194/customer/edit_data/<?php $id = $this->encrypt->encode($data->id); $idp = base64_encode($id); echo $idp ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a style="margin-bottom: 10px;" href="<?php echo base_url()?>trueaccon2194/customer/hapus/<?php $id = $this->encrypt->encode($data->id); $idp = base64_encode($id); echo $idp ?>" class="btn btn-danger hapus" ><i class="glyphicon glyphicon-remove"></i></a>
                    <a style="margin-bottom: 10px;" href="<?php echo base_url()?>trueaccon2194/customer/tracking/<?php $id = $this->encrypt->encode($data->id); $idp = base64_encode($id); echo $idp ?>" class="btn btn-default edit"><i class="glyphicon glyphicon-eye-open"></i></a>
                  </td>
              </tr>
             <?php }?>
            </tbody>
  </table>
</div>
<?php }?>
<?php echo form_close();?>
  </div>
</div>