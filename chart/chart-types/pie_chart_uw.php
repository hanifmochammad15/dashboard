<?php include '../header2.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php $paramlink=$_GET["team"]; ?>
<?php
/*
 $key ='hanif';
  $enckey=urlencode(base64_encode($key)); 
  $link=urlencode(base64_encode($enckey.$paramlink)); 
 echo $link; 
*/
 ?>
<?php  $param= $_GET['team']; ?>
<?php 
if($param==1){$queue = 159;}
    elseif ($param==2){$queue = 160;}
    elseif ($param==3){$queue = 161;}
    elseif ($param==4){$queue = 162;}
          
?>
<h1>PIE CHART TICKET OTRS</h1>
<a href="<?php echo BaseURL() ;?>bar_chart_uw.php?team=<?php echo $paramlink;?>" class="next">Chart Ticket Status</a>
<div id="chartContainer"></div>
 <?php


ini_set('error_reporting',E_ALL);

if(empty($param)){
echo "Empty Parameter.\n";
            exit;
}else{
//echo $param;
        $que = pg_query($conn, "
select d.name, count (user_login) AS jumlah_tiket
,round((count (user_login)/(
select count(d.name) as total
from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue) as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.status_user=1 and a.level_user=1 and d.id in('2','3','4','14','20'))::NUMERIC *100),2)
 as percentage  
from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue) as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.status_user=1 and a.level_user=1 and d.id in('2','3','4','14','20')
group by d.name")or die(pg_last_error($conn));


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

//print_r($dataPoints);
 
 }

?>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    title: {
        text: "Team <?php echo $param;?>"
    },
    subtitles: [{
        text: "<?php echo date ('Y M d');?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
 
}
setTimeout(function(){
   window.location.reload(1);
}, 60000);
</script>

<?php include '../footer.php'; ?>