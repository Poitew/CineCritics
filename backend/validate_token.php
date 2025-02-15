<?php
    require __DIR__ . '/../vendor/autoload.php';
    use \Firebase\JWT\JWT;
    use \Firebase\JWT\Key;

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Authorization, Content-Type");
    header("Access-Control-Allow-Credentials: true");

    $secret_key = "1bd90ca709008048f23b64dfe12fc92303cbb0fc";

    $headers = apache_request_headers();

    if (!isset($headers['Authorization'])) {
        echo json_encode(["status" => "error", "message" => "No token"]);
        exit();
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);

    try {
        $decoded = JWT::decode($token, new Key($secret_key, "HS256"));
        echo json_encode(["status" => "ok", "message" => "Token not valid"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Token expired"]);
        http_response_code(401);
        exit();
    }
?>