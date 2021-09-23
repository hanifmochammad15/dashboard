<?php include '../header.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>

<h1>Column Chart</h1>
<div id="chartContainer"></div>
 <?php
ini_set('error_reporting',E_ALL);

$param=$_GET["team"];
if(empty($param)){
echo "Empty Parameter.\n";
            exit;
}else{
//echo $param;
        $que = pg_query($conn, "
select d.name, count (user_login) AS jumlah_tiket
,round((count (user_login)/(
select count(d.name) as total
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id='$param' and a.status_user=1 and a.level_user=1 and d.id in('1','4','9','13','14','15','12','16'))::NUMERIC *100),2)
 as percentage  
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id='$param' and a.status_user=1 and a.level_user=1 and d.id in('1','4','9','13','14','15','12','16')
group by d.name
")or die(pg_last_error($conn));


        if (!$que) {
            echo "An error occurred.\n";
            exit;
        }
 /*
        $dataPoints = array( 
            array("label"=>"Chrome", "y"=>64.02),
            array("label"=>"Firefox", "y"=>12.55),
            array("label"=>"IE", "y"=>8.47),
            array("label"=>"Safari", "y"=>6.08),
            array("label"=>"Edge", "y"=>4.29),
            array("label"=>"Others", "y"=>4.59)
        );
        */

          $x = 0;
 while ($row = pg_fetch_assoc($que)) {
    $dataPoints[$x] = array( 
        'label'=>$row['name'].' -- ['.$row['jumlah_tiket'].' Ticket] --' , 
        'y'=>$row['percentage'],
        );
      $x ++; 
 } 
echo json_encode($dataPoints);
 
 }

?>

<?php include '../footer.php'; ?>