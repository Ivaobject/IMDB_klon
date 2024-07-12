<?php

require_once 'db.class.php';


function seed_table_ocijene()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare('INSERT INTO ocijene(user_id, movie_id, rating) VALUES (:user_id, :movie_id, :rating)');

        // Ocjene za filmove
        $st->execute(array('user_id' => 1, 'movie_id' => 1, 'rating' => 9)); // Pero ocjenjuje The Shawshank Redemption
        $st->execute(array('user_id' => 2, 'movie_id' => 2, 'rating' => 10)); // Mirko ocjenjuje The Godfather
        $st->execute(array('user_id' => 3, 'movie_id' => 3, 'rating' => 8)); // Slavko ocjenjuje The Dark Knight
        $st->execute(array('user_id' => 4, 'movie_id' => 4, 'rating' => 9)); // Ana ocjenjuje Pulp Fiction
        $st->execute(array('user_id' => 5, 'movie_id' => 5, 'rating' => 10)); // Maja ocjenjuje Forrest Gump
        $st->execute(array('user_id' => 1, 'movie_id' => 3, 'rating' => 7)); // Pero ocjenjuje The Dark Knight
        $st->execute(array('user_id' => 4, 'movie_id' => 2, 'rating' => 10)); // Ana ocjenjuje The Godfather
        $st->execute(array('user_id' => 1, 'movie_id' => 5, 'rating' => 6)); // Pero ocjenjuje Forrest Gump

    } catch (PDOException $e) {
        exit("PDO error (seed_table_ocijene): " . $e->getMessage());
    }

    echo "Ubacio ocijene u tablicu ocijene.<br />";
}

function seed_table_komentari()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare('INSERT INTO komentari(id_korisnik, id_film, tekst, datum) VALUES (:id_korisnik, :id_film, :tekst, :datum)');

        // Komentari na filmove
        $st->execute(array('id_korisnik' => 1, 'id_film' => 1, 'tekst' => 'Odličan film!', 'datum' => '2023-01-01')); // Pero komentira The Shawshank Redemption
        $st->execute(array('id_korisnik' => 2, 'id_film' => 2, 'tekst' => 'Klasična kriminalistička drama.', 'datum' => '2023-01-02')); // Mirko komentira The Godfather
        $st->execute(array('id_korisnik' => 3, 'id_film' => 3, 'tekst' => 'Fantastična izvedba!', 'datum' => '2023-01-03')); // Slavko komentira The Dark Knight
        $st->execute(array('id_korisnik' => 4, 'id_film' => 4, 'tekst' => 'Sjajan scenarij i režija.', 'datum' => '2023-01-04')); // Ana komentira Pulp Fiction
        $st->execute(array('id_korisnik' => 5, 'id_film' => 5, 'tekst' => 'Dirljiv film.', 'datum' => '2023-01-05')); // Maja komentira Forrest Gump

    } catch (PDOException $e) {
        exit("PDO error (seed_table_komentari): " . $e->getMessage());
    }

    echo "Ubacio komentare u tablicu komentari.<br />";
}

function seed_table_watchlists()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare('INSERT INTO watchlists(user_id, movie_id, watched) VALUES (:user_id, :movie_id, :watched)');

        // Watchlists za filmove
        $st->execute(array('user_id' => 1, 'movie_id' => 2, 'watched' => false)); // Pero želi pogledati The Godfather
        $st->execute(array('user_id' => 2, 'movie_id' => 3, 'watched' => true)); // Mirko je pogledao The Dark Knight
        $st->execute(array('user_id' => 3, 'movie_id' => 4, 'watched' => false)); // Slavko želi pogledati Pulp Fiction
        $st->execute(array('user_id' => 4, 'movie_id' => 5, 'watched' => true)); // Ana je pogledala Forrest Gump
        $st->execute(array('user_id' => 5, 'movie_id' => 1, 'watched' => false)); // Maja želi pogledati The Shawshank Redemption

    } catch (PDOException $e) {
        exit("PDO error (seed_table_watchlists): " . $e->getMessage());
    }

    echo "Ubacio filmove u watchlist.<br />";
}

// Pozovi funkcije za popunjavanje tablica
seed_table_ocijene();
seed_table_komentari();
seed_table_watchlists();
?>

