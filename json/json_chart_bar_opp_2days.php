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

$branch_code="'".$_POST['branch_code']."'";

if($_POST['branch_code'] == '-'){
    $branch_code_2 = "'10','13','14','15','12'";
}else{
    $branch_code_2 = $branch_code;
}

}
if($_POST['bar_opp_2days']==1){
 // $tglawal='2020-01-01';
 // $tglakhir='2020-09-22';
 // $team=2;
        $get_ticket_team = pg_query($conn_opp, "SELECT cd.user_login,
COALESCE (COUNT(cd.user_login), 0) AS jumlah_ticket
from(
SELECT dc.*, (dc.date_order-dc.pemulih)as fix_date
from (
SELECT
    b.user_login,
        ticket_number,
        b.team_id,
        sales_number,
        revision_number,
        param,
        tgl_order,
                (SELECT count (*) FROM daging_tgl  where tgl >= (tgl_order::date)::text AND tgl <= (now()::date)::text)*24
                    as pemulih,
                CURRENT_DATE as tgl_skrang,
                ((extract (epoch from ( CURRENT_DATE::timestamp - tgl_order::timestamp ) ) ) )::integer/3600 as date_order,
        case when substr(polis,2,2) in ($branch_code_2) then
        'HO' else 'no_ho' end
        as tgl_ex,
        status_order
FROM
    (
        SELECT
            *
        FROM
            dblink (
                'host=10.11.12.84 user=postgres dbname=otrs2_4_201610',
                $$ SELECT
                    A .user_login,
                    C .tn AS ticket_number,
                    A.team_id::int
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
                ticket_number VARCHAR,
                                team_id int
            )
    ) b
JOIN tbl_helpdesk_integration C USING (ticket_number)
LEFT JOIN tbl_log_order_printing_polis d ON C.sales_number = d.polis and c.revision_number=d.rev
WHERE
    b.ticket_number IS NOT NULL
and C.waktu_kejadian is not null 
AND C .sales_number IS NOT NULL
AND substr(c.sales_number, 1 ,1) <> 'Q'
)as dc
WHERE 
dc.tgl_order not in ('2020-10-28','2020-10-29','2020-10-30')
and
(dc.status_order in ('NEW') or dc.param IS NULL)
and tgl_ex = 'HO'
) as cd
WHERE fix_date >= 48
GROUP BY cd.user_login")or die(pg_last_error($conn_opp));
    

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