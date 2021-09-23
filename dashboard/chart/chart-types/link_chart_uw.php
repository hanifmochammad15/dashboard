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
select --responsible_user as closed_by,
ticket_status as name,count(distinct tn) jumlah_tiket, round((count(distinct tn) /
(select --responsible_user as closed_by,
count(distinct tn) jumlah_ticket
--,count(*) as feed
from (
                SELECT
                                a.id AS ticket_id, a.tn, a.title,
                  (SELECT DISTINCT login FROM users WHERE id = a.responsible_user_id) as responsible_user,
                                substr(substr(title, position('B-' in a.title) ,4), 3 ,2) as cab,
                                --substr(title, position('B-' in a.title) ,4) as cab,
                                --a.user_id,a.responsible_user_id,
                                (SELECT DISTINCT login FROM users WHERE id = a.user_id) AS user_id,
                                a.customer_user_id, a.create_time, a.change_time,
                                (SELECT DISTINCT login FROM users WHERE id = a.change_by) AS closed_by,
                                (select distinct name from ticket_state where id = a.ticket_state_id) as ticket_status,
                                b.id AS article_id, b.a_from, b.a_reply_to, b.a_to, b.a_cc, b.a_subject, b.a_body, b.create_time AS create_article_time,
                                c.name AS history, d.name AS history_type, e.name AS queue
                FROM
                                ticket AS a

                                LEFT JOIN article b ON b.ticket_id = a.id
                                LEFT JOIN ticket_history c ON c.ticket_id = a.id AND c.article_id = b.id
                                LEFT JOIN ticket_history_type d ON d.id = c.history_type_id
                                LEFT JOIN queue e ON e.id = a.queue_id and e.group_id = '4'
                WHERE
                                
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id in(159,160,161,162) and b.user_id not in(237,86))
                        and a.ticket_state_id in(1,2,4,3,14,20,18)
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
)   as total_ticket
)::NUMERIC*100),2) as percentage
from (
                SELECT
                                a.id AS ticket_id, a.tn, a.title,
                  (SELECT DISTINCT login FROM users WHERE id = a.responsible_user_id) as responsible_user,
                                substr(substr(title, position('B-' in a.title) ,4), 3 ,2) as cab,
                                --substr(title, position('B-' in a.title) ,4) as cab,
                                --a.user_id,a.responsible_user_id,
                                (SELECT DISTINCT login FROM users WHERE id = a.user_id) AS user_id,
                                a.customer_user_id, a.create_time, a.change_time,
                                (SELECT DISTINCT login FROM users WHERE id = a.change_by) AS closed_by,
                                (select distinct name from ticket_state where id = a.ticket_state_id) as ticket_status,
                                b.id AS article_id, b.a_from, b.a_reply_to, b.a_to, b.a_cc, b.a_subject, b.a_body, b.create_time AS create_article_time,
                                c.name AS history, d.name AS history_type, e.name AS queue
                FROM
                                ticket AS a

                                LEFT JOIN article b ON b.ticket_id = a.id
                                LEFT JOIN ticket_history c ON c.ticket_id = a.id AND c.article_id = b.id
                                LEFT JOIN ticket_history_type d ON d.id = c.history_type_id
                                LEFT JOIN queue e ON e.id = a.queue_id and e.group_id = '4'
                WHERE
                                 a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id in(159,160,161,162) and b.user_id not in(237,86))
                        and a.ticket_state_id in(1,2,4,3,14,20,18)
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
) as a
                --where coalesce(queue,'') <> ''
                group by --responsible_user,
ticket_status
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