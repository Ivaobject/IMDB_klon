<?php

class movie{
    protected $id, $title, $genre, $director, $rating, $year;

    function __construct($id, $title, $genre, $director, $rating, $year){
        $this->id = $id;
        $this->title = $title;
        $this->genre = $genre;
        $this->director = $director;
        $this->rating = $rating;
        $this->year = $year;
    }

    function __get( $property ){
        return $this->$property;
    }

    function __set( $property, $value ){
        $this->$property=$value;
    }

}

?>