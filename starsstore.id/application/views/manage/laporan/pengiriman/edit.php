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

  <h3>Edit Actual Ongkir

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

      <li class="active">Edit Actual Tarif</li>

    </ol>

  </div>

</div>

<div id="main-wrapper">

  <div class="row">

    <div class="col-md-9 col-xs-12">          

      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>

      <?php echo br(3);?> 

      <div class="row">
        <div class="col-md-6 col-xs-12" style="margin-bottom: 10px;">
            <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">

              <div id="general" class="tab-pane fade in active">
              <?php echo form_open_multipart('trueaccon2194/laporan_pengiriman/update_input_actual', array('id'=>'form_produk_add'));?>
                  <div class="row">
                    <div class="col-md-12"><h3 style="margin-top: 0;">Update Tarif Invoice</h3></div>
                    <div class="col-md-12 input group">

                      <label>Invoice : </label> <i style="color:red;">*</i>
                      <input readonly id="tarif" type="text" name="invoice" class="form-control cek_odv" id="retail" value="#<?php echo $g['invoice'];?> [<?php echo $g['buy_in']?>]" placeholder="Invoice" required>
                      <input type="hidden" name="idinv" value="<?php $id = $this->encrypt->encode($g['no_order_cus']); $idp = base64_encode($id); echo $idp ?>">
                      <br>
                    </div>

                    <div class="col-md-12 input group">

                      <label>Tarif Actual : <i style="color:red;">*</i></label>

                      <div class="input-group">

                      <span class="input-group-addon">Rp.</span>

                      <input id="tarif" type="number" name="tarif" class="form-control cek_retail" value="<?php echo $g['actual_tarif'];?>" id="retail" placeholder="Tarif" required>

                      </div>

                      <br>

                    </div>

                    <div class="col-md-12 input group">

                      <label>Ongkir dibayar oleh : <i style="color:red;">*</i></label>
                      <select name="dibayar" class="form-control">
                        <option value="">--- pilih ---</option>
                        <?php if($g['ongkir_ditanggung'] == "gratis"){?>
                          <option selected value="gratis">Gratis Ongkir</option>
                          <option value="kantor">Kantor</option>
                          <option value="toko">Toko</option>
                          <option value="dari_penjualan">Dipotong langsung dari penjualan</option>
                        <?php }else if($g['ongkir_ditanggung'] == "kantor"){?>
                          <option value="gratis">Gratis Ongkir</option>
                          <option selected value="kantor">Kantor</option>
                          <option value="toko">Toko</option>
                          <option value="dari_penjualan">Dipotong langsung dari penjualan</option>
                        <?php }else if($g['ongkir_ditanggung'] == "toko"){?>
                          <option value="gratis">Gratis Ongkir</option>
                          <option value="kantor">Kantor</option>
                          <option selected value="toko">Toko</option>
                          <option value="dari_penjualan">Dipotong langsung dari penjualan</option>
                        <?php }else if($g['ongkir_ditanggung'] == "dari_penjualan"){?>
                          <option value="gratis">Gratis Ongkir</option>
                          <option value="kantor">Kantor</option>
                          <option value="toko">Toko</option>
                          <option selected value="dari_penjualan">Dipotong langsung dari penjualan</option>
                        <?php }else if($g['ongkir_ditanggung'] == ""){?>
                          <option value="gratis">Gratis Ongkir</option>
                          <option value="kantor">Kantor</option>
                          <option value="toko">Toko</option>
                          <option value="dari_penjualan">Dipotong langsung dari penjualan</option>
                        <?php }?>
                      </select>
                      <br>
                    </div>
                  </div>
                  <button type="submit" class="simpan_review btn btn-success">Update</button><br><br>
              <?php echo form_close();?>
              </div>
              <i style="color:red;">(*) wajib diisi</i>
          </div>
        </div>
        
        <div class="col-md-6 col-xs-12" style="margin-bottom: 10px;">
            <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
              <div id="general" class="tab-pane fade in active">
              <?php echo form_open_multipart('trueaccon2194/laporan_pengiriman/proses_input_actual_massal', array('id'=>'form_produk_add'));?>
                  <div class="row">
                    <div class="col-md-12"><h3 style="margin-top: 0;">Input / Update Massal Per Marketplace</h3></div>
                    <div class="col-md-12 input group">
                      <label>Marketplace : </label> <i style="color:red;">*</i>
                      <select class="form-control cek_odv" name="market" required>
                        <option value="">-- pilih --</option>
                        <?php foreach($market as $gx){?>
                          <option value="<?php echo $gx->val_market?>"><?php echo $gx->market?></option>
                        <?php }?>
                      </select>
                      <br>
                    </div>

                    <div class="col-md-6 col-xs-12 input group ">
                      <label>Tanggal awal : <i style="color:red;">*</i></label>
                      <div id="datetimepicker1" class="input-append">
                          <input type="text" data-format="yyyy-MM-dd" name="tgl1" id="tgl1" class="form-control cek_tgl" placeholder="Tanggal awal" required>
                          <span class="add-on">
                            <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                          </span>   
                        </div>
                        <br>
                    </div>
                    <div class="col-md-6 col-xs-12 input group ">
                      <label>Tanggal akhir : <i style="color:red;">*</i></label>
                      <div id="datetimepicker2" class="input-append">
                          <input type="text" data-format="yyyy-MM-dd" name="tgl2" id="tgl2" class="form-control cek_tgl" placeholder="Tanggal akhir" required>
                          <span class="add-on">
                            <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                          </span>   
                        </div>
                        <br>
                    </div>

                    <div class="col-md-12 input group">

                      <label>Tarif Actual : <i style="color:red;">*</i></label>

                      <div class="input-group">

                      <span class="input-group-addon">Rp.</span>

                      <input id="tarif" type="number" name="tarif" class="form-control cek_retail" id="retail" placeholder="Tarif" required>

                      </div>

                      <br>

                    </div>

                    <div class="col-md-12 input group">

                      <label>Ongkir dibayar oleh : <i style="color:red;">*</i></label>

                      <select name="dibayar" class="form-control">

                        <option value="">--- pilih ---</option>

                        <option value="gratis">Gratis Ongkir</option>

                        <option value="kantor">Kantor</option>

                        <option value="toko">Toko</option>

                        <option value="dari_penjualan">Dipotong langsung dari penjualan</option>

                      </select>

                      <br>

                    </div>

                    <div class="col-md-12 input group " style="display: none">

                      <label>Tanggal Kirim : <i style="color:red;">*</i></label>

                      <div id="datetimepicker1" class="input-append">

                          <input type="text" data-format="yyyy-MM-dd" name="tgl" class="form-control cek_tgl" placeholder="Tanggal kirim">

                          <span class="add-on">

                            <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>

                          </span>   

                        </div>

                        <br>

                    </div>

                    <div class="col-md-12 input group " style="display: none">

                      <label>Telah dibayar Marketplace? : <i style="color:red;">*</i></label>

                      <select name="bayar" class="form-control">

                        <option value="sudah">Sudah</option>

                        <option value="belum">Belum</option>

                      </select>

                      <br>

                    </div>

                  </div>
                  <button type="submit" class="simpan_review btn btn-success">Update</button><br><br>
              <?php echo form_close();?>
              </div>

              <i style="color:red;">(*) wajib diisi</i>
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

        <h5>Tanggal    : <b><?php echo date('d M Y')?></b></h5>

    </div>

    </div>

</div>