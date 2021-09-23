<?php include '../chart/koneksi.php'; ?>
<?php include '../chart/nextg_koneksi.php'; ?>
<?php include '../chart/sharia_koneksi.php'; ?>
<?php include '../chart/koneksi_opp.php'; ?>

<?php
error_reporting(0);	
//error_reporting(E_ALL);
if( !empty($_POST['tglawal']) AND !empty($_POST['tglakhir'])){

$tglawal=$_POST['tglawal'];
$tglakhir=$_POST['tglakhir'];
}

if($_POST['summary_otrs_sla']==1){


 $query_read = pg_query($conn, "
select 
case 
when status = 'new' And hitung_rev <= param_dadakan_wanti_wanti then 'bahaya'
when status = 'Pending Follow Up Sales' then 'follow up sales'
when status = 'Pending Document' then 'document'
when status = 'merged' then 'document'
when  hitung_rev >= param_dadakan AND  hitung_rev >= param_dadakan_wanti_wanti then 'aman'
when  hitung_rev <= param_dadakan AND  hitung_rev >= param_dadakan_wanti_wanti then 'aman'
when  hitung_rev <= param_dadakan_wanti_wanti AND  hitung_rev >= param_dadakan_bahaya then 'wanti-wanti'
when  hitung_rev <= param_dadakan_bahaya then 'bahaya'
ELSE 'aneh' end as kondisi,* 
from (
        select (param_dadakan - hours) + pemulih + pemulih_follow_up_sales as hitung_rev, param_dadakan - hours as hitung,*
        from (
                select 
                    case when new_create_time is null and create_time_z is null then 0 when new_create_time is null 
                        then (SELECT count (*) FROM daging_tgl  where tgl >= (create_time_z::date)::text AND tgl <= (now()::date)::text)*24
                        when days = 0 then (SELECT count (*) FROM daging_tgl  where tgl = (new_create_time::date)::text)*24
                    else
                    (SELECT count (*) FROM daging_tgl  where tgl >= (new_create_time::date)::text AND tgl <= (now()::date)::text)*24
                    end as pemulih,
                    get_age_follow_up_sales_b(ticket_id,new_create_time) as pemulih_follow_up_sales,
                   

                    case when queue='Sales::POS DIRECT::Pos BSD' then 222 else 68.4 end as param_dadakan,
                    case when queue='Sales::POS DIRECT::Pos BSD' then 64 else 24 end as  param_dadakan_wanti_wanti,
                    case when queue='Sales::POS DIRECT::Pos BSD' then 24 else 12 end as  param_dadakan_bahaya,* 
        from(
 select case WHEN new_create_time is null and create_time_z is null 
                                then FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-0)/3600) 
                            WHEN new_create_time is null 
                                    then FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM create_time_z))/3600)
 
                            else FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM new_create_time))/3600)
                        end as hours, 
                        case WHEN new_create_time is null and create_time_z is null then 
                        FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-0)/3600)/24) 
                            WHEN new_create_time is null then 
                            FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM create_time_z))/3600)/24) 
                            else FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM new_create_time))/3600)/24) 
                        end as days,
                    EXTRACT(EPOCH FROM now()) as nowe,EXTRACT(EPOCH FROM now())-EXTRACT(EPOCH FROM new_create_time) as raw,*
                    
        from (
                SELECT DISTINCT on (a.id)  a.id,z.create_time as create_time_z,a.create_time as create_time_a,
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
            WHEN A .ticket_status in('Pending Document','merged') THEN null
            WHEN A .ticket_status in ( 'Assessment UW/RI','On Progress','Posted','Pending Follow Up Sales','Follow Up Maker') THEN
                    case when (SELECT count(*) from ticket_history WHERE ticket_id =a.id and state_id='21')!=0 THEN
                        (   select ini from (
                            SELECT *, lead(z.create_time) over (order by z.create_time asc) as ini
                            FROM ticket_history z
                            WHERE z.ticket_id = A . ID
                            --AND state_id = '21' 
                            ORDER BY z.create_time asc)y where state_id='21' ORDER BY ini desc
                            LIMIT 1
                        )
                    else A .create_time end
        END AS new_create_time,*

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
                and f.team_id in ('1','2','3') and f.status_user=1 and f.level_user=1       
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
            ORDER BY a.id ASC,z.create_time DESC ) as t1 )as t2 )as t3)as t4;
 ")or die(pg_last_error($conn));
    

if (!$query_read) {
            echo "An error occurred.\n";
            exit;
}
$x=0;
       while ($obj_read = pg_fetch_assoc($query_read)){
        $ticket[$x] = $obj_read;
        $x ++;
}
//echo "<PRE>"; print_r($ticket);

$statusbahaya='bahaya';
$bahaya= array_count_values(array_column($ticket,'kondisi'))[$statusbahaya];

$statusdocument='document';
$document= array_count_values(array_column($ticket,'kondisi'))[$statusdocument];

$statusaman='aman';
$aman= array_count_values(array_column($ticket,'kondisi'))[$statusaman];


$statuswantiwanti='wanti-wanti';
$wantiwanti= array_count_values(array_column($ticket,'kondisi'))[$statuswantiwanti];


$statusfuw='follow up sales';
$fuw= array_count_values(array_column($ticket,'kondisi'))[$statusfuw];

$total=$bahaya+$document+$aman+$wantiwanti+$fuw;

$bahayaPercentage=round((($bahaya/$total)*100), 2);
$documentPercentage=round((($document/$total)*100), 2);
$amanPercentage=round((($aman/$total)*100), 2);
$wantiwantiPercentage=round((($wantiwanti/$total)*100), 2);
$fuwPercentage=round((($fuw/$total)*100), 2);


$totalPercentage= $bahayaPercentage+$documentPercentage+$amanPercentage+$wantiwantiPercentage+$fuwPercentage;

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
  $dataPointsSLA[4] = array( 
        'label'=>$statusfuw.' -- ['.$fuw.' Ticket] --' , 
        'y'=>$fuwPercentage,
        );

header('Content-Type: application/json');

 echo json_encode($dataPointsSLA);
}

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

