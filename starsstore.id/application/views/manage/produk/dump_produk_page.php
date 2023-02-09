<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
  });
</script>
<div class="page-title">
  <h3>Produk 
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
      <li class="active" href="<?php echo base_url('trueaccon2194/produk/produk')?>">Produk</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
   <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
   <?php echo br(3);?>
</div>
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
            <thead>
                <tr style="background-color:#34425a;color:white;">
                    <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
                    <th style="text-align:center;">Gambar</th>
                    <th style="text-align:center;">Nama Project</th>
                    <th style="text-align:center;">Artikel</th>
                    <th style="text-align:center;display: none">Jenis Produk</th>
                    <th style="text-align:center;">Retail</th>
                    <th style="text-align:center;width:150px;display: none;">Stok Size</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($tong as $data):
                ?>
               <tr>
                  <td style="text-align:center;"><input type="checkbox" name="checklist[]" value="<?php echo $data->id_produk;?>" /></td>
                  <td style="text-align:center;"><img onError="this.onerror=null;this.src='<?php echo base_url('assets/images/produk/default.jpg');?>';" src="
                  <?php 
                    if(empty($data->gambar)){echo base_url('assets/images/produk/default.jpg');}else{echo $data->gambar;}?>" height="50"></td>
                  <td style="text-align:center;"><?php echo $data->nama_produk;?></td>
                  <td style="text-align:center;"><?php echo $data->artikel;?></td>
                  <td style="text-align:center;display: none;"></td>
                  <td style="text-align:center;">
                    <?php if($data->harga_dicoret == 0 || empty($data->harga_dicoret)){ 
                      echo "Rp. ".number_format($data->harga_fix,0,".",".")."";
                    }else{
                        echo "<s style='color:#989898 ;'>Rp. ".number_format($data->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($data->harga_fix,0,".",".")."</span>";
                        echo "<label class='label-diskon' style='margin-left:5px;'>".round(($data->harga_dicoret - $data->harga_fix) / $data->harga_dicoret * 100)." %</label>";
                    }?>
                  </td>
                  <td style="text-align:center;display: none;">
                    <?php
                          $idp = $data->id_produk;
                          $cek_parent = $this->produk_adm->get_list_produk_for_option_size($idp);           
                          foreach($cek_parent as $r){
                            if($r->stok <= 10){
                              $st = "<label class='btn btn-warning'>$r->stok</label>";
                            }else if($r->stok <= 30){
                              $st = "<label class='btn btn-primary'>$r->stok</label>";
                            }else if($r->stok > 30){
                              $st = "<label class='btn btn-success'>$r->stok</label>";
                            }
                            echo "<label class='btn btn-default'>$r->opsi_size</label> $st<br>";
                            }
                    ?>
                  </td>
                  <td style="text-align:center;"><label style='top:7px;position:relative;' class='label label-danger'>Outdated Data</label></td>
                  <td>
                    <a href="javascript:void(0)" class="btn btn-danger hapus" data-id="<?php $id = $this->encrypt->encode($data->id_produk); $idp = base64_encode($id); echo $idp ?>" data-name="<?php echo $data->nama_produk;?>" data-sku="<?php echo $data->sku_produk;?>" onclick="hapus_produk_ini(this);"><i class="glyphicon glyphicon-remove"></i></a> 
                    <a href="javascript:void(0)" class="btn btn-success renew" data-id="<?php $id = $this->encrypt->encode($data->id_produk); $idp = base64_encode($id); echo $idp ?>" data-name="<?php echo $data->nama_produk;?>" onclick="renew(this);"><i class="glyphicon glyphicon-saved"></i></a>
                  </td>
              </tr>
             <?php endforeach;?>
            </tbody>
  </table>
</div>
<?php echo form_close();?>
  </div>
</div>