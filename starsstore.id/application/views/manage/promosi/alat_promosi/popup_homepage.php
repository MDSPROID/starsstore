<div class="page-title">
  <h3><i class="glyphicon glyphicon-comment"></i> Popup Homepage
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
      <li><a href="<?php echo base_url('trueaccon2194/alat_promosi')?>">Alat Promosi</a></li>
      <li>Popup Homepage</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="<?php echo base_url('trueaccon2194/alat_promosi');?>"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open('trueaccon2194/alat_promosi/simpan_settingpopup')?>
        <div class="col-md-9 m-t-lg" >
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <div class="col-md-6">
                              <label>Status Popup :</label>
                              <?php if($r['aktif'] == ""){
                                $status = "";
                              }else{
                                $status = "checked";
                              }?>
                              <div class="ios-switch switch-lg">
                                  <input type="checkbox" name="status" class="js-switch pull-right fixed-header-check" <?php echo $status?>>
                              </div>
                              <br>
                            </div>
                            <div class="col-md-12 col-xs-12 text-center">
                              <a href="javascript:void(0);" class="btn btn-default tipepopup" name="popupmode" style="font-weight: 700;margin-right: 10px;" data-title="newsletter">Newsletter Mode</>
                              <a href="javascript:void(0);" class="btn btn-default tipepopup" name="popupmode" style="font-weight: 700;" data-title="popup">Popup Mode</a>
                              <br><br>
                            </div>
                            <input type="hidden" name="tipepopup" class="tipepopupval">
                            <div class="newslettermode" style="display: none;">
                              <div class="col-md-6 col-xs-12 input group">
                                <label>Keterangan Atas : <i style="color:red;">*</i></label>
                                <textarea name="editor1" id="mytextarea"><?php echo $r['meta_desc']?></textarea>
                                <br>
                              </div>
                              <div class="col-md-6 col-xs-12 input group">
                                <label>Keterangan Bawah : <i style="color:red;">*</i></label>
                                <input type="text" name="keteranganbawah" value="<?php echo $r['meta_key']?>" class="form-control keteranganbawah">
                                <br>
                              </div>
                            </div>
                            <div class="popupmode" style="display: none;">
                              <div class="col-md-12  col-xs-12 input group">
                                <label>Gambar : <i style="color:red;">*</i></label><i style="color:red;"></i>
                                <div class="input-group">
                                <input type="text" name="gambar" value="<?php echo $r['site_title']?>" class="form-control" id="carfID">
                                <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
                                </span>
                                </div>
                                <br>
                              </div>
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
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Simpan Popup</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close();?>
</div>
</div>