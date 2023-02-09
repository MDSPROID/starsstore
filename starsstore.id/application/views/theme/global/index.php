<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Standarisasi Pelayanan Online Toko Stars</title>
    <!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $get_data_setting = for_header_front_end();?>
        <?php foreach($get_data_setting as $data):?>
            <link rel="shortcut icon" sizes="192x192" href="<?php echo base_url('assets/manage/img/')?><?php echo $data->konten;?>" />
        <?php endforeach;?>
    <meta name="theme-color" content="red">
    <meta name="robots" content="index,no-follow"/>
    <meta name="copyright" content="This website has been registered and trademark of PT. STARS INTERNASIONAL, Inc "/>
    <!-- main template stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url('assets/global/standart_toko/css/style.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/global/standart_toko/css/responsive.css')?>">
</head>

<body>
    <?php $get_data_setting = for_header_front_end();?>
    <?php foreach($get_data_setting as $data):?>
        <div class="preloader" style="background-image: url(<?php echo base_url('assets/images/')?><?php echo $data->konten;?>);"></div><!-- /.preloader -->
    <?php endforeach;?>
    <div class="page-wrapper">
        <header class="site-header header-one">
            <nav class="navbar navbar-expand-lg navbar-light header-navigation stricky">
                <div class="container clearfix">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="logo-box clearfix">
                        <?php $get_data_setting = for_header_front_end();?>
                        <?php foreach($get_data_setting as $data):?>
                        <a class="navbar-brand" href="<?php echo base_url();?>" target="_new">
                            <img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" width="120">
                        </a>
                    <?php endforeach;?>
                        <button class="menu-toggler" data-target=".header-one .main-navigation">
                            <span class="fa fa-bars"></span>
                        </button>
                    </div><!-- /.logo-box -->
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="main-navigation">
                        <ul class="one-page-scroll-menu navigation-box">
                            <li class=" current scrollToLink"><a href="#home">Home</a></li>
                            <li class="scrollToLink"><a href="#invoice">Invoice</a></li>
                            <li class="scrollToLink"><a href="#pengiriman">Pengiriman</a></li>
                            <li class="scrollToLink"><a href="#pembayaran">Pembayaran</a></li>
                            <li class="scrollToLink" style="display: none;">
                                <a href="#blog">Blog</a>
                                <ul class="sub-menu">
                                    <li><a href="blog.html">Blog Grid</a></li>
                                    <li><a href="blog-details.html">Blog Details</a></li>
                                </ul><!-- /.sub-menu -->
                            </li>
                            <li><a href="<?php echo base_url();?>">Ke Starsstore.id</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
            </nav>
        </header><!-- /.site-header -->
        <section class="banner-style-one" id="home">
            <span class="bubble-1"></span>
            <span class="bubble-2"></span>
            <span class="bubble-3"></span>
            <span class="bubble-4"></span>
            <span class="bubble-5"></span>
            <span class="bubble-6"></span>
            <img src="<?php echo base_url('assets/global/standart_toko/')?>images/banner-moc-1-1.png" class="banner-mock" alt="Awesome Image" />
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-8">
                        <div class="content-block">
                            <h3>Langkah - langkah<br> mengelola pesanan <br>dari Starsstore.id</h3>
                            <p>Ikuti petunjuk dibawah untuk cara packing barang,<br> mengirim barang ke ekpedisi hingga melakukan<br> pemindahan barang.</p>
                            <div class="button-block" style="display: none;">
                                <a href="#" class="banner-btn">
                                    <i class="fa fa-play"></i>
                                    Get in<span>Google Play</span>
                                </a>
                                <a href="#" class="banner-btn">
                                    <i class="fa fa-apple"></i>
                                    Get in<span>Play Store</span>
                                </a>
                            </div><!-- /.button-block -->
                        </div><!-- /.content-block -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.banner-style-one -->
        <section class="feature-style-two" id="invoice">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="image-block">
                            <img src="<?php echo base_url('assets/global/standart_toko/')?>images/moc-1-1.png" alt="Awesome Image" />
                        </div><!-- /.image-block -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="content-block">
                            <div class="block-title ">
                                <h2>Mencetak Invoice</h2>
                            </div><!-- /.block-title -->
                            <p>Kunjungi <a href="https://www.starsstore.id/order" target="_new">https://www.starsstore.id/order</a> <br> Setelah itu cetak invoice.</p>
                            <ul class="feature-lists">
                                <li><i class="fa fa-check"></i> Potong invoice pada garis merah yang ada ditengah.</li>
                                <li><i class="fa fa-check"></i> Bagian atas adalah invoice (dimasukkan ke dalam inner box bersama sepatu). </li>
                                <li><i class="fa fa-check"></i> Bagian bawah adalah label pengiriman ditempel di luar packing.</li>
                                <li><i class="fa fa-check"></i> Bungkus inner box dengan kertas coklat atau plastik hitam (pembungkus yang tidak tembus). lihat gambar dibawah</li>
                            </ul><!-- /.feature-lists -->
                            <ul class="list-inline gbinv">
                                <li style="float: left;"><img height="150" src="<?php echo base_url('assets/global/standart_toko/')?>images/invoice1.png"></li>
                                <li><img height="150" src="<?php echo base_url('assets/global/standart_toko/')?>images/invoice2.png"></li>
                            </ul>
                        </div><!-- /.content-block -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.feature-style-two -->
        <section class="feature-style-one" id="pengiriman">
            <div class="container">
                <hr class="style-one" />
                <div class="row">
                    <div class="col-lg-6">
                        <div class="content-block">
                            <div class="block-title ">
                                <h2>Antar ke Ekpedisi</h2>
                            </div><!-- /.block-title -->
                            <p>Berikut instruksi antar paket ke ekpedisi</p>
                            <ul class="feature-lists">
                                <li><i class="fa fa-check"></i> Jika toko tidak mendapat info nomor resi dari kantor pusat, sementara barang dikirim terlebih dahulu ke ekspedisi terdekat, nanti setelah mendapatkan nomor resinya kemudian diinfokan ke admin kantor, lalu nanti biaya pengiriman akan diganti oleh kantor. </li>
                                <li><i class="fa fa-check"></i> Jika toko mendapat info nomor resi dari kantor pusat, maka cukup antar paket ke expedisi dan sebutkan nomor resi yang telah diinfokan oleh kantor pusat dan <b>tidak perlu membayar ke expedisi</b>.</li>
                                <li><i class="fa fa-check"></i> Fotokan nomor resi tersebut ke whatsapp kantor 0813-777-11300.</li>
                                <li><i class="fa fa-check"></i> Setelah diantar ke expedisi, lakukan pemindahan barang tersebut di POS ke kode EDP 100-01.</li>
                            </ul><!-- /.feature-lists -->
                        </div><!-- /.content-block -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="image-block">
                            <img src="<?php echo base_url('assets/global/standart_toko/')?>images/moc-1-2.png" alt="Awesome Image" />
                        </div><!-- /.image-block -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.feature-style-one -->
        <section class="feature-style-two" id="pembayaran">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="image-block">
                            <img src="<?php echo base_url('assets/global/standart_toko/')?>images/moc-1-2.png" alt="Awesome Image" />
                        </div><!-- /.image-block -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="content-block">
                            <div class="block-title ">
                                <h2>Klaim Ongkir</h2>
                                <p>Jika toko telah membayar ke expedisi maka lakukan langkah dibawah, jika toko tidak membayar ke expedisi maka lewati bagian ini (tidak perlu klaim ongkir).</p>
                            </div><!-- /.block-title -->
                            <ul class="feature-lists">
                                <li><i class="fa fa-check"></i> Infokan nomor rekening spv / pramuniaga yang telah membayar paket tersebut.</li>
                                <li><i class="fa fa-check"></i> Ongkir akan masuk ke rekening 1x24 jam</li>
                            </ul><!-- /.feature-lists -->
                        </div><!-- /.content-block -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.feature-style-two -->
        <footer class="site-footer">
            <span class="bubble-1"></span>
            <span class="bubble-2"></span>
            <span class="bubble-3"></span>
            <span class="bubble-4"></span>
            <span class="bubble-5"></span>
            <span class="bubble-6"></span>
            <div class="container">
                <div class="inner-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <div class="footer-widget">
                                <div class="widget-title">
                                    <h3>STARS OFFICIAL STORE</h3>
                                    <h5>Ikuti Kami</h5>
                                </div><!-- /.widget-title -->
                                <div class="social-block">
                                    <a href="https://twitter.com/starsallthebest"><i class="fa fa-twitter"></i></a>
                                    <a href="https://www.facebook.com/starsallthebest"><i class="fa fa-facebook-f"></i></a>
                                    <a href="https://www.instagram.com/stars.allthebest"><i class="fa fa-instagram"></i></a>
                                    <a href="https://www.youtube.com/channel/UCuy1wqC_-Wh8k5tFrm-q7sg"><i class="fa fa-youtube"></i></a>
                                </div><!-- /.social-block -->
                            </div><!-- /.footer-widget -->
                        </div><!-- /.col-lg-3 -->
                    </div><!-- /.row -->
                </div><!-- /.inner-container -->
            </div><!-- /.container -->
        </footer><!-- /.site-footer -->
        <div class="bottom-footer text-center">
            <div class="container">
                <?php $get_data_setting_footer = for_footer();?>
                <p><?php foreach($get_data_setting_footer as $data){?><?php echo $data->konten?><?php }?></p>
            </div><!-- /.container -->
        </div><!-- /.bottom-footer -->
    </div><!-- /.page-wrapper -->
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-long-arrow-up"></i></a>
    <!-- /.scroll-to-top -->
    <script src="<?php echo base_url('assets/global/standart_toko/js/jquery.js')?>"></script>
    <script src="<?php echo base_url('assets/global/standart_toko/js/bootstrap.bundle.min.js')?>"></script>
    <script src="<?php echo base_url('assets/global/standart_toko/js/owl.carousel.min.js')?>"></script>
    <script src="<?php echo base_url('assets/global/standart_toko/js/jquery.bxslider.min.js')?>"></script>
    <script src="<?php echo base_url('assets/global/standart_toko/js/waypoints.min.js')?>"></script>
    <script src="<?php echo base_url('assets/global/standart_toko/js/jquery.easing.min.js')?>"></script>
    <script src="<?php echo base_url('assets/global/standart_toko/js/wow.js')?>"></script>
    <script src="<?php echo base_url('assets/global/standart_toko/js/jquery.counterup.min.js')?>"></script>
    <script src="<?php echo base_url('assets/global/standart_toko/js/theme.js')?>"></script>
</body>

</html>