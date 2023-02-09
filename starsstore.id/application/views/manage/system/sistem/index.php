<div class="page-title">
  <h3>Backup Dan Restore
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
      <li class="active">Backup dan Restore</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
  <div class="row">
    <div class="col-md-6"> 
        <div class="panel panel-default">
            <div class="panel-heading">Restore</div>
            <div class="panel-body" style="padding-top: 15px;">
                <?php
                $att=array(
                'class'=>'form-horizontal',
                'id'=>'import',
                );
                echo form_open_multipart("",$att);
                ?>
                <div class="form-group">
                    <label for="x" class="col-sm-3 control-label">Tabel</label>
                    <div class="col-sm-8">
                      <select name="tb1" id="tb1" class="form-control" required="">
                          <option value="">-Pilih Tabel</option>
                          <?php
                          $t1 = $this->db->list_tables();
                          foreach($t1 as $rf1)
                          {
                              ?>
                              <option value="<?php echo $rf1;?>"><?php echo ucwords($rf1);?></option>
                              <?php
                          }
                          ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="x" class="col-sm-3 control-label">Pilih File (xls/xlsx)</label>
                    <div class="col-sm-8">
                      <input type="file" class="form-control" id="file" name="file" required="" placeholder="Pilih File" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    </div>
                </div>
                <div class="form-group">
                    <label for="x" class="col-sm-3 control-label">Baris Ke</label>
                    <div class="col-sm-3">
                      <input type="number" class="form-control" id="mulai" name="mulai" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="x" class="col-sm-3 control-label">Hapus data sebelum dimasukkan (TRUNCATE)?</label>
                    <div class="col-sm-3">
                      <input type="checkbox" name="trn" class="form-control">
                    </div>
                </div>           
                <span class="text-info">
                    <ul>
                        <li>1. Kolom harus sesuai dengan nama field dan urutannya</li>
                        <li>2. Baris data adalah letak data pada file. <a href="javascript:showelement('img1','bd');" id="bd" data-id="0" class="btn btn-xs btn-flat btn-success"><i class="glyphicon glyphicon-picture"></i> Lihat contoh gambar</a> <img src="<?php echo base_url('assets/images/contoh.jpg');?>" class="img-responsive" id="img1" style="display:none"/></li>
                    </ul>
                </span>
                <div class="form-group">
                    <label for="x" class="col-sm-3 control-label"></label>
                    <div class="col-sm-8">
                      <button type="submit" id="importbtn" class="btn btn-flat btn-md btn-primary">Import Data</button>
                      <button type="reset" id="resetbtn" class="btn btn-flat btn-md btn-default">Reset Form</button>
                    </div>
                </div>
                <div id="respon1"></div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
      </div>
      <div class="col-md-6 col-xs-12">
          <div class="panel panel-default">
              <div class="panel-heading">Backup</div>
              <div class="panel-body" style="padding-top: 15px;">
              <?php
                  $att=array(
                  'class'=>'form-horizontal',
                  'id'=>'export',
                  );
                  echo form_open("",$att);
                  ?>
                  <div class="form-group">
                      <label for="x" class="col-sm-3 control-label">Tabel</label>
                      <div class="col-sm-8">
                        <select name="tb1" id="tb1" class="form-control" required="">
                            <option value="">-Pilih Tabel</option>
                            <?php                                  
                            foreach($t1 as $rf1)
                            {
                                ?>
                                <option value="<?php echo $rf1;?>"><?php echo ucwords($rf1);?></option>
                                <?php
                            }
                            ?>
                        </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="x" class="col-sm-3 control-label">Judul</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="title" name="title" required="">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="x" class="col-sm-3 control-label">Keterangan</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="description" name="description" required="" placeholder="Masukkan deskripsi data">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="x" class="col-sm-3 control-label"></label>
                      <div class="col-sm-8">
                        <button type="submit" id="exportbtn" class="btn btn-flat btn-md btn-primary">Import Data</button>
                      </div>
                  </div>
                  <div id="respon2"></div>
                  <?php
                  echo form_close();
                  ?>
              </div>
          </div>
      </div>
      <div class="col-md-12"> 
        <div class="panel panel-default">
            <div class="panel-heading">Update Master Artikel</div>
            <div class="panel-body" style="padding-top: 15px;">
                <?php
                $att=array(
                'class'=>'form-horizontal'
                );
                echo form_open_multipart("trueaccon2194/backup_and_restore/uploadsqlMaster",$att);
                ?>
                <div class="col-md-12 col-xs-12">
                  <label>Pilih File .SQL</label>
                  <input type="file" class="form-control" id="file" name="filesqlUpload" required="" placeholder="Pilih File" accept=".sql" style="margin-bottom:10px;">
                  <button type="submit" id="importbtn" class="btn btn-flat btn-md btn-primary">Upload</button>
                  <a onclick="syncimagewithdb();" href="javascript:void(0);" id="importbtn" class="btn btn-flat btn-md btn-success">Sync gambar RIM dengan database</a> <a onclick="confirmUpdate();" href="javascript:void(0);" id="importbtn" class="btn btn-flat btn-md btn-success">Update Harga Produk dari Master</a>
                </div>
                <div id="respon1"></div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
      </div>
  </div>
</div>
