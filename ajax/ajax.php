<?php
require('controller/FilmController.php');
$FC = new FilmController();
if (isset($_GET["filmId"])) {
    $FC->allTranslationLanguages(intval($_GET["filmId"]));
}

if (isset($_GET["languagesFilmId"])) {
    $FC->usedTranslationLanguages(intval($_GET["languagesFilmId"]));
}

if (isset($_GET["editFilmId"]) && isset($_GET["languageId"])) {
    $film = $FC->getFilm(intval($_GET["editFilmId"]), intval($_GET["languageId"]));
    $xFilm = array("name" => $film->name, "price" => $film->price, "genreId" => $film->genreId, "description" => $film->description, "trailer" => $film->trailer, "duration" => $film->duration, "releaseDate" => $film->releaseDate, "cinemaDate" => $film->cinemaDate);
    echo json_encode($xFilm);
}

if (isset($_GET["genreId"])) {
    $FC->allGenresCB(intval($_GET["genreId"]));
}
