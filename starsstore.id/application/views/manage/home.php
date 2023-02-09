<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/css/bmkg/css/weather-icons.css');?>">

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/manage/css/bmkg.css');?>">

                <div class="page-title">

                    <h3>Dashboard</h3>

                    <div class="page-breadcrumb">

                        <ol class="breadcrumb">

                            <li><a href="">Home</a></li>

                            <li class="active">Dashboard</li>

                        </ol> 

                    </div> 

                </div>

                <div id="main-wrapper">

                    <div class="row"> 

                        <div class="col-lg-3 col-md-6">

                            <div class="panel info-box panel-white" style="border-left: 5px solid #22baa0 !important;">

                                <div class="panel-body">

                                <a href="<?php echo base_url('trueaccon2194/customer');?>">

                                    <div class="info-box-stats">

                                        <p class="counter"><?php echo count($count_user);?></p>

                                        <span class="info-box-title">Pelanggan Terdaftar</span>

                                    </div>

                                    <div class="info-box-icon">

                                        <i class="icon-users" style="color: #22baa0"></i>

                                    </div>

                                    <div class="info-box-progress">

                                        <div class="progress progress-xs progress-squared bs-n user-progress">

                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo count($count_user);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo count($count_user);?>%;">

                                            </div>

                                        </div>

                                    </div>

                                </a>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-6">

                            <div class="panel info-box panel-white" style="border-left: 5px solid #12afcb !important;">

                                <div class="panel-body">

                                <a href="<?php echo base_url('trueaccon2194/produk_dilihat');?>">

                                    <div class="info-box-stats">

                                        <p class="counter"><?php echo count($count_product_view);?></p>

                                        <span class="info-box-title">Produk dilihat</span>

                                    </div>

                                    <div class="info-box-icon">

                                        <i class="icon-eye" style="color: #12afcb"></i>

                                    </div>

                                    <div class="info-box-progress">

                                        <div class="progress progress-xs progress-squared bs-n pr-progress">

                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo count($count_product_view);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo count($count_product_view);?>%;">

                                            </div>

                                        </div>

                                    </div>

                                </a>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-6">

                            <div class="panel info-box panel-white" style="border-left: 5px solid #f25656 !important;">

                                <div class="panel-body">

                                <a href="<?php echo base_url('trueaccon2194/produk_dibeli');?>">

                                    <div class="info-box-stats">

                                        <p><small>Rp.</small> <span><?php echo number_format($total_order,0,".",".");?></span></p>

                                        <span class="info-box-title">Total pesanan (<?php echo $total_pesanan?>)</span>

                                    </div>

                                    <div class="info-box-icon">

                                        <i class="icon-basket" style="color: #f25656"></i>

                                    </div>

                                    <div class="info-box-progress">

                                        <div class="progress progress-xs progress-squared bs-n cart-progress">

                                            <?php

                                                if($total_order <= "1000000"){

                                                    $progress = "10";

                                                }else if($total_order > "1000000" && $total_order <= "10000000"){

                                                    $progress = "20";

                                                }else if($total_order > "10000000" && $total_order <= "30000000"){

                                                    $progress = "30";

                                                }else if($total_order > "30000000" && $total_order <= "50000000"){

                                                    $progress = "50";

                                                }else if($total_order > "50000000" && $total_order <= "60000000"){

                                                    $progress = "60";

                                                }else if($total_order > "60000000" && $total_order <= "70000000"){

                                                    $progress = "70";

                                                }else if($total_order > "70000000" && $total_order <= "80000000"){

                                                    $progress = "80";

                                                }else if($total_order > "80000000" && $total_order <= "90000000"){

                                                    $progress = "90";

                                                }else if($total_order > "90000000"){

                                                    $progress = "100";

                                                }else 

                                            ?>

                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress?>%">

                                            </div>

                                        </div>

                                    </div>

                                </a>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-6">

                            <div class="panel info-box panel-white" style="border-left: 5px solid #cddc39 !important;">

                                <div class="panel-body">

                                    <div class="info-box-stats">

                                        <p class="counter"><?php echo count($mail_send);?></p>

                                        <span class="info-box-title">Email Terkirim</span>

                                    </div>

                                    <div class="info-box-icon">

                                        <i class="icon-envelope"  style="color: #cddc39"></i>

                                    </div>

                                    <div class="info-box-progress">

                                        <div class="progress progress-xs progress-squared bs-n ml-progress">

                                            <div class="progress-bar progress-bar-gr" role="progressbar" aria-valuenow="<?php count($mail_send);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo count($mail_send);?>%">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div><!-- Row -->

                    <div class="row">

                        <div class="col-lg-2 col-sm-4 col-md-4 ctn-1">

                            <div class="panel" style="border-top:3px solid #ffc107;padding-top:10px;box-shadow:0px 0px 8px 0px #bababa;background-color:#28a745;">

                              <div class="panel-body" style="padding:10 0;">

                                <div class="c100 center p<?php if($today == 0){ echo "0";}else { echo $today ;}?> green">

                                  <span><b><?php if($today == 0){ echo "0";}else { echo $today; }?></b></span>

                                  <div class="slice">

                                    <div class="bar"></div>

                                    <div class="fill"></div>

                                  </div>

                                </div>

                              </div>

                              <div class="panel-heading text-center" style="height: auto;color: white;"><b><span style="font-size: 20px;">Penjualan</span><br>Hari ini</b></div>

                            </div>

                        </div>

                        <div class="col-lg-2 col-sm-4 col-md-4 ctn-1">

                            <div class="panel" style="border-top:3px solid #ffc107;padding-top:10px;box-shadow:0px 0px 8px 0px #bababa;background-color:#ffc107;">

                              <div class="panel-body" style="padding:10 0;">                                

                                <div class="c100 center p<?php if($week == 0){ echo "0";}else { echo $week; }?> orange">

                                  <span><b><?php if($week == 0){ echo "0";}else { echo $week; }?></b></span>

                                  <div class="slice">

                                    <div class="bar"></div>

                                    <div class="fill"></div>

                                  </div>

                                </div>

                              </div>

                               <div class="panel-heading text-center" style="height: auto;color: white;"><b><span style="font-size: 20px;">Penjualan</span><br>Minggu ini</b></div>

                            </div>

                        </div>

                        <div class="col-lg-2 col-sm-4 col-md-4 ctn-1">

                            <div class="panel" style="border-top:3px solid #ffc107;padding-top:10px;box-shadow:0px 0px 8px 0px #bababa;background-color:#343a40;">

                              <div class="panel-body" style="padding:10 0;">

                                <div class="c100 center p<?php if($month == 0){ echo "0";}else { echo $month; }?>">

                                  <span><b><?php if($month == 0){ echo "0";}else { echo $month; }?></b></span>

                                  <div class="slice">

                                    <div class="bar"></div>

                                    <div class="fill"></div>

                                  </div>

                                </div>

                              </div>

                               <div class="panel-heading text-center" style="height: auto;color: white;"><b><span style="font-size: 20px;">Penjualan</span><br>Bulan ini</b></div>

                            </div>

                        </div>

                        <div class="col-lg-6 col-sm-12 col-md-12">

                            <div class="panel" style="border-top:3px solid #ffc107;padding-top:5px;background-color:white;">

                              <div class="panel-heading text-center"><b style="font-size: 20px;font-weight: 600;">Koneksi Media Sosial</b></div>

                              <div class="panel-body" style="padding:10 0;">

                                <div class="col-md-12 text-center">

                                    <i class="fa fa-instagram" style="font-size: 50px;color: #616161"></i><br>

                                    <script type="text/javascript">

                                    var token = '1795454921.1677ed0.80a46416b7df48c49fddae973e4a13f1';

                                        $.ajax({

                                        url: 'https://api.instagram.com/v1/users/self',

                                        dataType: 'jsonp',

                                        type: 'GET',

                                        data: {access_token: token},

                                        success: function(data){

                                            if(data.status === undefined ){

                                                $(".fl").text('-'); // following : follows

                                                $(".fli").text('-');

                                                $(".flname").text('-');

                                            }else{
                                                var follower = data['data']['counts']['followed_by'];

                                                var following = data['data']['counts']['follows'];

                                                var fullname = data['data']['full_name'];

                                                $(".fl").text(follower); // following : follows

                                                $(".fli").text(following);

                                                $(".flname").text(fullname);
                                            }

                                        },

                                        error: function(data){

                                        console.log(data);

                                        }

                                        });

                                    </script>

                                    <span class="flname"></span>

                                </div>

                                <div class="col-md-6 text-center">

                                    <h3>Followers</h3>

                                    <h1 class="fl text-center" style="color: #b1d817;font-weight: 600;margin-top: 0;margin-bottom: 0;"></h1>

                                </div>

                                <div class="col-md-6 text-center">

                                    <h3>Following</h3>

                                    <h1 class="fli text-center" style="color: cornflowerblue;font-weight: 600;margin-top: 0;margin-bottom: 0;"></h1>

                                </div>

                              </div>

                            </div>

                        </div>

                        <div class="col-lg-4 col-sm-12 col-md-12">

                            <div class="panel" style="border-top:3px solid #ffc107;padding-top:5px;background-color:white;">

                              <div class="panel-heading text-center"><b style="font-size: 18px;">Grafik Penjualan By Market Tahun Ini</b></div>

                              <div class="panel-body" style="padding-bottom: 15px;">

                                <div id="mygraph3"></div>

                                <script type="text/javascript">

                                    $('#mygraph3').highcharts({

                                        chart: {

                                          type: 'pie',

                                          marginTop: 10

                                        },

                                        credits: {

                                          enabled: false

                                        }, 

                                        //tooltip: {

                                        //  pointFormat: '{series.name}: <b>{series.data.}pasang</b>'

                                        //},

                                        title: {

                                          text: ''

                                        },

                                        subtitle: {

                                          text: ''

                                        },

                                        xAxis: {

                                          categories: [''],

                                          labels: {

                                           style: {

                                            fontSize: '10px',

                                            fontFamily: 'Verdana, sans-serif'

                                           }

                                          }

                                        },

                                        legend: {

                                          enabled: true

                                        },

                                        plotOptions: {

                                           pie: {

                                             allowPointSelect: true,

                                             cursor: 'pointer',

                                             dataLabels: {

                                               enabled: false

                                             },

                                             showInLegend: true

                                           }

                                        },



                                        series: [{

                                           'name':'Terjual',

                                           'data':[

                                            <?php

                                              foreach($penjualan_by_sosmed_dan_mp as $pnj_type){                             

                                            ?>

                                             ['<?php echo $pnj_type->buy_in; ?> (<?php echo $pnj_type->jual_pasang; ?> psg)',<?php echo $pnj_type->jual_pasang; ?>],

                                            <?php }?>

                                           ]

                                        }]

                                    });

                                </script>

                                <?php 

                                    $psg1 = 0;

                                    $hrg1 = 0;

                                    foreach($penjualan_by_sosmed_dan_mp_price_calc as $t){

                                        $psg1 += $t->jual_pasang;

                                        $hrg1 += $t->harga_pasang;

                                    }

                                ?>

                                <div class="col-md-6 col-xs-6 text-center"><h4><?php echo $psg1?> Pasang</h4></div>

                                <div class="col-md-6 col-xs-6 text-center"><h4>Rp. <?php echo number_format($hrg1,0,".",".");?></h4></div>

                              </div>

                            </div>

                        </div>

                        <div class="col-lg-8 col-sm-12 col-md-12">

                            <div class="panel panel-white">

                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="visitors-chart">

                                            <div class="panel-heading">

                                                <h4 class="text-center" style="font-size:18px;">Penjualan By Market Sepanjang Tahun</h4>

                                            </div>

                                            <div class="panel-body">

                                                <div id="mygraph4"></div>

                                                <?php 

                                                    $psg2 = 0;

                                                    $hrg2 = 0;

                                                    foreach($penjualan_by_sosmed_dan_mp_all_price_calc as $xx){

                                                        $psg2 += $xx->jual_pasang;

                                                        $hrg2 += $xx->harga_pasang;

                                                    }

                                                ?>

                                                <div class="col-md-6 col-xs-6 text-center"><h4><?php echo $psg2?> Pasang</h4></div>

                                                <div class="col-md-6 col-xs-6 text-center"><h4>Rp. <?php echo number_format($hrg2,0,".",".");?></h4></div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-8 col-sm-12 col-md-12">

                            <div class="panel panel-white">

                                <div class="row">

                                    <div class="col-sm-8">

                                        <div class="visitors-chart">

                                            <div class="panel-heading">

                                                <h4 class="panel-title">Produk Insight</h4>

                                            </div>

                                            <div class="panel-body">

                                                <div id="graph"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-4">

                                        <div class="stats-info">

                                            <div class="panel-heading">

                                                <h4 class="panel-title">10 Produk Best Seller</h4>

                                            </div>

                                            <div class="panel-body">

                                                <ul class="list-unstyled">

                                                    <?php foreach($produk_paling_laris as $g){?>

                                                        <li><?php echo word_limiter($g->nama_produk, 4);?><div class="text-success pull-right"><?php echo $g->total?> pcs</div></li>

                                                    <?php }?>

                                                </ul>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-4 col-sm-12 col-md-12">

                            <div class="panel" style="border-top:3px solid #ffc107;padding-top:5px;background-color:white;">

                              <div class="panel-heading text-center"><b style="font-size: 18px;">Penjualan Per Bulan</b></div>

                              <div class="panel-body" style="padding:0;">

                                    <div id="mygraph2"></div>

                                    <div class="text-center">

                                        <h3 class="text-center" style="margin-bottom: 20px;">Trafik Pengunjung</h3>

                                        <div class="col-md-3 brdr"><h4>Android</h4><h3 style="color: #007bff;"><?php echo $android?></h3></div>

                                        <div class="col-md-3 brdr"><h4>IOS</h4><h3 style="color: #28a745;"><?php echo $ios?></h3></div>

                                        <div class="col-md-3 brdr"><h4>Win 10</h4><h3 style="color: #ffc107;"><?php echo $win10?></h3></div>

                                        <div class="col-md-3"><h4>Lainnya</h4><h3><?php echo $other?></h3></div>

                                    </div>

                              </div>

                            </div>

                        </div>

                        <div class="col-lg-12 col-sm-12 col-md-12">

                            <div class="panel">

                              <div class="panel-heading "><b style="font-size: 20px;font-weight: 600;">Store Map <?php echo count($toko_stars);?> <a href="<?php echo base_url('trueaccon2194/inout/export_shop_list')?>" class="label label-primary">Export Excel</a></b></div>

                              <div class="panel-body">

                                <div class="row">

                                    <div class="col-md-8 col-xs-12">

                                    <?php 

                                        require 'dbstoremap/Storemap.php';

                                        $edu = new storemap;

                                        $coll = $edu->getCollegesBlankLatLng();

                                        $coll = json_encode($coll, true);

                                        echo '<div id="data">' . $coll . '</div>';



                                        $allData = $edu->getAllColleges();

                                        $allData = json_encode($allData, true);

                                        echo '<div id="allData">' . $allData . '</div>';            

                                    ?>

                                        <div id="map"></div>

                                    </div>

                                    <div class="col-md-4 col-xs-12">

                                        <div style="margin-bottom: 20px;"><a class="btn btn-success" onclick="tambah_toko()">+ Tambah Toko</a> <a class="btn btn-success" onclick="tambah_bdm()">+ Tambah BDM</a> <a class="btn btn-success list_bdm" >Daftar BDM / Toko</a></div>

                                        <div class="table_bdmx" style="display: none;">

                                            <table id="table_bdm" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">

                                                <thead>

                                                    <tr style="background-color:white;color:black;">

                                                        <th style="">BDM</th>

                                                        <th style="text-align:center;">Opsi</th>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <?php 

                                                        foreach($bdm as $b){

                                                        $id = $b->id;

                                                    ?>

                                                    <tr>

                                                        <td><?php echo $b->nama_bdm;?><br><label style="display: inline-block;" class="label label-default"><?php echo $b->area;?></label> <label style="display: inline-block;" class="label label-default"><a href="tel:<?php echo $b->telp?>" target="_new"><?php echo $b->telp;?></a></label></td>

                                                        <td>

                                                            <a style="margin-bottom: 10px;" onclick="edit_bdm(<?php echo $id?>);" href="javascript:void(0);" class="btn btn-warning edit"><i class="glyphicon glyphicon-pencil"></i></a> 

                                                            <a style="margin-bottom: 10px;" data-id="<?php echo $id?>" data-name="<?php echo $b->nama_bdm?>" onclick="hapus_bdm(this);" href="javascript:void(0);" class="btn btn-danger edit"><i class="glyphicon glyphicon-remove"></i></a>

                                                        </td>

                                                    </tr>

                                                    <?php }?>

                                                </tbody>

                                            </table>

                                        </div>

                                        <div class="table_storex">

                                            <table id="table_store" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">

                                                <thead>

                                                    <tr style="background-color:white;color:black;">

                                                        <th style="text-align:center;">Toko</th>

                                                        <th style="text-align:center;">Opsi</th>

                                                    </tr>

                                                </thead>

                                                <tbody></tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>

                              </div>

                            </div>

                        </div>

                        <div class="col-lg-7 col-sm-12 col-md-12 hidden">

                            <div class="panel">

                              <div class="panel-heading text-center"><b style="font-size: 20px;font-weight: 600;">Perkiraan Cuaca (BMKG)</b></div>

                              <div class="panel-body bmkg">

                                    <?php //echo $bmkg?>  

                              </div>

                            </div>

                        </div>

                        <div class="col-lg-5 col-sm-12 col-md-12 hidden">

                            <div class="panel">

                              <div class="panel-heading text-center"><b style="font-size: 20px;font-weight: 600;">Daftar Gempa (BMKG)</b></div>

                              <div class="panel-body">

                                    <?php //echo $gempa?>  

                              </div>

                            </div>

                        </div>

                    </div>

                </div><!-- Main Wrapper -->

