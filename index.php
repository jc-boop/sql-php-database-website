<html>

<style>
body {text-align: center;}
nav {text-align: center;}
</style>

<nav id="navbar">
    <ul>
        <a href="index.php">Home</a>
        <a href="actor.php?id=4033">Actor</a>
        <a href="movie.php?id=15">Movie</a>
        <a href="search.php">Search</a>
        <a href="review.php?id=15">Review</a>
    </ul>
</nav>

<head><title>CS143 Projet 2 Website</title></head>

    <body>
        <h1>This is the project website for Johan Chiang and Josh McDermott for CS 143</h1> 
        <?php
        $db = new mysqli('localhost', 'cs143', '', 'class_db');
        if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
        }
        echo "Please use the navigation bar above.";
        ?>
    </body>
</html>
