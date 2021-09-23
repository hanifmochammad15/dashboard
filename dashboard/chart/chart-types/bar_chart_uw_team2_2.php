
<?php include '../header2_2.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../nextg_koneksi.php'; ?>
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
<h1>BAR CHART TOTAL ASSESS POLICY UNDERWRITING</h1>
<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<a href="<?php echo BaseURL() .'bar_chart_uw.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>" class="next">Chart Ticket OTRS</a>
<a href="<?php echo BaseURL() .'table_uw_team2_2.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>" class="next">Table</a>
<a href="<?php echo BaseURL() .'bar_chart_uw_team2_3.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>" class="next">Invoiced & Paid Fully</a>
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
        $Approve = pg_query($nextg_conn, "                       
 select user_login , 0 as jumlah_ticket from(SELECT unnest(ARRAY['dhony.iswahyudi','parmawaty.lestari','queue']) as user_login)as a 
            where user_login not in(
                        SELECT user_login FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Approve')
              and b.sales_status ='Approve'
            and c.ticket_type='Risk Approval'
            and b.userid in('dhony.iswahyudi','parmawaty.lestari')
              and b.actiontime::date >='$tglawal'
             and b.actiontime::date <='$tglakhir'
            GROUP BY b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
            GROUP BY stupid_query.user_login)
            UNION
            SELECT user_login,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Approve')
              and b.sales_status ='Approve'
            and c.ticket_type='Risk Approval'
            and b.userid in('dhony.iswahyudi','parmawaty.lestari')
              and b.actiontime::date >='$tglawal'
             and b.actiontime::date <='$tglakhir'
            GROUP BY b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
            GROUP BY stupid_query.user_login
            ")or die(pg_last_error($nextg_conn));

       $Assessed = pg_query($nextg_conn, "
             select user_login , 0 as jumlah_ticket from(SELECT unnest(ARRAY['dhony.iswahyudi','parmawaty.lestari','queue']) as user_login)as a 
            where user_login not in(
                        SELECT user_login FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Assessed')
              and b.sales_status ='Assessed'
            and c.ticket_type='Risk Approval'
            and b.userid in('dhony.iswahyudi','parmawaty.lestari')
              and b.actiontime::date >='$tglawal'
             and b.actiontime::date <='$tglakhir'
            GROUP BY b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
            GROUP BY stupid_query.user_login)
            UNION
            SELECT user_login,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Assessed')
             and b.sales_status ='Assessed'
            and c.ticket_type='Risk Approval'
            and b.userid in('dhony.iswahyudi','parmawaty.lestari')
              and b.actiontime::date >='$tglawal'
             and b.actiontime::date <='$tglakhir'
            GROUP BY b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
            GROUP BY stupid_query.user_login
            ")or die(pg_last_error($nextg_conn));

       $Risk_Accepted = pg_query($nextg_conn, "
            select user_login , 0 as jumlah_ticket from(SELECT unnest(ARRAY['dhony.iswahyudi','parmawaty.lestari','queue']) as user_login)as a 
            where user_login not in(
                        SELECT user_login FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Risk Accepted')
             and b.sales_status ='Assessed'
            and c.ticket_type='Risk Approval'
            and b.userid in('dhony.iswahyudi','parmawaty.lestari')
              and b.actiontime::date >='$tglawal'
             and b.actiontime::date <='$tglakhir'
            GROUP BY b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
            GROUP BY stupid_query.user_login)
            UNION
            SELECT user_login,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Risk Accepted')
             and b.sales_status ='Assessed'
            and c.ticket_type='Risk Approval'
            and b.userid in('dhony.iswahyudi','parmawaty.lestari')
              and b.actiontime::date >='$tglawal'
             and b.actiontime::date <='$tglakhir'
            GROUP BY b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
            GROUP BY stupid_query.user_login
            ")or die(pg_last_error($nextg_conn));

        $Created = pg_query($nextg_conn, "
        select user_login , 0 as jumlah_ticket from(SELECT unnest(ARRAY['dhony.iswahyudi','parmawaty.lestari']) as user_login)as a 
            union
            select 'queue' as user_login , count(queue.userid) as jumlah_ticket  from (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) a.sales_number,a.revision_number, a.sales_status as sales_status_now,a.sales_status,c.ticket_number,'queue' as userid,c.ticket_type,b.actiontime
             from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
            where a.sales_status in('Created')
                        and a.processing_stage='40'
            and c.ticket_type='Risk Approval'
                        and substr(a.sales_number, 2 ,2)='15'
              and b.actiontime::date >='$tglawal'
             and b.actiontime::date <='$tglakhir') as queue")or die(pg_last_error($nextg_conn));


/*

        if (!$closed_successful OR !$open OR !$new OR !$unconfirmed_facultative OR !$assessment OR !$closed_unsuccessful ) {
            echo "An error occurred.\n";
            exit;
        }
*/
         $x = 0;
         while ($row = pg_fetch_assoc($Approve)) {
            $dataPoints1[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

         $x = 0;
         while ($row = pg_fetch_assoc($Assessed)) {
            $dataPoints2[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 

          $x = 0;
         while ($row = pg_fetch_assoc($Risk_Accepted)) {
            $dataPoints3[$x] = array( 
                'label'=>$row['user_login'] , 
                'y'=>$row['jumlah_ticket'],
                );
              $x ++; 
         } 
          $x = 0;
         while ($row = pg_fetch_assoc($Created)) {
            $dataPoints4[$x] = array( 
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
        text: "Chart Assess Policy Team <?php echo $team; ?>"
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
        title: "Total Assess Policy",
        suffix: " Ticket"
    },
    legend: {
        cursor: "pointer",
        itemclick: toggleDataSeries
    },
     data: [
        {
            type: "stackedColumn",
            name: "Approve",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "Assessed",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "Risk Accepted",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
        },{
            type: "stackedColumn",
            name: "Created",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
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
/*
setTimeout(function(){
   window.location.reload(1);
}, 60000); // 1menit
*/
</script>


<?php include '../footer.php'; ?>
