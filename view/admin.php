<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h3, h4 {
            color: #333;
        }
        p {
            color: #666;
        }
        ol, ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        form {
            display: inline-block;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        input[type="text"] {
            padding: 8px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .admin-options {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php require_once __DIR__ . '/_header.php'; ?>
        <?php require_once __DIR__ . '/meni.php'; ?>

        <h3><?php echo $title; ?></h3>
        <p>Username: <?php echo $username; ?><br>[admin]</p>

        <?php
        $ls = new functions;

        $movieList = $ls->getWatchlist();
        if ($movieList === null) {
            $movieList = [];
        }
        ?>

        <div class="watchlist">
            <h4>Watchlist:</h4>
            <ol>
                <?php   foreach ($movieList as $movie) {
                echo '<li>';
                echo htmlspecialchars($movie->title);
                echo '</li>';
        }
                   
            ?>
            </ol>
        </div>
        <div class="ratings">
        <h4>Vaše ocijene:</h4>
        <?php if ($emptyratings === "Niste ocjenili nijedan film!"): ?>
            <p><?php echo $emptyratings; ?></p>
        <?php else: ?>
            <ul>
                <?php foreach ($ratedMoviesList as $index => $movie): ?>
                    <li>
                        <strong><?php echo $movie->title; ?></strong>
                        <span>Vaša ocjena: <?php echo $ratingsList[$index]; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

        <div class="admin-options">
            <h4>Add a new movie</h4>
            <form method="post" action="IMDB_klon.php?rt=admin/newmovie">
                <div class="form-group">
                    <label for="newtitle">Naslov:</label>
                    <input type="text" id="newtitle" name="newtitle">
                </div>
                <div class="form-group">
                    <label for="newyear">Godina:</label>
                    <input type="text" id="newyear" name="newyear">
                </div>
                <div class="form-group">
                    <label for="newgenre">Žanr:</label>
                    <input type="text" id="newgenre" name="newgenre">
                </div>
                <div class="form-group">
                    <label for="newdirector">Režiser:</label>
                    <input type="text" id="newdirector" name="newdirector">
                </div>
                <div class="form-group">
                    <label for="newcast">Postava:</label>
                    <input type="text" id="newcast" name="newcast">
                </div>
                <button type="submit" name="newmovie">Dodaj!</button>
            </form>

            <h4>Obriši korisnika</h4>
            <form method="post" action="IMDB_klon.php?rt=admin/eraseuser">
                <input type="text" name="search_users" placeholder="Enter username">
                <button type="submit" name="eraseuser">Obriši!</button>
            </form>

            <h4>Obriši komentar</h4>
            <form method="post" action="IMDB_klon.php?rt=admin/erasecomment">
                <input type="text" name="search_comments" placeholder="Enter comment ID">
                <button type="submit" name="erasecomment">Obriši!</button>
            </form>
            <br>

            <h4>Novi admin</h4>
            <form method="post" action="IMDB_klon.php?rt=admin/addadmin">
                <input type="text" name="new_admin" placeholder="Enter username">
                <button type="submit" name="addadmin">Dodaj admina</button>
            </form>

            <span><?php echo $info; ?></span>
            <br>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?rt=admin/logout">
                <button type="submit" name="logout">Izlogiraj se</button>
            </form>
        </div>
        <?php require_once __DIR__ . '/_footer.php'; ?>
    </div>
</body>
</html>
