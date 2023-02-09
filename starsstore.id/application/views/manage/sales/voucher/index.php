<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
  });
</script>
<div class="page-title">
  <h3>Voucher dan Kupon
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/voucher')?>">voucher dan kupon</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">

<div class="col-md-12">
  <a href="<?php echo base_url('trueaccon2194/voucher/tambah_voucher');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah voucher</a>
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
                    <th style="text-align:center;">Nama Voucher</th>
                    <th style="text-align:center;">Keterangan</th>
                    <th style="text-align:center;">Stok</th>
                    <th style="text-align:center;">Masa Berlaku</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($get_list) > 0){
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id;?>" /></td>
                  <td style="text-align:center;"><img src="
                  <?php 
                    if(empty($data->banner)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->banner;}?>" height="50"></td>
                  <td style="text-align:center;"><?php echo $data->voucher_and_coupons;?></td>
                  <td style="text-align:center;"><?php echo $data->keterangan;?></td>
                  <td style="text-align:center;"><?php echo $data->qty;?></td>
                  <td style="text-align:center;"><?php echo date('d F Y H:i:s', strtotime($data->valid_until));?></td>
                  <td style="text-align:center;">
                  <?php
                    if($data->aktif == ""){
                      echo "<label class='label label-danger'>Tidak Aktif</label>";
                    }else if($data->aktif == "on"){
                      echo "<label class='label label-success'>Aktif</label>";
                    }else if($data->aktif == "expired"){
                      echo "<label class='label label-danger'>Expired</label>";
                    }
                  ?></td>
                  <td style="text-align:center;">
                    <?php
                    $idf = $this->encrypt->encode($data->id);
                    $id = base64_encode($idf);
                    if($data->aktif == "on"){
                      echo "<a style='padding:3px 8px;' href='voucher/off/$id' class='btn btn-danger edit'>OFF</a>";
                    }else if($data->aktif == ""){
                      echo "<a style='padding:3px 8px;' href='voucher/on/$id' class='btn btn-success edit'>ON</a>";
                    }
                    ?>
                    <a href="<?php echo base_url()?>trueaccon2194/voucher/edit_data/<?php $id = $this->encrypt->encode($data->id); $idp = base64_encode($id); echo $idp ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a href="<?php echo base_url()?>trueaccon2194/voucher/hapus/<?php $id = $this->encrypt->encode($data->id); $idp = base64_encode($id); echo $idp ?>" class="btn btn-danger hapus" data-id=""><i class="glyphicon glyphicon-remove"></i></a>
                  </td>
              </tr>
             <?php 
            endforeach;}
            else{ echo "<tr><td colspan=9>DATA KOSONG!!</td></tr>";
              }?>
            </tbody>
  </table>
</div>
<?php echo form_close();?>
  </div>
</div>