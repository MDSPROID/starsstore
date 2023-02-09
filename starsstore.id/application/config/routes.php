<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
| 
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'allthebest';
$route['404_override'] = 'Allthebest/error'; //'' default
$route['translate_uri_dashes'] = FALSE;
//$route['(:any)'] = "produk/detail/$1";
$route['toko-libur']								= "off";
$route['review_order_produk/(:any)']				= "Checking_available/adding_rev/$1";
$route['review-berhasil']							= "Checking_available/page_success_review";
$route['add_review']								= "Checking_available/rev_pro/";
$route['lock_screen_default']						= "trueaccon2194/info_type_user_log/lock_account";
$route['unlock']									= "trueaccon2194/info_type_user_log/unlock_lock_screen";
$route['authenticationfacebook']					= "User_authentication";
$route['authorization_google']						= "Auth_google";
$route['pencarian1']								= "Allthebest/research_product";
$route['berlangganan']								= "Allthebest/berlangganan";
$route['keluar'] 									= "user/logout_page";
$route['keluar_akun'] 								= "user/customer_logout";
$route['checking_resource'] 						= "checking_available/cek_stok/";
$route['check_fc']									= "checking_available/cek_stok_fast_checkout";
$route['first_log_o_der'] 							= "checkout/endVerify_order";
$route['checkout/(:any)']							= "pembayaran/checkout/$1";
$route['success']									= "pembayaran/success";
$route['confirm_order']								= "pembayaran/confirm_order"; 
$route['verify_fastCheckout']						= "checkout/fast_checkout";
$route['logFororder']								= "checkout/login_order";
$route['check_vou'] 								= "cart/apply_coupon";
$route['checkingvalidationuser'] 					= "user/auth_log_key_basement";
$route['pesananselesai'] 							= "checkout/finishOrder";
$route['Reg_newest'] 								= "user/sign_up_and_login_for_order";
$route['mendaftar'] 								= "user/daftar_customer_baru/";
$route['login-pelanggan'] 							= "user/log_page_default";
$route['log_device_any']							= "trueaccon2194/info_type_user_log/log_admin";
$route['daftar-pelanggan-baru'] 					= "user/daftar";
$route['lupa-password'] 							= "user/lupa_pwd";
$route['reset'] 									= "user/reset";
$route['reset_password/(:any)']						= "user/reset_joss/$1";
$route['reset_combination']							= "user/reset_user_form";
$route['activation_class_user'] 					= "user/actfCount1";
$route['activation_class_user_default'] 			= "user/actfCount2";
$route['customer/retur'] 							= "user/daftarRet";
$route['customer/detail-retur/(:any)'] 				= "user/detailRet/$1";
$route['customer/print_invoice/(:any)'] 			= "user/cetakInv/$1";
$route['customer/informasi-akun'] 					= "user/infoAcc/";
$route['PageChngInfo']								= "user/ubah_info_user";
$route['customer/detail-penjualan/(:any)'] 			= "user/detailIn/$1";
$route['customer/riwayat-pesanan/retur/(:any)'] 	= "user/detailInAndRetur/$1";
$route['customer/riwayat-pesanan'] 					= "user/riwayatOrder";
$route['jadi-seller']		 						= "user/seller_preference";
$route['form-pengajuan-seller']						= "user/pre_form_seller";
$route['uploadDocumentseller']						= "user/upload_dokument_seller_auto";
$route['removedocument']							= "user/removeDocument";
$route['ValidateSellerInfor']						= "user/Validasiformseller";
$route['pengajuan-berhasil']						= "user/form_seller_berhasil";
$route['dashboard-seller']							= "user/dashboar_seller";
$route['customer/riwayat-pesanan'] 					= "user/riwayatOrder";
$route['activ_class_user/(:any)'] 					= "user/artclassaccountsip/$1";
$route['activ_class_user_default/(:any)'] 			= "user/artclassaccountsipppp/$1";
$route['checkuserorder'] 							= "checkout/loginuserakanorderpesanan";
$route['log_acc_us'] 								= "user/log_cus_header";
$route['daftar-baru'] 								= "user/daftar_user_baru";
$route['customer'] 									= "user/customer_page";
$route['customer/favorit'] 							= "user/favorit";
$route['add-to-wishlist/(:any)']					= "user/add_wishlist/$1";
$route['customer/favorit/hapus_wishlist/(:any)'] 	= "user/hapus_w/$1";
$route['customer/daftar-retur'] 					= "user/retur_list";
$route['customer/posJudgereturvalidation'] 			= "user/ajukan_retur";
$route['customer/member']							= "user/member";
$route['barcodemember/(:any)']								= "user/barcode/$1";
$route['regnewPagecs'] 								= "user/sign_up_for_new_register_csutomer";
$route['signupcheckout'] 							= "checkout/login_page_order/";
$route['produk/(:any)'] 							= "produk/pro_condition_details/$1";
$route['search_kat/(:any)']							= "Cataloguegaes/ajaxPaginationData_by_parent_kategori/$1";
$route['search_by_brand/(:any)']					= "Cataloguegaes/ajaxPaginationData_by_brand/$1";
$route['search_pr1/(:any)']							= "Cataloguegaes/ajaxPaginationData_by_promo1diskon/$1";
$route['search_pr2/(:any)']							= "Cataloguegaes/ajaxPaginationData_by_promo2diskon/$1";
$route['search_pr3/(:any)']							= "Cataloguegaes/ajaxPaginationData_by_promo2harga/$1";
$route['semua-kategori'] 							= "Cataloguegaes/semua_kategori";
$route['kategori/(:any)'] 							= "Cataloguegaes/cat_detail/$1";
$route['sub-kategori/(:any)']	 					= "Cataloguegaes/cat_detail/$1";
$route['merk/(:any)']		 						= "Cataloguegaes/cat_detail/$1";
$route['pencarian/(:any)']		 					= "Cataloguegaes/cat_detail/$1";
$route['promo-menarik/(:any)'] 						= "Cataloguegaes/cat_detail/$1";
$route['terbaru/(:any)'] 							= "Cataloguegaes/cat_detail/$1"; 
$route['brand']										= "Cataloguegaes/brand_promote"; 
$route['cariB/(:any)']								= "Halamanbantuan/caribantu/$1";
$route['bantuan']									= "Halamanbantuan/groupbantuan/";
$route['bantuan/(:any)']							= "Halamanbantuan/halaman_bantuan/$1";
$route['kontak-kami']								= "Halamanbantuan/kontak_kami";
$route['Sbcontact']									= "Halamanbantuan/submitPertanyaan";
$route['kontak-kami-berhasil']						= "Halamanbantuan/successhub";
$route['toko-kami']									= "Allthebest/our_store";
$route['lokasi-toko']								= "Allthebest/store_locator";
$route['caritoko']									= "Allthebest/caritoko";
$route['facebook']									= "Allthebest/subpagefacebook";
$route['adding_data']								= "Allthebest/tambahdatasubpage";
$route['selesai']									= "Allthebest/selesai_tambahdatasubpage";
$route['progress/kinerja/tim/promosi']				= "Allthebest/report_progres_kinerja_by_mail"; // URL urgent cron jobs
$route['uploadfilekinerja']							= "trueaccon2194/user_preference/upload_dokument_kinerja";
$route['hapusfilekinerja']							= "trueaccon2194/user_preference/removeDocumentkinerja";
$route['get_data_market_art']						= "trueaccon2194/online_store/get_data_price_cl_size_av";
$route['lacak-pesanan']								= "Allthebest/lacak_orderan";
$route['proses']									= "Allthebest/proses_lacak_pesananFix";
$route['sb_rev']									= "checking_available/addreview_manual";
$route['sb_qna']									= "checking_available/addpertanyaanproduk";
$route['gtpr']										= "produk/get_price";
$route['order']										= "allthebest/invoicepage";
$route['cariinv']									= "allthebest/cariinv";
$route['cetakinv/(:any)']							= "allthebest/cetakinv/$1";
$route['cetaklabel/(:any)']							= "allthebest/cetaklabel/$1";
$route['promo-menarik']								= "allthebest/promo";
$route['konfirmasi']								= "allthebest/konfirmasi";
$route['konfirmasi_pesanan']						= "allthebest/proses_konfirmasi";
$route['upload_bk']									= "allthebest/upload_bukti_transfer";
$route['hapus_bk']									= "allthebest/removeDocument";
$route['checkpsn']									= "allthebest/checkpesanankonfirmasi";
$route['standarisasi-pelayanan-online-toko']		= "allthebest/prosedur_toko";
$route['remove_voucher/(:any)']						= "cart/hapus_voucher/$1";
$route['cek-estimasi']								= "allthebest/cek_estimasi_ongkir";
$route['tentang-kami']								= "allthebest/tentang_kami";
$route['linktobuy']									= "allthebest/linktreestarsversion";
$route['artikelcheck5821']							= "allthebest/artikelcek";
$route['searchartinfo/(:any)']						= "allthebest/searchart/$1";
$route['cekartbyrims']								= "allthebest/cekStokbyrimsx";
$route['sinkronDatastarsstoretopos']				= "allthebest/sinkrondatatopos";