<?php
require('config_next.php');
$next = pg_connect("host=$hostname port=$port dbname=$database user=$username password=$password") or die("{success:false,message:'Could not connect to server $hostname'}");
?>