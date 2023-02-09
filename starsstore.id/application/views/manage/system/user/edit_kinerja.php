<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/dropzone.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/basic.min.css');?>">
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/dUp/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/drupload_kinerja.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/dUp/dropzone.min.js')?>"></script>
<style type="text/css">
  .dropzone{
    border:2px dashed #9e9e9e;
  }
  .dropzone .dz-preview .dz-error-message{
    color: white;
  }
</style>
<div class="page-title">
  <h3><i class="fa fa-bar-chart"></i> Edit Progres Kinerja
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
      <li><a href="<?php echo base_url('trueaccon2194/user_preference/progres_kinerja')?>">Progres Kinerja</a></li>
      <li class="active">Edi tKinerja</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open_multipart('trueaccon2194/user_preference/update_kinerja')?>
        <div class="col-md-9 m-t-lg" >
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Deksripsi Kerja Hari ini :<i style="color:red;">*</i></label>
                              <textarea name="description"><?php echo $g['deskripsi']?></textarea>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 re">
                              <span class="jud">File Pendukung (Gambar / Video / Dokumen) <i style="color:red;">*</i></span>
                              <div class="dropzone">
                                <div class="dz-message">
                                  <h3 class="txtgb"> Klik atau Drop gambar / dokumen anda disini<br>file maksimal 2 MB<br><span style="font-size: 12px;">file yang diijinkan : gif, jpg, png, pdf, doc, docx, xls, xlsx</span></h3>
                                  </div>
                                </div>
                              <i class="inf-ktp o"></i>
                            </div>
                            <div class="col-md-6 col-xs-12 re">
                              <ul class="list-unstyled list-inline">
                              <?php foreach($attach as $r){
                                $file_parts = pathinfo($r->file);
                              ?>
                                <?php if($file_parts['extension'] == "xls" || $file_parts['extension'] == "xlsx" || $file_parts['extension'] == "doc" || $file_parts['extension'] == "docx" || $file_parts['extension'] == "pdf"){?>
                                  <li id="file_dsc" class="re"><a href="javascript:void(0)" onclick="hapus_dokumen_kinerja(this)" data-id="<?php echo $r->token?>" data-src="<?php echo $r->file?>"><div style="border:1px solid #ccc; height: 80px;width: 100px;"><?php echo $r->file?></div></a>
                                  </li>
                                <?php }else{?>
                                  <li id="file_dsc" class="re"><img onclick="hapus_dokumen_kinerja(this)" data-id="<?php echo $r->token?>" data-src="<?php echo $r->file?>" class="img_hover" style="border:1px solid #ccc;" src="<?php echo base_url('assets/images/kinerja/'.$r->file.'')?>" height="80">
                                  </li>
                                <?php }?>
                              <?php }?>
                              </ul>
                            </div>
                        </div>                                        
                        <i style="color:red;">(*) Wajib diisi</i>
                    </div>
                </div>
            </div>
        </div>
  <div class="col-md-3 col-xs-12">
    <div class="panel panel-primary" style="border-color:#d3d3d3;">
        <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
        <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
          <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
          <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
          <h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
          <input type="hidden" name="cla" value="<?php $a = $this->encrypt->encode($g['id']);
    $b = base64_encode($a); echo $b?>">
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Update Kinerja</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>