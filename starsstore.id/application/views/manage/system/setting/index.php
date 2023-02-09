<div class="page-title">
  <h3>Setting
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
      <li class="active">Setting</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12 col-xs-12 notiflibur" style="display: none;">
        <div class="panel panel-default" style="box-shadow:0px 0px 8px 0px #bababa;">
          <div class="panel-heading">Info Libur</div>
          <div class="panel-body" style="padding-top: 15px;">
            <?php echo form_open('trueaccon2194/setting/simpan_dan_libur_on');?>
            <?php $get_data_set = toko_libur(); ?>
                <textarea name="notifPrei"><?php echo $get_data_set['konten'];?></textarea>
                <button class="btn btn-danger">Update</button>
            <?php echo form_close();?>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xs-12">
        <div class="panel panel-default" style="box-shadow:0px 0px 8px 0px #bababa;">
            <div class="panel-heading" style="height: 90px;">Setting Website 
              <div class="ios-switch switch-lg">
                <label>Mode Company Profile?</label>
                <?php 
                  $get_data_set = company_profile();
                  if($get_data_set['aktif'] == "on"){
                ?>
                  <input type="checkbox" name="modecomp" data-enggine="" onchange="company(this);" class="js-switch pull-right fixed-header-check" checked>
                <?php }else{?>
                  <input type="checkbox" name="modecomp" data-enggine="on" onchange="company(this);" class="js-switch pull-right fixed-header-check">
                <?php }?>
              </div>
              <div class="ios-switch switch-lg">
                  <label>Mode Libur</label>
                  <?php 
                    $get_data_set = toko_libur();
                    if($get_data_set['aktif'] == "on"){
                  ?>
                    <input type="checkbox" name="libur" data-enggine="" onchange="liburoff(this);" class="js-switch pull-right fixed-header-check" checked>
                  <?php }else{?>
                    <input type="checkbox" name="libur" data-enggine="on" onchange="liburon(this);" class="js-switch pull-right fixed-header-check">
                  <?php }?>
              </div>
            </div>
            <div class="panel-body" style="padding-top: 15px;">
            <?php
                $att=array(
                'class'=>'form-horizontal',
                );
                echo form_open_multipart("trueaccon2194/setting/update_setting",$att);
                ?>
                <div class="col-md-12 col-xs-12 input group">
                  <label>Logo :<i style="color:red;">*Maksimal 300KB, Uk: 1304x591px</i></label>
                  <img src="<?php echo base_url('assets/images/'.$logo.'');?>" width="100" class="img-responsive" style="margin: 10px 0;">
                  <input type="file" name="logo" class="form-control cek_email" id="gambar_utama">
                  <input type="hidden" name="logox" value="<?php echo $logo?>">
                  <input type="hidden" name="ilogo" value="<?php $a = $this->encrypt->encode($ilogo);$b = base64_encode($a); echo $b; ?>">
                  <input type="hidden" name="jwhkkk" value="<?php $a = $this->encrypt->encode('Hg9167!09^');$b = base64_encode($a); echo $b; ?>">
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group">
                  <label>Footer :<i style="color:red;">*</i></label>
                  <input type="text" name="footer" value="<?php echo $footer?>" class="form-control cek_telp" placeholder="Footer" required>
                  <input type="hidden" name="footerx" value="<?php echo $footer?>" required>
                   <input type="hidden" name="ifooter" value="<?php $a = $this->encrypt->encode($ifooter);$b = base64_encode($a); echo $b; ?>">
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group">
                  <label>Nama E-commerce :<i style="color:red;">*</i></label>
                  <input type="text" name="toko" value="<?php echo $toko?>" class="form-control cek_invp" placeholder="Nama Toko" required>
                  <input type="hidden" name="tokox" value="<?php echo $toko?>" required>
                   <input type="hidden" name="itoko" value="<?php $a = $this->encrypt->encode($itoko);$b = base64_encode($a); echo $b; ?>">
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group" style="display: none;">
                  <label>Deskripsi Toko :</label>
                  <textarea name="desc_toko"><?php echo $desc_toko?></textarea>
                  <input type="hidden" name="desc_tokox" value="<?php echo $desc_toko?>">
                  <input type="hidden" name="idesc_toko" value="<?php $a = $this->encrypt->encode($idesc_toko);$b = base64_encode($a); echo $b; ?>">
                </div>
                <div class="col-md-12 col-xs-12 input group">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
      </div>
      <div class="col-md-6 col-xs-12">
        <div class="panel panel-default" style="box-shadow:0px 0px 8px 0px #bababa;">
            <div class="panel-heading">Setting Email</div>
            <div class="panel-body" style="padding-top: 15px;">
            <?php
                $att=array(
                'class'=>'form-horizontal',
                );
                echo form_open("trueaccon2194/setting/update_email",$att);
                ?>
                <div class="col-md-12 col-xs-12 input group">
                  <label>Email Admin :<i style="color:red;">*isi satu email</i></label>
                  <input type="text" name="admin" value="<?php echo $admin?>" class="form-control cek_ecom" placeholder="Email Administrator" required>
                  <input type="hidden" name="adminx" value="<?php echo $admin?>" required>
                   <input type="hidden" name="iadmin" value="<?php $a = $this->encrypt->encode($iadmin);$b = base64_encode($a); echo $b; ?>">
                  <input type="hidden" name="jwh" value="<?php $a = $this->encrypt->encode('78354g3h4');$b = base64_encode($a); echo $b; ?>">
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group">
                  <label>Email Finance :<i style="color:red;">*isi satu email</i></label>
                  <input type="text" name="finance" value="<?php echo $finance?>" class="form-control cek_stat" placeholder="Email Finance" required>
                  <input type="hidden" name="financex" value="<?php echo $finance?>" required>
                   <input type="hidden" name="ifinance" value="<?php $a = $this->encrypt->encode($ifinance);$b = base64_encode($a); echo $b; ?>">
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group">
                  <label>Email Support :<i style="color:red;">*isi satu email</i></label>
                  <input type="text" name="support" value="<?php echo $support?>" class="form-control cek_retail" placeholder="Email Support" required>
                  <input type="hidden" name="supportx" value="<?php echo $support?>" required>
                   <input type="hidden" name="isupport" value="<?php $a = $this->encrypt->encode($isupport);$b = base64_encode($a); echo $b; ?>">
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group">
                  <label>Email Sales :<i style="color:red;">*isi satu email</i></label>
                  <input type="text" name="sales" value="<?php echo $sales?>" class="form-control cek_odv" placeholder="Email Sales" required>
                  <input type="hidden" name="salesx" value="<?php echo $sales?>" required>
                  <input type="hidden" name="isales" value="<?php $a = $this->encrypt->encode($isales);$b = base64_encode($a); echo $b; ?>">
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group">
                  <label>Email CC :<i style="color:red;">*pisahkan email dengan koma (,)</i></label>
                  <input type="text" name="cc" value="<?php echo $cc?>" class="form-control cek_alamat" placeholder="Email CC" required>
                  <input type="hidden" name="ccx" value="<?php echo $cc?>" required>
                  <input type="hidden" name="icc" value="<?php $a = $this->encrypt->encode($icc);$b = base64_encode($a); echo $b; ?>">
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group">
                  <label>Email BCC :<i style="color:red;">*pisahkan email dengan koma (,)</i></label>
                  <input type="text" name="bcc" value="<?php echo $bcc?>" class="form-control cek_tarif" placeholder="Email BCC" required>
                  <input type="hidden" name="bccx" value="<?php echo $bcc?>" required>
                  <input type="hidden" name="ibcc" value="<?php $a = $this->encrypt->encode($ibcc);$b = base64_encode($a); echo $b; ?>">
                  <br>
                </div>
                <div class="col-md-12 col-xs-12 input group">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
      </div>
      <div class="col-md-12 col-xs-12">
        <div class="panel panel-default" style="box-shadow:0px 0px 8px 0px #bababa;">
            <div class="panel-heading">Setting Halaman <a href="<?php echo base_url('trueaccon2194/setting/tambah_halaman');?>" style="padding: 5px " class="label label-success"><i class="glyphicon glyphicon-plus"></i></a> <a href="<?php echo base_url('trueaccon2194/setting/daftar_halaman');?>" style="padding: 5px " class="label label-success"><i class="glyphicon glyphicon-list"></i></a></div>
              <div class="panel-body" style="padding-top: 15px;">
                <div class="panel-group" id="accordion">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                        Syarat dan Ketentuan</a>
                      </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                      <div class="panel-body">
                        <?php echo form_open('trueaccon2194/setting/simpan_halaman');?>
                        <?php foreach($t as $h){
                            if($h->id_page == "6"){
                        ?>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Judul :<i style="color:red;">*</i></label>
                              <input type="text" name="judul" class="form-control" placeholder="Judul" value="<?php echo $h->judul?>" required>
                              <input type="hidden" name="ipost" value="<?php $a = $this->encrypt->encode($h->id_page);$b = base64_encode($a); echo $b; ?>">
                              <input type="hidden" name="kypost" value="<?php $a = $this->encrypt->encode('Post_judul');$b = base64_encode($a); echo $b; ?>">
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Key :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_key" class="form-control" placeholder="Meta Key" value="<?php echo $h->meta_key?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Description :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_desc" class="form-control" placeholder="Meta Deskripsi" value="<?php echo $h->meta_desc?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Slug :<i style="color:red;">*</i></label>
                              <input type="text" name="slug" class="form-control" placeholder="Slug" value="<?php echo $h->slug?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Konten :<i style="color:red;">*</i></label>
                              <textarea name="konten" id="mytextarea"><?php echo $h->konten?></textarea>
                              <br>
                          </div>
                          <div class="col-md-12">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        <?php }}?>
                        <?php echo form_close();?>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                        Kebijakan Privasi</a>
                      </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                      <div class="panel-body">
                        <?php echo form_open('trueaccon2194/setting/simpan_halaman');?>
                        <?php foreach($t as $h){
                            if($h->id_page == "7"){
                        ?>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Judul :<i style="color:red;">*</i></label>
                              <input type="text" name="judul" class="form-control" placeholder="Judul" value="<?php echo $h->judul?>" required>
                              <input type="hidden" name="ipost" value="<?php $a = $this->encrypt->encode($h->id_page);$b = base64_encode($a); echo $b; ?>">
                              <input type="hidden" name="kypost" value="<?php $a = $this->encrypt->encode('Post_judul');$b = base64_encode($a); echo $b; ?>">
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Key :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_key" class="form-control" placeholder="Meta Key" value="<?php echo $h->meta_key?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Description :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_desc" class="form-control" placeholder="Meta Deskripsi" value="<?php echo $h->meta_desc?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Slug :<i style="color:red;">*</i></label>
                              <input type="text" name="slug" class="form-control" placeholder="Slug" value="<?php echo $h->slug?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Konten :<i style="color:red;">*</i></label>
                              <textarea name="konten" id="mytextarea2"><?php echo $h->konten?></textarea>
                              <br>
                          </div>
                          <div class="col-md-12">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        <?php }}?>
                        <?php echo form_close();?>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                        Cara Berbelanja</a>
                      </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                      <div class="panel-body">
                          <?php echo form_open('trueaccon2194/setting/simpan_halaman');?>
                        <?php foreach($t as $h){
                            if($h->id_page == "8"){
                        ?>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Judul :<i style="color:red;">*</i></label>
                              <input type="text" name="judul" class="form-control" placeholder="Judul" value="<?php echo $h->judul?>" required>
                              <input type="hidden" name="ipost" value="<?php $a = $this->encrypt->encode($h->id_page);$b = base64_encode($a); echo $b; ?>">
                              <input type="hidden" name="kypost" value="<?php $a = $this->encrypt->encode('Post_judul');$b = base64_encode($a); echo $b; ?>">
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Key :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_key" class="form-control" placeholder="Meta Key" value="<?php echo $h->meta_key?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Description :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_desc" class="form-control" placeholder="Meta Deskripsi" value="<?php echo $h->meta_desc?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Slug :<i style="color:red;">*</i></label>
                              <input type="text" name="slug" class="form-control" placeholder="Slug" value="<?php echo $h->slug?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Konten :<i style="color:red;">*</i></label>
                              <textarea name="konten" id="mytextarea3"><?php echo $h->konten?></textarea>
                              <br>
                          </div>
                          <div class="col-md-12">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        <?php }}?>
                        <?php echo form_close();?>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                        Pembayaran</a>
                      </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse">
                      <div class="panel-body">
                          <?php echo form_open('trueaccon2194/setting/simpan_halaman');?>
                        <?php foreach($t as $h){
                            if($h->id_page == "2"){
                        ?>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Judul :<i style="color:red;">*</i></label>
                              <input type="text" name="judul" class="form-control" placeholder="Judul" value="<?php echo $h->judul?>" required>
                              <input type="hidden" name="ipost" value="<?php $a = $this->encrypt->encode($h->id_page);$b = base64_encode($a); echo $b; ?>">
                              <input type="hidden" name="kypost" value="<?php $a = $this->encrypt->encode('Post_judul');$b = base64_encode($a); echo $b; ?>">
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Key :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_key" class="form-control" placeholder="Meta Key" value="<?php echo $h->meta_key?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Description :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_desc" class="form-control" placeholder="Meta Deskripsi" value="<?php echo $h->meta_desc?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Slug :<i style="color:red;">*</i></label>
                              <input type="text" name="slug" class="form-control" placeholder="Slug" value="<?php echo $h->slug?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Konten :<i style="color:red;">*</i></label>
                              <textarea name="konten" id="mytextarea4"><?php echo $h->konten?></textarea>
                              <br>
                          </div>
                          <div class="col-md-12">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        <?php }}?>
                        <?php echo form_close();?>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                        Info Pengiriman</a>
                      </h4>
                    </div>
                    <div id="collapse5" class="panel-collapse collapse">
                      <div class="panel-body">
                          <?php echo form_open('trueaccon2194/setting/simpan_halaman');?>
                        <?php foreach($t as $h){
                            if($h->id_page == "3"){
                        ?>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Judul :<i style="color:red;">*</i></label>
                              <input type="text" name="judul" class="form-control" placeholder="Judul" value="<?php echo $h->judul?>" required>
                              <input type="hidden" name="ipost" value="<?php $a = $this->encrypt->encode($h->id_page);$b = base64_encode($a); echo $b; ?>">
                              <input type="hidden" name="kypost" value="<?php $a = $this->encrypt->encode('Post_judul');$b = base64_encode($a); echo $b; ?>">
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Key :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_key" class="form-control" placeholder="Meta Key" value="<?php echo $h->meta_key?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Description :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_desc" class="form-control" placeholder="Meta Deskripsi" value="<?php echo $h->meta_desc?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Slug :<i style="color:red;">*</i></label>
                              <input type="text" name="slug" class="form-control" placeholder="Slug" value="<?php echo $h->slug?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Konten :<i style="color:red;">*</i></label>
                              <textarea name="konten" id="mytextarea5"><?php echo $h->konten?></textarea>
                              <br>
                          </div>
                          <div class="col-md-12">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        <?php }}?>
                        <?php echo form_close();?>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                        Transaksi Aman</a>
                      </h4>
                    </div>
                    <div id="collapse6" class="panel-collapse collapse">
                      <div class="panel-body">
                          <?php echo form_open('trueaccon2194/setting/simpan_halaman');?>
                        <?php foreach($t as $h){
                            if($h->id_page == "11"){
                        ?>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Judul :<i style="color:red;">*</i></label>
                              <input type="text" name="judul" class="form-control" placeholder="Judul" value="<?php echo $h->judul?>" required>
                              <input type="hidden" name="ipost" value="<?php $a = $this->encrypt->encode($h->id_page);$b = base64_encode($a); echo $b; ?>">
                              <input type="hidden" name="kypost" value="<?php $a = $this->encrypt->encode('Post_judul');$b = base64_encode($a); echo $b; ?>">
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Key :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_key" class="form-control" placeholder="Meta Key" value="<?php echo $h->meta_key?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Meta Description :<i style="color:red;">*</i></label>
                              <input type="text" name="meta_desc" class="form-control" placeholder="Meta Deskripsi" value="<?php echo $h->meta_desc?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Slug :<i style="color:red;">*</i></label>
                              <input type="text" name="slug" class="form-control" placeholder="Slug" value="<?php echo $h->slug?>" required>
                              <br>
                          </div>
                          <div class="col-md-12 col-xs-12 input group">
                              <label>Konten :<i style="color:red;">*</i></label>
                              <textarea name="konten" id="mytextarea6"><?php echo $h->konten?></textarea>
                              <br>
                          </div>
                          <div class="col-md-12">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        <?php }}?>
                        <?php echo form_close();?>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
                        Halaman Lokasi Toko</a>
                        <?php 
                            $store_loc = for_store_locator();
                            if($store_loc['aktif'] == "on"){
                        ?>
                          <input type="checkbox" name="libur" data-enggine="" onchange="aktif_store(this);" class="js-switch pull-right fixed-header-check" checked>
                        <?php }else{?>
                          <input type="checkbox" name="libur" data-enggine="on" onchange="aktif_store(this);" class="js-switch pull-right fixed-header-check">
                        <?php }?>
                      </h4>
                    </div>
                  </div>
                </div>
              </div>
        </div>
      </div>
      <?php if(empty($g)){?>
      <div class="col-md-6 col-xs-12">
        <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
          <div class="row">
            <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
          </div>
        </div>
      </div>
      <?php } else {?>
      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="col-md-12">
            <a href="<?php echo base_url('trueaccon2194/setting/tambah_rekening');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah Rekening</a>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">  
              <table id="table_slider" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
                <thead>
                    <tr style="background-color:#34425a;color:white;">
                        <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                        <th style="text-align:center;">Bank</th>
                        <th style="text-align:center;">Nomor Rekening</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($g as $data):
                    ?>
                   <tr>
                      <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id;?>" /></td>
                      <td style="text-align:center;"><?php echo $data->name_bank;?></td>
                      <td style="text-align:center;"><?php echo $data->no_rek;?></td>
                      <td style="text-align:center;"><?php if($data->aktife_stat_bank == "on"){ echo "<label class='label label-success'>Aktif</label>"; }else{ echo "<label class='label label-danger'>Tidak Aktif</label>"; }?></td>
                      <td style="text-align:center;">
                        <?php 
                        $a = $this->encrypt->encode($data->id);
                        $b = base64_encode($a);
                        ?>
                        <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/setting/edit/<?php echo $b?>" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
                        <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/setting/hapus/<?php echo $b ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                      </td>
                  </tr>
                 <?php 
                endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <?php }?>
      <?php if(empty($f)){?>
        <div class="col-md-6 col-xs-12">
          <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
            <div class="row">
              <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
            </div>
          </div>
        </div>
      <?php } else {?>
      <div class="col-md-6 col-xs-12">
        <div class="col-md-12">
          <a href="<?php echo base_url('trueaccon2194/setting/tambah_other_store');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah Cabang Toko</a>
          <?php echo form_open_multipart('trueaccon2194/setting/delete_select', array('class' => 'input-group'));?>
          <button name="submit" class="btn btn-danger" style="margin-right: 10px;"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
        </div>
        <div class="col-md-12 ">
          <div class="table-responsive">  
            <table id="table_slider" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
              <thead>
                  <tr style="background-color:#34425a;color:white;">
                      <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                      <th style="text-align:center;">Logo</th>
                      <th style="text-align:center;">Nama Toko</th>
                      <th style="text-align:center;">Keterangan</th>
                      <th style="text-align:center;">Status</th>
                      <th style="text-align:center;">Opsi</th>
                  </tr>
              </thead>
              <tbody>
                  <?php 
                  foreach($f as $data):
                  ?>
                 <tr>
                    <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id;?>" /></td>
                    <td style="text-align:center;"><img src="<?php echo $data->gambar;?>" width="50"></td>
                    <td style="text-align:center;"><?php echo $data->nama;?></td>
                    <td style="text-align:center;"><?php echo $data->keterangan;?></td>
                    <td style="text-align:center;"><?php if($data->status == "on"){ echo "<label class='label label-success'>Aktif</label>"; }else{ echo "<label class='label label-danger'>Tidak Aktif</label>"; }?></td>
                    <td style="text-align:center;">
                      <?php 
                      $a = $this->encrypt->encode($data->id);
                      $b = base64_encode($a);
                      ?>
                      <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/setting/edit_other_store/<?php echo $b?>" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
                      <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/setting/hapus_other_store/<?php echo $b ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                    </td>
                </tr>
               <?php 
              endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php }?>
  </div>
</div>
