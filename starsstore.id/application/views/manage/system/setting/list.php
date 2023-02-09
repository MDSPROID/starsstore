<div class="page-title">
  <h3>Daftar Halaman
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
      <li><a href="<?php echo base_url('trueaccon2194/setting')?>">Setting</a></li>
      <li><a href="<?php echo base_url('trueaccon2194/setting/daftar_halaman')?>">Daftar Halaman</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
        <?php echo form_open_multipart('trueaccon2194/setting/delete_select', array('class' => 'input-group'));?>
        <a style="margin-right: 10px;" class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a> <button name="submit" class="btn btn-danger" style="margin-right: 10px;"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
      </div>
      <?php if(empty($list)){?>
      <div class="col-md-12">
        <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
          <div class="row">
            <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
          </div>
        </div>
      </div>
      <?php } else {?>
      <div class="col-md-12">  
        <div class="table-responsive">
        <table id="table_slider" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
          <thead>
              <tr style="background-color:#34425a;color:white;">
                  <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                  <th style="text-align:center;">Kategori</th>
                  <th style="text-align:center;">Judul</th>
                  <th style="text-align:center;">Meta Key</th>
                  <th style="text-align:center;">Meta Desc</th>
                  <th style="text-align:center;">Slug</th>
                  <th style="text-align:center;">Konten</th>
                  <th style="text-align:center;">Opsi</th>
              </tr>
          </thead>
          <tbody>
              <?php 
              foreach($list as $data):
              ?>
             <tr>
                <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_page;?>" /></td>
                <td style="text-align:center;"><?php echo $data->kategori;?></td>
                <td style="text-align:center;"><?php echo $data->judul;?></td>
                <td style="text-align:center;"><?php echo $data->meta_key;?></td>
                <td style="text-align:center;"><?php echo $data->meta_desc;?></td>
                <td style="text-align:center;"><?php echo $data->slug;?></td>
                <td style="text-align:center;"><?php echo $data->konten;?></td>
                <td style="text-align:center;">
                  <?php 
                  $a = $this->encrypt->encode($data->id_page);
                  $b = base64_encode($a);
                  ?>
                  <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/setting/edit_halaman/<?php echo $b?>" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/setting/hapus_halaman/<?php echo $b ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                </td>
            </tr>
           <?php 
          endforeach;?>
          </tbody>
        </table>
        </div>
      </div>
      <?php }?>
  </div>
</div>
