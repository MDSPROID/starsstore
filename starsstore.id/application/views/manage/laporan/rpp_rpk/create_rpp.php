<div class="page-title">
  <h3>RPP / RPK
    <?php  
      if($this->session->flashdata('success')):?>
        <label style="font-size: 12px;position: absolute;margin-left: 10px;padding: 5px 5px;font-weight:500;" class="label label-success"><?php echo $this->session->flashdata('success')?></label>
      <?php endif?>
      <?php 
      if($this->session->flashdata('error')):?>
        <label style="font-size: 12px;position: absolute;margin-left: 10px;padding: 5px 5px;font-weight:500;" class="label label-danger"><?php echo $this->session->flashdata('error')?></label>
    <?php endif?>
  </h3>
  <div class="page-breadcrumb"> 
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('trueaccon2194/info_type_user_log')?>">Home</a></li>
      <li class="active" href="#">Laporan</li>
      <li class="active" href="<?php echo base_url('trueaccon2194/rpp_rpk')?>">RPP / RPK</li>
    </ol>
  </div>
</div> 
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
  <a class="btn btn-primary pull-left" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
  <?php echo form_open('trueaccon2194/rpp_rpk/create', array('class' => 'input-group'));?>
  <input type="hidden" name="tgl_tarik" value="<?php echo $tgl1?>">
  <input type="hidden" name="market" value="<?php echo $market?>">
  <button name="submit" class="hidden btn btn-danger" style="margin-right: 10px;"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
  <br>