<!-- Bootstrap modal tambah-->

  <div class="modal fade" id="modal_toko" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header" style="background-color: #34425a;color: white;">

        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>

        <h3 class="modal-title"></h3>

      </div>

      <div class="modal-body form">

        <?php 

        $id = array('id' => 'form_tambah_toko');

        echo form_open('#', $id);

        ?>

          <div class="row">

              <div class="col-md-6 col-xs-12 input group">

                <label>Nama Toko : <i style="color:red;">*</i></label>

                <input type="text" name="nama" class="form-control nama" placeholder="Nama Toko" required>

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Alamat : <i style="color:red;">*</i></label>

                <input type="text" name="alamat" class="form-control alamat" placeholder="Alamat" required>

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>BDM : <i style="color:red;">*</i></label>

                <select class="form-control bdm" name="bdm" required>

                    <option value="">-- pilih --</option>

                    <?php foreach($bdm as $xb){?>

                        <option value="<?php echo $xb->id?>"><?php echo $xb->nama_bdm?> [<?php echo $xb->area?>]</option>

                    <?php }?>

                </select>

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Kode SMS : <i style="color:red;">*</i></label>

                <input type="text" name="sms" class="form-control sms" placeholder="Kode SMS" required>

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Kode EDP : <i style="color:red;">*</i></label>

                <input type="text" name="edp" class="form-control edp" placeholder="Kode EDP" required>

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>SPV : <i style="color:red;">*</i></label>

                <input type="text" name="spv" class="form-control spv" placeholder="Nama SPV" required>

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Assisten : <i style="color:red;">*</i></label>

                <input type="text" name="ass" class="form-control ass" placeholder="Assisten">

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>WA toko :</label>

                <input type="number" name="wa" class="form-control wa" placeholder="WA Toko">

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Nomor SPV : </label>

                <input type="number" name="no_spv" class="form-control no_spv" placeholder="Nomor SPV">

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Nomor Assisten :</label>

                <input type="number" name="no_ass" class="form-control no_ass" placeholder="Nomor Assisten">

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Latitude : <i style="color:red;">*</i></label>

                <input type="text" name="lat" class="form-control lat" placeholder="Latitude" required>

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Longitude : <i style="color:red;">*</i></label>

                <input type="text" name="lon" class="form-control lon" placeholder="Longitude" required>

                <br>

              </div>

          </div>

          <div class="modal-footer">

            <button type="submit" id="btnSave" class="btn btn-primary">Simpan</button>

            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

          </div>

        <?php echo form_close();?>

      </div>

        </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->

  <!-- End Bootstrap modal -->

  <!-- Bootstrap modal tambah-->

  <div class="modal fade" id="modal_bdm" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header" style="background-color: #34425a;color: white;">

        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>

        <h3 class="modal-title"></h3>

      </div>

      <div class="modal-body form">

        <?php 

        $id = array('id' => 'form_tambah_bdm');

        echo form_open('#', $id);

        ?>

          <div class="row">

              <div class="col-md-6 col-xs-12 input group">

                <label>Nama BDM : <i style="color:red;">*</i></label>

                <input type="text" name="nama" class="form-control nama" placeholder="Nama BDM" required>

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Area : <i style="color:red;">*</i></label>

                <input type="text" name="area" class="form-control area" placeholder="Area" required>

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Telpon : <i style="color:red;">*</i></label>

                <input type="number" name="telp" class="form-control telp" placeholder="Telpon BDM" required>

                <br>

              </div>

          </div>

          <div class="modal-footer">

            <button type="submit" id="btnSave" class="btn btn-primary">Simpan</button>

            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

          </div>

        <?php echo form_close();?>

      </div>

        </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->

  <!-- End Bootstrap modal -->

  <!-- Bootstrap modal tambah-->

  <div class="modal fade" id="modal_bdm_edit" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header" style="background-color: #34425a;color: white;">

        <a href="javascript:void(0)" style="font-size: 30px;border-radius:inherit;padding:initial;" class="tutup_modal label" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>

        <h3 class="modal-title"></h3>

      </div>

      <div class="modal-body form">

        <?php 

        $id = array('id' => 'form_edit_bdm');

        echo form_open('#', $id);

        ?>

          <div class="row">

              <div class="col-md-6 col-xs-12 input group">

                <label>Nama BDM : <i style="color:red;">*</i></label>

                <input type="text" name="nama" class="form-control nama" placeholder="Nama BDM" required>

                <input type="hidden" name="id" class="id">

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Area : <i style="color:red;">*</i></label>

                <input type="text" name="area" class="form-control area" placeholder="Area" required>

                <br>

              </div>

              <div class="col-md-6 col-xs-12 input group">

                <label>Telpon : <i style="color:red;">*</i></label>

                <input type="number" name="telp" class="form-control telp" placeholder="Telpon BDM" required>

                <br>

              </div>

          </div>

          <div class="modal-footer">

            <button type="submit" id="btnSave" class="btn btn-primary">Update</button>

            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

          </div>

        <?php echo form_close();?>

      </div>

        </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->

  <!-- End Bootstrap modal -->

