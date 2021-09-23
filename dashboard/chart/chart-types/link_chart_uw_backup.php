<?php include '../header_link_uw.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../nextg_koneksi.php'; ?>

<h1>LINK CHART OTRS DAN ASSESS UW</h1>
<a href="<?php echo BaseURL().'bar_chart_uw.php?team=1&tglawal='.$tglawal.'&tglakhir='.$tglakhir.'&status=no';?>" class="next">Team 1</a>
<a href="<?php echo BaseURL().'bar_chart_uw.php?team=2&tglawal='.$tglawal.'&tglakhir='.$tglakhir.'&status=no';?>" class="next">Team 2</a>
<a href="<?php echo BaseURL().'bar_chart_uw_team3_2.php?team=3&tglawal='.$tglawal.'&tglakhir='.$tglakhir.'&status=no';?>" class="next">Team 3</a>
<a href="<?php echo BaseURL().'bar_chart_uw.php?team=4&tglawal='.$tglawal.'&tglakhir='.$tglakhir.'&status=no';?>" class="next">Team 4</a>
<hr />
<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<?php if($team==2){?>
<a href="<?php echo BaseURL() .'bar_chart_uw_team2_2.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>" class="next">Chart Policy Status</a>
<?php }?>

<div class="row">
  <div class="column" >
    <div id="chartContainer"></div>
  </div>
  <div class="column" >
  <div id="chartContainer2"></div>
  </div>
</div>
<?php
ini_set('error_reporting',E_ALL);

 $que_otrs = pg_query($conn, "
select d.name, count (user_login) AS jumlah_tiket
,round((count (user_login)/(
select count(d.name) as total
from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
1 as status_user,'uw' as department from users as a 
join personal_queues as b on a.id=b.user_id
join queue as c on c.id=b.queue_id
where c.id in(159,160,161,162) and b.user_id not in(237,86)) as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where  a.status_user=1 
and c.create_time::date >='$tglawal'
and c.create_time::date <='$tglakhir'
--and queue_id in(159,160,161,162)
and a.level_user=1 and d.id in('1','2','4','3','14','20'))::NUMERIC *100),2)
as percentage  
from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
1 as status_user,'uw' as department from users as a 
join personal_queues as b on a.id=b.user_id
join queue as c on c.id=b.queue_id
where c.id in(159,160,161,162) and b.user_id not in(237,86)) as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where  a.status_user=1 
and c.create_time::date >='$tglawal'
and c.create_time::date <='$tglakhir'
--and queue_id in(159,160,161,162)
and a.level_user=1 and d.id in('1','2','4','3','14','20')
group by d.name
")or die(pg_last_error($conn));

