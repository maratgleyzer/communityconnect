<?php

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);


$file_lines = file("literacy_model_blkgrp2.csv");

var_dump($file_lines);exit;




?>