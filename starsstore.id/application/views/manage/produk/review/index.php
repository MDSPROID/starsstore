<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();

      $("#table_qna").DataTable();
  });
</script>
<div class="page-title">
  <h3>Review dan Q&A Produk 
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/review_produk')?>">Review Produk</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">

<div class="col-md-12">
  <a href="<?php echo base_url('trueaccon2194/review_produk/tambah_review_produk');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah Review</a>
  <?php echo form_open_multipart('trueaccon2194/produk/delete_select', array('class' => 'input-group'));?>
  <button name="submit" class="btn btn-danger" style="margin-right: 10px;"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
</div>
<div class="col-md-12 table-responsive">  
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Project</th>
                    <th style="text-align:center;">Artikel</th>
                    <th style="text-align:center;">Customer</th>
                    <th style="text-align:center;">Review</th>
                    <th style="text-align:center;">Rating Produk</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($get_list_review as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_review;?>" /></td>
                  <td style="text-align:center;"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="
                  <?php 
                    if(empty($data->gambar)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->gambar;}?>" height="50"></td>
                  <td style="text-align:center;"><a href="<?php echo base_url('produk/'.$data->slug.'');?>" target="_new"><?php echo $data->nama_produk;?></a></td>
                  <td style="text-align:center;"><?php echo $data->artikel;?></td>
                  <td style="text-align:center;"><?php echo $data->nama_review;?></td>
                  <td style="text-align:center;"><?php echo $data->review;?></td>
                  <td style="text-align:center;"><img src="<?php echo base_url('assets/images/rating/')?><?php echo $data->rating?>" width="80"></td>
                  <td style="text-align:center;">
                  <?php
                    if($data->status_review == ""){
                      echo "<label class='label label-danger'>Tidak Aktif</label>";
                    }else if($data->status_review == "ditinjau"){
                      echo "<label class='label label-warning'>Menunggu Persetujuan</label>";
                    }else if($data->status_review == "on"){
                      echo "<label class='label label-success'>Aktif</label>";
                    }
                  ?></td>
                  <td style="text-align:center;">
                    <?php
                    $idf = $this->encrypt->encode($data->id_review);
                    $id = base64_encode($idf);
                    if($data->status_review == "on"){
                      echo "<a style='padding:3px 8px;' href='review_produk/off/$id' class='btn btn-danger edit'>OFF</a>";
                    }else if($data->status_review == "ditinjau"){
                      echo "<a style='padding:3px 8px;' href='review_produk/setujui/$id' class='btn btn-success edit'>Setujui</a>";
                    }else if($data->status_review == ""){
                      echo "<a style='padding:3px 8px;' href='review_produk/on/$id' class='btn btn-success edit'>ON</a>";
                    }
                    ?>
                    <a href="<?php echo base_url()?>trueaccon2194/review_produk/edit_data/<?php $id = $this->encrypt->encode($data->id_review); $idp = base64_encode($id); echo $idp ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a href="<?php echo base_url()?>trueaccon2194/review_produk/hapus/<?php $id = $this->encrypt->encode($data->id_review); $idp = base64_encode($id); echo $idp ?>" class="btn btn-danger hapus" ><i class="glyphicon glyphicon-remove"></i></a>
                  </td>
              </tr>
             <?php endforeach;?>
            </tbody>
  </table>
</div>
<?php echo form_close();?>
<div class="col-md-12">
  <h2>Pertanyaan Produk</h2>
</div>
<div class="col-md-12 table-responsive">  
  <table id="table_qna" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Project</th>
                    <th style="text-align:center;">Artikel</th>
                    <th style="text-align:center;">Customer</th>
                    <th style="text-align:center;">Pertanyaan</th>
                    <th style="text-align:center;">Balasan Admin</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                foreach($get_list_qna as $data):
                  if(!empty($data->nama_balas)){
                    $chk = "background-color:#e6fde6";
                  }else{
                    $chk = "";
                  }
                ?>
               <tr style="<?php echo $chk?>">
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_q_n_a;?>" /></td>
                  <td style="text-align:center;"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="
                  <?php 
                    if(empty($data->gambar)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->gambar;}?>" height="50"></td>
                  <td style="text-align:center;"><a href="<?php echo base_url('produk/'.$data->slug.'');?>" target="_new"><?php echo $data->nama_produk;?></a></td>
                  <td style="text-align:center;"><?php echo $data->artikel;?></td>
                  <td style="text-align:center;"><?php echo $data->nama;?></td>
                  <td style="text-align:center;"><?php echo $data->pertanyaan;?></td>
                  <td style="text-align:center;">
                    <?php 
                      if(!empty($data->nama_balas)){
                        echo $data->balasan;
                      }else{
                        
                    ?>
                    <?php echo form_open('trueaccon2194/review_produk/balas_qna');?><input type="hidden" name="idp" value="<?php $id = $this->encrypt->encode($data->id_q_n_a); $idp = base64_encode($id); echo $idp ?>"><input type="hidden" name="nama_produk" value="<?php $id = $this->encrypt->encode($data->nama_produk); $idp = base64_encode($id); echo $idp ?>"><input type="text" name="balasan" class="bls form-control"><div style="padding-top: 10px;"><label onclick="fast_comment(this);" data-komen ="Stok Produk Tersedia. " class="label label-default">Stok Produk Tersedia. </label><label onclick="fast_comment(this);" data-komen ="Maaf Stok Habis. " class="label label-default">Maaf Stok Habis. </label><label onclick="fast_comment(this);" data-komen ="Pengiriman normalnya 3-4 hari. " class="label label-default">Pengiriman normalnya 3-4 hari. </label>
                      <?php echo form_close();?>
                      <?php }?>
                    </td>
                  <td style="text-align:center;">
                  <?php
                    if($data->nama_balas == ""){
                      echo "<label class='label label-danger'>Belum Dibalas</label>";
                    }else{
                      echo "<label class='label label-success'>Dibalas</label>";
                    }
                  ?></td>
                  <td style="text-align:center;">
                    <?php
                    $idf = $this->encrypt->encode($data->id_q_n_a);
                    $id = base64_encode($idf);
                    ?>
                    <a href="<?php echo base_url()?>trueaccon2194/review_produk/edit_qna/<?php $id = $this->encrypt->encode($data->id_q_n_a); $idp = base64_encode($id); echo $idp ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a href="<?php echo base_url()?>trueaccon2194/review_produk/hapus_qna/<?php $id = $this->encrypt->encode($data->id_q_n_a); $idp = base64_encode($id); echo $idp ?>" class="btn btn-danger hapus" ><i class="glyphicon glyphicon-remove"></i></a>
                  </td>
              </tr>
             <?php endforeach;?>
            </tbody>
  </table>
</div>
  </div>
</div>