<?php include '../header_new.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../koneksi_opp.php'; ?>

<?php
/*
 $key ='hanif';
  $enckey=urlencode(base64_encode($key)); 
  $link=urlencode(base64_encode($enckey.$paramlink)); 
 echo $link; 
*/
 ?>

<h1>BAR CHART TICKET OTRS</h1>
<a href="<?php echo BaseURL() .'bar_chart_ps.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Ticket Status</a>
<a href="<?php echo BaseURL() .'bar_chart_status.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Polis Status</a>
<a href="<?php echo BaseURL() .'bar_chart_stage.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Stage</a>
<a href="<?php echo BaseURL() .'bar_chart_opp_ps.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Closed Tickets Not Found in OPP</a>
<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" > <a href="<?php echo BaseURL() .'excel_opp_ps.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>" class="next" target="_blank">List Order Printing Polis</a> </p>
<hr />
<a href="<?php echo BaseURL() .'pie_chart_ps.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>" class="next">Pie &raquo;</a>
<div id="chartContainer"></div>
 <?php
ini_set('error_reporting',E_ALL);


if(empty($team)){
echo "Empty Parameter.\n";
            exit;
}else{
//echo $param;
        $closed = pg_query($conn_opp, "
        SELECT
    b.user_login,
    COALESCE (COUNT(b.user_login), 0) AS jumlah_ticket
FROM
    (
        SELECT
            *
        FROM
            dblink (
                'host=10.11.12.84 user=postgres dbname=otrs2_4_201610',
                $$ SELECT
                    A .user_login,
                    C .tn AS ticket_number --COALESCE(count (user_login),0) as jumlah_ticket 
                FROM
                    teams AS A
                JOIN users AS b ON b. LOGIN = A .user_login
                JOIN ticket AS C ON C .user_id = b. ID
                JOIN ticket_state AS d ON d. ID = C .ticket_state_id
                WHERE
                    A .team_id = $team
                AND A .status_user = 1
                AND A .level_user = 1
                AND d. ID in ('2','3')
                AND C .create_time :: DATE >= '$tglawal'
                AND C .create_time :: DATE <= '$tglakhir'
                AND c.queue_id <> '169'
                GROUP BY
                    A . ID,
                    A .user_login,
                    A .status_user,
                    A .team_id,
                    d. NAME,
                    C .tn
                ORDER BY
                    user_login ASC $$
            ) AS a1 (
                user_login VARCHAR,
                ticket_number VARCHAR
            )
    ) b
JOIN tbl_helpdesk_integration C USING (ticket_number)
LEFT JOIN tbl_log_order_printing_polis d ON C .sales_number = d.polis and c.revision_number=d.rev
WHERE
substr(c.sales_number, 4 ,3)not in ('187','417') AND
 b.ticket_number IS NOT NULL
AND C .sales_number IS NOT NULL
AND substr(c.sales_number, 1 ,1) <> 'Q'
AND d.param IS NULL
GROUP BY
    b.user_login")or die(pg_last_error($conn_opp));


        if ( !$closed) {
            echo "An error occurred.\n";
            exit;
        }

         $x = 0;
         while ($row = pg_fetch_assoc($closed)) {
            $dataPoints9[$x] = array( 
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
        text: "Closed Tickets Not Found in OPP Team <?php echo $team; ?>"
    },
     subtitles: [{
        text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
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
            name:  "Ticket Closed",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints9, JSON_NUMERIC_CHECK); ?>
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
