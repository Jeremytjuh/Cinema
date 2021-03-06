<?php
require('controller/FilmController.php');
$FC = new FilmController();
$FC->startSession();

if (!$FC->checkLogin()) {
    header("Location: login.php");
}

if (isset($_POST["btnSubmit"])) {
    $postArray = array("txtName", "txtPrice", "cbGenre", "txtDescription", "txtTrailer", "txtDuration", "dpReleaseDate", "dpCinemaDate", "cbLanguage");
    $isEmpty = false;

    foreach ($postArray as $v) {
        if (empty($_POST[$v])) {
            $isEmpty = true;
        }
    }

    if (($_FILES["imgPoster"]["size"] == 0 && $_FILES["imgPoster"]["error"] != 0) && ($_FILES["imgBackground"]["size"] == 0 && $_FILES["imgBackground"]["error"] != 0)) {
        $isEmpty = true;
    }

    if ($isEmpty) {
        echo "<script>alert('Voer alle velden in!')</script>";
    } else {
        $FC->addFilm($_POST["txtName"], $_POST["txtPrice"], $_POST["cbGenre"], $_POST["txtDescription"], $_POST["txtTrailer"], $_POST["txtDuration"], file_get_contents(($_FILES["imgPoster"]["tmp_name"])), file_get_contents(($_FILES["imgBackground"]["tmp_name"])), $_POST["dpReleaseDate"], $_POST["dpCinemaDate"], $_POST["cbLanguage"]);
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>JereMovies - Film Toevoegen</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php"><span class="logocolors">J</span>ere<span class="logocolors">M</span>ovies</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="films.php">Films</a>
                </li>
                <?php
                if ($FC->checkAdmin()) {
                ?>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin <span class="sr-only">(current)</span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">
                            <a class="dropdown-item" href="addFilm.php">Film toevoegen</a>
                            <a class="dropdown-item" href="editFilm.php">Film bewerken</a>
                            <a class="dropdown-item" href="addTranslation.php">Vertaling toevoegen</a>
                            <a class="dropdown-item" href="register.php">Nieuw account registreren</a>
                        </div>
                    </li>
                <?php
                }
                ?>
            </ul>
            <ul class="navbar-nav mt-2 mt-lg-0">
                <li class="nav-item">
                    <?php
                    if (!$FC->checkLogin()) {
                    ?>
                        <a class="nav-link" href="login.php">Login</a>
                    <?php
                    } else {
                    ?>
                        <a class="nav-link" href="logout.php">Log out</a>
                    <?php
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Form voor het invoeren van een film -->
    <header id="logobg">
        <div class="container">
            <div class="col-md-12 filminfobackground" style="min-height: 115vh; z-index: 50; padding-bottom: 2vh;">
                <form method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                        <label for="txtName">Name:</label>
                        <input type="text" class="form-control" name="txtName" id="txtName">
                    </div>
                    <div class="form-group">
                        <label for="txtPrice">Price:</label>
                        <input type="text" class="form-control" name="txtPrice">
                    </div>
                    <div class="form-group">
                        <label for="cbGenre">Genre:</label>
                        <select class="form-control" name="cbGenre">
                            <?php
                            $FC->allGenres();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txtDescription">Description:</label>
                        <textarea class="form-control" name="txtDescription" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cbLanguage">Language:</label>
                        <select class="form-control" name="cbLanguage">
                            <?php
                            $FC->allLanguages();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txtTrailer">Trailer viewkey:</label><br>
                        <input type="text" class="form-control" name="txtTrailer">
                    </div>
                    <div class="form-group">
                        <label for="txtDuration">Duration:</label>
                        <input type="number" class="form-control" name="txtDuration" min="0" max="180">
                    </div>
                    <div class="form-group">
                        <label for="imgPoster">Poster image:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imgPoster" id="imgPoster">
                                <label class="custom-file-label" for="imgPoster" id="imgPosterLabel">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="imgBackground">Background image:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imgBackground" id="imgBackground">
                                <label class="custom-file-label" for="imgBackground" id="imgBackgroundLabel">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dpDate">Release Date:</label>
                        <input type="date" class="form-control" name="dpReleaseDate">
                    </div>
                    <div class="form-group">
                        <label for="dpDate">Cinema Date:</label>
                        <input type="date" class="form-control" name="dpCinemaDate">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="form-control" name="btnSubmit" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </header>
    <!-- Optional JavaScript -->
    <script>
        var input = document.getElementById("txtName");
        input.focus();
        input.select();

        document.getElementById("imgPoster").addEventListener("change", function() {
            document.getElementById("imgPosterLabel").innerHTML = document.getElementById("imgPoster").files[0].name;
        });

        document.getElementById("imgBackground").addEventListener("change", function() {
            document.getElementById("imgBackgroundLabel").innerHTML = document.getElementById("imgBackground").files[0].name;
        });
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>