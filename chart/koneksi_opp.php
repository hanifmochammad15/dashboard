<?php


$host = "10.11.23.24";
$port = "5432";
$dbname = "nextg_dei3";
$user = "leo";
$password = "leo";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";
$conn_opp = pg_connect($connection_string);


?>