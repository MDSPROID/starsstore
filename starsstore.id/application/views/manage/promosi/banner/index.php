<?php 
  if($this->session->flashdata('success')):?>
    <h4 class="alert-sukses"><label class="label label-success"><?php echo $this->session->flashdata('success')?></label></h4>
<?php endif?>

<?php 
  if($this->session->flashdata('error')):?>
    <h4 class="alert-sukses"><label class="label label-danger"><?php echo $this->session->flashdata('error')?></label></h4>
<?php endif?>
<script type="text/javascript">
  $(document).ready(function () {

      $("#table_slider").DataTable();
      
  });
</script> 
<div class="page-title">
  <h3>Banner & Slider
  </h3>
  <div class="page-breadcrumb">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('trueaccon2194/info_type_user_log')?>">Home</a></li>
      <li>Banner & Slider</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a href="<?php echo base_url('trueaccon2194/media_promosi/tambah_banner');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah Banner</a>
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
                    <th style="text-align:center;">Banner</th>
                    <th style="text-align:center;">Per click</th>
                    <th style="text-align:center;">Link</th>
                    <th style="text-align:center;">Keterangan</th>
                    <th style="text-align:center;">Jenis Banner</th>
                    <th style="text-align:center;">Posisi</th>
                    <th style="text-align:center;">Tanggal Mulai</th>
                    <th style="text-align:center;">Tanggal Berakhir</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_banner;?>" /></td>
                  <td style="text-align:center;">
                    <?php if($data->jenis == "gambar"){?>
                    <img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="<?php echo $data->banner;?>" class="img-responsive" width="100">
                    <?php }else{
                      echo "<iframe id='video' width='230' height='150' src='https://www.youtube.com/embed/$data->banner' frameborder='0' allowfullscreen></iframe>";
                  }?>
                  </td>
                  <td style="text-align:center;">Rp. <?php echo $data->perclick;?></td>
                  <td style="text-align:center;"><?php echo $data->link;?></td>
                  <td style="text-align:center;"><?php echo $data->ket;?></td>
                  <td style="text-align:center;"><?php echo $data->jenis;?></td>
                  <td style="text-align:center;">
                  <?php if($data->posisi == "utama_kanan"){ 
                    echo "<label class='label label-warning'>Utama Kanan</label>"; 
                  }else if($data->posisi == "utama_kiri"){ 
                    echo "<label class='label label-warning'>Utama Kiri</label>"; 
                  }else if($data->posisi == "promo_utama"){ 
                    echo "<label class='label label-warning'>Promo Utama</label>"; 
                  }else { 
                    echo "<label class='label label-primary'>$data->posisi</label>";
                  }?></td>
                  <td style="text-align:center;"><?php echo date('d F Y', strtotime($data->tgl_mulai));?></td>
                  <td style="text-align:center;"><?php echo date('d F Y', strtotime($data->tgl_akhir));?></td>
                  <td style="text-align:center;">
                  <?php
                    if($data->status_banner == ""){
                      echo "<label class='label label-danger'>Tidak Aktif</label>";
                    }else if($data->status_banner == "on"){
                      echo "<label class='label label-success'>Aktif</label>";
                    }else if($data->status_banner == "expired"){
                      echo "<label class='label label-danger'>Expired</label>";
                    }
                  ?></td>
                  <td style="text-align:center;">
                    <?php 
                    $a = $this->encrypt->encode($data->id_banner);
                    $b = base64_encode($a);

                    if($data->status_banner == "on"){
                      $xh = "OFF";
                    }else if($data->status_banner == "expired"){
                      $xh = "";
                    }else{
                      $xh = "ON";
                    }?>    

                    <?php if($data->posisi == "utama_1" || $data->posisi == "utama_2" || $data->posisi == "utama_3" || $data->posisi == "nav_promo" || $data->posisi == "login" || $data->posisi == "utama_4" || $data->posisi == "utama_5"){
                      echo ""; 
                    }else if((empty($data->status_banner)) && ($data->posisi = "utama")){ 
                      echo "<a style='padding:3px 8px;' href='media_promosi/on/$b' style='top:7px;position:relative;' class='btn btn-success'>ON</a>"; 
                    }else if(($data->status_banner = "on") && ($data->posisi = "utama")){
                      echo "<a style='padding:3px 8px;' href='media_promosi/off/$b' style='top:7px;position:relative;' class='btn btn-danger'>OFF</a>"; 
                    }else if(($data->status_banner = "expired") && ($data->posisi = "utama")){
                      echo "";
                    }?>
                    <a href="<?php echo base_url()?>trueaccon2194/media_promosi/edit/<?php echo $b?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                     <?php 
                     if($data->posisi == "utama_1" || $data->posisi == "utama_2" || $data->posisi == "utama_3" || $data->posisi == "nav_promo" || $data->posisi == "login" || $data->posisi == "utama_4" || $data->posisi == "utama_5"){ }else {?>
                        <a href="<?php echo base_url()?>trueaccon2194/media_promosi/hapus/<?php echo $b ?>" class="btn btn-danger hapus"><i class="glyphicon glyphicon-remove"></i></a>
                      <?php }?>
                        <a href="<?php echo base_url()?>trueaccon2194/media_promosi/banner_perform/<?php echo $b ?>" class="btn btn-default cetak"><i class="glyphicon glyphicon-eye-open"></i></a>
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