<?php
require('../next/connection_next.php');

$query_read = pg_query($next,"
	SELECT
	case when kondisi = 'bahaya' then 1
	when kondisi ='wanti-wanti' then 2
	when kondisi ='follow up sales' then 3
	when kondisi ='document' then 4
	when kondisi ='aman' then 5
	else 6 end as sort_kondisi,
      tn,title,new_create_time,queue,responsible_user,
						status,hitung_rev,param_dadakan,kondisi,
						--insurance_period_from,
 						a.sales_number||';'||a.revision_number AS sales_number, b.sales_status, 'konven' AS group,
						(CASE WHEN (b.sales_status='Created' OR b.sales_status='Endorsing' 
						OR b.sales_status='Renewal' OR b.sales_status='Revising') THEN 
							CASE WHEN processing_stage is null THEN 'Maker'
							WHEN processing_stage='' THEN 'Maker'
							WHEN processing_stage='20' THEN 'Checker'
							WHEN processing_stage='30' THEN 'Approver'
							WHEN processing_stage='40' THEN
								 CASE WHEN b.management_approval='t' THEN 'HO U/W' ELSE 'Branch U/W' END
							ELSE '---'
							 END
						WHEN b.sales_status='Assessed' THEN 'Reinsurance'
						ELSE ''
						END ) as stage

        FROM
            dblink (
                'host=10.11.12.84 user=postgres dbname=otrs2_4_201610',
                $$ 
			SELECT tn,title,new_create_time,queue,responsible_user,
			status,hitung_rev,param_dadakan,kondisi

 from (select 
case 
when status = 'new' And hitung_rev <= param_dadakan_wanti_wanti then 'bahaya'
when status = 'Pending Follow Up Sales' then 'follow up sales'
when status = 'Pending Document' then 'document'
when status = 'merged' then 'document'
when  hitung_rev >= param_dadakan AND  hitung_rev >= param_dadakan_wanti_wanti then 'aman'
when  hitung_rev <= param_dadakan AND  hitung_rev >= param_dadakan_wanti_wanti then 'aman'
when  hitung_rev <= param_dadakan_wanti_wanti AND  hitung_rev >= param_dadakan_bahaya then 'wanti-wanti'
when  hitung_rev <= param_dadakan_bahaya then 'bahaya'
ELSE 'aneh' end as kondisi,* 
from (
         select (param_dadakan - hours) + pemulih + pemulih_follow_up_sales as hitung_rev, param_dadakan - hours as hitung,*
                --elect 68.4-372+96+228 status sla
           from (
				select 
					case when new_create_time is null and create_time_z is null then 0 when new_create_time is null 
						then (SELECT count (*) FROM daging_tgl  where tgl >= (create_time_z::date)::text AND tgl <= (now()::date)::text)*24
						when days = 0 then (SELECT count (*) FROM daging_tgl  where tgl = (new_create_time::date)::text)*24
					else
					(SELECT count (*) FROM daging_tgl  where tgl >= (new_create_time::date)::text AND tgl <= (now()::date)::text)*24
					end as pemulih,
					get_age_follow_up_sales_b(ticket_id,new_create_time) as pemulih_follow_up_sales,
																	/*
					(select COALESCE(sum(hour),0) as hour from
					select *,FLOOR((EXTRACT(EPOCH FROM next)-EXTRACT(EPOCH FROM create_time))/3600) as hour
					from (select  id,state_id,create_time,
           lag(create_time) over (order by create_time asc) as prev,
           lead(create_time) over (order by create_time asc) as next
					from ticket_history where ticket_id=t2.ticket_id order by create_time asc) as x 
					where state_id=12 and next is not null)as x2 ) as pemulih_follow_up_sales,
*/
					case when queue='Sales::POS DIRECT::Pos BSD' then 222 else 68.4 end as param_dadakan,
					case when queue='Sales::POS DIRECT::Pos BSD' then 64 else 24 end as  param_dadakan_wanti_wanti,
					case when queue='Sales::POS DIRECT::Pos BSD' then 24 else 12 end as  param_dadakan_bahaya,* 
			from(
select case WHEN new_create_time is null and create_time_z is null 
			then FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-0)/3600)             
			WHEN new_create_time is null 
			then FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM create_time_z))/3600)
/*           when status='Pending Follow Up Sales' 
			 then(FLOOR((EXTRACT(EPOCH FROM (select create_time from ticket_history a
			 where state_id='12' and a.ticket_id=t1.ticket_id order by create_time desc limit 1)
.2 * interval '1 hour')-EXTRACT(EPOCH FROM new_create_time))/3600))*/
else FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM new_create_time))/3600) end as hours, 
		case WHEN new_create_time is null and create_time_z is null then 
		FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-0)/3600)/24) 
		WHEN new_create_time is null then 
				FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM create_time_z))/3600)/24) 
		else FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM new_create_time))/3600)/24) 
											end as days,
			EXTRACT(EPOCH FROM now()) as nowe,EXTRACT(EPOCH FROM now())-EXTRACT(EPOCH FROM new_create_time) as raw,*                              
                                from (
			SELECT DISTINCT on (a.id)  a.id,z.create_time as create_time_z,a.create_time as create_time_a,
                     CASE
            WHEN A .ticket_status = 'new' THEN
                (
                    SELECT z.create_time
                    FROM ticket_history z
                    WHERE z.ticket_id = A . ID
                    AND z.history_type_id = '16' --move
                    AND state_id = A .ticket_state_id
                    ORDER BY z.create_time DESC
                    LIMIT 1
                )
            WHEN A .ticket_status = 'open' THEN
                (
                    SELECT z.create_time
                    FROM ticket_history z
                    WHERE z.ticket_id = A . ID
                    AND state_id = A .ticket_state_id
                    ORDER BY z.create_time DESC
                    LIMIT 1
                )
            WHEN A .ticket_status in('Pending Document','merged') THEN null
            WHEN A .ticket_status in ( 'Assessment UW/RI','On Progress','Posted','Pending Follow Up Sales','Follow Up Maker') THEN
                    case when (SELECT count(*) from ticket_history WHERE ticket_id =a.id and state_id='21')!=0 THEN
                        (   select ini from (
                            SELECT *, lead(z.create_time) over (order by z.create_time asc) as ini
                            FROM ticket_history z
                            WHERE z.ticket_id = A . ID
                            --AND state_id = '21' 
                            ORDER BY z.create_time asc)y where state_id='21' ORDER BY ini desc
                            LIMIT 1
                        )
                    else A .create_time end
        END AS new_create_time,*
    FROM
        (
            SELECT
                A .create_time, A . ID, A .ticket_state_id, C . NAME AS ticket_status, A .tn, A .title,
                (SELECT DISTINCT LOGIN FROM users WHERE ID = A .responsible_user_id) AS responsible_user,
                b. NAME AS queue, C . NAME AS status
            FROM ticket A
            LEFT JOIN queue b ON b. ID = A .queue_id
            LEFT JOIN ticket_state C ON C . ID = A .ticket_state_id
            LEFT join users as d on d.id=a.user_id
            LEFT JOIN teams as f on f.user_login=d.login
            WHERE 
                a.create_time::date >='2019-01-01'
                --and a.create_time::date <='2020-10-22' --and a.id ='552574'--'552088'--'551290'--in ('549502','549503')
                --and f.team_id in ('1','2','3') and f.status_user=1 and f.level_user=1       
                AND C . NAME NOT IN ('closed successful', 'merged') 
                AND b. NAME IN  ('Sales::POS DIRECT::Pos JKP',
                                'Sales::POS DIRECT::Pos Kediri',
                                'Sales::POS DIRECT::Pos Cirebon',
                                'Sales::POS DIRECT::Pos Bandung',
                                'Sales::POS DIRECT::Pos Jambi',
                                'Sales::POS DIRECT::Pos BSD',
                                'Sales::POS DIRECT::Pos Makassar',
                                'Sales::POS DIRECT::Pos Malang',
                                'Sales::POS DIRECT::Pos Solo',
                                'Sales::POS DIRECT::Pos Batam',
                                'Sales::POS DIRECT::Pos Medan',
                                'Sales::POS DIRECT::Pos Jember',
                                'Sales::POS DIRECT::Pos Purwokerto',
                                'Sales::POS DIRECT::Pos Pontianak',
                                'Sales::POS DIRECT::Pos Lampung',
                                'Sales::POS DIRECT::pos.samarinda',
                                'Sales::POS DIRECT::Pos Denpasar',
                                'Sales::POS DIRECT::Pos Semarang',
                                'Sales::POS DIRECT::Pos Manado',
                                'Sales::POS DIRECT::Pos Yogyakarta',
                                'Sales::POS DIRECT::Pos Surabaya',
                                'Sales::POS DIRECT::Pos Palembang',
                                'Sales::POS DIRECT::Pos Balikpapan',
                                'Sales::POS DIRECT::HO KONVEN',
                                'Sales::POS DIRECT::Pos Pekanbaru',
                                'Sales::POS DIRECT::Pos Health',
                                'Sales::POS DIRECT::Pos DNC',
                                'TMO'
)
                AND A.tn NOT IN (
                    '880295919',
                    '880299111',
                    '880345340',
                    '880345581',
                    '880345709',
                    '880345710',
                    '880346755',
                    '880346784',
                    '880346786',
                    '880346963',
                    '880346969',
                    '880347268',
                    '880349390',
                    '880351271',
                    '880351589',
                    '880352274',
                    '880353054',
                    '880353734',
                    '880354348',
                    '880354857',
                    '880355068',
                    '880355449',
                    '880356948',
                    '880357556',
                    '880358649',
                    '880358818',
                    '880444574',
                    '880384757'
                )
        ) AS A

LEFT JOIN ticket_history z
            on z.ticket_id = a.id
            AND z.state_id = a.ticket_state_id
            ORDER BY a.id ASC,z.create_time DESC ) as t1 )as t2 )as t3)as t4 )as t5;
