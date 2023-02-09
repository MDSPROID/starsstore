<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/dropzone.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/basic.min.css');?>">
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/druploadforlabelpengirimanmarketplace.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/dUp/dropzone.min.js')?>"></script>
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
        $('.sender').val(''+res.kode_toko); // membuat id 'v_jurusan' untuk ditampilkan
      }
  });
});
</script>
<div class="page-title">
  <h3>Edit Manual Order
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
      <li><a class="active">Edit Manual Order</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12 col-xs-12">      
      <?php echo form_open('trueaccon2194/online_store/update_manual_order', array('id'=>'form_produk_add'));?>
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
                <input type="text" style="text-transform: uppercase;" <?php //if($d['buy_in'] == "E-commerce"){echo"readonly";}?> name="invoice" readonly class="form-control cek_inv" id="inv1" value="<?php echo $d['invoice']?>" placeholder="Invoice" required>
              <input type="hidden" id="inv" name="invoice1" value="<?php echo $d['invoice'];?>">
                <br>
              </div>
              <div class="col-md-6 input group">
                <label> Nama Lengkap : <i style="color:red;">*</i></label>
                <input type="text" name="nama" class="form-control cek_nama" id="nama" value="<?php echo $d['nama_lengkap']?>" placeholder="Nama customer" required>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Email : </label>
                <input type="email" name="email" class="form-control cek_email" id="slug" value="<?php echo $d['email']?>" placeholder="Email customer">
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>No. Telp : <i style="color:red;">*</i></label>
                <input type="number" name="telp" class="form-control cek_telp" id="telp" value="<?php echo $d['no_telp']?>" placeholder="Telp customer" required>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Marketplace : <i style="color:red;">*</i></label>
                <select name="ecommerce" class="form-control cek_ecom" required>
                  <option value="">-- pilih --</option>
                  <?php 
                    foreach($market as $m){
                    if($d['buy_in'] == $m->val_market){
                  ?>
                    <option selected value="<?php echo $m->val_market?>"><?php echo $m->market?></option>
                  <?php }else{?>
                    <option value="<?php echo $m->val_market?>"><?php echo $m->market?></option>
                  <?php }}?>
                </select>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label> Status Order : <i style="color:red;">*</i></label>
                <select class="form-control cek_stat" name="status" id="status" required>
                  <option value="">-- pilih --</option>
                  <?php if($d['status'] == "2hd8jPl613!2_^5"){?>
                    <option value="2hd8jPl613!2_^5" selected>Menunggu Pembayaran</option>
                    <option value="*^56t38H53gbb^%$0-_-">Pembayaran Diterima</option>
                    <option value="Uywy%u3bShi)payDhal">Dalam Pengiriman</option>
                    <option value="ScUuses8625(62427^#&9531(73">Diterima</option>
                    <option value="batal">Dibatalkan</option>
                  <?php }else if($d['status'] == "*^56t38H53gbb^%$0-_-"){?>
                    <option value="2hd8jPl613!2_^5">Menunggu Pembayaran</option>
                    <option value="*^56t38H53gbb^%$0-_-" selected>Pembayaran Diterima</option>
                    <option value="Uywy%u3bShi)payDhal">Dalam Pengiriman</option>
                    <option value="ScUuses8625(62427^#&9531(73">Diterima</option>
                    <option value="batal">Dibatalkan</option>
                  <?php }else if($d['status'] == "Uywy%u3bShi)payDhal"){?>
                    <option value="2hd8jPl613!2_^5">Menunggu Pembayaran</option>
                    <option value="*^56t38H53gbb^%$0-_-">Pembayaran Diterima</option>
                    <option value="Uywy%u3bShi)payDhal" selected>Dalam Pengiriman</option>
                    <option value="ScUuses8625(62427^#&9531(73">Diterima</option>
                    <option value="batal">Dibatalkan</option>
                  <?php }else if($d['status'] == "ScUuses8625(62427^#&9531(73"){?>
                    <option value="2hd8jPl613!2_^5">Menunggu Pembayaran</option>
                    <option value="*^56t38H53gbb^%$0-_-">Pembayaran Diterima</option>
                    <option value="Uywy%u3bShi)payDhal">Dalam Pengiriman</option>
                    <option value="ScUuses8625(62427^#&9531(73" selected>Diterima</option>
                    <option value="batal">Dibatalkan</option>
                  <?php }else if($d['status'] == "batal"){?>
                    <option value="2hd8jPl613!2_^5">Menunggu Pembayaran</option>
                    <option value="*^56t38H53gbb^%$0-_-">Pembayaran Diterima</option>
                    <option value="Uywy%u3bShi)payDhal">Dalam Pengiriman</option>
                    <option value="ScUuses8625(62427^#&9531(73">Diterima</option>
                    <option value="batal" selected>Dibatalkan</option>
                  <?php }?>
                </select>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Catatan Pembelian :</label>
                <input type="text" name="note" class="form-control" id="note" value="<?php echo $d['catatan_pembelian']?>" placeholder="catatan pembelian">
                <br>
              </div>
              <div class="col-md-6 input group ">
                <label>Tanggal Order : <i style="color:red;">*</i></label>
                <div id="datetimepicker" class="input-append">
                  <input type="text" data-format="yyyy-MM-dd HH:mm:ss" name="tgl_order" class="form-control cek_tgl" value="<?php echo $d['tanggal_waktu_order']?>" placeholder="Tanggal Order" required>
                  <span class="add-on">
                    <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                  </span>   
                </div>
                <br>
              </div>
              <div class="col-md-6 input group ">
                <label>Tanggal Selesai : <i style="color:red;">*</i></label>
                <div id="datetimepicker2" class="input-append">
                  <input type="text" data-format="yyyy-MM-dd HH:mm:ss" name="tgl_selesai" class="form-control" value="<?php echo $d['tanggal_waktu_order_finish']?>" placeholder="Tanggal Selesai">
                  <span class="add-on">
                    <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                  </span>   
                </div>
                <br>
              </div>
              <div class="col-md-6 input group">
                <label>Sudah dibayar Marketplace? :</label>
                <select name="dibayar" class="form-control">
                  <?php if($d['dibayar'] == "bayar"){?>
                    <option value="belum">Belum dibayar</option>
                    <option selected value="bayar">Sudah dibayar</option>
                  <?php }else{?>
                    <option selected value="belum">Belum dibayar</option>
                    <option value="bayar">Sudah dibayar</option>
                  <?php }?>
                </select>
                <br>
              </div> 
            </div>
            <div class="col-md-6 col-xs-12">
              <h4>Input Manual Order</h4>
              <p style="text-align: justify;">Ketika ada penjualan dari E-commerce seperti bukalapak, tokopedia, shoppe, dll masukkan ke dalam inputan ini. meliputi info customer, produk yang dibeli, pengiriman dan metode pembayaran yang dipilih.</p>
            </div>
          </div>
      </div>
    <div id="produk" class="tab-pane fade">
    <?php echo br()?>  
    <div class="row">  
      <div class="col-md-8 col-xs-12">
        <div id="simple-clone" class="row">
          <?php foreach($produk as $p){?>
            <div class="col-md-12 col-xs-12" id="ro-produk">
                <a href="javascript:void(0);" id="btn-del" onclick="delete_produk_edit_marketplace()" data-id="<?php echo $p->idpr_order?>" class="btn btn-danger">Hapus Produk</a>
                <?php echo br(2)?>
                <fieldset class="field-fix">
                <legend class="leg-fix">Produk</legend>
                  <div class="col-md-4 col-xs-6" id="artikel1">
                    <label>Artikel : <i style="color:red;">*</i></label>
                    <input type="text" style="text-transform: uppercase;" name="artikel[]" value="<?php echo $p->artikel?>" class="seacrhart form-control cek_artikel" placeholder="Artikel" required>
                    <br>
                  </div>
                  <div class="col-md-4 col-xs-6" id="size1">
                    <label>Size : <i style="color:red;">*</i></label>
                    <select class="form-control" name="size[]" id="sizing" required>
                        <option value="">-- pilih --</option>
                    <?php foreach($get_data_sizex_all as $datac){
                      if($datac['opsi_size'] == "-"){
                    ?>
                      <option value="-" SELECTED>-</option>
                      <?php }else if($datac['opsi_size'] == $p->ukuran){?>
                        <option value="<?php echo $datac['opsi_size']?>" SELECTED><?php echo $datac['opsi_size']?></option>
                      <?php }else{?>
                        <option value="<?php echo $datac['opsi_size']?>"><?php echo $datac['opsi_size']?></option>
                      <?php }?>
                    <?php }?>
                    </select>
                    <br>
                  </div>
                  <div class="col-md-4 col-xs-6" id="color1">
                    <label>Warna : <i style="color:red;">*</i></label>
                    <select class="form-control" name="color[]" id="sizing" required>
                        <option value="">-- pilih --</option>
                    <?php foreach($get_data_colorx_all as $datax){
                     if($datax['warna'] == "-"){
                    ?>
                      <option value="-" SELECTED>-</option>
                      <?php }else if($datax['opsi_color'] == $p->warna){?>
                        <option value="<?php echo $datax['opsi_color']?>" SELECTED><?php echo $datax['opsi_color']?></option>
                        <?php }else{?>
                        <option value="<?php echo $datax['opsi_color']?>"><?php echo $datax['opsi_color']?></option>
                    <?php }}?>
                    </select>
                    <br>
                  </div>
                  <div class="col-md-4 col-xs-6" id="qty1">
                    <label>Qty : <i style="color:red;">*</i></label>
                    <input type="text" name="qty[]" class="form-control cek_qty" value="<?php echo $p->qty?>" placeholder="Quantity" required>
                    <br>
                  </div>
                  <div class="col-md-4 col-xs-6" id="before1">
                    <label>Harga Dicoret: </label>
                    <div class="input-group">
                      <span class="input-group-addon">Rp.</span>
                      <input type="number" name="harga_before[]" style="text-decoration:line-through;" value="<?php echo $p->harga_before?>" class="form-control cek_diskon" placeholder="Harga dicoret">
                    </div>
                    <br>
                  </div>
                  <div class="col-md-4 col-xs-6" id="fix1">
                    <label>Harga Fix : <i style="color:red;">*</i></label>
                    <div class="input-group">
                      <span class="input-group-addon">Rp.</span>
                      <input type="number" name="harga_fix[]" class="form-control cek_retail" value="<?php echo $p->harga_fix?>" placeholder="Harga Fix retail" required>
                    </div>
                    <br>
                  </div>
                  </fieldset>
                  <?php echo br(2);?>
            </div>     
          <?php }?>
          <div class="col-md-12 col-xs-12">
            <div class="toclone">
              <a href="#" class="btn btn-success clone">Tambah Produk</a>
              <a href="#" class="btn btn-danger delete">Hapus Kolom</a>
              <?php echo br(2)?>
              <fieldset class="field-fix">
              <legend class="leg-fix">Produk</legend>
                <div class="col-md-4 col-xs-6">
                  <label>Artikel : <i style="color:red;">*</i></label>
                  <input type="text" style="text-transform: uppercase;" name="artikel[]" class="form-control cek_artikel" placeholder="Artikel">
                  <br>
                </div>
                <div class="col-md-4 col-xs-6">
                  <label>Size : <i style="color:red;">*</i></label>
                  <select class="form-control cek_size" name="size[]" id="size">
                      <option value="">-- pilih --</option>
                      <?php foreach($get_sizex as $data){ ?>
                      <option value="<?php echo $data->id_opsi_size;?>,<?php echo $data->opsi_size;?>"><?php echo $data->opsi_size;?></option>
                      <?php }?>
                  </select>
                  <br>
                </div>
                <div class="col-md-4 col-xs-6">
                  <label>Warna : <i style="color:red;">*</i></label>
                  <select class="form-control cek_color" name="color[]" id="color">
                      <option value="">-- pilih --</option>
                      <?php foreach($get_colorx as $data){ ?>
                      <option value="<?php echo $data->opsi_color;?>"><?php echo $data->opsi_color;?></option>
                      <?php }?>
                  </select>
                  <br>
                </div>
                <div class="col-md-4 col-xs-6">
                  <label>Qty : <i style="color:red;">*</i></label>
                  <input type="text" name="qty[]" class="form-control cek_qty" placeholder="Quantity">
                  <br>
                </div>
                <div class="col-md-4 col-xs-6">
                  <label>Harga Dicoret: </label>
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="number" name="harga_before[]" style="text-decoration:line-through;" value="" class="form-control cek_diskon" placeholder="Harga dicoret">
                  </div>
                  <br>
                </div>
                <div class="col-md-4 col-xs-6">
                  <label>Harga Fix : <i style="color:red;">*</i></label>
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="number" name="harga_fix[]" value="" class="form-control cek_retail" placeholder="Harga Fix retail">
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
              <h5>Harga Fix  <b style="margin-left: 25px;">:</b> <b class="fixed"></b></h5>
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
            <input type="text" name="alamat" class="form-control cek_alamat" value="<?php echo $d['alamat']?>" placeholder="Alamat lengkap" required>
            <br>
          </div>
          <div class="hidden col-md-6 col-xs-12">
            <span class="jud">Provinsi <i style="color:red;">*</i></span>
            <select class="form-control propKey cek_prop" name="propinsi_tujuan" id="propinsi_tujuan">
              <option value="0" selected="" disabled="">Pilih Provinsi</option>
              <?php $this->load->view('rajaongkir/getProvince'); ?>
            </select>
          </div>
          <div class="hidden col-md-6 col-xs-12">
            <span class="jud">Kota <i style="color:red;">*</i></span>
            <select class="form-control citKey cek_kota" name="destination" id="destination">
              <option value="0" selected="" disabled="">Pilih Kota</option>
            </select>
            <i style="font-size: 12px;">*jika nama kota tidak muncul pilih kembali provinsinya</i><br>
          </div>
          <div class="col-md-6 input group">
            <label>layanan : <i style="color:red;">*</i></label>
            <input type="text" name="layanan" style="text-transform: uppercase;" class="form-control cek_layanan" value="<?php echo $d['layanan']?>" placeholder="Layanan Pengiriman" required>
            <br>
          </div>
          <div class="hidden col-md-6 input group">
            <label>ETD : <i style="color:red;">*</i></label>
            <input type="text" name="etd" class="form-control cek_etd" placeholder="Estimasi Pengiriman">
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Tarif : <i style="color:red;">*</i></label>
              <div class="input-group">
                <span class="input-group-addon">Rp.</span>
                <input type="number" name="tarif" class="form-control cek_tarif" value="<?php echo $d['tarif']?>" placeholder="Tarif" required>
              </div>
          </div>
          <div class="col-md-6 input group">
            <label>No Resi : <i style="color:red;">*<?php if($d['buy_in'] == "E-commerce"){ echo "Edit dihalaman detail order"; }?></i></label>
            <?php if($d['buy_in'] == "E-commerce"){ ?>
              <input readonly="readonly" type="text" name="resi" class="form-control cek_odv" value="<?php echo $d['no_resi']?>" placeholder="Ubah dihalaman detail order">
            <?php }else{?>
              <input type="text" name="resi" class="form-control cek_odv" value="<?php echo $d['no_resi']?>" placeholder="No Resi">
            <?php }?>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Dikirim Oleh : <i style="color:red;">*</i></label>
                <input type="text" name="sender" class="form-control sender" id="sender" value="<?php echo $d['sender']?>" placeholder="Toko / Ecommerce">
                <b>TOKO : <?php echo $d['nama_toko']?></b>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Komisi Toko (Custom) : </label>
            <input type="number" name="komisi" class="form-control komisi" id="komisi" value="<?php echo $d['komisi_toko']?>" placeholder="Komisi Toko">
            <br>
          </div>
          <div class="col-md-12" style="margin: 20px 0;">
          <div class="dropzone">
            <div class="dz-message">
              <h3> Klik atau Drop dokumen label pengiriman dari marketplace <br>file maksimal 4 MB<br><span style="font-size: 12px;">file yang diijinkan : pdf, word</span></h3>
              </div>
          </div>
          <?php if($d['tokenlabel'] != ""){
            echo "Label Pengiriman : <a target='_new' style='font-size: 10px;' href='".$d['labelpengiriman']."'>Download Label Pengiriman</a>";
          }else{
            echo "Label pengiriman belum diupload";
          }?>
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
            <div class="col-md-6 input group">
              <label>Voucher / Kupon : </label>
                <input type="text" name="vouandcou" class="form-control cek_vouandcou" style="text-transform: uppercase;" value="<?php echo $d['voucher']?>" placeholder="Voucher / Kupon" >
              <br>
            </div>
            <div class="col-md-6 col-xs-12">
              <label>Metode Pembayaran : <i style="color:red;">*</i></label>
              <select class="form-control" name="metode_bayar">
                <option>-- pilih --</option>
                <?php if($d['jenis_pembayaran'] == "bca_bank_transfer"){?>
                  <option value="bca_bank_transfer" selected>BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
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
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "bni_bank_transfer"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer" selected>BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
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
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "mandiri_bank_transfer"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer" selected>Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
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
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "bri_bank_transfer"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer" selected>BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
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
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "saldo_marketplace"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace" selected>Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
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
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "virtual_account"){?>
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
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "bca_klikpay"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
                  <option value="bca_klikpay" selected>BCA Klikpay</option>
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
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "mandiri_clickpay"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
                  <option value="bca_klikpay">BCA Klikpay</option>
                  <option value="mandiri_clickpay" selected>Mandiri ClickPay</option>
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
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "mandiri_ecash"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
                  <option value="bca_klikpay">BCA Klikpay</option>
                  <option value="mandiri_clickpay">Mandiri ClickPay</option>
                  <option value="mandiri_ecash" selected=>Mandiri E-cash</option>
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
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "cimb_click"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
                  <option value="bca_klikpay">BCA Klikpay</option>
                  <option value="mandiri_clickpay">Mandiri ClickPay</option>
                  <option value="mandiri_ecash">Mandiri E-cash</option>
                  <option value="cimb_click" selected>CIMB Clicks</option>
                  <option value="indomaret">Indomaret</option>
                  <option value="alfamart">Alfamart</option>
                  <option value="alfamidi">Alfamidi</option>
                  <option value="visa">Visa</option>
                  <option value="master_card">Master Card</option>
                  <option value="jcb">JCB</option>
                  <option value="kredivo">Kredivo</option>
                  <option value="akulaku">Akulaku</option>
                  <option value="pos_indonesia">Pos Indonesia</option>
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "indomaret"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
                  <option value="bca_klikpay">BCA Klikpay</option>
                  <option value="mandiri_clickpay">Mandiri ClickPay</option>
                  <option value="mandiri_ecash">Mandiri E-cash</option>
                  <option value="cimb_click">CIMB Clicks</option>
                  <option value="indomaret" selected>Indomaret</option>
                  <option value="alfamart">Alfamart</option>
                  <option value="alfamidi">Alfamidi</option>
                  <option value="visa">Visa</option>
                  <option value="master_card">Master Card</option>
                  <option value="jcb">JCB</option>
                  <option value="kredivo">Kredivo</option>
                  <option value="akulaku">Akulaku</option>
                  <option value="pos_indonesia">Pos Indonesia</option>
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "alfamart"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
                  <option value="bca_klikpay">BCA Klikpay</option>
                  <option value="mandiri_clickpay">Mandiri ClickPay</option>
                  <option value="mandiri_ecash">Mandiri E-cash</option>
                  <option value="cimb_click">CIMB Clicks</option>
                  <option value="indomaret">Indomaret</option>
                  <option value="alfamart" selected>Alfamart</option>
                  <option value="alfamidi">Alfamidi</option>
                  <option value="visa">Visa</option>
                  <option value="master_card">Master Card</option>
                  <option value="jcb">JCB</option>
                  <option value="kredivo">Kredivo</option>
                  <option value="akulaku">Akulaku</option>
                  <option value="pos_indonesia">Pos Indonesia</option>
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "alfamidi"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
                  <option value="bca_klikpay">BCA Klikpay</option>
                  <option value="mandiri_clickpay">Mandiri ClickPay</option>
                  <option value="mandiri_ecash">Mandiri E-cash</option>
                  <option value="cimb_click">CIMB Clicks</option>
                  <option value="indomaret">Indomaret</option>
                  <option value="alfamart">Alfamart</option>
                  <option value="alfamidi" selected>Alfamidi</option>
                  <option value="visa">Visa</option>
                  <option value="master_card">Master Card</option>
                  <option value="jcb">JCB</option>
                  <option value="kredivo">Kredivo</option>
                  <option value="akulaku">Akulaku</option>
                  <option value="pos_indonesia">Pos Indonesia</option>
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "visa"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
                  <option value="bca_klikpay">BCA Klikpay</option>
                  <option value="mandiri_clickpay">Mandiri ClickPay</option>
                  <option value="mandiri_ecash">Mandiri E-cash</option>
                  <option value="cimb_click">CIMB Clicks</option>
                  <option value="indomaret">Indomaret</option>
                  <option value="alfamart">Alfamart</option>
                  <option value="alfamidi">Alfamidi</option>
                  <option value="visa" selected>Visa</option>
                  <option value="master_card">Master Card</option>
                  <option value="jcb">JCB</option>
                  <option value="kredivo">Kredivo</option>
                  <option value="akulaku">Akulaku</option>
                  <option value="pos_indonesia">Pos Indonesia</option>
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "master_card"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
                  <option value="bca_klikpay">BCA Klikpay</option>
                  <option value="mandiri_clickpay">Mandiri ClickPay</option>
                  <option value="mandiri_ecash">Mandiri E-cash</option>
                  <option value="cimb_click">CIMB Clicks</option>
                  <option value="indomaret">Indomaret</option>
                  <option value="alfamart">Alfamart</option>
                  <option value="alfamidi">Alfamidi</option>
                  <option value="visa">Visa</option>
                  <option value="master_card" selected>Master Card</option>
                  <option value="jcb">JCB</option>
                  <option value="kredivo">Kredivo</option>
                  <option value="akulaku">Akulaku</option>
                  <option value="pos_indonesia">Pos Indonesia</option>
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "jcb"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
                  <option value="bca_klikpay">BCA Klikpay</option>
                  <option value="mandiri_clickpay">Mandiri ClickPay</option>
                  <option value="mandiri_ecash">Mandiri E-cash</option>
                  <option value="cimb_click">CIMB Clicks</option>
                  <option value="indomaret">Indomaret</option>
                  <option value="alfamart">Alfamart</option>
                  <option value="alfamidi">Alfamidi</option>
                  <option value="visa">Visa</option>
                  <option value="master_card">Master Card</option>
                  <option value="jcb" selected>JCB</option>
                  <option value="kredivo">Kredivo</option>
                  <option value="akulaku">Akulaku</option>
                  <option value="pos_indonesia">Pos Indonesia</option>
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "kredivo"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
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
                  <option value="kredivo" selected>Kredivo</option>
                  <option value="akulaku">Akulaku</option>
                  <option value="pos_indonesia">Pos Indonesia</option>
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "akulaku"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
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
                  <option value="akulaku" selected>Akulaku</option>
                  <option value="pos_indonesia">Pos Indonesia</option>
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "pos_indonesia"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
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
                  <option value="pos_indonesia" selected>Pos Indonesia</option>
                  <option value="Bank Transfer">Bank Transfer (E-commerce)</option>
                <?php }else if($d['jenis_pembayaran'] == "Bank Transfer"){?>
                  <option value="bca_bank_transfer">BCA Bank Transfer</option>
                  <option value="bni_bank_transfer">BNI Bank Transfer</option>
                  <option value="mandiri_bank_transfer">Mandiri Bank Transfer</option>
                  <option value="bri_bank_transfer">BRI Bank Transfer</option>
                  <option value="saldo_marketplace">Saldo Marketplace</option>
                  <option value="virtual_account">Virtual Account</option>
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
                  <option value="Bank Transfer" selected>Bank Transfer (E-commerce)</option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="col-md-6 col-xs-12">
          <h4><i class="fa fa-credit-card"></i> Pembayaran</h4>
            <p style="text-align: justify;">Tab pembayaran ini dapat memilih metode pembayaran kartu kredit atau bank transfer dan pengaturan tentang voucher.</p>
          </div>
        </div>
      </div>
    <i style="color:red;">(*) wajib diisi<br>(*)Jika menambahkan kode voucher, total belanja tidak dihitung ulang</i>
  </div>
  </div>
  <?php echo form_close()?>
  </div><!-- Row -->
</div><!-- Main Wrapper -->
<script src="<?php echo base_url('assets/manage/js/cloneya/jquery-cloneya.js');?>"></script>
<script>
  $('#simple-clone').cloneya();
</script>