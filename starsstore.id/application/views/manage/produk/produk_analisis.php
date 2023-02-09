<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/dropzone.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/basic.min.css');?>">
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/drupload_for_imagerim.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/dUp/dropzone.min.js')?>"></script>
<div class="page-title"> 
  <h3>Produk Analisis
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
      <li class="active" href="<?php echo base_url('trueaccon2194/produk/produk')?>">Produk analisis</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">

    <div class="col-md-12 btn-grup-produk">
      <a href="<?php echo base_url('trueaccon2194/produk/tambah_produk');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah produk</a>
      <?php if(empty($tong)){?>
        <button disabled href="#" class="btn btn-danger" style="margin-right:10px;margin-bottom:10px;"><i class="glyphicon glyphicon-trash"></i> Tong Sampah</button>
      <?php }else{?>
        <a href="<?php echo base_url('trueaccon2194/produk/daftar_produk_dihapus/');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Tong Sampah</a>
      <?php }?>
    </div>
      <div class="col-md-12">
        <div class="fil_best_seller">
          <div class="row">
            <div class="col-md-6 col-xs-12 form-group">
              <fieldset class="field-fix">
              <legend class="leg-fix">Menu</legend>
                <div class="row">
                  <div class="col-md-12">
                    <a href="javascript:void(0);" onclick="penurunan_harga_produk();" style="margin-right:10px;margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-scissors"></i> Daftar Perubahan Harga Setelah Update</a> 
                    <a onclick="confirmUpdate();" href="javascript:void(0);" style="margin-right:10px;margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> Update Harga Dari Master</a>
                    <a onclick="syncimagewithdb();" href="javascript:void(0);" style="margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> Sync Gambar RIM dengan database</a>
                    <a onclick="uploadRimimage();" href="javascript:void(0);" style="margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-upload"></i> Upload Gambar di RIM</a>
                    <a href="<?php echo base_url('trueaccon2194/produk/daftar_grup/');?>" style="margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-th-large"></i> Produk grouping / Group promo</a>
                    <a href="<?php echo base_url('trueaccon2194/produk/download_excel_produk/');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-book"></i> Download Semua Data Produk (excel)</a>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
        </div>
      </div>

    <div class="col-md-12 drpimg" style="margin: 20px 0 30px 0;display: none;">
      <div class="dropzone">
        <div class="dz-message">
          <h3 class="txtgb"> Klik atau Drop foto artikel terbaru <br>file maksimal 4 MB<br><span style="font-size: 12px;">file yang diijinkan : gif, jpg, jpeg, png<br>*Jika ingin menghapus foto Rim harap ke menu galeri.</span></h3>
          </div>
        </div>
    </div>
    <div class="col-md-12 table-responsive">  
    <div id="pesan"></div>
      <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
        <thead>
            <tr style="background-color:#34425a;color:white;">
              <th style="text-align:center;">Gambar</th>
              <th style="text-align:center;">Nama Project</th>
              <th style="text-align:center;">Artikel</th>
              <th style="text-align:center;">Kategori</th>
              <th style="text-align:center;">Merk</th>
              <th style="text-align:center;">Total Dilihat Pengunjung</th>
              <th style="text-align:center;">Ukuran</th>
              <th style="text-align:center;">Stok</th>
              <th style="text-align:center;">Harga</th>
              <th style="text-align:center;">Terjual</th>
              <th style="text-align:center;">Opsi</th>
            </tr>
        </thead>
        <tbody>
          <?php 
            foreach($get_list as $x){
              // menghitung variasi produk dimasukkan kedalam rowspan
              $idprodukvariasi = $x->id_produk;
              $rowsv = $this->produk_adm->count_variasi($idprodukvariasi);
              // STATUS LABEL
              if($x->status == "on"){
                $stx = "<label style='top:7px;position:relative;' class='label label-success'>Aktif</label>";
              }else{
                $stx = "<label style='top:7px;position:relative;' class='label label-danger'>Tidak aktif</label>";
              }
              // END STATUS LABEL
              // PRODUK DILIHAT
              $rowthlt = $this->produk_adm->produk_dilihat($idprodukvariasi);
              // END PRODUK DILIHAT
          ?>
            <tr>
              <th style="text-align:center;" align="center" rowspan="<?php echo $rowsv['variasi'];?>"><img src='<?php echo $x->gambar?>' height='70' onError='this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg')?>'><br><?php echo $stx?></th>
              <th style="text-align:center;" align="center" rowspan="<?php echo $rowsv['variasi'];?>">
                <?php echo $x->nama_produk?>
              </th>
              <th style="text-align:center;" align="center" rowspan="<?php echo $rowsv['variasi'];?>"><?php echo $x->artikel?></th>
              <th style="text-align:center;" align="center" rowspan="<?php echo $rowsv['variasi'];?>"><?php echo $x->kategori?></th>
              <th style="text-align:center;" align="center" rowspan="<?php echo $rowsv['variasi'];?>"><img src="<?php echo $x->logo?>" width="100" onError='this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg')?>'></th>
              <th style="text-align:center;" align="center" rowspan="<?php echo $rowsv['variasi'];?>"><?php echo $rowthlt['total_dilihat'];?></th>
              <?php 
                // tata struktur variasi
                $nomorvariasi = 0;
                $xv = $this->produk_adm->get_variasi($idprodukvariasi);
                foreach($xv as $gh){
                $nomorvariasi++;

                $art = $x->artikel;
                $size = $gh->opsi_size;
                // PRODUK TERJUAL
                $rowdjl = $this->produk_adm->produk_terjual($art, $size);
                // END PRODUK TERJUAL

                if($nomorvariasi == 1){
              ?>
                <td style="text-align:center;" ><?php echo $gh->opsi_size?></td>
                <td style="text-align:center;" ><?php echo $gh->stok?></td>
                <td style="text-align:center;" >
                <?php 
                  if($x->harga_dicoret == 0 || empty($x->harga_dicoret)){ 
                    echo "Rp. ".number_format($x->harga_fix,0,".",".")."";
                  }else{
                    echo "<s style='color:#989898;font-size:12px;'>Rp. ".number_format($x->harga_dicoret,0,".",".")."</s><br><span>Rp. ".number_format($x->harga_fix,0,".",".")."</span> <label class='label-diskon' style='margin-left:5px;'>".round(($x->harga_dicoret - $x->harga_fix) / $x->harga_dicoret * 100)." %</label>";
                  }
                ?>
                </td>
                <td style="text-align:center;" >
                  <?php if(empty($rowdjl['total_terjual'])){ echo 0; }else{echo $rowdjl['total_terjual']; }?> Psg
                </td>
                <td style="text-align:center;" rowspan="<?php echo $rowsv['variasi'];?>">
                  <?php $id = $this->encrypt->encode($x->id_produk); 
                  $idx = base64_encode($id);
                  // edit
                  echo "<a style='margin-bottom:10px;' href='".base_url('trueaccon2194/produk/edit_data/'.$idx.'')."' class='btn btn-warning edit'><i class='glyphicon glyphicon-pencil'></i></a><br>";
                  // remove
                  echo "<a href='javascript:void(0)'' class='btn btn-danger hapus' data-id='".$idx."' data-name='".$x->nama_produk."' onclick='pindahkan_tong(this);'><i class='glyphicon glyphicon-remove'></i></a>";
                  ?>
                </td>
              <?php }?>
            </tr>
            <?php if($nomorvariasi == 2){?>
            <tr>
              <td style="text-align:center;" ><?php echo $gh->opsi_size?></td>
              <td style="text-align:center;" ><?php echo $gh->stok?></td>
              <td style="text-align:center;" >
                <?php 
                  if($x->harga_dicoret == 0 || empty($x->harga_dicoret)){ 
                    echo "Rp. ".number_format($x->harga_fix,0,".",".")."";
                  }else{
                    echo "<s style='color:#989898;font-size:12px;'>Rp. ".number_format($x->harga_dicoret,0,".",".")."</s><br><span>Rp. ".number_format($x->harga_fix,0,".",".")."</span> <label class='label-diskon' style='margin-left:5px;'>".round(($x->harga_dicoret - $x->harga_fix) / $x->harga_dicoret * 100)." %</label>";
                  }
                ?>
              </td>
              <td style="text-align:center;" >
                <?php if(empty($rowdjl['total_terjual'])){ echo 0; }else{echo $rowdjl['total_terjual']; }?> Psg
              </td>
            </tr>
            <?php }?>
            <?php if($nomorvariasi > 2){?>
            <tr>
              <td style="text-align:center;" ><?php echo $gh->opsi_size?></td>
              <td style="text-align:center;" ><?php echo $gh->stok?></td>
              <td style="text-align:center;" >
                <?php 
                  if($x->harga_dicoret == 0 || empty($x->harga_dicoret)){ 
                    echo "Rp. ".number_format($x->harga_fix,0,".",".")."";
                  }else{
                    echo "<s style='color:#989898;font-size:12px;'>Rp. ".number_format($x->harga_dicoret,0,".",".")."</s><br><span>Rp. ".number_format($x->harga_fix,0,".",".")."</span> <label class='label-diskon' style='margin-left:5px;'>".round(($x->harga_dicoret - $x->harga_fix) / $x->harga_dicoret * 100)." %</label>";
                  }
                ?>
              </td>
              <td style="text-align:center;" >
                <?php if(empty($rowdjl['total_terjual'])){ echo 0; }else{echo $rowdjl['total_terjual']; }?> Psg
              </td>
            </tr>
            <?php }?>
          <?php }?>
          <?php }?>
        </tbody>
      </table>
      
    </div>
  </div>
</div>