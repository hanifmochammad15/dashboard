<?php
require('config_meas.php');
$meas = pg_connect("host=$hostname port=$port dbname=$database user=$username password=$password") or die("{success:false,message:'Could not connect to server $hostname'}");
?>