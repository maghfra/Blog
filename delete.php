<?php
include_once './connection.php';

$id = $_GET['id'];
$sql = "DELETE FROM users WHERE id = $id";
$result = $conn->query($sql);

if ($_SESSION['user_id'] == $id) {
    session_unset();
    session_destroy();
    header("location: login.php");
    exit();
} else {
    header("location: index.php");
    exit();
}
?>
