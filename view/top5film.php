<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/menu.php'; ?>

<h3><?php echo htmlspecialchars($title); ?></h3>

<ul>
<ol>
<?php
foreach ($movieList as $movie) {
    echo '<li>
            <form method="post" action="teka.php?rt=movies/movie">
                <input type="submit" name="movie_title" value="' . htmlspecialchars($movie->title) . '" />
                <input type="hidden" name="movie_id" value="' . htmlspecialchars($movie->id_movie) . '" />
            </form>
            Average rating: ';
    if ((int) $movie->average_rating === -1) {
        echo 'No one has rated this movie yet!';
    } else {
        echo htmlspecialchars($movie->average_rating);
    }
    echo '<br><br>
          </li>';
}
?>
</ol>
</ul>

<?php require_once __DIR__ . '/_footer.php'; ?>

