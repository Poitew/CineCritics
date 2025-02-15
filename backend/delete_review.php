<?php 
    include("./pdo.php");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Content-Type: application/json");

    $ID = isset($_GET["id"]) ? $_GET["id"] : null;
    $status = "not ok";
    $message = "";

    if(is_null($ID)){
        $message = "ID is null";
    }
    else {
        $sql = "DELETE FROM reviews WHERE ID = :ID";
        $statement = $pdo->prepare($sql);
        $statement->execute(["ID" => $ID]);

        $status = "ok";
        $message = "Review deleted successfully";
    }

    $response = array(
        "status" => $status,
        "message" => $message
    );

    echo json_encode($response);
?>