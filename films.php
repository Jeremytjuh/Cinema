<?php
require('controller/FilmController.php');
$FC = new FilmController();
$FC->startSession();
?>
<!doctype html>
<html lang="en">

<head>
    <title>JereMovies - Films</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="films.php">Films <span class="sr-only">(current)</span></a>
                </li>
                <?php
                if ($FC->checkAdmin()) {
                ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
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
                <form>
                    <select class="form-control" name="cbLanguage" id="cbLanguage">
                        <?php
                        if (isset($_COOKIE["language"])) {
                            $FC->allLanguagesCB($_COOKIE["language"]);
                        } else {
                            $FC->allLanguages();
                        }
                        ?>
                    </select>
                </form>
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
    <header id="logobg" style="min-height: 100vh;">
        <div class="container">
            <div class="col-md-12 filminfobackground" id="login" style="min-height: 100vh; z-index: 50;">
                <div class="row" id="filmRow">
                    <!-- Zoek functie ofzo -->
                    <?php
                    if (isset($_COOKIE["language"])) {
                        $FC->allFilms($_COOKIE["language"]);
                    } else {
                        $FC->allFilms(1);
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>
    <!-- Optional JavaScript -->
    <script>
        document.getElementById("cbLanguage").addEventListener("change", function() {
            var filmsLanguageId = document.getElementById("cbLanguage").value;
            $.ajax({
                dataType: "html",
                url: 'ajax/ajax.php',
                xhrFields: {
                    withCredentials: true
                },
                data: {
                    filmsLanguageId: filmsLanguageId,
                },
                beforeSend: function(xhr) {
                    document.cookie = "language=" + filmsLanguageId;
                },
                success: function(data) {
                    document.getElementById("filmRow").innerHTML = data;
                },
                error: function(data) {
                    alert("Error");
                }
            });
        });
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>