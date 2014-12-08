<?php

class PointOfInterestController extends BaseController
{
    public function showCreate()
    {
        return View::make('admin.pointOfInterest');
    }

    public function showEdit($id = null)
    {
        $eras = Era::all();
        $categories = Category::all();

        $poi = null;
        if($id) {

            $poi = PointOfInterest::where('id', '=', $id)->with('eras')->with('photos')->with('categories')->get()->first();
        }


        return View::make('admin.pointOfInterest')->with('poi', $poi)->with('eras', $eras)->with('categories', $categories);
    }
} 