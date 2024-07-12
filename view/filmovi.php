<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/menu.php'; ?>

<?php


echo '<h2>' . $title . '</h2>';

echo
    '<ul>' . 
    '<li>: ';
    if( (int) $movie->rating === -1)
        echo '<span id="prosocijena">' .'Nitko još nije ocijenio ovaj film.' . '</span>';
    else 
        echo '<span id="prosocijena">' .$movie->rating . '</span>';
echo
    '</li>' .
    '<li>Godina: ' .
    $movie->year .
    '</li>' .
    '<li>Žanr: ' .
    $movie->genre .
    '</li>' .
    '<li>Redatelj: ' .
    $movie->director .
    '</li>' .
    '</ul>';

echo '<br>';
if( $rating !== -2 )
{
    if( $rating !== -1 )
    {
        echo 'Vaša ocijena: ' . '<span id="tvojaocijena">' . $rating . '</span>';
    }
    else
    {
        echo 'Your rating: ' . '<span id="tvojaocijena">' . "Niste još ocijenili ovaj film!" . '</span>';
    }

    echo '
    <h4>Rate this movie:</h4>
    <select name="rating" id="rating">
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
    </select>
    <button type="submit" name="rate" id="rate">Ocijeni!</button>';
}

echo '<br><br>';

if( !$isOnWatchlist )
{
    echo 
    '<label for="newwatchlist">
    <form method="post" action="index.php?rt=movies/watchlist">
    <button type="submit" name="watchlist">Dodajte film na svoj watchlist!</button>
    </label>
    </form>';
    echo '<br>';
}


echo '<h4>' . 'Cast' . '</h4>';
    foreach ( $castList as $cast )
    {
        
        echo 
            '<p>' . 
            $cast . ' ' .
            '<br>' .
            '</p>';
    }

echo '<br>';

echo '<h3>' . 'Komentari' . '</h3>';
$i = 0;
    foreach ( $commentList as $comment )
    {        
        echo 
            '<p>' . 
            $usersList[$i++] . ' ' .
            $comment->tekst .
            '<br>' .
            $comment->datum .
            '<br>' .
            '</p>';
    }
?>

<?php 
echo '<br>
<label for="newreview">
Dodaj komentar:
<br>
<form method="post" action="index.php?rt=movies/newcomment">
<textarea name="content" cols="100" rows="10"></textarea>
</label>
<br>
<button type="submit" name="comment">Pošalji komentar!</button>
</form>';

?>


<?php require_once __DIR__ . '/_footer.php'; ?>