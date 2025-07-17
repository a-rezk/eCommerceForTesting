<?php

  $dsn = 'mysql:host=localhost;dbname=shop';
  $username = 'root';
  $pass = '';
  $opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

  ];

try{
  $con = new PDO($dsn, $username, $pass, $opt);
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e){
  echo 'Failed ' . $e;
}