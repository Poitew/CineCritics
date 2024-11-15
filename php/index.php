<?php
    
    include("pdo.php");
    include("load_movies.php");
    
    $moviesRow = array_slice($shuffledMovies, 0, 6);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineCritics - Reviewing movies since 2024</title>
    <meta name="description" content="Cincecritics, the best platform for reviewing movies of all kinds">
    <link rel="stylesheet" href="/film_review/assets/css/general.css">
    <link rel="stylesheet" href="/film_review/assets/css/header-footer.css">
    <link rel="stylesheet" href="/film_review/assets/css/index.css">
    <link rel="stylesheet" href="/film_review/assets/css/responsive.css">
</head>
<body>
    <?php include("header.php") ?>
    
    <div class="trending" style="background-image: url(<?= $moviesRow[0]["landscape_cover"] ?>);" >
        <div class="trending-info">
            <h1><?= $moviesRow[0]["title"] ?></h1>

            <p class="trending-description" ><?= $moviesRow[0]["movie_description"] ?></p>
            <p class="trending-director" ><?= $moviesRow[0]["director"] ?></p>

            <div class="reviews center">
                <a href="reviews.php?id=<?= $moviesRow[0]["id"] ?>">REVIEWS</a>
            </div>
            
        </div>
    </div>

    <div class="fan-favorites-title">
        <h2>Fan Favorites ></h2>
        <p>People love this..</p>
    </div>
    

    <div class="fan-favorites">
        
        <?php foreach ($moviesRow as $index => $movie): ?>
            <a href="reviews.php?id=<?= $movie["id"] ?>">
                <div class="movie">
                    <img src="<?= $movie['cover'] ?>" alt="Movie <?= $index + 1 ?>">
                    <div class="info">
                        <p class="movie-title"><?= $movie['title'] ?></p>
                        <p class="movie-director"><?= $movie["director"] ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>

    </div>

    <?php include("footer.php") ?>

    <script src="/film_review/assets/javascript/script.js"></script>
</body>
</html>