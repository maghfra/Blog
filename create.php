<?php
include_once './connection.php';
if (isset($_POST['submit'])){
    $username = validate_data($_POST['username']);
    $email = validate_data($_POST['email']);
    $password = validate_data($_POST['password']);
    $image_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $folder = './images/users/'.$image_name;

    $errors = [];
    if (strlen($username) < 2) {
        $errors["username"]="Invalid user name.";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Invaild Email.';
    }
    if (strlen($password) < 2) {
        $errors["password"]="Invalid password.";
    }

    $select = "SELECT * FROM users WHERE email='$email' ";
    $result = $conn->query($select);
    if(mysqli_num_rows($result) > 0){
        $errors['email'] = 'User already exists.';  
    } 
    else {
        $stmt = $conn->prepare('INSERT INTO users (username,email,password,image) VALUES (?,?,?,?)');
        $stmt->bind_param("ssss",$username,$email,$password,$image_name);
        $stmt->execute();
        if(!move_uploaded_file($tmp_name,$folder)){
            echo "faild to upload image";
        }
        header('Location: index.php');
        exit();
    }
}
function validate_data($data){
    $data=trim($data);
    $data=addslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}


?>
<?php include_once './nav.php'?>
   <div class="container my-4">
   <form method="post" action="#" enctype="multipart/form-data">
        <div class="mb-3">
           <label for="username" class="form-label">User Name</label>
            <input type="text" class="form-control" id="username" name="username">
            <?php
                if(!empty($errors["username"])) {
                    echo '<span class="text-danger">' . $errors["username"] . '</span>';
                }
            ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
            <?php
                if(!empty($errors["email"])) {
                    echo '<span class="text-danger">' . $errors["email"] . '</span>';
                }
            ?>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <?php
                if(!empty($errors["password"])) {
                    echo '<span class="text-danger">' . $errors["password"] . '</span>';
                }
            ?>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" name="submit" class="btn my-3 w-100" style="background-color: #8993ff;color: #fff;border-radius: 10px;">Add</button>
    </form>
   </div>
<?php include_once './footer.php'?>    