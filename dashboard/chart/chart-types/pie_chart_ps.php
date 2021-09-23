<?php include '../header_new.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php
/*
 $key ='hanif';
  $enckey=urlencode(base64_encode($key)); 
  $link=urlencode(base64_encode($enckey.$paramlink)); 
 echo $link; 
*/
 ?>

<h1>PIE CHART TICKET OTRS</h1>
<a href="<?php echo BaseURL() .'bar_chart_ps.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Ticket Status</a>
<a href="<?php echo BaseURL() .'bar_chart_status.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Polis Status</a>
<a href="<?php echo BaseURL() .'bar_chart_stage.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Stage</a>
<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<hr />
<a href="<?php echo BaseURL() .'bar_chart_ps.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Bar &raquo;</a>
<div id="chartContainer"></div>

 <?php


ini_set('error_reporting',E_ALL);

if(empty($team)){
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
where a.team_id='$team' and a.status_user=1 and a.level_user=1 
and c.create_time::date >='$tglawal'
and c.create_time::date <='$tglakhir'
and d.id in('1','4','13','14','15','12','16','3','21','17'))::NUMERIC *100),2)
 as percentage  
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id='$team' and a.status_user=1 and a.level_user=1 
and c.create_time::date >='$tglawal'
and c.create_time::date <='$tglakhir'
and d.id in('1','4','13','14','15','12','16','3','21','17')
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

//print_r($dataPoints);
 
 }

?>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    title: {
        text: "Team <?php echo $team;?>"
    },
    subtitles: [{
        text: "<?php echo $tglawal .' -- '.$tglakhir.' (yyyy-mm-dd)' ;?>"
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