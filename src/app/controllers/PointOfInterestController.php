<?php

class PointOfInterestController extends BaseController
{
    public function showEdit()
    {
        $id = Input::get('id');

        $eras = Era::orderBy('label', 'ASC')->get();
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
        $poi->eras()->sync(Input::get('era') ? Input::get('era') : []);
        $poi->categories()->sync(Input::get('category') ? Input::get('category') : []);

        $newCategories = Input::get('category_new');

        if ($newCategories)
        {
            $count = DB::table('category')->count();

            foreach($newCategories as $category)
            {
                $obj = new Category();
                $obj->label = $category;
                $obj->position = $count++;
                $poi->categories()->save($obj);
            }
        }

        $poi->save();

        return Redirect::action('MapController@displayAdmin');
    }
} 