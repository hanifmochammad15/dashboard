<?php

$today = date("Y-m-d H:i:s");
echo $today;
echo '<br>';
echo strtotime($today)- strtotime(0)
?>