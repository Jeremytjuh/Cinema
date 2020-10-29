<?php
require('controller/FilmController.php');
$FC = new FilmController();
$FC->startSession();

if (isset($_POST["btnRegister"])) {
    $postArray = array("txtUsername", "txtPassword", "txtRepeatPassword");
    $isEmpty = false;

    foreach ($postArray as $v) {
        if (empty($_POST[$v])) {
            $isEmpty = true;
        }
    }

    if ($isEmpty) {
        echo "<script>alert('Voer alle velden in!')</script>";
    } else {
        if ($_POST["txtPassword"] == $_POST["txtRepeatPassword"]) {
            if ($FC->checkAdmin()) {
                if (isset($_POST["admin"])) {
                    $admin = true;
                } else {
                    $admin = false;
                }
            } else {
                $admin = false;
            }
            if (!$FC->register($_POST["txtUsername"], $_POST["txtPassword"], $admin)) {
                echo "<script>alert('Gebruikersnaam bestaat al!')</script>";
            }
        } else {
            echo "<script>alert('De wachtwoorden komen niet overeen!')</script>";
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>JereMovies - Registreren</title>
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
                <li class="nav-item active">
                    <?php
                    if (!$FC->checkLogin()) {
                    ?>
                        <a class="nav-link" href="login.php">Login<span class="sr-only">(current)</span></a>
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
    <header id="logobg">
        <div class="container">
            <div class="col-md-12 filminfobackground" id="login" style="height: 100vh; z-index: 50;">
                <h1>Registreren:</h1>
                <form method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                        <label for="txtUsername">Username:</label>
                        <input type="text" class="form-control" name="txtUsername" id="txtUsername">
                    </div>
                    <div class="form-group">
                        <label for="txtPassword">Password:</label>
                        <input type="password" class="form-control" name="txtPassword">
                    </div>
                    <div class="form-group">
                        <label for="txtRepeatPassword">Repeat Password:</label>
                        <input type="password" class="form-control" name="txtRepeatPassword">
                    </div>
                    <?php
                    if ($FC->checkAdmin()) {
                    ?>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="admin" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Admin</label>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="form-group">
                        <input type="submit" class="form-control" name="btnRegister" value="Registreren">
                    </div>
                </form>
            </div>
        </div>
    </header>
    <!-- Optional JavaScript -->
    <script>
        var input = document.getElementById("txtUsername");
        input.focus();
        input.select();
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>