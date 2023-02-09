<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/dropzone.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/basic.min.css');?>">
<script type="text/javascript">
$(function(){
  // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
  var baseURL = window.location.origin + '/';
  $('#datetimepicker').datetimepicker({});
  $('#datetimepicker2').datetimepicker({});
  $('.seacrhart').autocomplete({
      serviceUrl: baseURL + 'trueaccon2194/produk/searchart',
      onSelect: function (res) {
          $('#artikel').val(''+res.artikel);
      }
  }); 
  $('#sender').autocomplete({
      serviceUrl: baseURL + 'trueaccon2194/order/searchstore',
      onSelect: function (res) {
        $('.sender').val(''+res.kode_toko);
      }
  });
  $("#generate_invoice").click(function(){
    $.ajax({
            url  : baseURL + "trueaccon2194/order/generate_new_invoice",
            beforeSend: function(){
                $(".gn").text("GENERATE...");
            },
            success : function(inv){
                $(".gn").text("GENERATE NOMOR INVOICE");
                $("#inv").val(inv);
            }
        });
  });
});
</script>
<div class="page-title">
  <h3>Input Manual Order
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
      <li><a href="<?php echo base_url('trueaccon2194/online_store')?>">Market Place</a></li>
      <li><a class="active">Input Manual Order</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row"> 
      <div class="col-md-12 col-xs-12">      
      <?php echo form_open('trueaccon2194/online_store/tambah_manual_order', array('id'=>'form_produk_add'));?>
      <a class="btn btn-primary pull-left" style="margin-right: 15px;" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <button type="submit" class="btn btn-success pull-left" href=""><i class="glyphicon glyphicon-save"></i> Simpan</button>
      <?php echo br(3);?>
      <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#user"><i class="glyphicon glyphicon-user"></i> Info Customer</a></li>
          <li><a data-toggle="tab" href="#produk"><i class="glyphicon glyphicon-tag"></i> Produk</a></li>
          <li><a data-toggle="tab" href="#kirim"><i class="fa fa-truck"></i> Pengiriman</a></li>
          <li style="display: none;"><a data-toggle="tab" href="#bayar"><i class="fa fa-credit-card"></i> Pembayaran</a></li>
      </ul>
      <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
    <div id="user" class="tab-pane fade in active">
    <?php echo br(2)?>
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <div class="col-md-6 input group">
              <label>Invoice : <i style="color:red;">*</i></label>
              <input type="text" style="text-transform: uppercase;" name="invoice" class="form-control cek_inv" id="inv" placeholder="Invoice" required>
              <br>
            </div>
            <div class="col-md-6 input group">
              <label> Nama Lengkap : <i style="color:red;">*</i></label>
              <input type="text" name="nama" class="form-control cek_nama" id="nama" placeholder="Nama customer" required>
              <br>
            </div>
            <div class="col-md-6 input group">
              <label>Email : </label>
              <input type="email" name="email" class="form-control cek_email" id="slug" placeholder="Email customer">
              <br>
            </div>
            <div class="col-md-6 input group">
              <label>No. Telp : <i style="color:red;">*</i></label>
              <input type="number" name="telp" class="form-control cek_telp" id="telp" placeholder="Telp customer" required>
              <br>
            </div>
             <div class="col-md-6 input group">
              <label>Marketplace : <i style="color:red;">*</i></label>
              <select name="ecommerce" class="form-control cek_ecom" required>
                <option value="">-- pilih --</option>
                <?php foreach($market as $m){?>
                  <option value="<?php echo $m->val_market?>"><?php echo $m->market?></option>
                <?php }?>
              </select>
              <br>
            </div>
            <div class="col-md-6 input group">
              <label> Status Order : <i style="color:red;">*</i></label>
              <select class="form-control cek_stat" name="status" id="status" required>
                <option value="">-- pilih --</option>
                <option value="2hd8jPl613!2_^5">Menunggu Pembayaran</option>
                <option value="*^56t38H53gbb^%$0-_-">Pembayaran Diterima</option>
                <option value="Uywy%u3bShi)payDhal">Dalam Pengiriman</option>
                <option value="ScUuses8625(62427^#&9531(73">Diterima</option>
                <option value="batal">Dibatalkan</option>
              </select>
              <br>
            </div>
            <div class="col-md-6 input group">
              <label>Catatan Pembelian :</label>
              <input type="text" name="note" class="form-control" id="note" placeholder="catatan pembelian">
              <br>
            </div> 
            <div class="col-md-6 input group ">
              <label>Tanggal Order : <i style="color:red;">*</i></label>
              <div id="datetimepicker" class="input-append">
                <input type="text" data-format="yyyy-MM-dd HH:mm:ss" name="tgl_order" class="form-control cek_tgl" placeholder="Tanggal Order" required>
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
            <div class="col-md-6 input group ">
              <label>Tanggal Selesai : <i style="color:red;">*</i></label>
              <div id="datetimepicker2" class="input-append">
                <input type="text" data-format="yyyy-MM-dd HH:mm:ss" name="tgl_selesai" class="form-control" placeholder="Tanggal Selesai">
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
            <div class="col-md-6 input group">
              <label>Sudah dibayar Marketplace? :</label>
              <select name="dibayar" class="form-control">
                <option value="belum">Belum dibayar</option>
                <option value="bayar">Sudah dibayar</option>
              </select>
              <br>
            </div> 
          </div>
          <div class="col-md-6 col-xs-12">
            <h4>Input Manual Order</h4>
            <p style="text-align: justify;">Ketika ada penjualan dari E-commerce seperti bukalapak, tokopedia, shoppe, dll masukkan ke dalam inputan ini. meliputi info customer, produk yang dibeli, pengiriman dan metode pembayaran yang dipilih.</p>
            <label class="btn-large btn btn-primary gn" id="generate_invoice">GENERATE NOMOR INVOICE</label>
          </div>
        </div>
    </div>
    <div id="produk" class="tab-pane fade">
    <?php echo br(2)?>
    <div class="row">  
        <div class="col-md-8 col-xs-12">
        <div id="simple-clone" class="row">
          <div class="col-md-12 col-xs-12">
          <div class="toclone">
            <a href="#" class="btn btn-success clone">Tambah Produk</a>
            <a href="#" class="btn btn-danger delete">Hapus Kolom</a>
            <?php echo br(2)?>
            <fieldset class="field-fix">
            <legend class="leg-fix">Produk</legend>
              <div class="col-md-4 col-xs-6">
                <label>Artikel : <i style="color:red;">*</i></label>
                <input type="text" style="text-transform: uppercase;" name="artikel[]" class="form-control cek_artikel" placeholder="Artikel" required>
                <br>
              </div>
              <div class="col-md-4 col-xs-6">
                <label>Size : <i style="color:red;" class="size">*</i></label>
                <select class="form-control cek_size" name="size[]" id="size" required>
                    <option value="">-- pilih --</option>
                    <?php foreach($get_sizex as $data){ ?>
                    <option value="<?php echo $data->id_opsi_size?>,<?php echo $data->opsi_size?>"><?php echo $data->opsi_size;?></option>
                    <?php }?>
                </select>
                <br>
              </div>
              <div class="col-md-4 col-xs-6">
                <label>Warna : <i style="color:red;" class="color">*</i></label>
                <select class="form-control cek_color" name="color[]" id="color" required>
                    <option value="">-- pilih --</option>
                    <?php foreach($get_colorx as $data){ ?>
                    <option value="<?php echo $data->opsi_color;?>"><?php echo $data->opsi_color;?></option>
                    <?php }?>
                </select>
                <br>
              </div>
              <div class="col-md-4 col-xs-6">
                <label>Qty : <i style="color:red;">*</i></label>
                <input type="text" name="qty[]" class="form-control cek_qty" placeholder="Quantity" required>
                <br>
              </div>
              <div class="col-md-4 col-xs-6">
                <label>Harga Dicoret: </label> <i style="color: red;" class="harga"></i>
                <div class="input-group">
                  <span class="input-group-addon">Rp.</span>
                  <input type="number" name="harga_before[]" style="text-decoration:line-through;" class="form-control cek_diskon" placeholder="Harga dicoret">
                </div>
                <br>
              </div>
              <div class="col-md-4 col-xs-6">
                <label>Harga Fix : <i style="color:red;">*</i></label>
                <div class="input-group">
                  <span class="input-group-addon">Rp.</span>
                  <input type="number" name="harga_fix[]" class="form-control cek_retail" placeholder="Harga Fix retail" required>
                </div>
                <br>
              </div>
              </fieldset>
              <?php echo br(2);?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-xs-12">
          <div class="panel panel-primary" style="border-color:#d3d3d3;">
            <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Cek Harga</div>
            <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
              <input type="text" style="text-transform: uppercase;margin-top: 10px;" class="calcArt1 seacrhart form-control" id="artikel" placeholder="Artikel">
              <h5>Harga Retail  <b style="margin-left: 10px;">:</b> <b class="retail"></b></h5>
              <h5 style="display: none;">Harga Fix  <b style="margin-left: 25px;display: none;">:</b> <b class="fixed"></b></h5>
            </div>
          </div>
      </div>    
    </div>
    </div>
    <div id="kirim" class="tab-pane fade">
      <?php echo br(2)?>
      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="col-md-6 input group">
            <label>Alamat : <i style="color:red;">*</i></label>
            <input type="text" name="alamat" class="form-control cek_alamat" placeholder="Alamat lengkap" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>layanan : <i style="color:red;">*</i></label>
            <input type="text" name="layanan" style="text-transform: uppercase;" class="form-control cek_layanan" placeholder="Layanan Pengiriman" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Tarif : <i style="color:red;">*</i></label>
            <div class="input-group">
              <span class="input-group-addon">Rp.</span>
              <input type="number" name="tarif" class="form-control cek_tarif" value="0" placeholder="Tarif" required>
            </div>
          </div>
          <div class="col-md-6 input group">
            <label>No Resi : <i style="color:red;">*</i></label>
                <input type="text" name="resi" class="form-control cek_odv" value="0" placeholder="No Resi">
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Dikirim Oleh : <i style="color:red;">*</i></label>
                <input type="text" name="sender" class="form-control sender" id="sender" placeholder="Toko / Ecommerce">
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Komisi Toko (Custom) : </label>
            <input type="number" name="komisi" class="form-control komisi" id="komisi" placeholder="Komisi Toko">
            <br>
          </div>
          <div class="col-md-12" style="margin: 20px 0;">
          <div class="dropzone">
            <div class="dz-message">
              <h3> Upload dokumen label pengiriman dari marketplace bisa dilakukan di halaman depan dengan mengklik "nama logo dikolom pembelian melalui" atau juga bisa di menu edit invoice</h3>
              </div>
            </div>
          </div>
          <br>
        </div>
        <div class="col-md-6 col-xs-12">
            <h4><i class="fa fa-truck"></i> Pengiriman</h4>
            <p style="text-align: justify;">pada tab pengiriman ini akan memuat informasi tentang pengiriman, jika terdapat sebuah order yang telah meng apply voucher <b>"gratis ongkir"</b> isi nilai <b>"0"</b> pada kolom tarif.</p>
          </div>
      </div>
    </div>
    <div id="bayar" class="tab-pane fade hidden">
      <?php echo br(2)?>
      <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="hidden col-md-6 input group">
              <label>Total Order : <i style="color:red;">*</i></label>
                <div class="input-group">
                  <span class="input-group-addon">Rp.</span>
                  <input type="text" name="tot_order" class="form-control cek_tot_order" placeholder="Total Order">
                </div>
              <br>
            </div>
            <div class="hidden col-md-6 input group">
              <label>Kode Pembayaran : <i style="color:red;">*</i></label>
                <div class="input-group">
                  <span class="input-group-addon">Rp.</span>
                  <input type="text" name="paycode" class="form-control cek_paycode" placeholder="Kode Pembayaran">
                </div>
              <br>
            </div>
            <div class="col-md-6 input group">
              <label>Voucher / Kupon : </label>
                <input type="text" name="vouandcou" class="form-control cek_vouandcou" style="text-transform: uppercase;" placeholder="Voucher / Kupon" >
              <br>
            </div>
            <div class="hidden col-md-6 input group">
              <label>Aksi Voucher / Kupon : </label>
                <input type="text" name="actvoucou" class="form-control cek_actvoucou" placeholder="Aksi Voucher / Kupon" >
              <br>
            </div>
            <div class="hidden col-md-12 input group">
              <label>Tanggal Jatuh Tempo : <i style="color:red;">*</i></label>
              <div id="datetimepicker2" class="input-append">
                <input type="text" data-format="yyyy-MM-dd HH:mm:ss" name="exporder" class="dtpc gt form-control cek_exporder" placeholder="Tanggal Jatuh Tempo Order">
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
            <div class="col-md-6 col-xs-12">
              <label>Metode Pembayaran : <i style="color:red;">*</i></label>
              <select class="form-control" name="metode_bayar">
                <option>-- pilih --</option>
                <option value="bca_bank_transfer">BCA Bank Transfer</option>
                <option value="bni_bank_transfer">BNI Bank Transfer</option>
                <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                <option value="bri_bank_transfer">BRI Bank Transfer</option>
                <option value="saldo_marketplace">Saldo Marketplace</option>
                <option value="virtual_account" selected>Virtual Account</option>
                <option value="bca_klikpay">BCA Klikpay</option>
                <option value="mandiri_clickpay">Mandiri ClickPay</option>
                <option value="mandiri_ecash">Mandiri E-cash</option>
                <option value="cimb_click">CIMB Clicks</option>
                <option value="indomaret">Indomaret</option>
                <option value="alfamart">Alfamart</option>
                <option value="alfamidi">Alfamidi</option>
                <option value="visa">Visa</option>
                <option value="master_card">Master Card</option>
                <option value="jcb">JCB</option>
                <option value="kredivo">Kredivo</option>
                <option value="akulaku">Akulaku</option>
                <option value="pos_indonesia">Pos Indonesia</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 col-xs-12">
          <h4><i class="fa fa-credit-card"></i> Pembayaran</h4>
            <p style="text-align: justify;">Tab pembayaran ini dapat memilih metode pembayaran kartu kredit atau bank transfer dan pengaturan tentang voucher.</p>
          </div>
        </div>
      </div>
    <i style="color:red;">(*) wajib diisi</i>
  </div>
  </div>
  <?php echo form_close()?>
  </div><!-- Row -->
</div><!-- Main Wrapper -->
<script src="<?php echo base_url('assets/manage/js/cloneya/jquery-cloneya.js');?>"></script>
<script>
  $('#simple-clone').cloneya();
</script>