<?php include '../header_new.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../nextg_koneksi.php'; ?>
<?php include '../sharia_koneksi.php'; ?>
<?php include '../koneksi_opp.php'; ?>


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

<div class="row">
  <div class="column" >
 <div id="chartContainer"></div>
 </div>
  <div class="column" >
  <div id="chartContainerSla"></div>
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

<div class="row">
  <div class="column" >
    <div id="chartContainerStatusOpp"></div>
  </div>
</div>
 

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

    $query_tiket2 = "SELECT COUNT(b.user_login)::NUMERIC AS jumlah_ticket FROM ( SELECT * FROM dblink ( 'host=10.11.12.84 user=postgres dbname=otrs2_4_201610', $$ SELECT A .user_login, C .tn AS ticket_number,A.team_id::int FROM teams AS A JOIN users AS b ON b. LOGIN = A .user_login JOIN ticket AS C ON C .user_id = b. ID JOIN ticket_state AS d ON d. ID = C .ticket_state_id WHERE A .team_id in ('1','2','3') AND A .status_user = 1 AND A .level_user = 1 AND d. ID in ('2','3') AND C .create_time :: DATE >= '$tglawal' AND C .create_time :: DATE <= '$tglakhir' AND c.queue_id <> '169' GROUP BY A . ID, A .user_login, A .status_user, A .team_id, d. NAME, C .tn ORDER BY user_login ASC $$ ) AS a1 ( user_login VARCHAR, ticket_number VARCHAR, team_id int ) ) b JOIN tbl_helpdesk_integration C USING (ticket_number) LEFT JOIN tbl_log_history_order_printing d ON C .sales_number = substr(d.param, 1, 12) WHERE b.ticket_number IS NOT NULL AND C .sales_number IS NOT NULL AND substr(c.sales_number, 1 ,1) <> 'Q' AND d.param IS NULL";
    $hasil_query2 = pg_query($conn_opp, $query_tiket2); 
    $get_query_tiket2 = pg_fetch_assoc($hasil_query2);
    $jumlah_ticket    = $get_query_tiket2['jumlah_ticket'];


