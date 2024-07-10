<?php

require_once __DIR__ . '/../model/tekaservice.class.php';
require_once __DIR__ . '/../model/movie.class.php';

require_once __DIR__ . '/../controller/userController.php';

class adminController{

    public function index()
    {
        if( !isset ( $_SESSION['admin'] ) )
        {
            require_once __DIR__ . '/../view/signin.php';
        }


        //otvori watchlistu 
        elseif( (int)$_SESSION['admin'] )
        {
            $x = new TekaService;
            $username = $x->getUsername();
            $title = 'My profile';
            $watchList = [];
            $watchList = $x->getWatchlist();
            $movieList;
            for( $i = 0; $i < sizeof($watchList); ++$i )
            {
               $movieList[$i] = $x->getMovie( $watchList[$i]->id_movie );
            }
            require_once __DIR__ . '/../view/admin.php';
        }


        //otvori watchlistu plus adminske opcije
        else 
            require_once __DIR__ . '/../view/myprofile.php';
    }

    public function eraseuser(){

        if ( isset( $_POST['eraseuser'] ) )
        {
            $x = new TekaService;
            $username = $_POST['search_users'];
            $id = $x->getUserId( $username );
            $x->eraseUser( $id );

            require_once __DIR__ . '/../view/eraseuser.php';

        }

    }

    public function erasecomment(){

        if ( isset( $_POST['erasecomment'] ) )
        {
            $x = new TekaService;
            $content = $_POST['search_comments'];
            $id = $x->getCommentId( $content );
            $x->eraseComment( $id );

            require_once __DIR__ . '/../view/erasecomment.php';

        }

    }


    public function newmovie()
    {
        $x = new TekaService;
        $x->newMovie();
        require_once __DIR__ . '/../view/newmovie.php';



    }

    //fja za dodavanje admina
    public function addadmin()
    {

    }




    public function logout(){

        session_unset();
        session_destroy();

        require_once __DIR__ . '/../view/_header.php';
        require_once __DIR__ . '/../view/menu.php';
        require_once __DIR__ . '/../view/_footer.php';

    }


}
?>