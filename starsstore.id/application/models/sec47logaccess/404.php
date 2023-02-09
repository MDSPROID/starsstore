<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<link href="<?php echo base_url();?>qusour894/css/bootstrap.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="bg-parallax-1">
	<div class="container product-content text-center" style="margin-bottom:20px;margin-top: 25px;">
	<center>
		<img class="img-responsive" src="<?php echo base_url('qusour894/images/404.jpg')?>" width="300">
	</center>
		<h3>Produk yang anda cari tidak ditemukan.</h3>
	</div>
	<div class="container" style="margin-top:20px;">
	<div class="brand-container">
		<div class="best-seller-pro">
			<div class="slider-items-products">
				<div style="margin-bottom: -30px;">
					<span class="border-title">ANDA AKAN MENYUKAI</span>
				</div>
				<?php echo br(2);?>
				<div id="featured-slider" class="product-flexslider hidden-buttons">
					<div class="slider-items slider-width-col4"> 
					<?php foreach($get_produk_last as $produk):?>
	 					<!-- Item -->
						<div class="item-prev">
  							<div class="col-item">
    							<div class="img-thumbnail" style="border-radius: 0;padding: 0;"> 
    								<a class="product-image url-produk" href="<?php echo base_url()?>produk/<?php echo $produk->slug?>"> 
    								<?php if($produk->diskon == 0){
										echo "";
									}else{
										echo "<label class='diskon'>$produk->diskon%</label>";
									}?>
    								<img src="<?php echo $produk->gambar;?>" data-original="<?php echo $produk->gambar;?>" class="lazy img-responsive" /> 
    								<div class="text-product">
										<h3 class="product-title"><?php $nama = word_limiter($produk->nama_produk,5); echo $nama; ?></h3>
										<?php
                                            //$diskon = $produk->harga_retail-($produk->harga_retail*$produk->diskon/100);
                                            if($produk->diskon == 0){
                                                echo "<h4 class='harga_retail'>Rp.".number_format($produk->harga_retail,0,".",".")."</h4>";   
                                            }else{
                                                echo "<h5><s class='discount-title'>Rp.".number_format($produk->harga_retail,0,".",".")."</s> <harga class='harga_retail'>Rp.".number_format($produk->diskon_rupiah,0,".",".")."</harga></h5>"; 
                                        }?>
										<?php
											if($produk->rating_produk == 0){
												echo "<img src='".base_url()."qusour894/img/rating/0stars.png'  data-original='qusour894/img/rating/0stars.png' class='lazy' width='100'>";
											}elseif($produk->rating_produk <= 5){
												echo "<img src='".base_url()."qusour894/img/rating/1stars.png'  data-original='qusour894/img/rating/1stars.png' class='lazy' width='100'>";
											}elseif($produk->rating_produk <= 10){
												echo "<img src='".base_url()."qusour894/img/rating/2stars.png'  data-original='qusour894/img/rating/2stars.png' class='lazy' width='100'>";
											}elseif($produk->rating_produk <= 15){
												echo "<img src='".base_url()."qusour894/img/rating/3stars.png'  data-original='qusour894/img/rating/3stars.png' class='lazy' width='100'>";
											}elseif($produk->rating_produk <= 20){
												echo "<img src='".base_url()."qusour894/img/rating/4stars.png'  data-original='qusour894/img/rating/4stars.png' class='lazy' width='100'>";
											}elseif($produk->rating_produk <= 25 || $produk->rating_produk > 25){	
												echo "<img src='".base_url()."qusour894/img/rating/5stars.png'  data-original='qusour894/img/rating/5stars.png' class='lazy' width='100'>";
										}?>
									</div>
    								</a>
   								</div>
  							</div>
						</div>
						<!-- End Item -->
					<?php endforeach;?>
					</div>
					</div>
			</div>
		</div>
		</div>
	</div>
</div>
</body>
</html>