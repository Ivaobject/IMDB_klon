<?php

require_once 'db.class.php';


function seed_table_ocijene()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare('INSERT INTO ocijene(id_user, id_movie, rating) VALUES (:id_user, :id_movie, :rating)');

        // Ocjene za filmove
        $st->execute(array('id_user' => 1, 'id_movie' => 1, 'rating' => 9)); // Pero ocjenjuje The Shawshank Redemption
        $st->execute(array('id_user' => 2, 'id_movie' => 2, 'rating' => 10)); // Mirko ocjenjuje The Godfather
        $st->execute(array('id_user' => 3, 'id_movie' => 3, 'rating' => 8)); // Slavko ocjenjuje The Dark Knight
        $st->execute(array('id_user' => 4, 'id_movie' => 4, 'rating' => 9)); // Ana ocjenjuje Pulp Fiction
        $st->execute(array('id_user' => 5, 'id_movie' => 5, 'rating' => 10)); // Maja ocjenjuje Forrest Gump
        $st->execute(array('id_user' => 1, 'id_movie' => 3, 'rating' => 7)); // Pero ocjenjuje The Dark Knight
        $st->execute(array('id_user' => 4, 'id_movie' => 2, 'rating' => 10)); // Ana ocjenjuje The Godfather
        $st->execute(array('id_user' => 1, 'id_movie' => 5, 'rating' => 6)); // Pero ocjenjuje Forrest Gump

    } catch (PDOException $e) {
        exit("PDO error (seed_table_ocijene): " . $e->getMessage());
    }

    echo "Ubacio ocijene u tablicu ocijene.<br />";
}

function seed_table_komentari()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare('INSERT INTO komentari(id_user, id_movie, tekst, datum) VALUES (:id_user, :id_movie, :tekst, :datum)');

        // Komentari na filmove
        $st->execute(array('id_user' => 1, 'id_movie' => 1, 'tekst' => 'Odličan film!', 'datum' => '2023-01-01')); // Pero komentira The Shawshank Redemption
        $st->execute(array('id_user' => 2, 'id_movie' => 2, 'tekst' => 'Klasična kriminalistička drama.', 'datum' => '2023-01-02')); // Mirko komentira The Godfather
        $st->execute(array('id_user' => 3, 'id_movie' => 3, 'tekst' => 'Fantastična izvedba!', 'datum' => '2023-01-03')); // Slavko komentira The Dark Knight
        $st->execute(array('id_user' => 4, 'id_movie' => 4, 'tekst' => 'Sjajan scenarij i režija.', 'datum' => '2023-01-04')); // Ana komentira Pulp Fiction
        $st->execute(array('id_user' => 5, 'id_movie' => 5, 'tekst' => 'Dirljiv film.', 'datum' => '2023-01-05')); // Maja komentira Forrest Gump

    } catch (PDOException $e) {
        exit("PDO error (seed_table_komentari): " . $e->getMessage());
    }

    echo "Ubacio komentare u tablicu komentari.<br />";
}

function seed_table_watchlists()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare('INSERT INTO watchlists(id_user, id_movie, watched) VALUES (:id_user, :id_movie, :watched)');

        // Watchlists za filmove
        $st->execute(array('id_user' => 1, 'id_movie' => 2, 'watched' => -1)); // Pero želi pogledati The Godfather
        $st->execute(array('id_user' => 2, 'id_movie' => 3, 'watched' => 1)); // Mirko je pogledao The Dark Knight
        $st->execute(array('id_user' => 3, 'id_movie' => 4, 'watched' => -1)); // Slavko želi pogledati Pulp Fiction
        $st->execute(array('id_user' => 4, 'id_movie' => 5, 'watched' => 1)); // Ana je pogledala Forrest Gump
        $st->execute(array('id_user' => 5, 'id_movie' => 1, 'watched' => -1)); // Maja želi pogledati The Shawshank Redemption

    } catch (PDOException $e) {
        exit("PDO error (seed_table_watchlists): " . $e->getMessage());
    }

    echo "Ubacio filmove u watchlist.<br />";
}

