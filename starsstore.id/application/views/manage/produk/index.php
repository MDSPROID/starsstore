<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/dropzone.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/basic.min.css');?>">
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/drupload_for_imagerim.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/dUp/dropzone.min.js')?>"></script>
<style type="text/css">
  .input-group-addon, .input-group-btn, .input-group .form-control {
    display: flex;
}
</style>
<div class="page-title"> 
  <h3>Produk 
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
      <li class="active" href="<?php echo base_url('trueaccon2194/produk/produk')?>">Produk</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">

    <div class="col-md-12 btn-grup-produk">
      <a href="<?php echo base_url('trueaccon2194/produk/tambah_produk');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah produk</a>
      <a href="javascript:void(0);" onclick="tambahprodukwithcekrims();" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah produk Metode Lain</a>
      <?php if(empty($tong)){?>
        <button disabled href="#" class="btn btn-danger" style="margin-right:10px;margin-bottom:10px;"><i class="glyphicon glyphicon-trash"></i> Tong Sampah</button>
      <?php }else{?>
        <a href="<?php echo base_url('trueaccon2194/produk/daftar_produk_dihapus/');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Tong Sampah</a>
      <?php }?>
        <a href="<?php echo base_url('trueaccon2194/produk/daftar_produk_dinonaktifkan_sistem/');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Produk yang dinonaktifkan oleh sistem</a>
        <a href="<?php echo base_url('trueaccon2194/produk/produk_analisis/');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-primary"><i class="glyphicon glyphicon-stats"></i> Produk Analisis</a>
        <a href="javascript:void(0);" id="btncetak" style="display: none;margin-right:10px;margin-bottom:10px;" onclick="printDiv('cetakareacekstok')" class="btn btn-default print" style="margin-right:10px;"><i class="glyphicon glyphicon-print"></i> Cetak Cetak Cek Stok</a>
        <div class="input-group pull-right thinput">
          <input type="text" name="artprocess" class="form-control list-form seacrhart arthd" style="text-transform: uppercase;" id="art" placeholder="Artikel" required>
          <span class="input-group-btn">
            <button class="btn btn-danger mail_sb hj cek_stok" onclick="cekStokbyrims();">Cek Stok Produk</button>
          </span>
        </div>
    </div>
    <div class="col-md-12">
      <div class="resultcekstok" style="display: none;text-align:center;background-color:white;padding: 15px;margin-top: 20px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-12 menuss">
      <div class="fil_best_seller">
        <div class="row">
          <div class="col-md-4 col-xs-12 form-group">
            <fieldset class="field-fix">
            <legend class="leg-fix">Menu</legend>
              <div class="row">
                <div class="col-md-12">
                  <a href="javascript:void(0);" onclick="penurunan_harga_produk();" style="margin-right:10px;margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-scissors"></i> Daftar Perubahan Harga Setelah Update</a> 
                  <a onclick="confirmUpdate();" href="javascript:void(0);" style="margin-right:10px;margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> Update Harga Dari Master</a>
                  <a onclick="syncimagewithdb();" href="javascript:void(0);" style="margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> Sync Gambar Upload dengan database</a>
                  <a onclick="uploadRimimage();" href="javascript:void(0);" style="margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-upload"></i> Upload Gambar di RIM</a>
                  <a href="<?php echo base_url('trueaccon2194/produk/daftar_grup/');?>" style="margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-th-large"></i> Produk grouping / Group promo</a>
                  <a href="<?php echo base_url('trueaccon2194/produk/download_excel_produk/');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-book"></i> Download Semua Data Produk (excel)</a>
                  <a href="javascript:void(0);" onclick="cekstokbyonline();" style="margin-right:10px;margin-bottom:10px;" class="btn btn-default"><i class="glyphicon glyphicon-book"></i> Cek Produk Aktif tak layak jual (status ON & stok < 700)</a>
                  <div class="input-group">
                  </div>

                  <div class="input-group thinput">
                    <?php echo form_open_multipart('trueaccon2194/produk/update_produk_by_excel');?>
                    <input type="file" style="width: 50%;" name="fileupload" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-danger mail_sb hj cek_stok" style="line-height: 14px;">Upload & Update</button>
                    </span>
                    <?php echo form_close();?>
                  </div>
                  <a href="<?php echo base_url('trueaccon2194/produk/download_produk_format_upload');?>">Download Data Produk (Format Upload)</a>

                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-8 col-xs-12 form-group">
            <fieldset class="field-fix">
              <legend class="leg-fix">Filter</legend>
              <?php 
                $id = array('id' => 'fill-form');
                echo form_open('trueaccon2194/produk/filter_produk_excel', $id);
              ?>
              <div class="row">
                <div class="col-md-6 col-xs-12" style="margin-bottom: 5px;">
                  <label>Status produk*</label>
                  <select class="form-control" name="status_produk" id="status_produk">
                    <option value="all">Semua</option>
                    <option value="on">ON</option>
                    <option value="off">OFF</option>
                  </select>
                </div>
                <div class="col-md-6 col-xs-12" style="margin-bottom: 5px;">
                  <label>Sort By*</label>
                  <select class="form-control" name="sort_by" id="sort_by">
                    <option value="a_z">A ke Z</option>
                    <option value="z_a">Z ke A</option>
                    <option value="low">Harga rendah ke harga tinggi</option>
                    <option value="high">Harga tinggi ke harga rendah</option>
                    <option value="first_end">Produk lama ke produk baru</option>
                    <option value="end_first">Produk baru ke produk lama</option>
                    <option value="tr_diubah">Terakhir diubah</option>
                  </select>
                </div>
                <div class="col-md-4 col-xs-12" style="margin-bottom: 5px;">
                  <label>Ukuran*</label>
                  <select id="size" name="size" class="form-control">
                    <option value="">-- Pilih ukuran --</option>
                    <?php foreach($ukuran as $g){?>
                      <option value="<?php echo $g->id_opsi_size?>"><?php echo $g->opsi_size?></option>
                    <?php }?>
                  </select>
                </div>
                <div class="col-md-4 col-xs-12" style="margin-bottom: 5px;">
                  <label>Warna*</label>
                  <select id="color" name="color" class="form-control">
                    <option value="">-- Pilih warna --</option>
                    <?php foreach($color as $xx){?>
                      <option value="<?php echo $xx->id_opsi_color?>"><?php echo $xx->opsi_color?></option>
                    <?php }?>
                  </select>
                </div>
                <div class="col-md-4 col-xs-12" style="margin-bottom: 5px;">
                  <label>Kategori (Khusus lazada, Bukalapak & Blibli)</label>
                  <select name="kategori" class="form-control" id="kategori">
                    <option value="">-- Pilih kategori --</option>
                    <?php foreach($kategori as $xxx){?>
                      <option value="<?php echo $xxx->kat_id?>"><?php echo $xxx->kategori?></option>
                    <?php }?>
                  </select>
                </div>
                <div class="col-md-12 col-xs-12" style="margin-bottom: 5px;">
                  <input style="display: none;" type="text" name="produk_pilih" class="form-control" placeholder="sementara hanya bisa digunakan satu artikel">
                  <div class="row">
                    <div class="col-md-6 input group ">
                    <label>Tanggal awal upload : <i style="color:red;">*</i></label>
                    <div id="datetimepicker3" class="input-append">
                        <input type="text" data-format="yyyy-MM-dd" id="tgl1" name="tglupload1" class="form-control cek_tgl" placeholder="Tanggal awal upload">
                        <span class="add-on">
                          <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                        </span>   
                      </div>
                      <br>
                    </div>
                    <div class="col-md-6 input group ">
                    <label>Tanggal akhir upload : <i style="color:red;">*</i></label>
                    <div id="datetimepicker4" class="input-append">
                        <input type="text" data-format="yyyy-MM-dd" id="tgl2" name="tglupload2" class="form-control cek_tgl" placeholder="Tanggal akhir upload">
                        <span class="add-on">
                          <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                        </span>   
                      </div>
                      <br>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
                  <a style="margin-bottom: 5px;" class="btn btn-success btn-filter">Filter</a>
                  <button class="btn btn-success" style="margin-bottom: 5px;" name="excel_filter" value="excel_produk_by_filter">Filter & Export ke Excel</button>
                  <button class="btn btn-success" style="margin-bottom: 5px;" name="excel_filter" value="excel_produk_by_filter_to_shopee">Filter & Export ke Excel (Shopee)</button>
                  <button class="btn btn-success" style="margin-bottom: 5px;" name="excel_filter" value="excel_produk_by_filter_to_lazada">Filter & Export ke Excel (Lazada)</button>
                  <button class="btn btn-success" style="margin-bottom: 5px;" name="excel_filter" value="excel_produk_by_filter_to_tokopedia">Filter & Export ke Excel (Tokopedia)</button>
                  <button class="btn btn-success" style="margin-bottom: 5px;" name="excel_filter" value="excel_produk_by_filter_to_bukalapak">Filter & Export ke Excel (Bukalapak)</button>
                  <button class="btn btn-success" style="margin-bottom: 5px;" name="excel_filter" value="excel_produk_by_filter_to_blibli">Filter & Export ke Excel (Blibli)</button><br>
                </div>
                <div class="col-md-12 col-xs-12">
                <label>Cek produk Otomatis (Cronjob)</label>
                <?php 
                $rx = setting_cek_stok_produk();
                if($rx['aktif'] == ""){
                  $status_cek_stok = "";
                }else{
                  $status_cek_stok = "checked";
                }?>
                <div class="ios-switch switch-lg">
                    <input type="checkbox" name="status_cek_stok" id="status_c_stok" <?php echo $status_cek_stok?> class="status_cek_stok js-switch pull-right fixed-header-check">
                </div>
              </div>
              </div>
              <?php echo form_close();?>
              <i style="color: red;">*Khusus untuk lazada, Bukalapak & Blibli pilih kategori.</i>
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
    <div id="table_produkx" class="col-md-12 table-responsive">  
    <div id="pesan"></div>
      <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
        <thead>
            <tr style="background-color:#34425a;color:white;">
                <th style="text-align:center;">Tanggal Upload</th>
                <th style="text-align:center;">Gambar</th>
                <th style="text-align:center;">Nama Project</th>
                <th style="text-align:center;">Artikel | Merk | Warna</th>
                <th style="text-align:center;">Stok Global</th>
                <th style="text-align:center;">Harga</th>
                <th style="text-align:center;">20</th>
                <th style="text-align:center;">21</th>
                <th style="text-align:center;">22</th>
                <th style="text-align:center;">23</th>
                <th style="text-align:center;">24</th>
                <th style="text-align:center;">25</th>
                <th style="text-align:center;">26</th>
                <th style="text-align:center;">27</th>
                <th style="text-align:center;">28</th>
                <th style="text-align:center;">29</th>
                <th style="text-align:center;">30</th>
                <th style="text-align:center;">31</th>
                <th style="text-align:center;">32</th>
                <th style="text-align:center;">33</th>
                <th style="text-align:center;">34</th>
                <th style="text-align:center;">35</th>
                <th style="text-align:center;">36</th>
                <th style="text-align:center;">37</th>
                <th style="text-align:center;">38</th>
                <th style="text-align:center;">39</th>
                <th style="text-align:center;">40</th>
                <th style="text-align:center;">41</th>
                <th style="text-align:center;">42</th>
                <th style="text-align:center;">43</th>
                <th style="text-align:center;">44</th>
                <th style="text-align:center;">45</th>
                <th style="text-align:center;">Opsi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
          <tr style="background-color:#34425a;color:white;">
                <th style="text-align:center;">Tanggal Upload</th>
                <th style="text-align:center;">Gambar</th>
                <th style="text-align:center;">Nama Project</th>
                <th style="text-align:center;">Artikel | Merk | Warna</th>
                <th style="text-align:center;">Stok Global</th>
                <th style="text-align:center;">Harga</th>
                <th style="text-align:center;">20</th>
                <th style="text-align:center;">21</th>
                <th style="text-align:center;">22</th>
                <th style="text-align:center;">23</th>
                <th style="text-align:center;">24</th>
                <th style="text-align:center;">25</th>
                <th style="text-align:center;">26</th>
                <th style="text-align:center;">27</th>
                <th style="text-align:center;">28</th>
                <th style="text-align:center;">29</th>
                <th style="text-align:center;">30</th>
                <th style="text-align:center;">31</th>
                <th style="text-align:center;">32</th>
                <th style="text-align:center;">33</th>
                <th style="text-align:center;">34</th>
                <th style="text-align:center;">35</th>
                <th style="text-align:center;">36</th>
                <th style="text-align:center;">37</th>
                <th style="text-align:center;">38</th>
                <th style="text-align:center;">39</th>
                <th style="text-align:center;">40</th>
                <th style="text-align:center;">41</th>
                <th style="text-align:center;">42</th>
                <th style="text-align:center;">43</th>
                <th style="text-align:center;">44</th>
                <th style="text-align:center;">45</th>
                <th style="text-align:center;">Opsi</th>
            </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<!-- Bootstrap modal edit-->
