	<div class="page-footer">
		<?php $get_data_setting_footer = for_footer();?>
			<p class="no-s"><?php foreach($get_data_setting_footer as $data){?><?php echo $data->konten?><?php }?> | server time <strong>{elapsed_time}</strong> secs.</p>
	</div>
</div><!-- Page Inner -->
</main>
        <div class="cd-overlay"></div>
        <script type="text/javascript">
        var baseURL = '<?php echo base_url();?>';

    tinymce.init({
        selector: "textarea",
        theme: "modern",
        height: 300,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "responsivefilemanager link image",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor",
            "image"
        ],

        image_advtab: true,
        paste_data_images: true,
        
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager link image | print preview media fullpage | forecolor backcolor emoticons", 
        
        style_formats: [
            {title: "Bold text", inline: "b"},
            {title: "Red text", inline: "span", styles: {color: "#ff0000"}},
            {title: "Red header", block: "h1", styles: {color: "#ff0000"}},
            {title: "Example 1", inline: "span", classes: "example1"},
            {title: "Example 2", inline: "span", classes: "example2"},
            {title: "Table styles"},
            {title: "Table row 1", selector: "tr", classes: "tablerow1"}
        ],

        external_filemanager_path:" <?php echo base_url('Si345manim/filemanager');?>/",
        filemanager_title:"Filemanager",
        filemanager_access_key:"rOls54iLOFwb874GzQ15d0MmgEa94" ,
        external_plugins: {"filemanager" : "<?php echo base_url('Si345manim/filemanager/plugin.min.js');?>"}
    });        

  </script>
        <script src="<?php echo base_url('assets/manage/js/3d-bold-navigation/js/modernizr.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/offcanvasmenueffects/js/snap.svg-min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/jquery-ui/jquery-ui.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/pace-master/pace.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/jquery-blockui/jquery.blockui.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/autoCom/jquery.autocomplete.js')?>"></script>
        <script src="<?php echo base_url('assets/manage/js/switchery/switchery.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/uniform/jquery.uniform.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/offcanvasmenueffects/js/classie.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/offcanvasmenueffects/js/main.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/waves/waves.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/3d-bold-navigation/js/main.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/waypoints/jquery.waypoints.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/jquery-counterup/jquery.counterup.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/bootstrap-datepicker/js/bootstrap-datepicker.js')?>"></script>
        <script src="<?php echo base_url('assets/manage/js/toastr/toastr.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/flot/jquery.flot.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/flot/jquery.flot.time.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/flot/jquery.flot.symbol.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/flot/jquery.flot.resize.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/flot/jquery.flot.tooltip.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/curvedlines/curvedLines.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/metrojs/MetroJs.min.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/modern.js');?>"></script>
        <script src="<?php echo base_url('assets/manage/js/pages/dashboard.js');?>"></script>   

        <!-- respon carf -->
  <div class="modal fade" id="responCarif" role="dialog" style="margin-top:100px;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;color: black;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">File Manager</h3>
      </div>
      <div class="modal-body" style="padding: 0;">
            <iframe  frameborder="0" style="width: 100%;height: 565px;" src="<?php echo base_url('Si345manim/');?>filemanager/dialog.php?field_id=carfID&lang=en_EN&akey=rOls54iLOFwb874GzQ15d0MmgEa94">
            </iframe>
        </div>
      </div>
    </div>
    </div>
  <!-- End -->

  <!-- respon carf -->
  <div class="modal fade" id="responCarif1" role="dialog" style="margin-top:100px;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;color: black;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">File Manager</h3>
      </div>
      <div class="modal-body" style="padding: 0;">
            <iframe  frameborder="0" style="width: 100%;height: 565px;" src="<?php echo base_url('Si345manim/');?>filemanager/dialog.php?field_id=carfID1&lang=en_EN&akey=rOls54iLOFwb874GzQ15d0MmgEa94">
            </iframe>
        </div>
      </div>
    </div>
    </div>
  <!-- End -->

  <!-- respon carf -->
  <div class="modal fade" id="responCarif2" role="dialog" style="margin-top:100px;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;color: black;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">File Manager</h3>
      </div>
      <div class="modal-body" style="padding: 0;">
            <iframe  frameborder="0" style="width: 100%;height: 565px;" src="<?php echo base_url('Si345manim/');?>filemanager/dialog.php?field_id=carfID2&lang=en_EN&akey=rOls54iLOFwb874GzQ15d0MmgEa94">
            </iframe>
        </div>
      </div>
    </div>
    </div>
  <!-- End -->

  <!-- respon carf -->
  <div class="modal fade" id="responCarif3" role="dialog" style="margin-top:100px;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;color: black;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h3 class="modal-title">File Manager</h3>
      </div>
      <div class="modal-body" style="padding: 0;">
            <iframe  frameborder="0" style="width: 100%;height: 565px;" src="<?php echo base_url('Si345manim/');?>filemanager/dialog.php?field_id=carfID3&lang=en_EN&akey=rOls54iLOFwb874GzQ15d0MmgEa94">
            </iframe>
        </div>
      </div>
    </div>
    </div>
  <!-- End -->
</body>
</html>