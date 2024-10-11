<?php
    include("get_email.php");
?>
<header>
    <a href="index.php">
        <div class="company-logo">
            <p>CineCritics</p>
        </div>
    </a>

    <div class="search">
        <form action="search.php" method="get" >
            <input type="text" name="movie" placeholder="Search a movie" class="search-box" >
            <input type="submit" value="" class="submit-button" >
        </form>
    </div>

    <a href="index.php">
        <div class="home-header">
            <p id="Home" >Home</p>
        </div>
    </a>

    <a href="movie_list.php">
        <div class="movie-list-header">
            <p id="Movie-list" >Movie List</p>
        </div>
    </a>

    <a href="login.php" id="login-header"><?= ($login && $email) ? $email : "Login" ?></a>
    
</header>