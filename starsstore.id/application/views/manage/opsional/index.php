<script type="text/javascript">
  $(document).ready(function () { 

      $("#table_opsi_warna").DataTable();
      $("#table_opsi_ukuran").DataTable();
      
  });
</script>
<div class="page-title">
  <h3>Opsi Produk
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
      <li class="active">Opsi Produk</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">

<div class="col-md-4 col-xs-12">    
  <button style="margin-right:10px;margin-bottom:10px;" class="tambah_kolom_warna btn btn-success pull-left" onclick="tambah_warna()"><i class="glyphicon glyphicon-plus"></i> Tambah Warna</button>  
  <?php echo br(3);?>
    <table id="table_opsi_warna" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;">Warna </th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($get_opsi_warna) > 0){
                foreach($get_opsi_warna as $data):
                ?>
               <tr>
                  <td align="center"><b><?php echo $data->opsi_color;?></b></td>
                  <td style="text-align:center;">
                  <button onclick="edit_warna(<?php echo $data->id_opsi_color?>)" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></button>
                  <a href="javascript:void(0);" class="btn btn-danger" data-name="<?php echo $data->opsi_color?>" data-id="<?php echo $data->id_opsi_color?>" onclick="hapus_warna(this)"><i class="glyphicon glyphicon-remove"></i></a>
                  </td>
              </tr>
             <?php 
            endforeach;}
            else{ echo "<tr><td colspan=5>DATA KOSONG!!</td></tr>";
              }?>
            </tbody>
    </table>
</div>

<div class="col-md-4 col-xs-12">    
  <button style="margin-right:10px;margin-bottom:10px;" class="tambah_kolom_ukuran btn btn-success pull-left" onclick="tambah_ukuran()"><i class="glyphicon glyphicon-plus"></i> Tambah Ukuran</button>
  <?php echo br(3);?>
    <table id="table_opsi_ukuran" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;">Ukuran</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($get_opsi_size) > 0){
                foreach($get_opsi_size as $data):
                ?>
               <tr>
                  <td align="center"><b><?php echo $data->opsi_size;?></b></td>
                  <td style="text-align:center;">
                  <a href="javascript:void(0)" onclick="edit_ukuran(<?php echo $data->id_opsi_size;?>)" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a href="javascript:void(0);" class="btn btn-danger" data-name="<?php echo $data->opsi_size?>" data-id="<?php echo $data->id_opsi_size?>" onclick="hapus_ukuran(this)"><i class="glyphicon glyphicon-remove"></i></a>
                  </td>
              </tr>
             <?php 
            endforeach;}
            else{ echo "<tr><td colspan=5>DATA KOSONG!!</td></tr>";
              }?>
            </tbody>
    </table>
</div>
<div class="col-md-4">
  <h3>Input Product Option</h3>
  <div style="background-color: white;padding: 10px;">
      <?php echo form_open('#', array('id' => 'form_warna', 'class' => 'hidden'));?>
        <div id="place_warna"></div>
        <button type="button" class="simpan_warna btn btn-primary">Simpan Warna</button>
      <?php echo form_close();?>

      <?php echo form_open('#', array('id' => 'form_ukuran', 'class' => 'hidden'));?>
        <div id="place_ukuran"></div>
        <button type="button" class="simpan_ukuran btn btn-primary">Simpan Ukuran</button>
      <?php echo form_close();?>
  </div>
</div>

<div class="hidden">
  <div id="col_warna_add" class="hapus_warna_pilihan">
    <label onclick="hapus_pilihan_warna()" class="label label-danger">X</label>
    <input type="text" name="warna[]" class="form-control field_warna" placeholder="Masukkan Warna">
    <br>
  </div>
  <div id="col_ukuran_add">
    <label onclick="hapus_pilihan_ukuran()" class="label label-danger">X</label>
    <input type="text" name="ukuran[]" class="form-control field_ukuran" placeholder="Masukkan Ukuran">
    <br>
  </div>
</div>

<!-- Bootstrap modal edit-->
<div class="modal fade" id="modal_edit_warna" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Book Form</h3>
      </div>
      <div class="modal-body form">
        <?php 
        $id = array('id' => 'form_edit_warna');
        echo form_open('', $id);
        ?>
          <input type="hidden" value="" name="id_warna" id="id_warna"/>
          <input type="text" class="form-control" name="get_warna" id="get_warna">
          <div class="row">
          <div class="col-md-12 input group ukuran">
          </div>
        <?php echo form_close();?>
          </div>
          <div class="modal-footer" style="padding:10px 0;">
            <button type="button" class="update_warna btn btn-primary">Simpan Warna</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
  <!-- End Bootstrap modal -->

  <!-- Bootstrap modal edit-->
  <div class="modal fade" id="modal_edit_ukuran" role="dialog" style="margin-top:100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Book Form</h3>
      </div>
      <div class="modal-body form">
        <?php 
        $id = array('id' => 'form_edit_judul');
        echo form_open('', $id);
        ?>
          <input type="hidden" value="" name="id_ukuran" id="id_ukuran"/>
          <input type="text" class="form-control" name="get_ukuran" id="get_ukuran">
          <div class="row">
          <div class="col-md-12 input group ukuran">
          </div>
        <?php echo form_close();?>
          </div>
          <div class="modal-footer" style="padding:10px 0;">
            <button type="button" class="update_ukuran btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
  <!-- End Bootstrap modal -->

</div>
</div>
