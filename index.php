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

    if( isset( $parts[0] ) && preg_match( '/^[A-Za-z0-9]+$/', $parts[0] ) )
        $controller = $parts[0];
    else
        $controller = 'user';

    
    if( isset( $parts[1] ) && preg_match( '/^[A-Za-z0-9]+$/', $parts[1] ) )
        $action = $parts[1];
    else
        $action = 'index';
}


$controllerName = $controller . 'Controller';

require_once __DIR__ . '/controller/' . $controllerName . '.php';

$con = new $controllerName();

$con->$action();

exit(0);

?>