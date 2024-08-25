<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/meni.php'; ?>

<br>

<form method="post" action="index.php?rt=movies/search">

    <p>
        Year: 
        <input type="text" list="datalist_godine" id="txt_year" name="txt_year">
        <datalist id="datalist_godine">
        </datalist>
        <button type="submit" name="searchyear">Pretraži filmove!</button>
    </p>

    <p>
        Genre:
        <select name="genre">
        <?php
        foreach ($genreList as $genre) {
            echo '<option value="' . htmlspecialchars($genre) . '">' . htmlspecialchars($genre) . '</option>';
        }
        ?>
        </select>
        <button type="submit" name="genrebutton">Pretraži filmove!</button>
    </p>

    <p>

    <form id="director_search_form" method="post" action="index.php?rt=movies/search">
    <p>
        Redatelj:
        <input type="text" name="search_input" list="datalist_director" id="director_search"> 
        <datalist id="datalist_director"></datalist>
        <button type="submit" name="bydirector" id="search_button">Pretraži!</button>
    </p>
    </form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    </p>

</form>

<div id="movies"></div>

<?php

foreach ($movieList as $movie) {
    echo '<ol>
            <li>' . htmlspecialchars($movie->title) . '</li>
            <li>' . htmlspecialchars($movie->rating) . '</li>
          </ol>';
}

?>



<?php require_once __DIR__ . '/_footer.php'; ?>
