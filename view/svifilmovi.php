<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/meni.php'; ?>

<ul> 
<?php
?>
<h3> <?php echo $title; ?> </h3>

<ul>
<?php
foreach ($movieList as $movie): ?>
    <li>
        <form method="post" action="index.php?rt=movies/movie">
            <input type="submit" name="movie_title" value="<?php echo $movie->title; ?>" />
            <input type="hidden" name="id_movie" value="<?php echo $movie->id; ?>" />
        </form>
        Žanr:<?php echo ($movie->rating === 0) ? 'Još nitko nije ocijenio taj film!' : $movie->genre; ?>

 
        <br>
        
        

        <br><br>
    </li>
<?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/_footer.php'; ?>