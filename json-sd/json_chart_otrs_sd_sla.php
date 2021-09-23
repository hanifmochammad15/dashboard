<?php include '../chart/koneksi.php'; ?>
<?php include '../chart/nextg_koneksi.php'; ?>
<?php include '../chart/sharia_koneksi.php'; ?>
<?php include '../chart/koneksi_opp.php'; ?>
<?php include '../chart/koneksi_otrs_sd.php'; ?>

<?php
//error_reporting(0);   
error_reporting(E_ALL);
$tglawal=$_POST['tglawal'];
$tglakhir=$_POST['tglakhir'];
$query_users="select (((u.first_name) :: TEXT || ' ' :: TEXT) || (u.last_name) :: TEXT) AS uname from ticket T  
JOIN users u ON T .user_id = u. ID
WHERE T.create_time::date >='$tglawal'
and T.create_time::date <='$tglakhir'  
and T.ticket_state_id in('1','4','6','13')
and T.user_id in('1','18','22','27','30','38','40','34')
group by uname";
$query="select 
case when priority_name ='1 very low' then 'very low' 
when priority_name ='2 low' then 'low'
when priority_name ='3 normal' then 'normal' 
when priority_name ='4 high' then 'high'
when priority_name ='5 very high' then 'very high'
else 'undefined' end as priority_name_mod,
case when (hours - pemulih) <= param_aman and state_name <> 'closed success' and state_name ='follow up' then 'follow_up'
when (hours - pemulih) <= param_aman and state_name <> 'closed success' then 'aman'
when (hours - pemulih) > param_aman and (hours - pemulih) <= param_wanti_wanti and state_name <> 'closed success'then 'wanti_wanti'
when (hours - pemulih) > param_wanti_wanti and state_name <> 'closed success' then 'bahaya' 
else '--' end as kondisi,
param_wanti_wanti-(hours - pemulih) as left_hours_wanti_wanti,param_aman-(hours - pemulih) as left_hours_aman,(hours - pemulih) as total_hours ,* from( 
SELECT
(SELECT count (*) FROM daging_tgl  where tgl >= (T.create_time::date)::text AND tgl <= (now()::date)::text)*24
 as pemulih,
case when (select count(*) from ticket_history where ticket_id=T.id and state_id =13) > 0 then 8
when tx.name ='1 very low' then 6 
when tx.name ='2 low' then 4 
when tx.name ='3 normal' then 2 
when tx.name ='4 high' then 1 
when tx.name ='5 very high' then 0
else 0
end as param_aman,
case when (select count(*) from ticket_history where ticket_id=T.id and state_id =13) > 0 then 12
when tx.name ='1 very low' then 10 
when tx.name ='2 low' then 6
when tx.name ='3 normal' then 4 
when tx.name ='4 high' then 2 
when tx.name ='5 very high' then  0
else  0
end as param_wanti_wanti,
FLOOR((EXTRACT(EPOCH FROM now())-EXTRACT(EPOCH FROM T.create_time))/3600)
 as hours, 
FLOOR(((EXTRACT(EPOCH FROM now())-EXTRACT(EPOCH FROM T.create_time))/3600)/24) 
 as days,
    T . ID,
    T .tn,
    T .title,
    T .queue_id,
    T .ticket_lock_id,
    T .ticket_answered,
    T .type_id,
    tt. NAME AS type_name,
    T .ticket_state_id,
    ts. NAME AS state_name,
    T .valid_id,
    T .archive_flag,
    T .create_time_unix,
    T .create_time,
    T .create_by,
    T .change_time,
    T .change_by,
    T .user_id,
    T .customer_id,
    tx.name as priority_name,
    (((u.first_name) :: TEXT || ' ' :: TEXT) || (u.last_name) :: TEXT) AS uname
FROM ticket T JOIN ticket_type tt ON T .type_id = tt. ID
            JOIN ticket_state ts ON T .ticket_state_id = ts. ID
            JOIN ticket_priority tx ON T .ticket_priority_id = tx. ID

        LEFT JOIN users u ON T .user_id = u. ID


WHERE T.create_time::date >='$tglawal'
and T.create_time::date <='$tglakhir' 
AND T.ticket_state_id in('1','4','6','13')
AND T.user_id in('1','18','22','27','30','38','40','34')
)as t1";

 
// $get_user_login = pg_query($conn_otrs_sd,"select login from users where id in('38','40','34'/*,'41','30','27','22'*/)")or die(pg_last_error($conn_otrs_sd));
// $variable = pg_fetch_all($get_user_login);

  $get_user = pg_query($conn_otrs_sd, $query_users
)or die(pg_last_error($conn_otrs_sd));
   $get_ticket = pg_query($conn_otrs_sd, $query
)or die(pg_last_error($conn_otrs_sd));
  // echo "<pre>";
