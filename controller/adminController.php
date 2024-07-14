<?php
require_once __DIR__ . '/../model/functions.class.php';
require_once __DIR__ . '/../model/movie.class.php';
require_once __DIR__ . '/../controller/userController.php';

class adminController {

    public function index() {
        if (!isset($_SESSION['admin'])) {
            require_once __DIR__ . '/../view/signin.php';
        } else {
            $info = '';
            $emptylist = '';
            $title = 'My profile';
            $emptyratings = '';

            $x = new functions;
            $username = $x->getUsername($_SESSION['id_user']);

            $watchList = $x->getWatchlist();
            $movieList = [];

            for ($i = 0; $i < sizeof($watchList); ++$i) {
                $movieList[$i] = $x->getMovie($watchList[$i]->id_movie);
            }

            if (sizeof($movieList) === 0) {
                $emptylist = 'Vaš watchlist je prazan!';
            }

            $ratedMoviesList = $x->getAllRatedMovies();

            if (sizeof($ratedMoviesList) === 0) {
                $emptyratings = "Niste ocijenili nijedan film!";
            }

            foreach ($ratedMoviesList as $movie) {
                $rating = $x->getRating($movie->id, $_SESSION['id_user']);
                //echo "Movie ID: {$movie->id}, Rating: {$rating}<br>";
                $ratingsList[] = $rating;
            }

            if ((int)$_SESSION['admin']) {
                require_once __DIR__ . '/../view/admin.php';
            } else {
                require_once __DIR__ . '/../view/myprofile.php';
            }
        }
    }

    public function eraseuser() {
        if (isset($_POST['eraseuser'])) {
            $x = new functions;
            $username = $_POST['search_users'];
            $id = $x->getUserId($username);
            $x->eraseUser($id);

            require_once __DIR__ . '/../view/eraseuser.php';
        }
    }

    public function erasecomment() {
        if (isset($_POST['erasecomment'])) {
            $x = new functions;
            $content = $_POST['search_comments'];
            $id = $x->getCommentId($content);
            $x->eraseComment($id);

            require_once __DIR__ . '/../view/erasecomment.php';
        }
    }

    public function newmovie() {
        $x = new functions;
        if (isset($_POST['newtitle'])) {
            $x->newMovie();
            $title = $_POST['newtitle'];
        }
        require_once __DIR__ . '/../view/newmovie.php';
    }

    public function addadmin() {
        $x = new functions;
        $admin = $x->newAdmin($_POST['new_admin']);
        if ($admin) {
            $info = 'This user is already admin.';
        } else {
            $info = 'User ' . $_POST['new_admin'] . ' is now also admin.';
        }

        $title = 'My profile';
        $username = $x->getUsername($_SESSION['id_user']);
        $watchList = $x->getWatchlist();
        $movieList = [];

        for ($i = 0; $i < sizeof($watchList); ++$i) {
            $movieList[$i] = $x->getMovie($watchList[$i]->id_movie);
        }

        require_once __DIR__ . '/../view/admin.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
}

?>