function seed_table_korisnici(){

    $db = DB::getConnection();

    try {
        $st = $db->prepare('INSERT INTO korisnici(username, password_hash, email, registration_sequence, has_registered, admin) VALUES (:username, :password_hash, :email, :registration_sequence, :has_registered, :admin)');

        $st->execute(array(
            'username' => 'Pero', 
            'password_hash' => password_hash('perinas', PASSWORD_DEFAULT), 
            'email' => 'pero@gmail.com', 
            'registration_sequence' => 'seq1234', 
            'has_registered' => 1, 
            'admin' => -1
        ));


        $st->execute(array(
            'username' => 'Mirko', 
            'password_hash' => password_hash('mirkovas', PASSWORD_DEFAULT), 
            'email' => 'mirko@yahoo.com', 
            'registration_sequence' => 'seq5678', 
            'has_registered' => 1, 
            'admin' => -1
        ));

        $st->execute(array(
            'username' => 'Slavko', 
            'password_hash' => password_hash('slavkovas', PASSWORD_DEFAULT), 
            'email' => 'slavko@gmail.com', 
            'registration_sequence' => 'seq91011', 
            'has_registered' => 1, 
            'admin' => -1
        ));

        $st->execute(array(
            'username' => 'Ana', 
            'password_hash' => password_hash('aninas', PASSWORD_DEFAULT), 
            'email' => 'ana@gmail.com', 
            'registration_sequence' => 'seq1213', 
            'has_registered' => 1, 
            'admin' => -1
        ));

        $st->execute(array(
            'username' => 'Maja', 
            'password_hash' => password_hash('majinas', PASSWORD_DEFAULT), 
            'email' => 'maja@gmail.com', 
            'registration_sequence' => 'seq1415', 
            'has_registered' => 1, 
            'admin' => -1
        ));
    }catch (PDOException $e) {
        exit("PDO error (seed_table_korisnici): " . $e->getMessage());
    }

    echo "Ubacio korisnike u tablicu.<br />";
}




function seed_table_filmovi(){
    try {
        $db = DB::getConnection();

        $st = $db->prepare('INSERT INTO filmovi(title, genre, year, director, actors) VALUES (:title, :genre, :year, :director, :actors)');

        $st->execute(array(
            'title' => 'The Shawshank Redemption',
            'genre' => 'Drama',
            'year' => 1994,
            'director' => 'Frank Darabont',
            'actors' => 'Tim Robbins, Morgan Freeman, Bob Gunton'
        ));

        $st->execute(array(
            'title' => 'The Godfather',
            'genre' => 'Crime, Drama',
            'year' => 1972,
            'director' => 'Francis Ford Coppola',
            'actors' => 'Marlon Brando, Al Pacino, James Caan'
        ));

        $st->execute(array(
            'title' => 'The Dark Knight',
            'genre' => 'Action, Crime, Drama',
            'year' => 2008,
            'director' => 'Christopher Nolan',
            'actors' => 'Christian Bale, Heath Ledger, Aaron Eckhart'
        ));

        $st->execute(array(
            'title' => 'Pulp Fiction',
            'genre' => 'Crime, Drama',
            'year' => 1994,
            'director' => 'Quentin Tarantino',
            'actors' => 'John Travolta, Uma Thurman, Samuel L. Jackson'
        ));

        $st->execute(array(
            'title' => 'Forrest Gump',
            'genre' => 'Drama, Romance',
            'year' => 1994,
            'director' => 'Robert Zemeckis',
            'actors' => 'Tom Hanks, Robin Wright, Gary Sinise'
        ));
    } catch (PDOException $e) {
        exit("PDO error #5: " . $e->getMessage());
    }


    echo "Ubacio filmove u tablicu filmovi.<br />";
}

function seed_table_ocjene()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare('INSERT INTO ocjene(id_user, id_movie, rating) VALUES (:id_user, :id_movie, :rating)');

        // Ocjene za filmove
        $st->execute(array('id_user' => 1, 'id_movie' => 1, 'rating' => 9)); // Pero ocjenjuje The Shawshank Redemption
        $st->execute(array('id_user' => 2, 'id_movie' => 2, 'rating' => 10)); // Mirko ocjenjuje The Godfather
        $st->execute(array('id_user' => 3, 'id_movie' => 3, 'rating' => 8)); // Slavko ocjenjuje The Dark Knight
        $st->execute(array('id_user' => 4, 'id_movie' => 4, 'rating' => 9)); // Ana ocjenjuje Pulp Fiction
        $st->execute(array('id_user' => 5, 'id_movie' => 5, 'rating' => 10)); // Maja ocjenjuje Forrest Gump
        $st->execute(array('id_user' => 1, 'id_movie' => 3, 'rating' => 7)); // Pero ocjenjuje The Dark Knight
        $st->execute(array('id_user' => 4, 'id_movie' => 2, 'rating' => 10)); // Ana ocjenjuje The Godfather
        $st->execute(array('id_user' => 1, 'id_movie' => 5, 'rating' => 6)); // Pero ocjenjuje Forrest Gump

    } catch (PDOException $e) {
        exit("PDO error (seed_table_ocjene): " . $e->getMessage());
    }

    echo "Ubacio ocijene u tablicu ocjene.<br />";
}




// Pozovi funkcije za popunjavanje tablica
//seed_table_ocijene();
//seed_table_komentari();
//seed_table_watchlists();
//seed_table_korisnici();
//seed_table_filmovi();

seed_table_ocjene();
?>

