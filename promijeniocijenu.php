
<?php

require __DIR__ . '/model/funkcije.class.php';

function sendJSONandExit( $message )
{

    header( 'Content-type:application/json;charset=utf-8' );
    echo json_encode( $message );
    flush();
    exit( 0 );
}

$ocjena = $_GET[ "ocjena" ];
$user_id = $_GET[ "user_id" ];
$movie_id = $_GET[ "movie_id" ];

$x = new functions;

$x->changeRating($ocjena, $user_id, $movie_id);

$message = [];
$message[ 'average' ] = $x->getAverageRating( $movie_id );
$message[ 'your' ] = $x->getRatingOfUser( $movie_id, $user_id ); 

sendJSONandExit( $message );



?>
