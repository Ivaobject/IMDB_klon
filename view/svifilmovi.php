<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/meni.php'; ?>

<ul> 
<?php
?>
<h3> <?php echo $title; ?> </h3>

<ul>
<?php
foreach( $movieList as $movie )
{
    echo
    '<li>' .
    '<form method="post" action="index.php?rt=filmovi/movie">' .
    '<input type="submit" name="movie_title" value="' .
    $movie->title .
    '" />' .
    '<input type="hidden" name="movie_id" value="' .
    $movie->id .
    '" />' .
    '</form>' .
    'Ocijena: ' ;
    if( (int) $movie->rating === -1)
        echo 'Još nitko nije ocijenio taj film!';
    else 
        echo $movie->rating;
    echo
    '<br>' .
    '<br>' .
    '</li>';
}
?>
</ul>

<?php require_once __DIR__ . '/_footer.php'; ?>