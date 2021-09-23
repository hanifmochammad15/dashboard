<?php include '../header_new.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../nextg_koneksi.php'; ?>
<?php include '../sharia_koneksi.php'; ?>


<h1>DASHBOARD POLICY SERVICE ACTIVITY</h1>
<a href="<?php echo BaseURL() ;?>bar_chart_ps.php?team=1" class="next">Team 1</a>
<a href="<?php echo BaseURL() ;?>bar_chart_ps.php?team=2" class="next">Team 2</a>
<a href="<?php echo BaseURL() ;?>bar_chart_ps.php?team=3" class="next">Team 3</a>

<a href="<?php echo BaseURL() ;?>table.php?team=1" class="next">Simple Table</a>

<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<hr />

<div class="row">
  <div class="column" >
    <div id="chartContainerStatus"></div>
  </div>
  <div class="column" >
  <div id="chartContainerStages"></div>
  </div>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<hr />
 <div id="chartContainer"></div>

<?php
 error_reporting(0);	
$queStatus = pg_query($conn, "
select d.name, count (user_login) AS jumlah_tiket
,round((count (user_login)/(
select count(d.name) as total
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id in('1','2','3','4') and a.status_user=1 and a.level_user=1 and d.id in('1','4','13','14','15','12','16','3','21','17'))::NUMERIC *100),2)
 as percentage  
from teams as a
join users as b on b.login=a.user_login
join ticket as c on c.user_id=b.id
join ticket_state as d on d.id=c.ticket_state_id
where a.team_id in('1','2','3','4')  and a.status_user=1 and a.level_user=1 and d.id in('1','4','13','14','15','12','16','3','21','17')
group by d.name
")or die(pg_last_error($conn));

 $cde = 0;
 while ($row = pg_fetch_assoc($queStatus)) {
    $dataPointsStatus[$cde] = array( 
        'label'=>$row['name'].' -- ['.$row['jumlah_tiket'].' Ticket] --' , 
        'y'=>$row['percentage'],
        );
      $cde ++; 
 } 

// STAGE
  // $get_ticket_team = pg_query($conn, "select c.tn
  //               from teams as a
  //               join users as b on b.login=a.user_login
  //               join ticket as c on c.user_id=b.id
  //               join ticket_state as d on d.id=c.ticket_state_id
  //               JOIN queue f ON f. ID = c .queue_id
  //               where a.team_id in('1','2','3','4') and a.status_user=1 and a.level_user=1  
                
  //               and c.create_time::date >='$tglawal'
		// 		and c.create_time::date <='$tglakhir'
  //               and d. NAME NOT IN ('closed successful', 'merged')
  //               and f. NAME IN  ('Sales::POS DIRECT::Pos JKP',
  //                                           'Sales::POS DIRECT::Pos Kediri',
  //                                           'Sales::POS DIRECT::Pos Cirebon',
  //                                           'Sales::POS DIRECT::Pos Bandung',
  //                                           'Sales::POS DIRECT::Pos Jambi',
  //                                           'Sales::POS DIRECT::Pos BSD',
  //                                           'Sales::POS DIRECT::Pos Makassar',
  //                                           'Sales::POS DIRECT::Pos Malang',
  //                                           'Sales::POS DIRECT::Pos Solo',
  //                                           'Sales::POS DIRECT::Pos Batam',
  //                                           'Sales::POS DIRECT::Pos Medan',
  //                                           'Sales::POS DIRECT::Pos Jember',
  //                                           'Sales::POS DIRECT::Pos Purwokerto',
  //                                           'Sales::POS DIRECT::Pos Pontianak',
  //                                           'Sales::POS DIRECT::Pos Lampung',
  //                                           'Sales::POS DIRECT::pos.samarinda',
  //                                           'Sales::POS DIRECT::Pos Denpasar',
  //                                           'Sales::POS DIRECT::Pos Semarang',
  //                                           'Sales::POS DIRECT::Pos Manado',
  //                                           'Sales::POS DIRECT::Pos Yogyakarta',
  //                                           'Sales::POS DIRECT::Pos Surabaya',
  //                                           'Sales::POS DIRECT::Pos Palembang',
  //                                           'Sales::POS DIRECT::Pos Balikpapan',
  //                                           'Sales::POS DIRECT::HO KONVEN',
  //                                           'Sales::POS DIRECT::Pos Pekanbaru',
  //                                           'Sales::POS DIRECT::Pos Health',
  //                                           'Sales::POS DIRECT::Pos DNC',
  //                                           'TMO')
  //                           and c.tn NOT IN (
  //                                           '880295919',
  //                                           '880299111',
  //                                           '880345340',
  //                                           '880345581',
  //                                           '880345709',
  //                                           '880345710',
  //                                           '880346755',
  //                                           '880346784',
  //                                           '880346786',
  //                                           '880346963',
  //                                           '880346969',
  //                                           '880347268',
  //                                           '880349390',
  //                                           '880351271',
  //                                           '880351589',
  //                                           '880352274',
  //                                           '880353054',
  //                                           '880353734',
  //                                           '880354348',
  //                                           '880354857',
  //                                           '880355068',
  //                                           '880355449',
  //                                           '880356948',
  //                                           '880357556',
  //                                           '880358649',
  //                                           '880358818'
  //                                       )
  //                                           ")or die(pg_last_error($conn));
    
$get_ticket_team = pg_query($conn, "SELECT
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
            WHEN A .ticket_status = 'Assessment UW/RI' THEN
                (
                    SELECT z.create_time
                    FROM ticket_history z
                    WHERE z.ticket_id = A . ID
                    AND state_id = '4' --open
                    ORDER BY z.create_time DESC
                    LIMIT 1
                )
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
                
        a.create_time::date >='2020-01-01'
                and a.create_time::date <='2020-08-10'
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
    ORDER BY 1 ASC  ) ")or die(pg_last_error($conn));

        if (!$get_ticket_team) {
            echo "An error occurred.\n";
            exit;
        }

        $abc = pg_fetch_all($get_ticket_team['tn']);
        $xyz = subArraysToString($abc);
        
        $array=array_map('intval', explode(',', $xyz));
        $array = implode("','",$array);
        //$get_ticket = pg_query($conn, "select * from tbl_helpdesk_integration where ticket_number in ('".$array."')")or die(pg_last_error($conn));
        
        $get_user_login = pg_query($conn, "select a.user_login,c.tn
                from teams as a
                join users as b on b.login=a.user_login
                join ticket as c on c.user_id=b.id
                join ticket_state as d on d.id=c.ticket_state_id
                where a.team_id in('1','2','3','4')  and a.status_user=1 and a.level_user=1
                and tn in ('".$array."')
                ")or die(pg_last_error($conn));

         $team_user_login = pg_query($conn, "select user_login from teams where team_id in('1','2','3','4') and level_user=1 and status_user=1")or die(pg_last_error($conn));

         $get_ticket = pg_query($nextg_conn, "SELECT 
                a.ticket_number,a.sales_number||';'||a.revision_number AS sales_number, b.sales_status, 'konven' AS group,
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
            ticket_number in ('".$array."')
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
            )")or die(pg_last_error($nextg_conn));

$get_ticket_sharia = pg_query($sharia_conn, "SELECT 
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
                ticket_number in ('".$array."')
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
                )")or die(pg_last_error($sharia_conn));


        $x = 0;
         while ($row = pg_fetch_assoc($get_user_login)) {
            $array1[$x] = array( 
                'id'=>$row['tn'],
                'user_login'=>$row['user_login']
                );
              $x ++; 
         } 
           $x = 0;
         while ($row = pg_fetch_assoc($get_ticket)) {
           
            $array2[$x] = array( 
                'id'=>$row['ticket_number'],
                'sales_number'=>$row['sales_number'],
                'stage'=>$row['stage'],
                'sales_status'=>$row['sales_status'],
                'group'=>$row['group']
                );
            
              $x ++; 
            }

         while ($row = pg_fetch_assoc($get_ticket_sharia)) {
           
            $array3[$x] = array( 
                'id'=>$row['ticket_number'],
                'sales_number'=>$row['sales_number'],
                'stage'=>$row['stage'],
                'sales_status'=>$row['sales_status'],
                'group'=>$row['group']
                );
            
              $x ++; 
            }
 

if(!empty($array3) ){
$result=array_merge($array2, $array3);
}else{
    $result=$array2;
}
//print_r($result);
$master_array = merge_two_arrays($array1,$result);

//print_r($master_array);
$stagebranchUW='Branch U/W';
$branchUW= array_count_values(array_column($master_array,'stage'))[$stagebranchUW];
$stagemaker='Maker';
$maker= array_count_values(array_column($master_array,'stage'))[$stagemaker];
$stagereinsurance='Reinsurance';
$reinsurance= array_count_values(array_column($master_array,'stage'))[$stagereinsurance];
$stagehoUW='HO U/W';
$hoUW= array_count_values(array_column($master_array,'stage'))[$stagehoUW];

$total=$branchUW+$maker+$reinsurance+$hoUW;


$branchUWPercentage=round((($branchUW/$total)*100), 2);
$makerPercentage=round((($maker/$total)*100), 2);
$reinsurancePercentage=round((($reinsurance/$total)*100), 2);
$hoUWPercentage=round((($hoUW/$total)*100), 2);


$totalPercentage= $branchUWPercentage+$makerPercentage+$reinsurancePercentage+$hoUWPercentage;

 $dataPointsStage[0] = array( 
        'label'=>$stagebranchUW.' -- ['.$branchUW.' Ticket] --' , 
        'y'=>$branchUWPercentage,
        );

 $dataPointsStage[1] = array( 
        'label'=>$stagemaker.' -- ['.$maker.' Ticket] --' , 
        'y'=>$makerPercentage,
        );

 $dataPointsStage[2] = array( 
        'label'=>$stagereinsurance.' -- ['.$reinsurance.' Ticket] --' , 
        'y'=>$reinsurancePercentage,
        );

 $dataPointsStage[3] = array( 
        'label'=>$stagehoUW.' -- ['.$hoUW.' Ticket] --' , 
        'y'=>$hoUWPercentage,
        );


//otrs policy status

 $get_ticket_team = pg_query($conn, "select c.tn
                from teams as a
                join users as b on b.login=a.user_login
                join ticket as c on c.user_id=b.id
                join ticket_state as d on d.id=c.ticket_state_id
                JOIN queue f ON f. ID = c .queue_id
                where a.team_id in('1','2','3','4') and a.status_user=1 and a.level_user=1  
                
                and c.create_time::date >='$tglawal'
				and c.create_time::date <='$tglakhir'
                and d. NAME NOT IN ('closed successful', 'merged')
                and f. NAME IN  ('Sales::POS DIRECT::Pos JKP',
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
                                            'TMO')
                            and c.tn NOT IN (
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
                                            '880358818'
                                        )
                                            ")or die(pg_last_error($conn));
    


        if (!$get_ticket_team) {
            echo "An error occurred.\n";
            exit;
        }

        $abc = pg_fetch_all($get_ticket_team);
        $xyz = subArraysToString($abc);
        //echo $arr;
        $array=array_map('intval', explode(',', $xyz));
        $array = implode("','",$array);
        
        $get_user_login = pg_query($conn, "select a.user_login,c.tn
                from teams as a
                join users as b on b.login=a.user_login
                join ticket as c on c.user_id=b.id
                join ticket_state as d on d.id=c.ticket_state_id
                where a.team_id in('1','2','3','4')  and a.status_user=1 and a.level_user=1
                and tn in ('".$array."')
                ")or die(pg_last_error($conn));

         $team_user_login = pg_query($conn, "select user_login from teams where team_id in('1','2','3','4') and level_user=1 and status_user=1")or die(pg_last_error($conn));

         $get_ticket = pg_query($nextg_conn, "SELECT 
                a.ticket_number,a.sales_number||';'||a.revision_number AS sales_number, b.sales_status, 'konven' AS group,
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
            ticket_number in ('".$array."')
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
            )")or die(pg_last_error($nextg_conn));

$get_ticket_sharia = pg_query($sharia_conn, "SELECT 
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
                ticket_number in ('".$array."')
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
                )")or die(pg_last_error($sharia_conn));


        $x = 0;
         while ($row = pg_fetch_assoc($get_user_login)) {
            $array1[$x] = array( 
                'id'=>$row['tn'],
                'user_login'=>$row['user_login']
                );
              $x ++; 
         } 
           $x = 0;
         while ($row = pg_fetch_assoc($get_ticket)) {
           
            $array2[$x] = array( 
                'id'=>$row['ticket_number'],
                'sales_number'=>$row['sales_number'],
                'stage'=>$row['stage'],
                'sales_status'=>$row['sales_status'],
                'group'=>$row['group']
                );
            
              $x ++; 
            }

         while ($row = pg_fetch_assoc($get_ticket_sharia)) {
           
            $array3[$x] = array( 
                'id'=>$row['ticket_number'],
                'sales_number'=>$row['sales_number'],
                'stage'=>$row['stage'],
                'sales_status'=>$row['sales_status'],
                'group'=>$row['group']
                );
            
              $x ++; 
            }
 


if(!empty($array3) ){
$result=array_merge($array2, $array3);
}else{
    $result=$array2;
}
print_r($result);
$master_array = merge_two_arrays($array1,$result);


foreach ($master_array as $key => $value) {
    # code...
}
$statusRiskAccepted='Risk Accepted';
$RiskAccepted= array_count_values(array_column($master_array,'sales_status'))[$statusRiskAccepted];

$statusApprove='Approve';
$Approve= array_count_values(array_column($master_array,'sales_status'))[$statusApprove];

$statusPaidfully='Paid fully';
$Paidfully= array_count_values(array_column($master_array,'sales_status'))[$statusPaidfully];

$statusPaidpartially='Paid partially';
$Paidpartially= array_count_values(array_column($master_array,'sales_status'))[$statusPaidpartially];

$statusInvoiced='Invoiced';
$Invoiced= array_count_values(array_column($master_array,'sales_status'))[$statusInvoiced];

$Blankcount = 1;
foreach($master_array as $v) {
    if ($v['sales_status'] == '') { 
        $Blankcount++;
    }
}
$Blank= $Blankcount-1;



$total=$RiskAccepted+$Approve+$Paidfully+$Paidpartially+$Invoiced+$Blank;

$RiskAcceptedPercentage=round((($RiskAccepted/$total)*100), 2);
$ApprovePercentage=round((($Approve/$total)*100), 2);
$PaidfullyPercentage=round((($Paidfully/$total)*100), 2);
$PaidpartiallyPercentage=round((($Paidpartially/$total)*100), 2);
$InvoicedPercentage=round((($Invoiced/$total)*100), 2);
$BlankPercentage=round((($Blank/$total)*100), 2);

$totalPercentage= $RiskAcceptedPercentage+$ApprovePercentage+$PaidfullyPercentage+$PaidpartiallyPercentage+$InvoicedPercentage+$BlankPercentage;

 $dataPoints[0] = array( 
        'label'=>$statusRiskAccepted.' -- ['.$RiskAccepted.' Ticket] --' , 
        'y'=>$RiskAcceptedPercentage,
        );

 $dataPoints[1] = array( 
        'label'=>$statusApprove.' -- ['.$Approve.' Ticket] --' , 
        'y'=>$ApprovePercentage,
        );

 $dataPoints[2] = array( 
        'label'=>$statusPaidfully.' -- ['.$Paidfully.' Ticket] --' , 
        'y'=>$PaidfullyPercentage,
        );

 $dataPoints[3] = array( 
        'label'=>$statusPaidpartially.' -- ['.$Paidpartially.' Ticket] --' , 
        'y'=>$PaidpartiallyPercentage,
        );

  $dataPoints[4] = array( 
        'label'=>$statusInvoiced.' -- ['.$Invoiced.' Ticket] --' , 
        'y'=>$InvoicedPercentage,
        );
    $dataPoints[5] = array( 
        'label'=>'New'.' -- ['.$Blank.' Ticket] --' , //berfore blank
        'y'=>$BlankPercentage,
        );
          

?>


<script>

window.onload = function() {
 
var chartStatus = new CanvasJS.Chart("chartContainerStatus", {
    animationEnabled: true,
    title: {
        text: "Summary OTRS Ticket"
    },
    subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPointsStatus, JSON_NUMERIC_CHECK); ?>
    }]
});
var chartStage = new CanvasJS.Chart("chartContainerStages", {
    animationEnabled: true,
    title: {
        text: "Summary Stages Policy"
    },
    subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPointsStage, JSON_NUMERIC_CHECK); ?>
    }]
});
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    title: {
        text: "Summary Status Policy"
    },
    subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chartStatus.render();
chartStage.render();
chart.render();
}

</script>




<?php
   function subArraysToString($ar, $sep = ', ') {
                $str = '';
                foreach ($ar as $val) {
                    $str .= implode($sep, $val);
                    $str .= $sep; // add separator between sub-arrays
                }
                $str = rtrim($str, $sep); // remove last separator
                return $str;
        }

function merge_two_arrays($array1,$array2) {
    $data = array();
    $arrayAB = array_merge($array1,$array2);
    foreach ($arrayAB as $value) {
    $id = $value['id'];
    if (!isset($data[$id])) {
        $data[$id] = array();
    }
    $data[$id] = array_merge($data[$id],$value);
    }
    return $data;
}

?>