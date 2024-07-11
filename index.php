<?php



session_start();

if( !isset( $_GET['rt'] ) && !isset( $_GET['niz'] ) )
{
    $controller = 'user';
    $action = 'index';
}
elseif( isset( $_GET['niz'] ) ){
    $controller = 'user';
    $action = 'verifyUser';

    $_SESSION['niz'] = $_GET['niz'];
}
else{
    $parts = explode( '/', $_GET['rt'] );

    $controllerName = $parts[0] . 'Controller';
    if( isset( $parts[1] ) )
        $action = $parts[1];
    else
        $action = 'index';
    
}

// Controller $controllerName se nalazi poddirektoriju controller
$controllerFileName = 'controller/' . $controllerName . '.php';

// Includeaj tu datoteku
require_once $controllerFileName;

// Stvori pripadni kontroler
$con = new $controllerName; 

// Pozovi odgovarajuću akciju
$con->$action();

?>