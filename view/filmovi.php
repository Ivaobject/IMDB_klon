
<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/meni.php'; ?>

<h2><?php echo $title; ?></h2>

<ul>
    <li>
        <?php if ((int) $movie->rating === 0): ?>
            <span id="prosocijena">Nitko još nije ocijenio ovaj film.</span>
        <?php else: ?>
            <span id="prosocijena"><?php echo $movie->rating; ?></span>
        <?php endif; ?>
    </li>
    <li>Godina: <?php echo $movie->year; ?></li>
    <li>Žanr: <?php echo $movie->genre; ?></li>
    <li>Redatelj: <?php echo $movie->director; ?></li>
</ul>

<br>

<?php if ($rating !== -2): ?>
    <?php if ($rating !== -1): ?>
        Vaša ocjena: <span id="tvojaocijena"><?php echo $rating; ?></span>
    <?php else: ?>
        Your rating: <span id="tvojaocijena">Niste još ocijenili ovaj film!</span>
    <?php endif; ?>

    <form method="post" action="index.php?rt=movies/rate">
        <input type="hidden" name="id_movie" value="<?php echo $movie->id; ?>">
        <h4>Ocijenite ovaj film:</h4>
        <select name="rating" id="rating">
            <?php for ($i = 0; $i <= 10; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit" name="rate" id="rate">Ocijeni!</button>
    </form>
<?php endif; ?>

<br><br>

<?php if (isset($isOnWatchlist) && !$isOnWatchlist): ?>
    <form method="post" action="index.php?rt=movies/watchlist">
        <input type="hidden" name="id_movie" value="<?php echo $movie->id; ?>">
        <button type="submit" name="watchlist">Dodajte film na svoj watchlist!</button>
    </form>
    <br>
<?php endif; ?>

<h4>Glumci</h4>
<?php foreach ($castList as $cast): ?>
    <p><?php echo $cast; ?><br></p>
<?php endforeach; ?>

<br>

<h3>Komentari</h3>
<?php foreach ($commentList as $i => $comment): ?>
    <p><?php echo $usersList[$i]; ?> <?php echo $comment->tekst; ?><br><?php echo $comment->datum; ?><br></p>
<?php endforeach; ?>

<br>

<label for="newreview">
    Dodaj komentar:
    <form method="post" action="index.php?rt=movies/newcomment">
        <input type="hidden" name="id_movie" value="<?php echo $movie->id; ?>">
        <textarea name="content" cols="100" rows="10"></textarea>
        <br>
        <button type="submit" name="comment">Pošalji komentar!</button>
    </form>
</label>

<script src="promijeniocijenu.js"></script>

<?php require_once __DIR__ . '/_footer.php'; ?>