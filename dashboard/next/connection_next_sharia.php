<?php
require('config_next_sharia.php');
$next_sharia = pg_connect("host=$hostname port=$port dbname=$database user=$username password=$password") or die("{success:false,message:'Could not connect to server $hostname'}");
?>