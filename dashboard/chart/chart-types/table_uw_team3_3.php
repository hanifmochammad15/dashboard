
<?php include '../header_table2.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../nextg_koneksi.php'; ?>
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
<h1>BAR CHART TICKET OTRS UNDERWRITNG</h1>
<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<a href="<?php echo BaseURL() .'bar_chart_uw_team3_3.php?team='.$team.'&tglawal='.$tglawal.'&tglakhir='.$tglakhir;?>" class="next">Chart Ticket Status</a>
<hr />

<select id="myStatus" onchange="myStatus()">
    <?php
    if($status=='Invoiced'){
        echo'
        <option value="Paid_fully" selected>Paid fully</option>
          <option value="Invoiced" selected>Invoiced</option>';
    }else{
         echo'
         <option value="Paid_fully" selected>Paid_fully</option>
          <option value="Invoiced">Invoiced</option>';

    }
    ?>
</select>
<!--
<a href="<?php echo BaseURL() ;?>pie_chart_uw.php?team=<?php echo $team;?>" class="next">Pie &raquo;</a>-->
<div id="chartContainer"></div>
 <?php
ini_set('error_reporting',E_ALL);


if(empty($team)){
echo "Empty Parameter.\n";
            exit;
}else{
    

/*

        if (!$closed_successful OR !$open OR !$new OR !$unconfirmed_facultative OR !$assessment OR !$closed_unsuccessful ) {
            echo "An error occurred.\n";
            exit;
        }
*/

if($status=='Invoiced'){
            $Invoiced = pg_query($nextg_conn, "
            select DISTINCT on (concat(a.sales_number,';',a.revision_number)) a.sales_number,a.revision_number, a.sales_status as sales_status_now,b.sales_status,c.ticket_number,b.userid,c.ticket_type,b.actiontime from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
            where a.sales_status in('Invoiced')
            and b.sales_status ='Assessed'
            and c.ticket_type='Risk Approval'
            and b.userid in('dwi.prasetyo','trivina.setyawati','rini.aryani','lisbet')
             and b.actiontime::date >='$tglawal'
             and b.actiontime::date <='$tglakhir'
                        ORDER BY  concat(a.sales_number,';',a.revision_number),b.userid asc, b.actiontime desc")or die(pg_last_error($nextg_conn));

         echo '<table border="1">';
          echo '<tr>';
          echo '<th> no </th>';
            echo '<th> sales_number </th>';
            echo '<th> revision_number </th>';
            echo '<th> sales_status_now </th>';
            echo '<th> sales_status </th>';
            echo '<th> ticket_number </th>';
            echo '<th> userid </th>';
            echo '<th> ticket_type </th>';
            echo '<th> actiontime </th>';
         echo '</tr>';
         $x = 1;
         while ($row = pg_fetch_assoc($Invoiced)) {
          echo '<tr>';
          echo '<td>'.$x.'</td>';
           echo '<td>'.$row['sales_number'].'</td>';
           echo '<td>'.$row['revision_number'].'</td>';
           echo '<td>'.$row['sales_status_now'].'</td>';
           echo '<td>'.$row['sales_status'].'</td>';
           echo '<td>'.$row['ticket_number'].'</td>';
           echo '<td>'.$row['userid'].'</td>';
           echo '<td>'.$row['ticket_type'].'</td>';
           echo '<td>'.$row['actiontime'].'</td>';
          echo '</tr>';
          $x ++; 
         } 
          echo '</table>';
      }else {

       $Paid_fully = pg_query($nextg_conn, "
             select DISTINCT on (concat(a.sales_number,';',a.revision_number)) a.sales_number,a.revision_number, a.sales_status as sales_status_now,b.sales_status,c.ticket_number,b.userid,c.ticket_type,b.actiontime from tbl_so_sales_details as a
            join tbl_so_sales_tracker as b on a.sales_number=b.sales_number and a.revision_number=b.revision_number
            join tbl_helpdesk_integration as c on a.sales_number=c.sales_number and a.revision_number=c.revision_number
            where a.sales_status in('Paid fully')
            and b.sales_status ='Assessed'
            and c.ticket_type='Risk Approval'
            and b.userid in('dwi.prasetyo','trivina.setyawati','rini.aryani','lisbet')
             and b.actiontime::date >='$tglawal'
             and b.actiontime::date <='$tglakhir'
                        ORDER BY  concat(a.sales_number,';',a.revision_number),b.userid asc, b.actiontime desc")or die(pg_last_error($nextg_conn));
        echo '<table border="1">';
          echo '<tr>';
          echo '<th> no </th>';
            echo '<th> sales_number </th>';
            echo '<th> revision_number </th>';
            echo '<th> sales_status_now </th>';
            echo '<th> sales_status </th>';
            echo '<th> ticket_number </th>';
            echo '<th> userid </th>';
            echo '<th> ticket_type </th>';
            echo '<th> actiontime </th>';
         echo '</tr>';
         $x = 1;
         while ($row = pg_fetch_assoc($Paid_fully)) {
          echo '<tr>';
          echo '<td>'.$x.'</td>';
           echo '<td>'.$row['sales_number'].'</td>';
           echo '<td>'.$row['revision_number'].'</td>';
           echo '<td>'.$row['sales_status_now'].'</td>';
           echo '<td>'.$row['sales_status'].'</td>';
           echo '<td>'.$row['ticket_number'].'</td>';
           echo '<td>'.$row['userid'].'</td>';
           echo '<td>'.$row['ticket_type'].'</td>';
           echo '<td>'.$row['actiontime'].'</td>';
          echo '</tr>';
          $x ++; 
         } 
          echo '</table>';
      }



}//end else
//print_r($dataPoints1);
?>


<script>
function myStatus() {
  var tglawal = '<?php echo $tglawal;?>';
  var tglakhir = '<?php echo $tglakhir;?>';
  var team = '<?php echo $team;?>';
  var status = document.getElementById("myStatus").value;
 //alert (tglawal);
  var link='http://dashboard.asuransibintang.com/dashboard/chart/chart-types/table_uw_team3_3.php?team='+team;
    link +='&tglawal='+tglawal+'&tglakhir='+tglakhir+'&status='+status;
    var win = location.replace(link);
}
</script>


<?php include '../footer.php'; ?>
