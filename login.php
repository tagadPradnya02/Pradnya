
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="backgroundd">
        <div class="login-container">

        <?php
                    require_once "database.php";
                if(isset($_POST['login'])){
                    $email=$_POST["emailid"];
                $password=$_POST["password"];


                $sql = "SELECT * FROM register WHERE email_id = '$email'";
                $result=mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
                if($user){
                    echo "user found ";
                    if (password_verify($password, $user['password'])) {
                        header("Location: home.php");
                        die();
                    }else{
                        echo "<p style='color:white; background-color:red;'>Invalid Password!</p>";

                        }

                }else{
                    echo "<p style='color:white; background-color:red;'>Email is invalid! </p>";
                }

            }  
                
                ?>
            <h1>Login</h1>
            <form action="login.php" method="POST">

                <div class="form-group">
                    <label for="email">EmailId:</label>
                    <input type="text" id="email" name="emailid">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="form-group">
                <button type="submit" name="login">Login</button>

                </div>
                <p>Don't have an account?</p>
                <a href="register.php">Register Here</a>
            </form>
        </div>
    </div>
</body>
</html>
