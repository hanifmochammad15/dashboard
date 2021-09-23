
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
                where a.user_login not in(select 
        --responsible_user as closed_by,
        responsible_user as user_login
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id='$queue' and b.user_id not in(237,86))
                                                                and a.ticket_state_id=2
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                                where coalesce(queue,'') <> ''
                                group by responsible_user,ticket_status)
                union
                select 
                --responsible_user as closed_by,
                responsible_user as user_login,
                --ticket_status,
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id=$queue and b.user_id not in(237,86))
                                                                and a.ticket_state_id=2
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                where coalesce(queue,'') <> ''
                group by responsible_user,ticket_status")or die(pg_last_error($conn));

        $open = pg_query($conn, "select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select 
        --responsible_user as closed_by,
        responsible_user as user_login
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id='$queue' and b.user_id not in(237,86))
                                                                and a.ticket_state_id=4
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                                where coalesce(queue,'') <> ''
                                group by responsible_user,ticket_status)
                union
                select 
                --responsible_user as closed_by,
                responsible_user as user_login,
                --ticket_status,
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id=$queue and b.user_id not in(237,86))
                                                                and a.ticket_state_id=4
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                where coalesce(queue,'') <> ''
                group by responsible_user,ticket_status")or die(pg_last_error($conn));

        $closed_unsuccessful = pg_query($conn, "
          select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select 
        --responsible_user as closed_by,
        responsible_user as user_login
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id='$queue' and b.user_id not in(237,86))
                                                                and a.ticket_state_id=3
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                                where coalesce(queue,'') <> ''
                                group by responsible_user,ticket_status)
                union
                select 
                --responsible_user as closed_by,
                responsible_user as user_login,
                --ticket_status,
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id=$queue and b.user_id not in(237,86))
                                                                and a.ticket_state_id=3
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                where coalesce(queue,'') <> ''
                group by responsible_user,ticket_status")or die(pg_last_error($conn));

        $assessment = pg_query($conn, "
          select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select 
        --responsible_user as closed_by,
        responsible_user as user_login
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id='$queue' and b.user_id not in(237,86))
                                                                and a.ticket_state_id=14
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                                where coalesce(queue,'') <> ''
                                group by responsible_user,ticket_status)
                union
                select 
                --responsible_user as closed_by,
                responsible_user as user_login,
                --ticket_status,
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id=$queue and b.user_id not in(237,86))
                                                                and a.ticket_state_id=14
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                where coalesce(queue,'') <> ''
                group by responsible_user,ticket_status")or die(pg_last_error($conn));

        $unconfirmed_facultative = pg_query($conn, "
          select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select 
        --responsible_user as closed_by,
        responsible_user as user_login
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id='$queue' and b.user_id not in(237,86))
                                                                and a.ticket_state_id=20
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                                where coalesce(queue,'') <> ''
                                group by responsible_user,ticket_status)
                union
                select 
                --responsible_user as closed_by,
                responsible_user as user_login,
                --ticket_status,
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id=$queue and b.user_id not in(237,86))
                                                                and a.ticket_state_id=20
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                where coalesce(queue,'') <> ''
                group by responsible_user,ticket_status")or die(pg_last_error($conn));

        $new = pg_query($conn, "
         select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select 
        --responsible_user as closed_by,
        responsible_user as user_login
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id='$queue' and b.user_id not in(237,86))
                                                                and a.ticket_state_id=1
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                                where coalesce(queue,'') <> ''
                                group by responsible_user,ticket_status)
                union
                select 
                --responsible_user as closed_by,
                responsible_user as user_login,
                --ticket_status,
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id=$queue and b.user_id not in(237,86))
                                                                and a.ticket_state_id=1
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                where coalesce(queue,'') <> ''
                group by responsible_user,ticket_status")or die(pg_last_error($conn));

$request_facultative = pg_query($conn, "
         select a.user_login, 0 as jumlah_ticket 
        from (select a.id,a.login as user_login,1 as level_user, c.id as team_id,
                            1 as status_user,'uw' as department from users as a 
                            join personal_queues as b on a.id=b.user_id
                            join queue as c on c.id=b.queue_id
                            where c.id=$queue and b.user_id not in(237,86)) as a
                where a.user_login not in(select 
        --responsible_user as closed_by,
        responsible_user as user_login
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id='$queue' and b.user_id not in(237,86))
                                                                and a.ticket_state_id=18
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                                where coalesce(queue,'') <> ''
                                group by responsible_user,ticket_status)
                union
                select 
                --responsible_user as closed_by,
                responsible_user as user_login,
                --ticket_status,
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
                                --date_part('year',a.create_time)=date_part('year',CURRENT_DATE) and
                                --(date_part('month',a.create_time) between date_part('month',CURRENT_DATE)-1 and
                                --date_part('month',CURRENT_DATE))
                                a.create_time::date >='$tglawal'
                                and a.create_time::date <='$tglakhir'
                                and d.name <> 'SendAutoReply'
                                and a.ticket_state_id not in ('1','14')
                                                                and a.responsible_user_id in(select a.id from users as a 
                                join personal_queues as b on a.id=b.user_id
                                join queue as c on c.id=b.queue_id
                                where c.id=$queue and b.user_id not in(237,86))
                                                                and a.ticket_state_id=18
                                --and (select distinct name from ticket_state where id = a.ticket_state_id)='new'
                ORDER BY  b.create_time
                ) as a
                where coalesce(queue,'') <> ''
                group by responsible_user,ticket_status")or die(pg_last_error($conn));

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

         $x = 0;
         while ($row = pg_fetch_assoc($request_facultative)) {
            $dataPoints7[$x] = array( 
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
        },{
            type: "stackedColumn",
            name: "Request Facultative",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: <?php echo json_encode($dataPoints7, JSON_NUMERIC_CHECK); ?>
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
