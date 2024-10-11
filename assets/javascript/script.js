const page = window.location.pathname;
const home_header = document.getElementById("Home");
const login_header = document.getElementById("login-header");
const movie_header = document.getElementById("Movie-list");


const active_color = "#B04822"; // color for the page you are in
const inactive_color = "#E9E0E0";


if(page === "/film_review/php/index.php" || page === "/film_review/php/"){
    home_header.style.color = active_color;
    movie_header.style.color = inactive_color;
    login_header.style.color = inactive_color;
}
if(page === "/film_review/php/movie_list.php"){
    home_header.style.color = inactive_color;
    movie_header.style.color = active_color;
    login_header.style.color = inactive_color;
}
if(page === "/film_review/php/login.php"){
    home_header.style.color = inactive_color;
    movie_header.style.color = inactive_color;
    login_header.style.color = active_color;
}