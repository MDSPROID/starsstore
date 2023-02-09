<style type="text/css">
  .dropzone{
    border:2px dashed #9e9e9e;
  }
  .dropzone .dz-preview .dz-error-message{
    color: white;
  }
</style>

<script type="text/javascript">
  $(document).ready(function(){
    $('#datetimepicker3').datetimepicker({});
    $(".chkid").blur(function(){
        // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
        var Bs = window.location.origin + '/';
        var csrf = Cookies.get('mfh83ujd7oo');
        var psn = $(this).val();

        $.ajax({ // Send the credential values to another checker.php using Ajax in POST menthod
                type : "POST",
                url  : Bs + "checkpsn",
                data : {pesanan:psn},
            success: function(log){ // Get the result and asign to each cases
                if(log == "200"){
                    $(".info-error").html("Nomor pesanan tidak ditemukan");
                }else if(log == "405"){
                    $(".info-error").html("Nomor pesanan sudah dikonfirmasi");
                }else{
                    $(".info-error").html("");
                }
            }
        });
    });
  });
</script>
<script type="text/javascript">
$(function(){
  // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
  var baseURL = window.location.origin + '/';
  $('#seacrhid').autocomplete({
      serviceUrl: baseURL + 'trueaccon2194/order/searchidpesanan',
      onSelect: function (res) {
          $('.chkid').val(''+res.invoice); // membuat id 'v_jurusan' untuk ditampilkan
      }
  });
});
</script>
<div class="page-title">
  <h3><i class="glyphicon glyphicon-plus"></i> Edit Konfirmasi Pembayaran Manual (Khusus non E-commerce)</h3>
  <div class="page-breadcrumb">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('trueaccon2194/info_type_user_log')?>">Home</a></li>
      <li><a href="<?php echo base_url('trueaccon2194/order')?>">Order</a></li>
      <li class="active">Tambah Konfirmasi Pembayaran Manual</li>
    </ol>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/dUp/dropzone.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/dUp/basic.min.css');?>">
<script type="text/javascript" src="<?php echo base_url('assets/global/dUp/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/global/dUp/dropzone.min.js')?>"></script>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open_multipart('trueaccon2194/order/update_konfirmasi')?>
        <div class="col-md-9 m-t-lg" >
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                          <div class="col-xs-12 col-md-12">
                              <div class="woocommerce-message info-error" role="alert"><?php echo $this->session->flashdata('berhasil');?><?php echo $this->session->flashdata('error');?></div>
                          </div>
                          <div class="col-md-12 col-xs-12 re pldgbr">
                            <span class="jud">Bukti pembayaran <i style="color:red;">*</i></span>
                            <div class="dropzone">
                              <div class="dz-message">
                                <h3 class="txtgb"> Klik atau Drop bukti transfer anda disini<br>file maksimal 4 MB<br><span style="font-size: 12px;">file yang diijinkan : gif, jpg, jpeg, png</span></h3>
                                </div>
                              </div>
                            <i class="inf-ktp o"></i>
                            <ul class="list-unstyled" style="margin-top: 20px;">
                              <?php foreach($gb_bukti as $g){?>
                                <li id="gb_bukti<?php echo $x['token']?>"><img onclick="hapus_gambar_bukti_konfirm(this);" data-token="<?php echo $x['token']?>" data-src="<?php echo $g->gambar?>" src="<?php echo $g->gambar?>" class="img_hover" style="height: 250px;"></li>
                              <?php }?>
                            </ul>
                          </div>
                          <div class="sd" style="display: block;">
                            <div class="col-md-12 col-xs-12">
                              <h3>Isi Data Dibawah</h3>
                            </div>
                              <input type="hidden" name="sku_m" class="sku_m" value="<?php echo $x['identity_pembayaran']?>">
                              <input type="hidden" name="kIns" class="kIns" value="<?php $a = $this->encrypt->encode('KntJs628%243@729&2!46'); $b = base64_encode($a); echo $b?>">
                              <div class="col-md-12 col-xs-12 re">
                                <span class="jud">ID Pesanan <i style="color:red;">*</i></span>
                                <input type="text" name="id_pesanan" class="form-control list-form na chkid" id="seacrhid" value="<?php echo $x['id_pesanan']?>" required>
                              </div>
                              <div class="col-md-12 col-xs-12 re" style="display: none;">
                                <span class="jud">Nama Pemilik Rekening <i style="color:red;">*</i></span>
                                <input type="text" name="nama" class="form-control list-form na" value="<?php echo $x['nama']?>">
                                <i class="inf-n o"></i>
                              </div>
                              <div class="col-md-12 col-xs-12 re" style="display: none;">
                                <span class="jud">Email </span>
                                <input type="text" name="email" value="<?php echo $x['email']?>" class="form-control list-form em">
                                <i class="inf-e o"></i>
                              </div>
                              <div class="col-md-12 col-xs-12 re" style="display: none;">
                                <span class="jud">Bank <i style="color:red;">*</i></span>
                                <select name="bank" class="form-control ktP list-form">
                                  <option value="">pilih</option>
                                  <?php 
                                    foreach($bank as $k){
                                      $name = base64_encode($k->name_bank);
                                      $no = base64_encode($k->no_rek);

                                      $nmbnk = $k->name_bank;
                                      $nrbnk = $k->no_rek;

                                      $gbg = $nmbnk.' - '.$nrbnk;
                                      if($x['bank'] == $gbg){
                                  ?>
                                    <option value="<?php echo $name;?>|<?php echo $no?>" selected><?php echo $k->name_bank ?> [<?php echo $k->no_rek?>]</option>
                                  <?php  }else{?>
                                    <option value="<?php echo $name;?>|<?php echo $no?>"><?php echo $k->name_bank ?> [<?php echo $k->no_rek?>]</option>
                                  <?php }}?>  
                                </select>
                                <i class="inf-k o"></i>
                              </div>
                              <div class="col-md-12 col-xs-12 re">
                                <span class="jud">Nilai Transfer <i style="color:red;">*</i></span>
                                <input type="number" name="nominal" value="<?php echo $x['nominal']?>" class="form-control list-form em" required>
                                <i class="inf-l o"></i>
                              </div>
                              <div class="col-md-12 col-xs-12 input group">
                              <span class="jud">Tanggal :<i style="color:red;">*</i></span>
                                <div id="datetimepicker3" class="input-append">
                                  <input type="text" data-format="yyyy-MM-dd" name="tgl_transfer" value="<?php echo $x['tgl']?>" class="form-control list-form cek_tgl" required>
                                  <span class="add-on">
                                    <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                  </span>   
                                </div>
                              <br>
                            </div>
                              <div class="col-md-12 col-xs-12 re">
                                <span class="jud">Catatan</span>
                                <textarea name="catatan" class="form-control klh" rows="8" cols="5"><?php echo $x['catatan']?></textarea>
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
          <h5>Diubah oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
          <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
          <h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Update Data</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/druploadforkonfirmadmin.js');?>"></script>
<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>