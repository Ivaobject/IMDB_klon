<?php

require __DIR__ . '/../app/database/db.class.php';
require __DIR__ . '/user.class.php';
require __DIR__ . '/movie.class.php';
require __DIR__ . '/rating.class.php';
require __DIR__ . '/comment.class.php';
require __DIR__ . '/watchlist.class.php';

class functions{



    public function getUserId( $username )
    {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id FROM korisnici WHERE username=:username' );
            $st->execute( ['username' => $username] );
            $row = $st->fetch();
            
            return $row;
    }

    public function isUserAdmin()
    {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT admin FROM korisnici WHERE id=:id' );
            $st->execute( ['id' => $_SESSION['id_korisnik']] );
            $row = $st->fetch();
            
            return $row;
    }


    public function getUsername( $id ) 
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM korisnici WHERE id=:id' );
        $st->execute( ['id' => $id] );
        $row = $st->fetch();
    
        return $user->username;
    }
        
    public function eraseUser( $id )
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'DELETE FROM korisnici WHERE id LIKE :id' );
        $st->execute(['id' => $id]);
        return;

    }
    

}

?>