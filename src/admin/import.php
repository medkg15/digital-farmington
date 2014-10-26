<!DOCTYPE html>
<html>
<head>
    <link href="/css/main.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">
    <form action="" method="post" enctype="multipart/form-data">
        <h1>WARNING: This will delete all data from the database and replace it with the file contents.</h1>
        <input type="file" name="data"/>  Upload a CSV file in the described format.
        <input type="submit" value="Submit"/>
    </form>
</div>
</body>

<?php

require_once(dirname(__FILE__) . '/../includes/config.php');
require_once(dirname(__FILE__) . '/../includes/csv_parser.php');

if(array_key_exists('data', $_FILES))
{
    $data = $_FILES['data'];

    $csv = csv_to_array($data['tmp_name']);

    DB::delete('point_of_interest_category','1=1');
    DB::delete('point_of_interest_era','1=1');
    DB::delete('era','1=1');
    DB::delete('category','1=1');
    DB::delete('photo','1=1');
    DB::delete('point_of_interest','1=1');

    foreach ($csv as $point_of_interest) {
        /*
         * [Latitude] => 41.7383071
            [Longitude] => -72.8400425
            [Name] => Deer Pond
            [Description] =>
            [Photos] => deer_pond.jpg
            [Categories] => Natural Features
            [Years] => 1900;1930;1970;2010
            [Display] => Show
         */
        $years = explode(';', $point_of_interest['Years']);
        $categories = explode(';', $point_of_interest['Categories']);
        $photos = explode(';', $point_of_interest['Photos']);

        $filter_null_whitespace = function ($input) {
            return $input && !ctype_space($input);
        };

        $years = array_filter($years, $filter_null_whitespace);
        $categories = array_filter($categories, $filter_null_whitespace);
        $photos = array_filter($photos, $filter_null_whitespace);

        // create the POI record

        DB::startTransaction();

        DB::insert('point_of_interest', array(
            'latitude' => $point_of_interest['Latitude'],
            'longitude' => $point_of_interest['Longitude'],
            'name' => $point_of_interest['Name'],
            'description' => $point_of_interest['Description'],
            'display' => $point_of_interest['Display'] === 'Show'
        ));

        $poiID = DB::insertId();

        // add photos

        if ($photos) {
            DB::insert('photo', array_map(function ($photo) use ($poiID) {
                return array(
                    'filename' => $photo,
                    'point_of_interest_id' => $poiID
                );
            }, $photos));
        }

        // add categories
        $existing_categories = DB::query('select id, label from category');

        $category_lookup = array();
        foreach($existing_categories as $existing_category)
        {
            $category_lookup[$existing_category['label']] = $existing_category['id'];
        }

        $inserts = array();
        foreach ($categories as $category) {

            if(!array_key_exists($category, $category_lookup))
            {
                DB::queryFirstField(' insert into category (label, position)  select %s, count(*) from category;', $category);
                $category_lookup[$category] = DB::insertId();
            }

            $inserts[] = array(
                'point_of_interest_id' => $poiID,
                'category_id' => $category_lookup[$category]
            );
        }

        DB::insert('point_of_interest_category', $inserts);

        // add eras
        $existing_eras = DB::query('select id, label from era');

        $era_lookup = array();
        foreach($existing_eras as $existing_era)
        {
            $era_lookup[$existing_era['label']] = $existing_era['id'];
        }

        $inserts = array();
        foreach ($years as $year) {

            if(!array_key_exists($year, $era_lookup))
            {
                DB::queryFirstField(' insert into era (label) values (%s);', $year);
                $era_lookup[$year] = DB::insertId();
            }

            $inserts[] = array(
                'point_of_interest_id' => $poiID,
                'era_id' => $era_lookup[$year]
            );
        }

        DB::insert('point_of_interest_era', $inserts);

        DB::commit();
    }
}
