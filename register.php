<?php
include_once './connection.php';
if (isset($_POST['submit'])){
    $username = validate_data($_POST['username']);
    $email = validate_data($_POST['email']);
    $password = validate_data($_POST['password']);
    $repassword = validate_data($_POST['repassword']);
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
    if($password != $repassword){
        $errors['repassword']="password not match!";
    }

    $select = "SELECT * FROM users WHERE email='$email' ";
    $result = $conn->query($select);
    if(mysqli_num_rows($result) > 0){
        $errors['email'] = 'User already exists.';  
    }
    else{
        if($password != $repassword){
         $errors['repassword']="password not match!";
        }else {
            $stmt = $conn->prepare('INSERT INTO users (username,email,password,image) VALUES (?,?,?,?)');
            $stmt->bind_param("ssss",$username,$email,$password,$image_name);
            $stmt->execute();
            if(!move_uploaded_file($tmp_name,$folder)){
                echo "faild to upload image";
            }
            header('Location: login.php');
           exit();
        }
    }
}
function validate_data($data){
    $data=trim($data);
    $data=addslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body{
            background-color:rgb(242, 238, 238);
        }
        h1{
            margin-top: 90px;
            color: #93acff;
            text-align: center;
        }
        .container{
            margin-top: 25px;
            padding: 25px;
            background-color: #ffffff66;
            max-width: 800px;
            border-radius: 15px;
            box-shadow: 0 0 20px gray;
        }
        input[type="text"],
        input[type='email'],
        input[type='password']{
            outline: none;
            border: none;
            border-bottom: 2px solid #93acff;
            
        }
        label{
            color: #8993ff;
        }
        .btn{
            background-color: #8993ff; 
            color: #fff;
            border-radius: 10px;
        }
        .btn:hover{
            background-color: #93acff;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1><b>Registration</b><span style="color: 	#accbff;"> Form</span></h1>
    <div class="container my-4">
        <div class="row">
            <div class="col-6">
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
                        <label for="repassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="repassword" name="repassword">
                        <?php
                           if(!empty($errors["repassword"])) {
                               echo '<span class="text-danger">' . $errors["repassword"] . '</span>';
                            }
                       ?>
                      </div>
                      <div class="mb-3">
                        <label for="image" class="form-label">UPload Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                      </div>
                    <button type="submit" name="submit" class="btn my-3 w-100">Register</button>
                    <p style="color:#8993ff">Already have an account? <a href="login.php">Login now</a></p>
                  </form>
            </div>
            <div class="col-6">
                <img width="100%" height="100%" src="./images/r.png" alt="">
            </div>
        </div>
    </div>
    
</body>
</html>