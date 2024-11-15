<?php
    include("get_email.php");
?>
<header>
    <div class="company-logo">
        <a href="index.php">CineCritics</a>
    </div>

    <div class="search">
        <form action="search.php" method="get" >
            <input type="text" name="movie" placeholder="Search a movie" class="search-box" >
            <input type="submit" value="" class="submit-button" >
        </form>
    </div>

    <div class="home-header">
        <a id="Home" href="index.php">Home</a>
    </div>

    <div class="movie-list-header">
        <a id="Movie-list" href="movie_list.php">Movie List</a>
    </div>

    <a href="login.php" id="login-header"><?= ($login && $email) ? $email : "Login" ?></a> 
</header>