<link href="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" rel="stylesheet" type="text/css"/>
 <script src="<?php echo base_url('assets/manage/js/bootstrap-tagsinput/bootstrap-tagsinput.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready( function () {

      $("#table_id").DataTable();
      $("#table_market").DataTable();
      
  });
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
      <li><a class="active" href="<?php echo base_url('trueaccon2194/online_store')?>">Market Place</a></li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12 col-xs-12">
<div class="row">
  <div class="col-md-6 col-xs-12">
    <div class="panel panel-white">
        <div class="panel-heading clearfix">
            <h4 class="panel-title">Login Akun</h4>
        </div>
        <div class="panel-body">
            <?php echo form_open('#');?>
                <div class="form-group">
                    <label for="exampleInputEmail1">Akun</label>
                     <select name="akun" id="exampleInputEmail1" class="form-control">
                      <?php foreach($get_akun as $f){?>
                        <option value="<?php echo $f->id_akun?>"><?php echo $f->nama_akun?></option>
                      <?php }?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Akses</label>
                    <select name="akun" id="exampleInputPassword1" class="form-control">
                      <option value="">-- Pilih  --</option>
                      <?php foreach($market as $m){?>
                        <option value="<?php echo $m->val_market?>"><?php echo $m->market?></option>
                      <?php }?>
                    </select>
                </div>
                <button style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left" onclick="login_akun_online_store()"><i class="glyphicon glyphicon-log-in"></i> Login Akun</button>
              <?php echo form_close()?>
        </div>
    </div>
  </div>
  <div class="col-md-6 col-xs-12">
    <div class="panel panel-white">
        <div class="panel-heading clearfix">
            <h4 class="panel-title">Menu</h4>
        </div>
        <div class="panel-body">  
          <div class="row">
            <div class="col-md-3 col-xs-6 text-center" onclick="tambah_kategori()">
              <div class="bt_mart">
                <h3 style="margin-top: 5px;"><i class="glyphicon glyphicon-user"></i></h3>
                Tambah Akun
              </div>
            </div>
            <div class="col-md-3 col-xs-6 text-center" onclick="input_manual_order(this)">
              <div class="bt_mart">
                <h3 style="margin-top: 5px;"><i class="glyphicon glyphicon-plus"></i></h3>
                Manual Pesanan
              </div>
            </div>
            <div class="col-md-3 col-xs-6 text-center" onclick="list_order_marketplace(this)">
              <div class="bt_mart">
                <h3 style="margin-top: 5px;"><i class="glyphicon glyphicon-book"></i></h3>
                Daftar Pesanan
              </div>
            </div>
            <div class="col-md-3 col-xs-6 text-center" onclick="tambah_market()">
              <div class="bt_mart">
                <h3 style="margin-top: 5px;"><i class="glyphicon glyphicon-globe"></i></h3>
                Tambah Marketplace
              </div>
            </div>
          </div>
              
        </div>
    </div>
  </div>
</div>
<div class="row">
  <?php echo br(3)?>
  <div class="col-md-12 table-responsive">   
    <table id="table_id" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
              <thead>
                  <tr style="background-color:#34425a;color:white;">
                      <th style="text-align:center;">Nama Akun <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                      <th style="text-align:center;">Email <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                      <th style="text-align:center;">Password <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                      <th style="width:180px;text-align:center;">Opsi</th>
                  </tr>
              </thead>
              <tbody>
                  <?php 
                  foreach($get_akun as $ambil_data):
                  ?>
                 <tr>
                    <td><?php echo $ambil_data->nama_akun;?></td>
                    <td><?php echo $ambil_data->email;?></td>
                    <td style="padding-top:15px;width:140px;text-align:center;">***********
                    </td>
                    <td style="width:180px;text-align:center;">
                    <a href="<?php echo base_url()?>trueaccon2194/online_store/edit_akun/<?php $id = $this->encrypt->encode($ambil_data->id_akun); $idf = base64_encode($id); echo $idf ?>" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger hapus" data-id="<?php $id = $this->encrypt->encode($ambil_data->id_akun); $idf = base64_encode($id); echo $idf ?>" data-name="<?php echo $ambil_data->nama_akun?>" onclick="hapus_kategori_divisi(this)"><i class="glyphicon glyphicon-remove"></i></a>
                    </td>
                </tr>
               <?php 
              endforeach;?>
              </tbody>
    </table>
  </div>
  <?php echo br(3);?>
  <div class="col-md-12 table-responsive">  
    <table id="table_market" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
              <thead>
                  <tr style="background-color:#34425a;color:white;">
                      <th style="text-align:center;">Nama Marketplace <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                      <th style="text-align:center;">Identity <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                      <th style="width:180px;text-align:center;">Opsi</th>
                  </tr>
              </thead>
              <tbody>
                  <?php 
                  foreach($market as $r):
                  ?>
                 <tr>
                    <td><?php echo $r->market;?></td>
                    <td><?php echo $r->val_market;?></td>
                    <td style="width:180px;text-align:center;">
                    <a href="javascript:void(0)" class="btn btn-danger hapus" data-id="<?php $id = $this->encrypt->encode($r->id); $idf = base64_encode($id); echo $idf ?>" data-name="<?php echo $r->market?>" onclick="hapus_market(this)"><i class="glyphicon glyphicon-remove"></i></a>
                    </td>
                </tr>
               <?php 
              endforeach;?>
              </tbody>
    </table>
  </div>
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
        echo form_open('trueaccon2194/online_store/tambah_akun', $id);
        ?>
          <div class="row">
          <div class="col-md-12 input group">
            <label>Nama Akun :</label>
            <input type="text" name="nama_akun" class="form-control" id="kat" placeholder="Nama Akun" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Email : </label>
            <input type="email" name="email" class="form-control" id="slug" placeholder="Email" required>
            <br>
          </div>
          <div class="col-md-6 input group">
            <label>Password :</label>
            <input type="text" name="password" class="form-control" id="ket" placeholder="password" required>
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
  <div class="modal fade" id="modal_market" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #34425a;color: white;">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title"></h3>
      </div>
      <div class="modal-body form">
        <?php 
        $id = array('id' => 'form');
        echo form_open('trueaccon2194/online_store/tambah_market', $id);
        ?>
          <div class="row">
            <div class="col-md-12 input group">
              <label>Market Place :</label>
              <input type="text" name="marketplace" class="form-control" id="kat" placeholder="Nama Marketplace" required>
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
