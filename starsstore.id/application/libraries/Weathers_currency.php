<?php
class Weathers_currency
{
    function databmkg(){
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://www.bmkg.go.id/cuaca/prakiraan-cuaca.bmkg?AreaID=501306&Prov=12',
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        if($resp !== false){
            $pecah = explode('<h2 class="blog-grid-title-lg">', $resp);
            $pecahLagi = explode('</button>', $pecah[1]);    
            return $pecahLagi[0];
        }else{
            return "";
        }
        //return $pecahLagi[0];
    }

    function gempa(){
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://www.bmkg.go.id',
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        if($resp !== false){
            $pecah = explode('<div class="col-md-4 md-margin-bottom-10">', $resp);
            $pecahLagi = explode('<section id="berita-press-release"></section>', $pecah[1]);    
            return $pecahLagi[0];
        }else{
            return "";
        }
    }
}
?>