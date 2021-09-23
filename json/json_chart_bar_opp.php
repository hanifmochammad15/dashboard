<?php include '../chart/koneksi.php'; ?>
<?php include '../chart/nextg_koneksi.php'; ?>
<?php include '../chart/sharia_koneksi.php'; ?>
<?php include '../chart/koneksi_opp.php'; ?>

 <?php
 error_reporting(0);
//ini_set('error_reporting',E_ALL);

if( !empty($_POST['tglawal']) AND !empty($_POST['tglakhir'])){
$tglawal=$_POST['tglawal'];
$tglakhir=$_POST['tglakhir'];
$team=$_POST['team'];
}
if($_POST['bar_opp']==1){
 // $tglawal='2020-01-01';
 // $tglakhir='2020-09-22';
 // $team=2;
        $get_ticket_team = pg_query($conn_opp, "SELECT
    b.user_login,
    COALESCE (COUNT(b.user_login), 0) AS jumlah_ticket
FROM
    (
        SELECT
            *
        FROM
            dblink (
                'host=10.11.12.84 user=postgres dbname=otrs2_4_201610',
                $$ SELECT
                    A .user_login,
                    C .tn AS ticket_number --COALESCE(count (user_login),0) as jumlah_ticket 
                FROM
                    teams AS A
                JOIN users AS b ON b. LOGIN = A .user_login
                JOIN ticket AS C ON C .user_id = b. ID
                JOIN ticket_state AS d ON d. ID = C .ticket_state_id
                WHERE
                    A .team_id = $team
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
 and C.waktu_kejadian is not null 
AND C .sales_number IS NOT NULL
AND substr(c.sales_number, 1 ,1) <> 'Q'
AND d.param IS NULL
GROUP BY
    b.user_login")or die(pg_last_error($conn_opp));
    

$team_user_login = pg_query($conn, "select user_login from teams where team_id='$team' and level_user=1 and status_user=1 order by user_login asc")or die(pg_last_error($conn));

$array2=pg_fetch_all($team_user_login);
$array=pg_fetch_all($get_ticket_team);
$jumlah_ticket = 0;
$x=0;
foreach ($array2 as $key => $row) {

    foreach ($array as $key => $value) {
        //echo  $value['user_login'].'-'.$value['jumlah_ticket'];
        if($value['user_login'] == $row['user_login']){
             $jumlah_ticket = $value['jumlah_ticket'];
        }

    }
        $dataPoints[$x]['opp']= array( 
                        'label'=>$row['user_login'] , 
                        'y'=>intval($jumlah_ticket),
                        );

        $x++;
        $jumlah_ticket=0;
}


header('Content-Type: application/json');
echo json_encode($dataPoints);


}
?>

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