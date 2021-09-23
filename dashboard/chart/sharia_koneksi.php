<?php


$host = "10.11.12.24";
$port = "5432";
$dbname = "nextg_sharia_v25";
$user = "fifoto";
$password = "azteca";
$pg_options = "--client_encoding=UTF8";


$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";
$sharia_conn = pg_connect($connection_string);


?>