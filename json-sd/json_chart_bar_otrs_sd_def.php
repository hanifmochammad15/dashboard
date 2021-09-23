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

  $get_ticket = pg_query($conn_otrs_sd, "
select count(type_name) as total,type_name,type_id,state_name from (".$query."
 )
as t1 GROUP BY type_name,type_id,state_name
order by total desc;
")or die(pg_last_error($conn_otrs_sd));

//   $get_ticket2 = pg_query($conn_otrs_sd, "
// select count (uname) as total,uname,user_id,state_name from (".$query."
//  ) as t1 where user_id=40 or user_id = 22 or user_id = 27 or user_id = 30 or user_id = 34 or user_id = 38
// group by uname,state_name,user_id
// order by user_id,state_name;
// ")or die(pg_last_error($conn_otrs_sd));


// $get_user_login = pg_query($conn_otrs_sd,"select login from users where id in('38','40','34'/*,'41','30','27','22'*/)")or die(pg_last_error($conn_otrs_sd));
// $variable = pg_fetch_all($get_user_login);
$x =0;
$x1 =0;
$x2 =0; 
$x3 =0;
$x4 =0; 
$x5 =0; 
$arrayTypeName =[];
while ($row = pg_fetch_assoc($get_ticket)) {
    $arrayTypeName[$x] =$row['type_name'];
    $array [$x] = array('total'=>$row['total'],
                         'type_name'=>$row['type_name'],
                         'type_id'=>$row['type_id'],
                         'state_name'=>$row['state_name'],
                        );
        if($row['state_name']=='new'){
         $array1[$x1] = array( 
                        'total'=>$row['total'],
                        'type_name'=>$row['type_name'],
                        'type_id'=>$row['type_id'],
                        'state_name'=>$row['state_name'],
                        );
         $x1 ++; 
        }elseif($row['state_name']=='closed success'){
         $array2[$x2] = array( 
                        'total'=>$row['total'],
                        'type_name'=>$row['type_name'],
                        'type_id'=>$row['type_id'],
                        'state_name'=>$row['state_name'],
                        );
         $x2 ++; 
        }elseif($row['state_name']=='open'){
         $array3[$x3] = array( 
                        'total'=>$row['total'],
                        'type_name'=>$row['type_name'],
                        'type_id'=>$row['type_id'],
                        'state_name'=>$row['state_name'],
                        );
         $x3++; 
        }elseif($row['state_name']=='pending reminder'){
         $array4[$x4] = array( 
                        'total'=>$row['total'],
                        'type_name'=>$row['type_name'],
                        'type_id'=>$row['type_id'],
                        'state_name'=>$row['state_name'],
                        );
         $x4 ++; 
        }elseif($row['state_name']=='follow up'){
         $array5[$x5] = array( 
                        'total'=>$row['total'],
                        'type_name'=>$row['type_name'],
                        'type_id'=>$row['type_id'],
                        'state_name'=>$row['state_name'],
                        );
         $x5 ++; 
        }
    $x ++; 

    }

// echo "<pre>";
// print_r($array);
// $arrayTypeName=array_unique($arrayTypeName));
// echo "</pre>";
// echo "<br/>";
$arrayTypeNames=array_unique($arrayTypeName);

$arrayTypeIndex=[];
$x=0;
foreach ($arrayTypeNames as  $value) {
    $arrayTypeIndex[$x]=$value;
$x++;
}
//print_r($arrayTypeIndex);

$x1 =0;
$x2 =0; 
$x3 =0;
$x4 =0; 

$abc1 =[];
$xx1=0;
if(!empty($array1) ){
    foreach ($arrayTypeIndex as $key => $value) {

            foreach($array1 as $key =>$val) {
                ${$val['type_id']}=0; 
                if($value==$val['type_name'] ){
                 ${$val['type_id']} += $val['total'];
                 $abc1 [$x1]= $val['type_name'];
                $dataPointz[0]['new'][$x2] = array( 
                            'label'=>$val['type_name'] , 
                            'y'=> ${$val['type_id']}
                            );
                }



            $x1++;


        }
        $xx1+= $x1;
        if (in_array($value, $abc1)){
                        //no action
        }else{
        $dataPointz[0]['new'][$xx1] = array( 
                'label'=>$value , 
                'y'=> 0
                );
        }

        $xx1++;


    }
    $x1=0;
    foreach ($dataPointz[0]['new'] as  $value) {
        $dataPoints[0]['new'][$x1] = array( 
                    'label'=>$value['label'] , 
                    'y'=> $value['y']
                    );
        $x1++;
    }
}

$abc2 =[];
$xx2=0;
if(!empty($array2) ){
    foreach ($arrayTypeIndex as $key => $value) {

            foreach($array2 as $key =>$val) {
                ${$val['type_id']}=0; 
                if($value==$val['type_name'] ){
                 ${$val['type_id']} += $val['total'];
                 $abc2 [$x2]= $val['type_name'];
                $dataPointz[0]['closed_success'][$x2] = array( 
                            'label'=>$val['type_name'] , 
                            'y'=> ${$val['type_id']}
                            );
                }



            $x2++;


        }
        $xx2+= $x2;
        if (in_array($value, $abc2)){
                        //no action
        }else{
        $dataPointz[0]['closed_success'][$xx2] = array( 
                'label'=>$value , 
                'y'=> 0
                );
        }

        $xx2++;


    }

    $x2=0;
    foreach ($dataPointz[0]['closed_success'] as  $value) {
        $dataPoints[0]['closed_success'][$x2] = array( 
                    'label'=>$value['label'] , 
                    'y'=> $value['y']
                    );
        $x2++;
    }
}


$abc3 =[];
$xx3=0;
if(!empty($array3) ){
    foreach ($arrayTypeIndex as $value) {

            foreach($array3 as $key =>$val) {
                ${$val['type_id']}=0; 
                if($value==$val['type_name'] ){
                    ${$val['type_id']} += $val['total'];
                    //echo $val['type_name'];
                 $abc3 [$x3]= $val['type_name'];
                $dataPointz[0]['open'][$x3] = array( 
                            'label'=>$val['type_name'] , 
                            'y'=> ${$val['type_id']}
                            );
                }
            $x3++;


        }

        $xx3+= $x3;
        if (in_array($value, $abc3)){
                        //no action
        }else{
        $dataPointz[0]['open'][$xx3] = array( 
                'label'=>$value , 
                'y'=> 0
                );
        }

        $xx3++;

    }
    $x3=0;
    foreach ($dataPointz[0]['open'] as  $value) {
        $dataPoints[0]['open'][$x3] = array( 
                    'label'=>$value['label'] , 
                    'y'=> $value['y']
                    );
        $x3++;
    }
}

$abc4 =[];
$xx4=0;
if(!empty($array4) ){
    foreach ($arrayTypeIndex as $value) {

            foreach($array4 as $key =>$val) {
                ${$val['type_id']}=0; 
                if($value==$val['type_name'] ){
                    ${$val['type_id']} += $val['total'];
                    //echo $val['type_name'];
                 $abc4 [$x4]= $val['type_name'];
                $dataPointz[0]['pending_reminder'][$x4] = array( 
                            'label'=>$val['type_name'] , 
                            'y'=> ${$val['type_id']}
                            );
                }
            $x4++;


        }

        $xx4+= $x4;
        if (in_array($value, $abc4)){
                        //no action
        }else{
        $dataPointz[0]['pending_reminder'][$xx4] = array( 
                'label'=>$value , 
                'y'=> 0
                );
        }

        $xx4++;

    }
    $x4=0;
    foreach ($dataPointz[0]['pending_reminder'] as  $value) {
        $dataPoints[0]['pending_reminder'][$x4] = array( 
                    'label'=>$value['label'] , 
                    'y'=> $value['y']
                    );
        $x4++;
    }
}

$abc5 =[];
$xx5=0;
if(!empty($array4) ){
    foreach ($arrayTypeIndex as $value) {

            foreach($array5 as $key =>$val) {
                ${$val['type_id']}=0; 
                if($value==$val['type_name'] ){
                    ${$val['type_id']} += $val['total'];
                    //echo $val['type_name'];
                 $abc5 [$x5]= $val['type_name'];
                $dataPointz[0]['follow_up'][$x5] = array( 
                            'label'=>$val['type_name'] , 
                            'y'=> ${$val['type_id']}
                            );
                }
            $x5++;


        }

        $xx5+= $x5;
        if (in_array($value, $abc5)){
                        //no action
        }else{
        $dataPointz[0]['follow_up'][$xx5] = array( 
                'label'=>$value , 
                'y'=> 0
                );
        }

        $xx5++;

    }
    $x5=0;
    foreach ($dataPointz[0]['follow_up'] as  $value) {
        $dataPoints[0]['follow_up'][$x5] = array( 
                    'label'=>$value['label'] , 
                    'y'=> $value['y']
                    );
        $x5++;
    }
}

// while ($row = pg_fetch_assoc($get_ticket2)) {
//             $arrUname[$x]= $row['uname'];
//             $arrState_name[$x]= $row['state_name'];
//             $dataPointz2[$x] = array('total' =>$row ['total'] , 
//                                  'uname' =>$row ['uname'] ,
//                                  'user_id' =>$row ['user_id'] ,
//                                  'state_name' =>$row ['state_name'] ,
//                                     );
//             $x++;
//     }
// $x=0;
// $dataPoints[1]=[];
//          foreach ($dataPointz2 as $key => $value) {

//                 if (array_key_exists($value['uname'], $dataPoints[1])) {

//                     $dataPoints[1][$value['uname']][$value['state_name']] =$value ['total'];
//                     }else{
//                          $dataPoints[1][$value['uname']] = array($value ['state_name'] =>$value ['total']
//                          );
//                 }
//                 $x++;
//             }
   

 // echo "<pre>";
 // print_r($dataPoints);
 // echo "</pre>";
// echo "<br/>";


header('Content-Type: application/json');
echo json_encode($dataPoints);



