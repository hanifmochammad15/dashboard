<?php include '../chart/koneksi.php'; ?>
<?php include '../chart/nextg_koneksi.php'; ?>
<?php include '../chart/sharia_koneksi.php'; ?>
<?php include '../chart/koneksi_opp.php'; ?>

<?php
if( !empty($_POST['tglawal']) AND !empty($_POST['tglakhir'])){

$tglawal=$_POST['tglawal'];
$tglakhir=$_POST['tglakhir'];
}

if($_POST['summary_otrs']==1){
$queStatus = pg_query($conn, "
select d.name, count (user_login) AS jumlah_tiket
,round((count (user_login)/(
select count(d.name) as total
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id in('1','2','3','4') 
and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
and a.status_user=1 and a.level_user=1 and d.id in('1','4','13','14','15','12','16','3','21','17'))::NUMERIC *100),2)
 as percentage  
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id in('1','2','3','4') 
and c.create_time::date >='$tglawal'
        and c.create_time::date <='$tglakhir'
 and a.status_user=1 and a.level_user=1 and d.id in('1','4','13','14','15','12','16','3','21','17')

group by d.name
")or die(pg_last_error($conn));

    $cde = 0;
 while ($row = pg_fetch_assoc($queStatus)) {
    $dataPointsStatus[$cde] = array( 
        'label'=>$row['name'].' -- ['.$row['jumlah_tiket'].' Ticket] --' , 
        'y'=>$row['percentage'],
        );
      $cde ++; 
 }

 echo json_encode($dataPointsStatus);
}
