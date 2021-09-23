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

<h1>BAR CHART TICKET OTRS</h1>
<a href="<?php echo BaseURL() ;?>bar_chart_ps.php?team=1" class="next">Chart Ticket Status</a>
<a href="<?php echo BaseURL() ;?>bar_chart_status.php?team=2" class="next">Chart Polis Status</a>
<a href="<?php echo BaseURL() ;?>bar_chart_stage.php?team=3" class="next">Chart Stage</a>
<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<hr />
<a href="<?php echo BaseURL() ;?>pie_chart_ps.php?team=<?php echo $team;?>" class="next">Pie &raquo;</a>

<div class="row">
  <div class="column" >
    <div id="chartContainerPie"></div>
  </div>
  <div class="column" >
    <div id="chartContainerBar"></div>
  </div>
 <?php
ini_set('error_reporting',E_ALL);


if(empty($team)){
echo "Empty Parameter.\n";
            exit;
}else{
//echo $param;
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

        if (!$pending_follow_up_sales OR !$op OR !$merged OR !$assessment OR !$pending_follow_up_uw OR !$posted OR !$open OR !$new OR !$closed_unsuccessful OR !$pending_document OR !$pending_follow_up_reinsurer) {
            echo "An error occurred.\n";
            exit;
        }

         $x = 0;
         while ($row = pg_fetch_assoc($pending_follow_up_sales)) {
            $dataPoints1[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

         $x = 0;
         while ($row = pg_fetch_assoc($op)) {
            $dataPoints2[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

          $x = 0;
         while ($row = pg_fetch_assoc($assessment)) {
            $dataPoints3[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 
/*
          $x = 0;
         while ($row = pg_fetch_assoc($merged)) {
            $dataPoints4[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 
         */

          $x = 0;
         while ($row = pg_fetch_assoc($pending_follow_up_uw)) {
            $dataPoints5[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 



          $x = 0;
         while ($row = pg_fetch_assoc($posted)) {
            $dataPoints6[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         }  

          $x = 0;
         while ($row = pg_fetch_assoc($open)) {
            $dataPoints7[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

          $x = 0;
         while ($row = pg_fetch_assoc($new)) {
            $dataPoints8[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

         $x = 0;
         while ($row = pg_fetch_assoc($closed_unsuccessful)) {
            $dataPoints9[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

           $x = 0;
         while ($row = pg_fetch_assoc($pending_document)) {
            $dataPoints10[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 
             $x = 0;
         while ($row = pg_fetch_assoc($pending_follow_up_reinsurer)) {
            $dataPoints11[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

        $xyz = 0;
         while ($row = pg_fetch_assoc($que)) {
            $dataPointsPie[$xyz] = array( 
                'label'=>$row['name'].' -- ['.$row['jumlah_tiket'].' Ticket] --' , 
                'y'=>$row['percentage'],
                );
              $xyz ++; 
         } 






}//end else
//print_r($dataPoints1);
?>

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainerBar", {
    title: {
        text: "Chart Ticket Team <?php echo $team; ?>"
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
            name: "Pending Follow Up Sales",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "On Progress",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "Assessment UW/RI",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
        },/*
        {
            type: "stackedColumn",
            name:  "merged",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
        },*/
        {
            type: "stackedColumn",
            name: "Pending Follow Up UW",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "Posted",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "Open",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints7, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name:  "New",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints8, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name:  "Closed Unsuccessful",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints9, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name:  "Pending Document",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints10, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name:  "Pending Follow Up Reinsurer",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints11, JSON_NUMERIC_CHECK); ?>
        }
    ]
});
 
var chartPie = new CanvasJS.Chart("chartContainerPie", {
    animationEnabled: true,
    title: {
        text: "Team <?php echo $team;?>"
    },
    subtitles: [{
        text: "<?php echo date ('Y M d');?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPointsPie, JSON_NUMERIC_CHECK); ?>
    }]
});

chart.render();
chartPie.render();
 
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
