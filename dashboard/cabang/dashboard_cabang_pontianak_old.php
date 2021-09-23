<?php

#region setup
ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 'Off');
require('../connection.php');
require('../next/connection_next.php');
require('../next/connection_next_sharia.php');
$today = date("Y-m-d H:i:s");
$x = 0;
/* $kondisi[0] = 84; //sla 3,5 hari
$kondisi[1] = 24; // 1 hari
$kondisi[2] = 12; // merah
$kondisi['bsd'] = 276; //sla 11,5
$kondisi['bsd_wanti_wanti'] = 64;
$kondisi['bsd_bahaya'] = 24; */

#update rL 7Feb20
//Non BSD//
$kondisi[0] = 68.4; //sla 2,85 hari
$kondisi[1] = 24; // 1 hari
$kondisi[2] = 12; // merah
//BSD//
$kondisi['bsd'] = 222; //sla 9,5 hari
$kondisi['bsd_wanti_wanti'] = 64;
$kondisi['bsd_bahaya'] = 24;
#update rL 7Feb20

#endregion setup

#region html head
$html_head = <<<AZTECA
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
AZTECA;
#endregion html head

$html_body = "";
$html_body_red = "";
$html_body_pink = "";
$html_body_green = "";
$html_body_yellow= "";
$html_body_hitam = "";

#region html tail
$html_tail = <<<AZTECA
			</tbody>
		</table>
	</body>
</html>
AZTECA;

#endregion html tail

