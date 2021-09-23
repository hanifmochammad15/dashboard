<?php include '../header_new.php'; ?>
<?php //include '../sidebar.php'; ?>
<?php //include '../content.php'; ?>
<?php include '../koneksi.php'; ?>
<?php include '../nextg_koneksi.php'; ?>
<?php include '../sharia_koneksi.php'; ?>
<?php include '../koneksi_opp.php'; ?>
<?php $param=$_GET["team"]; ?>

<h1>Table Order Printing Polis  <select onchange="this.options[this.selectedIndex].row && (window.location = this.options[this.selectedIndex].row);">
    <option row="">Team <?php echo $param;?></option>
     <option row="<?php echo BaseURL() ;?>table.php?team=1">Team 1</option>
    <option row="<?php echo BaseURL() ;?>table.php?team=2">Team 2</option>
    <option row="<?php echo BaseURL() ;?>table.php?team=3">Team 3</option>
</select>
</h1>
<p>Date Awal: <input name="awal" type="text" id="datepickerawal" > - Date Akhir: <input name="akhir" type="text" id="datepickerakhir" ></p>
<hr />
 <?php
 error_reporting(0);
//ini_set('error_reporting',E_ALL);


if(empty($param)){
echo "Empty Parameter.\n";
            exit;
}else{
//echo $param;
        $get_ticket_team = pg_query($conn_opp, "
            SELECT
    b.user_login,b.ticket_number,c.sales_number,c.revision_number
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
                    C .tn AS ticket_number--COALESCE(count (user_login),0) as jumlah_ticket 
                FROM
                    teams AS A
                JOIN users AS b ON b. LOGIN = A .user_login
                JOIN ticket AS C ON C .user_id = b. ID
                JOIN ticket_state AS d ON d. ID = C .ticket_state_id
                WHERE
                    A .team_id = '$param'
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
                ticket_number VARCHAR
            )
    ) b
JOIN tbl_helpdesk_integration C USING (ticket_number)
LEFT JOIN tbl_log_order_printing_polis d ON C .sales_number = d.polis and c.revision_number=d.rev
WHERE
substr(c.sales_number, 4 ,3)not in ('187','417') AND
 b.ticket_number IS NOT NULL
AND C .sales_number IS NOT NULL
AND substr(c.sales_number, 1 ,1) <> 'Q'
AND d.param IS NULL
--GROUP BY
    --b.user_login")or die(pg_last_error($conn_opp));
    


        if (!$get_ticket_team) {
            echo "An error occurred.\n";
            exit;
        }

        


  echo "<table  border='1'>";
  echo " <th>No</th><th>Id</th><th>user_login</th><th>sales_number</th><th>revision_number</th>";
  $x = 1;
       while  ($row = pg_fetch_assoc($get_ticket_team)){ 
        echo '<tr>';
        echo '<td>'.$x.'</td>';
        echo '<td>'.$row['ticket_number'].'</td>';
        if(empty($row['user_login'])){
            echo '.<td></td>';
        }else{echo '<td>'.$row['user_login'].'</td>';}
        if(empty($row['sales_number'])){
            echo '.<td></td>';
        }else{echo '<td>'.$row['sales_number'].'</td>';}
        if(empty($row['revision_number'])){
            echo '.<td></td>';
        }else{echo '<td>'.$row['revision_number'].'</td>';}
        echo '</tr>';
            $x ++; 
         } 
          echo "</table>";

}
?>
<?php include '../footer.php'; ?>
