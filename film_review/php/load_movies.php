<?php

    include("pdo.php");

    try {
        $statement = $pdo->query("SELECT * FROM movies");
        $movies = $statement->fetchAll();
        $shuffledMovies = $movies;
        shuffle($shuffledMovies);

        $mappedMovies = [];
        foreach ($movies as $index => $movie) {
            $mappedMovies[$movie['id']] = $index;
        }

        $statement2 = $pdo->query("SELECT * FROM reviews");
        $reviews = $statement2->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

?>