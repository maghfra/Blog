<?php
include_once './connection.php';
if (!isset($_SESSION['username'])) {
  header("Location: login.php"); 
  exit();
}
$id = $_GET['id'];
$sql = "select * from users where id=$id";
$data = $conn->query($sql);
$result = $data->fetch_assoc();
?>
<style>
  li{
    background-color: #d9d9d9;
    padding: 10px;
    margin-bottom: 5px;
    border-radius: 5px;
    text-align:center;
  }
</style>
<?php include_once './nav.php'?>
  <div class="container my-4">
    <ul style="list-style-type: none; padding: 0; margin: auto; width:50%;">
      <?php
      echo "<li><strong>Username: </strong>{$result['username']}</li>";
      echo "<li><strong>Email: </strong>{$result['email']}</li>";
      if (!empty($result['image'])) {
        echo "<li><img src='./images/users/{$result['image']}' alt='user image' width='90%'; height='250px';></li>";
      }
      ?>
    </ul>
  </div>
<?php include_once './footer.php'?>