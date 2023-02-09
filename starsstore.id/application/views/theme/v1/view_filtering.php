<?php if(!empty($posts)): foreach($posts as $pk): ?>
<li>
<!-- mt product1 large start here -->
<div class="product-3 product-on-catalog">
	<?php 
	if($pk->harga_dicoret > 0 || $pk->harga_dicoret != ""){
		$diskon = round(($pk->harga_dicoret - $pk->harga_fix) / $pk->harga_dicoret * 100);
		echo "<span style='float:right;color:white;background-color:red;width:32px;font-family: Montserrat, sans-serif;padding: 9px 5px;border-radius:50px;font-size:10px;position:absolute;margin-left:50px;'>-".$diskon."%</span>";	
	}?>
	<div class="box mask-img-cat">
		<div class="b1">
			<div class="b2">
				<a href="<?php echo base_url('produk/'.$pk->slug_produk.'');?>"><img src="<?php echo $pk->gambar?>" alt="image description"></a>
			</div>
		</div>
	</div>
	<div class="txt">
		<strong class="title"><a href="<?php echo base_url('produk/'.$pk->slug_produk.'');?>"><?php $nama = word_limiter($pk->nama_produk,4); echo $nama; ?></a></strong>
		<span class="price">
			<?php if($pk->harga_dicoret == 0 || empty($pk->harga_dicoret)){ 
                  echo "Rp. ".number_format($pk->harga_fix,0,".",".")."";
            }else{
                  echo "<s>Rp. ".number_format($pk->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($pk->harga_fix,0,".",".")."</span>";
            }?>
		</span>
		<?php 
        $ongkirset = free_ongkir_all_city();
        $listcity = list_city_freeongkir();
        if($ongkirset['aktif'] == "on" || $listcity['city'] > 0){
         	$freeongkir = "<i class='fa fa-truck' style='font-size: 22px;bottom:8px;color: #9741cd;margin-right:110px;'><i style='font-size: 6px;position: absolute;left: 8.5px;top: 7px;color: white;font-family: arial;'>Free</i></i>";
        }else{
        	$freeongkir = "";
        }?>
		<?php
			if($pk->rating_produk == 0){
					echo "<div class='stars0'>".$freeongkir."</div>";
			}elseif($pk->rating_produk <= 5){
					echo "<div class='stars1'>".$freeongkir."</div>";
			}elseif($pk->rating_produk <= 10){
					echo "<div class='stars2'>".$freeongkir."</div>";
			}elseif($pk->rating_produk <= 15){
					echo "<div class='stars3'>".$freeongkir."</div>";
			}elseif($pk->rating_produk <= 20){
					echo "<div class='stars4'>".$freeongkir."</div>";
			}elseif($pk->rating_produk <= 25 || $pk->rating_produk > 25){	
					echo "<div class='stars5'>".$freeongkir."</div>";
			}
		?>
	</div>
</div><!-- mt product1 center end here -->
</li>
<?php endforeach; else: ?>
<li>
<div class="col-md-12 text-center" style="padding: 15px;"><h5 style="margin-top: 60px;">Pencarian tidak ditemukan, coba kata kunci lain.</h5></div>
</li>
<?php endif; ?>
<div class="col-xs-12 text-center"><?php echo $this->ajax_pagination->create_links(); ?></div>