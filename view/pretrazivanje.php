<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/meni.php'; ?>

<br>

<form method="post" action="teka.php?rt=movies/search">

    <p>
        Year: 
        <input type="text" list="datalist_godine" id="txt_year" name="txt_year">
        <datalist id="datalist_godine">
        </datalist>
        <button type="submit" name="searchyear">Search movies!</button>
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
        <button type="submit" name="genrebutton">Search movies!</button>
    </p>

    <p>
        Director:
        <input type="text" name="search_input" list="datalist_director" id="director_search"> 
        <datalist id="datalist_director">
        </datalist>
        <button type="submit" name="bydirector">Search!</button>
    </p>

</form>

<p id="movies"></p>

<?php

foreach ($movieList as $movie) {
    echo '<ol>
            <li>' . htmlspecialchars($movie->title) . '</li>
            <li>' . htmlspecialchars($movie->rating) . '</li>
          </ol>';
}

?>

<script src="directorSearch.js"></script>
<?php require_once __DIR__ . '/_footer.php'; ?>
