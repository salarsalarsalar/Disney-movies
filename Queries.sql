
-- CREATING TABLES


USE i191716;
CREATE TABLE show_description
(
	show_id	varchar(5) PRIMARY KEY,	
	type varchar(50),	
	title varchar(50),
	director varchar(100),
	cast varchar(255),	
	country	varchar(56),		
	date_added date,
	release_year int(4),
	rating	varchar(10),
	duration varchar(25),
	listed_in varchar(255),
	description varchar(255),
);
-- sql loader is supported in mysql, this is the way of loading file in myql
LOAD DATA LOCAL INFILE 'c:\wamp64\tmp\disney_plus_titles.csv' 
INTO TABLE show_description 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;


CREATE TABLE IF NOT EXISTS `i191716`.`disney_plus_titles_1` (`show_id` varchar(5), `type` varchar(7), `title` varchar(79), `director` varchar(51), `cast` varchar(112), `country` varchar(137), `date_added` varchar(18), `release_year` int(4), `rating` varchar(8), `duration` varchar(10), `listed_in` varchar(49), `description` varchar(102)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE actor ADD PRIMARY KEY(show_id);
ALTER TABLE film_description ADD PRIMARY KEY(show_id);
ALTER TABLE film_director ADD PRIMARY KEY(show_id);
ALTER TABLE film_time ADD PRIMARY KEY(show_id);

CREATE TABLE Film_Director AS
SELECT show_id, director, type, title, listed_in
FROM disney_plus_titles;

CREATE TABLE Film_description AS
SELECT show_id, type, title, cast, country, rating, listed_in, description
FROM disney_plus_titles;

CREATE TABLE Film_time AS
SELECT show_id, date_added, duration, release_year
FROM disney_plus_titles;

CREATE TABLE Actor AS
SELECT show_id, cast, title
FROM disney_plus_titles;

-- MAKING QUERIES

-- Regular expression is supported in mysql

SELECT cast, title
FROM actor
WHERE cast REGEXP 'Johnny Depp';

SELECT type,listed_in 
FROM film_description 
WHERE listed_in REGEXP 'comedy';

SELECT * 
FROM film_description 
WHERE rating REGEXP 'PG-13';

SELECT * 
FROM film_director
WHERE director REGEXP 'Jason Sterman';


-- SUB QUERIES


-- select all directors with movie/shows in the duration between of 20 and 99
SELECT director, title, type
FROM film_director
WHERE 
show_id IN 
( 
    SELECT show_id
	FROM film_time
    WHERE duration REGEXP '[2-9][2-9]'
);

-- select all pg-13 movies
SELECT director, title, type
FROM film_director
WHERE 
show_id IN 
( 
    SELECT show_id
	FROM film_description
    WHERE rating LIKE 'PG-13'
);

-- show the time actor with Mic in his name has
SELECT duration
FROM film_time
WHERE 
-- the in operator counts as a set operation
show_id IN 
( 
    SELECT show_id
	FROM actor
    WHERE cast REGEXP 'Mic'
);


-- AGGREGATE FUNCTIONS AND JOINS


-- average year of movie of a specific director

SELECT director,date_added,duration,AVG(release_year)
FROM film_time RIGHT OUTER JOIN film_director
USING (show_id)
WHERE type LIKE 'Movie';

-- show the most recent movie
-- mysql doesnt have full outer join keyword
SELECT date_added,duration,MAX(release_year) most_recent_movie,title,listed_in
FROM film_time LEFT JOIN film_director  
USING (show_id);

-- count rating of movies/shows released in 2019
SELECT f.title,cast,country,COUNT(rating)
FROM film_director f LEFT OUTER JOIN film_description d
USING (show_id)
WHERE 
director IS NOT NULL AND cast IS NOT NULL AND country IS NOT NULL
AND
show_id IN 
(
	SELECT show_id
    FROM film_time
    WHERE release_year = 2019
);

-- split columns by comma
SELECT 
substring_index ( substring_index ( director,',',1 ), ',', -1) name1,
substring_index ( substring_index ( director,',',2 ), ',', -1) name2,
substring_index ( substring_index ( director,',',3 ), ',', -1) name3,
substring_index ( substring_index ( director,',',4 ), ',', -1) name4
FROM film_director

-- get name of everyone
SELECT 
substring_index ( substring_index ( director,',',1 ), ',', -1) name1,
substring_index ( substring_index ( director,',',2 ), ',', -1) name2,
substring_index ( substring_index ( director,',',3 ), ',', -1) name3,
substring_index ( substring_index ( director,',',4 ), ',', -1) name4
FROM film_director
UNION
SELECT
substring_index ( substring_index ( cast,',',1 ), ',', -1) name5,
substring_index ( substring_index ( cast,',',2 ), ',', -1) name6,
substring_index ( substring_index ( cast,',',3 ), ',', -1) name7,
substring_index ( substring_index ( cast,',',4 ), ',', -1) name8
FROM actor

-- order every movie release_year
SELECT * FROM film_time
WHERE date_added IS NOT NULL
UNION ALL
SELECT type,title,cast,description FROM film_description
ORDER BY release_year;

-- select all movies in 2009
SELECT title, release_year, type
FROM film_time LEFT OUTER JOIN film_description
USING (show_id)
WHERE release_year = 2009 AND type LIKE 'Movie'

-- select all movies from these years
SELECT title, release_year, type
FROM film_time LEFT OUTER JOIN film_description
USING (show_id)
WHERE release_year IN (2010,2011,2020) AND type LIKE 'Movie';


-- get total count of movies
SELECT COUNT(type) movie_count
FROM film_description
WHERE type LIKE "Movie"

UNION

-- get total count of tv shows
SELECT COUNT(type) movie_count
FROM film_description
WHERE type LIKE "TV Show"

-- select all movies realeased after november 20
SELECT * 
FROM film_time 
WHERE date_added REGEXP "November [2-9][0-9]"

-- select all movies with more than 10 seasons
SELECT * 
FROM film_time 
WHERE duration REGEXP "[1-9][0-9] Season"

-- select all actors who have played in a movie with duck or queen in them
SELECT *
FROM actor
WHERE title REGEXP "Duck|Queen"

-- select all movies with Christmas in the title and and having a comedy category
SELECT *
FROM film_description
WHERE listed_in REGEXP "comedy" AND title REGEXP "Christmas"