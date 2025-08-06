<?php 

// include "conf.php";
$sever ="localhost";
$username ="root";
$password ="";
$db="i191716";

$con = mysqli_connect($sever,$username,$password,$db);
if($con)
{
    echo "connection succesful";

    $query1="SELECT cast, title
    FROM actor
    WHERE cast REGEXP 'Johnny Depp';";
    $result1 = mysqli_query($con, $query1);

    $row1 = mysqli_fetch_assoc($result1);
    echo"<table border =1><tr><th>cast</th><th>title</th></tr>";
    while($row1 = mysqli_fetch_assoc($result1))
    {
        echo "<tr><td>".$row["cast"]. "</td><td>".$row["title"]."</td></tr>";    
    }
    echo "</table>";

    $query2="SELECT type,listed_in 
    FROM film_description 
    WHERE listed_in REGEXP 'comedy';";
    $result2 = mysqli_query($con, $query2);
    $row2 = mysqli_fetch_assoc($result2);
    echo"<table border =1><tr><th>type</th><th>listed_in</th></tr>";
    while($row2 = mysqli_fetch_assoc($result2);)
    {
        echo "<tr><td>".$row["type"]. "</td><td>".$row["listed_in"]."</td></tr>";    
    }
    echo "</table>";

    $query3="SELECT * 
    FROM film_description 
    WHERE rating REGEXP 'PG-13';";
    $result3 = mysqli_query($con, $query3);
    $row3 = mysqli_fetch_assoc($result3);
    echo"<table border =1><tr>
    <th>show_id</th>
    <th>type</th>
    <th>title</th>
    <th>cast</th>
    <th>country</th>
    <th>rating</th>
    <th>listed_in</th>
    <th>description</th></tr>";
    while($row3 = mysqli_fetch_assoc($result3);)
    {
        echo "<tr><td>".$row["show_id"].
        "</td><td>".$row["type"]. 
        "</td><td>".$row["title"].
        "</td><td>".$row["cast"].
        "</td><td>".$row["country"]".
        "</td><td>".$row["rating"]".
        "</td><td>".$row["listed_in"]".
        "</td><td>".$row["description"]".
        "</td><td></tr>";    
    }
    echo "</table>";

    $query4="SELECT * 
    FROM film_director
    WHERE director REGEXP 'Jason Sterman';";
    $result4 = mysqli_query($con, $query4);
    $row4 = mysqli_fetch_assoc($result4);
    echo"<table border =1>
    <tr>
    <th>show_id</th>
    <th>director</th>
    <th>type</th>
    <th>title</th>
    <th>listed_in</th>
    </tr>";
    while($row4 = mysqli_fetch_assoc($result4);)
    {
        echo "<tr>
        ."<td>".$row["show_id"].
        "</td><td>".$row["director"]. 
        "</td><td>".$row["type"].
        "</td><td>".$row["title"].
        "</td><td>".$row["listed_in"]"."</td><td>".
        "</tr>";    
    }
    echo "</table>";

    $query5="SELECT director, title, type
    FROM film_director
    WHERE 
    show_id IN 
    ( 
        SELECT show_id
        FROM film_time
        WHERE duration REGEXP '[2-9][2-9]'
    );"
    $result5 = mysqli_query($con, $query5);
    $row5 = mysqli_fetch_assoc($result5);
    echo"<table border =1><tr>
    <th>director</th>
    <th>title</th>
    <th>type</th>
    </tr>";
    while($row5 = mysqli_fetch_assoc($result5);)
    {
        echo "<tr>".
        "<td>".$row["director"].
        "</td><td>".$row["title"]. 
        "</td><td>".$row["type"].
        "</td></tr>";    
    }
    echo "</table>";
    $query6="SELECT director, title, type
    FROM film_director
    WHERE 
    show_id IN 
    ( 
        SELECT show_id
        FROM film_description
        WHERE rating LIKE 'PG-13'
    );";
    $result6 = mysqli_query($con, $query6);    
    $row6 = mysqli_fetch_assoc($result6);
    echo"<table border =1><tr>
    <th>director</th>
    <th>title</th>
    <th>type</th>
    </tr>";
    while($row6 = mysqli_fetch_assoc($result6);)
    {
        echo "<tr>".
        "<td>".$row["director"].
        "</td><td>".$row["title"]. 
        "</td><td>".$row["type"].
        "</td></tr>";    
    }
    echo "</table>";

    $query7="SELECT duration
    FROM film_time
    WHERE 
    show_id IN 
    ( 
        SELECT show_id
        FROM actor
        WHERE cast REGEXP 'Mic'
    );";
    $result7 = mysqli_query($con, $query7);    
    $row7 = mysqli_fetch_assoc($result7);
    echo"<table border =1><tr>
    <th>duration</th>
    </tr>";
    while($row7 = mysqli_fetch_assoc($result7);)
    {
        echo "<tr>".
        "<td>".$row["duration"]."</td></tr>";    
    }
    echo "</table>";

    $query8="SELECT director,date_added,duration,AVG(release_year)
    FROM film_time RIGHT OUTER JOIN film_director
    USING (show_id)
    WHERE type LIKE 'Movie';";
    $result8 = mysqli_query($con, $query8);    
    $row8 = mysqli_fetch_assoc($result8);
    echo"<table border =1><tr>
    <th>director</th>
    <th>date_added</th>
    <th>duration</th>
    <th>AVG(release_year)</th>
    </tr>";
    while($row8 = mysqli_fetch_assoc($result8);)
    {
        echo "<tr>".
        "<td>".$row["director"].
        "</td><td>".$row["date_added"]. 
        "</td><td>".$row["duration"].
        "</td><td>".$row["AVG(release_year)"].
        "</td></tr>";    
    }
    echo "</table>";

    $query9="SELECT date_added,duration,MAX(release_year) most_recent_movie,title,listed_in
    FROM film_time LEFT JOIN film_director  
    USING (show_id);";
    $result9 = mysqli_query($con, $query9);    
    $row9 = mysqli_fetch_assoc($result9);
    echo"<table border =1><tr>
    <th>date_added</th>
    <th>duration</th>
    <th>most_recent_movie</th>
    <th>title</th>
    <th>listed_in</th>
    </tr>";
    while($row9 = mysqli_fetch_assoc($result9);)
    {
        echo "<tr>".
        "<td>".$row["date_added"].
        "</td><td>".$row["duration"]. 
        "</td><td>".$row["most_recent_movie"].
        "</td><td>".$row["title"].
        "</td><td>".$row["listed_in"].
        "</td></tr>";    
    }
    echo "</table>";

    $query10="SELECT f.title,cast,country,COUNT(rating)
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
    );";
    $result10 = mysqli_query($con, $query10);    
    $row10= mysqli_fetch_assoc($result10);
    echo"<table border =1><tr>
    <th>title</th>
    <th>cast</th>
    <th>country</th>
    <th>COUNT(rating)</th>
    </tr>";
    while($row10 = mysqli_fetch_assoc($result10);)
    {
        echo "<tr>".
        "<td>".$row["title"].
        "</td><td>".$row["cast"]. 
        "</td><td>".$row["country"].
        "</td><td>".$row["COUNT(rating)"].
        "</td></tr>";    
    }
    echo "</table>";


    $query11="SELECT 
    substring_index ( substring_index ( director,',',1 ), ',', -1) name1,
    substring_index ( substring_index ( director,',',2 ), ',', -1) name2,
    substring_index ( substring_index ( director,',',3 ), ',', -1) name3,
    substring_index ( substring_index ( director,',',4 ), ',', -1) name4
    FROM film_director";
    $result11 = mysqli_query($con, $query11);    
    $row11= mysqli_fetch_assoc($result11);
    echo"<table border =1><tr>
    <th>name1</th>
    <th>name2</th>
    <th>name3</th>
    <th>name4</th>
    </tr>";
    while($row11 = mysqli_fetch_assoc($result11);)
    {
        echo "<tr>".
        "<td>".$row["name1"].
        "</td><td>".$row["name2"]. 
        "</td><td>".$row["name3"].
        "</td><td>".$row["name4"].
        "</td></tr>";    
    }
    echo "</table>";
    $query12="SELECT 
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
    FROM actor";
    $result12 = mysqli_query($con, $query12);    
    $row12= mysqli_fetch_assoc($result12);
    echo"<table border =1><tr>
    <th>name1</th>
    <th>name2</th>
    <th>name3</th>
    <th>name4</th>
    <th>name5</th>
    <th>name6</th>
    <th>name7</th>
    <th>name8</th>
    </tr>";
    while($row12 = mysqli_fetch_assoc($result12);)
    {
        echo "<tr>".
        "<td>".$row["name1"].
        "</td><td>".$row["name2"]. 
        "</td><td>".$row["name3"].
        "</td><td>".$row["name4"].
        "</td><td>".$row["name5"].
        "</td><td>".$row["name6"].
        "</td><td>".$row["name7"].
        "</td><td>".$row["name8"].
        "</td></tr>";    
    }
    echo "</table>";

    $query13="SELECT * FROM film_time
    WHERE date_added IS NOT NULL
    UNION ALL
    SELECT type,title,cast,description FROM film_description
    ORDER BY release_year;";
    $result13 = mysqli_query($con, $query13);    
    $row13= mysqli_fetch_assoc($result13);

    echo"<table border =1><tr>
    <th>show_id</th>
    <th>date_added</th>
    <th>duration</th>
    <th>release_year</th>
    </tr>";
    while($row13 = mysqli_fetch_assoc($result13);)
    {
        echo "<tr>".
        "<td>".$row["show_id"].
        "</td><td>".$row["date_added"]. 
        "</td><td>".$row["duration"].
        "</td><td>".$row["release_year"].
        "</td></tr>";    
    }
    echo "</table>";

    $query14="SELECT title, release_year, type
    FROM film_time LEFT OUTER JOIN film_description
    USING (show_id)
    WHERE release_year = 2009 AND type LIKE 'Movie'";
    $result14 = mysqli_query($con, $query14);    
    $row14= mysqli_fetch_assoc($result14);
    echo"<table border =1><tr>
    <th>title</th>
    <th>release_year</th>
    <th>type</th>
    </tr>";
    while($row14 = mysqli_fetch_assoc($result14);)
    {
        echo "<tr>".
        "<td>".$row["title"].
        "</td><td>".$row["release_year"]. 
        "</td><td>".$row["type"].
        "</td></tr>";    
    }
    echo "</table>";

    $query15="SELECT title, release_year, type
    FROM film_time LEFT OUTER JOIN film_description
    USING (show_id)
    WHERE release_year IN (2010,2011,2020) AND type LIKE 'Movie';";
    $result15 = mysqli_query($con, $query15);    
    $row15= mysqli_fetch_assoc($result15);
    echo"<table border =1><tr>
    <th>title</th>
    <th>release_year</th>
    <th>type</th>
    </tr>";
    while($row15 = mysqli_fetch_assoc($result15);)
    {
        echo "<tr>".
        "<td>".$row["title"].
        "</td><td>".$row["release_year"]. 
        "</td><td>".$row["type"].
        "</td></tr>";    
    }
    echo "</table>";
    $query16="SELECT COUNT(type) movie_count
    FROM film_description
    WHERE type LIKE 'Movie'

    UNION

    SELECT COUNT(type) movie_count
    FROM film_description
    WHERE type LIKE 'TV Show';";
    $result16 = mysqli_query($con, $query16);    
    $row16= mysqli_fetch_assoc($result16);
    echo"<table border =1><tr>
    <th>movie_count</th>
    </tr>";
    while($row15 = mysqli_fetch_assoc($result15);)
    {
        echo "<tr>".
        "<td>".$row["movie_count"].
        "</td></tr>";    
    }
    $query17="SELECT * 
    FROM film_time 
    WHERE date_added REGEXP 'November [2-9][0-9]';"
    $result17 = mysqli_query($con, $query17);    
    $row17= mysqli_fetch_assoc($result17);
    echo"<table border =1><tr>
    <th>show_id</th>
    <th>date_added</th>
    <th>duration</th>
    <th>release_year</th>
    </tr>";
    while($row17 = mysqli_fetch_assoc($result17);)
    {
        echo "<tr>".
        "<td>".$row["show_id"].
        "</td><td>".$row["date_added"]. 
        "</td><td>".$row["duration"].
        "</td><td>".$row["release_year"].
        "</td></tr>";    
    }
    echo "</table>";
    $query18="SELECT * 
    FROM film_time 
    WHERE duration REGEXP '[1-9][0-9] Season';";
    $result18 = mysqli_query($con, $query18);    
    $row18= mysqli_fetch_assoc($result18);
    echo"<table border =1><tr>
    <th>show_id</th>
    <th>date_added</th>
    <th>duration</th>
    <th>release_year</th>
    </tr>";
    while($row18 = mysqli_fetch_assoc($result18);)
    {
        echo "<tr>".
        "<td>".$row["show_id"].
        "</td><td>".$row["date_added"]. 
        "</td><td>".$row["duration"].
        "</td><td>".$row["release_year"].
        "</td></tr>";    
    }
    echo "</table>";
	
    $query19="SELECT *
    FROM actor
    WHERE title REGEXP 'Duck|Queen';";
    $result19 = mysqli_query($con, $query19);    
    $row19= mysqli_fetch_assoc($result19);
    echo"<table border =1><tr>
    <th>show_id</th>
    <th>cast</th>
    <th>title</th>
    </tr>";
    while($row19 = mysqli_fetch_assoc($result19);)
    {
        echo "<tr>".
        "<td>".$row["show_id"].
        "</td><td>".$row["cast"]. 
        "</td><td>".$row["title"].
        "</td></tr>";    
    }
    echo "</table>";
    $query20="SELECT *
    FROM film_description
    WHERE listed_in REGEXP 'comedy' AND title REGEXP 'Christmas';";
    $result20 = mysqli_query($con, $query20);    
    $row20= mysqli_fetch_assoc($result20);
    echo"<table border =1>
    <tr>
    <th>show_id</th>
    <th>director</th>
    <th>type</th>
    <th>title</th>
    <th>listed_in</th>
    </tr>";
    while($row20 = mysqli_fetch_assoc($result20);)
    {
        echo "<tr>
        ."<td>".$row["show_id"].
        "</td><td>".$row["director"]. 
        "</td><td>".$row["type"].
        "</td><td>".$row["title"].
        "</td><td>".$row["listed_in"]"."</td><td>".
        "</tr>";    
    }
    echo "</table>";

    // closing connection is a must.  VERY IMPORTANT LINE
    $con->close();
}

else
{
    echo "failed to connect to db". mysqli_error($con);
    die("destroyed");
}

?>