// print_r($dataPoints);
// echo "</pre>";
// echo "<br/>";


$x =0;
$x1 =0;
$x2 =0; 
$x3 =0;
$x4 =0; 
$x5 =0; 
$aman=0;
$wanti_wanti=0;
$bahaya=0;
$follow_up=0;
$dataPoints =[];
$arrayTicket=[];
while ($row = pg_fetch_assoc($get_ticket)) {
		$arrayTicket[$x] = array(
			'tn'=>$row['tn'],
			'kondisi'=>$row['kondisi'],
			'uname'=>$row['uname'],
			'priority_name_mod'=>$row['priority_name_mod'],
		);
        if($row['kondisi']=='aman'){
         $x1 ++; 
        }elseif($row['kondisi']=='wanti_wanti'){
         
         $x2 ++; 
        }elseif($row['kondisi']=='bahaya'){
         
       $x3++; 
        }elseif($row['kondisi']=='follow_up'){
        
         $x4 ++; 
        }
    $x ++; 

    }
    $dataPoints['satu']['aman'] = array( 
                            'label'=>'aman' , 
                            'y'=> $x1
                            );
    $dataPoints['satu']['wanti_wanti'] = array( 
                            'label'=>'wanti_wanti' , 
                            'y'=> $x2
                            );
    $dataPoints['satu']['bahaya'] = array( 
                            'label'=>'bahaya' , 
                            'y'=> $x3
                            );
     $dataPoints['satu']['follow_up'] = array( 
                            'label'=>'follow_up' , 
                            'y'=> $x4
                            );
$xy =0;
$xx =0;
$xx1 =0;
$xx2 =0; 
$xx3 =0;
$xx4 =0; 
$xx5 =0; 
$total=[];
$users=[];

while ($val = pg_fetch_assoc($get_user)) {
$users[$xy]=$val["uname"];
        $total["{$val['uname']}"]['aman'] = 0;
        $total["{$val['uname']}"]['wanti_wanti'] = 0;
        $total["{$val['uname']}"]['bahaya'] = 0;
        $total["{$val['uname']}"]['follow_up'] = 0;
     foreach ($arrayTicket as $key => $row) {
        if( $row['uname']==$val['uname'] and $row['kondisi']=='aman'){
            $xx1 ++; 
         $total["{$val['uname']}"]['aman'] =   $total["{$val['uname']}"]['aman']+1; 
        }if($row['uname']==$val['uname'] and $row['kondisi']=='wanti_wanti' ){
         $xx2 ++; 
         $total["{$val['uname']}"]['wanti_wanti'] = $total["{$val['uname']}"]['wanti_wanti']+ 1; 
        }if($row['uname']==$val['uname'] and $row['kondisi']=='bahaya'){
       $xx3++; 
        $total["{$val['uname']}"]['bahaya'] = $total["{$val['uname']}"]['bahaya'] + 1; 
        //echo $val['uname'].'--'.$total["{$val['uname']}"]['bahaya'];
        }if($row['uname']==$val['uname'] and $row['kondisi']=='follow_up'){ 
        $xx4 ++; 
         $total["{$val['uname']}"]['follow_up'] = $total["{$val['uname']}"]['follow_up']+1; 
        } 
        $xx ++; 
    }
    $xy++;
}

$x=0;
foreach ($users as $vals) {

     $dataPoints['dua'][$x]['aman'] = array( 
                            'label'=>$vals , 
                            'y'=>    $total[$vals]['aman']
                            );
     $dataPoints['dua'][$x]['wanti_wanti'] = array( 
                            'label'=>$vals , 
                            'y'=>   $total[$vals]['wanti_wanti']
                            );
     $dataPoints['dua'][$x]['bahaya'] = array( 
                            'label'=>$vals , 
                            'y'=>   $total[$vals]['bahaya']
                            );
     $dataPoints['dua'][$x]['follow_up'] = array( 
                            'label'=>$vals , 
                            'y'=>   $total[$vals]['follow_up']
                            );
     $x++;
     }


//print_r($dataPoints);
header('Content-Type: application/json');
echo json_encode($dataPoints);



