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

    if ($isEmpty) {
        echo "<script>alert('Voer alle velden in!')</script>";
    } else {
        $FC->editFilm($_POST["cbFilm"], $_POST["txtName"], $_POST["txtPrice"], $_POST["cbGenre"], $_POST["txtDescription"], $_POST["txtTrailer"], $_POST["txtDuration"], $_FILES["imgPoster"]["tmp_name"], $_FILES["imgBackground"]["tmp_name"], $_POST["dpReleaseDate"], $_POST["dpCinemaDate"], $_POST["cbLanguage"]);
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>JereMovies - Film Bewerken</title>
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
                        <label for="cbFilm">Film:</label>
                        <select class="form-control" name="cbFilm" id="cbFilm">
                            <option value="">Kies een film</option>
                            <?php
                            $FC->allFilmsCB();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cbLanguage">Language:</label>
                        <select class="form-control" name="cbLanguage" id="cbLanguage" disabled></select>
                    </div>
                    <div class="form-group">
                        <label for="txtName">Name:</label>
                        <input type="text" class="form-control" name="txtName" id="txtName" disabled>
                    </div>
                    <div class="form-group">
                        <label for="txtPrice">Price:</label>
                        <input type="text" class="form-control" name="txtPrice" id="txtPrice" disabled>
                    </div>
                    <div class="form-group">
                        <label for="cbGenre">Genre:</label>
                        <select class="form-control" name="cbGenre" id="cbGenre" disabled></select>
                    </div>
                    <div class="form-group">
                        <label for="txtDescription">Description:</label>
                        <textarea class="form-control" name="txtDescription" id="txtDescription" rows="3" disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label for="txtTrailer">Trailer viewkey:</label><br>
                        <input type="text" class="form-control" name="txtTrailer" id="txtTrailer" disabled>
                    </div>
                    <div class="form-group">
                        <label for="txtDuration">Duration:</label>
                        <input type="number" class="form-control" name="txtDuration" id="txtDuration" min="0" max="180" disabled>
                    </div>
                    <div class="form-group">
                        <label for="imgPoster">Poster image:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imgPoster" id="imgPoster" disabled>
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
                                <input type="file" class="custom-file-input" name="imgBackground" id="imgBackground" disabled>
                                <label class="custom-file-label" for="imgBackground" id="imgBackgroundLabel">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dpDate">Release Date:</label>
                        <input type="date" class="form-control" name="dpReleaseDate" id="dpReleaseDate" disabled>
                    </div>
                    <div class="form-group">
                        <label for="dpDate">Cinema Date:</label>
                        <input type="date" class="form-control" name="dpCinemaDate" id="dpCinemaDate" disabled>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="form-control" name="btnSubmit" id="btnSumbit" value="Save" disabled>
                    </div>
                </form>
            </div>
        </div>
    </header>
    <!-- Optional JavaScript -->
    <script>
        document.getElementById("cbFilm").addEventListener("change", function() {
            var languagesFilmId = document.getElementById("cbFilm").value;
            if (languagesFilmId != "") {
                document.getElementById("cbLanguage").innerHTML = "";
                document.getElementById("cbGenre").innerHTML = "";
                EmptyForm();
                disableInputs();
                var xmlHTTP = new XMLHttpRequest();
                xmlHTTP.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("cbLanguage").innerHTML = this.responseText;
                        document.getElementById("cbLanguage").disabled = false;
                    };
                };
                xmlHTTP.open("GET", "ajax/ajax.php?languagesFilmId=" + languagesFilmId, true);
                xmlHTTP.send();
            } else {
                document.getElementById("cbLanguage").innerHTML = "";
                document.getElementById("cbGenre").innerHTML = "";
                document.getElementById("cbLanguage").disabled = true;
                EmptyForm();
                disableInputs();
            }
        });

        document.getElementById("cbLanguage").addEventListener("change", function() {
            var editFilmId = document.getElementById("cbFilm").value;
            var languageId = document.getElementById("cbLanguage").value;
            if (languageId != "") {
                $.ajax({
                    dataType: "json",
                    url: 'ajax/ajax.php',
                    data: {
                        editFilmId: editFilmId,
                        languageId: languageId
                    },
                    success: function(data) {
                        FillForm(data);
                        getUsedGenre(data.genreId);
                        enableInputs();
                    },
                    error: function(data) {
                        alert("Error " + data.name);
                    }
                });
            } else {
                EmptyForm();
                disableInputs();
            }

            function enableInputs() {
                document.getElementById("txtName").disabled = false;
                document.getElementById("txtPrice").disabled = false;
                document.getElementById("cbGenre").disabled = false;
                document.getElementById("txtDescription").disabled = false;
                document.getElementById("txtTrailer").disabled = false;
                document.getElementById("txtDuration").disabled = false;
                document.getElementById("imgPoster").disabled = false;
                document.getElementById("imgBackground").disabled = false;
                document.getElementById("dpReleaseDate").disabled = false;
                document.getElementById("dpCinemaDate").disabled = false;
                document.getElementById("btnSumbit").disabled = false;
            }

            function FillForm(data) {
                document.getElementById("txtName").value = data.name;
                document.getElementById("txtPrice").value = data.price;
                document.getElementById("txtDescription").value = data.description;
                document.getElementById("txtTrailer").value = data.trailer;
                document.getElementById("txtDuration").value = data.duration;
                document.getElementById("dpReleaseDate").value = data.releaseDate;
                document.getElementById("dpCinemaDate").value = data.cinemaDate;
            }

            function getUsedGenre(genreId) {
                var xmlHTTP = new XMLHttpRequest();
                xmlHTTP.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("cbGenre").innerHTML = this.responseText;
                    };
                };
                xmlHTTP.open("GET", "ajax/ajax.php?genreId=" + genreId, true);
                xmlHTTP.send();
            }
        });

        function disableInputs() {
            document.getElementById("txtName").disabled = true;
            document.getElementById("txtPrice").disabled = true;
            document.getElementById("cbGenre").disabled = true;
            document.getElementById("txtDescription").disabled = true;
            document.getElementById("txtTrailer").disabled = true;
            document.getElementById("txtDuration").disabled = true;
            document.getElementById("imgPoster").disabled = true;
            document.getElementById("imgBackground").disabled = true;
            document.getElementById("dpReleaseDate").disabled = true;
            document.getElementById("dpCinemaDate").disabled = true;
            document.getElementById("btnSumbit").disabled = true;
        }

        function EmptyForm() {
            document.getElementById("txtName").value = "";
            document.getElementById("txtPrice").value = "";
            document.getElementById("txtDescription").value = "";
            document.getElementById("txtTrailer").value = "";
            document.getElementById("txtDuration").value = "";
            document.getElementById("dpReleaseDate").value = "";
            document.getElementById("dpCinemaDate").value = "";
        }

        document.getElementById("imgPoster").addEventListener("change", function() {
            document.getElementById("imgPosterLabel").innerHTML = document.getElementById("imgPoster").files[0].name;
        });

        document.getElementById("imgBackground").addEventListener("change", function() {
            document.getElementById("imgBackgroundLabel").innerHTML = document.getElementById("imgBackground").files[0].name;
        });
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>