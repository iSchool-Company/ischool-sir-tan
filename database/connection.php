<?php

$serverName = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'ischool_temp';

$connection = new mysqli($serverName, $dbUsername, $dbPassword, $dbName);

if ($connection->connect_error) {

  die('Failed to connect!');
} else {

  mysqli_set_charset($connection, 'utf8');
  date_default_timezone_set('Asia/Manila');
}
