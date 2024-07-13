
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
        $st->execute(['id' => $_SESSION['id_korisnik']]);
        $row = $st->fetch();

        return $row['admin']; // Vraćanje samo admin statusa, ne cijelog reda
    }

    public function eraseUser($id) {
        $st = $this->db->prepare('DELETE FROM korisnici WHERE id LIKE :id');
        $st->execute(['id' => $id]);
        return;
    }

    public function loginUser() {
        $st = $this->db->prepare('SELECT has_registered FROM korisnici WHERE username=:username');
        $st->execute(['username' => $_POST["username"]]);
        $row = $st->fetch();

        if ($row['has_registered'] === '0') // Provjera treba li vratiti false
            return false;

        $st = $this->db->prepare('SELECT password_hash FROM korisnici WHERE username=:username');
        $st->execute(['username' => $_POST["username"]]);
        $row = $st->fetch();

        return $row['password_hash']; // Vraćanje samo password_hash-a, ne cijelog reda
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
    
        $movie = new Movie($row['id'], $row['title'], $row['director'], $row['year'], $row['genre'], $row['actors'], $row['rating']);
        return $movie;
    }
    


    public function getWatchlist ()
        {
                $allmovies = [];

                $db = DB::getConnection();
                $st = $db->prepare( 'SELECT * FROM watchlists WHERE id_user=:id_user' );
                $st->execute( ['id_user' => $_SESSION['id_user']] );

                while( $row = $st->fetch() )
                $allmovies[] = new Watchlist( $row['id'], $row['id_user'], $row['id_movie'], $row['watched'] );

                return $allmovies;
        }

        public function getUsername() 
        {

            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM korisnici WHERE id=:id_user' );
            $st->execute( ['id' => $_SESSION['id_user']] );
            $row = $st->fetch();
            $user = new User ($row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'], $row['admin']);

            return $user->username;
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
            $st = $db->prepare( 'SELECT * FROM filmovi ORDER BY title' );
            $st->execute();
      
    
            while( $row = $st->fetch() )
                $movies[] = new Movie($row['id'], $row['title'], $row['director'], $row['year'], $row['genre'], $row['actors'], $row['rating']);
    
            return $movies;
        }
    
        public function getTopMovies ()
        {
            $movies = [];
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM filmovi ORDER BY rating DESC LIMIT 0,5' );
            $st->execute();
    
            while( $row = $st->fetch() )
                $movies[] = new Movie($row['id_movie'], $row['title'], $row['director'], $row['year'], $row['genre'], $row['cast'], $row['rating']);
    
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
            $st = $db->prepare( 'INSERT INTO komentari (id_user, id_movie, content, date) VALUE (:id_user, :id_movie, :content, :date)' );
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
            $st->execute( ['release_year' => $year] );
    
            while( $row = $st->fetch() )
            $allmovies[] = new Movie($row['id_movie'], $row['title'], $row['director'], $row['year'], $row['genre'], $row['cast'], $row['rating']);
    
            return $allmovies;
        }
        
        public function searchByActor($actorName) {
            $stmt = $this->db->prepare("SELECT * FROM movies WHERE actors LIKE :actorName");
            $actorName = '%' . $actorName . '%';
            $stmt->execute([':actorName' => $actorName]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

}

?>