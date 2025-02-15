<?php
    include("./pdo.php");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Content-Type: application/json");

    $ID = isset($_GET["id"]) ? (int)$_GET["id"] : null;

    $status = "not ok";
    $message = "";
    $content = null;

    if(is_null($ID)){
        $message = "Invalid ID";
    }
    else {
        $sql = "SELECT * FROM reviews WHERE movieID = :ID";
        $statement = $pdo->prepare($sql);
        $statement->execute(["ID" => $ID]);
        $results = $statement->fetchAll();

        $status = "ok";
        $message = "no error";
        $content = $results;
    }

    $response = array(
        "status" => $status,
        "message" => $message,
        "content" => $content
    );

    echo json_encode($response);
    exit;
?>