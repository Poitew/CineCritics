<?php

    include("load_movies.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineCritics - Full movie list</title>
    <link rel="stylesheet" href="/film_review/css/general.css">
    <link rel="stylesheet" href="/film_review/css/header-footer.css">
    <link rel="stylesheet" href="/film_review/css/movie_list.css">
</head>
<body>
    <?php include("header.php") ?>
    
    <div class="list">
        <?php foreach($movies as $index => $movie): ?>
            <a href="reviews.php?id=<?= $index ?>">
                <img src="<?= $movie["cover"] ?>" alt="Movie <?= $index ?>">
            </a>
        <?php endforeach; ?>
    </div>

    <?php include("footer.php") ?>
    <script src="/film_review/javascript/script.js"></script>
</body>
</html>