$queStatusOpp = pg_query($conn_opp, "
SELECT 'team ' ||n.team_id as team, count(n.user_login) AS jumlah_tiket, round((count (n.user_login)/$jumlah_ticket ::NUMERIC *100),2) as percentage from(
SELECT
    b.user_login,b.ticket_number,b.team_id
    --COALESCE (COUNT(b.user_login), 0) AS jumlah_ticket
FROM
    (
        SELECT
            *
        FROM
            dblink (
                'host=10.11.12.84 user=postgres dbname=otrs2_4_201610',
                $$ SELECT
                    A .user_login,
                    C .tn AS ticket_number,A.team_id::int  --COALESCE(count (user_login),0) as jumlah_ticket 
                FROM
                    teams AS A
                JOIN users AS b ON b. LOGIN = A .user_login
                JOIN ticket AS C ON C .user_id = b. ID
                JOIN ticket_state AS d ON d. ID = C .ticket_state_id
                WHERE
                    A .team_id in ('1','2','3')
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
                ticket_number VARCHAR,
                team_id int
            )
    ) b
JOIN tbl_helpdesk_integration C USING (ticket_number)
LEFT JOIN tbl_log_history_order_printing d ON C .sales_number = substr(d.param, 1, 12)
WHERE
    b.ticket_number IS NOT NULL
AND C .sales_number IS NOT NULL
AND substr(c.sales_number, 1 ,1) <> 'Q'
AND d.param IS NULL
--GROUP BY
    --b.user_login
--ORDER BY b.team_id asc
)as n

GROUP BY
n.team_id")or die(pg_last_error($conn_opp));


 $cde = 0;
 while ($row = pg_fetch_assoc($queStatus)) {
    $dataPointsStatus[$cde] = array( 
        'label'=>$row['name'].' -- ['.$row['jumlah_tiket'].' Ticket] --' , 
        'y'=>$row['percentage'],
        );
      $cde ++; 
 }

 $cde_opp = 0;
 while ($row = pg_fetch_assoc($queStatusOpp)) {
    $dataPointsStatusOpp[$cde_opp] = array( 
        'label'=>$row['team'].' -- ['.$row['jumlah_tiket'].' Ticket] --' , 
        'y'=>$row['percentage'],
        );
      $cde_opp ++; 
 }  

// STAGE
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
//print_r($result);
$master_array = merge_two_arrays($array1,$result);

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
        

// sla
$today = date("Y-m-d H:i:s");
    $kondisi[0] = 68.4; //sla 2,85 hari
    $kondisi[1] = 24; // 1 hari
    $kondisi[2] = 12; // merah
    //BSD//
    $kondisi['bsd'] = 222; //sla 9,5 hari
    $kondisi['bsd_wanti_wanti'] = 64;
    $kondisi['bsd_bahaya'] = 24;

 $query_read = pg_query($conn, "SELECT
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
            LEFT join users as d on d.id=a.user_id
            LEFT JOIN teams as f on f.user_login=d.login
            WHERE
                
                a.create_time::date >='$tglawal'
                and a.create_time::date <='$tglakhir'    
                and f.team_id in('1','2','3','4') and f.status_user=1 and f.level_user=1            
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
    ORDER BY 1 ASC ")or die(pg_last_error($conn));
    

        if (!$query_read) {
            echo "An error occurred.\n";
            exit;
        }
$x=0;
       while ($obj_read = pg_fetch_assoc($query_read)){
    $ticket[$x] = $obj_read;
    
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
        if(empty($waktu_pemeriksa[$ticket[$x]['id']])) {$ticket[$x]['new_create_time'] = 0;}
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
        
    }
    else if($ticket[$x]['status'] == 'Pending Follow Up Sales' or $ticket[$x]['status'] == 'Pending Document' or $ticket[$x]['status'] == 'merged') { //pink
        $ticket[$x]['diff']['hitung'] = 0;
        $ticket[$x]['kondisi'] = 'document';
    }
    else if ($ticket[$x]['diff']['hitung'] >= $param_dadakan && $ticket[$x]['diff']['hitung'] >= $param_dadakan_wanti_wanti) { //green
        $ticket[$x]['kondisi'] = 'aman';

        
    }
    else if ($ticket[$x]['diff']['hitung'] <= $param_dadakan && $ticket[$x]['diff']['hitung'] >= $param_dadakan_wanti_wanti) { //green
        $ticket[$x]['kondisi'] = 'aman';
          
    }
    else if ($ticket[$x]['diff']['hitung'] <= $param_dadakan_wanti_wanti && $ticket[$x]['diff']['hitung'] >= $param_dadakan_bahaya) { //yellow
        $ticket[$x]['kondisi'] = 'wanti-wanti';
        
    }
    else if ($ticket[$x]['diff']['hitung'] <= $param_dadakan_bahaya) { //red
        $ticket[$x]['kondisi'] = 'bahaya';
    }
    else { //back
        $ticket[$x]['kondisi'] = 'aneh';
       
    }
    $x = $x +1;
}
//echo "<PRE>"; print_r($ticket);
$x = 0;


$statusbahaya='bahaya';
$bahaya= array_count_values(array_column($ticket,'kondisi'))[$statusbahaya];

$statusdocument='document';
$document= array_count_values(array_column($ticket,'kondisi'))[$statusdocument];

$statusaman='aman';
$aman= array_count_values(array_column($ticket,'kondisi'))[$statusaman];


$statuswantiwanti='wanti-wanti';
$wantiwanti= array_count_values(array_column($ticket,'kondisi'))[$statuswantiwanti];

$total=$bahaya+$document+$aman+$wantiwanti;

$bahayaPercentage=round((($bahaya/$total)*100), 2);
$documentPercentage=round((($document/$total)*100), 2);
$amanPercentage=round((($aman/$total)*100), 2);
$wantiwantiPercentage=round((($wantiwanti/$total)*100), 2);

$totalPercentage= $bahayaPercentage+$documentPercentage+$amanPercentage+$wantiwantiPercentage;

 $dataPointsSLA[0] = array( 
        'label'=>$statusbahaya.' -- ['.$bahaya.' Ticket] --' , 
        'y'=>$bahayaPercentage,
        );

 $dataPointsSLA[1] = array( 
        'label'=>$statusdocument.' -- ['.$document.' Ticket] --' , 
        'y'=>$documentPercentage,
        );

 $dataPointsSLA[2] = array( 
        'label'=>$statusaman.' -- ['.$aman.' Ticket] --' , 
        'y'=>$amanPercentage,
        );

 $dataPointsSLA[3] = array( 
        'label'=>$statuswantiwanti.' -- ['.$wantiwanti.' Ticket] --' , 
        'y'=>$wantiwantiPercentage,
        );



?>


<script>

window.onload = function() {
  CanvasJS.addColorSet("chartContainerColor",
                [//colorSet Array
                "#e73f3f",
                "#bd3853",
                "#38a445",
                "#fff85b"              
                ]);
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

var chartStatusOpp = new CanvasJS.Chart("chartContainerStatusOpp", {
    animationEnabled: true,
    title: {
        text: "Summary Of Closed Tickets Not Found In OPP"
    },
    subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPointsStatusOpp, JSON_NUMERIC_CHECK); ?>
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
var chartSla = new CanvasJS.Chart("chartContainerSla", {
    colorSet: "chartContainerColor",
    animationEnabled: true,
    title: {
        text: "Summary Status SLA"
    },
    subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPointsSLA, JSON_NUMERIC_CHECK); ?>
    }]
});
chartStatus.render();
chartStage.render();
chart.render();
chartSla.render();
chartStatusOpp.render();

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