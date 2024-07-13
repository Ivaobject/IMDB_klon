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
            'password_hash VARCHAR(255) NOT NULL,' .
            'email VARCHAR(50) NOT NULL UNIQUE,' .
            'registration_sequence VARCHAR(50) NOT NULL,' .
            'has_registered INT DEFAULT -1,' .
            'admin INT DEFAULT -1)'
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
            'title VARCHAR(50) NOT NULL,' .
            'genre VARCHAR(50) NOT NULL,' .
            'year INT NOT NULL,' .
            'director VARCHAR(50),' .
            'actors TEXT)'
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
			'id_user int NOT NULL,' .
			'id_movie int NOT NULL,' .
			'rating int NOT NULL)'
		);

        $st->execute();
    }
    catch( PDOException $e ) { exit( "PDO error (create_table_ocijene): " . $e->getMessage() ); }

    echo "Napravio tablicu ocijene.<br />";
}

function create_table_watchlists()
{
    $db = DB::getConnection();

    try
    {
			$st = $db->prepare( 
				'CREATE TABLE IF NOT EXISTS watchlists (' .
				'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
				'id_user int NOT NULL,' .
				'id_movie int NOT NULL,' .
				'watched int)'
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
			'id_user INT NOT NULL,' .
			'id_movie INT NOT NULL,' .
			'tekst varchar(1000) NOT NULL,' .
			'datum DATETIME NOT NULL)'
		);

        $st->execute();
    }
    catch( PDOException $e ) { exit( "PDO error (create_table_komentari): " . $e->getMessage() ); }

    echo "Napravio tablicu komentari.<br />";
}
?>
