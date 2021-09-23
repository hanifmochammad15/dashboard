
<?php include '../header2.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php $team = $_GET['team']; ?>
<?php
/*
 $key ='hanif';
  $enckey=urlencode(base64_encode($key)); 
  $link=urlencode(base64_encode($enckey.$paramlink)); 
 echo $link; 
*/
 ?>

<?php 
if($team==1){$queue = 159;}
    elseif ($team==2){$queue = 160;}
    elseif ($team==3){$queue = 161;}
    elseif ($team==4){$queue = 162;}
          
?>
<h1>BAR CHART TICKET OTRS UNDERWRITING</h1>
<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<?php if($team==2){?>
<a href="<?php echo BaseURL() .'bar_chart_uw_team2_2.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>" class="next">Chart Policy Status</a>
<?php }?>
<hr />
<!--
<a href="<?php echo BaseURL() ;?>pie_chart_uw.php?team=<?php echo $team;?>" class="next">Pie &raquo;</a>-->
<div id="chartContainer"></div>
 <?php
ini_set('error_reporting',E_ALL);


if(empty($team)){
echo "Empty Parameter.\n";
            exit;
}else{
echo $team;
        $closed_successful = pg_query($conn, "
        select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select user_login
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where  a.status_user=1 and a.level_user=1 and d.id=2
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        group by a.id,a.user_login,a.status_user,a.team_id
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.status_user=1 and  a.level_user=1 and d.id=2
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $open = pg_query($conn, "
          select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select user_login
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where  a.status_user=1 and a.level_user=1 and d.id=4
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        group by a.id,a.user_login,a.status_user,a.team_id
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.status_user=1 and  a.level_user=1 and d.id=4
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $closed_unsuccessful = pg_query($conn, "
          select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select user_login
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where  a.status_user=1 and a.level_user=1 and d.id=3
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        group by a.id,a.user_login,a.status_user,a.team_id
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.status_user=1 and  a.level_user=1 and d.id=3
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $assessment = pg_query($conn, "
          select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select user_login
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where  a.status_user=1 and a.level_user=1 and d.id=14
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        group by a.id,a.user_login,a.status_user,a.team_id
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.status_user=1 and  a.level_user=1 and d.id=14
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $unconfirmed_facultative = pg_query($conn, "
          select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select user_login
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where  a.status_user=1 and a.level_user=1 and d.id=20
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        group by a.id,a.user_login,a.status_user,a.team_id
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.status_user=1 and  a.level_user=1 and d.id=20
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

        $new = pg_query($conn, "
         select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select user_login
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where  a.status_user=1 and a.level_user=1 and d.id=1
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name)
        group by a.id,a.user_login,a.status_user,a.team_id
        union
        select a.user_login, COALESCE(count (user_login),0) as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
        join users as b on b.login=a.user_login
        join ticket as c on c.user_id=b.id
        join ticket_state as d on d.id=c.ticket_state_id
        where a.status_user=1 and  a.level_user=1 and d.id=1
                and c.create_time::date >='$tglawal'
                and c.create_time::date <='$tglakhir'
        group by a.id,a.user_login,a.status_user,a.team_id,d.name order by user_login asc")or die(pg_last_error($conn));

/*

        if (!$closed_successful OR !$open OR !$new OR !$unconfirmed_facultative OR !$assessment OR !$closed_unsuccessful ) {
            echo "An error occurred.\n";
            exit;
        }
*/
         $x = 0;
         while ($row = pg_fetch_assoc($closed_successful)) {
            $dataPoints1[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

         $x = 0;
         while ($row = pg_fetch_assoc($open)) {
            $dataPoints2[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

          $x = 0;
         while ($row = pg_fetch_assoc($new)) {
            $dataPoints3[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 


          $x = 0;
         while ($row = pg_fetch_assoc($unconfirmed_facultative)) {
            $dataPoints4[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 



          $x = 0;
         while ($row = pg_fetch_assoc($assessment)) {
            $dataPoints5[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         }  

          $x = 0;
         while ($row = pg_fetch_assoc($closed_unsuccessful)) {
            $dataPoints6[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

}//end else
//print_r($dataPoints1);
?>


<script>


window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
    title: {
        text: "Chart Ticket OTRS Team <?php echo $team; ?>"
    },
     subtitles: [{
        text: "<?php echo date ('Y M d');?>"
    }],
    theme: "light2",
    animationEnabled: true,
    toolTip:{
        shared: true,
        reversed: true
    },
    axisY: {
        title: "Total Ticket OTRS",
        suffix: " Ticket"
    },
    legend: {
        cursor: "pointer",
        itemclick: toggleDataSeries
    },
     data: [
        {
            type: "stackedColumn",
            name: "Closed Successful",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "Open",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "New",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
        },
        {
            type: "stackedColumn",
            name:  "Unconfirmed Facultative",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
        },
        {
            type: "stackedColumn",
            name: "Assessment UW/RI",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "Closed Unsuccessful",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
        }
    ]
});
 
chart.render();
 
function toggleDataSeries(e) {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    e.chart.render();
}
 
}

setTimeout(function(){
   window.location.reload(1);
}, 60000); // 1menit

</script>


<?php include '../footer.php'; ?>
