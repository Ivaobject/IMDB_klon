<?php
    class Rating
    {
        protected $id_korisnik, $id_film , $rating;

        public function __construct( $id_korisnik, $id_film, $rating )
        {
            $this->id_korisnik = $id_korisnik;
            $this->id_film = $id_film;
            $this->rating = $rating;
        }

        public function __get( $property )
        {
            if( property_exists( $this, $property ) )
                return $this->$property;
        }

        public functin __set( $property, $value )
        {
            if ( property_exists( $this, $property) )
                $this->property = $value;
            return $this;
        }
    }
?>