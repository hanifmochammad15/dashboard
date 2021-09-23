<?php


$host = "10.11.23.29";
$port = "5432";
$dbname = "otrs";
$user = "otrs";
$password = "";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";
$conn_otrs_sd = pg_connect($connection_string);


?>