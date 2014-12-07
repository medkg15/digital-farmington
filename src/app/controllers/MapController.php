<?php

class MapController extends BaseController
{

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |	Route::get('/', 'HomeController@showWelcome');
    |
    */

    public function displayPublic()
    {
        return View::make('map', $this->getViewModel());
    }

    public function displayAdmin()
    {
        return View::make('admin/map', $this->getViewModel());
    }

    private function getViewModel()
    {
        $pois = PointOfInterest::where('display', '=', true)
            ->with('eras')->with('categories')->with('photos')
            ->get();

        $erasWithActivePOIs = Era::orderBy('label')->get();

        $eras = array();
        foreach ($erasWithActivePOIs as $era) {
            $eras[] = $era->label;
        }

        $categories = Category::whereHas('pointsOfInterest', function ($q) {
                $q->where('display', '=', true);
            })
            ->get();

        return array('pois' => $pois, 'eras' => $eras, 'categories' => $categories);
    }
}
