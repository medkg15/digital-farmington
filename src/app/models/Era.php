<?php

class Era extends Eloquent
{
    protected $table = 'era';

    public function pointsOfInterest()
    {
        return $this->belongsToMany('PointOfInterest', 'point_of_interest_era');
    }
}