<div class="modal fade" id="modal_penurunan" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Book Form</h3>
      </div>
        <div class="modal-body form">
        <?php 
        echo form_open('trueaccon2194/produk/cek_perubahan_harga');
        ?>
        <div class="row">
          <div class="col-md-6 input group ">
          <label>Tanggal awal : <i style="color:red;">*</i></label>
          <div id="datetimepicker1" class="input-append">
              <input type="text" data-format="yyyy-MM-dd" value="<?php echo date('Y-m-d')?>" name="tgl1" class="form-control cek_tgl" placeholder="Tanggal awal" required>
              <span class="add-on">
                <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>   
            </div>
            <br>
          </div>
          <div class="col-md-6 input group ">
          <label>Tanggal akhir : <i style="color:red;">*</i></label>
          <div id="datetimepicker2" class="input-append">
              <input type="text" data-format="yyyy-MM-dd" name="tgl2" value="<?php echo date('Y-m-d')?>" class="form-control cek_tgl" placeholder="Tanggal akhir" required>
              <span class="add-on">
                <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>   
            </div>
            <br>
          </div>
          <div class="col-md-12">
            <div class="input-group">
              <button type="submit" name="laporan" value="" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Cek Produk Penurunan Harga</button> 
            </div>
          </div>
        </div>
      <?php echo form_close();?>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div>
