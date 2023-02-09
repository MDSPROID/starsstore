<style type="text/css">
  .cityfree li{
    background-color: #e8e8e8;
    margin-bottom: 5px;
    padding: 5px;
  }
</style>
<div class="page-title"> 
  <h3><i class="glyphicon glyphicon-comment"></i> Free Ongkir Kota
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
      <li><a href="<?php echo base_url('trueaccon2194/alat_promosi/')?>">Alat Promosi</a></li>
      <li>Free Ongkir Kota</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="<?php echo base_url('trueaccon2194/alat_promosi');?>"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
        <div class="col-md-9 m-t-lg" >
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <?php 
                            $r = free_ongkir_all_city();
                            if($r['aktif'] == ""){
                              $lock = "";
                            }else{
                              $lock = "disabled";
                            }?>
                            <div class="col-md-4 col-xs-12">
                              <div class="form-group">
                                <label>Provinsi</label>
                                <select class="form-control propKey" <?php echo $lock?> name="propinsi_tujuan" id="propinsi_tujuan" required>
                                  <option value="">Pilih Provinsi</option>
                                  <?php $this->load->view('rajaongkir/getProvince'); ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Kota</label>
                                <select name="kota" id="destination" <?php echo $lock?> class="citKey form-control" placeholder="Kota" required>
                                  <option value="">Pilih Kota</option>
                                </select>
                              </div>
                              <button class="btn btn-success simpankotafreeongkir" <?php echo $lock?>>Simpan Kota</button>
                              <br><br>
                            </div>
                            <div class="col-md-8 col-xs-12">
                              <label><b>Daftar Kota Free Ongkir</b></label>
                              <div class="kotafreeongkir">
                                <?php 
                                $no = 0;
                                echo "<ul class='list-unstyled cityfree'>";
                                foreach($freeongkir as $y){
                                  $no++;
                                  echo '<li><b>'.$no.'. '.$y->kota.'</b><a class="pull-right" href="javascript:void(0);" onclick="hapus_kota_freeongkir(this)" data-id="'.$y->id_kota.'"><i class="glyphicon glyphicon-trash"></i></a></li>';
                                }
                                echo "</ul>";
                                ?>
                              </div>
                              <br><br>
                            </div>
                            <div class="col-md-12">
                                <label><b>Free ongkirkan semua kota :</b></label>
                                <?php 
                                $r = free_ongkir_all_city();
                                if($r['aktif'] == ""){
                                  $status = "";
                                }else{
                                  $status = "checked";
                                }?>
                                <div class="ios-switch switch-lg">
                                    <input type="checkbox" name="status" id="cekseting" class="js-switch pull-right fixed-header-check statusfreeongkir" <?php echo $status?>>
                                </div>
                                <br>
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
      </div>
      </div>
  </div>
</div>
</div>