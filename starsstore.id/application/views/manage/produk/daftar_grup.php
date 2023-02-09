<link href="<?php echo base_url('assets/manage/js/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/manage/js/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd'
      });         
      $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd'
      });
  });
</script>
<div class="page-title">
  <h3>Daftar Grup
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
      <li><a href="<?php echo base_url('trueaccon2194/produk')?>">Produk</a></li>
      <li><a class="active" href="<?php echo base_url('trueaccon2194/produk/produk_grouping')?>">Produk Grouping</a></li>
      <li><a class="active" href="javascript:void(0);">Daftar Group</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a class="btn btn-primary pull-left" href="javascript:history.go(-1)" style="margin-right:10px;margin-bottom:10px;"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a> 
  <a href="<?php echo base_url('trueaccon2194/produk/group_promo');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success"><i class="glyphicon glyphicon-th-large"></i> Group Promo</a>
  <a href="<?php echo base_url('trueaccon2194/produk/manual');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success"><i class="glyphicon glyphicon-th-large"></i> Grouping Manual</a>
  <a href="<?php echo base_url('trueaccon2194/produk/otomatis');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success"><i class="glyphicon glyphicon-th-large"></i> Grouping Otomatis</a>
</div>
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Grup</th>
                    <th style="text-align:center;">Posisi</th>
                    <th style="text-align:center;">Tanggal Mulai</th>
                    <th style="text-align:center;">Tanggal Berakhir</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($get_list) > 0){
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id;?>" /></td>
                  <td style="text-align:center;"><img src="<?php echo $data->gambar;?>" width="70"></td>
                  <td style="text-align:center;"><?php echo $data->name_group;?></td>
                  <td style="text-align:center;"><label class='btn btn-default'><?php echo $data->posisi;?></label></td>
                  <td style="text-align:center;"><label class='btn btn-default'><?php echo date('d F Y', strtotime($data->mulai));?></label></td>
                  <td style="text-align:center;"><label class='btn btn-default'><?php echo date('d F Y', strtotime($data->berakhir));?></label></td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php
                    if($data->status == "on"){
                      echo "<label class='btn btn-success'>Aktif</label>";
                    }else{
                      echo "<label class='btn btn-danger'>Tidak Aktif</label>";
                    }
                    ?>
                  </td>
                  <td style="text-align:center;font-size: 12px;">
                    <?php $id1 = $this->encrypt->encode($data->id); $idx = base64_encode($id1);?>
                    <a href="<?php echo base_url('trueaccon2194/produk/export_excel_group/'.$idx.'')?>" class="btn btn-success edit"><i class="glyphicon glyphicon-book"></i></a>

                    <a href="javascript:void(0);" onclick="detail_group_produk(this);" data-id="<?php $id = $this->encrypt->encode($data->id); $idp = base64_encode($id); echo $idp ?>" data-name="<?php echo $data->name_group?>" class="btn btn-default edit"><i class="glyphicon glyphicon-eye-open"></i></a>
                    <?php
                    $id = $this->encrypt->encode($data->id); 
                    $idp = base64_encode($id); 
                    if($data->status == "on"){
                      echo "<a style='padding:3px 8px;' href='".base_url('trueaccon2194/produk/off_group/'.$idp.'')."' class='btn btn-danger edit'>OFF</a>";
                    }else{
                      echo "<a style='padding:3px 8px;' href='".base_url('trueaccon2194/produk/on_group/'.$idp.'')."' class='btn btn-success edit'>ON</a>";
                    }
                    ?>
                    <a href="<?php echo base_url()?>trueaccon2194/produk/edit_daftar_grup/<?php $id = $this->encrypt->encode($data->id); $idp = base64_encode($id); echo $idp ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a href="<?php echo base_url('trueaccon2194/produk/hapus_group/'.$idp.'')?>" class="btn btn-danger hapus"><i class="glyphicon glyphicon-remove"></i></a>
                  </td>
              </tr>
             <?php 
            endforeach;}?>
            </tbody>
  </table>
</div>
<?php echo form_close();?>
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
        <div class="modal-body form" style="height: 250px;overflow-y: scroll;">
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
  <!-- End Bootstrap modal -->
