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
$team=$_POST['team'];

}

if($_POST['bar_otrs']==1){
 // $tglawal='2020-01-01';
 // $tglakhir='2020-09-22';
 // $team=1;
$pending_follow_up_sales = pg_query($conn, "
        select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1 and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=12
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=12
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $op = pg_query($conn, "
        select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1 and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=13
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=13
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $merged = pg_query($conn, "
         select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1  and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=9
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=9
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $assessment = pg_query($conn, "
        select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1  and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=14
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=14
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $pending_follow_up_uw = pg_query($conn, "
        select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1  and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=16
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=16
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $posted = pg_query($conn, "
         select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1  and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=15
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=15
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $open = pg_query($conn, "
         select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1  and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=4
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=4
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $new = pg_query($conn, "
        select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1  and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=1
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=1
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $closed_unsuccessful = pg_query($conn, "
        select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1  and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=3
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=3
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $pending_document = pg_query($conn, "
        select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1  and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=21
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=21
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

         $pending_follow_up_reinsurer = pg_query($conn, "
        select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1  and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=17
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=17
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $pending_follow_up_maker = pg_query($conn, "
        select user_login, 0 as jumlah_ticket 
        from teams where team_id=$team and status_user=1 and  level_user=1  and user_login not in(select user_login
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and a.level_user=1 and d.id=22
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from teams as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.team_id=$team and a.status_user=1 and  a.level_user=1 and d.id=22
        and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        if (!$pending_follow_up_sales OR !$op OR !$merged OR !$assessment OR !$pending_follow_up_uw OR !$posted OR !$open OR !$new OR !$closed_unsuccessful OR !$pending_document OR !$pending_follow_up_reinsurer OR !$pending_follow_up_maker) {
            echo "An error occurred.\n";
            exit;
        }


        $x = 0;
        $array=pg_fetch_all($pending_follow_up_sales);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['pending_follow_up_sales'] = array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         } 

         $x = 0;
         $array=pg_fetch_all($op);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['on_progress'] = array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         } 

          $x = 0;
          $array=pg_fetch_all($assessment);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['assessment'] = array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         } 
/*
          $x = 0;
          $array=pg_fetch_all($merged);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['merged'] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 
         */

          $x = 0;

          $array=pg_fetch_all($pending_follow_up_uw);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['pending_follow_up_uw'] = array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         } 



          $x = 0;

          $array=pg_fetch_all($posted);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['posted'] = array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         }  

          $x = 0;

          $array=pg_fetch_all($open);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['open'] = array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         } 

          $x = 0;
          $array=pg_fetch_all($new);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['new']= array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         } 

         $x = 0;
          $array=pg_fetch_all($closed_unsuccessful);
        foreach ($array as $key => $row) {
            $dataPoints[$x] ['closed_unsuccessful']= array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         } 

           $x = 0;
          $array=pg_fetch_all($pending_document);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['pending_document'] = array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         } 
             $x = 0;
           $array=pg_fetch_all($pending_follow_up_reinsurer);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['pending_follow_up_reinsurer'] = array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         } 
            $x = 0;
        $array=pg_fetch_all($pending_follow_up_maker);
        foreach ($array as $key => $row) {
            $dataPoints[$x]['pending_follow_up_maker'] = array( 
                'label'=>$row['user_login'] , 
                'y'=>intval($row['jumlah_ticket']),
                );
              $x ++; 
         } 



header('Content-Type: application/json');
echo json_encode($dataPoints);

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

?>