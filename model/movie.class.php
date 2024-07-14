<?php 
class Movie {
    protected $id, $title, $genre, $director, $rating, $year, $actors;

    public function __construct($id, $title, $genre, $year, $director, $actors, $rating) {
        $this->id = $id;
        $this->title = $title;
        $this->genre = $genre;
        $this->year = $year;
        $this->director = $director;
        $this->actors = $actors;
        $this->rating = $rating;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}

?>
