<?php

$serverName = 'eyw6324oty5fsovx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
$dbUsername = 'ypukfa5dwp20pcwh';
$dbPassword = 'd0cxqu0wdu0mhlr4';
$dbName = 'mw8wu1416wd1n7ke';

$connection = new mysqli($serverName, $dbUsername, $dbPassword, $dbName);

if ($connection->connect_error) {

  die('Failed to connect!');
} else {

  mysqli_set_charset($connection, 'utf8');
  date_default_timezone_set('Asia/Manila');
}
