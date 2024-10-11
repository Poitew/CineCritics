<?php
    include("pdo.php");
    include("load_movies.php");
    include("get_email.php");

    $movieID = $_GET["id"];
    $movieIndex = $mappedMovies[$movieID];
    

    // Get all Reviews
    $sql = "SELECT * FROM reviews WHERE movie_id = :movieID";
    $statement = $pdo->prepare($sql);
    $statement->execute(["movieID" => $movieID]);
    $movie_reviews = $statement->fetchAll();

    // New Review Form Logic
    if(isset($_POST["submit-button"])){
        $review = filter_input(INPUT_POST, "review", FILTER_SANITIZE_SPECIAL_CHARS);
        if(!empty($review)){
            $sql = "INSERT INTO reviews(movie_id, review, email) VALUES(:movieID, :review, :email)";
            $statement_review = $pdo->prepare($sql);
            $statement_review->execute(["movieID" => $movieID, "review" => $review, "email" => $email]);

            header("Location: reviews.php?id=$movieID");
            exit();
        }
    }

    // Delete Button Logic 
    if(isset($_POST["delete-button"])){
        $reviewID = $_POST["review_ID"];
        $sql = "DELETE FROM reviews WHERE id = :reviewID AND email = :email";
        $statement = $pdo->prepare($sql);
        $statement->execute(["reviewID" => $reviewID, "email" => $email]);

        header("Location: reviews.php?id=$movieID");
        exit();
    }

    // Review Change Logic
    if(isset($_POST["modify-button"])){
        
        $reviewID = $_POST["review_ID"];
        $new_review = filter_input(INPUT_POST, "modify-input", FILTER_SANITIZE_SPECIAL_CHARS);
    
        // Update the review only if the email is the same as the logged in user
        $sql = "UPDATE reviews SET review = :new_review WHERE id = :reviewID AND email = :email";
        $statement = $pdo->prepare($sql);
        $statement->execute(["new_review" => $new_review, "reviewID" => $reviewID, "email" => $email]);

        header("Location: reviews.php?id=$movieID");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineCritics - Reviews</title>
    <link rel="stylesheet" href="/film_review/assets/css/general.css">
    <link rel="stylesheet" href="/film_review/assets/css/header-footer.css">
    <link rel="stylesheet" href="/film_review/assets/css/reviews.css">
</head>
<body>
    <?php include("header.php") ?>

    <!-- Decoration -->
    <div class="main" style="background-image: url(<?= $movies[$movieIndex]["landscape_cover"] ?>);">
        <img src="<?= $movies[$movieIndex]["cover"] ?>" alt="Movie <?= $movieIndex ?>">
        <div class="main-info">
            <h1><?= $movies[$movieIndex]["title"] . " - " . $movies[$movieIndex]["director"] ?></h1>
            <p><?= $movies[$movieIndex]["movie_description"] ?></p>
        </div>
    </div>
    
    <!-- New Review Form -->
    <div class="reviews-form" >
        <form action="reviews.php?id=<?= $movieID ?>" method="post">
            <input type="text" name="review" placeholder="Write a review" class="search-box" >
            <input type="submit" value="" class="submit-button" name="submit-button" >
        </form>
    </div>
    
    <!-- Review -->
    <ul>
        <?php foreach($movie_reviews as $review): ?>
            <li id="review" >
                <?= $review["email"] ?> <br/>
                <?= $review["review"] ?> <!-- Review Text -->
                <!-- Delete Form -->
                <form action="reviews.php?id=<?= $movieID ?>" method="post">
                    <input type="hidden" name="review_ID" value="<?= $review['id'] ?>">
                    <input type="submit" value="Delete" name="delete-button">
                </form>

                <!-- Modify Review Form -->
                <form action="reviews.php?id=<?= $movieID ?>" method="post">
                    <input type="hidden" name="review_ID" value="<?= $review['id'] ?>">
                    <input type="text" name="modify-input">
                    <input type="submit" value="Modify" name="modify-button">
                </form>
            </li>
            
        <?php endforeach; ?>
    </ul>

    <?php include("footer.php") ?>
</body>
</html>