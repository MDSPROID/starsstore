<div class="page-title">
  <h3><i class="glyphicon glyphicon-user"></i> Tambah User 
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
      <li><a href="<?php echo base_url('trueaccon2194/user_preference')?>">User Management</a></li>
      <li class="active">Tambah User</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open_multipart('trueaccon2194/user_preference/update_user')?>
        <div class="col-md-9 m-t-lg" >
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Avatar :<i style="color:red;">*</i></label><br>
                              <img src="<?php echo base_url('assets/images/user/'.$g['gb_user'].'')?>" width="100">
                              <input type="file" name="avatar" class="form-control cek_tags" id="gambar_utama" placeholder="Gambar">
                              <input type="hidden" name="gb" class="form-control" value="<?php echo $g['gb_user']?>">
                              <input type="hidden" name="is" class="form-control" value="<?php $a = $this->encrypt->encode($g['id']);
    $b = base64_encode($a); echo $b?>">
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Nama :<i style="color:red;">*</i></label>
                                <input type="text" name="nama" class="form-control cek_stat" value="<?php echo $g['nama_depan']?>" placeholder="Nama" required>
                              <br>
                            </div>
                            <div class="col-md-6 input group">
                              <label>Email :</label>
                              <input type="email" name="email" class="form-control cek_kota" value="<?php echo $g['email']?>" id="retail" placeholder="Email" required>
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Akses :<i style="color:red;">*</i></label>
                              <select name="jenis_akses" class="form-control cek_odv" required>
                                <option value="">-- pilih --</option>
                                <?php if($g['akses'] == "G7)*#_fsRe"){?>
                                <option selected value="Administrator">Administrator</option>
                                <option value="Finance">Finance</option>
                                <option value="Sales">Sales</option>
                                <option value="Support">Support</option>
                                <option value="Writer">Writer</option>
                                <?php }else if($g['akses'] == "FnC%4%7d8B"){?>
                                <option value="Administrator">Administrator</option>
                                <option selected value="Finance">Finance</option>
                                <option value="Sales">Sales</option>
                                <option value="Support">Support</option>
                                <option value="Writer">Writer</option>
                                <?php }else if($g['akses'] == "pG5Y$7(#1@"){?>
                                <option value="Administrator">Administrator</option>
                                <option value="Finance">Finance</option>
                                <option value="Sales">Sales</option>
                                <option selected value="Support">Support</option>
                                <option value="Writer">Writer</option>
                                <?php }else if($g['akses'] == "WrTd3*6)^@"){?>
                                <option value="Administrator">Administrator</option>
                                <option value="Finance">Finance</option>
                                <option value="Sales">Sales</option>
                                <option value="Support">Support</option>
                                <option selected value="Writer">Writer</option>
                                <?php }else if($g['akses'] == "S_lf63*%@)"){?>
                                <option value="Administrator">Administrator</option>
                                <option value="Finance">Finance</option>
                                <option selected value="Sales">Sales</option>
                                <option value="Support">Support</option>
                                <option value="Writer">Writer</option>
                                <?php }?>
                              </select>
                              <br>
                            </div>
                            <div class="col-md-12 input group">
                              <label>Username :</label>
                              <input type="text" name="user" value="<?php echo $g['username']?>" class="form-control cek_retail nm" id="user" placeholder="Username" required>
                              <div id="al" style="color: red;"></div>
                              <br>
                            </div>
                           <div class="col-md-6 input group">
                              <label>Password : </label> <i style="color:red;">*</i>
                              <input type="password" name="pass1" class="form-control cek_pass1" id="pass1" placeholder="Password">
                              <div id="notif1"></div>
                              <br>
                              <br>
                            </div>
                            <div class="col-md-6 input group">
                              <label>Masukkan Password : </label> <i style="color:red;">*</i>
                              <input type="password" name="pass2" class="form-control cek_pass2" id="pass2" placeholder="Masukkan Password yang sama">
                              <div id="notif"></div>
                              <br>
                              <br>
                            </div>
                            <div class="col-md-12 col-xs-12">
                              <label>Hak akses Menu :</label>
                              <?php echo br(2)?>
                              <div class="row">
                                <div class="col-md-3 col-xs-12">
                                <label><b>Marketplace</b></label>
                                  <ul class="list-unstyled">
                                    <li><label><input type="checkbox" name="akses[]" value="ymarket" <?php echo $ymarket1;?>> Marketplace</label></li>
                                  </ul>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                <label><input type="checkbox" id="ymail" name="akses[]" value="ymail" <?php echo $ymail1;?>> <b>E-Mail</b></label>
                                  <ul class="list-unstyled">
                                    <li><label><input type="checkbox" class="yinbox" name="akses[]" value="yinbox" <?php echo $yinbox1?>> Inbox</label></li>
                                    <li><label><input type="checkbox" class="ywrite" name="akses[]" value="ywrite" <?php echo $ywrite1?>> Tulis Pesan</label></li>
                                  </ul>
                                </div>
                                 <div class="col-md-3 col-xs-12">
                                <label><input type="checkbox" id="ycustomer" name="akses[]" value="ycustomer" <?php echo $ycustomer1?>> <b>Customer</b></label>
                                  <ul class="list-unstyled">
                                    <li><label><input type="checkbox" class="ydatacustomer" name="akses[]" value="ydatacustomer" <?php echo $ydatacustomer1?>> Data Customer</label></li>
                                    <li><label><input type="checkbox" class="ypointcustomer" name="akses[]" value="ypointcustomer" <?php echo $ypointcustomer1?>> Point Customer</label></li>
                                  </ul>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                <label><input type="checkbox" name="akses[]" id="ysales" value="ysales" <?php echo $ysales1?>> <b>Sales</b></label>
                                  <ul class="list-unstyled">
                                    <li><label><input type="checkbox" name="akses[]" class="ybestseller" value="ybestseller" <?php echo $ybestseller1?>> Best Seller</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yorder" value="yorder" <?php echo $yorder1?>> Order & Konfirmasi</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yretur" value="yretur" <?php echo $yretur1?>> Retur</label></li>
                                  </ul>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                <label><input type="checkbox" name="akses[]" id="ylaporan" value="ylaporan" <?php echo $ylaporan1?>> <b>Laporan</b></label>
                                  <ul class="list-unstyled">
                                    <li><label><input type="checkbox" name="akses[]" class="yorderlap" value="yorderlap" <?php echo $yorderlap1?>> Order</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yrpp" value="yrpp" <?php echo $yrpp1?>> RPP / RPK</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yinout" value="yinout" <?php echo $yinout1?>> Barang Masuk & Keluar</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yutang" value="yutang" <?php echo $yutang1?>> Laporan Hutang & Piutang</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="ypengiriman" value="ypengiriman" <?php echo $ypengiriman1?>> Pengiriman</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yreturlap" value="yreturlap" <?php echo $yreturlap1?>> Retur</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yvoucherlap" value="yvoucherlap" <?php echo $yvoucherlap1?>> Voucher</label></li>
                                  </ul>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                <label><input type="checkbox" name="akses[]" id="ypromosi" value="ypromosi" <?php echo $ypromosi1?>> <b>Promosi</b></label>
                                  <ul class="list-unstyled">
                                    <li style="display: none;"><label><input type="checkbox" name="akses[]" class="yvouandcou" value="yvouandcou" <?php echo $yvouandcou1?>> Voucher & Kupon</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="ypromoslideutama" value="ypromoslideutama" <?php echo $ypromoslideutama1?>> Alat Promosi</label></li>
                                    <li style="display: none;"><label><input type="checkbox" name="akses[]" class="ybannerslider" value="ybannerslider" <?php echo $ybannerslider1?>> Banner & Slider</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="ygallery" value="ygallery" <?php echo $ygallery1?>> Gallery</label></li>
                                  </ul>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                <label><input type="checkbox" name="akses[]" id="ysistem" value="ysistem" <?php echo $ysistem1?>> <b>Sistem</b></label>
                                  <ul class="list-unstyled">
                                    <li><label><input type="checkbox" name="akses[]" class="ysetting" value="ysetting" <?php echo $ysetting1?>> Setting</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yuser" value="yuser" <?php echo $yuser1?>> User</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yuseractivity" value="yuseractivity" <?php echo $yuseractivity1?>> User Activity</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="ybackuprestore" value="ybackuprestore" <?php echo $ybackuprestore1?>> Backup & Restore</label></li>
                                  </ul>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                <label><input type="checkbox" name="akses[]" id="yproduk" value="yproduk" <?php echo $yproduk1?>> <b>Produk</b></label>
                                  <ul class="list-unstyled">
                                    <li><label><input type="checkbox" name="akses[]" class="ydafpro" value="ydafpro" <?php echo $ydafpro1?>> Daftar Produk</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="ymaster" value="ymaster" <?php echo $ymaster1?>> Master Barang</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="ykatparkat" value="ykatparkat" <?php echo $ykatparkat1?>> Kategori & Parent</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="ykatdiv" value="ykatdiv" <?php echo $ykatdiv1?>> Kategori Divisi</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yopsipro" value="yopsipro" <?php echo $yopsipro1?>> Opsional Produk</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="ymerk" value="ymerk" <?php echo $ymerk1?>> Merk</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="ystok" value="ystok" <?php echo $ystok1?>> Stok</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yrevpro" value="yrevpro" <?php echo $yrevpro1?>> Review dan Q&A Produk</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yprobeli" value="yprobeli" <?php echo $yprobeli1?>> Produk Dibeli</label></li>
                                    <li><label><input type="checkbox" name="akses[]" class="yproview" value="yproview" <?php echo $yproview1?>> Produk Dilihat</label></li>
                                  </ul>
                                </div>
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
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Simpan User</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>