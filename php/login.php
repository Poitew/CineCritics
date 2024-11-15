<?php

    include("./pdo.php");
    require __DIR__ . '/../vendor/autoload.php';
    use \Firebase\JWT\JWT;

    $secret_key = "MyBeautifullDarkTwistedPassword";
    $is_logged_in = false;
    $is_email_used = false;
    $is_login_correct = true;

    // Login
    if(isset($_POST["login_submit"])){
        $email_login = filter_input(INPUT_POST, "email_login", FILTER_SANITIZE_EMAIL);
        $password_login = $_POST["password_login"];

        $sql = "SELECT ID, email, password FROM credenziali WHERE email = :email";
        $statement = $pdo->prepare($sql);
        $statement->execute(["email" => $email_login]);
        $result = $statement->fetch();

        if($result){
            if(password_verify($password_login, $result["password"])){
                $is_login_correct = true;
                
                // JWT Token Creation
                $payload = array(
                    "iss" => "http://localhost/film_review/php/login.php",
                    "iat"=> time(),
                    "exp" => time() + 3600,
                    "data" => array (
                        "ID" => $result["ID"],
                        "email" => $result["email"]
                    )
                );

                $jwt = JWT::encode($payload, $secret_key, "HS256" );
                setcookie("jwt_token", $jwt, time() + 3600, "/", "", true);

                $is_logged_in = true;
                setcookie("is_logged_in", $is_logged_in, time() + 3600, "/", "", true);
                
                header("Location: login.php");
                exit();
            }
            else {
                $is_login_correct = false;
            }
        }
    }

    // Register
    if(isset($_POST["register_submit"])){
        $email_register = filter_input(INPUT_POST, "email_register", FILTER_SANITIZE_EMAIL);
        $password_register = $_POST["password_register"];
        $hashed_password = password_hash($password_register, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM credenziali WHERE email = :email";
        $statement = $pdo->prepare($sql);
        $statement->execute(["email" => $email_register]);
        $result = $statement->fetch();

        if($result){
            $is_email_used = true;
        }
        else {
            $sql = "INSERT INTO credenziali(email, password) VALUES(:email, :password)";
            $statement = $pdo->prepare($sql);
            $statement->execute(["email" => $email_register, "password" => $hashed_password]);
        }
    }

    // Logout
    if(isset($_POST["logout"])){
        setcookie('jwt_token', '', time() - 3600, "/", "", true, true);
        setcookie("is_logged_in", '', time() - 3600, "/", "");

        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/film_review/assets/css/general.css">
    <link rel="stylesheet" href="/film_review/assets/css/header-footer.css">
    <link rel="stylesheet" href="/film_review/assets/css/login.css">
    <link rel="stylesheet" href="/film_review/assets/css/responsive.css">
</head>
<body>
    <?php include("header.php") ?>

    <div class="form-wrapper">
        <div class="login">
            <h2>Login</h2>
            <p><?= ($is_login_correct) ? "" : "<p>Email or Password not correct</p>" ?></p>

            <form action="login.php" method="post">
                <label for="email_login">
                    email <br/>
                    <input type="text" name="email_login" id="email_login">
                </label>

                <label for="password_login">
                    password <br/>
                    <input type="password" name="password_login" id="password_login">
                </label>

                <input type="submit" name="login_submit" value="Login">
            </form>
        </div>

        <div class="register">
            <h2>Register</h2>
            <?= ($is_email_used) ? "<p>Email already in use</p>" : "" ?>

            <form action="login.php" method="post">
                <label for="email_register">
                email <br/>
                    <input type="text" name="email_register" id="email_register">
                </label>

                <label for="password_register">
                    password <br/>
                    <input type="password" name="password_register" id="password_register">
                </label>

                <input type="submit" name="register_submit" value="Register">
            </form>
        </div>
    </div>

    <form id="logout" action="login.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

    <?php include("footer.php") ?>
    <script src="/film_review/assets/javascript/script.js"></script>
</body>
</html>