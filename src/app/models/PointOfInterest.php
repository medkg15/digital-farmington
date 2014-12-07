<?php

class PointOfInterest extends Eloquent
{
    protected $table = 'point_of_interest';

    public function categories()
    {
        return $this->belongsToMany('Category', 'point_of_interest_category');
    }

    public function eras()
    {
        return $this->belongsToMany('Era', 'point_of_interest_era');
    }

    public function photos()
    {
        return $this->hasMany('Photo');
    }
}