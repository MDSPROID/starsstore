  <script type="text/javascript">
  $(document).ready( function () {

      $("#table_email").DataTable();

      //$("#table_id").DataTable();
      $("#table_id_parent").DataTable();

      table = $('#table_id').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('trueaccon2194/email/load_data_kontak')?>",
            "type": "POST",
            "data": function ( data ) {
                data.kategori = $('#kategori').val();
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
  });
</script>
<div class="page-title">
  <h3>Email 
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/email')?>">Email</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-12 col-xs-12 table-responsive">         
      <a href="<?php echo base_url('trueaccon2194/email/broadcast');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Buat Email Broadcast</a>
      <?php echo form_open_multipart('trueaccon2194/email/hapus_data_dipilih', array('id'=>'form_produk_add'));?>
      <button name="submit" class="btn btn-danger" style="margin-right: 10px;"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
      <?php echo br(3);?>
      <table id="table_email" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" name="iddata[]" onclick="check();"></th>
                    <th style="width:180px;text-align:left;">Kepada</th>
                    <th style="width:180px;text-align:center;">Judul</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Tanggal</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="iddata[]" value="<?php echo $data->id;?>" /></td>
                  <td style="text-align:left;"><div><b>From :</b> <?php echo $data->from?> <br><b>To : </b><label class="label label-success"><?php echo $data->to_type?></label></div></td>
                  <td style="text-align:center;"><?php echo $data->judul?></td>
                  <td style="text-align:center;">
                   <?php if($data->status == "terkirim"){
                      echo "<label style='padding:3px 8px;margin-bottom:5px;' class='label label-success'>Terkirim</label>"; 
                    }else {
                      echo "<label style='padding:3px 8px;margin-bottom:5px;' class='label label-danger'>Konsep</label>"; 
                    }?>
                  </td>
                  <td style="text-align:center;"><?php echo date('d F Y H:i:s',strtotime($data->date_created));?></td>
                  <td style="text-align:center;">
                    <?php 
                      $a = $this->encrypt->encode($data->id);
                      $b = base64_encode($a);
                    ?>    
                    <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/email/send_again/<?php echo $b?>" class="btn btn-primary"><i class="glyphicon glyphicon-send"></i></a>
                    <a style="margin-bottom:5px;" href="<?php echo base_url()?>trueaccon2194/email/edit_data/<?php echo $b?>" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
                  </td>
              </tr>
             <?php 
            endforeach;?>
            </tbody>
      </table> 
    </div>
    <?php echo form_close();?>

    <div class="col-md-12">
      <fieldset class="field-fix">
        <legend class="leg-fix">Filter</legend>
        <?php 
          $id = array('id' => 'fill-form');
          echo form_open('trueaccon2194/email/export_kontak_excel', $id);
        ?>
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <label>Kategori*</label>
            <select id="kategori1" name="kategori1" class="form-control">
              <option value="0">Semua</option>
              <option value="1">Generate WA Blaz</option>
              <option value="2">Toko</option>
              <option value="3">Kantor</option>
              <option value="4">Direktur</option>
              <option value="5">Div Promosi</option>
            </select>
          </div>
          <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
            <a style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left" onclick="tambah_kontak()"><i class="glyphicon glyphicon-plus"></i> Tambah Kontak</a>  
            <a href="<?php echo base_url('trueaccon2194/email/fixed_number');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-wrench"></i> Cek & Fixed Nomor</a> 
            <a class="btn btn-success btn-filter" style="margin-right:10px;">Filter</a> 
            <button name="filter" value="export" class="btn btn-success">Export Excel</button><br><br>
            <i style="color:red">*Import data kontak melalui database dengan format, cell A = nama, cell B = nomor, cell C = kategori. dan nama sheet harus "master_telp_blaz" dan file harus ber extension .ods</i>
          </div>
        </div>
        <?php echo form_close();?>
      </fieldset>
      <?php echo br(2);?>
    </div>
    <div class="col-md-12 col-xs-12">
      <div class="table-responsive">    
        <table id="table_id" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
          <thead>
            <tr style="background-color:#1c2d3f;color:white;">
              <th style="text-align:center;"><input type="checkbox" class="form-control" name="checklist[]" /></th>
              <th style="text-align:center;">Nama <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Nomor <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Kategori <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
              <th style="text-align:center;">Opsi <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap modal edit-->
<div class="modal fade" id="modal_edit_kontak" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Book Form</h3>
      </div>
      <div class="modal-body form">
        <?php 
        $id = array('id' => 'form_edit_kontak');
        echo form_open('', $id);
        ?>
          <input type="hidden" value="" name="id_kontak" id="id_kontak"/>
          <input type="text" class="form-control" name="get_nama" id="get_nama" style="margin-bottom: 10px;">
          <input type="text" class="form-control" name="get_kontak" id="get_kontak">
        <?php echo form_close();?>
          <div class="modal-footer" style="padding:10px 0;">
            <button type="button" class="update_kontak btn btn-primary" onclick="update_kontak();">Update Kontak</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
  <!-- End Bootstrap modal -->

  <!-- Bootstrap modal edit-->
<div class="modal fade" id="modal_tambah_kontak" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Tambah Kontak</h3>
      </div>
      <div class="modal-body form">
        <?php 
        $id = array('id' => 'form_tambah_kontak');
        echo form_open('', $id);
        ?>
          <label>Nama :</label>
          <input type="text" class="form-control" name="get_nama" id="get_nama" style="margin-bottom: 10px;">
          <label>Nomor :</label>
          <input type="text" class="form-control" name="get_kontak" id="get_kontak" style="margin-bottom: 10px;">
          <label>Kategori :</label>
          <select id="kategori" name="kategori" class="form-control">
              <option value="0">Semua</option>
              <option value="1">Generate WA Blaz</option>
              <option value="2">Toko</option>
              <option value="3">Kantor</option>
              <option value="4">Direktur</option>
              <option value="5">Div Promosi</option>
            </select>
        <?php echo form_close();?>
          <div class="modal-footer" style="padding:10px 0;">
            <button type="button" class="tambah_kontak btn btn-primary" onclick="tambah_kontakx();">Tambah Kontak</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
  <!-- End Bootstrap modal -->