<!-- Bootstrap modal edit-->
<div class="modal fade" id="modal_cek_produk_baru" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Tambah Produk Metode Lain</h3>
      </div>
        <div class="modal-body form">
        <div class="row">
          <?php echo form_open_multipart('trueaccon2194/produk/upload_produk_by_excel');?>
          <div class="col-md-12 input group ">
            <h4>1. Upload Masal Dengan Excel</h4>
            <label><a href="<?php echo base_url('trueaccon2194/produk/download_template_upload_produk');?>">Download template upload produk <i style="color:red;">*</i></a><br><i>Pastikan anda telah mengupload gambar utama dan telah menyinkronkan, upload masal ini hanya untuk melengkapi data produk lainnya</i></label>
            <input type="file" name="uploadprodukbyexcel" class="form-control">
          </div>
          <div class="col-md-12">
            <div class="input-group">
              <button type="submit" name="uploadproduk" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Upload Produk</button> 
            </div>
          </div>
          <?php echo form_close();?>
          <div class="col-md-12 input group ">
            <h4>2. Cek Produk Baru Layak Jual (Stok > 700)</h4>
            <label>Jumlah Produk Ditampilkan : <i style="color:red;">*</i></label>
            <input type="number" name="jml" class="form-control" id="jml" placeholder="Jumlah Ditampilkan" required>
          </div>
          <div class="col-md-12">
            <div class="input-group">
              <button type="submit" onclick="tampilkanprodukbaru();" name="laporan" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Tampilkan Produk</button> 
              <button type="submit" onclick="tampilkanprodukbarubyexcel();" name="laporan" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Download Produk (Excel)</button> 
            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div>