$$
            ) AS x (
                tn VARCHAR, title TEXT,new_create_time TIMESTAMP,queue TEXT,responsible_user VARCHAR,
								status VARCHAR,hitung_rev numeric,param_dadakan numeric,kondisi VARCHAR
            )
LEFT join (select DISTINCT ON (ticket_number) * from 	tbl_helpdesk_integration) as a on x.tn=a.ticket_number and date_part('year', waktu_kejadian) >='2019'
left join  tbl_so_sales_details as b ON b.sales_number = a.sales_number AND 
b.revision_number = a.revision_number 
and b.sales_status NOT IN (
			'Cancel',
			'Cancelled',
			'Drooped',
			'Drop',
			'Droped',
			'dropped',
			'Dropped',
			'Master JP',
			'Reject',
			'Rejected'
			) order by sort_kondisi,hitung_rev asc
") or die(pg_last_error($next));

$x=0;

?>
<html>
	<head>
	</head>
	<body>
		<table border=2>
			<tbody>
			<tr>
				<td>Ticket Number</td>
				<td>Title</td>
				<td>Create Time</td>
				<td>Queue</td>
				<td>Responsible By</td>
				<td>Ticket Status</td>
				<td>Remaining Time (In Hours)</td>
				<td>Target SLA (In Hours)</td>
				<td>SLA Status</td>
				<td>No Polis</td>
				<td>Polis Status</td>
				<td>Stage</td>
			</tr>
			<?php
				while ($obj_read = pg_fetch_assoc($query_read)){
					echo '<tr>';
					echo '<td>'.$obj_read['tn'].'</td>';
					echo '<td>'.$obj_read['title'].'</td>';
					echo '<td>'.$obj_read['new_create_time'].'</td>';
					echo '<td>'.$obj_read['queue'].'</td>';
					echo '<td>'.$obj_read['responsible_user'].'</td>';
					echo '<td>'.$obj_read['status'].'</td>';
					echo '<td>'.$obj_read['hitung_rev'].'</td>';
					echo '<td>'.$obj_read['param_dadakan'].'</td>';
					if($obj_read['kondisi']=='document'){
					echo '<td bgcolor="#bd3853">'.$obj_read['kondisi'].'</td>';
					}elseif($obj_read['kondisi']=='aman'){
					echo '<td bgcolor="#38a445">'.$obj_read['kondisi'].'</td>';
					}elseif($obj_read['kondisi']=='wanti-wanti'){
					echo '<td bgcolor="#fff85b">'.$obj_read['kondisi'].'</td>';
					}elseif($obj_read['kondisi']=='bahaya'){
					echo '<td bgcolor="#e73f3f">'.$obj_read['kondisi'].'</td>';
					}elseif($obj_read['kondisi']=='follow up sales'){
					echo '<td bgcolor="#8a2be2">'.$obj_read['kondisi'].'</td>';
					}else{
					echo '<td>'.$obj_read['kondisi'].'</td>';
					}
					echo '<td>'.$obj_read['sales_number'].'</td>';
					echo '<td>'.$obj_read['sales_status'].'</td>';
					echo '<td>'.$obj_read['stage'].'</td>';
					echo '</tr>';

					}
				?>
			</tbody>
			</table>
</body>
</html>