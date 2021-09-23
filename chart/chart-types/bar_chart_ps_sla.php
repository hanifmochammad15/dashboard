<?php include '../header_new.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../nextg_koneksi.php'; ?>
<?php include '../sharia_koneksi.php'; ?>
<?php
/*
 $key ='hanif';
  $enckey=urlencode(base64_encode($key)); 
  $link=urlencode(base64_encode($enckey.$paramlink)); 
 echo $link; 
*/
 ?>
<h1>BAR CHART POLIS STATUS OTRS</h1>


<a href="<?php echo BaseURL() .'bar_chart_ps.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Ticket Status</a>
<a href="<?php echo BaseURL() .'bar_chart_status.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Polis Status</a>
<a href="<?php echo BaseURL() .'bar_chart_stage.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Stage</a>
<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<hr />
<a href="<?php echo BaseURL() .'pie_chart_status.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>" class="next">Pie &raquo;</a>

<div id="chartContainer"></div>
 <?php
 error_reporting(0);
//ini_set('error_reporting',E_ALL);


if(empty($team)){
echo "Empty Parameter.\n";
            exit;
}else{
    $today = date("Y-m-d H:i:s");
    $kondisi[0] = 68.4; //sla 2,85 hari
    $kondisi[1] = 24; // 1 hari
    $kondisi[2] = 12; // merah
    //BSD//
    $kondisi['bsd'] = 222; //sla 9,5 hari
    $kondisi['bsd_wanti_wanti'] = 64;
    $kondisi['bsd_bahaya'] = 24;

 $query_read = pg_query($conn, "SELECT
        CASE
            WHEN A .ticket_status = 'new' THEN
                (
                    SELECT z.create_time
                    FROM ticket_history z
                    WHERE z.ticket_id = A . ID
                    AND z.history_type_id = '16' --move
                    AND state_id = A .ticket_state_id
                    ORDER BY z.create_time DESC
                    LIMIT 1
                )
            WHEN A .ticket_status = 'open' THEN
                (
                    SELECT z.create_time
                    FROM ticket_history z
                    WHERE z.ticket_id = A . ID
                    AND state_id = A .ticket_state_id
                    ORDER BY z.create_time DESC
                    LIMIT 1
                )
            WHEN A .ticket_status in('Pending Follow Up Sales','Pending Document','merged') THEN NULL
            WHEN A .ticket_status = 'Assessment UW/RI' THEN
                (
                    SELECT z.create_time
                    FROM ticket_history z
                    WHERE z.ticket_id = A . ID
                    AND state_id = '4' --open
                    ORDER BY z.create_time DESC
                    LIMIT 1
                )
            ELSE A .create_time
        END AS new_create_time,
        *
    FROM
        (
            SELECT
                A .create_time, A . ID, A .ticket_state_id, C . NAME AS ticket_status, A .tn, A .title,
                (SELECT DISTINCT LOGIN FROM users WHERE ID = A .responsible_user_id) AS responsible_user,
                b. NAME AS queue, C . NAME AS status
            FROM ticket A
            LEFT JOIN queue b ON b. ID = A .queue_id
            LEFT JOIN ticket_state C ON C . ID = A .ticket_state_id
            LEFT join users as d on d.id=a.user_id
            LEFT JOIN teams as f on f.user_login=d.login
            WHERE
                
                a.create_time::date >='$tglawal'
                and a.create_time::date <='$tglakhir'    
                and f.team_id = '$team' and f.status_user=1 and f.level_user=1            
                AND C . NAME NOT IN ('closed successful', 'merged')
                AND b. NAME IN  ('Sales::POS DIRECT::Pos JKP',
                                            'Sales::POS DIRECT::Pos Kediri',
                                            'Sales::POS DIRECT::Pos Cirebon',
                                            'Sales::POS DIRECT::Pos Bandung',
                                            'Sales::POS DIRECT::Pos Jambi',
                                            'Sales::POS DIRECT::Pos BSD',
                                            'Sales::POS DIRECT::Pos Makassar',
                                            'Sales::POS DIRECT::Pos Malang',
                                            'Sales::POS DIRECT::Pos Solo',
                                            'Sales::POS DIRECT::Pos Batam',
                                            'Sales::POS DIRECT::Pos Medan',
                                            'Sales::POS DIRECT::Pos Jember',
                                            'Sales::POS DIRECT::Pos Purwokerto',
                                            'Sales::POS DIRECT::Pos Pontianak',
                                            'Sales::POS DIRECT::Pos Lampung',
                                            'Sales::POS DIRECT::pos.samarinda',
                                            'Sales::POS DIRECT::Pos Denpasar',
                                            'Sales::POS DIRECT::Pos Semarang',
                                            'Sales::POS DIRECT::Pos Manado',
                                            'Sales::POS DIRECT::Pos Yogyakarta',
                                            'Sales::POS DIRECT::Pos Surabaya',
                                            'Sales::POS DIRECT::Pos Palembang',
                                            'Sales::POS DIRECT::Pos Balikpapan',
                                            'Sales::POS DIRECT::HO KONVEN',
                                            'Sales::POS DIRECT::Pos Pekanbaru',
                                            'Sales::POS DIRECT::Pos Health',
                                            'Sales::POS DIRECT::Pos DNC',
                                            'TMO'
)
                AND A.tn NOT IN (
                    '880295919',
                    '880299111',
                    '880345340',
                    '880345581',
                    '880345709',
                    '880345710',
                    '880346755',
                    '880346784',
                    '880346786',
                    '880346963',
                    '880346969',
                    '880347268',
                    '880349390',
                    '880351271',
                    '880351589',
                    '880352274',
                    '880353054',
                    '880353734',
                    '880354348',
                    '880354857',
                    '880355068',
                    '880355449',
                    '880356948',
                    '880357556',
                    '880358649',
                    '880358818',
                    '880444574',
                    '880384757'
                )
        ) AS A
    ORDER BY 1 ASC ")or die(pg_last_error($conn));
    

        if (!$query_read) {
            echo "An error occurred.\n";
            exit;
        }
$x=0;
       while ($obj_read = pg_fetch_assoc($query_read)){
    $ticket[$x] = $obj_read;
    
    if($ticket[$x]['new_create_time'] == '') {
        $query_pemeriksa = pg_query($conn,"         
            SELECT z.create_time
            FROM ticket_history z
            WHERE z.ticket_id = '{$ticket[$x]['id']}'
            AND state_id = '{$ticket[$x]['ticket_state_id']}'
            ORDER BY z.create_time DESC
            LIMIT 1
        ") or die(pg_last_error($conn));
        while ($obj_pemeriksa = pg_fetch_assoc($query_pemeriksa)){
            $waktu_pemeriksa[$ticket[$x]['id']] = $obj_pemeriksa['create_time'];
        }
        if(empty($waktu_pemeriksa[$ticket[$x]['id']])) {$ticket[$x]['new_create_time'] = 0;}
        else {$ticket[$x]['new_create_time'] = $waktu_pemeriksa[$ticket[$x]['id']];}
    }
    $ticket[$x]['now'] = $today;
    $ticket[$x]['diff']['raw'] = strtotime($ticket[$x]['now']) - strtotime($ticket[$x]['new_create_time']);
    $ticket[$x]['diff']['days'] = floor(($ticket[$x]['diff']['raw']/3600)/24);
    $ticket[$x]['pemulih'] = 0;
    
    if($ticket[$x]['diff']['days'] == 0) {
        $tgl_periksa = substr($ticket[$x]['new_create_time'], 0, 10);
        $query_libur = pg_query($conn,"
            SELECT * FROM daging_tgl WHERE tgl = '{$tgl_periksa}'
        ") or die(pg_last_error($conn));
        $ticket[$x]['libur'][1] = pg_fetch_assoc($query_libur);
        if(!empty($ticket[$x]['libur'][1])) {$ticket[$x]['pemulih'] = 24;}
    }
    else {
        
        for($a=0; $a<=$ticket[$x]['diff']['days']; $a++){ 
            $ticket[$x]['junk_tgl'][$a] = 
                date('Y-m-d H:i:s', strtotime($ticket[$x]['new_create_time'] . ' +'.$a.' day'));
            $tgl_periksa = substr($ticket[$x]['junk_tgl'][$a], 0, 10);
            $query_libur = pg_query($conn,"
                SELECT * FROM daging_tgl WHERE tgl = '{$tgl_periksa}'
            ") or die(pg_last_error($conn));
            $ticket[$x]['libur'][$a] = pg_fetch_assoc($query_libur);
            if(!empty($ticket[$x]['libur'][$a])) {$ticket[$x]['pemulih'] = $ticket[$x]['pemulih'] + 24;}
        }
    }
    
    /*if ($ticket[$x]['polis'] == '') {$param_dadakan = $kondisi[0];}
    else if (substr($ticket[$x]['polis'],0,3) == 'P15' OR substr($ticket[$x]['polis'],0,3) == 'Q15') {
        $param_dadakan = $kondisi['bsd'];
    }
    else {$param_dadakan = $kondisi[0];}*/
    
    if ($ticket[$x]['queue'] == 'Sales::POS DIRECT::Pos BSD') {
        $param_dadakan = $kondisi['bsd'];
        $param_dadakan_wanti_wanti = $kondisi['bsd_wanti_wanti'];
        $param_dadakan_bahaya = $kondisi['bsd_bahaya'];
    }
    else {
        $param_dadakan = $kondisi[0];
        $param_dadakan_wanti_wanti = $kondisi[1];
        $param_dadakan_bahaya = $kondisi[2];
    }
    
    $ticket[$x]['debug'] = 'waktunya = '.$param_dadakan;
    //echo "<PRE>".substr($ticket[$x]['polis'],0,3)." - ".$ticket[$x]['debug'];
    
    $ticket[$x]['diff']['hours'] = floor($ticket[$x]['diff']['raw']/3600);
    $ticket[$x]['diff']['minutes'] = floor($ticket[$x]['diff']['raw']/60);
    $ticket[$x]['diff']['hitung'] = $param_dadakan - $ticket[$x]['diff']['hours'];
    $ticket[$x]['diff']['hitung_rev'] = $ticket[$x]['diff']['hitung'] + $ticket[$x]['pemulih'];
    
    //patch cepet sementara
    $ticket[$x]['diff']['hitung_old'] = $ticket[$x]['diff']['hitung'];
    $ticket[$x]['diff']['hitung'] = $ticket[$x]['diff']['hitung_rev'];
    
    if($ticket[$x]['status'] == 'new' && $ticket[$x]['diff']['hitung'] <= $param_dadakan_wanti_wanti) { //red
        $ticket[$x]['kondisi'] = 'bahaya';
        
    }
    else if($ticket[$x]['status'] == 'Pending Follow Up Sales' or $ticket[$x]['status'] == 'Pending Document' or $ticket[$x]['status'] == 'merged') { //pink
        $ticket[$x]['diff']['hitung'] = 0;
        $ticket[$x]['kondisi'] = 'document';
    }
    else if ($ticket[$x]['diff']['hitung'] >= $param_dadakan && $ticket[$x]['diff']['hitung'] >= $param_dadakan_wanti_wanti) { //green
        $ticket[$x]['kondisi'] = 'aman';

        
    }
    else if ($ticket[$x]['diff']['hitung'] <= $param_dadakan && $ticket[$x]['diff']['hitung'] >= $param_dadakan_wanti_wanti) { //green
        $ticket[$x]['kondisi'] = 'aman';
          
    }
    else if ($ticket[$x]['diff']['hitung'] <= $param_dadakan_wanti_wanti && $ticket[$x]['diff']['hitung'] >= $param_dadakan_bahaya) { //yellow
        $ticket[$x]['kondisi'] = 'wanti-wanti';
        
    }
    else if ($ticket[$x]['diff']['hitung'] <= $param_dadakan_bahaya) { //red
        $ticket[$x]['kondisi'] = 'bahaya';
    }
    else { //back
        $ticket[$x]['kondisi'] = 'aneh';
       
    }
    $x = $x +1;
}
//echo "<PRE>"; print_r($ticket);
$x = 0;

$team_user_login = pg_query($conn, "select user_login from teams where team_id='$team' and level_user=1 and status_user=1")or die(pg_last_error($conn));
while ($row = pg_fetch_assoc($team_user_login)) { 
        $mark='bahaya';
        $count1 = 0;
            foreach ($ticket as $key => $value) {
                
              if($value['responsible_user'] == $row['user_login'] && $value['kondisi'] == $mark)
                $count1++;
            }
            $dataPoints1[$x] = array( 
                            'label'=>$row['user_login'] , 
                            'y'=>$count1,
                            );

        $mark='document';
        $count2 = 0;
        foreach ($ticket as $key => $value) {
           
          if($value['responsible_user'] == $row['user_login'] && $value['kondisi'] == $mark)
            $count2++;
        }
        $dataPoints2[$x] = array( 
                        'label'=>$row['user_login'] , 
                        'y'=>$count2,
                        );


        $mark='aman';
        $count3 = 0;
        foreach ($ticket as $key => $value) {
           
          if($value['responsible_user'] == $row['user_login'] && $value['kondisi'] == $mark)
            $count3++;
        }
        $dataPoints3[$x] = array( 
                        'label'=>$row['user_login'] , 
                        'y'=>$count3,
                        );

        $mark='wanti-wanti';
        $count4 = 0;
        foreach ($ticket as $key => $value) {
           
          if($value['responsible_user'] == $row['user_login'] && $value['kondisi'] == $mark)
            $count4++;
        }
        $dataPoints4[$x] = array( 
                        'label'=>$row['user_login'] , 
                        'y'=>$count4,
                        );


        $x++;


        }


    }

?>


<script>
window.onload = function () {
     CanvasJS.addColorSet("chartContainerColor",
                [//colorSet Array
                "#e73f3f",
                "#bd3853",
                "#38a445",
                "#fff85b"              
                ]);
 
var chart = new CanvasJS.Chart("chartContainer", {
    colorSet: "chartContainerColor",
    title: {
        text: "Chart Ticket Team <?php echo $team; ?>"
    },
     subtitles: [{
       text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
    theme: "light2",
    animationEnabled: true,
    toolTip:{
        shared: true,
        reversed: true
    },
    axisY: {
        title: "Total Ticket OTRS",
        suffix: " Ticket"
    },
    legend: {
        cursor: "pointer",
        itemclick: toggleDataSeries
    },
     data: [
        {
            type: "stackedColumn",
            name: "bahaya",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "document",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "aman",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
        },
        {
            type: "stackedColumn",
            name:  "wanti-wanti",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
        }
    ]
});
 
chart.render();
 
function toggleDataSeries(e) {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    e.chart.render();
}
 
}

setTimeout(function(){
   window.location.reload(1);
}, 300000);// 5menit
</script>
<?php include '../footer.php'; ?>

<?php
   function subArraysToString($ar, $sep = ', ') {
                $str = '';
                foreach ($ar as $val) {
                    $str .= implode($sep, $val);
                    $str .= $sep; // add separator between sub-arrays
                }
                $str = rtrim($str, $sep); // remove last separator
                return $str;
        }

function merge_two_arrays($array1,$array2) {
    $data = array();
    $arrayAB = array_merge($array1,$array2);
    foreach ($arrayAB as $value) {
    $id = $value['id'];
    if (!isset($data[$id])) {
        $data[$id] = array();
    }
    $data[$id] = array_merge($data[$id],$value);
    }
    return $data;
}

?>