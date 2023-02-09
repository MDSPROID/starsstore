<?php  
$curl = curl_init();
$proxy = '192.168.0.219:80';

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
  //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10, 
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
    "key: 8e7d9a6d463e525fc266871130a04f88"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $data = json_decode($response, true);
  //echo json_encode($k['rajaongkir']['results']);

  /*
  for ($k=0; $k < count($data['rajaongkir']['results']); $k++){
   

    echo "<li='".$data['rajaongkir']['results'][$k]['code']."'>".$data['rajaongkir']['results'][$k]['service']."</li>";
  	//echo $data['rajaongkir']['results'][$k]['code'];
  }
  */
  //echo $data['rajaongkir']['results']['costs']['service'];
}
?>

<?php
	for ($k=0; $k < count($data['rajaongkir']['results']); $k++) {
		if(!$data['rajaongkir']['results'][$k]['costs']){
		echo "Expedisi tidak tersedia, silahkan pilih expedisi lain.";
	}else{
?>    
	<div class="atr-fnt" id="shipping">
		<?php
			for ($l=0; $l < count($data['rajaongkir']['results'][$k]['costs']); $l++) {			 
      $tarif1 = $data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value'];
      $tarif2 = $this->encrypt->encode($tarif1);
      $tarif = base64_encode($tarif2);
		?>
			<div class="radio">
				<label style="width: 100%;"><input data-price="<?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value'];?>" onclick="check_ship(this)" type="radio" name="checkshipping" value="<?php echo strtoupper($data['rajaongkir']['results'][$k]['name']);?>,<?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['service'];?>,<?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['description'];?>|<?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['etd'];?>hari|<?php echo $tarif?>"> <div style="font-weight:bold;"><?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['service'];?> - <?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['description'];?></div>
					 <h5>Estimasi <?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['etd'];?> hari <b class="pull-right">Rp. <?php echo number_format($data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value'],0,".",".");?></b></h5></label>
			</div>
		<?php }?>
	</div>
 <?php
 }}
 ?>