#region query
$query_read = pg_query($conn,"
	SELECT
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
			WHEN A .ticket_status in('Pending Follow Up Sales','Pending Document','merged') THEN NULL
			WHEN A .ticket_status in ( 'Assessment UW/RI','On Progress','Posted') THEN
					case when (SELECT count(*) from ticket_history WHERE ticket_id =a.id and state_id='4')!=0 THEN
						(
							SELECT z.create_time
							FROM ticket_history z
							WHERE z.ticket_id = A . ID
							AND state_id = '4' --open
							ORDER BY z.create_time DESC
							LIMIT 1
						)
					else A .create_time
					end
			ELSE A .create_time
		END AS new_create_time,
		*
	FROM
		(
			SELECT
				A .create_time, A . ID, A .ticket_state_id, C . NAME AS ticket_status, A .tn, A .title,
				(SELECT DISTINCT LOGIN FROM users WHERE ID = A .responsible_user_id) AS responsible_user,
				b. NAME AS queue, C . NAME AS status
			FROM ticket A
			LEFT JOIN queue b ON b. ID = A .queue_id
			LEFT JOIN ticket_state C ON C . ID = A .ticket_state_id
			WHERE
				date_part('year', A .create_time) >= '2019'
				AND C . NAME NOT IN ('closed successful', 'merged')
				AND b. NAME = 'Sales::POS DIRECT::Pos Pontianak'
				AND A .tn NOT IN (
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
					'880444574'
				)
		) AS A
	ORDER BY 1 ASC 
") or die(pg_last_error($conn));
#endregion query

while ($obj_read = pg_fetch_assoc($query_read)){
	$ticket[$x] = $obj_read;
	
	$query_ticket_polis = pg_query($next,"
		SELECT 
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
			tbl_helpdesk_integration a 
		LEFT JOIN 
			tbl_so_sales_details b 
		ON 
			b.sales_number = a.sales_number 
		AND 
			b.revision_number = a.revision_number
		WHERE 
			ticket_number = '{$ticket[$x]['tn']}' 
									and waktu_kejadian is not null  

		AND 
			b.sales_status NOT IN (
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
			)
					ORDER BY waktu_kejadian desc

		LIMIT 1
	") or die(pg_last_error($next));
	$list_polis[$ticket[$x]['tn']] = pg_fetch_assoc($query_ticket_polis);
	if (empty($list_polis[$ticket[$x]['tn']])) {
		
		$query_ticket_polis_sharia = pg_query($next_sharia,"
			SELECT 
				a.sales_number||';'||a.revision_number AS sales_number, b.sales_status, 'sharia' AS group,
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
				tbl_helpdesk_integration a 
			LEFT JOIN 
				tbl_so_sales_details b 
			ON 
				b.sales_number = a.sales_number 
			AND 
				b.revision_number = a.revision_number
			WHERE 
				ticket_number = '{$ticket[$x]['tn']}' 
			AND 
				b.sales_status NOT IN (
				'Cancel',
				'Cancelled',
				'Drooped',
				'Drop',
				'Droped',
				'dropped',
				'Dropped',
				'Invoiced',
				'Master JP',
				'paidfully',
				'paid fully',
				'Paid fully',
				'Paid fully',
				'Paid Fully',
				'Paid partially',
				'Reject',
				'Rejected'
				)
			LIMIT 1
		") or die(pg_last_error($next_sharia));
		$list_polis[$ticket[$x]['tn']] = pg_fetch_assoc($query_ticket_polis_sharia);
		if (empty($list_polis[$ticket[$x]['tn']])) {
			$ticket[$x]['polis'] = '';
			$ticket[$x]['polis_status'] = '';
			$ticket[$x]['junk'] = '';
		}
		else {
			$ticket[$x]['polis'] = $list_polis[$ticket[$x]['tn']]['sales_number'];
			$ticket[$x]['polis_status'] = $list_polis[$ticket[$x]['tn']]['sales_status'];
			$ticket[$x]['junk'] = $list_polis[$ticket[$x]['tn']];				
		}

	}
	else {
		$ticket[$x]['polis'] = $list_polis[$ticket[$x]['tn']]['sales_number'];
		$ticket[$x]['polis_status'] = $list_polis[$ticket[$x]['tn']]['sales_status'];	
		$ticket[$x]['junk'] = $list_polis[$ticket[$x]['tn']];	
		$ticket[$x]['stage'] = $list_polis[$ticket[$x]['tn']]['stage'];
	}
	
	if($ticket[$x]['new_create_time'] == '') {
		$query_pemeriksa = pg_query($conn,"			
			SELECT z.create_time
			FROM ticket_history z
			WHERE z.ticket_id = '{$ticket[$x]['id']}'
			AND state_id = '{$ticket[$x]['ticket_state_id']}'
			ORDER BY z.create_time DESC
			LIMIT 1
		") or die(pg_last_error($conn));
		while ($obj_pemeriksa = pg_fetch_assoc($query_pemeriksa)){
			$waktu_pemeriksa[$ticket[$x]['id']] = $obj_pemeriksa['create_time'];
		}
		if($waktu_pemeriksa[$ticket[$x]['id']] == '') {$ticket[$x]['new_create_time'] = 0;}
		else {$ticket[$x]['new_create_time'] = $waktu_pemeriksa[$ticket[$x]['id']];}
	}
	$ticket[$x]['now'] = $today;
	$ticket[$x]['diff']['raw'] = strtotime($ticket[$x]['now']) - strtotime($ticket[$x]['new_create_time']);
	$ticket[$x]['diff']['days'] = floor(($ticket[$x]['diff']['raw']/3600)/24);
	$ticket[$x]['pemulih'] = 0;
	
	if($ticket[$x]['diff']['days'] == 0) {
		$tgl_periksa = substr($ticket[$x]['new_create_time'], 0, 10);
		$query_libur = pg_query($conn,"
			SELECT * FROM daging_tgl WHERE tgl = '{$tgl_periksa}'
		") or die(pg_last_error($conn));
		$ticket[$x]['libur'][1] = pg_fetch_assoc($query_libur);
		if(!empty($ticket[$x]['libur'][1])) {$ticket[$x]['pemulih'] = 24;}
	}
	else {
		
		for($a=0; $a<=$ticket[$x]['diff']['days']; $a++){ 
			$ticket[$x]['junk_tgl'][$a] = 
				date('Y-m-d H:i:s', strtotime($ticket[$x]['new_create_time'] . ' +'.$a.' day'));
			$tgl_periksa = substr($ticket[$x]['junk_tgl'][$a], 0, 10);
			$query_libur = pg_query($conn,"
				SELECT * FROM daging_tgl WHERE tgl = '{$tgl_periksa}'
			") or die(pg_last_error($conn));
			$ticket[$x]['libur'][$a] = pg_fetch_assoc($query_libur);
			if(!empty($ticket[$x]['libur'][$a])) {$ticket[$x]['pemulih'] = $ticket[$x]['pemulih'] + 24;}
		}
	}
	
	/*if ($ticket[$x]['polis'] == '') {$param_dadakan = $kondisi[0];}
	else if (substr($ticket[$x]['polis'],0,3) == 'P15' OR substr($ticket[$x]['polis'],0,3) == 'Q15') {
		$param_dadakan = $kondisi['bsd'];
	}
	else {$param_dadakan = $kondisi[0];}*/
	
	if ($ticket[$x]['queue'] == 'Sales::POS DIRECT::Pos BSD') {
		$param_dadakan = $kondisi['bsd'];
		$param_dadakan_wanti_wanti = $kondisi['bsd_wanti_wanti'];
		$param_dadakan_bahaya = $kondisi['bsd_bahaya'];
	}
	else {
		$param_dadakan = $kondisi[0];
		$param_dadakan_wanti_wanti = $kondisi[1];
		$param_dadakan_bahaya = $kondisi[2];
	}
	
	$ticket[$x]['debug'] = 'waktunya = '.$param_dadakan;
	//echo "<PRE>".substr($ticket[$x]['polis'],0,3)." - ".$ticket[$x]['debug'];
	
	$ticket[$x]['diff']['hours'] = floor($ticket[$x]['diff']['raw']/3600);
	$ticket[$x]['diff']['minutes'] = floor($ticket[$x]['diff']['raw']/60);
	$ticket[$x]['diff']['hitung'] = $param_dadakan - $ticket[$x]['diff']['hours'];
	$ticket[$x]['diff']['hitung_rev'] = $ticket[$x]['diff']['hitung'] + $ticket[$x]['pemulih'];
	
	//patch cepet sementara
	$ticket[$x]['diff']['hitung_old'] = $ticket[$x]['diff']['hitung'];
	$ticket[$x]['diff']['hitung'] = $ticket[$x]['diff']['hitung_rev'];
	
	if($ticket[$x]['status'] == 'new' && $ticket[$x]['diff']['hitung'] <= $param_dadakan_wanti_wanti) { //red
		$ticket[$x]['kondisi'] = 'bahaya';
		$ticket[$x]['warna'] = '#e73f3f'; //red
		$junk_red = <<<AZTECA
			<tr>
				<td >{$ticket[$x]['tn']}</td>
				<td>{$ticket[$x]['title']}</td>
				<td>{$ticket[$x]['new_create_time']}</td>
				<td>{$ticket[$x]['queue']}</td>
				<td>{$ticket[$x]['responsible_user']}</td>
				<td>{$ticket[$x]['status']}</td>
				<td>{$ticket[$x]['diff']['hitung']}</td>
				<td>{$param_dadakan}</td>
				<td bgcolor="{$ticket[$x]['warna']}">{$ticket[$x]['kondisi']}</td>
				<td>{$ticket[$x]['polis']}</td>
				<td>{$ticket[$x]['polis_status']}</td>
				<td>{$ticket[$x]['stage']}</td>
			</tr>
AZTECA;
		$html_body_red = $html_body_red.$junk_red;
	}
	else if($ticket[$x]['status'] == 'Pending Follow Up Sales' or $ticket[$x]['status'] == 'Pending Document' or $ticket[$x]['status'] == 'merged') { //pink
		$ticket[$x]['diff']['hitung'] = 0;
		$ticket[$x]['kondisi'] = 'document';
		$ticket[$x]['warna'] = '#bd3853'; //pink
		$junk_pink = <<<AZTECA
			<tr>
				<td >{$ticket[$x]['tn']}</td>
				<td>{$ticket[$x]['title']}</td>
				<td>{$ticket[$x]['new_create_time']}</td>
				<td>{$ticket[$x]['queue']}</td>
				<td>{$ticket[$x]['responsible_user']}</td>
				<td>{$ticket[$x]['status']}</td>
				<td>{$ticket[$x]['diff']['hitung']}</td>
				<td>{$param_dadakan}</td>
				<td bgcolor="{$ticket[$x]['warna']}">{$ticket[$x]['kondisi']}</td>
				<td>{$ticket[$x]['polis']}</td>
				<td>{$ticket[$x]['polis_status']}</td>
				<td>{$ticket[$x]['stage']}</td>
			</tr>
AZTECA;
		$html_body_pink = $html_body_pink.$junk_pink;
	}
	else if ($ticket[$x]['diff']['hitung'] >= $param_dadakan && $ticket[$x]['diff']['hitung'] >= $param_dadakan_wanti_wanti) { //green
		$ticket[$x]['kondisi'] = 'aman';
		$ticket[$x]['warna'] = '#38a445'; //green
		$junk_green = <<<AZTECA
			<tr>
				<td >{$ticket[$x]['tn']}</td>
				<td>{$ticket[$x]['title']}</td>
				<td>{$ticket[$x]['new_create_time']}</td>
				<td>{$ticket[$x]['queue']}</td>
				<td>{$ticket[$x]['responsible_user']}</td>
				<td>{$ticket[$x]['status']}</td>
				<td>{$ticket[$x]['diff']['hitung']}</td>
				<td>{$param_dadakan}</td>
				<td bgcolor="{$ticket[$x]['warna']}">{$ticket[$x]['kondisi']}</td>
				<td>{$ticket[$x]['polis']}</td>
				<td>{$ticket[$x]['polis_status']}</td>
				<td>{$ticket[$x]['stage']}</td>
			</tr>
AZTECA;
		$html_body_green = $html_body_green.$junk_green;
		
	}
	else if ($ticket[$x]['diff']['hitung'] <= $param_dadakan && $ticket[$x]['diff']['hitung'] >= $param_dadakan_wanti_wanti) { //green
		$ticket[$x]['kondisi'] = 'aman';
		$ticket[$x]['warna'] = '#38a445'; //green
		$junk_green = <<<AZTECA
			<tr>
				<td >{$ticket[$x]['tn']}</td>
				<td>{$ticket[$x]['title']}</td>
				<td>{$ticket[$x]['new_create_time']}</td>
				<td>{$ticket[$x]['queue']}</td>
				<td>{$ticket[$x]['responsible_user']}</td>
				<td>{$ticket[$x]['status']}</td>
				<td>{$ticket[$x]['diff']['hitung']}</td>
				<td>{$param_dadakan}</td>
				<td bgcolor="{$ticket[$x]['warna']}">{$ticket[$x]['kondisi']}</td>
				<td>{$ticket[$x]['polis']}</td>
				<td>{$ticket[$x]['polis_status']}</td>
				<td>{$ticket[$x]['stage']}</td>
			</tr>
AZTECA;
		$html_body_green = $html_body_green.$junk_green;		
	}
	else if ($ticket[$x]['diff']['hitung'] <= $param_dadakan_wanti_wanti && $ticket[$x]['diff']['hitung'] >= $param_dadakan_bahaya) { //yellow
		$ticket[$x]['kondisi'] = 'wanti-wanti';
		$ticket[$x]['warna'] = '#fff85b'; //yellow
		$junk_yellow = <<<AZTECA
			<tr>
				<td >{$ticket[$x]['tn']}</td>
				<td>{$ticket[$x]['title']}</td>
				<td>{$ticket[$x]['new_create_time']}</td>
				<td>{$ticket[$x]['queue']}</td>
				<td>{$ticket[$x]['responsible_user']}</td>
				<td>{$ticket[$x]['status']}</td>
				<td>{$ticket[$x]['diff']['hitung']}</td>
				<td>{$param_dadakan}</td>
				<td bgcolor="{$ticket[$x]['warna']}">{$ticket[$x]['kondisi']}</td>
				<td>{$ticket[$x]['polis']}</td>
				<td>{$ticket[$x]['polis_status']}</td>
				<td>{$ticket[$x]['stage']}</td>
			</tr>
AZTECA;
		$html_body_yellow = $html_body_yellow.$junk_yellow;
	}
	else if ($ticket[$x]['diff']['hitung'] <= $param_dadakan_bahaya) { //red
		$ticket[$x]['kondisi'] = 'bahaya';
		$ticket[$x]['warna'] = '#e73f3f'; //red
		$junk_red = <<<AZTECA
			<tr>
				<td >{$ticket[$x]['tn']}</td>
				<td>{$ticket[$x]['title']}</td>
				<td>{$ticket[$x]['new_create_time']}</td>
				<td>{$ticket[$x]['queue']}</td>
				<td>{$ticket[$x]['responsible_user']}</td>
				<td>{$ticket[$x]['status']}</td>
				<td>{$ticket[$x]['diff']['hitung']}</td>
				<td>{$param_dadakan}</td>
				<td bgcolor="{$ticket[$x]['warna']}">{$ticket[$x]['kondisi']}</td>
				<td>{$ticket[$x]['polis']}</td>
				<td>{$ticket[$x]['polis_status']}</td>
				<td>{$ticket[$x]['stage']}</td>
			</tr>
AZTECA;
		$html_body_red = $html_body_red.$junk_red;
	}
	else { //back
		$ticket[$x]['kondisi'] = 'aneh';
		$ticket[$x]['warna'] = '#000000';
		$junk_hitam= <<<AZTECA
			<tr>
				<td >{$ticket[$x]['tn']}</td>
				<td>{$ticket[$x]['title']}</td>
				<td>{$ticket[$x]['new_create_time']}</td>
				<td>{$ticket[$x]['queue']}</td>
				<td>{$ticket[$x]['responsible_user']}</td>
				<td>{$ticket[$x]['status']}</td>
				<td>{$ticket[$x]['diff']['hitung']}</td>
				<td>{$param_dadakan}</td>
				<td bgcolor="{$ticket[$x]['warna']}">{$ticket[$x]['kondisi']}</td>
				<td>{$ticket[$x]['polis']}</td>
				<td>{$ticket[$x]['polis_status']}</td>
				<td>{$ticket[$x]['stage']}</td>
			</tr>
AZTECA;
		$html_body_hitam = $html_body_hitam.$junk_hitam;
	}
	$x = $x +1;
}
$html_body = $html_body_red.$html_body_yellow.$html_body_pink.$html_body_green.$html_body_hitam;
echo $html_head.$html_body.$html_tail;
//echo "<PRE>"; print_r($ticket);

?>