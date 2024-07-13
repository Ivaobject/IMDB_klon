<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/meni.php'; ?>

<ul>
<?php

echo '<h3>' . htmlspecialchars($title) . '</h3>';

echo '<ol>';
if (!empty($movieList)) {
    foreach ($movieList as $index => $movie) {
        if (!empty($movie) && isset($nwatchlistsList[$index])) {
            echo '<li>
                    <form method="post" action="index.php?rt=movies/movie">
                        <input type="submit" name="movie_title" value="' . htmlspecialchars($movie->title) . '" />
                        <input type="hidden" name="movie_id" value="' . htmlspecialchars($movie->id) . '" />
                    </form>
                    Broj ljudi koji ima ovaj film na svojem watchlistu: ' . htmlspecialchars($nwatchlistsList[$index]) . '
                    <br><br>
                  </li>';
        } else {
            echo '<li>Film nije pronađen ili nedostaju informacije.</li>';
        }
    }
} else {
    echo '<li>Nema filmova za prikaz.</li>';
}
echo '</ol>';
?>
</ul>

<?php require_once __DIR__ . '/_footer.php'; ?>