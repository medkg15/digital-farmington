<?php

require_once('../includes/config.php');

$json = file_get_contents('php://input');
$input = json_decode($json);

if(empty($input->categories))
{
    exit;
}

DB::startTransaction();

DB::query('
create temporary table filter_point_of_interest engine=memory
as
(
    select *
    from point_of_interest
    where exists
      (
        select *
        from point_of_interest_era
          inner join era
            on point_of_interest_era.era_id = era.id
        where era.label = %s
          and point_of_interest_id = point_of_interest.id
      )
      and exists
      (
        select *
        from point_of_interest_category
          inner join category
            on point_of_interest_category.category_id = category.id
        where category.label in %ls
          and point_of_interest_id = point_of_interest.id
      )
      and display = (1)
);', $input->year, $input->categories);

$pois = DB::query('select * from filter_point_of_interest');

if(!empty($pois)) {

    $poi_ids = array_map(function ($poi) {
            return $poi['id'];
        }, $pois);

        $categories = DB::query('
    SELECT category.id, category.label, point_of_interest_category.point_of_interest_id
    FROM category
      INNER JOIN point_of_interest_category
        ON point_of_interest_category.category_id = category.id
    WHERE point_of_interest_category.point_of_interest_id IN %ls;', $poi_ids);

        $photos = DB::query('
    SELECT id, filename, point_of_interest_id
    FROM photo
    WHERE point_of_interest_id IN %ls;', $poi_ids);
}

DB::query('drop table filter_point_of_interest;');

DB::commit();

if(!empty($pois)) {
    $pois = array_map(function ($poi) use ($photos, $categories) {
        $poi['photos'] = array_values(array_filter($photos, function ($photo) use ($poi) {
            return $poi['id'] === $photo['point_of_interest_id'];
        }));

        $poi['categories'] = array_values(array_filter($categories, function ($category) use ($poi) {
            return $poi['id'] === $category['point_of_interest_id'];
        }));
        return $poi;
    }, $pois);
}

echo json_encode($pois);
header('Content-Type: application/json');