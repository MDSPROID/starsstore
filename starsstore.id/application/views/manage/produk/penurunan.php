<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd'
      });
  });
</script>
<div class="page-title">
  <h3>Perubahan Harga Produk Setelah Update Master
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
      <li class="active" href="<?php echo base_url('trueaccon2194/produk/produk')?>">Produk</li>
      <li class="active" href="#">Perubahan Harga Produk Setelah Update Master</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
  <?php echo br(3);?>
</div>
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Project</th>
                    <th style="text-align:center;">Artikel</th>
                    <th style="text-align:center;">User Pengubah</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                  foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_produk;?>" /></td>
                  <td style="text-align:center;"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="
                  <?php 
                    if(empty($data->gambar)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->gambar;}?>" height="50"><br>
                    <?php 
                    if($data->status == "on"){
                      echo "<label style='top:7px;position:relative;' class='label label-success'>Aktif</label>";
                    }else{
                      echo "<label style='top:7px;position:relative;' class='label label-danger'>Tidak aktif</label>";
                      }?>
                  </td>
                  <td style="text-align:center;font-size: 12px;"><a href="javascript:void(0);" onclick="preview_produk(<?php echo $data->id_produk;?>);"><?php echo $data->nama_produk;?></a></td>
                  <td style="text-align:center;font-size: 12px;"><?php echo $data->artikel;?></td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php echo $data->nama_depan?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                    if($data->status == "on"){
                      echo "<a style='padding:3px 8px;' href='produk/off/$data->id_produk' class='btn btn-danger edit'>OFF</a>";
                    }else{
                      echo "<a style='padding:3px 8px;' href='produk/on/$data->id_produk' class='btn btn-success edit'>ON</a>";
                    }
                    ?>
                    <a href="<?php echo base_url()?>trueaccon2194/produk/edit_data/<?php $id = $this->encrypt->encode($data->id_produk); $idp = base64_encode($id); echo $idp ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger hapus" data-id="<?php $id = $this->encrypt->encode($data->id_produk); $idp = base64_encode($id); echo $idp ?>" data-name="<?php echo $data->nama_produk;?>" onclick="pindahkan_tong(this);"><i class="glyphicon glyphicon-remove"></i></a>
                  </td>
              </tr>
             <?php endforeach;?>
            </tbody>
  </table>
</div>
<?php echo form_close();?>
  </div>
</div>