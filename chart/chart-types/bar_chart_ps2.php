<?php include '../header.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>

<h1>Column Chart</h1>
<div id="chartContainer"></div>
 <?php
ini_set('error_reporting',E_ALL);

$pending_follow_up_sales = pg_query($conn, "
select a.*,'new' as name, 0 as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id<>12
and user_login not in(select user_login
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=12
group by a.id,a.user_login,a.status_user,a.team_id,d.name)
group by a.id,a.user_login,a.status_user,a.team_id
union
select a.*,d.name, COALESCE(count (user_login),0) as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=12
group by a.id,a.user_login,a.status_user,a.team_id,d.name;")or die(pg_last_error($conn));

$op = pg_query($conn, "
select a.*,'new' as name, 0 as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id<>13
and user_login not in(select user_login
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=13
group by a.id,a.user_login,a.status_user,a.team_id,d.name)
group by a.id,a.user_login,a.status_user,a.team_id
union
select a.*,d.name, COALESCE(count (user_login),0) as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=13
group by a.id,a.user_login,a.status_user,a.team_id,d.name;")or die(pg_last_error($conn));

$merged = pg_query($conn, "
select a.*,'new' as name, 0 as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id<>9
and user_login not in(select user_login
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=9
group by a.id,a.user_login,a.status_user,a.team_id,d.name)
group by a.id,a.user_login,a.status_user,a.team_id
union
select a.*,d.name, COALESCE(count (user_login),0) as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=9
group by a.id,a.user_login,a.status_user,a.team_id,d.name;")or die(pg_last_error($conn));

$assessment = pg_query($conn, "
select a.*,'new' as name, 0 as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id<>14
and user_login not in(select user_login
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=14
group by a.id,a.user_login,a.status_user,a.team_id,d.name)
group by a.id,a.user_login,a.status_user,a.team_id
union
select a.*,d.name, COALESCE(count (user_login),0) as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=14
group by a.id,a.user_login,a.status_user,a.team_id,d.name;")or die(pg_last_error($conn));

$pending_follow_up_uw = pg_query($conn, "
select a.*,'new' as name, 0 as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id<>16
and user_login not in(select user_login
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=16
group by a.id,a.user_login,a.status_user,a.team_id,d.name)
group by a.id,a.user_login,a.status_user,a.team_id
union
select a.*,d.name, COALESCE(count (user_login),0) as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=16
group by a.id,a.user_login,a.status_user,a.team_id,d.name;")or die(pg_last_error($conn));

$posted = pg_query($conn, "
select a.*,'new' as name, 0 as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id<>15
and user_login not in(select user_login
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=15
group by a.id,a.user_login,a.status_user,a.team_id,d.name)
group by a.id,a.user_login,a.status_user,a.team_id
union
select a.*,d.name, COALESCE(count (user_login),0) as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=15
group by a.id,a.user_login,a.status_user,a.team_id,d.name")or die(pg_last_error($conn));

$open = pg_query($conn, "
select a.*,'new' as name, 0 as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id<>4
and user_login not in(select user_login
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=4
group by a.id,a.user_login,a.status_user,a.team_id,d.name)
group by a.id,a.user_login,a.status_user,a.team_id
union
select a.*,d.name, COALESCE(count (user_login),0) as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=4
group by a.id,a.user_login,a.status_user,a.team_id,d.name")or die(pg_last_error($conn));

$new = pg_query($conn, "
select a.*,'new' as name, 0 as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id<>1
and user_login not in(select user_login
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=1
group by a.id,a.user_login,a.status_user,a.team_id,d.name)
group by a.id,a.user_login,a.status_user,a.team_id
union
select a.*,d.name, COALESCE(count (user_login),0) as jumlah_ticket 
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id=1 and a.status_user='1' and d.id=1
group by a.id,a.user_login,a.status_user,a.team_id,d.name")or die(pg_last_error($conn));


if (!$pending_follow_up_sales) {
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
 while ($row = pg_fetch_assoc($merged)) {
    $dataPoints5[$x] = array( 
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

  $x = 0;
 while ($row = pg_fetch_assoc($pending_follow_up_uw)) {
    $dataPoints4[$x] = array( 
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



/*
$dataPoints1 = array(
    array("label"=> "cecep", "y"=> 12),
    array("label"=> "raja", "y"=> 13),
    array("label"=> "eka", "y"=> 20),
    array("label"=> "eny", "y"=> 30),
    array("label"=> "ilham", "y"=> 42),
    array("label"=> "krisna", "y"=> 12),
    array("label"=> "anggar", "y"=> 15),
    array("label"=> "feri", "y"=> 7)
);


$dataPoints2 = array(
    array("label"=> "cecep", "y"=> 12),
    array("label"=> "raja", "y"=> 13),
    array("label"=> "eka", "y"=> 20),
    array("label"=> "eny", "y"=> 30),
    array("label"=> "ilham", "y"=> 42),
    array("label"=> "krisna", "y"=> 12),
    array("label"=> "anggar", "y"=> 15),
    array("label"=> "feri", "y"=> 7)
);

$dataPoints3 = array(
    array("label"=> "cecep", "y"=> 12),
    array("label"=> "raja", "y"=> 13),
    array("label"=> "eka", "y"=> 20),
    array("label"=> "eny", "y"=> 30),
    array("label"=> "ilham", "y"=> 42),
    array("label"=> "krisna", "y"=> 12),
    array("label"=> "anggar", "y"=> 15),
    array("label"=> "feri", "y"=> 7)
);

$dataPoints4 = array(
    array("label"=> "cecep", "y"=> 12),
    array("label"=> "raja", "y"=> 13),
    array("label"=> "eka", "y"=> 20),
    array("label"=> "eny", "y"=> 30),
    array("label"=> "ilham", "y"=> 42),
    array("label"=> "krisna", "y"=> 12),
    array("label"=> "anggar", "y"=> 15),
    array("label"=> "feri", "y"=> 7)
);
$dataPoints5 = array(
    array("label"=> "cecep", "y"=> 12),
    array("label"=> "raja", "y"=> 13),
    array("label"=> "eka", "y"=> 20),
    array("label"=> "eny", "y"=> 30),
    array("label"=> "ilham", "y"=> 42),
    array("label"=> "krisna", "y"=> 12),
    array("label"=> "anggar", "y"=> 15),
    array("label"=> "feri", "y"=> 7)
);
$dataPoints6 = array(
    array("label"=> "cecep", "y"=> 12),
    array("label"=> "raja", "y"=> 13),
    array("label"=> "eka", "y"=> 20),
    array("label"=> "eny", "y"=> 30),
    array("label"=> "ilham", "y"=> 42),
    array("label"=> "krisna", "y"=> 12),
    array("label"=> "anggar", "y"=> 15),
    array("label"=> "feri", "y"=> 7)
);
$dataPoints7 = array(
    array("label"=> "cecep", "y"=> 12),
    array("label"=> "raja", "y"=> 13),
    array("label"=> "eka", "y"=> 20),
    array("label"=> "eny", "y"=> 30),
    array("label"=> "ilham", "y"=> 42),
    array("label"=> "krisna", "y"=> 12),
    array("label"=> "anggar", "y"=> 15),
    array("label"=> "feri", "y"=> 7)
);
$dataPoints8 = array(
    array("label"=> "cecep", "y"=> 12),
    array("label"=> "raja", "y"=> 13),
    array("label"=> "eka", "y"=> 20),
    array("label"=> "eny", "y"=> 30),
    array("label"=> "ilham", "y"=> 42),
    array("label"=> "krisna", "y"=> 12),
    array("label"=> "anggar", "y"=> 15),
    array("label"=> "feri", "y"=> 7)
);
 */
?>

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
    title: {
        text: "Chart Ticket"
    },
    theme: "light2",
    animationEnabled: true,
    toolTip:{
        shared: true,
        reversed: true
    },
    axisY: {
        title: "Cumulative Capacity",
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
            name: "merged",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name:  "Assessment UW/RI",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
        },{
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
</script>

<?php include '../footer.php'; ?>