</div>
<div class="col-md-9 table-responsive">  
<div id="pesan"></div>
<h2 class="text-center"><b>TOKO E-COMMERCE KODE EDP 100-01</b></h2>
<h4><span>Toko E-commerce</span><span class="pull-right">Bulan : <?php //echo date('F Y', strtotime($tgl1));?><input type="text" class="tgl_tarik" name="bln_closing" style="height: 30px;padding: 10px;" required></span></h4>
<h3>REKAPITULASI PERHITUNGAN PERSEDIAAN (RPP)<span class="pull-right">Toko Online : <?php echo $market?></span></h3>
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;border: 1px solid black;">
            <thead>
                <tr style="background-color:white;color:#2d2d2d;">
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">PERINCIAN</th>
                    <th style="text-align:center;border-top: 5px solid black;border-left: 5px solid black;">PAIRS</th>
                    <th style="text-align:center;border-top: 5px solid black;">TURN OVER</th>
                    <th style="text-align:center;border-top: 5px solid black;border-left: 5px solid black;">PAIRS</th>
                    <th style="text-align:center;border-top: 5px solid black;border-right: 5px solid black;">TURN OVER</th>
                    <th style="text-align:center;">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //foreach($get_list as $data):
                ?>
              <tr>
                  <td style="text-align:center;">1</td>
                  <td style="text-align:left;">Sisa Persediaan Bulan Lalu</td>
                  <td style="text-align:center;border-left: 5px solid black;"><?php echo $stok_bln_lalu?><input type="hidden" name="sisa_persediaan_bulan_lalu" class="form-control sisa_persediaan_bulan_lalu" value="<?php echo $stok_bln_lalu?>"></td>
                  <td style="text-align:center;"><?php echo number_format($rupiah_stk_bln_lalu,0,".",".")?><input type="hidden" name="turn_over_sisa_persediaan_bulan_lalu" class="form-control turn_over_sisa_persediaan_bulan_lalu" value="<?php echo $rupiah_stk_bln_lalu?>"></td>
                  <td style="text-align:center;border-left: 5px solid black;">xxx</td>
                  <td style="text-align:center;border-right: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">2</td>
                  <td style="text-align:left;">Penjualan Sepatu & Sandal bulan ini</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxx</td>
                  <td style="text-align:center;">xxxxx</td>
                  <td style="text-align:center;border-left: 5px solid black;"><?php echo $total_qty?><br><input type="hidden" class="pendingan_psg_bulan_ini" name="pendingan_psg_bulan_ini" value="<?php //echo $pendingan?>"><br><input type="hidden" class="penjualan_psg_bulan_ini" name="penjualan_psg_bulan_ini" value="<?php echo $total_qty?>"></td>
                  <td style="text-align:center;border-right: 5px solid black;"><?php echo number_format($total_rupiah,0,".",".")?><input type="hidden" class="penjualan_rupiah_bulan_ini" name="penjualan_rupiah_bulan_ini" value="<?php echo $total_rupiah?>"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">3</td>
                  <td style="text-align:left;"><i><b>Total Penjualan Bulan Ini (Baris 2)</b></i></td>
                  <td style="text-align:center;border-left: 5px solid black;">xxx</td>
                  <td style="text-align:center;">xxxxx</td>
                  <td style="text-align:center;border-left: 5px solid black;"><?php echo $total_qty?></td>
                  <td style="text-align:center;border-right: 5px solid black;"><?php echo number_format($total_rupiah,0,".",".")?></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">4</td>
                  <td style="text-align:left;">Barang Masuk Bulan Ini</td>
                  <td style="text-align:center;border-left: 5px solid black;"><?php echo $total_psg_masuk?><input type="hidden" class="total_psg_masuk" name="total_psg_masuk" value="<?php echo $total_psg_masuk?>"></td>
                  <td style="text-align:center;"><?php echo number_format($total_rupiah_masuk,0,".",".")?><input type="hidden" class="total_rupiah_masuk" name="total_rupiah_masuk" value="<?php echo $total_rupiah_masuk?>"></td>
                  <td style="text-align:center;border-left: 5px solid black;">xxx</td>
                  <td style="text-align:center;border-right: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">5</td>
                  <td style="text-align:left;">Barang Keluar Bulan Ini</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxx</td>
                  <td style="text-align:center;">xxxxx</td>
                  <td style="text-align:center;border-left: 5px solid black;"><?php echo $total_psg_keluar?><input type="hidden" name="total_psg_keluar" class="total_psg_keluar" value="<?php echo $total_psg_keluar?>"></td>
                  <td style="text-align:center;border-right: 5px solid black;"><?php echo number_format($total_rupiah_keluar,0,".",".")?><input type="hidden" name="total_rupiah_keluar" class="total_rupiah_keluar" value="<?php echo $total_rupiah_keluar?>"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">6</td>
                  <td style="text-align:left;">BALANCE SELISIH LEBIH (DSL/DSK)</td>
                  <td style="text-align:center;border-left: 5px solid black;"><input type="number" name="balance_selisih_lebih" class="form-control balance_selisih_lebih" value="0"></td>
                  <td style="text-align:center;"><input type="number" name="turnover_balance_selisih_lebih" class="form-control turnover_balance_selisih_lebih" value="0"></td>
                  <td style="text-align:center;border-left: 5px solid black;">xxx</td>
                  <td style="text-align:center;border-right: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">7</td>
                  <td style="text-align:left;">BALANCE SELISIH KURANG (DSL/DSK)</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxx</td>
                  <td style="text-align:center;">xxxxx</td>
                  <td style="text-align:center;border-left: 5px solid black;"><input type="number" name="balance_selisih_kurang" class="form-control balance_selisih_kurang" value="0"></td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="turnover_balance_selisih_kurang" class="form-control turnover_balance_selisih_kurang" value="0"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">8</td>
                  <td style="text-align:left;">Diskon Penjualan Bulan Ini</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxx</td>
                  <td style="text-align:center;">xxxxx</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><?php echo number_format($total_rupiah_diskon,0,".",".")?> <input type="hidden" name="spesial_diskon" class="spesial_diskon form-control" value="<?php echo $total_rupiah_diskon?>"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">9</td>
                  <td style="text-align:left;">Sisa Persediaan Bulan Ini</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxx</td>
                  <td style="text-align:center;">xxxxx</td>
                  <td style="text-align:center;border-left: 5px solid black;"><b class="sum_sisa_persediaan_kanan"></b></td>
                  <td style="text-align:center;border-right: 5px solid black;"><b class="sum_rupiah_sisa_persediaan_kanan"></b></td>
                  <td style="text-align:center;"></td>
              </tr>
             <?php //endforeach;?>
            </tbody>
            <tfoot>
              <tr style="background-color:white;color:#2d2d2d;">
                  <td style="text-align:center;" colspan="2">JUMLAH</td>
                  <td style="text-align:center;border-left: 5px solid black;border-bottom: 5px solid black;"><b class="sum_total_rpp_kiri"></b><br><label class="label label-success sum_rpp_kiri"><i class="glyphicon glyphicon-refresh"></i></label></td>
                  <td style="text-align:center;border-bottom: 5px solid black;"><b class="sum_total_rpp_rupiah_kiri"></b><br><label class="label label-success sum_rpp_rupiah_kiri"><i class="glyphicon glyphicon-refresh"></i></label></td>
                  <td style="text-align:center;border-left: 5px solid black;border-bottom: 5px solid black;"><b class="sum_total_rpp_kanan"></b><br><label class="label label-success sum_rpp_kanan"><i class="glyphicon glyphicon-refresh"></i></label></td>
                  <td style="text-align:center;border-right: 5px solid black;border-bottom: 5px solid black;"><b class="sum_total_rupiah_kanan"></b><br><label class="label label-success sum_rpp_rupiah_kanan"><i class="glyphicon glyphicon-refresh"></i></label></td>
                  <td style="text-align:center;"></td>
              </tr>
            </tfoot>
  </table><br>

  <h3>REKAPITULASI PERHITUNGAN KEUANGAN (RPK)</h3>
  <table id="table_produk" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%" style="box-shadow:0px 0px 8px 0px #bababa;border: 1px solid black;">
            <thead>
                <tr style="background-color:white;color:#2d2d2d;">
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">PERINCIAN</th>
                    <th style="text-align:center;">KODE</th>
                    <th style="text-align:center;border-top: 5px solid black;border-left: 5px solid black;">TURN OVER</th>
                    <th style="text-align:center;border-top: 5px solid black;border-right: 5px solid black;">TURN OVER</th>
                    <th style="text-align:center;">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //foreach($get_list as $data):
                ?>
              <tr>
                  <td style="text-align:center;">1</td>
                  <td style="text-align:left;">Money Onway</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-left: 5px solid black;"><?php echo number_format($totalpendinganbulanlalu,0,".",".")?><input type="hidden" name="total_rupiah" class="total_rupiah" value="<?php echo $totalpendinganbulanlalu?>"></td>
                  <td style="text-align:center;border-right: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">2</td>
                  <td style="text-align:left;">Omzet Penjualan Bulan Ini (Baris 3 RPP)</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-left: 5px solid black;"><?php echo number_format($total_rupiah,0,".",".")?><input type="hidden" name="total_rupiah" class="total_rupiah" value="<?php echo $total_rupiah //SETELAH DISKON?>"></td>
                  <td style="text-align:center;border-right: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">3</td>
                  <td style="text-align:left;">RUPIAH SELISIH KURANG (DSL/DSK)</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-left: 5px solid black;"><input type="number" name="selisih_kurang_dsl_dsk" class="form-control selisih_kurang_dsl_dsk" value="0"></td>
                  <td style="text-align:center;border-right: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">4</td>
                  <td style="text-align:left;">Selisih Kurang Penjualan Bulan Lalu</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-left: 5px solid black;"><input type="number" name="selisih_kurang_penjualan_bulan_lalu" class="form-control selisih_kurang_penjualan_bulan_lalu" value="0"></td>
                  <td style="text-align:center;border-right: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">5</td>
                  <td style="text-align:left;">Selisih Lebih Penjualan Bulan Lalu</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="selisih_lebih_penjualan_bulan_lalu" class="form-control selisih_lebih_penjualan_bulan_lalu" value="0"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;"><b style="font-size: 16px;">A. BIAYA RUTIN</b></td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">6</td>
                  <td style="text-align:left;">Biaya Promosi</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="biaya_promosi" class="biaya_promosi form-control" value="0"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">7</td>
                  <td style="text-align:left;">Biaya Internet</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="biaya_internet" class="biaya_internet form-control" value="0"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">8</td>
                  <td style="text-align:left;">Biaya Pengiriman pesanan</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><?php echo number_format($ongkir_ditanggung_toko,0,".",".")?><input type="hidden" name="biaya_pengiriman_pesanan" class="biaya_pengiriman_pesanan form-control" value="<?php echo $ongkir_ditanggung_toko;?>"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">9</td>
                  <td style="text-align:left;">Biaya Fotocopy Dokumen Toko</td>
                  <td style="text-align:center;">K</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="biaya_fotocopy_dokumen" class="biaya_fotocopy_dokumen form-control" value="0"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">10</td>
                  <td style="text-align:left;">Biaya Perjalanan Dinas Bekerja</td>
                  <td style="text-align:center;">U</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="biaya_perjalanan_dinas" class="biaya_perjalanan_dinas form-control" value="0"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">11</td>
                  <td style="text-align:left;">Ongkos dan Administrasi Bank</td>
                  <td style="text-align:center;">N</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="ongkos_dan_administrasi_bank" class="ongkos_dan_administrasi_bank form-control" value="0"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">12</td>
                  <td style="text-align:left;">Pembayaran Gaji & Komisi Supervisor</td>
                  <td style="text-align:center;">G</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><?php echo number_format($komisi_spv,0,".",".")?><input type="hidden" name="pembayaran_gaji_dan_komisi_supervisor" class="pembayaran_gaji_dan_komisi_supervisor form-control" value="<?php echo round($komisi_spv);?>"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">13</td>
                  <td style="text-align:left;">Pembayaran Komisi Pramuniaga</td>
                  <td style="text-align:center;">H</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><?php echo number_format($komisi_pram,0,".",".")?><input type="hidden" name="pembayaran_komisi_pramuniaga" class="pembayaran_komisi_pramuniaga form-control" value="<?php echo round($komisi_pram);?>"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">14</td>
                  <td style="text-align:left;">Ongkos Angkut</td>
                  <td style="text-align:center;">J</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="ongkos_angkut" class="ongkos_angkut form-control" value="0"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">15</td>
                  <td style="text-align:left;">Spesial Diskon</td>
                  <td style="text-align:center;">Y</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><?php echo number_format(0,0,".","."); //$total_rupiah_diskon?></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">16</td>
                  <td style="text-align:left;">Pembayaran Pajak</td>
                  <td style="text-align:center;">Q</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" value="0" name="pembayaran_pajak" class="pembayaran_pajak form-control" value="<?php echo $periode['biaya_marketplace']?>"><input type="hidden" name="t_periode" class="t_periode" value="<?php echo $periode['id_penjualan_fix']?>"><i class="glyphicon glyphicon-remove hapus_periode hidden"></i></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">17</td>
                  <td style="text-align:left;"><b style="font-size: 16px;">SUB TOTAL BIAYA RUTIN</b></td>
                  <td style="text-align:center;">I</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><b class="sub_total_b_rutin"></b></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;"><b style="font-size: 16px;">B. BIAYA NON RUTIN</b></td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">18</td>
                  <td style="text-align:left;">Biaya Maintenance</td>
                  <td style="text-align:center;">M</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="biaya_maintenance" class="biaya_maintenance form-control" value="0"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">19</td>
                  <td style="text-align:left;"><b style="font-size: 16px;">SUB TOTAL BIAYA NON RUTIN</b></td>
                  <td style="text-align:center;">Z</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><b class="sub_total_b_non_rutin"></b></td>
                  <td style="text-align:center;"></td>
              </tr>
               <tr>
                  <td style="text-align:center;">20</td>
                  <td style="text-align:left;"><b style="font-size: 16px;">TOTAL BIAYA (Baris 14 + 16)</b></td>
                  <td style="text-align:center;">O</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><b class="total_biaya_rutin_dan_non_rutin"></b></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr> 
                  <td style="text-align:center;">21</td>
                  <td style="text-align:left;">Total Setoran Bank (Sesuai Bukti)</td>
                  <td style="text-align:center;">V</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input readonly type="number" name="total_setoran_bank" class="form-control total_setoran_bank" value="<?php echo $periode['penjualan_fix'];?>"><input type="hidden" name="t_periode" class="t_periode" value="<?php echo $periode['id_penjualan_fix']?>"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;">22</td>
                  <td style="text-align:left;">Total Kartu Kredit (Sesuai Bukti)</td>
                  <td style="text-align:center;">W</td>
                  <td style="text-align:center;border-left: 5px solid black;">xxxxx</td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="total_kartu_kredit" class="form-control total_kartu_kredit" value="0"></td>
                  <td style="text-align:center;"></td>
              </tr>
              <tr>
                  <td style="text-align:center;"><input type="text" name="rincian" class="form-control" style="width: 40px;"></td>
                  <td style="text-align:left;"><input type="text" name="add_no" class="form-control add_no"></td>
                  <td style="text-align:center;"><input type="text" name="add_kode" class="form-control add_kode"></td>
                  <td style="text-align:center;border-left: 5px solid black;"><input type="number" name="add_turn_kiri" class="form-control add_turn_kiri"></td>
                  <td style="text-align:center;border-right: 5px solid black;"><input type="number" name="add_turn_kanan" class="form-control add_turn_kanan"></td>
                  <td style="text-align:center;"></td>
              </tr>
            </tbody>
            <tfoot>
              <tr style="background-color:white;color:#2d2d2d;">
                  <td style="text-align:center;" colspan="2">JUMLAH</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;border-bottom: 5px solid black;border-left: 5px solid black;"><b class="total_rpk_turnover_kiri"></b><br><label class="label label-success rpk_turnover_kiri"><i class="glyphicon glyphicon-refresh"></i></label></td>
                  <td style="text-align:center;border-right: 5px solid black;border-bottom: 5px solid black;"><b class="total_rpk_turnover_kanan"></b><br><label class="label label-success rpk_turnover_kanan"><i class="glyphicon glyphicon-refresh"></i></label></td>
                  <td style="text-align:center;"></td>
              </tr>
            </tfoot>
  </table>
  <p style="line-height: 30px;">Dengan ini Supervisor menyatakan bahwa RPP/RPK ini dibuat dengan sebenar-benarnya & telah menyetorkan uang hasil penjualan mulai tanggal ........................... s/d ..........................</p>
  <div class="row">
    <div class="col-md-4 pull-left">
        <b>DIPERIKSA OLEH</b><br><br><br><br><br>
        (.......................)
    </div>
    <div class="col-md-4 text-center">
        <b>Tanda - Tangan Asisten - Supervisor</b><br><br><br><br>
        (.......................)
    </div>
    <div class="col-md-4 text-center">
        <b>Tanda - Tangan Supervisor & Stempel Toko</b><br><br><br><br>
        (.......................)
    </div>
  </div>
</div>
<div class="col-md-3">
  <div class="panel panel-primary" style="border-color:#d3d3d3;">
      <div class="panel-heading" style="background-color:#34425a;border-color:#f9f9f9;">Info</div>
      <div class="panel-body" style="box-shadow:0px 0px 8px 0px #bababa;">
        <h5>Dibuat oleh     : <b><?php $user_log = info_user_login(); foreach($user_log as $datas){ echo $datas->nama_depan;}?></b></h5>
        <h5>Alamat IP  : <b><?php echo $this->input->ip_address()?></b></h5>
        <h5>Tanggal    : <b><?php echo date('Y-m-d')?></b></h5>
        <button type="submit" class="simpan_produk btn btn-success">Buat RPP / RPK</button>
        <?php echo br(2)?>
    </div>
    </div>
</div>
<input type='hidden' name='tgl1' value='<?php echo $tgl1?>'>
<input type='hidden' name='tgl2' value='<?php echo $tgl2?>'>
<input type='hidden' name='marketplace' value='<?php echo $markett?>'>
<?php echo form_close();?>
  </div>
</div>