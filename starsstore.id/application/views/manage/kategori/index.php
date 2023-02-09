<link href="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" rel="stylesheet" type="text/css"/>
 <script src="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {

      $("#table_id").DataTable();
      $("#table_id_parent").DataTable();
      
  });
</script>
<div class="page-title">
  <h3>Kategori & Parent Kategori
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
      <li class="active" href="<?php echo base_url('trueaccon2194/kategori_dan_parent_kategori')?>">Kategori & parent kategori</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">

<div class="col-md-6 col-xs-12">
  <button style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left" onclick="tambah_kategori()"><i class="glyphicon glyphicon-plus"></i> Tambah Kategori</button>
<?php echo br(3)?>
<div class="table-responsive">    
  <table id="table_id" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="text-align:center;">Kategori <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="text-align:center;">Slug <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
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
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $ambil_data->kat_id;?>"/></td>
                  <td><img src="<?php echo $ambil_data->gambar;?>" class="img-responsive" width="100"></td>
                  <td><?php echo $ambil_data->kategori;?></td>
                  <td><?php echo $ambil_data->slug;?></td>
                  <td style="padding-top:15px;width:140px;text-align:center;"><?php 
                  if($ambil_data->aktif == "on"){
                    echo "<label style='position:relative;top:7px;' class='label label-success'>Aktif</label>";
                    }else{
                    echo "<label style='position:relative;top:7px;' class='label label-danger'>Tidak aktif</label>";
                      }?>
                  </td>
                  <td style="width:180px;text-align:center;">
                  <a href="<?php echo base_url()?>trueaccon2194/kategori_dan_parent_kategori/edit_kategori/<?php $id = $this->encrypt->encode($ambil_data->kat_id); $idf = base64_encode($id); echo $idf ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a href="javascript:void(0)" class="btn btn-danger hapus" data-id="<?php $id = $this->encrypt->encode($ambil_data->kat_id); $idf = base64_encode($id); echo $idf ?>" data-name="<?php echo $ambil_data->kategori?>" onclick="hapus_kategori(this)"><i class="glyphicon glyphicon-remove"></i></a>
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
<div class="col-md-6 col-xs-12">
<button style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left" onclick="tambah_parent_kategori()"><i class="glyphicon glyphicon-plus"></i> Tambah Parent Kategori</button>
<?php echo br(3)?>
<div class="table-responsive">    
  <table id="table_id_parent" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="text-align:center;">Sub Kategori <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="width:180px;text-align:center;">Kategori Utama<span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="text-align:center;">Slug <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="width:140px;text-align:center;">Status <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="width:180px;text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($parent_kategori) > 0){

                foreach($parent_kategori as $ambil_data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $ambil_data->id_parent;?>"/></td>
                  <td><img src="<?php if(empty($ambil_data->gambar_parent)){ echo base_url('assets/images/kategori/default_parent.jpg');}else{ echo$ambil_data->gambar_parent;}?>" class="img-responsive" width="100"></td>
                  <td><?php echo $ambil_data->parent_kategori;?></td>
                  <td style="width:180px;text-align:center;padding-top:15px;">
                    <label style='position:relative;top:7px;' class='label label-primary'><?php echo $ambil_data->kategori?></label>
                  </td>
                  <td><?php echo $ambil_data->slug_parent;?></td>
                  <td style="padding-top:15px;width:140px;text-align:center;"><?php 
                  if($ambil_data->aktif == "on"){
                    echo "<label style='position:relative;top:7px;' class='label label-success'>Aktif</label>";
                    }else{
                    echo "<label style='position:relative;top:7px;' class='label label-danger'>Tidak aktif</label>";
                      }?>
                  </td>
                  <td style="width:180px;text-align:center;">
                  <a href="<?php echo base_url()?>trueaccon2194/kategori_dan_parent_kategori/edit_parent_kategori/<?php $id = $this->encrypt->encode($ambil_data->id_parent); $idf = base64_encode($id); echo $idf ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a href="javascript:void(0)" class="btn btn-danger hapus" data-id="<?php $id = $this->encrypt->encode($ambil_data->id_parent); $idf = base64_encode($id); echo $idf ?>" data-name="<?php echo $ambil_data->parent_kategori?>" onclick="hapus_parent_kategori(this)"><i class="glyphicon glyphicon-remove"></i></a>
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
        echo form_open('trueaccon2194/kategori_dan_parent_kategori/proses_tambah_kat', $id);
        ?>
          <div class="row">
          <div class="col-md-6 input group">
            <label>Kategori :</label>
            <input type="text" name="kat" class="form-control" id="kat" placeholder="Nama Kategori" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Slug : <i style="color:red;">*ganti spasi dengan tanda (-)</i></label>
            <input type="text" name="slug" class="form-control" id="slug" placeholder="URL Kategori" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Keterangan :</label>
            <input type="text" name="keterangan" class="form-control" id="ket" placeholder="Keterangan" required>
          </div>
          <div class="col-md-6 input group">
            <label>Kata Kunci :</label>
            <input type="text" name="kata_kunci" class="form-control" id="kata_kunci" data-role="tagsinput" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Gambar : <i style="color:red;">*Gambar tidak boleh diatas 1MB</i></label>
            <div class="input-group">
            <input type="text" name="gambar" class="form-control gambar" id="carfID">
            <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif"><i class="glyphicon glyphicon-search"></i></a>
            </span>
            </div>
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

  <!-- Bootstrap modal tambah-->
  <div class="modal fade" id="modal_form_parent" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #34425a;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title"></h3>
      </div>
      <div class="modal-body form">
        <?php 
        $id = array('id' => 'form');
        echo form_open('trueaccon2194/kategori_dan_parent_kategori/proses_tambah_parent_kat', $id);
        ?>
          <div class="row">
          <div class="col-md-6 input group">
            <label>Parent Kategori :</label>
            <input type="text" name="parent_kategori" class="form-control" id="parent_kat" placeholder="Nama Parent Kategori" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>kategori :</label>
            <select class="form-control" name="kategori" id="kategori">
                <?php foreach($load_option_kat_for_index as $data){ ?>
              <option value="<?php echo $data['kat_id'];?>"><?php echo $data['kategori'];?></option>
                <?php }?>
            </select>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Slug : <i style="color:red;">*ganti spasi dengan tanda (-)</i></label>
            <input type="text" name="slug" class="form-control" id="slug" placeholder="URL Kategori" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Keterangan :</label>
            <input type="text" name="keterangan" class="form-control" id="ket" placeholder="Keterangan" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Kata Kunci :</label>
            <input type="text" name="kata_kunci" class="form-control" id="kata_kunci" data-role="tagsinput" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Gambar : <i style="color:red;">*Gambar tidak boleh diatas 1MB</i></label>
            <div class="input-group">
            <input type="text" name="gambar" class="form-control gambar" id="carfID1">
            <span class="input-group-addon"><a data-toggle="modal" href="javascript:;" data-target="#responCarif1"><i class="glyphicon glyphicon-search"></i></a>
            </span>
            </div>
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
