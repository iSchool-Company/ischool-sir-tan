<?php

$server_name = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'ischool_temp';

$connection = new mysqli($server_name, $db_username, $db_password, $db_name);

if ($connection->connect_error) {

  die('Failed to connect!');
} else {

  mysqli_set_charset($connection, 'utf8');
  date_default_timezone_set('Asia/Manila');
}
