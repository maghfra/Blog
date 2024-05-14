<?php
include_once './connection.php';

$id = $_GET['id'];

if (isset($_POST['submit'])) {
    $username = validate_data($_POST['username']);
    $email = validate_data($_POST['email']);
    $password = validate_data($_POST['password']);

    $errors = [];

    if (strlen($username) < 2) {
        $errors["username"] = "Invalid user name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid Email.';
    }
    if (strlen($password) < 2) {
        $errors["password"] = "Invalid password.";
    }

    $update_fields = "username='$username', email='$email', password='$password'";

    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $folder = './images/users/' . $image_name;

        if (!move_uploaded_file($tmp_name, $folder)) {
            echo "Failed to upload image";
        } else {
            $update_fields .= ", image='$image_name'";
        }
    }

    $sql = "UPDATE users SET $update_fields WHERE id=$id";
    $result = $conn->query($sql);

    if ($result) {
        echo "Data updated to the database";
        header("location: index.php");
        exit(); // Important to prevent further execution
    } else {
        echo "<script>alert('Data didn't save to the database.')</script>";
    }
}

$select = "SELECT * FROM users WHERE id='$id'";
$result = $conn->query($select);
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
}

function validate_data($data)
{
    $data = trim($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<?php include_once './nav.php'?>
   <div class="container my-4">
        <form method="post" action="#" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="username" class="form-label">User Name</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['username']; ?>">
                <?php
                   if(!empty($errors["username"])) {
                        echo '<span class="text-danger">' . $errors["username"] . '</span>';
                    }
                ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $data['email']; ?>">
                <?php
                    if(!empty($errors["email"])) {
                        echo '<span class="text-danger">' . $errors["email"] . '</span>';
                    }
                ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $data['password']; ?>">
                <?php
                    if(!empty($errors["password"])) {
                        echo '<span class="text-danger">' . $errors["password"] . '</span>';
                    }
                ?>
            </div>
            <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if (!empty($data['image'])): ?>
                <img src="./images/users/<?php echo $data['image']; ?>" alt="Previous Image" width="250px" height="250px" class="mt-3">
            <?php endif; ?>
        </div>

            <button type="submit" name="submit" class="btn my-3 w-100" style="background-color: #8993ff;color: #fff;border-radius: 10px;">Update</button>
        </form>
    </div>
<?php include_once './footer.php'?>    