const page = window.location.pathname;
const home_header = document.getElementById("Home");
const movie_header = document.getElementById("Movie-list");
const color = "#B04822"; // color for the page you are in


if(page === "/film_review/php/index.php"){
    home_header.style.color = color;
    movie_header.style.color = "#E9E0E0";
}
else if(page === "/film_review/php/movie_list.php"){
    home_header.style.color = "#E9E0E0";
    movie_header.style.color = color;
}
else {
    home_header.style.color = color;
    movie_header.style.color = color;
}