<script type="text/javascript">

  $(document).ready( function () { 

      $("#progress_order").DataTable();

      $("#table_bdm").DataTable({

        "pageLength": 6,

      });



       table = $('#table_store').DataTable({ 

        "processing": true, 

        "serverSide": true, 

        "pageLength": 4,

        "order": [],

        // Load data for the table's content from an Ajax source

        "ajax": {

            "url": "<?php echo base_url('trueaccon2194/info_type_user_log/load_store')?>",

            "type": "POST",

        },



        //Set column definition initialisation properties.

        "columnDefs": [

        { 

            "targets": [ 0 ], //last column

            "orderable": false, //set not orderable

        },

        ],

    

      });

  });

</script>

<script>

var chart1; 

var chart2; 

var chart3;

$(document).ready(function() {

    chart1 = new Highcharts.Chart({

        chart: {

            renderTo: 'graph',

                type: 'column',

                options3d: {

                enabled: true,

                alpha: 0,

                beta: 20

            },

        },   

        title: {

            text: 'Best Seller'

        },

        xAxis: {

            categories: ['Produk']

        },

        yAxis: {

            title: {

                text: 'Total yang dibeli'

            }

        },

        series: [

            <?php

              foreach($produk_paling_laris as $data){                             

            ?>

                {

                  name: '<?php echo $data->nama_produk; ?>',

                  data: [<?php echo $data->total; ?>]

                },

            <?php }?>

        ]

    });



    chart2 = new Highcharts.Chart({

        chart: {

            renderTo: 'mygraph2',

            type: 'column',

            options3d: {

                enabled: true,

                alpha: 0,

                beta: 20

            },

        },   

        title: {

            text: ''

        },

        xAxis: {

            categories: ['Jumlah Pasang']

        },

        yAxis: {

            title: {

                text: 'Pasang'

            }

        },

        series: [

            <?php

              foreach($penjualan as $datax){                             

            ?>

                {

                  name: '<?php echo $datax->bulan;?>',

                  data: [<?php echo $datax->pasang; ?>]

                },

            <?php }?>

        ]

    });



    chart3 = new Highcharts.Chart({

        chart: {

            renderTo: 'mygraph4',

            type: 'column',

            options3d: {

                enabled: true,

                alpha: 0,

                beta: 20

            },

        },   

        title: {

            text: ''

        },

        xAxis: {

            categories: ['Jumlah Pasang']

        },

        yAxis: {

            title: {

                text: 'Pasang'

            }

        },

        series: [

            <?php

              foreach($penjualan_by_sosmed_dan_mp_all as $pnj_type){                             

            ?>

                {

                  name: '<?php echo $pnj_type->buy_in; ?>',

                  data: [<?php echo $pnj_type->jual_pasang; ?>]

                },

            <?php }?>

        ]



    });



});  

</script>