/*
$que_assess = pg_query($nextg_conn, "
select name,jumlah_ticket,round((jumlah_ticket/(
select sum(bca.jumlah_ticket) as total_ticket from(
            SELECT 'Approve' as name,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Approve')
              and b.sales_status ='Approve'
            and c.ticket_type='Risk Approval'
            and b.userid in('dhony.iswahyudi','parmawaty.lestari','dwi.prasetyo','trivina.setyawati','rini.aryani','lisbet')
             and b.actiontime::date >='$tglawal'
            and b.actiontime::date <='$tglakhir'
            GROUP BY b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
						union
            SELECT stupid_query.sales_status as name,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,a.sales_status,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Assessed','Risk Accepted')
             and b.sales_status in('Assessed')
            and c.ticket_type='Risk Approval'
             and b.userid in('dhony.iswahyudi','parmawaty.lestari','dwi.prasetyo','trivina.setyawati','rini.aryani','lisbet')
             and b.actiontime::date >='$tglawal'
            and b.actiontime::date <='$tglakhir'
            GROUP BY a.sales_status,b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
            GROUP BY stupid_query.sales_status
) as bca) *100),2
) as percentage
 from(
            SELECT 'Approve' as name,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Approve')
              and b.sales_status ='Approve'
            and c.ticket_type='Risk Approval'
            and b.userid in('dhony.iswahyudi','parmawaty.lestari','dwi.prasetyo','trivina.setyawati','rini.aryani','lisbet')
             and b.actiontime::date >='$tglawal'
            and b.actiontime::date <='$tglakhir'
            GROUP BY b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
						union
            SELECT stupid_query.sales_status as name,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,a.sales_status,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Assessed','Risk Accepted')
             and b.sales_status in('Assessed')
            and c.ticket_type='Risk Approval'
             and b.userid in('dhony.iswahyudi','parmawaty.lestari','dwi.prasetyo','trivina.setyawati','rini.aryani','lisbet')
             and b.actiontime::date >='$tglawal'
            and b.actiontime::date <='$tglakhir'
            GROUP BY a.sales_status,b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
            GROUP BY stupid_query.sales_status) as abc
						GROUP BY abc.name,abc.jumlah_ticket
")or die(pg_last_error($nextg_conn));


*/
$que_assess2 = pg_query($nextg_conn, "
select name,jumlah_ticket,round((jumlah_ticket/(
select sum(bca.jumlah_ticket) as total_ticket from(
						select 'Queue' as name , count(queue.userid) as jumlah_ticket  from (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) a.sales_number,a.revision_number, a.sales_status as sales_status_now,a.sales_status,c.ticket_number,'queue' as userid,c.ticket_type,b.actiontime
             from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
            where a.sales_status in('Created')
                        and a.processing_stage='40'
            and c.ticket_type='Risk Approval'
                 and b.actiontime::date >='$tglawal'
            and b.actiontime::date <='$tglakhir') as queue
						union	
            SELECT 'Approve' as name,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Approve')
              and b.sales_status ='Approve'
            and c.ticket_type='Risk Approval'
            and b.userid in('dhony.iswahyudi','parmawaty.lestari','dwi.prasetyo','trivina.setyawati','rini.aryani','lisbet')
              and b.actiontime::date >='$tglawal'
            and b.actiontime::date <='$tglakhir'
            GROUP BY b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
						union
            SELECT stupid_query.sales_status as name,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,a.sales_status,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Assessed','Risk Accepted')
             and b.sales_status in('Assessed')
            and c.ticket_type='Risk Approval'
             and b.userid in('dhony.iswahyudi','parmawaty.lestari','dwi.prasetyo','trivina.setyawati','rini.aryani','lisbet')
            and b.actiontime::date >='$tglawal'
            and b.actiontime::date <='$tglakhir'
            GROUP BY a.sales_status,b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
            GROUP BY stupid_query.sales_status
) as bca) *100),2
) as percentage
 from(			
						
            select 'Queue' as name , count(queue.userid) as jumlah_ticket  from (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) a.sales_number,a.revision_number, a.sales_status as sales_status_now,a.sales_status,c.ticket_number,'queue' as userid,c.ticket_type,b.actiontime
             from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
            where a.sales_status in('Created')
                        and a.processing_stage='40'
            and c.ticket_type='Risk Approval'
                 and b.actiontime::date >='$tglawal'
            and b.actiontime::date <='$tglakhir') as queue
						union
            SELECT 'Approve' as name,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Approve')
              and b.sales_status ='Approve'
            and c.ticket_type='Risk Approval'
            and b.userid in('dhony.iswahyudi','parmawaty.lestari','dwi.prasetyo','trivina.setyawati','rini.aryani','lisbet')
            and b.actiontime::date >='$tglawal'
            and b.actiontime::date <='$tglakhir'
            GROUP BY b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
						union
            SELECT stupid_query.sales_status as name,count(*) as jumlah_ticket FROM (
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) b.userid as user_login,a.sales_status,concat(a.sales_number,';',a.revision_number) as policy_number from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
             where a.sales_status in('Assessed','Risk Accepted')
             and b.sales_status in('Assessed')
            and c.ticket_type='Risk Approval'
             and b.userid in('dhony.iswahyudi','parmawaty.lestari','dwi.prasetyo','trivina.setyawati','rini.aryani','lisbet')
           and b.actiontime::date >='$tglawal'
            and b.actiontime::date <='$tglakhir'
            GROUP BY a.sales_status,b.userid, concat(a.sales_number,';',a.revision_number))as stupid_query
            GROUP BY stupid_query.sales_status) as abc
						GROUP BY abc.name,abc.jumlah_ticket	")or die(pg_last_error($nextg_conn));

  $x = 0;
 while ($row = pg_fetch_assoc($que_otrs)) {
    $dataPoints[$x] = array( 
        'label'=>$row['name'].' -- ['.$row['jumlah_tiket'].' Ticket] --' , 
        'y'=>$row['percentage'],
        );
      $x ++; 
 } 

   $xyz = 0;
 while ($row = pg_fetch_assoc($que_assess2)) {
    $dataPoints2[$xyz] = array( 
        'label'=>$row['name'].' -- ['.$row['jumlah_ticket'].' Ticket] --' , 
        'y'=>$row['percentage'],
        );
      $xyz ++; 
 } 
 

?>
<script>
window.onload = function() {
 var chart2 = new CanvasJS.Chart("chartContainer2", {
    animationEnabled: true,
    title: {
        text: "SUMMARY UNDERWRITING ASSESS POLICY"
    },
    subtitles: [{
        text: "<?php echo $tglawal.' --- '.$tglakhir;?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
    }]
});
 
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    title: {
        text: "SUMMARY UNDERWRITING OTRS TICKET"
    },
    subtitles: [{
        text: "<?php echo $tglawal.' --- '.$tglakhir;?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
chart2.render();
 
}
</script>