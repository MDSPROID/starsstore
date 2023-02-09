<?php 
	$b = for_header_front_end_banner_3_utama();
	foreach($b as $u){
		if($u->posisi == "utama_5"){
?>
	<a href="<?php echo base_url(''.$u->link.'')?>">
		<img class="hidden-xs" src="<?php echo $u->banner?>" style="width: 100%;height: auto;">
		<img class="hidden-lg hidden-md" src="<?php echo $u->for_banner3?>" style="width: 100%;height: auto;">
	</a>
<?php }}?>
<div class="container footer" style="padding-top:20px;">
	<div class="col-md-3 col-sm-12 col-xs-12">
		<h3 class="footer-head">Informasi</h3>
		<ul class="list-unstyled parent glik">
			<li><a href="<?php echo base_url('bantuan/tentang-kami');?>">Tentang Kami</a></li>
			<li><a href="<?php echo base_url('bantuan/syarat-dan-ketentuan');?>">Syarat dan ketentuan</a></li>
			<li><a href="<?php echo base_url('bantuan/kebijakan-privasi');?>">Kebijakan Privasi</a></li>
		</ul>
	</div>
	<div class="col-md-3 col-sm-12 col-xs-12">
		<h3 class="footer-head">Layanan Pelanggan</h3>
		<ul class="list-unstyled parent glik">
			<li><a href="<?php echo base_url('customer');?>">Akun Saya</a></li>
			<li><a href="<?php echo base_url('bantuan');?>">Hubungi Kami</a></li>
			<li><a href="<?php echo base_url('bantuan');?>">Pertanyaan</a></li>
			<li><a href="<?php echo base_url('lacak-pesanan');?>">Lacak Pesanan</a></li>
		</ul>
	</div>
	<div class="col-md-3 col-sm-12 col-xs-12">
		<h3 class="footer-head">Butuh Bantuan</h3>
		<ul class="list-unstyled parent glik">
			<li><a href="<?php echo base_url('bantuan');?>">Bantuan Pelanggan</a></li>
			<li><a href="<?php echo base_url('bantuan/cara-belanja');?>">Cara Berbelanja</a></li>
			<li><a href="<?php echo base_url('bantuan/informasi-pembayaran');?>">Pembayaran</a></li>
			<li><a href="<?php echo base_url('bantuan/informasi-pengiriman');?>">Info Pengiriman</a></li>
			<li><a href="<?php echo base_url('bantuan/transaksi-aman');?>">Transaksi Aman</a></li>
		</ul>
	</div>
	<div class="col-md-3 col-sm-12 col-xs-12">
		<h3 class="footer-head">Ikuti Kami</h3>
		<!-- Social Network of the Page -->
		<ul class="list-inline social-network">
			<li><a target="_new" href="https://www.instagram.com/stars.footwear"><i class="fa fa-instagram"></i></a></li>
			<li><a target="_new" href="https://twitter.com/starsallthebest"><i class="fa fa-twitter"></i></a></li>
			<li><a target="_new" href="https://www.facebook.com/starsallthebest"><i class="fb fa fa-facebook"></i></a></li>
			<li><a target="_new" href="https://www.youtube.com/channel/UCuy1wqC_-Wh8k5tFrm-q7sg"><i class="fa fa-youtube"></i></a></li>
		</ul>
		<h3 class="footer-head">Dapatkan Promo Menarik</h3>
		<div class="input-group">
			<input type="hidden" name="token_session_config" id="session_token" value="<?php $a=$this->encrypt->encode('Jsd63)263&31).?'); $b=base64_encode($a); echo $b?>">
			<div class="input-group">
            	<input type="text" name="newsletter" class="newsletter form-control" id="email" placeholder="Email / whatsapp" required>
            	<span class="input-group-btn">
            		<button onclick="berlangganan();" class="btn mail_sb"><i class="glyphicon glyphicon-envelope"></i></button>
            	</span>
            </div>
		</div><?php echo br();?>
	</div>
</div> 
<!-- footer of the Page -->
			<footer id="mt-footer">
				<!-- Footer Holder of the Page -->
				<div class="footer-holder">
					<div class="container divider">
						<div class="row">
							<nav class="col-xs-12 col-sm-6 col-md-6 f-widget-nav2">
								<!-- EXPEDISI ICON -->
								<div class="judulnav2">PENGIRIMAN</div>
								<ul class="list-inline">
									<li><label class="jne"></label></li>
									<li><label class="tiki"></label></li>
									<li><label class="pos"></label></li>
									<li><label class="jet"></label></li>
								</ul>
								<!-- Footer Nav of the Page end -->
							</nav>
							<div class="col-xs-12 col-sm-6 col-md-6 f-widget-nav3">
								<!-- PAYMENT ICON -->
								<div class="judulnav3">PEMBAYARAN</div>
								<ul class="list-inline">
									<li style="display: none;"><label class="hidden master_card"></label></li>
									<li style="display: none;"><label class="hidden visa"></label></li>
									<li style="display: none;"><label class="hidden gopay"></label></li>
									<li style="display: none;"><label class="hidden bca"></label></li>
									<li style="display: none;"><label class="hidden mandiri"></label></li>
									<li><label class="bni"></label></li>
								</ul>
								<!-- Social Network of the Page end -->
							</div>
						</div>
					</div>
				</div>
				<!-- Footer Holder of the Page end -->
				<!-- Footer area of the Page -->
				<div class="footer-area">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<p><a href="<?php echo base_url();?>"><span><?php $get_data_setting_footer = for_footer();?>
                                            <?php foreach($get_data_setting_footer as $data){?><?php echo $data->konten?><?php }?>
                                        </span></a></p>
							</div>
						</div>
					</div>
				</div>
				<!-- Footer area of the Page end -->
			</footer>
			<!-- footer of the Page end -->
		</div><!-- W1 end here -->
		<span id="back-top" class="fa fa-arrow-up"></span>
	</div>
<script src="<?php echo base_url('assets/theme/v1/');?>js/plugins.js"></script>
<script src="<?php echo base_url('assets/theme/v1/');?>js/jquery.main.js"></script>
<script src="<?php echo base_url('assets/global/js.cookie.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/zoom-image.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/global/common.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/global/')?>s497sd_09.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/global/autoCom/jquery.autocomplete.js')?>"></script>
<script src="//code.tidio.co/qjdpbjvaglwvz43wf5yqr8lj16zfxexu.js"></script>
</body>
</html>