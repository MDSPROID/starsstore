<div class="page-title">
  <h3>Laporan Retur
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
      <li>Laporan</li>
      <li class="active">Laporan Retur</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
  <div class="col-md-12">
    <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
    <?php echo br(2);?>
  </div>
  <div class="col-md-12">
    <div class="tab-content" style="padding: 10px;box-shadow:0px 0px 8px 0px #bababa;">
      <div class="row">
        <?php if(empty($get_list)){?>
          <div class="col-md-12 text-center" style="color: red;">Data Kosong!</div>
        <?php }else{?>
          <div class="col-md-12">
          <div class="row">
            <div class="col-md-8">
              <h4><span style="margin-right: 34px;">Tanggal</span>: <?php echo date('d F Y' ,strtotime($tgl1));?> - <?php echo date('d F Y' ,strtotime($tgl2));?></h4>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-12">
            
              <div class="table-responsive">  
              <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
              <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Tanggal Retur</th>
                    <th style="text-align:center;">Nomor Retur</th>
                    <th style="text-align:center;">Invoice</th>
                    <th style="text-align:center;">Customer</th>
                    <th style="text-align:center;">Alasan Retur</th>
                    <th style="text-align:center;">Solusi</th>
                    <th style="text-align:center;">Tanggal Selesai Retur</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($get_list as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_retur_info;?>" /></td>
                  <td style="text-align:center;"><?php $t = $data->date_create; echo date('d F y H:i:s', strtotime($t));?></td>
                  <td style="text-align:center;"><?php echo $data->id_retur_info;?></td>
                  <td style="text-align:center;"><?php echo $data->invoice;?></td>
                  <td style="text-align:center;"><?php echo $data->nama_lengkap;?></td>
                  <td style="text-align:center;"><?php echo $data->alasan;?></td>
                  <td style="text-align:center;"><?php if($data->solusi == ""){ }else{ echo $data->solusi_retur; }?></td>
                  <td style="text-align:center;"><?php if($data->date_end == "0000-00-00 00:00:00"){ echo "<label class='label label-danger'>Belum Selesai / Masih dalam Proses</label>";}else{ $x = $data->date_end; echo date('d F y H:i:s', strtotime($x));}?></td>
                  <td style="text-align:center;">
                  <?php
                    if($data->status_retur == "JGErnoahs3721"){
                      echo "<label class='label label-danger'>Tidak Aktif / Dibatalkan</label>";
                    }else if($data->status_retur == "Kgh3YTsuccess"){
                      echo "<label class='label label-success'>Sukses</label>";
                    }else if($data->status_retur == "Ksgtvwt%t2ditangguhkan"){
                      echo "<label class='label label-warning'>Sedang diproses</label>";
                    }
                  ?></td>
                  <td style="text-align:center;">
                    <a href="<?php echo base_url()?>trueaccon2194/laporan_retur/cetak_laporan_retur/<?php $id = $this->encrypt->encode($data->id_retur_info); $idp = base64_encode($id); echo $idp ?>" class="btn btn-default hapus"><i class="glyphicon glyphicon-print"></i></a>
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
        <?php }?>
      </div>
    </div>
  </div>
</div>
</div>