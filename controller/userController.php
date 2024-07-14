<?php

require_once __DIR__ . '/../model/functions.class.php';
require_once __DIR__ . '/adminController.php';

class userController{

    public function index()
    {
        require_once __DIR__ . '/../view/_header.php';
        require_once __DIR__ . '/../view/meni.php';
        echo '<h1>Dobrodošli na IMDB klon</h1>';
        require_once __DIR__ . '/../view/_footer.php';
    }

    public function signin()
    {
        if( isset( $_SESSION['admin'] ) )
        {
            $x = new adminController;
            $x->index();
        }

        else
            require_once __DIR__ . '/../view/signin.php';
    }

    public function verifyUser(){
        $cs = new functions;
        $user = $cs->getUser();
    }

    public function login()
{
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        $this->signin(); // Ako nedostaju korisničko ime ili lozinka, prikaži ponovno prijavljivanje
        return;
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    $cs = new functions();
    $row = $cs->loginUser($username, $password);

    if ($row === false) {
        $this->signin(); // Neuspješna prijava, prikaži ponovno prijavljivanje
        return;
    }

    $hash = $row['password_hash'];

    if (password_verify($password, $hash)) {
        // Prijava je uspješna, postavi sesijske varijable
        $_SESSION['id_user'] = $cs->getUserId($username);
        $_SESSION['admin'] = $cs->isUserAdmin();

        $this->index(); // Preusmjeri na glavnu stranicu
    } else {
        $this->signin(); // Neuspješna provjera lozinke, prikaži ponovno prijavljivanje
    }
}

    public function register(){
 
        if( isset( $_POST['newusername'] ) ){
            if( !isset( $_POST['newusername'] ) || !isset( $_POST['newpassword'] ) || !isset( $_POST['newemail'] ) ){
                $x = new userController;
                $x->signin();
                exit();
            }

            if( !preg_match( '/^[a-zA-Z]{3,10}$/', $_POST['newusername'] ) ){
                $x = new userController;
                $x->signin();
                exit();
            }
            else if( !filter_var( $_POST['newemail'], FILTER_VALIDATE_EMAIL) ){
                $x = new userController;
                $x->signin();
                exit();
            }
            else{
                $cs = new functions;
                $cs->newUser();
            }  
        }
        else{
            $x = new userController;
            $x->signin();
            exit();
        }
    }

}
?>
