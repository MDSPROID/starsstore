<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
  });
</script>
<div class="page-title">
  <h3>Point Customer
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/point_customer')?>">Point Customer</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a class="hidden" href="<?php echo base_url('trueaccon2194/customer/tambah_customer');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah Customer</a>
  <?php echo form_open_multipart('trueaccon2194/produk/delete_select', array('class' => 'input-group'));?>
  <button name="submit" class="btn btn-danger" style="margin-right: 10px;"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
</div>
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Customer</th>
                    <th style="text-align:center;">Total Point</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id;?>" /></td>
                  <td style="text-align:center;"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="
                  <?php 
                    if(empty($data->gb_user)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->gb_user;}?>" height="50"></td>
                  <td style="text-align:center;"><?php echo $data->nama_lengkap;?></td>
                  <td style="text-align:center;"><?php echo $data->point_terkumpul;?></td>
                  <td style="text-align:center;">
                    <a style="margin-bottom: 10px;" href="<?php echo base_url()?>trueaccon2194/point_customer/detail/<?php $id = $this->encrypt->encode($data->id); $idp = base64_encode($id); echo $idp ?>" class="btn btn-default edit"><i class="glyphicon glyphicon-eye-open"></i></a>
                  </td>
              </tr>
             <?php endforeach;?>
            </tbody>
  </table>
</div>
<?php echo form_close();?>
  </div>
</div>