<?php
$tgl1 = date("Y-m-d");
$tgl2 = date("Y-m-d", strtotime("-2 day"));

require_once 'dgfhjqyker3yruifdcx23/CekMt.php';
//$this->load->library('mtransc');
    $config = [
        'credential' => [
            'username' => 'achammad2102',
            'password' => 'danny2102',
        ],
        'nomor_rekening' => '0423596591',
        'range' => [
            'tgl_awal'  => date('d-M-Y',strtotime($tgl2)),
            'tgl_akhir' => date('d-M-Y',strtotime($tgl1))
        ],
]; 
        
    $bni = new CekMt($config);
    $getdata = $bni->toArray();    
    foreach($getdata as $key){ // URAI ARRAY MUTASI
        $ex1 = str_replace('IDR ', '', $key[3]);
        $ex2 = str_replace('.', '',$ex1);
        $ex3 = str_replace(',00', '', $ex2);

        $w = $this->home->get_order_menunggu_pembayaran();
        foreach($w as $h){ // DATA PENJUALAN 
            if($ex3 == $h->total_belanja){
                // UBAH STATUS
                $data_status = array(
                    'status' => '*^56t38H53gbb^%$0-_-'
                );
                $this->db->where('invoice', $h->invoice);
                $this->db->update('order_customer', $data_status);
                log_helper('laporan', 'Sistem mengubah otomatis order no. invoice '.$h->invoice.' menjadi pembayaran diterima (cek pembayaran otomatis)');
            }
        }
    }

?>