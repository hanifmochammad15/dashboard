
<?php include '../chart/connection_measurement.php'; ?>

<?php
 error_reporting(0);
if($_POST['bar_cp']==1){


$query_read= pg_query($meas, "select  case when bulan='January' then 1
when bulan='February'  then 2
when bulan='March'  then 3
when bulan='April'  then 4
when bulan='May'  then 5
when bulan='June'  then 6
when bulan='July'  then 7
when bulan='August'  then 8
when bulan='September'  then 9
when bulan='October'  then 10
when bulan='November'  then 11
when bulan='December'  then 12
end as urut_bulan,
 * from dashboard_cp 
where id_batch=(select id_batch from  batch_dashboard_cp order by tanggal desc limit 1
)
 order by tahun,urut_bulan;")or die(pg_last_error($meas));

//print_r($query_read);
// $query_read_2= pg_query($nextg_conn, "select  case when bulan='January' then 1
// when bulan='February'  then 2
// when bulan='March'  then 3
// when bulan='April'  then 4
// when bulan='May'  then 5
// when bulan='June'  then 6
// when bulan='July'  then 7
// when bulan='August'  then 8
// when bulan='September'  then 9
// when bulan='October'  then 10
// when bulan='November'  then 11
// when bulan='December'  then 12
// end as urut_bulan,
//  * from(
// select '2019' as tahun,'January' as bulan,2686 as jum_polis
// union
// select '2019' as tahun,'February' as bulan,5296 as jum_polis
// union
// select '2019' as tahun,'March' as bulan,3456 as jum_polis
// union
// select '2019' as tahun,'April' as bulan,5674 as jum_polis
// union
// select '2019' as tahun,'May' as bulan,3456 as jum_polis
// union
// select '2019' as tahun,'June' as bulan,4567 as jum_polis
// union
// select '2019' as tahun,'July' as bulan,5675 as jum_polis
// union
// select '2019' as tahun,'August' as bulan,7656 as jum_polis
// union
// select '2019' as tahun,'September' as bulan,6654 as jum_polis
// union
// select '2019' as tahun,'October' as bulan,7754 as jum_polis
// union
// select '2019' as tahun,'November' as bulan,5467 as jum_polis
// union
// select '2019' as tahun,'December' as bulan,6768 as jum_polis
// union
// select '2020' as tahun,'January' as bulan,7685 as jum_polis
// union
// select '2020' as tahun,'February' as bulan,2344 as jum_polis
// union
// select '2020' as tahun,'March' as bulan,3454 as jum_polis
// union
// select '2020' as tahun,'April' as bulan,4656 as jum_polis
// union
// select '2020' as tahun,'May' as bulan,2356 as jum_polis
// union
// select '2020' as tahun,'June' as bulan,5678 as jum_polis
// union
// select '2020' as tahun,'July' as bulan,4566 as jum_polis
// union
// select '2020' as tahun,'August' as bulan,7775 as jum_polis
// union
// select '2020' as tahun,'September' as bulan,4567 as jum_polis
// union
// select '2020' as tahun,'October' as bulan,4567 as jum_polis
// ) as table_coba order by tahun,urut_bulan;
// ")or die(pg_last_error($nextg_conn));


// $query_read = pg_query($nextg_conn, "select tahun,to_char(to_timestamp(bulan,'MM'),'Month') as bulan, sum(jum_polis) as jum_polis from (
// select substring(period,1,4) as tahun, case when substring(period,6,2) = '13' then '12' else substring(period,6,2) end as bulan, count(distinct d.sales_number||d.revision_number) as jum_polis from(
// select distinct sales_number,revision_number from tbl_so_sales_tracker
// where dbaction in ('INSERT','UPDATE') and actiontime between ('01-01-'||(extract('year' from current_date)-1)::varchar)::date and current_date
// and substring(sales_number,4,3) not in ('463','469') and userid in (select distinct userid from adm_userrole_rel2 where rolename = 'mr_ps')
// ) as a 
// join view_daily_production as d using(sales_number,revision_number)
// group by tahun,bulan
// ) as a where tahun in ((extract('year' from current_date)-1)::varchar,(extract('year' from current_date))::varchar) and bulan::integer <= extract('month' from current_date)
// group by tahun,bulan;")or die(pg_last_error($nextg_conn));

$query_year = pg_query($meas, "
select (extract('year' from current_date)) as year_now ,(extract('year' from current_date)-1) as year_prev; ")or die(pg_last_error($meas));
 while ($row = pg_fetch_assoc($query_year)) {
    $year_now=$row['year_now'];
    $year_prev=$row['year_prev'];
 } 
 $yp=0;
 $yn=0;
 $x=0;
 while ($row = pg_fetch_assoc($query_read)) {
 	if($row['tahun']==$year_prev){
    	$dataPoints[$year_prev][$yp] = array( 
	        'label'=>$row['bulan'] , 
	        'y'=>(int)$row['jum_polis'],
	        );
	      $yp ++; 
 	 }else{
    	$dataPoints[$year_now][$yn] = array( 
	        'label'=>$row['bulan'] , 
	        'y'=>(int)$row['jum_polis'],
	        );
	      $yn ++; 
 	 }
 	 $x++;
 } 


header('Content-Type: application/json');
echo json_encode($dataPoints);
}
 ?>
