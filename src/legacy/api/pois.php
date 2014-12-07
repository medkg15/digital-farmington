<?php

require_once('../includes/config.php');

$pois = DB::query('select *
    from point_of_interest
    where display = (1)');

if(!empty($pois)) {
        $categories = DB::query('
    SELECT category.id, category.label, point_of_interest_category.point_of_interest_id
    FROM category
      INNER JOIN point_of_interest_category
        ON point_of_interest_category.category_id = category.id');

        $photos = DB::query('
    SELECT id, filename, point_of_interest_id
    FROM photo');

    $eras = DB::query('
        SELECT era.id, era.label, point_of_interest_era.point_of_interest_id
        FROM era
          INNER JOIN point_of_interest_era
            ON point_of_interest_era.era_id = era.id');
}

if(!empty($pois)) {
    $pois = array_map(function ($poi) use ($photos, $categories, $eras) {
        $poi['photos'] = array_values(array_filter($photos, function ($photo) use ($poi) {
            return $poi['id'] === $photo['point_of_interest_id'];
        }));

        $poi['categories'] = array_values(array_filter($categories, function ($category) use ($poi) {
            return $poi['id'] === $category['point_of_interest_id'];
        }));

        $poi['eras'] = array_values(array_filter($eras, function ($era) use ($poi){
            return $poi['id'] === $era['point_of_interest_id'];
        }));
        return $poi;
    }, $pois);
}

echo json_encode($pois);
header('Content-Type: application/json');