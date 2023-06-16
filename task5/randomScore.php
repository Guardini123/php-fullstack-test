<?php
    $startValue = $_GET['startValue'];
    $endValue = $_GET['endValue'];

    $res = rand($startValue, $endValue);
    echo $res;
?>