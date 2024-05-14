<?php
include_once './connection.php';

if (isset($_POST['submit'])) {
    $email = validate_data($_POST['email']);
    $password = validate_data($_POST['password']);
    $error = [];


    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (empty($email) || empty($password)) {
            $error[] = 'Email and password are required!';
        } else {    
        if ($password == $row['password'] && $email == $row['email']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['image'] = $row['image'];
            header("location: index.php");
            exit();
        } else {
            $error[] = 'Invalid email or password!';
        }
    }
    } else {
        $error[] = 'Invalid email or password!';
    }
}

function validate_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
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
    <h1><b>Login</b><span style="color:#accbff;"> Form</span></h1>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <img width="100%" src="./images/r.png" alt="">
            </div>
            <div class="col-6 mt-5">
                <form method="post" action="">
                  <?php
                        if(isset($error)){
                            foreach($error as $error){
                                echo '<div class="alert alert-danger w-100">'.$error.'</div>';
                            }
                        }
                    ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" >
                    </div>
                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" id="password" name="password" >
                    </div>
                    <button type="submit" class="btn my-3 w-100" name="submit">Login</button>
                    <p style="color:#8993ff">You Don't have an account? <a href="register.php">Register now</a></p>
                  </form>
            </div>
        </div>
    </div>
</body>
</html>
