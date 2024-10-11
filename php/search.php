<?php
    include("load_movies.php");
    $movie_name = $_GET["movie"];
    $movieIndex = null;

    foreach($movies as $index => $movie) {
        if (strcasecmp($movie_name, $movie["title"]) == 0) {
            $movieIndex = $index + 1;
            break;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineCritics - search</title>
    <link rel="stylesheet" href="/film_review/assets/css/general.css">
    <link rel="stylesheet" href="/film_review/assets/css/header-footer.css">
    <link rel="stylesheet" href="/film_review/assets/css/search.css">
</head>
<body>
    <?php include("header.php") ?>

    <div class="results">
        <?php if ($movieIndex !== null): ?>
            <a href="reviews.php?id=<?= $movieIndex ?>"><img src="<?= $movies[$movieIndex - 1]["cover"] ?>" alt="<?= $movies[$movieIndex - 1]["title"] ?>"></a>
        <?php else: ?>
            <p>Movie not found</p>
        <?php endif; ?>
    </div>

    <?php include("footer.php") ?>
</body>
</html>
