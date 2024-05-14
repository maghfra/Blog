<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
      body{
            background-color:rgb(242, 238, 238);
        }
        nav{
          background-color:#93acff;
        }
        .navbar-brand{
          margin-left: 100px;
          color: #fff;
        }
        .name{
          margin-left: 860px;
        }
        a{
          text-decoration: none;
        }
    </style>
</head>
<body>
<nav class="navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <i class="fa-solid fa-user-tie"></i>
      Users Demo
    </a>
    <div class="name">
      <?php
        echo "<img src='./images/users/{$_SESSION['image']}' alt='user image' width='50px' height='50px' style='border-radius:50% ;'>";
        echo "<span style='font-size:16px; color:#fff; font-weight: 700;' class='mx-2'>{$_SESSION['username']} </span>";
      ?>
    </div>
      <form action="logout.php" method="post">
        <button type="submit" class="btn" style="margin-right: 150px; border: 2px solid #fff; color:#fff">Logout</button>
      </form>
  </div>
</nav>
</body>
</html>
