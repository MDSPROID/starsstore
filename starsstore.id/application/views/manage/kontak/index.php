<script type="text/javascript">
  $(document).ready( function () {

      $("#table_kontak").DataTable();
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/kontak')?>">Kontak</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
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
  <table id="table_kontak" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Tanggal</th>
                    <th style="text-align:center;">Nomor Tiket</th>
                    <th style="text-align:center;">Nama Pelanggan</th>
                    <th style="text-align:center;">Email</th>
                    <th style="text-align:center;">Kategori Keluhan</th>
                    <th style="text-align:center;">Pertanyaan</th>
                    <th style="text-align:center;">Informasi Device</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($get_list as $data){
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_kontak;?>" /></td>
                  <td style="text-align:center;"><?php $t = $data->date_create; echo date('d F Y H:i:s', strtotime($t));?></td>
                  <td style="text-align:center;">
                    <?php if($data->baca == "belum"){?>
                      <label class="label label-success"><?php echo $data->no_kontak;?></label>
                    <?php }else{?>
                      <label class="label label-default"><?php echo $data->no_kontak;?></label>
                    <?php }?>
                  </td>
                  <td style="text-align:center;"><?php echo $data->nama;?></td>
                  <td style="text-align:center;"><?php echo $data->email;?></td>
                  <td style="text-align:center;"><?php echo $data->kategori_keluhan;?></td>
                  <td style="text-align:center;"><?php echo word_limiter($data->pertanyaan, 5);?></td>
                  <td style="text-align:center;"><label class="label label-default"><?php echo $data->ip;?></label><br><label class="label label-default"><?php echo $data->browser;?></label><br><label class="label label-default"><?php echo $data->os;?></label></td>
                  <td style="text-align:center;">
                    <?php if($data->status == "ditangguhkanmenunggu"){?>
                      <label class="label label-warning">Menungu Balasan</label>
                    <?php }else if($data->status == "dibalaskan"){?>
                      <label class="label label-danger">Dijawab</label>
                    <?php }else{?>
                      <label class="label label-danger">Dibatalkan</label>
                    <?php }?>
                  </td>
                  <td style="text-align:center;">
                    <a style="margin-bottom: 10px;" href="<?php echo base_url()?>trueaccon2194/kontak/reply_and_read/<?php $id = $this->encrypt->encode($data->id_kontak); $idp = base64_encode($id); echo $idp ?>" class="btn btn-default edit"><i class="glyphicon glyphicon-eye-open"></i></a>
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