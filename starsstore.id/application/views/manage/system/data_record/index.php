<script type="text/javascript">
  $(document).ready( function () {

      $("#table_record").DataTable();
      
  });
</script>
<div style="margin-top:-70px;"><h2>Aktifitas User</h2></div>
<?php echo br();?>
<div class="col-md-12 table-responsive">    
  <table id="table_record" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr style="background-color:#1c2d3f;color:white;">
                    <th style="width:200px;text-align:center;">Waktu <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="width:200px;text-align:center;">User <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="width:140px;text-align:center;">Tipe Akses <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                    <th style="width:300px;text-align:center;">Keterangan <span style="padding-top:5px;font-size:12px;" class="hidden-sm hidden-xs glyphicon glyphicon-sort"></span></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($get_all) > 0){
                foreach($get_all as $data):
                ?>
               <tr>
                  <td style="width:200px;text-align:center;"><?php echo $data->log_time;?></td>
                  <td style="width:200px;text-align:center;"><?php echo $data->log_user;?></td>
                  <td style="padding-top:15px;width:140px;text-align:center;"><?php echo $data->log_tipe;?></td>
                  <td style="width:300px;text-align:center;"><?php echo $data->log_desc;?></td>
              </tr>
             <?php 
            endforeach;}
            else{ echo "<tr><td colspan=5>DATA KOSONG!!</td></tr>";
              }?>
            </tbody>
  </table>
</div>