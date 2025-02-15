<?php
    include("./pdo.php");

    require __DIR__ . '/../vendor/autoload.php';
    use \Firebase\JWT\JWT;

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Content-Type: application/json");

    $secret_key = "1bd90ca709008048f23b64dfe12fc92303cbb0fc";

    $email = isset($_GET["email"]) ? $_GET["email"] : "";
    $password = isset($_GET["pd"]) ? $_GET["pd"] : "";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $type = isset($_GET["type"]) ? $_GET["type"] : "";

    $status = "not ok";
    $message = "Invalid request";
    $jwt = null;
    $id = 0;

    if($type == "register"){
        $sql = "SELECT * FROM users WHERE email = :email";
        $statement = $pdo->prepare($sql);
        $statement->execute(["email" => $email]);
        $results = $statement->fetch();

        if($results){
            $message = "Email already exist";
        }
        else {
            $sql = "INSERT INTO users(email, password) VALUES(:email, :password)";
            $statement = $pdo->prepare($sql);
            $statement->execute(["email" => $email, "password" => $hashed_password]);
    
            $status = "ok";
            $message = "successfully logged in";
        }
    }
    else {
        $sql = "SELECT * FROM users WHERE email = :email";
        $statement = $pdo->prepare($sql);
        $statement->execute(["email" => $email]);
        $results = $statement->fetch();

        if($results){
            if(password_verify($password, $results["password"])){
                $status = "ok";
                $message = "successfully logged in";

                $payload = array(
                    "iss" => "http://localhost/film_review_react/backend/users.php",
                    "iat"=> time(),
                    "exp" => time() + 3600,
                    "data" => array (
                        "ID" => $results["ID"],
                        "email" => $results["email"]
                    )
                );

                $id = $results["ID"];
                $jwt = JWT::encode($payload, $secret_key, "HS256" );
                setcookie("jwt_token", $jwt, time() + 3600, "/", "", false, true);
            }
            else {
                $message = "Wrong password";
            }
        }
        else {
            $message = "Wrong email";
        }
    }

    $response = array(
        "token" => $jwt,
        "userID" => $id,
        "type" => $type,
        "status" => $status,
        "message" => $message
    );

    echo json_encode($response);
    exit;
?>
