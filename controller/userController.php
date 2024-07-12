<?php

require_once __DIR__ . '/../model/functions.class.php';
require_once __DIR__ . '/adminController.php';

class userController{

    public function index()
    {
        require_once __DIR__ . '/../view/_header.php';
        require_once __DIR__ . '/../view/menu.php';
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
        $cs = new function;
        $user = $cs->getUser();
    }

    public function login()
    {
               
	            if( !isset( $_POST["username"] ) || preg_match( '/[a-zA-Z]{3, 20}/', $_POST["username"] ) )
                {
                    $x = new userController;
                    $x->signin();
                }

               
                if( !isset( $_POST["password"] ) )
                {
                    $x = new userController;
                    $x->signin();
                }

                $provjera = new functions;
                $row = $provjera->loginUser();

                if( $row === false )
                {
                
                    $x = new userController;
                    $x->signin();
                    return;
                }
                else
                {


                    $hash = $row['password_hash'];

                  
                    if( password_verify( $_POST['password'], $hash ) )
                    {
                      
                        $y = new functions;
                        $_SESSION['id_user'] = $y->getUserId();
                        $_SESSION['admin'] = $y->isUserAdmin();

                        $x = new userController;
                        $x->index();

                        return;
                    }
                    else
                    {
                        
                        $x = new userController;
                        $x->signin();
                        return;
                    }
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
