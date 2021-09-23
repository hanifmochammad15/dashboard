<?php include '../header.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../nextg_koneksi.php'; ?>
<?php $param=$_GET["team"]; ?>

<h1>Bar Chart OTRS</h1>
<a href="http://10.11.12.93/DEV/hanif/chart/chart-types/pie_chart_ps.php?team=<?php echo $param;?>" class="next">Pie &raquo;</a>
<div id="chartContainer"></div>
 <?php
ini_set('error_reporting',E_ALL);


if(empty($param)){
echo "Empty Parameter.\n";
            exit;
}else{
//echo $param;
        $get_ticket_team = pg_query($conn, "select c.tn
                from teams as a
                join users as b on b.login=a.user_login
                join ticket as c on c.user_id=b.id
                join ticket_state as d on d.id=c.ticket_state_id
                where a.team_id='$param' and a.status_user=1 and a.level_user=1  
                ")or die(pg_last_error($conn));
        
        $get_user_login = pg_query($conn, "select a.user_login,c.tn
                from teams as a
                join users as b on b.login=a.user_login
                join ticket as c on c.user_id=b.id
                join ticket_state as d on d.id=c.ticket_state_id
                where a.team_id='$param'  and a.status_user=1 and a.level_user=1
                ")or die(pg_last_error($conn));

         $team_user_login = pg_query($conn, "select user_login from teams where team_id='$param' and level_user=1 and status_user=1")or die(pg_last_error($conn));


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
                'sales_number'=>$row['sales_number'] ,
                'stage'=>$row['stage'] 
                );
              $x ++; 
         } 
         
$master_array = merge_two_arrays($array1,$array2);

  echo "<table  border='1'>";
  echo " <th>No</th><th>Id</th><th>user_login</th><th>sales_number</th><th>stage</th>";
  $x = 0;
       foreach ($master_array as $value){ 
        echo '<tr>';
        echo '<td>'.$x.'</td>';
        echo '<td>'.$value['id'].'</td>';
        echo '<td>'.$value['user_login'].'</td>';
        if(empty($value['sales_number'])){
            echo '.<td></td>';
        }else{echo '<td>'.$value['sales_number'].'</td>';}
        if(empty($value['stage'])){
            echo '<td></td>';
        }else{echo '<td>'.$value['stage'].'</td>';}
        echo '</tr>';
            $x ++; 
         } 
          echo "</table>";


            $x = 0;
         while ($row = pg_fetch_assoc($team_user_login)) {
            echo $row['user_login'];
            echo array_count_values(array_column($master_array, 'user_login'))[$row['user_login']];
              $x ++; 
         } 
         

         
}
?>




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