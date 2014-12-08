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

        $colors = [
            'FF7F50',
            '6495ED',
            'FFF8DC',
            'DC143C',
            '00FFFF',
            '00008B',
            '008B8B',
            'B8860B',
            '006400',
            'BDB76B',
            '8B008B',
            '556B2F',
            'FF8C00',
            '9932CC',
            '8B0000',
            'E9967A',
            '8FBC8F',
            '483D8B',
            '2F4F4F',
            '00CED1',
            '9400D3',
            'FF1493',
            '00BFFF',
            '696969',
            '1E90FF',
            'B22222',
            'FFFAF0',
            '228B22',
            'FF00FF',
            'DCDCDC',
            'F8F8FF',
            'FFD700',
            'DAA520',
            '808080',
            '008000',
            'ADFF2F',
            'F0FFF0',
            'FF69B4',
            'CD5C5C',
            '4B0082',
            'FFFFF0',
            'F0E68C',
            'E6E6FA',
            'FFF0F5',
            '7CFC00',
            'FFFACD',
            'ADD8E6',
            'F08080',
            'E0FFFF',
            'FAFAD2',
            'D3D3D3',
            '90EE90',
            'FFB6C1',
            'FFA07A',
            '20B2AA',
            '87CEFA',
            '778899',
            'B0C4DE'
        ];



        $lookup = [];
        $categories->each(function($category) use ($colors, &$lookup){
            $category->color = $colors[$category->position];
            $lookup[$category->label] = $colors[$category->position];
        });

        return array('pois' => $pois, 'eras' => $eras, 'categories' => $categories, 'colors' => $lookup);
    }
}
