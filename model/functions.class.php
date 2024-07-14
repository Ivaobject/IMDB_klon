
<?php

require __DIR__ . '/../app/database/db.class.php';
require __DIR__ . '/user.class.php';
require __DIR__ . '/movie.class.php';
require __DIR__ . '/rating.class.php';
require __DIR__ . '/comment.class.php';
require __DIR__ . '/watchlist.class.php';

class functions {

    private $db; // Dodano kao privatno svojstvo za vezu s bazom podataka

    public function __construct() {
        $this->db = DB::getConnection(); // Inicijalizacija veze s bazom podataka
    }

    public function getUserId($username) {
        $st = $this->db->prepare('SELECT id FROM korisnici WHERE username=:username');
        $st->execute(['username' => $username]);
        $row = $st->fetch();

        return $row['id']; // Vraćanje samo ID-a, ne cijelog reda
    }

    public function isUserAdmin() {
        $st = $this->db->prepare('SELECT admin FROM korisnici WHERE id=:id');
        $st->execute(['id' => $_SESSION['id_user']]);
        $row = $st->fetch();

        return $row['admin']; // Vraćanje samo admin statusa, ne cijelog reda
    }

    public function eraseUser($id) {
        $st = $this->db->prepare('DELETE FROM korisnici WHERE id LIKE :id');
        $st->execute(['id' => $id]);
        return;
    }

    public function loginUser($username, $password) {
        $st = $this->db->prepare('SELECT * FROM korisnici WHERE username=:username');
        $st->execute(['username' => $username]);
        $user = $st->fetch();

        if (!$user) {
            return false; // Korisnik nije pronađen
        }

        // Provjeri lozinku
        if (password_verify($password, $user['password_hash'])) {
            return $user; // Vrati korisnika ako je lozinka ispravna
        } else {
            return false; // Neispravna lozinka
        }
    }

    public function newUser(){
        $db = DB::getConnection();

        try{
                    $st = $db->prepare( 'SELECT * FROM korisnici WHERE username=:username' );
        $st->execute( array( 'username' => $_POST['newusername'] ) );
        }
        catch( PDOException $e ) { exit( "PDO error [korisnici]: " . $e->getMessage() ); }

        if( $st->rowCount() !== 0 ){
            require_once __DIR__ . '/../view/signin.php';
            exit();
        }

        $reg_seq = '';
        for( $i = 0; $i < 20; ++$i )
            $reg_seq .= chr( rand(0, 25) + ord( 'a' ) );


        try{
                    $st = $db->prepare( 'INSERT INTO korisnici(username, password_hash, email, registration_sequence, has_registered, admin) VALUES ' .
                                            '(:username, :password_hash, :email, :registration_sequence, 0, 0)' );

                    $st->execute( array( 'username' => $_POST['newusername'], 
                                             'password_hash' => password_hash( $_POST['newpassword'], PASSWORD_DEFAULT ), 
                                             'email' => $_POST['newemail'], 
                             'registration_sequence'  => $reg_seq ) );
        }
        catch( PDOException $e ) { exit( "PDO error [korisnici]: " . $e->getMessage() ); }


        $to       = $_POST['newemail'];
        $subject  = 'Registracijski mail';
        $message  = 'Poštovani ' . $_POST['newusername'] . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
        $message .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/index.php?niz=' . $reg_seq . "\n";
        $headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
                    'Reply-To: rp2@studenti.math.hr' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        $isOK = mail($to, $subject, $message, $headers);

        if( !$isOK )
            exit( 'Error: can not send e-mail.' );
        require_once __DIR__ . '/../view/registracija.php';
        exit();
    }


    public function getMovie($id_movie) {
        $st = $this->db->prepare('SELECT * FROM filmovi WHERE id=:id_movie');
        $st->execute(['id_movie' => $id_movie]);
        $row = $st->fetch();
    
        if (!$row) {
            return null; // Return null if no movie found
        }
    
        $movie = new Movie($row['id'], $row['title'], $row['genre'], $row['year'], $row['director'], $row['actors'], $row['rating']);
        return $movie;
    }
    


    public function getWatchlist() {
        $allmovies = [];
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM watchlists WHERE id_user=:id_user');
        $st->execute(['id_user' => $_SESSION['id_user']]);
    
        while ($row = $st->fetch()) {
            $movie = $this->getMovie($row['id_movie']);
            if ($movie) {
                $allmovies[] = $movie;
            }
        }
    
        return $allmovies;
    }

