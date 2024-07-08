<?php
    class Watchlist
    {
        protected $id, $id_korisnik, $id_film, $gledano;

        public function __construct( $id, $id_korisnik, $id_film, $gledano )
        {
            $this->id = $id;
            $this->id_korisnik = $id_korisnik;
            $this->id_film = $id_film;
            $this->gledano = $gledano;
        }

        public function __get( $property )
        {
            if( property_exists( $this, $property ) )
                return $this->$property; 
        }

        public function __set( $property, $value )
        {
            if( property_exists( $this, $property ) )
                $this->$property = $value;
            
                return $this;
        }

        
    }

?>