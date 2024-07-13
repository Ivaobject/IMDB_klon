<?php


require __DIR__ . '/app/database/db.class.php';


function sendJSONandExit( $message )
{

    header( 'Content-type:application/json;charset=utf-8' );
    echo json_encode( $message );
    flush();
    exit( 0 );
}

function sendErrorAndExit( $messageText )
{
	$message = [];
	$message[ 'error' ] = $messageText;
	sendJSONandExit( $message );
}

if( !isset( $_GET['q'] ) )
	sendErrorAndExit( "Nije poslan korisnikov unos." );


$q = $_GET[ "q" ];
$lowerq = strtolower($q);


    $db = DB::getConnection();

    $st = $db->prepare( "SELECT * FROM filmovi ORDER BY title" );
    $st->execute();

    $message = [];
    $message[ 'movies' ] = [];

    while( $row = $st->fetch() )
    {
   
        $title = strtolower( $row['title'] );
        if( strpos( $title, $q ) !== false )
          $message[ 'movies' ][] = array( 'id_movie' => $row['id_movie'], 'title' => $row['title'], 'director' => $row['director'], 'year' => $row['year'], 'genre' => $row['genre'], 'cast' => $row['cast'], 'rating' => $row['rating']);			
    }
                                                                                                                            

    sendJSONandExit( $message );
	
?>