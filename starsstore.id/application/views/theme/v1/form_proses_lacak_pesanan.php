<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1472453182816875');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1472453182816875&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<!-- mt main start here -->
<main id="mt-main">
	<div class="product-detail-tab wow fadeInUp" data-wow-delay="0.4s">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				     <?php 
				      if($this->session->flashdata('error')):?>
				        <label style="padding: 10px;" class="label label-danger"><?php echo $this->session->flashdata('error')?></label>
				    <?php endif?>
				</div>
				<div class="col-md-12">
					<a class="label label-danger" style="background-color: red;padding:8px;color: white;" href="<?php echo base_url('lacak-pesanan');?>">Kembali</a>
					<div class="table-responsive" style="margin-top: 20px;">
						<table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
							<thead>
				                <tr style="background-color:#505050;color:white;">
				                    <th style="text-align:center;">Tanggal</th>
				                    <th style="text-align:center;">Invoice</th>
				                    <th style="text-align:center;">Pembelian Melalui</th>
				                    <th style="text-align:center;">Nama Pemesan</th>
				                    <th style="text-align:center;">Status</th>			                    
				                </tr>
				            </thead>
				            <tbody>
				            	<?php if($lacak =="" || empty($lacak)){
									echo "<td colspan='5' style='text-align:center;'>Nomor Pesanan Tidak Ditemukan<br><a class='label label-danger' href='".base_url('lacak-pesanan')."'>Kembali</a></td>";
								}else{
								?>
						    	<?php 
						    		foreach($lacak as $t):
						    	?>
				               	<tr style="background-color: white;color: black;">
				                  <td style="text-align:center;"><?php echo date('d F Y',strtotime($t->tanggal_order));?></td>
				                  <td style="text-align:center;"><?php echo $t->invoice;?></td>
				                  <td style="text-align:center;"><?php echo $t->buy_in;?></td>
				                  <td style="text-align:center;"><?php echo $t->nama_lengkap;?></td>
				                  <td style="text-align:center;"><?php
				                  if($t->status == "2hd8jPl613!2_^5"){
				                    echo "<label class='label label-warning'>Menunggu Pembayaran</label>";
				                  }else if($t->status == "*^56t38H53gbb^%$0-_-"){
				                    echo "<label class='label label-primary'>Pembayaran Diterima</label>";
				                  }else if($t->status == "Uywy%u3bShi)payDhal"){
				                    echo "<label class='label label-primary'>Dalam Pengiriman</label>";
				                  }else if($t->status == "ScUuses8625(62427^#&9531(73"){
				                    echo "<label class='label label-success'>Diterima</label>";
				                  }else if($t->status == "batal"){
				                    echo "<label class='label label-danger'>Dibatalkan</label>";
				                  }
				                  ?>
				                  </td>
				                </tr>
				                <?php endforeach;}?>
				           	</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- related products start here -->

</main><!-- mt main end here -->