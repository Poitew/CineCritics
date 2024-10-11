<?php
    require __DIR__ . '/../vendor/autoload.php';
    use \Firebase\JWT\JWT;
    use \Firebase\JWT\Key;
    
    $secret_key = "MyBeautifullDarkTwistedPassword";

    $login = isset($_COOKIE["is_logged_in"]) ? $_COOKIE["is_logged_in"] : false;
    $JWT = isset($_COOKIE["jwt_token"]) ? $_COOKIE["jwt_token"] : null;
    $email = null;
    
    if($JWT){
        try {
            $decoded_jwt = JWT::decode($JWT, new Key($secret_key, "HS256"));
            $email = $decoded_jwt->data->email;
        } catch (Exception $e) {
            $email = "Errore JWT";
        }
    }
?>