        public function getUsername($userId){

            $db = DB::getConnection();
            $st = $db->prepare('SELECT * FROM korisnici WHERE id=:id_user');
            $st->execute(['id_user' => $userId]);
            $row = $st->fetch();

            if (!$row) {
                return null; // Ako korisnik nije pronađen, možete vratiti null ili neki drugi signal
            }

            return $row['username'];
        }

        public function getUser($userId) {
            $query = "SELECT * FROM korisnici WHERE id = :user_id";
           
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
        
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if (!$user) {
                return null; // ili neki drugi način da signalizirate da korisnik nije pronađen
            }
        
            return $user;
        }

        public function allGenres()
        {
            $allGenres = [];
    
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT DISTINCT genre FROM filmovi' );
            $st->execute();
    
            while( $row = $st->fetch() )
            $allGenres[] = $row['genre'];
            
            return $allGenres;
        }
    


        public function getCommentId( $content )
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id FROM komentari WHERE content=:content' );
            $st->execute( ['content' => $content] );
            $row = $st->fetch();

            return $row;
        }
        
        public function eraseComment( $id )
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'DELETE FROM komentari WHERE id LIKE :id' );
            $st->execute(['id' => $id]);
            return;

        }

        
        public function newMovie()
        {
            $db = DB::getConnection();
            try{
                $st = $db->prepare( 'INSERT INTO filmovi(title, director, year, genre, cast, rating) VALUES ' .
                            '(:title, :director, :release_year, :genre, :cast, 0)' );
                $st->execute( array( 'title' => $_POST['newtitle'], 
                            'director' => $_POST['newdirector'], 
                            'release_year' => $_POST['newyear'], 
                            'genre' => $_POST['newgenre'],
                            'cast' => $_POST['newcast'] ) );
            }
            catch( PDOException $e ) { exit( "PDO error [komentari]: " . $e->getMessage() ); }
            return;

        }

        public function getTitle( $id_movie ) 
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM filmovi WHERE id=:id_movie' );
            $st->execute( [ 'id_movie' => $id_movie ] );
            $row = $st->fetch();
    
            $movie = new Movie( $row['id'], $row['title'], $row['director'], $row['year'], $row['genre'], $row['actors'], $row['rating'] );
            return $movie->title;
        }
    
        public function getAllMovies()
        {
            $movies = [];
            $db = DB::getConnection();
            $st = $db->prepare('SELECT id, title, genre, year, director, actors, rating FROM filmovi ORDER BY title');
            $st->execute();
        
            while ($row = $st->fetch()) {
         
                $movies[] = new Movie(
                    $row['id'],
                    $row['title'],
                    $row['genre'],
                    $row['year'],
                    $row['director'],
                    $row['actors'],
                    $row['rating']
                );
            }
            return $movies;
        }
    
        public function getTopMovies ()
        {
            $movies = [];
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM filmovi ORDER BY rating DESC LIMIT 0,5' );
            $st->execute();
    
            while( $row = $st->fetch() )
                $movies[] = new Movie($row['id'], $row['title'], $row['genre'], $row['year'], $row['director'], $row['actors'], $row['rating']);
    
            return $movies;
        }
    
        public function getPopularMovies()
        {
            $movies = [];
    
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id_movie, COUNT(*) FROM watchlists GROUP BY id_movie ORDER BY 2 DESC LIMIT 0,5');
            $st->execute();
    
            $ls = new functions;
    
            while( $row = $st->fetch() )
                $movies[] = $ls->getMovie($row['id_movie']);
    
            return $movies;
        }
    
        public function getNumberOfWatchlists( $id_movie )
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT COUNT(*) FROM watchlists WHERE id_movie=:id_movie');
            $st->execute( ['id_movie' => $id_movie] );

            return $st->fetchColumn();
        }
        public function getCast( $id_movie ) 
        {
    
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM filmovi WHERE id=:id_movie' );
            $st->execute( ['id_movie' => $id_movie] );
            $row = $st->fetch();
            $cast = $row['actors'];
    
            return $cast;
        }
    
        public function getComments ( $id_movie )
        {
            $allcomments = [];
    
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM komentari WHERE id_movie=:id_movie ORDER BY datum' );
            $st->execute( ['id_movie' => $id_movie] );
    
            while( $row = $st->fetch() )
                $allcomments[] = new Comment( $row['id'], $row['id_user'], $row['id_movie'], $row['tekst'], $row['datum'] );
    
            return $allcomments;
        }
    
        public function newAdmin( $username )
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM korisnici WHERE username=:username' );
            $st->execute( array( 'username' => $username ) );
            $row = $st->fetch();
    
            if( $row['admin'] ) 
                return 0;
    
            else
            {
                $st = $db->prepare( 'UPDATE korisnici SET admin=1 WHERE username=:username' );
                $st->execute( array( 'username' => $username ) );
                return 1;
            }
    
    
        }
    

        public function writeNewMessage($id_movie, $content)
        {
            $id_user = (int)$_SESSION['id_user'];
            date_default_timezone_set("Europe/Zagreb");
            $date = date("Y-m-d H:i:s"); 
            $db = DB::getConnection();
            $st = $db->prepare( 'INSERT INTO komentari (id_user, id_movie, tekst, datum) VALUE (:id_user, :id_movie, :content, :date)' );
            $st->execute(['id_user' => $id_user,  'id_movie' => $id_movie, 'content' => $content, 'date' => $date]);
        }
    
        public function addMovieToWatchlist( $id_movie, $id_user )
        {
            $db = DB::getConnection();
    
            $st = $db->prepare( 'INSERT INTO watchlists (id_user, id_movie, watched) VALUE (:id_user, :id_movie, 0)' );
            $st->execute(['id_user' => $id_user,  'id_movie' => $id_movie]);
        }
    
        public function isMovieOnWatchlist( $id_movie, $id_user )
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM watchlists WHERE id_user=:id_user AND id_movie=:id_movie');
            $st->execute( array( 'id_user' => $id_user, 'id_movie' => $id_movie ) );
    
            return $st->rowCount();
    
        }
    
        public function moviesByYear( $year )
        {
            $allmovies = [];
    
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM filmovi WHERE year=:year' );
            $st->execute(['year' => $year]); 
    
            while( $row = $st->fetch() )
            $allmovies[] = new Movie($row['id'], $row['title'], $row['director'], $row['year'], $row['genre'], $row['actors'], $row['rating']);
    
            return $allmovies;
        }
        
        public function searchByActor($actorName) {
            $stmt = $this->db->prepare("SELECT * FROM movies WHERE actors LIKE :actorName");
            $actorName = '%' . $actorName . '%';
            $stmt->execute([':actorName' => $actorName]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function getAllRatedMovies() {
            $db = DB::getConnection();
    
            $st = $db->prepare('SELECT id_movie FROM ocjene WHERE id_user=:id_user');
            $st->execute(['id_user' => $_SESSION['id_user']]);
    
            $movieList = [];
            while ($row = $st->fetch()) {
                $movieList[] = $this->getMovie($row['id_movie']);
            }
    
            return $movieList;
        }
    
        public function getRating($id_movie, $id_user) {
            $db = DB::getConnection();
        
            $st = $db->prepare('SELECT rating FROM ocjene WHERE id_movie=:id_movie AND id_user=:id_user');
            $st->execute(['id_movie' => $id_movie, 'id_user' => $id_user]);
        
            $row = $st->fetch();
        
            if ($row) {
                return (int)$row['rating'];
            } else {
                echo "Nema podataka za id_movie: $id_movie, id_user: $id_user<br>";
                return -1; // Vraća -1 ako korisnik nije ocijenio film
            }
        }
        public function getAverageRating($id_movie) {
            $db = DB::getConnection();
    
            $st = $db->prepare('SELECT rating FROM ocjene WHERE id_movie=:id_movie');
            $st->execute(['id_movie' => $id_movie]);
    
            $n = 0;
            $rating_sum = 0;
            while ($row = $st->fetch()) {
                $rating_sum += $row['rating'];
                $n++;
            }
    
            if ($n === 0) {
                return -1;
            } else {
                return $rating_sum / $n;
            }
        }
    
        public function updateAverageRating($id_movie, $average_rating) {
            $db = DB::getConnection();
    
            try {
                $st = $db->prepare('UPDATE filmovi SET rating=:average_rating WHERE id=:id_movie');
                $st->execute(['average_rating' => $average_rating, 'id_movie' => $id_movie]);
            } catch (PDOException $e) {
                exit("PDO error [ocijene]: " . $e->getMessage());
            }
        }
    
        public function rateMovie($id_movie, $id_user, $rating) {
            $db = DB::getConnection();
    
            try {
                $query = "INSERT INTO ocjene (id_movie, id_user, rating) VALUES (:id_movie, :id_user, :rating)";
                $statement = $db->prepare($query);
    
                $statement->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
                $statement->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $statement->bindParam(':rating', $rating, PDO::PARAM_INT);
                $statement->execute();
    
                $average_rating = $this->getAverageRating($id_movie);
                $this->updateAverageRating($id_movie, $average_rating);
    
            } catch (PDOException $e) {
                exit('Database error: ' . $e->getMessage());
            }
        }
    

}

?>