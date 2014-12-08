<?php

class PointOfInterestController extends BaseController
{
    public function showEdit()
    {
        $id = Input::get('id');

        $eras = Era::all();
        $categories = Category::all();

        $poi = null;
        if($id) {

            $poi = PointOfInterest::where('id', '=', $id)->with('eras')->with('photos')->with('categories')->get()->first();
        }
        else
        {
        }


        return View::make('admin.pointOfInterest')->with('poi', $poi)->with('eras', $eras)->with('categories', $categories);
    }

    public function save()
    {
        $id = Input::get('id');

        if($id) {
            $poi = PointOfInterest::find($id);
        }
        else
        {
            $poi = new PointOfInterest();
        }

        $poi->name = Input::get('name');
        $poi->description = Input::get('description');
        $poi->display = Input::get('display', (int)0);
        $poi->latitude = Input::get('latitude');
        $poi->longitude = Input::get('longitude');

        $poi->save();

        return Redirect::action('MapController@displayAdmin');
    }
} 