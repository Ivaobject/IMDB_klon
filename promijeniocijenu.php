<?php
require __DIR__ . '/model/funkcije.class.php';

function sendJSONandExit($message) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode($message);
    flush();
    exit(0);
}

if (!isset($_POST["ocjena"]) || !isset($_POST["user_id"]) || !isset($_POST["movie_id"])) {
    exit('Error: Missing required parameters.');
}

$ocjena = (int) $_POST["ocjena"];
$user_id = (int) $_POST["user_id"];
$movie_id = (int) $_POST["movie_id"];

$x = new functions;

$x->changeRating($ocjena, $user_id, $movie_id);

$message = [];
$message['average'] = $x->getAverageRating($movie_id);
$message['your'] = $x->getRatingOfUser($movie_id, $user_id);

sendJSONandExit($message);
?>

