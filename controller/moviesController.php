<?php

require_once __DIR__ . '/../model/functions.class.php';

    class MoviesController{

        public function allmovies()
        {
            $ls = new functions;

            $title = 'Svi filmovi';
            $movieList = $ls->getAllMovies();

            require_once __DIR__ . '/../view/svifilmovi.php';
        }

        public function toprated()
        {
            $ls = new functions;

            $title = 'Najbolje ocijenjeni filmovi';
            $movieList = $ls->getTopMovies();

            require_once __DIR__ . '/../view/top5film.php';
        }

        public function mostpopular()
        {
            $ls = new functions;

            $title = 'Popularni filmovi';
            $movieList = $ls->getPopularMovies();

            foreach($movieList as $movie)
            {
                $nwatchlistsList[] = $ls->getNumberOfWatchlists((int)$movie->id);
            }

            require_once __DIR__ . '/../view/popularnifilmovi.php';
        }

        public function search()
        {
         

            if( isset($_POST['searchyear']) )
            {
                $year = $_POST['txt_year'];

       

                if ( !preg_match( '/[0-9]{4}/', $year ) )
                {
                    
                    $title = 'Pretrazivanje';
                    $genreList = [];
                    $x = new functions;
                    $genreList = $x->allGenres();


                    require_once __DIR__ . '/../view/pretrazivanje.php';
                }
                    
                else
                {
                    
                    $ls = new functions;

                    $title = $year . ' filmovi';
                    $movieList = $ls->moviesByYear( $year );

                    require_once __DIR__ . '/../view/svifilmovi.php';
                }
                
            }

            elseif( isset( $_POST['genrebutton'] ) )
            {
                
                $genre = $_POST['genre'];
                
                $title = $genre . 'filmovi';
                $x = new functions;
                $movieList = [];
                $movieList = $x->searchByGenre( $genre );

                require_once __DIR__ . '/../view/svifilmovi.php';
            }

            elseif( isset( $_POST['byname'] ) )
            {
                
                $x = new functions;
                $title = $_POST['search_input'];
                $movieList = $x->moviesByTitle( $title );

                
                if ( sizeof( $movieList ) === 1 )
                {
                    
                    $_POST['movie_id'] = $movieList->$id_movie;
                    $_POST["movie_title"] = $movieList->title;
                    require_once __DIR__ . '/../view/film.php';
                }

                else
                {
                    $title = 'Pretrazivanje';
                    require_once __DIR__ . '/../view/svifilmovi.php';

                }
                
            }

            else
            {
                $title = 'Pretrazivanje';
                $genreList = [];
                $x = new functions;
                $genreList = $x->allGenres();


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

            // Check if movie_id is set in POST or SESSION
            if (isset($_POST["movie_id"])) {
                $id = (int) $_POST["movie_id"];
            } elseif (isset($_SESSION['id_movie'])) {
                $id = (int) $_SESSION['id_movie'];
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

                // Check if user is logged in
                if (isset($_SESSION['id_user'])) {
                    $rating = $ls->getRating($id);
                } else {
                    $rating = -2; // Default value for non-logged in users
                }

                // Render the view
                require_once __DIR__ . '/../view/film.php';
            } else {
                // Handle case where movie was not found
                exit('Error: Movie not found for ID ' . $id);
            }
        }



        public function newcomment() 
        {
            if (isset ( $_SESSION['id_user']) )
            {
                if (isset ($_POST['content']))
                {
                    $id_movie = (int) $_SESSION['id_movie'];


                    $ls = new functions;
                    $ls->writeNewMessage( $id_movie, $_POST['content'] );

                    
                    $x = new MoviesController;
                    $x->movie(); 

                    require_once __DIR__ . '/../view/film.php';
                }


            }
            else 
            {
                require_once __DIR__ . '/../view/signin.php';
            }

        }

        public function watchlist()
        {
            if (isset ( $_POST['watchlist']) )
            {
                $id_movie = (int) $_SESSION['id_movie'];
                $id_user = (int) $_SESSION['id_user'];

                $ls = new functions;
                $ls->addMovieToWatchlist( $id_movie, $id_user );

                $x = new MoviesController;
                $x->movie(); 

                require_once __DIR__ . '/../view/film.php';
                

            }
        }
    }




    
?>