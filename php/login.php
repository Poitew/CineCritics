<?php

    include("./pdo.php");
    require __DIR__ . '/../vendor/autoload.php';
    use \Firebase\JWT\JWT;

    $secret_key = "MyBeautifullDarkTwistedPassword";
    $is_logged_in = false;

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
                
                // Crazione Token JWT
                $payload = array(
                    "iss" => "http://localhost/film_review/php/login.php",
                    "iat"=> time(),
                    "exp" => time() + 3600,
                    "data" => array(
                        "ID" => $result["ID"],
                        "email" => $result["email"]
                    )
                );

                $jwt = JWT::encode($payload, $secret_key, "HS256" );
                setcookie("jwt_token", $jwt, time() + 3600, "/", "", true, true);

                $is_logged_in = true;
                setcookie("is_logged_in", $is_logged_in, time() + (86400 * 30), "/");

                header("Location: login.php");
                exit();
            }
        }
    }

    // Register
    if(isset($_POST["register_submit"])){
        $email_register = filter_input(INPUT_POST, "email_register", FILTER_SANITIZE_EMAIL);
        $password_register = $_POST["password_register"];

        $hashed_password = password_hash($password_register, PASSWORD_DEFAULT);

        $sql = "INSERT INTO credenziali(email, password) VALUES(:email_register, :hashed_password)";
        $statement = $pdo->prepare($sql);
        $statement->execute(["email_register" => $email_register, "hashed_password" => $hashed_password]);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/film_review/assets/css/general.css">
    <link rel="stylesheet" href="/film_review/assets/css/header-footer.css">
    <link rel="stylesheet" href="/film_review/assets/css/login.css">
</head>
<body>
    <?php include("header.php") ?>

    <div class="form-wrapper">
        <div class="login">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <label for="email_login">
                    email <br/>
                    <input type="text" name="email_login" id="email_login">
                </label>

                <br/>

                <label for="password-login">
                    password <br/>
                    <input type="password" name="password_login" id="password_login">
                </label>

                <input type="submit" name="login_submit" value="Login">
            </form>
        </div>

        <div class="register">
            <h2>Register</h2>
            <form action="login.php" method="post">
                <label for="email-register">
                email <br/>
                    <input type="text" name="email_register" id="email_register">
                </label>

                <br/>

                <label for="password_register">
                    password <br/>
                    <input type="password" name="password_register" id="password_register">
                </label>

                <input type="submit" name="register_submit" value="Register">
            </form>
        </div>
    </div>
    
    <?php include("footer.php") ?>
    <script src="/film_review/assets/javascript/script.js"></script>
</body>
</html>