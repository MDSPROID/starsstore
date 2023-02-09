<link href="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {

      $("#table_kat_divisi").DataTable();
      
  });
</script>
<div class="page-title">
  <h3>Kategori Divisi
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
      <li class="active" href="<?php echo base_url('trueaccon2194/kategori_dan_parent_kategori')?>">Kategori Divisi</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-12 col-xs-12">
    <button style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left" onclick="tambah_kategori()"><i class="glyphicon glyphicon-plus"></i> Tambah Kategori Divisi</button>
    <?php echo br(3)?>
      <div class="table-responsive">    
          <table id="table_kat_divisi" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Kategori <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="text-align:center;">Divisi <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="width:140px;text-align:center;">Status <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="width:180px;text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($data_kategori) > 0){

                foreach($data_kategori as $ambil_data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $ambil_data->kat_divisi_id;?>"/></td>
                  <td><?php echo $ambil_data->kode_kategori;?></td>
                  <td><?php echo $ambil_data->nama_kategori_divisi;?></td>
                  <td style="padding-top:15px;width:140px;text-align:center;"><?php 
                  if($ambil_data->aktif == "on"){
                    echo "<label style='position:relative;top:7px;' class='label label-success'>Aktif</label>";
                    }else{
                    echo "<label style='position:relative;top:7px;' class='label label-danger'>Tidak aktif</label>";
                      }?>
                  </td>
                  <td style="width:180px;text-align:center;">
                  <a href="<?php echo base_url()?>trueaccon2194/kategori_divisi/edit_kategori/<?php $id = $this->encrypt->encode($ambil_data->kat_divisi_id); $idf = base64_encode($id); echo $idf ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a href="javascript:void(0)" class="btn btn-danger hapus" data-id="<?php $id = $this->encrypt->encode($ambil_data->kat_divisi_id); $idf = base64_encode($id); echo $idf ?>" data-name="<?php echo $ambil_data->kode_kategori?>" onclick="hapus_kategori_divisi(this)"><i class="glyphicon glyphicon-remove"></i></a>
                  </td>
              </tr>
             <?php 
            endforeach;}
            else{ echo "<tr><td colspan=5>DATA KOSONG!!</td></tr>";
              }?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap modal tambah-->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #34425a;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title"></h3>
      </div>
      <div class="modal-body form">
        <?php 
        $id = array('id' => 'form');
        echo form_open('trueaccon2194/kategori_divisi/proses_tambah_kat_divisi', $id);
        ?>
          <div class="row">
            <div class="col-md-6 input group">
              <label>Kode Kategori :</label>
              <input type="text" name="kode_kategori" class="form-control" id="kat" placeholder="Kode Kategori" required>
              <br>
            </div>
            <div class="col-md-6 input group">
              <label>Kategori Divisi : </label>
              <input type="text" name="nm_kategori" class="form-control" id="slug" placeholder="Nama Kategori" required>
              <br>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnSave" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          </div>
        <?php echo form_close();?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  <!-- End Bootstrap modal -->
