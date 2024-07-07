<?php  
    class Comment
    {
        protected $id, $id_korisnik, $id_film, $tekst, $datum;

        public function __construct( $id, $id_korisnik, $id_film, $tekst, $datum )
        {
            $this->id = $id;
            $this->id_korisnik = $id_korisnik;
            $this->id_film = $id_film;
            $this->tekst = $tekst;
            $this->datum = $datum;
        }

        public function __get( $property )
        {
            if( property_exists( $this, $property ) )
                return $this->$property;
        }

        public function __set( $property, $value )
        {
            if ( property_exists( $this, $property) )
                $this->property = $value;

            return $this;
        }
    }