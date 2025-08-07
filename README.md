### Detailed Description:

[https://www.kaggle.com/shivamb/disney-movies-and-tv-shows](https://www.kaggle.com/shivamb/disney-movies-and-tv-shows "null")

1. Read and Understand the details of the dataset on given URL.
    
2. Plan the entities, their keys and attributes
    
3. Create a database in Oracle, create tables for all the identified entities having keys and attributes.
    
4. Download the dataset and load into the created tables. You can use SQL*Loader utility for this purpose. It is a very simple and easy to use utility which can load the data from csv file(s) into Oracle database.
    
5. Then apply 22 different SQL queries to get various insights of the dataset.
    

### Deliverables:

A report containing following items:

1. Keys and attributes of each table should be clearly shown along with their datatypes.
    
2. SQL queries to create database, tables, keys, and attributes.
    
3. Code of SQL*Loader to load the data into the created tables. Add snapshots of codes (both creation and loading) on pdf file.
    
4. Submit .txt files that has all code for creating and loading of tables
    
5. SQL queries and their result along with the 2-3 liner description which tell the purpose of each query and tells what information we get from each query and obtained results (attach snapshots of output). You can create queries of your own but they should be your own queries and should not be copied from other groups. The count of 18 queries is divided as below:
    
    i. 3 Queries which use various aggregation functions
    
    ii. 3 Queries which use various aggregation functions and involve more than 2 tables (database join)
    
    iii. 3 Nested queries
    
    iv. 3 queries involving outer joins and aggregation functions
    
    v. 3 queries involving set operators.
    
    vi. 3 queries to compare the difference in execution time of different types of joins like outer join vs equi join etc. The execution time must be obtained from the system and should be displayed along with the output.
    

#### Other queries

1- Display all the movies/tv shows directed by Jason Sterman

2- Display all the movies/tv shows with genre “Comedy”

3- Display all the movies/tv shows with rating “PG-13”

4- Display all the movies/tv shows in which actor “Johnny Depp” has worked

7. Also make an interface using php which will take the queries from user and display the answers of the query. There will be a single webpage. Attach all the snap shots of webpage and results on pdf document
    

## Report

### Introduction

This report dives into the aspects of structured query language or SQL for short. Our workspace through we will be investigating this will be WAMP sever. We will be looking into the various uses of SQL in databases by crafting queries for a given database that is loaded into our workspace. We will also be making a web server using php

### SQL Queries

The following are the SQL queries that we used to investigate our database

#### CREATING TABLES

```
USE i191716;
CREATE TABLE show_description
(
	show_id	 varchar(5) PRIMARY KEY,
	 type varchar(50),
	 title varchar(50),
	 director varchar(100),
	 cast varchar(255),
	 country	 varchar(56),
	date_added date,
	release_year int(4),
	 rating	 varchar(10),
	 duration varchar(25),
	listed_in varchar(255),
	 description varchar(255),
);
```

# sql loader is supported in mysql, this is the way of loading file in myql

````
LOAD DATA LOCAL INFILE 'c:\wamp64\tmp\disney_plus_titles.csv'
INTO TABLE show_description
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```sql
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
````

#### MAKING QUERIES

# Regular expression is supported in mysql

```
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
```

#### SUB QUERIES

# select all directors with movie/shows in the duration between of 20 and 99

```
SELECT director, title, type
FROM film_director
WHERE
show_id IN
(
    SELECT show_id
	 FROM film_time
    WHERE duration REGEXP '[2-9][2-9]'
);
```

# select all pg-13 movies

```
SELECT director, title, type
FROM film_director
WHERE
show_id IN
(
    SELECT show_id
	 FROM film_description
    WHERE rating LIKE 'PG-13'
);
```

# show the time actor with Mic in his name has

```
SELECT duration
FROM film_time
WHERE
# the in operator counts as a set operation
show_id IN
(
    SELECT show_id
	 FROM actor
    WHERE cast REGEXP 'Mic'
);
```

#### AGGREGATE FUNCTIONS AND JOINS

# average year of movie of a specific director

```
SELECT director,date_added,duration,AVG(release_year)
FROM film_time RIGHT OUTER JOIN film_director
USING (show_id)
WHERE type LIKE 'Movie';
```

# show the most recent movie

# mysql doesnt have full outer join keyword

```
SELECT date_added,duration,MAX(release_year) most_recent_movie,title,listed_in
FROM film_time LEFT JOIN film_director
USING (show_id);
```

# count rating of movies/shows released in 2019

```
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
```

# split columns by comma

```
SELECT
substring_index ( substring_index ( director,',',1 ), ',', -1) name1,
substring_index ( substring_index ( director,',',2 ), ',', -1) name2,
substring_index ( substring_index ( director,',',3 ), ',', -1) name3,
substring_index ( substring_index ( director,',',4 ), ',', -1) name4
FROM film_director
```

# get name of everyone

```
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
```

# order every movie release_year

```
SELECT * FROM film_time
WHERE date_added IS NOT NULL
UNION ALL
SELECT type,title,cast,description FROM film_description
ORDER BY release_year;
```

# select all movies in 2009

```
SELECT title, release_year, type
FROM film_time LEFT OUTER JOIN film_description
USING (show_id)
WHERE release_year = 2009 AND type LIKE 'Movie'
```

# select all movies from these years

```
SELECT title, release_year, type
FROM film_time LEFT OUTER JOIN film_description
USING (show_id)
WHERE release_year IN (2010,2011,2020) AND type LIKE 'Movie';
```

# get total count of movies

```
SELECT COUNT(type) movie_count
FROM film_description
WHERE type LIKE "Movie"
UNION
# get total count of tv shows
SELECT COUNT(type) movie_count
FROM film_description
WHERE type LIKE "TV Show"
```

# select all movies realeased after november 20

```
SELECT *
FROM film_time
WHERE date_added REGEXP "November [2-9][0-9]"
```

# select all movies with more than 10 seasons

```
SELECT *
FROM film_time
WHERE duration REGEXP "[1-9][0-9] Season"
```

# select all actors who have played in a movie with duck or queen in them

```
SELECT *
FROM actor
WHERE title REGEXP "Duck|Queen"
```

# select all movies with Christmas in the title and and having a comedy category

```
SELECT *
FROM film_description
WHERE listed_in REGEXP "comedy" AND title REGEXP "Christmas"
```

### Conclusion

What we learned from working this assignment was that SQL is a language that is very lenient on syntax. The power of language is prominent in areas where we have to gather some insight on some data. SQL also can be used on web via connection to a web-based language, we used php for this purpose.