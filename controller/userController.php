<?php

require_once __DIR__ . '/../model/functions.class.php';

class userController{
    public function signin()
    {
        require_once __DIR__ . '/../view/signin.php';
    }

    public function login()
    {
                // Provjeri sastoji li se ime samo od slova; ako ne, crtaj login formu.
	            if( !isset( $_POST["username"] ) || preg_match( '/[a-zA-Z]{3, 20}/', $_POST["username"] ) )
                {
                    $x = new userController;
                    $x->signin();
                }

                // Možda se ne šalje password; u njemu smije biti bilo što.
                if( !isset( $_POST["password"] ) )
                {
                    $x = new userController;
                    $x->signin();
                }

                $provjera = new TekaService;
                $row = $provjera->loginUser();

                if( $row === false )
                {
                    // Taj user ne postoji, ili nije registriran upit u bazu nije vratio ništa.
                    $x = new userController;
                    $x->signin();
                    return;
                }
                else
                {


                    // Postoji user. Dohvati hash njegovog passworda.
                    $hash = $row['password_hash'];

                    // Da li je password dobar?
                    if( password_verify( $_POST['password'], $hash ) )
                    {
                        // Dobar je. Ulogiraj ga.
                        $y = new TekaService;
                        $_SESSION['id_user'] = $y->getUserId();
                        $_SESSION['admin'] = $y->isUserAdmin();

                        $x = new userController;
                        $x->index();

                        return;
                    }
                    else
                    {
                        // Nije dobar. Crtaj opet login formu s pripadnom porukom.
                        $x = new userController;
                        $x->signin();
                        return;
                    }
                }
    }

    public function register(){
        /*
        if( isset( $_SESSION['username'] ) ){
            require_once __DIR__ . '/../view/menu_form.php';
            require_once __DIR__ . '/channelsController.php';
            $con = new ChannelsController;
            $con->userChannels();
            exit();
        }
*/
        if( isset( $_POST['newusername'] ) ){
            if( !isset( $_POST['newusername'] ) || !isset( $_POST['newpassword'] ) || !isset( $_POST['newemail'] ) ){
                //$title = 'Register';
                //echo 'Enter username, password and e-mail.';
                //require_once __DIR__ . '/../view/register_form.php';
                $x = new userController;
                $x->signin();
                exit();
            }

            if( !preg_match( '/^[a-zA-Z]{3,10}$/', $_POST['newusername'] ) ){
                //$title = 'Register';
                //echo 'Username has to have between 3 and 10 letters.';
                //require_once __DIR__ . '/../view/login_form.php';
                $x = new userController;
                $x->signin();
                exit();
            }
            else if( !filter_var( $_POST['newemail'], FILTER_VALIDATE_EMAIL) ){
                //$title = 'Register';
                //echo 'Wrong e-mail address.';
                //require_once __DIR__ . '/../view/login_form.php';
                $x = new userController;
                $x->signin();
                exit();
            }
            else{
                $cs = new TekaService;
                $cs->newUser();
            }  
        }
        else{
            //$title = 'Register';
            //require_once __DIR__ . '/../view/register_form.php';
            $x = new userController;
            $x->signin();
            exit();
        }
    }

}
?>
