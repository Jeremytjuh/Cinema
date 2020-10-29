<?php
require('controller/FilmController.php');
$FC = new FilmController();
$FC->startSession();
?>
<!doctype html>
<html lang="en">

<head>
    <title>JereMovies</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
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
    <header id="logobg" style="height: 100vh;">
        <div class="container">
            <div class="row">
                <div class="col-12 align-middle" style="z-index: 50; text-align: center;">
                    <h1 id="logo" style="z-index: 50;"><span class="logocolors">J</span>ere<span class="logocolors">M</span>ovies</h1>
                </div>
            </div>
        </div>
    </header>
    <br><br>
    <div id="cinemabg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Welkom bij bioscoop JereMovies</h1>
                </div>
                <div class="col-8">
                    <p>Op deze website kan je veel informatie vinden over onze bioscoop en wat voor films er allemaal draaien</p>
                </div>
                <div class="col-lg-4">
                    <div id="carouselId" class="carousel slide" data-ride="carousel">
                        <!--<ol class="carousel-indicators">
                            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselId" data-slide-to="1"></li>
                            <li data-target="#carouselId" data-slide-to="2"></li>
                        </ol>-->
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <img src="img/popcorn.png" alt="Popcorn slide" class="carousel-img">
                                <div class="carousel-caption d-none d-md-block">
                                    <h3>Popcorn!</h3>
                                    <p>Bij JereMovies hebben we de lekkerste popcorn van Nederland!</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="img/3dglassesGrey.png" alt="3DGlasses slide" class="carousel-img">
                                <div class="carousel-caption d-none d-md-block">
                                    <h3>3D</h3>
                                    <p>We hebben de nieuwste technologie op het gebied van 3D!</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="img/happycustomer.png" alt="Customer slide" class="carousel-img">
                                <div class="carousel-caption d-none d-md-block">
                                    <h3>Beoordeling</h3>
                                    <p>Onze klanten geven de bioscoop een 4.5/5 als beoordeling!</p>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    .
    <div style="height: 500px;">
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>