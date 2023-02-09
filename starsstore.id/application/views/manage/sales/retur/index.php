<script type="text/javascript">
  $(document).ready( function () {

      table = $('#table_retur').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('trueaccon2194/retur/load_all_serverside')?>",
            "type": "POST",
            "data": function ( data ) {
                data.buy_in = $('#marketplace').val();
                data.tgl1   = $('#tgl1').val();
                data.tgl2   = $('#tgl2').val();
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
  <h3>Retur
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
      <li class="active"><a href="<?php echo base_url('trueaccon2194/retur')?>">Retur</a></li>
    </ol>
  </div>
</div> 
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a href="<?php echo base_url('trueaccon2194/retur/tambah_retur');?>" style="margin-right:10px;margin-bottom:10px;" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plus"></i> Tambah Retur</a>
  <?php echo form_open_multipart('trueaccon2194/retur/delete_select', array('class' => 'input-group'));?>
  <button name="submit" class="btn btn-danger" style="margin-right: 10px;"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
</div>
<div class="col-md-12 table-responsive">  
<div id="pesan"></div>
  <table id="table_retur" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;">
    <thead>
        <tr style="background-color:#34425a;color:white;">
            <th style="text-align:center;"><input type="checkbox" id="toggle" value="select" onClick="check()"></th>
            <th style="text-align:center;">Tanggal Retur</th>
            <th style="text-align:center;">Nomor Retur</th>
            <th style="text-align:center;">Invoice Retur dan Invoice Pengganti</th>
            <th style="text-align:center;">Alasan Retur</th>
            <th style="text-align:center;">Solusi</th>
            <th style="text-align:center;">Keterangan</th>
            <th style="text-align:center;">Opsi</th>
        </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>
<?php echo form_close();?>
  </div>
</div>