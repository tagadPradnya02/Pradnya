<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="register.css">
</head>

<body>
    <div class="background2">
        <form method="post">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $Fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $repassword = $_POST['repassword'];

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);


                $errors = array();
                if (empty($Fullname) or empty($email) or empty($password) or empty($repassword)) {
                    array_push($errors, "All Fields are required.");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid.");
                }
                if (strlen($password) < 8) {
                    array_push($errors, "Password must be at least 8 characters.");
                }
                if ($password !== $repassword) {
                    array_push($errors, "Passwords do not match.");
                }

                require_once "database.php";
                $sql = "SELECT * FROM register WHERE email_id ='$email' ";
                $result = mysqli_query($conn,$sql);
                $rowCount = mysqli_num_rows($result);
                if ($rowCount > 0){
                    array_push($errors,"This Email already exists");
                    }
                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<p style='color: white; background-color: red; padding: 10px;'>" . $error . "</p>";
                    }
                } else {

                    $sql = "INSERT INTO register(full_name,email_id,password) VALUES (?,?,?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt, "sss", $Fullname, $email, $passwordHash);
                        mysqli_stmt_execute($stmt);
                        echo '<p style="color: white;">You are registered successfully!</p>';


                    } else {
                        die("Something went wrong");
                    }
                }
            }

            ?>
            <div class="forminfo">

                <h2> Register Here ! !</h2>

                <input type="text" id="fullname" name="fullname" placeholder="Fullname:">


                <input type="email" id="email" name="email" placeholder="Email-Id" :>


                <input type="password" id="password" name="password" placeholder="Password:">


                <input type="password" id="repassword" name="repassword" placeholder="Re-Enter password:">

                <button type="submit" value="reg" name="submit">Register</button>
                <p>Already have an account?</p>
                <a href="login.php">Login here!</a>
            </div>

    </div>


</body>

</html>