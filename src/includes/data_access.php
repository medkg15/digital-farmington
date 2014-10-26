<?php

require_once(dirname(__FILE__) . '/config.php');

class DataAccess {

    public function get_eras()
    {
        return DB::query(
            'select id, label
from era
where exists (
  select *
  from point_of_interest_era
    inner join point_of_interest
      on point_of_interest_era.point_of_interest_id = point_of_interest_id
  where era.id = point_of_interest_era.era_id
    and display = (1)
)
order by label;');
    }

    public function get_categories()
    {
        return DB::query(
'select id, label
from category
where exists (
  select *
  from point_of_interest_category
    inner join point_of_interest
      on point_of_interest_category.point_of_interest_id = point_of_interest.id
  where category.id = point_of_interest_category.category_id
    and display = (1)
)
order by position;');
    }

} 