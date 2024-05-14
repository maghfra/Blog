<?php
include_once './connection.php';
if (!isset($_SESSION['username'])) {
  header("Location: login.php"); 
  exit();
}
$sql = 'SELECT * FROM users';
$result = $conn->query($sql);
?>

<?php include_once './nav.php'?>
  <div class="container my-4">
    <a href="create.php"><button class="btn text-light my-3" style='background-color: #8993ff; margin-left:1100px;'>Create new user</button></a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Image</th>
          <th scope="col">name</th>
          <th scope="col">email</th>
          <th scope='col'>View</th>
          <th scope='col'>Update</th>
          <th scope='col'>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
              echo '<tr>';
              echo '<td>'.$row['id'].'</td>';
              echo "<td><img src='./images/users/{$row['image']}' alt='user image' width='150px' height='150px' style='border-radius:50% ;'></td>";
              echo '<td>'.$row['username'].'</td>';
              echo '<td>'.$row['email'].'</td>';
              echo "<td><button class='btn' style='background-color: #8993ff;'><a class='text-light' href='view.php?id={$row['id']}'> View</a></button></td>";
              echo "<td><button class='btn btn-warning'><a class='text-light' href='update.php?id={$row['id']}'> Update</a></button></td>";
              echo "<td><button class='btn btn-danger'><a class='text-light' href='delete.php?id={$row['id']}'> Delete</a></button></td>";
              echo '</tr>';
            }
          }
          else {
            echo "<tr><td colspan='3'>No records found</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
<?php include_once './footer.php'?>