<?php 
    include("./pdo.php");

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Content-Type: application/json");

    $ID         = isset($_GET["id"])        ? (int)$_GET["id"]      : null;
    $movie_ID   = isset($_GET["movieID"])   ? (int)$_GET["movieID"] : null;
    $user_ID    = isset($_GET["userID"])    ? (int)$_GET["userID"]  : null;
    $review     = isset($_GET["review"])    ? $_GET["review"]       : null;
    $type       = isset($_GET["type"])      ? $_GET["type"]         : null;

    $status  = "not ok";
    $message = "Something went wrong";

    if(isset($movie_ID, $user_ID, $review, $type)){
        if($type == "new"){
            $sql = "INSERT INTO reviews(movieID, userID, review) VALUES(:movieID, :userID, :review)";
            $statement = $pdo->prepare($sql);
            $statement->execute(["movieID" => $movie_ID, "userID" => $user_ID, "review" => $review]);
    
            $status = "ok";
            $message = "Review successfully submitted";
        }
        else if($type == "change"){
            $sql = "UPDATE reviews SET review = :review WHERE ID = :ID";
            $statement = $pdo->prepare($sql);
            $statement->execute(["review" => $review, "ID" => $ID]);
    
            $status = "ok";
            $message = "Review successfully updated";
        }
        else {
            $message = "Bad request";
        }
    }

    $response = array(
        "status" => $status,
        "message" => $message
    );

    echo json_encode($response);
    exit;
?>