<!-- Bootstrap modal upload gambar-->
  <div class="modal fade" id="modal_upload_gambar_tambahan" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <span class="modal-title-upload">Book Form</span>
      </div>
      <div class="modal-body form">
          <div class="dropzone" id="dropzone">
            <div class="dz-message">
              <h3 class="txtgb"> Klik atau Drop gambar disini<br>file maksimal 2 MB<br><span style="font-size: 12px;">file yang diijinkan : gif, jpg, png, jpeg</span></h3>
            </div>
          </div>
          <input type="hidden" name="sku_produk" class="identity_produk" id="identity_produkx"/>
          <div class="modal-footer" style="padding:10px 0;">
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="resetFormUpload();">Tutup</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
  <!-- End Bootstrap modal -->
<script type="text/javascript">
  $(document).ready(function(){
      Dropzone.autoDiscover = false;
        // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
        //var baseURL = window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/';
        //var identitasx = $("#identity_produkx").val();
        //$('#dropzone').empty();
        var foto_upload = new Dropzone("#dropzone",{
        url: "<?php echo base_url('trueaccon2194/produk/uploadimageanyproduct');?>",
        maxFilesize: 2, 
        method:"post",
        acceptedFiles:"image/*, .jpeg, png, jpg, gif",
        paramName:"filelist",
        dictInvalidFileType:"Type file ini tidak dizinkan",
        addRemoveLinks:true,
        });
        //Event ketika Memulai mengupload
        foto_upload.on("sending",function(a,b,c){
          a.token=Math.random();
          //c.append("identitas",identitasx);
          c.append("token",a.token); //Menmpersiapkan token untuk masing masing foto
        });
        //Event ketika foto dihapus
        foto_upload.on("removedfile",function(a){
          var token=a.token;
          $.ajax({
            type:"post",
            data:{token:token},
            url: "<?php echo base_url('trueaccon2194/produk/hapusimageforproduct');?>",
            cache:false,
            dataType: 'json',
            success: function(){
              console.log("File dihapus");
            },
            error: function(){
              console.log("Error");

            }
          });
        });
      //tampil_data_barang();   //pemanggilan fungsi tampil barang.
      //$("#table_produk").DataTable();
       //datatables
      table = $('#table_produk').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('trueaccon2194/produk/load_produk_serverside')?>",
            "type": "POST",
            "data": function ( data ) {
                data.kategori = $('#kategori').val();
                data.status_produk = $('#status_produk').val();
                data.sort_by = $('#sort_by').val();
                data.size = $('#size').val();
                data.color = $('#color').val();
                data.tgl1 = $('#tgl1').val();
                data.tgl2 = $('#tgl2').val();
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //last column
            "orderable": false, //set not orderable
        },
        ],
    
      });

      $('.btn-filter').click(function(){ //button filter event click
          table.ajax.reload();  //just reload table
      });

      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd'
      });
      $('#datetimepicker3').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker4').datetimepicker({
        format: 'yyyy-MM-dd'
      });
  });
  $(function(){
    // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
    var baseURL = window.location.origin + '/';
      $('.seacrhart').autocomplete({
          serviceUrl: baseURL + 'trueaccon2194/produk/searchart',
          onSelect: function (res) {
              $('#artikel').val(''+res.artikel); 
          }
      });
  });
  function resetFormUpload(){
    $("#dropzone").empty();
  }

  function uploadanyimage(art){
    // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
      var baseURL = window.location.origin + '/';
      //$('#form_edit_warna')[0].reset(); // reset form on modals
      //Ajax Load data from ajax
      $.ajax({
        url : baseURL + "trueaccon2194/produk/ambil_data_upload/" + art,
        type: "GET",
        dataType: "JSON",
        success: function(get)
        {
            //$('#identity_produk').val(get.sku_produk);
            $('.modal-title-upload').text('Upload Gambar Tambahan Produk'); // Set title to Bootstrap modal title
            $('#modal_upload_gambar_tambahan').modal('show'); // show bootstrap modal when complete loaded
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
  }
</script>