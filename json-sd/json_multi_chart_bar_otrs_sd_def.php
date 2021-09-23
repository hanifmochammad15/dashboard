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

$query_old ="SELECT
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
    (
        (
            (u.first_name) :: TEXT || ' ' :: TEXT
        ) || (u.last_name) :: TEXT
    ) AS uname
FROM
    (
        (
            (
                ticket T
                JOIN ticket_type tt ON ((T .type_id = tt. ID))
            )
            JOIN ticket_state ts ON ((T .ticket_state_id = ts. ID))
        )
        JOIN users u ON ((T .user_id = u. ID))
    )
WHERE
    (
        (
            (
                (
                    date_part('year' :: TEXT, T .create_time) = date_part(
                        'year' :: TEXT,
                        ('now' :: TEXT) :: DATE
                    )
                )
                AND (
                    date_part(
                        'month' :: TEXT,
                        T .create_time
                    ) = date_part(
                        'month' :: TEXT,
                        ('now' :: TEXT) :: DATE
                    )
                )
            )
            AND (
                (
                    (
                        (T .ticket_state_id = 1)
                        OR (T .ticket_state_id = 2)
                    )
                    OR (T .ticket_state_id = 4)
                )
                OR (T .ticket_state_id = 6)
            )
        )
        AND (
            (
                (
                    (
                        (
                            (
                                (
                                    (T .user_id = 29)
                                    OR (T .user_id = 18)
                                )
                                OR (T .user_id = 22)
                            )
                            OR (T .user_id = 27)
                        )
                        OR (T .user_id = 30)
                    )
                    OR (T .user_id = 34)
                )
                OR (T .user_id = 38)
            )
            OR (T .user_id = 40)
        )
    )
";

$query="SELECT
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
    (((u.first_name) :: TEXT || ' ' :: TEXT) || (u.last_name) :: TEXT) AS uname
FROM ticket T JOIN ticket_type tt ON T .type_id = tt. ID
            JOIN ticket_state ts ON T .ticket_state_id = ts. ID
            JOIN ticket_priority tx ON T .ticket_priority_id = tx. ID

        JOIN users u ON T .user_id = u. ID
        where T.create_time::date >='$tglawal'
and T.create_time::date <='$tglakhir'    
AND T.ticket_state_id in('1','2','4','6','13')
AND T.user_id in('18','22','27','30','38','40','34')";

// $get_user_login = pg_query($conn_otrs_sd,"select login from users where id in('38','40','34'/*,'41','30','27','22'*/)")or die(pg_last_error($conn_otrs_sd));
// $variable = pg_fetch_all($get_user_login);

  $get_ticket = pg_query($conn_otrs_sd, "SELECT count(id) as total,type_id,type_name,user_id,uname from (
    ".$query."
)as t1 GROUP BY type_id,type_name,user_id,uname
ORDER BY total desc, uname,type_name"
)or die(pg_last_error($conn_otrs_sd));
  $x =0;
  $type_name_Index=[];
  $uname_name_Index=[];
  $fullArray=[];
while ($row = pg_fetch_assoc($get_ticket)) {
        $type_name_Index[$x]=$row['type_name'];
        $uname_name_Index[$x]=$row['uname'];
        $fullArray [$x]= array('total' => $row['total'], 
                                'type_id' => $row['type_id'],
                                'type_name' => $row['type_name'],
                                'user_id' => $row['user_id'],
                                'uname' => $row['uname'],
                                );


    $x ++; 

    }
$type_name_unique=array_unique($type_name_Index);
$x=0;
$type_name_arr=[];
foreach ($type_name_unique as  $value) {
    $type_name_arr[$x]=$value;
    $x ++; 
}

$uname_name_unique=array_unique($uname_name_Index);
$x=0;
$uname_name_arr=[];
foreach ($uname_name_unique as  $value) {
    $uname_name_arr[$x]=$value;
    $x ++;
}

$dataPoints=[];
$x=0;
foreach ($type_name_arr as $type_name) {
    foreach ($uname_name_arr as $uname) {
        foreach ($fullArray as $key => $val) {
            if($type_name == $val['type_name'] And $uname == $val['uname']){
                  if (array_key_exists($val['type_name'], $dataPoints)) {
                        $dataPoints[$type_name ][$val['uname']]= intval($val['total']) ;
                    }else{
                        $dataPoints[$type_name ]= array($val['uname'] => intval($val['total'] ));
                    }
                }

        }
       // echo $type_name;
        //print_r( $dataPoints[$type_name ]);
        if(empty($dataPoints[$type_name ][$uname])){
           $dataPoints[$type_name ][$uname]= 0;
        }
}
    # code...
  
}
// echo "<pre>";
// print_r($dataPoints);
// echo "</pre>";
// echo "<br/>";


header('Content-Type: application/json');
echo json_encode($dataPoints);



