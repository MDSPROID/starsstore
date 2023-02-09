<script type="text/javascript">
  $(document).ready( function () { 

      $("#table_merk").DataTable();
      
  });
</script>
<div class="page-title">
  <h3>Merk
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
      <li class="active">Merk</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
  <button style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left" onclick="tambah_merk()"><i class="glyphicon glyphicon-plus"></i> Tambah Merk</button>
  <button type="submit" class="btn btn-danger" name="submit"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
</div>
<div class="col-md-12 table-responsive">    
  <table id="table_merk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#1c2d3f;color:white;">
                    <th style="text-align:center;">Logo <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon  glyphicon-sort"></span></th>
                    <th style="text-align:center;">Merk <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="text-align:center;">Slug <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="width:140px;text-align:center;">Status <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="width:180px;text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($get_merk) > 0){
                foreach($get_merk as $data):
                ?>
               <tr>
                  <td><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="<?php if(empty($data->logo)){ echo base_url('assets/images/brand/default.jpg');}else{echo $data->logo;}?>" class="img-responsive" width="80"></td>
                  <td><?php echo $data->merk;?></td>
                  <td><?php echo $data->slug;?></td>
                  <td style="padding-top:15px;width:140px;text-align:center;"><?php 
                  if($data->aktif == "on"){
                    echo "<label style='position:relative;top:7px;' class='label label-success'>Aktif</label>";
                    }else{
                    echo "<label style='position:relative;top:7px;' class='label label-danger'>Tidak aktif</label>";
                      }?>
                  </td>
                  <td style="width:180px;text-align:center;">
                  <a href="<?php echo base_url()?>trueaccon2194/merk/edit_merk/<?php $a = $this->encrypt->encode($data->merk_id); $b= base64_encode($a); echo $b?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a href="javascript:void(0);" class="btn btn-danger" data-id="<?php $a = $this->encrypt->encode($data->merk_id); $b= base64_encode($a); echo $b?>" data-name="<?php echo $data->merk?>" onclick="hapus_merk(this)"><i class="glyphicon glyphicon-remove"></i></a>
                  </td>
              </tr>
             <?php 
            endforeach;}
            else{ echo "<tr><td colspan=5>DATA KOSONG!!</td></tr>";
              }?>
            </tbody>
  </table>
</div>
<?php echo form_close();?>


<!-- Bootstrap modal tambah-->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c2d3f;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">Book Form</h3>
      </div>
      <div class="modal-body form">
        <?php 
        $id = array('id' => 'form');
        echo form_open('', $id);
        ?>
          <input type="hidden" value="" name="id"/>
          <div class="row">
          <div class="col-md-6 col-xs-12 input group">
            <label>Merk :</label>
            <input type="text" name="merk" class="form-control" id="merk" placeholder="Nama Merk" required>
            <br>
          </div>
          <div class="col-md-6 col-xs-12 input group">
            <label>Logo :</label>
            <div class="input-group">
            <input type="text" name="logo" class="form-control" id="carfID">
            <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
            </span>
            </div>
            <br>
          </div>
          <div class="col-md-6 col-xs-12 input group">
            <label>Slug : <span style="color:red;">*ganti spasi dengan tanda (-)</span></label>
            <input type="text" name="slug" class="form-control" id="slug" placeholder="URL Kategori" required>
            <br>
          </div>
          <div class="col-md-6 col-xs-12 input group">
            <label>Status :</label>
            <div class="ios-switch switch-lg">
                <input type="checkbox" name="status" class="js-switch pull-right fixed-header-check" checked>
            </div>
            <br>
          </div>
          </div>
          <div class="input group">
            <label>Deskripsi :</label>
            <textarea class="ckeditor" name="editor1" id="editor1"></textarea>
          </div>
        <?php echo form_close();?>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" class="simpan_merk btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
  </div>
</div>
