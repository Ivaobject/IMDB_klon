<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/meni.php'; ?>

<h3><?php echo htmlspecialchars($title); ?></h3>
<p>Username: <?php echo htmlspecialchars($username); ?></p>

<br>

<h4>Watchlist:</h4>
<?php
if ($emptylist === 'Your Watchlist is empty!') {
    echo htmlspecialchars($emptylist);
} else {
    echo '<ul>';
    foreach ($movieList as $movie) {
        echo '<li>
                <form method="post" action="index.php?rt=movies/movie">
                    <input type="submit" name="movie_title" value="' . htmlspecialchars($movie->title) . '" />
                    <input type="hidden" name="movie_id" value="' . htmlspecialchars($movie->id_movie) . '" />
                </form>
              </li>';
    }
    echo '</ul>';
}

echo '<h4>Your ratings:</h4>';

if ($emptyratings === "You haven't rated any movies!") {
    echo htmlspecialchars($emptyratings);
} else {
    echo '<ul>';
    foreach ($ratedMoviesList as $index => $movie) {
        echo '<li>
                <form method="post" action="index.php?rt=movies/movie">
                    <input type="submit" name="movie_title" value="' . htmlspecialchars($movie->title) . '" />
                    <input type="hidden" name="movie_id" value="' . htmlspecialchars($movie->id_movie) . '" />
                </form>
                Your rating: ' . htmlspecialchars($ratingsList[$index]) . '
              </li>';
    }
    echo '</ul>';
}
?>

<br>
<br>

<form method="post" action="index.php?rt=admin/logout">
    <button type="submit" name="logout">Log out</button>
</form>

<?php require_once __DIR__ . '/_footer.php'; ?>
