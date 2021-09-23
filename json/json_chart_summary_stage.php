<?php include '../chart/koneksi.php'; ?>
<?php include '../chart/nextg_koneksi.php'; ?>
<?php include '../chart/sharia_koneksi.php'; ?>
<?php include '../chart/koneksi_opp.php'; ?>

<?php
error_reporting(0);	
//error_reporting(E_ALL);
if( !empty($_POST['tglawal']) AND !empty($_POST['tglakhir'])){

$tglawal=$_POST['tglawal'];
$tglakhir=$_POST['tglakhir'];
}

if($_POST['summary_otrs_stage']==1){
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
           if(!empty($row['ticket_number'])){
            $array3[$x] = array( 
                'id'=>$row['ticket_number'],
                'sales_number'=>$row['sales_number'],
                'stage'=>$row['stage'],
                'sales_status'=>$row['sales_status'],
                'group'=>$row['group']
                );
            
              $x ++; 
            }
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

header('Content-Type: application/json');

 echo json_encode($dataPointsStage);

}



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
