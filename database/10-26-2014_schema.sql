create table point_of_interest
(
  id int primary key auto_increment,
  latitude decimal(10,8) not null,
  longitude decimal(11,8) not null,
  name varchar(500) not null,
  description text null,
  display bit not null
);

create table photo
(
  id int primary key auto_increment,
  filename varchar(500) not null,
  point_of_interest_id int,
  foreign key (point_of_interest_id) references point_of_interest (id)
);

create table category
(
  id int primary key auto_increment,
  label varchar(250) not null,
  position int not null
);

create table era(
  id int primary key auto_increment,
  label varchar(250) not null,
  position int not null
);

create table point_of_interest_category
(
  point_of_interest_id int,
  category_id int,
  primary key (point_of_interest_id, category_id),
  foreign key (point_of_interest_id) references point_of_interest (id),
  foreign key (category_id) references category (id)
);

create table point_of_interest_era
(
  point_of_interest_id int,
  era_id int,
  primary key (point_of_interest_id, era_id),
  foreign key (point_of_interest_id) references point_of_interest (id),
  foreign key (era_id) references era (id)
);