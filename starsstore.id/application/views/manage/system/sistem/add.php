<div class="page-title">
  <h3>Tambah Halaman
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
      <li><a href="<?php echo base_url('trueaccon2194/setting')?>">Setting</a></li>
      <li class="active">Tambah Halaman</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
        <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open('trueaccon2194/setting/add_halaman');?>
        <div class="col-md-9 m-t-lg" >
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                              <div class="col-md-12 col-xs-12 input group">
                                  <label>Kategori :<i style="color:red;">*</i></label>
                                  <select name="kat" class="form-control" required="">
                                    <?php foreach($kat as $t){?>
                                    <option value="<?php echo $t->id_kategori_halaman?>"><?php echo $t->kategori?></option>
                                    <?php }?>
                                  </select>
                                  <input type="hidden" name="kypost" value="<?php $a = $this->encrypt->encode('Post_judul');$b = base64_encode($a); echo $b; ?>">
                                  <br>
                              </div>
                              <div class="col-md-12 col-xs-12 input group">
                                  <label>Judul :<i style="color:red;">*</i></label>
                                  <input type="text" name="judul" class="form-control" placeholder="Judul" required>
                                  <br>
                              </div>
                              <div class="col-md-12 col-xs-12 input group">
                                  <label>Meta Key :<i style="color:red;">*</i></label>
                                  <input type="text" name="meta_key" class="form-control" placeholder="Meta Key" required>
                                  <br>
                              </div>
                              <div class="col-md-12 col-xs-12 input group">
                                  <label>Meta Description :<i style="color:red;">*</i></label>
                                  <input type="text" name="meta_desc" class="form-control" placeholder="Meta Deskripsi" required>
                                  <br>
                              </div>
                              <div class="col-md-12 col-xs-12 input group">
                                  <label>Slug :<i style="color:red;">*</i></label>
                                  <input type="text" name="slug" class="form-control" placeholder="Slug" required>
                                  <br>
                              </div>
                              <div class="col-md-12 col-xs-12 input group">
                                  <label>Konten :<i style="color:red;">*</i></label>
                                  <textarea name="konten" id="mytextarea1"></textarea>
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
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Simpan Halaman</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>