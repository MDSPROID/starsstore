 <table class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th>Informasi Gempa</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $list_gempa = new SimpleXMLElement('http://data.bmkg.go.id/en_gempaterkini.xml', null, true);
        foreach($list_gempa->gempa as $bmkg){
    ?>
        <tr>
            <td>
                <h3 style="margin-top: 0;"><i class="fa fa-map-marker"></i> <?php echo strtoupper($bmkg->Wilayah);?><br><small><?php echo $bmkg->Tanggal?> <?php echo $bmkg->Jam?></small></h3>
                <i class="fa fa-area-chart" style="margin-right: 10px;"></i> <?php echo $bmkg->Magnitude?><br>
                <i class="fa fa-location-arrow" style="margin-right: 15px;"></i> <?php echo $bmkg->Lintang?> LS, <?php echo $bmkg->Bujur?> BT<br>
            </td>
        </tr>
    <?php }?>
    </tbody>
</table>