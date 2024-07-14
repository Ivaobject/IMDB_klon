<?php

require_once __DIR__ . '/../model/functions.class.php';

class MoviesController {

    public function allmovies() {
        $ls = new functions;

        $title = 'Svi filmovi';
        $movieList = $ls->getAllMovies();

        require_once __DIR__ . '/../view/svifilmovi.php';
    }

    public function toprated() {
        $ls = new functions;

        $title = 'Najbolje ocijenjeni filmovi';
        $movieList = $ls->getTopMovies();

        require_once __DIR__ . '/../view/top5film.php';
    }

    public function mostpopular() {
        $ls = new functions;

        $title = 'Popularni filmovi';
        $movieList = $ls->getPopularMovies();

        if (!$movieList) {
            $noMoviesMessage = 'Nema rezultata za popularne filmove.';
        } else {
            foreach ($movieList as $movie) {
                $nwatchlistsList[] = $ls->getNumberOfWatchlists((int) $movie->id);
            }
        }
    

        require_once __DIR__ . '/../view/popularnifilmovi.php';
    }

    public function search() {
        $title = 'Pretrazivanje';
        $movieList = []; // Inicijalizacija praznog niza za $movieList
        $genreList = [];
        $x = new functions;
        $genreList = $x->allGenres();

        if (isset($_POST['searchyear'])) {
            $year = $_POST['txt_year'];

            if (!preg_match('/[0-9]{4}/', $year)) {
                require_once __DIR__ . '/../view/pretrazivanje.php';
            } else {
                $movieList = $x->moviesByYear($year);
                require_once __DIR__ . '/../view/svifilmovi.php';
            }
        } elseif (isset($_POST['genrebutton'])) {
            $genre = $_POST['genre'];
            $title = $genre . ' filmovi';
            $movieList = $x->searchByGenre($genre);
            require_once __DIR__ . '/../view/svifilmovi.php';
        } elseif (isset($_POST['byname'])) {
            $title = $_POST['search_input'];
            $movieList = $x->moviesByTitle($title);

            if (sizeof($movieList) === 1) {
                $_POST['movie_id'] = $movieList[0]->id_movie;
                $_POST["movie_title"] = $movieList[0]->title;
                require_once __DIR__ . '/../view/film.php';
            } else {
                require_once __DIR__ . '/../view/svifilmovi.php';
            }
        } else {
            require_once __DIR__ . '/../view/pretrazivanje.php'; 
        }
    }

    public function movie()
{
    $ls = new functions();

    // Initialize variables
    $movie = null;
    $castList = [];
    $usersList = [];
    $rating = -2;
    $isOnWatchlist = false;

  
    if (isset($_POST["id_movie"])) {
        $id = (int) $_POST["id_movie"];
    } elseif (isset($_SESSION["id_movie"])) {
        $id = (int) $_SESSION["id_movie"];
    } else {
        // Handle case where movie_id is not set
        exit('Error: Movie ID not set.');
    }

    // Fetch movie details
    $movie = $ls->getMovie($id);

    // Check if movie was found
    if ($movie) {
        $title = $movie->title;

        $caststr = $ls->getCast($id);
        $castList = explode(',', $caststr);

        $commentList = $ls->getComments($id);

        foreach ($commentList as $comment) {
            $usersList[] = $ls->getUsername($comment->id_user);
        }


        if (isset($_SESSION['id_user'])) {
            $rating = $ls->getRating($id,$_SESSION['id_user']);

            $isOnWatchlist = $ls->isMovieOnWatchlist($id, $_SESSION['id_user']);
        } else {
            $rating = -2; 
        }

     
        require_once __DIR__ . '/../view/filmovi.php';
    } else {
     
        exit('Error: Movie not found for ID ' . $id);
    }
}

public function newcomment() {
    if (isset($_SESSION['id_user'])) {
        if (isset($_POST['content'])) {
            $id_movie = isset($_SESSION['id_movie']) ? (int) $_SESSION['id_movie'] : null;

            if (!$id_movie && isset($_POST['id_movie'])) {
                $id_movie = (int) $_POST['id_movie'];
            }

            if (!$id_movie) {
                exit('Error: Movie ID not set.');
            }

            $ls = new functions;
            $ls->writeNewMessage($id_movie, $_POST['content']);

            $x = new MoviesController;
            $x->movie();

            require_once __DIR__ . '/../view/filmovi.php';
        }
    } else {
        require_once __DIR__ . '/../view/signin.php';
    }
}

public function watchlist() {
    if (!isset($_SESSION['id_user'])) {
        require_once __DIR__ . '/../view/signin.php';
        return;
    }
    
    $id_user = (int)$_SESSION['id_user'];

    if (!isset($_POST['id_movie'])) {
        exit('Error: Movie ID not set.');
    }

    $id_movie = (int)$_POST['id_movie'];

    $ls = new functions;
    $ls->addMovieToWatchlist($id_movie, $id_user);

    // Direktno prikaži film nakon dodavanja u watchlistu
    $this->movie();
}

public function rate() {
    if (isset($_SESSION['id_user'])) {
        $ls = new functions;

        // Provjeri ID filma iz sesije ili POST-a
        $id_movie = isset($_SESSION['id_movie']) ? (int) $_SESSION['id_movie'] : null;

        if (!$id_movie && isset($_POST['id_movie'])) {
            $id_movie = (int) $_POST['id_movie'];
        }

        // Ako ID filma nije postavljen, izbacuje grešku
        if (!$id_movie) {
            exit('Error: Movie ID not set.');
        }

        // Provjeri ocjenu iz POST-a
        if (isset($_POST['rating'])) {
            $rating = (int) $_POST['rating'];

            if ($rating < 1 || $rating > 10) {
                exit('Error: Invalid rating. Please provide a rating between 1 and 10.');
            }

            // Ocijeni film
            $ls->rateMovie($id_movie, $_SESSION['id_user'], $rating);

            // Preusmjeri nazad na stranicu filma
            header('Location: index.php?rt=movies/movie&id=' . $id_movie);
            exit();
        } else {
            exit('Error: Rating not set.');
        }
    } else {
        // Ako korisnik nije prijavljen, preusmjeri na stranicu za prijavu
        header('Location: index.php?rt=view/signin');
        exit();
    }
}


}

?>