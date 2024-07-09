<?php

require_once __DIR__ . '/db.class.php';

create_table_korisnici();
create_table_filmovi();
create_table_komentari();
create_table_ocijene();
create_table_watchlists();


function create_table_korisnici()
{
	$db = DB::getConnection();

	
	try
	{
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
}


function create_table_filmovi()
{
	$db = DB::getConnection();

	
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
}


function create_table_ocijene()
{
	$db = DB::getConnection();

	try
	{
		$st = $db->prepare(
			'CREATE TABLE IF NOT EXISTS ocijene (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'user_id INT,'.
            'movie_id INT,'.
            'rating INT CHECK (rating >= 1 AND rating <= 5),'.
            'comment TEXT,'.
            'FOREIGN KEY (user_id) REFERENCES korisnici(id),'.
            'FOREIGN KEY (movie_id) REFERENCES filmovi(id)'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error (create_table_ocijene: " . $e->getMessage() ); }

	echo "Napravio tablicu ocijene.<br />";
}



function create_table_watchlists()
{
	$db = DB::getConnection();

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
}


function create_table_komentari()
{
	$db = DB::getConnection();

	try
	{
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
	}
	catch( PDOException $e ) { exit( "PDO error (create_table_komentari): " . $e->getMessage() ); }

	echo "Napravio tablicu komentari.<br />";
}
?>
