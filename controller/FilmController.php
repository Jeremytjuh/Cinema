<?php
class FilmController
{
    public $conn;

    public function __construct()
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbcinema;", "root", "");
        $this->conn = $conn;
    }

    public function allFilms($languageId)
    {
        $query = "SELECT tf.id, tf.image, tfl.languageId FROM tbfilms tf INNER JOIN tbfilmlanguages tfl ON tfl.filmId=tf.id WHERE tfl.languageId=:languageId";
        $stm = $this->conn->prepare($query);
        $stm->bindparam(":languageId", $languageId);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $film) {
                echo '<div class="col-lg-3 films"><a href="film.php?id=' . $film->id . '&languageId=' . $film->languageId . '"><img src="data:image/jpeg;base64,' . base64_encode($film->image) . '" class="poster"></a></div>';
            }
        }
    }

    public function getFilm($id, $languageId)
    {
        $query = "SELECT Tf.id, Tfl.name, Tf.price, Tf.genreId, Tfl.description, Tf.trailer, Tf.duration, Tf.image, Tf.backgroundImage, Tf.releaseDate, Tf.cinemaDate, Tg.id AS gId, Tg.name AS gName FROM tbfilms Tf INNER JOIN tbgenres Tg ON Tf.genreId=Tg.id INNER JOIN tbfilmlanguages Tfl ON Tfl.filmId=Tf.id WHERE Tf.id=:id AND Tfl.languageId=:languageId";
        $stm = $this->conn->prepare($query);
        $stm->bindparam(":id", $id);
        $stm->bindparam(":languageId", $languageId);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $film) {
                return $film;
            }
        } else {
            return false;
        }
    }

    public function addFilm($name, $price, $genreId, $description, $trailer, $duration, $image, $backgroundImage, $releaseDate, $cinemaDate, $languageId)
    {
        $query = "SELECT MAX(LAST_INSERT_ID(id)) AS lastID FROM tbfilms";
        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $film) {
                $newFilmId = $film->lastID + 1;
            }
        }

        $query = "INSERT INTO tbfilms (price, genreId, trailer, duration, image, backgroundImage, releaseDate, cinemaDate) values (:price, :genreId, :trailer, :duration, :image, :backgroundImage, :releaseDate, :cinemaDate); ";
        $query .= "INSERT INTO tbfilmlanguages (filmId, name, description, languageId) values (:filmId, :name, :description, :languageId); ";

        $stm = $this->conn->prepare($query);
        $stm->bindparam(":price", $price);
        $stm->bindparam(":genreId", $genreId);
        $stm->bindparam(":trailer", $trailer);
        $stm->bindparam(":duration", $duration);
        $stm->bindparam(":image", $image);
        $stm->bindparam(":backgroundImage", $backgroundImage);
        $stm->bindparam(":releaseDate", $releaseDate);
        $stm->bindparam(":cinemaDate", $cinemaDate);

        $stm->bindparam(":filmId", $newFilmId);
        $stm->bindparam(":name", $name);
        $stm->bindparam(":description", $description);
        $stm->bindparam(":languageId", $languageId);

        if ($stm->execute()) {
            header("Location: films.php");
        } else {
            return false;
        }
    }

    public function editFilm($id, $name, $price, $genreId, $description, $trailer, $duration, $image, $backgroundImage, $releaseDate, $cinemaDate, $languageId)
    {
        $query = "UPDATE tbfilms SET price=:price, genreId=:genreId, trailer=:trailer, duration=:duration, ";

        if ($image != "") {
            $query .= "image=:image, ";
        }

        if ($backgroundImage != "") {
            $query .= "backgroundImage=:backgroundImage, ";
        }

        $query .= "releaseDate=:releaseDate, cinemaDate=:cinemaDate WHERE id=:id; ";
        $query .= "UPDATE tbfilmlanguages SET filmId=:filmId, name=:name, description=:description WHERE languageId=:languageId AND filmId=:filmId;";
        $stm = $this->conn->prepare($query);
        $stm->bindparam(":id", $id);
        $stm->bindparam(":price", $price);
        $stm->bindparam(":genreId", $genreId);
        $stm->bindparam(":trailer", $trailer);
        $stm->bindparam(":duration", $duration);

        if ($image != "") {
            $imageContent = file_get_contents($image);
            $stm->bindparam(":image", $imageContent);
        }

        if ($backgroundImage != "") {
            $backgroundImageContent = file_get_contents($backgroundImage);
            $stm->bindparam(":backgroundImage", $backgroundImageContent);
        }

        $stm->bindparam(":releaseDate", $releaseDate);
        $stm->bindparam(":cinemaDate", $cinemaDate);

        $stm->bindparam(":filmId", $id);
        $stm->bindparam(":name", $name);
        $stm->bindparam(":description", $description);
        $stm->bindparam(":languageId", $languageId);

        if ($stm->execute()) {
            header("Location: film.php?id=$id&languageId=$languageId");
        } else {
            return false;
        }
    }

    public function deleteFilm()
    {
        $query = "DELETE FROM tbfilms WHERE id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindparam(":id", $id);
        if ($stm->execute()) {
            header("Location: films.php");
        } else {
            return false;
        }
    }

    public function addTranslation($filmId, $name, $description, $languageId)
    {
        $query = "INSERT INTO tbfilmlanguages (filmId, name, description, languageId) values (:filmId, :name, :description, :languageId);";
        $stm = $this->conn->prepare($query);
        $stm->bindparam(":filmId", $filmId);
        $stm->bindparam(":name", $name);
        $stm->bindparam(":description", $description);
        $stm->bindparam(":languageId", $languageId);
        if ($stm->execute()) {
            header("Refresh:0");
        } else {
            return false;
        }
    }

    public function allGenres()
    {
        $query = "SELECT id, name FROM tbgenres";
        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $genre) {
                echo "<option value='$genre->id'>$genre->name</option>";
            }
        }
    }

    public function allLanguages()
    {
        $query = "SELECT id, name FROM tblanguages";
        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $language) {
                echo "<option value='$language->id'>$language->name</option>";
            }
        }
    }

    public function allFilmsCB()
    {
        $query = "SELECT Tf.id, Tfl.name FROM tbfilms Tf INNER JOIN tbfilmlanguages Tfl ON Tfl.filmId=Tf.id WHERE Tfl.languageId=1";
        $stm = $this->conn->prepare($query);
        $stm->bindparam("languageId", $languageId);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            $i = 1;
            foreach ($result as $film) {
                echo "<option value='$film->id'>$i - $film->name</option>";
                $i++;
            }
        }
    }

    public function allGenresCB($id)
    {
        $query = "SELECT id, name FROM tbgenres";
        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $genre) {
                if ($genre->id != $id) {
                    echo "<option value='$genre->id'>$genre->name</option>";
                } else {
                    echo "<option selected='selected' value='$genre->id'>$genre->name</option>";
                }
            }
        }
    }

    public function allLanguagesCB($id)
    {
        $query = "SELECT id, name FROM tblanguages";
        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $language) {
                if ($language->id != $id) {
                    echo "<option value='$language->id'>$language->name</option>";
                } else {
                    echo "<option selected='selected' value='$language->id'>$language->name</option>";
                }
            }
        }
    }

    public function usedLanguagesCB($filmId, $languageId)
    {
        $query = "SELECT tfl.languageId AS id, tl.name AS name FROM tbfilmlanguages tfl INNER JOIN tblanguages tl ON tl.id=tfl.languageId WHERE tfl.filmId=:filmId";
        $stm = $this->conn->prepare($query);
        $stm->bindparam("filmId", $filmId);
        if ($stm->execute()) {
            $usedLanguages = $stm->fetchAll(PDO::FETCH_OBJ);
        }

        $query = "SELECT id, name FROM tblanguages";
        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $allLanguages = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($allLanguages as $aLanguage) {
                if (in_array($aLanguage, $usedLanguages)) {
                    if ($aLanguage->id != $languageId) {
                        echo "<option value='$aLanguage->id'>$aLanguage->name</option>";
                    } else {
                        echo "<option selected='selected' value='$aLanguage->id'>$aLanguage->name</option>";
                    }
                }
            }
        }
    }

    public function allTranslationLanguages($filmId)
    {
        $query = "SELECT tfl.languageId AS id, tl.name AS name FROM tbfilmlanguages tfl INNER JOIN tblanguages tl ON tl.id=tfl.languageId WHERE tfl.filmId=:filmId";
        $stm = $this->conn->prepare($query);
        $stm->bindparam("filmId", $filmId);
        if ($stm->execute()) {
            $usedLanguages = $stm->fetchAll(PDO::FETCH_OBJ);
        }

        $query = "SELECT id, name FROM tblanguages";
        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $allLanguages = $stm->fetchAll(PDO::FETCH_OBJ);
            $i = 1;
            echo "<option value=''>Kies een taal</option>";
            foreach ($allLanguages as $aLanguage) {
                if (!in_array($aLanguage, $usedLanguages)) {
                    echo "<option value='$aLanguage->id'>$i - $aLanguage->name</option>";
                    $i++;
                }
            }
        }
    }

    public function usedTranslationLanguages($filmId)
    {
        $query = "SELECT tfl.languageId AS id, tl.name AS name FROM tbfilmlanguages tfl INNER JOIN tblanguages tl ON tl.id=tfl.languageId WHERE tfl.filmId=:filmId";
        $stm = $this->conn->prepare($query);
        $stm->bindparam("filmId", $filmId);
        if ($stm->execute()) {
            $usedLanguages = $stm->fetchAll(PDO::FETCH_OBJ);
        }

        $query = "SELECT id, name FROM tblanguages";
        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $allLanguages = $stm->fetchAll(PDO::FETCH_OBJ);
            $i = 1;
            echo "<option value=''>Kies een taal</option>";
            foreach ($allLanguages as $aLanguage) {
                if (in_array($aLanguage, $usedLanguages)) {
                    echo "<option value='$aLanguage->id'>$i - $aLanguage->name</option>";
                    $i++;
                }
            }
        }
    }

    public function register($username, $password, $admin)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO tbuser (username, password, admin) values (:username, :password, :admin)";
        $stm = $this->conn->prepare($query);
        $stm->bindparam(":username", $username);
        $stm->bindparam(":password", $hashedPassword);
        $stm->bindparam(":admin", $admin);
        if ($stm->execute()) {
            header("Location: login.php");
        }
    }

    public function login($username, $password)
    {
        $query = "SELECT username, password, admin FROM tbuser WHERE username=:username LIMIT 1";
        $stm = $this->conn->prepare($query);
        $stm->bindparam(":username", $username);
        if ($stm->execute()) {
            $user = $stm->fetch(PDO::FETCH_OBJ);
            if ($user != null) {
                if (password_verify($password, $user->password)) {
                    $_SESSION["loggedIn"] = true;
                    $_SESSION["username"] = $username;
                    $_SESSION["admin"] = $user->admin;
                    header("Location: logout.php");
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            print_r($stm->errorInfo());
        }
    }

    public function startSession()
    {
        session_start();
    }

    public function checkLogin()
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy()
    {
        session_destroy();
        header("Location: login.php");
    }

    public function checkAdmin()
    {
        if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
            return true;
        } else {
            return false;
        }
    }
}
