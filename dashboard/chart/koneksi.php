<?php


$host = "10.11.12.84";
$port = "5432";
$dbname = "otrs2_4_201610";
$user = "radit";
$password = "radit";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";
$conn = pg_connect($connection_string);


?>