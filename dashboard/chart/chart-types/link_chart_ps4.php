<?php include '../header_new.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../nextg_koneksi.php'; ?>
<?php include '../sharia_koneksi.php'; ?>
<?php include '../koneksi_opp.php'; ?>


<h1>DASHBOARD POLICY SERVICE ACTIVITY</h1>
<a href="<?php echo BaseURL() ;?>bar_chart_ps.php?team=1" class="next">Team 1</a>
<a href="<?php echo BaseURL() ;?>bar_chart_ps.php?team=2" class="next">Team 2</a>
<a href="<?php echo BaseURL() ;?>bar_chart_ps.php?team=3" class="next">Team 3</a>

<a href="<?php echo BaseURL() ;?>table.php?team=1" class="next">Simple Table</a>

<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<hr />

  <div id="chartContainerSla"></div>
 

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<hr />

<div class="row">
  <div class="column" >
    <div id="chartContainerStatusOpp"></div>
  </div>
</div>
 
<?php
 error_reporting(0);    


 $query_read = pg_query($conn, "
--select now() + 1.2 * interval '1 hour';

--select * from(
select 
case 
when status = 'new' And hitung_rev <= param_dadakan_wanti_wanti then 'bahaya'
when status = 'Pending Follow Up Sales' then 'document'
when status = 'Pending Document' then 'document'
when status = 'merged' then 'document'
when  hitung_rev >= param_dadakan AND  hitung_rev >= param_dadakan_wanti_wanti then 'aman'
when  hitung_rev <= param_dadakan AND  hitung_rev >= param_dadakan_wanti_wanti then 'aman'
when  hitung_rev <= param_dadakan_wanti_wanti AND  hitung_rev >= param_dadakan_bahaya then 'wanti-wanti'
when  hitung_rev <= param_dadakan_bahaya then 'bahaya'
ELSE 'aneh'
end as kondisi,
* from (
select 
(param_dadakan - hours) + pemulih as hitung_rev,
param_dadakan - hours as hitung,
*from (
select 
case 
when new_create_time is null and create_time_z is null then 0
when new_create_time is null then 
(SELECT count (*) FROM daging_tgl  where tgl >= (create_time_z::date)::text AND tgl <= (now()::date)::text)*24

 when days = 0 then 
(SELECT count (*) FROM daging_tgl  where tgl = (new_create_time::date)::text)*24

else
(SELECT count (*) FROM daging_tgl  where tgl >= (new_create_time::date)::text AND tgl <= (now()::date)::text)*24
end as pemulih,

case when queue='Sales::POS DIRECT::Pos BSD' then 222
else 68.4
end as 
param_dadakan,
case when queue='Sales::POS DIRECT::Pos BSD' then 64
else 24
end as 
param_dadakan_wanti_wanti,
case when queue='Sales::POS DIRECT::Pos BSD' then 24
else 12
end as 
param_dadakan_bahaya,
* from(
select 
case 
WHEN
new_create_time is null and create_time_z is null then 
FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-0)/3600)
WHEN
new_create_time is null then 
FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM create_time_z))/3600)
else 
FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM new_create_time))/3600)
end as hours, 

case 
WHEN
new_create_time is null and create_time_z is null then 
FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-0)/3600)/24) 
WHEN
new_create_time is null then 
FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM create_time_z))/3600)/24) 
else 
FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM new_create_time))/3600)/24) 
end as days,
EXTRACT(EPOCH FROM now()) as nowe,EXTRACT(EPOCH FROM now())-EXTRACT(EPOCH FROM new_create_time) as raw,
* from (SELECT DISTINCT on (a.id)  a.id,z.create_time as create_time_z,a.create_time as create_time_a,
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
                and f.team_id in('1','2','3','4') and f.status_user=1 and f.level_user=1            
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

LEFT JOIN ticket_history z
            on z.ticket_id = a.id
            AND z.state_id = a.ticket_state_id
            ORDER BY a.id ASC,z.create_time DESC ) as t1 )as t2 )as t3)as t4 
--)as t5 where kondisi='bahaya'; ")or die(pg_last_error($conn));
    

if (!$query_read) {
            echo "An error occurred.\n";
            exit;
}
$x=0;
       while ($obj_read = pg_fetch_assoc($query_read)){
    $ticket[$x] = $obj_read;
      $x = $x +1;
}
//echo "<PRE>"; print_r($ticket);
$x = 0;


$statusbahaya='bahaya';
$bahaya= array_count_values(array_column($ticket,'kondisi'))[$statusbahaya];

$statusdocument='document';
$document= array_count_values(array_column($ticket,'kondisi'))[$statusdocument];

$statusaman='aman';
$aman= array_count_values(array_column($ticket,'kondisi'))[$statusaman];


$statuswantiwanti='wanti-wanti';
$wantiwanti= array_count_values(array_column($ticket,'kondisi'))[$statuswantiwanti];

$total=$bahaya+$document+$aman+$wantiwanti;

$bahayaPercentage=round((($bahaya/$total)*100), 2);
$documentPercentage=round((($document/$total)*100), 2);
$amanPercentage=round((($aman/$total)*100), 2);
$wantiwantiPercentage=round((($wantiwanti/$total)*100), 2);

$totalPercentage= $bahayaPercentage+$documentPercentage+$amanPercentage+$wantiwantiPercentage;

 $dataPointsSLA[0] = array( 
        'label'=>$statusbahaya.' -- ['.$bahaya.' Ticket] --' , 
        'y'=>$bahayaPercentage,
        );

 $dataPointsSLA[1] = array( 
        'label'=>$statusdocument.' -- ['.$document.' Ticket] --' , 
        'y'=>$documentPercentage,
        );

 $dataPointsSLA[2] = array( 
        'label'=>$statusaman.' -- ['.$aman.' Ticket] --' , 
        'y'=>$amanPercentage,
        );

 $dataPointsSLA[3] = array( 
        'label'=>$statuswantiwanti.' -- ['.$wantiwanti.' Ticket] --' , 
        'y'=>$wantiwantiPercentage,
        );



?>


<script>

window.onload = function() {
  CanvasJS.addColorSet("chartContainerColor",
                [//colorSet Array
                "#e73f3f",
                "#bd3853",
                "#38a445",
                "#fff85b"              
                ]);
var chartSla = new CanvasJS.Chart("chartContainerSla", {
    colorSet: "chartContainerColor",
    animationEnabled: true,
    title: {
        text: "Summary Status SLA"
    },
    subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPointsSLA, JSON_NUMERIC_CHECK); ?>
    }]
});
chartSla.render();

}

</script>




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