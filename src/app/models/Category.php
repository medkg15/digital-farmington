<?php

class Category extends Eloquent
{
    protected $table = 'category';

    public function pointsOfInterest()
    {
        return $this->belongsToMany('PointOfInterest', 'point_of_interest_category');
    }
}