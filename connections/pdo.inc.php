<?php
error_reporting(13);

if ($_SERVER['SERVER_NAME'] != "localhost") {
  $hostname = "";
  $username = "";
  $password = "";
  $database = "";
} else {
  $hostname = "localhost";
  $username = "root";
  $password = "wordsofstone25";
  $port     = "8889";
  $database = "db_ledenadmin";
}
$_PDO = new PDO("mysql:host=$hostname;port=$port; dbname=$database", "$username", "$password");

$_PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
