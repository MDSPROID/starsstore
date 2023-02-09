 <link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
 <script type="text/javascript">
  $(document).ready( function () { 

    $('#datetimepicker1').datetimepicker({
      format: 'yyyy-MM-dd'
    });         
    $('#datetimepicker2').datetimepicker({
      format: 'yyyy-MM-dd'
    });  
  }); 
</script>
<div class="page-title">
  <h3>Edit Barang Masuk / Keluar
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
      <li><a href="<?php echo base_url('trueaccon2194/laporan_pengiriman')?>">Laporan Pengiriman</a></li>
      <li class="active">Edit Barang Masuk / Keluar</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-9">          
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <?php echo br(3);?>
      <?php echo form_open_multipart('trueaccon2194/inout/update_inout', array('id'=>'form_produk_add'));?>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
        <div id="general" class="tab-pane fade in active">
            <div class="row">
               <div class="col-md-12 input group">
                <label>Jenis : </label> <i style="color:red;">*</i>
                <select class="form-control cek_odv" name="jenis" id="jenis" required>
                  <option value="">--- Pilih ---</option>
                  <?php if($g['jenis'] == "masuk"){?>
                    <option value="masuk" selected>Masuk</option>
                    <option value="keluar">Keluar</option>
                  <?php }else{?>
                    <option value="masuk">Masuk</option>
                    <option value="keluar" selected>Keluar</option>
                  <?php }?>
                </select>
                <br>
              </div>
              <div class="col-md-12 input group ">
                <label>Tanggal : <i style="color:red;">*</i></label>
                <div id="datetimepicker1" class="input-append">
                    <input type="text" data-format="yyyy-MM-dd" name="tgl" class="form-control cek_tgl" placeholder="Tanggal" value="<?php echo $g['tanggal']?>" required>
                    <span class="add-on">
                      <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>   
                  </div>
                  <br>
                  <div class="col-md-12 hidden">
                    <ul>
                      <li>Jika Menginput Barang Masuk (Supply Stok) Isi tanggal invoicenya</li>
                      <li>Jika Menginput Barang Masuk Karena permintaan pesanan (stok ambil dari toko) input tanggal pesanan selesainya</li>
                    </ul>
                  </div>
              </div>
              <div class="col-md-12 input group">
                <label>No. Invoice (Surat) : <i style="color:red;">*</i></label>
                <input type="text" name="inv" class="form-control cek_tags" value="<?php echo $g['invoice']?>" placeholder="No. Invoice" required>
                <input type="hidden" name="idinout" value="<?php echo $g['invoice']?>">
                <br>
              </div>
              <?php 
              if($g['jenis'] == "masuk"){
                $hdn_pesanan = "";
              }else{
                $hdn_pesanan = "hidden";
              }
              $invxx = array();
              foreach($datainv as $k){
                $invxx[] = $k->inv;
              }
              $invx = implode(',',$invxx);
              ?>
              <div class="col-md-12 input group pesanan <?php echo $hdn_pesanan?>">
                <label>No. Invoice Pesanan : <i style="color:red;">*Beri tanda , (koma) jika lebih dari satu invoice</i></label>
                <input type="text" name="inv_pesanan" id="idpesanan" class="form-control" data-role="tagsinput" value="<?php echo $invx ?>" placeholder="No. Invoice Pesanan">
                <br>
              </div>
              <div class="col-md-12 input group">
                <label>Pasang : <i style="color:red;">*</i></label>
                <input type="number" name="pasang" class="form-control cek_nama" value="<?php echo $g['pasang']?>" placeholder="Pasang" required>
                <br>
              </div>
              <div class="col-md-12 input group">
                <label>Rupiah : <i style="color:red;">*</i></label>
                <div class="input-group">
                <span class="input-group-addon">Rp.</span>
                <input id="tarif" type="number" name="rupiah" class="form-control cek_retail" value="<?php echo $g['rupiah']?>" placeholder="Rupiah" required>
                </div>
                <br>
              </div>
              <?php if($g['jenis'] == "masuk"){?>
              <div class="col-md-12 input group dari">
                <label>Dari : <i style="color:red;">*</i></label>
                <input type="text" name="dari" class="form-control cek_slug dari_form" value="<?php echo $g['source']?>" placeholder="Dari">
                <br>
              </div>
              <div class="col-md-12 input group ke hidden">
                <label>Ke : <i style="color:red;">*</i></label>
                <input type="text" name="ke" class="form-control cek_artikel ke_form" placeholder="Ke">
                <br>
              </div>
              <?php }else{?>
              <div class="col-md-12 input group dari hidden">
                <label>Dari : <i style="color:red;">*</i></label>
                <input type="text" name="dari" class="form-control cek_slug dari_form" placeholder="Dari">
                <br>
              </div>
              <div class="col-md-12 input group ke">
                <label>Ke : <i style="color:red;">*</i></label>
                <input type="text" name="ke" class="form-control cek_artikel ke_form" value="<?php echo $g['source']?>" placeholder="Ke">
                <br>
              </div>
              <?php }?>
              <div class="col-md-12 input group">
                <label>Keterangan : <i style="color:red;">*</i></label>
                <input type="text" name="ket" class="form-control cek_berat" value="<?php echo $g['keterangan']?>" placeholder="Keterangan" required>
                <br>
              </div>
            </div>
        </div>
        <i style="color:red;">(*) wajib diisi</i>
  </div>
</div>
<div class="col-md-3">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
        <h5>Diubah oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
        <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
        <h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
        <button type="submit" class="simpan_review btn btn-success">Simpan</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<?php echo form_close();?>