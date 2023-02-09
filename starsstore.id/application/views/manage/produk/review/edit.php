<div class="page-title">
  <h3><i class="glyphicon glyphicon-user"></i> Tambah Review
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
      <li><a href="<?php echo base_url('trueaccon2194/review_produk')?>">Review Produk</a></li>
      <li class="active">Edit Review Produk</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
      <div class="col-md-12">
      <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
      <br>
      </div>
<?php echo form_open_multipart('trueaccon2194/review_produk/update_review_produk')?>
        <div class="col-md-9 m-t-lg" >
            <div class="panel panel-white" style="box-shadow:0px 0px 8px 0px #bababa;">
                <div class="panel-bodyty">
                    <div class="post-inv">                                        
                        <div class="row">
                            <div class="col-md-6 col-xs-12 input group">
                              <label> Nama Produk : <i style="color:red;">*</i></label>
                              <select class="form-control cek_nama" name="produk">
                              <?php foreach($produk as $data){ 
                              if($data['id_produk'] == $g['id_produk']){?>
                                <option value="<?php echo $data['id_produk']?>" SELECTED><?php echo $data['nama_produk']?> [<?php echo $data['artikel']?>]</option>    
                                  <?php }else{?>
                                <option value="<?php echo $data['id_produk']?>"><?php echo $data['nama_produk']?> [<?php echo $data['artikel']?>]</option>    
                              <?php }}?>
                              </select>
                              <input type="hidden" name="id_review" value="<?php echo $g['id_review']?>">
                              <br>
                            </div>
                            <div class="col-md-6 col-xs-12 input group">
                              <label>Nama Pe-review: </label> <i style="color:red;">*</i>
                              <input type="text" name="nama_review" class="form-control cek_slug" id="slug" value="<?php echo $g['nama_review']?>" placeholder="Nama Pe-review" >
                              <br>
                            </div>
                            <div class="col-md-2 col-xs-12 input group">
                              <label>Rating : <i style="color:red;">*</i></label>
                              <ul class="list-unstyled rate">
                                <?php 
                                  if($g['rating'] == "0stars.png"){
                                ?>
                                  <li><label><input type="radio" id="rt" name="rt" value="5stars.png"><span class="stars5">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="4stars.png"><span class="stars4">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="3stars.png"><span class="stars3">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="2stars.png"><span class="stars2">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="1stars.png"><span class="stars1">&nbsp</span></label></li>
                                  <li><label><input type="radio" checked id="rt" name="rt" value="0stars.png"><span class="stars0">&nbsp</span></label></li>

                                <?php }else if($g['rating'] == "0stars.png"){?>

                                  <li><label><input type="radio" id="rt" name="rt" value="5stars.png"><span class="stars5">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="4stars.png"><span class="stars4">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="3stars.png"><span class="stars3">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="2stars.png"><span class="stars2">&nbsp</span></label></li>
                                  <li><label><input type="radio" checked id="rt" name="rt" value="1stars.png"><span class="stars1">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="0stars.png"><span class="stars0">&nbsp</span></label></li>

                                <?php }else if($g['rating'] == "2stars.png"){?>

                                  <li><label><input type="radio" id="rt" name="rt" value="5stars.png"><span class="stars5">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="4stars.png"><span class="stars4">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="3stars.png"><span class="stars3">&nbsp</span></label></li>
                                  <li><label><input type="radio" checked id="rt" name="rt" value="2stars.png"><span class="stars2">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="1stars.png"><span class="stars1">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="0stars.png"><span class="stars0">&nbsp</span></label></li>

                                <?php }else if($g['rating'] == "3stars.png"){?>

                                  <li><label><input type="radio" id="rt" name="rt" value="5stars.png"><span class="stars5">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="4stars.png"><span class="stars4">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" checked name="rt" value="3stars.png"><span class="stars3">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="2stars.png"><span class="stars2">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="1stars.png"><span class="stars1">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="0stars.png"><span class="stars0">&nbsp</span></label></li>

                                <?php }else if($g['rating'] == "4stars.png"){?>

                                  <li><label><input type="radio" id="rt" name="rt" value="5stars.png"><span class="stars5">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" checked name="rt" value="4stars.png"><span class="stars4">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="3stars.png"><span class="stars3">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="2stars.png"><span class="stars2">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="1stars.png"><span class="stars1">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="0stars.png"><span class="stars0">&nbsp</span></label></li>

                                <?php }else if($g['rating'] == "5stars.png"){?>

                                  <li><label><input type="radio" id="rt" checked name="rt" value="5stars.png"><span class="stars5">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="4stars.png"><span class="stars4">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="3stars.png"><span class="stars3">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="2stars.png"><span class="stars2">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="1stars.png"><span class="stars1">&nbsp</span></label></li>
                                  <li><label><input type="radio" id="rt" name="rt" value="0stars.png"><span class="stars0">&nbsp</span></label></li>

                                <?php }?>
                              </ul>
                              <br>
                              <label>Status :</label>
                              <div class="ios-switch switch-lg">
                                  <input type="checkbox" name="status" class="js-switch pull-right fixed-header-check" <?php echo $status1?>>
                              </div>
                              <br>
                            </div>
                            <div class="col-md-10 col-xs-12 input group">
                              <label>Review : <i style="color:red;">*</i></label>
                              <textarea name="review" id="mytextarea" ><?php echo $g['review']?></textarea>
                            <?php echo br()?>
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
          <button type="submit" class="btn btn-success" onclick="simpan_promo()">Update Review</button>
          <?php echo br(2)?>
      </div>
      </div>
  </div>
<?php echo form_close()?>
</div>
</div>