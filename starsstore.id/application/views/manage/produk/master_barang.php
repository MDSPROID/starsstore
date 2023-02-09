<script type="text/javascript">
  $(document).ready( function () {

      $("#table_produk").DataTable();
  });
  $(function(){
    // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
    var baseURL = window.location.origin + '/';
      $('.seacrhart').autocomplete({
          serviceUrl: baseURL + 'trueaccon2194/produk/searchart',
          onSelect: function (res) {
              $('#artikel').val(''+res.artikel); 
          }
      });
  });
</script> 
<div class="page-title">
  <h3>Master Barang 
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
      <li><a href="<?php echo base_url('trueaccon2194/produk/produk')?>">Produk</a></li>
      <li class="active">Master Barang</li>
    </ol>
  </div>
</div>
<div id="main-wrapper">
<div class="row">
<div class="col-md-12 table-responsive">  
<div id="pesan"></div> 
  <h3>Cari Informasi Artikel</h3>
  <div class="input-group">
    <input class="" type="hidden" name="sess_mail" id="session_token" value="<?php $a=$this->encrypt->encode('lh743hG82#19'); $b=base64_encode($a); echo $b?>">
    <input type="text" name="inv" class="form-control list-form seacrhart" style="text-transform: uppercase;" id="art" placeholder="Artikel" required>
    <span class="input-group-btn">
      <button class="btn btn-danger mail_sb hj" onclick="cariFrommaster();">Cari</button>
    </span>
  </div>
  <div class="col-md-12 col-xs-12 info-success"><?php echo $this->session->flashdata('berhasil');?></div>
  <div class="col-md-12 col-xs-12 info-error"><?php echo $this->session->flashdata('error');?></div>
  <div class="page-preloader hidden" style="background-position: center;""></div>
  <div class="result"></div>
</div>
</div>
</div>