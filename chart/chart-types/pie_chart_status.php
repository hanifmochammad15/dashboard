<?php include '../header_new.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../nextg_koneksi.php'; ?>
<?php include '../sharia_koneksi.php'; ?>
<?php
/*
 $key ='hanif';
  $enckey=urlencode(base64_encode($key)); 
  $link=urlencode(base64_encode($enckey.$paramlink)); 
 echo $link; 
*/
 ?>

<h1>PIE CHART POLIS STATUS OTRS</h1>
<a href="<?php echo BaseURL() .'bar_chart_ps.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Ticket Status</a>
<a href="<?php echo BaseURL() .'bar_chart_status.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Polis Status</a>
<a href="<?php echo BaseURL() .'bar_chart_stage.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Chart Stage</a>
<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<hr />
<a href="<?php echo BaseURL() .'bar_chart_status.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>"  class="next">Bar &raquo;</a>
<div id="chartContainer"></div>
 <?php
 error_reporting(0);
//ini_set('error_reporting',E_ALL);


if(empty($team)){
echo "Empty Parameter.\n";
            exit;
}else{
//echo $param;
        $get_ticket_team = pg_query($conn, "select c.tn
                from teams as a
                join users as b on b.login=a.user_login
                join ticket as c on c.user_id=b.id
                join ticket_state as d on d.id=c.ticket_state_id
                JOIN queue f ON f. ID = c .queue_id
                where a.team_id='$team' and a.status_user=1 and a.level_user=1  
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
        //$get_ticket = pg_query($conn, "select * from tbl_helpdesk_integration where ticket_number in ('".$array."')")or die(pg_last_error($conn));
        
        $get_user_login = pg_query($conn, "select a.user_login,c.tn
                from teams as a
                join users as b on b.login=a.user_login
                join ticket as c on c.user_id=b.id
                join ticket_state as d on d.id=c.ticket_state_id
                where a.team_id='$team'  and a.status_user=1 and a.level_user=1
                and tn in ('".$array."')
                ")or die(pg_last_error($conn));

         $team_user_login = pg_query($conn, "select user_login from teams where team_id='$team' and level_user=1 and status_user=1")or die(pg_last_error($conn));

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

/*
  echo "<table  border='1'>";
  echo " <th>No</th><th>Id</th><th>user_login</th><th>sales_number</th><th>stage</th><th>sales_status</th><th>group</th>";
  $x = 0;
       foreach ($master_array as $value){ 
        echo '<tr>';
        echo '<td>'.$x.'</td>';
        echo '<td>'.$value['id'].'</td>';
          if(empty($value['user_login'])){
            echo '.<td></td>';
        }else{echo '<td>'.$value['user_login'].'</td>';}
        if(empty($value['sales_number'])){
            echo '.<td></td>';
        }else{echo '<td>'.$value['sales_number'].'</td>';}
        if(empty($value['stage'])){
            echo '<td></td>';
        }else{echo '<td>'.$value['stage'].'</td>';}
          if(empty($value['sales_status'])){
            echo '<td></td>';
        }else{echo '<td>'.$value['sales_status'].'</td>';}
        if(empty($value['group'])){
            echo '<td></td>';
        }else{echo '<td>'.$value['group'].'</td>';}
        echo '</tr>';
            $x ++; 
         } 
          echo "</table>";

*/
//print_r($master_array);
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
/*
$statusBlank='';
$Blank= array_count_values(array_column($master_array,'sales_status'))[$statusBlank];
*/
$Blankcount = 1;
foreach($master_array as $v) {
    if ($v['sales_status'] == '') { 
        $Blankcount++;
    }
}
$Blank= $Blankcount-1;
//echo $Blank;


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
          

}
//print_r($dataPoints)
?>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    title: {
        text: "Team <?php echo $team;?>"
    },
    subtitles: [{
          text: "<?php echo $tglawal .' -- '.$tglakhir.' (yyyy-mm-dd)' ;?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
 
}
setTimeout(function(){
   window.location.reload(1);
}, 60000);
</script>
<?php include '../footer.php'; ?>

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