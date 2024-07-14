<?php

require __DIR__ . '/../../model/functions.class.php';

$ls = new functions;


for( $i = 1; $i <= 5; $i++ )
        $ls->updateAverageRating($i, $ls->getAverageRating($i));


?>