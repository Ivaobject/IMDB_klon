<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/menu.php'; ?>

<ul>
<?php

echo '<h3>' . htmlspecialchars($title) . '</h3>';

echo '<ol>';
foreach ($movieList as $index => $movie) {
    echo '<li>
            <form method="post" action="teka.php?rt=movies/movie">
                <input type="submit" name="movie_title" value="' . htmlspecialchars($movie->title) . '" />
                <input type="hidden" name="movie_id" value="' . htmlspecialchars($movie->id_movie) . '" />
            </form>
            Number of people who have this on their Watchlist: ' . htmlspecialchars($nwatchlistsList[$index]) . '
            <br><br>
          </li>';
}
echo '</ol>';
?>
</ul>

<?php require_once __DIR__ . '/_footer.php'; ?>
