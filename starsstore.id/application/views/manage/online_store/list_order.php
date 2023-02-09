<link href="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/dropzone.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/js/dUp/basic.min.css');?>">
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
 <script src="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.min.js');?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/manage/js/druploadforlabelpengirimanmarketplace.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/dUp/dropzone.min.js')?>"></script>
<script type="text/javascript">
  $(document).ready( function () {
 
      //$("#table_id").DataTable();
      $("#table_id_parent").DataTable();
      table = $('#table_id').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('trueaccon2194/online_store/load_all_serverside')?>",
            "type": "POST",
            "data": function ( data ) {
                data.tgl1 = $('.awal').val();
                data.tgl2 = $('.akhir').val();
                data.buy_in = $('#buy_in').val();
                data.status = $('#status').val();
                data.dibayar = $('#dibayar').val();
                data.sender = $('#sender').val();
                data.sortby = $('#sortby:checked').val();
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
      
  });

  function update_status(){
    var selected = new Array();
    var tgl     = $("#tgl_selesaix").val();
    var st      = $("#statusx").val();
    var byr     = $("#dibayarx").val();
    // Read all checked checkboxes
    $("#table_id input[type=checkbox]:checked").each(function () {
        selected.push(this.value);
    });

    // Check checkbox checked or not
    if(st == "" || byr == ""){
        alert("Status Pesanan / Status Pembayaran Belum Dipilih");
    }else if (selected.length > 0) {

       // Confirm alert
       var confirmdelete = confirm("Apa anda yakin untuk mengubah status pesanan?");
       if (confirmdelete == true) {
          $.ajax({
             url: "<?php echo base_url('trueaccon2194/online_store/update_status_order_massal')?>",
            type: "POST",
             data: {checkorder: selected,tgl_selesai: tgl,status:st,dibayar:byr },
             success: function(response){
                table.ajax.reload(); // reload data
             }
          });
       } 
    }else{
      alert("Pilih Nomor Invoice");
    }
  }

  function tutuplabel(){
    $('#dropzone').html("<div class='dz-message' style='display:block;'><h3 class='txtgb'>Klik atau Drop dokumen label pengiriman dari marketplace<br>file maksimal 4 MB<br><span style='font-size: 12px;''>file yang diijinkan : pdf, word</span></h3></div>");
  }

  function uploadlabel(label){
    $('#dropzone').html("<div class='dz-message' style='display:block;'><h3 class='txtgb'>Klik atau Drop dokumen label pengiriman dari marketplace<br>file maksimal 4 MB<br><span style='font-size: 12px;''>file yang diijinkan : pdf, word</span></h3></div>");
    // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
      var baseURL = window.location.origin + '/';
      //$('#form_edit_warna')[0].reset(); // reset form on modals
      //Ajax Load data from ajax
      $.ajax({
        url : baseURL + "trueaccon2194/online_store/ambil_data_order/" + label,
        type: "GET",
        dataType: "JSON",
        success: function(get)
        {   if(get.tokenlabel != ""){
              $("#labeldownload").html(get.label);
            }else{
              $("#labeldownload").html("Label pengiriman belum diupload");
            }
            $('#inv').val(get.invoice);
            $('.modal-title-upload').text('Upload Label Pengiriman'); // Set title to Bootstrap modal title
            $('#modal_upload_label').modal('show'); // show bootstrap modal when complete loaded
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
  }
</script>
<div class="page-title">
  <h3>Market Place
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
      <li class="active">Daftar Order Market Place</li>
    </ol>
  </div>
</div>

<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a class="btn btn-primary pull-left" style="margin-right: 15px;" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
  <a href="javascript:void(0);" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left" onclick="input_manual_order(this)"><i class="glyphicon glyphicon-book"></i> Input Manual Order dari Market Place</a>
  <?php echo br(3)?>
  <div class="row">
    <div class="col-md-6 col-xs-12">
      <fieldset class="field-fix">
        <legend class="leg-fix">Filter</legend>
        <div class="row">
          <?php echo form_open('trueaccon2194/online_store/laporan_ist_toko');?>
          <div class="col-md-6 col-xs-12 input group ">
            <label>Tanggal awal : <i style="color:red;">*</i></label>
            <div id="datetimepicker1" class="input-append">
              <input type="text" data-format="yyyy-MM-dd" name="tgl1" class="form-control cek_tgl awal" placeholder="Tanggal awal" required>
              <span class="add-on">
                <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>   
            </div>
            <br>
          </div>
          <div class="col-md-6 col-xs-12 input group ">
            <label>Tanggal akhir : <i style="color:red;">*</i></label>
            <div id="datetimepicker2" class="input-append">
              <input type="text" data-format="yyyy-MM-dd" name="tgl2" class="form-control cek_tgl akhir" placeholder="Tanggal akhir" required>
              <span class="add-on">
                <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>   
            </div>
            <br>
          </div>
          <div class="col-md-3 col-xs-12">
            <label>Pembelian*</label>
            <select id="buy_in" name="buy_in" class="form-control">
              <option value="">Semua</option>
              <?php foreach($get_ol as $g){?>
                <option value="<?php echo $g->val_market?>"><?php echo $g->market?></option>
              <?php }?>
            </select>
          </div>
          <div class="col-md-3 col-xs-12">
            <label>Status Pesanan*</label>
            <select class="form-control" name="status" id="status">
              <option value="all">Semua</option>
              <option value="2hd8jPl613!2_^5">Menunggu Pembayaran</option>
              <option value="*^56t38H53gbb^%$0-_-">Pembayaran Diterima</option>
              <option value="Uywy%u3bShi)payDhal">Dalam Pengiriman</option>
              <option value="ScUuses8625(62427^#&9531(73">Diterima</option>
              <option value="batal">Batal</option>
            </select>
          </div>
          <div class="col-md-3 col-xs-12">
            <label>Status Dibayar*</label>
            <select class="form-control" name="dibayar" id="dibayar">
              <option value="">Semua</option>
              <option value="belum">Belum</option>
              <option value="bayar">Sudah</option>
            </select>
          </div>
          <div class="col-md-3 col-xs-12">
            <label>Toko Pengirim*</label>
            <select id="sender" name="sender" class="form-control">
              <option value="">Semua</option>
              <?php foreach($store_list as $xx){?>
                <option value="<?php echo $xx->kode_edp?>"><?php echo $xx->nama_toko?> [<?php echo $xx->kode_edp?>]</option>
              <?php }?>
            </select>
          </div>
          <div class="col-md-6 input group">
            <label>Sort By : <i style="color:red;">*</i></label><br>
              <label><input type="radio" name="sortby" id="sortby" class="form-control" value="tgl_order" required> Tanggal Order</label><br>
              <label><input type="radio" name="sortby" id="sortby" class="form-control" value="tgl_selesai" required checked> Tanggal Selesai Order (untuk closing)</label>
          </div>
          <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
            <a class="btn btn-success btn-filter">Filter</a> 
            <button type="submit" name="laporan" value="cetak_ist_toko_daripenjualan" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left btn-best"><i class="glyphicon glyphicon-book"></i> Laporan IST Toko dari Penjualan</button><br><br>
            <i style="color:red">*Laporan IST wajib menggunakan sort by tanggal order</i>
          </div>
          <?php echo form_close();?>
        </div>
        
      </fieldset>
      <?php echo br(2);?>
    </div>
    
    <div class="col-md-6 col-xs-12">
      <fieldset class="field-fix">
        <legend class="leg-fix">Update Status Order (Massal)</legend>
        <div class="row">
          <div class="col-md-12 input group ">
              <label>Tanggal Selesai Pesanan: <i style="color:red;">*</i></label>
              <div id="datetimepicker3" class="input-append">
                <input type="text" data-format="yyyy-MM-dd HH:mm:ss" name="tgl_selesai" id="tgl_selesaix" class="form-control" placeholder="Tanggal Selesai Pesanan">
                <span class="add-on">
                  <i style="font-size: 18px;position: absolute;top: 30px;right: 20px;" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>   
              </div>
              <br>
            </div>
          <div class="col-md-6 col-xs-12">
            <label>Status Pesanan*</label>
            <select class="form-control" name="status" id="statusx">
              <option value="">Semua</option>
              <option value="2hd8jPl613!2_^5">Menunggu Pembayaran</option>
              <option value="*^56t38H53gbb^%$0-_-">Pembayaran Diterima</option>
              <option value="Uywy%u3bShi)payDhal">Dalam Pengiriman</option>
              <option value="ScUuses8625(62427^#&9531(73">Diterima</option>
              <option value="batal">Batal</option>
            </select>
          </div>
          <div class="col-md-6 col-xs-12">
            <label>Status Dibayar*</label>
            <select class="form-control" name="dibayar" id="dibayarx">
              <option value="">Semua</option>
              <option value="belum">Belum</option>
              <option value="bayar">Sudah</option>
            </select>
          </div>
          <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
            <a class="btn btn-success" onclick="update_status();">Update Status</a>
          </div>
        </div>
      </fieldset>
      <?php echo br(2);?>
    </div>
  </div>
</div>
<div class="col-md-12 col-xs-12">
<div class="table-responsive">    
  <table id="table_id" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
    <thead>
      <tr style="background-color:#1c2d3f;color:white;">
        <th style="text-align:center;"><input type="checkbox" class="form-control" name="checkorder[]" onclick="checkorder();" /></th>
        <th style="text-align:center;">Invoice & Resi <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
        <th style="text-align:center;">Pembelian Melalui <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
        <th style="text-align:center;">Tanggal Order <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
        <th style="text-align:center;">Tanggal Selesai Order <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
        <th style="text-align:center;">Customer <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
        <th style="text-align:center;">Total Belanja <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
        <th style="text-align:center;">Status <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
        <th style="text-align:center;">Opsi <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>
</div>
</div>
</div>
<!-- Bootstrap modal upload gambar-->
  <div class="modal fade" id="modal_upload_label" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <span class="modal-title-upload">Book Form</span>
      </div>
      <div class="modal-body form">
          <div class="dropzone" id="dropzone">
            <div class="dz-message" style='display:block;'>
              <h3 class="txtgb">Klik atau Drop dokumen label pengiriman dari marketplace<br>file maksimal 4 MB<br><span style="font-size: 12px;">file yang diijinkan : pdf, word</span></h3>
            </div>
          </div>
          <input type="hidden" name="invoice" class="invoice" id="inv"/>
          <div class="modal-footer" style="padding:10px 0;">
            <div id="labeldownload" class="pull-left" style="text-align: left;"></div>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="tutuplabel();">Tutup</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
  <!-- End Bootstrap modal -->