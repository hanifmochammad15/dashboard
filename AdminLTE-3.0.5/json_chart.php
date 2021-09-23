<?php include '../chart/koneksi.php'; ?>
<?php include '../chart/nextg_koneksi.php'; ?>
<?php include '../chart/sharia_koneksi.php'; ?>
<?php include '../chart/koneksi_opp.php'; ?>
<script>
            function change_formatphp(date){
                  var date = date;
                  var initial = date.split(/\//);
                  return [ initial[2], initial[0], initial[1] ].join('-'); //=> 'mm/dd
            }
            function change_formatjs(date){
                  var date = date;
                  var initial = date.split('-');
                  return [ initial[1], initial[2], initial[0] ].join('/'); //=> 'mm/dd
            }
            function checkdatejs(date){
                  var date = date;
                  var initial = date.split(/\//);
                  return [ initial[2], initial[0], initial[1] ].join(''); //=> 'mm/dd
            }
            function checkdatephp(date){
                  var date = date;
                  var initial = date.split('-');
                  return [ initial[0], initial[1], initial[2] ].join(''); //=> 'mm/dd
            }
            $( document ).ready(function() {
                  var tglawal = '<?php echo $tglawal;?>';
                  var tglakhir = '<?php echo $tglakhir;?>';
                  var status = '<?php echo $status;?>';
                  var team = '<?php echo $team;?>';
                  var actual_link2 ='<?php echo  $actual_link2;?>';
                  //alert(actual_link2);
                  document.getElementById("datepickerawal").value = change_formatjs(tglawal); 
                  document.getElementById("datepickerakhir").value = change_formatjs(tglakhir);  
                 
                $("#datepickerawal").datepicker({ 
                    format: 'yyyy-mm-dd'
                });
                
                $("#datepickerawal").on("change", function () {
                    var fromdate = $(this).val();
                    var checkfromdate = checkdatejs(fromdate);
                    var checktodate = checkdatephp(tglakhir);
                    var result=checktodate-checkfromdate;
                    //alert(result);
                    if(checktodate >= checkfromdate){
                    var link = actual_link2 ;
                    link +='?team='+team ;
                    link +='&tglawal='+change_formatphp(fromdate)+'&tglakhir='+tglakhir+'&status='+status;
                    var win = location.replace(link);
                }else{
                    alert('Tanggal awal harus lebih kecil dari tanggal akhir');
                }
                    

                });
                $("#datepickerakhir").datepicker({ 
                    format: 'yyyy-mm-dd'
                });
                $("#datepickerakhir").on("change", function () {
                    var todate = $(this).val();
                    var checkfromdate2 = checkdatephp(tglawal);
                    var checktodate2 = checkdatejs(todate);
                    var result2=checktodate2-checkfromdate2;
                     if(checktodate2 >= checkfromdate2){
                    var link = actual_link2 ;
                    link +='?team='+team ;
                    link +='&tglawal='+tglawal+'&tglakhir='+change_formatphp(todate)+'&status='+status;
                    var win = location.replace(link);
                }else{
                    alert('Tanggal akhir harus lebih besar dari tanggal awal');
                }
                    
                });

            }); 
            </script>
<?php
//error_reporting(E_ALL);
error_reporting(0);

$arr = json_decode(file_get_contents("php://input"));
if(!empty($arr)){

$tglawal=$arr->tglawal;
$tglakhir=$arr->tglakhir;
}else{
 $tglawal='2020-01-01';
$tglakhir='2020-09-01';
}
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
        


 $query_read = pg_query($conn, "
--select now() + 1.2 * interval '1 hour';

--select * from(
select 
case 
when status = 'new' And hitung_rev <= param_dadakan_wanti_wanti then 'bahaya'
when status = 'Pending Follow Up Sales' then 'document'
when status = 'Pending Document' then 'document'
when status = 'merged' then 'document'
when  hitung_rev >= param_dadakan AND  hitung_rev >= param_dadakan_wanti_wanti then 'aman'
when  hitung_rev <= param_dadakan AND  hitung_rev >= param_dadakan_wanti_wanti then 'aman'
when  hitung_rev <= param_dadakan_wanti_wanti AND  hitung_rev >= param_dadakan_bahaya then 'wanti-wanti'
when  hitung_rev <= param_dadakan_bahaya then 'bahaya'
ELSE 'aneh'
end as kondisi,
* from (
select 
(param_dadakan - hours) + pemulih as hitung_rev,
param_dadakan - hours as hitung,
*from (
select 
case 
when new_create_time is null and create_time_z is null then 0
when new_create_time is null then 
(SELECT count (*) FROM daging_tgl  where tgl >= (create_time_z::date)::text AND tgl <= (now()::date)::text)*24

 when days = 0 then 
(SELECT count (*) FROM daging_tgl  where tgl = (new_create_time::date)::text)*24

else
(SELECT count (*) FROM daging_tgl  where tgl >= (new_create_time::date)::text AND tgl <= (now()::date)::text)*24
end as pemulih,

case when queue='Sales::POS DIRECT::Pos BSD' then 222
else 68.4
end as 
param_dadakan,
case when queue='Sales::POS DIRECT::Pos BSD' then 64
else 24
end as 
param_dadakan_wanti_wanti,
case when queue='Sales::POS DIRECT::Pos BSD' then 24
else 12
end as 
param_dadakan_bahaya,
* from(
select 
case 
WHEN
new_create_time is null and create_time_z is null then 
FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-0)/3600)
WHEN
new_create_time is null then 
FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM create_time_z))/3600)
else 
FLOOR((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM new_create_time))/3600)
end as hours, 

case 
WHEN
new_create_time is null and create_time_z is null then 
FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-0)/3600)/24) 
WHEN
new_create_time is null then 
FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM create_time_z))/3600)/24) 
else 
FLOOR(((EXTRACT(EPOCH FROM now()+ 1.2 * interval '1 hour')-EXTRACT(EPOCH FROM new_create_time))/3600)/24) 
end as days,
EXTRACT(EPOCH FROM now()) as nowe,EXTRACT(EPOCH FROM now())-EXTRACT(EPOCH FROM new_create_time) as raw,
* from (SELECT DISTINCT on (a.id)  a.id,z.create_time as create_time_z,a.create_time as create_time_a,
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
                            AND state_id = '4' 
                            ORDER BY z.create_time DESC
                            LIMIT 1
                        )
                    else A .create_time end
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

LEFT JOIN ticket_history z
            on z.ticket_id = a.id
            AND z.state_id = a.ticket_state_id
            ORDER BY a.id ASC,z.create_time DESC ) as t1 )as t2 )as t3)as t4 
--)as t5 where kondisi='bahaya'; ")or die(pg_last_error($conn));
    

if (!$query_read) {
            echo "An error occurred.\n";
            exit;
}
$x=0;
       while ($obj_read = pg_fetch_assoc($query_read)){
        $ticket[$x] = $obj_read;
      $x ++;
}
//echo "<PRE>"; print_r($ticket);

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

echo json_encode($dataPoints);


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
