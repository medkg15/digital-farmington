<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 12/7/2014
 * Time: 6:14 PM
 */

class CategoryController extends BaseController {

    public function show()
    {
        $categories = Category::all();

        return View::make('admin.categories', array('categories' => $categories));
    }

    public function save()
    {
        $existing = Input::get('existing');
        $new = Input::get('new');

        for ($i = 0; $i < count($existing); $i++)
        {
            if($existing[$i] == $new[$i])
            {
                continue;
            }

            $category = Category::where('label', '=', $existing[$i])->first();

            $category->label = $new[$i];

            $category->save();
        }

        return Redirect::action('MapController@displayAdmin');
    }
} 