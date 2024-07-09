<?php

require_once __DIR__ . '/db.class.php';


$db = DB::getConnection();


try {
    $st = $db->prepare(
        'CREATE TABLE IF NOT EXISTS korisnici (' .
        'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
        'username VARCHAR(50) NOT NULL UNIQUE,' .
        'password VARCHAR(50) NOT NULL,' .
        'email VARCHAR(50) NOT NULL UNIQUE,' .
        'registration_sequence VARCHAR(50) NOT NULL,' .
        'has_registered BOOLEAN DEFAULT FALSE,' .
        'admin BOOLEAN DEFAULT FALSE)'
    );

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error (create_table_korisnici): " . $e->getMessage() ); }

echo "Napravio tablicu korisnici.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS filmovi (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'title VARCHAR(50) NOT NULL,'.
        'genre VARCHAR(50) NOT NULL,'.
        'year INT NOT NULL,'.
        'director VARCHAR(50),'.
        'actors TEXT'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error (create_table_filmovi): " . $e->getMessage() ); }

echo "Napravio tablicu filmovi.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS ocijene (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'user_id INT,'.
        'movie_id INT,'.
        'rating INT CHECK (rating >= 1 AND rating <= 10),'.
        'FOREIGN KEY (user_id) REFERENCES korisnici(id),'.
        'FOREIGN KEY (movie_id) REFERENCES filmovi(id)'
		);

	$st->execute();
	}
catch( PDOException $e ) { exit( "PDO error (create_table_ocijene): " . $e->getMessage() ); }

echo "Napravio tablicu ocijene.<br />";


try
{
	$st = $db->prepare(
	    'CREATE TABLE IF NOT EXISTS watchlists ('.
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,'.
		'user_id INT NOT NULL,'.
		'movie_id INT NOT NULL,'.
		'watched BOOLEAN DEFAULT FALSE,'.
		'FOREIGN KEY (user_id) REFERENCES korisnici(id),'.
		'FOREIGN KEY (movie_id) REFERENCES filmovi(id)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error (create_table_watchlists): " . $e->getMessage() ); }

echo "Napravio tablicu watchlists.<br />";


try {
    $st = $db->prepare(
        'CREATE TABLE IF NOT EXISTS komentari (' .
        'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
        'id_korisnik int NOT NULL,' .
        'id_film int NOT NULL,' .
        'tekst TEXT NOT NULL,' .
        'datum DATE NOT NULL,' .
        'FOREIGN KEY (id_korisnik) REFERENCES korisnici(id),' .
        'FOREIGN KEY (id_film) REFERENCES filmovi(id))'
    );

    $st->execute();
} catch (PDOException $e) {
    exit("PDO error (create_table_komentari): " . $e->getMessage());
}

echo "Napravio tablicu komentari.<br />";



try {
    $st = $db->prepare('INSERT INTO korisnici(username, password, email, registration_sequence, has_registered, is_admin) VALUES (:username, :password, :email, :registration_sequence, :has_registered, :is_admin)');

    $st->execute(array(
        'username' => 'Pero', 
        'password' => password_hash('perinasifra', PASSWORD_DEFAULT), 
        'email' => 'pero@gmail.com', 
        'registration_sequence' => 'seq1234', 
        'has_registered' => true, 
        'admin' => false
    ));

    $st->execute(array(
        'username' => 'Mirko', 
        'password' => password_hash('mirkovasifra', PASSWORD_DEFAULT), 
        'email' => 'mirko@yahoo.com', 
        'registration_sequence' => 'seq5678', 
        'has_registered' => true, 
        'admin' => false
    ));

    $st->execute(array(
        'username' => 'Slavko', 
        'password' => password_hash('slavkovasifra', PASSWORD_DEFAULT), 
        'email' => 'slavko@gmail.com', 
        'registration_sequence' => 'seq91011', 
        'has_registered' => true, 
        'admin' => false
    ));

    $st->execute(array(
        'username' => 'Ana', 
        'password' => password_hash('aninasifra', PASSWORD_DEFAULT), 
        'email' => 'ana@gmail.com', 
        'registration_sequence' => 'seq1213', 
        'has_registered' => true, 
        'admin' => false
    ));

    $st->execute(array(
        'username' => 'Maja', 
        'password' => password_hash('majinasifra', PASSWORD_DEFAULT), 
        'email' => 'maja@gmail.com', 
        'registration_sequence' => 'seq1415', 
        'has_registered' => true, 
        'admin' => true
    ));
}

echo "Ubacio korisnike u tablicu korisnici.<br />";



try {
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


