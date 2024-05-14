<?php
session_start();

$servername='localhost';
$username='root';
$password='3468';
$dbname='study';

$conn = new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("connection faild...".$conn->connect_error);
}

?>