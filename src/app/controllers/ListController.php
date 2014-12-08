<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 12/7/2014
 * Time: 6:14 PM
 */

class ListController extends BaseController {

    public function showList()
    {
        $pois = PointOfInterest::with('eras')->with('categories')->with('photos')->get();


        $pois->each(function($poi){

            $poi->categories = $poi->categories->map(function($category){ return $category->label; });
            $poi->photos = $poi->photos->map(function($photo){ return $photo->filename; });
            $poi->eras = $poi->eras->map(function($era){ return $era->label; });

        });

        return View::make('admin.list', array('pois' => $pois));
    }
} 