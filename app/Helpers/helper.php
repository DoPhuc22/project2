<?php

use App\Models\Genre;
use App\Models\Movie;

function getGenres()
    {
        return Genre::orderby('name', 'ASC')->where('status', 1)->get();
    }

?>
