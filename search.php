<html>
<body>

<style>
h1 {text-align: center;}
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

<h1>Search for Actor/Movie</h1>

<h2 style="text-align:center">Actor Search</h2>
<form method="get" action="search.php" style="margin:20px; text-align:center">
<input type="text" name="actor" placeholder="Actor's name"/><br />
<input type="submit" value="Submit" style="margin:20px"/>
</form>

<h2 style="text-align:center">Movie Search</h2>
<form method="get" action="search.php" style="margin:20px; text-align:center">
<input type="text" name="movie" placeholder="Movie's name"/><br />
<input type="submit" value="Submit" style="margin:20px"/>
</form>

<?php
$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}

if (isset($_GET["actor"])) {
    $condition = '';
    $exploded_search = explode(" ", $_GET["actor"]);
    $search_len = count($exploded_search);
    if ($search_len == 1) {
      $condition = "first LIKE '%".$exploded_search[0]."%' OR last LIKE '%".$exploded_search[0]."%'";
    } 
    elseif ($search_len == 2) {
      $condition = "first LIKE '%".$exploded_search[0]."%' AND last LIKE '%".$exploded_search[1]."%'";
    } 
    
    $query = "SELECT * FROM Actor WHERE ".$condition;
    $rs = $db->query($query);

    if ($rs->num_rows > 0) {
        echo "<h1>Results</h1>";

        echo "<table class=center style=margin-left:auto;margin-right:auto; border=1>
        <tr>
        <th>Name</th>
        </tr>";

        while ($row = $rs->fetch_assoc()) {
            echo "<tr>";
            $full_name = $row['first']." ".$row['last'];
            $id = $row['id'];
            echo "<td><a href='./actor.php?id=".$row['id']."'>" . $full_name . "</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else {
        echo "<h1>No results</h1>";
    }
    $rs->free();
}
elseif (isset($_GET["movie"])) {
    $exploded_search = explode(" ", $_GET["movie"]);
    $search_len = count($exploded_search);
    $condition = "title LIKE '%{$exploded_search[0]}%'";

    for ($i = 1; $i < $search_len; $i++) {
        $condition = $condition." AND (title LIKE '%{$exploded_search[$i]}%')";
    }
    
    $query = "SELECT * FROM Movie WHERE ".$condition;
    $rs = $db->query($query);

    
    if ($rs->num_rows > 0) {
        echo "<h1>Results</h1>";
        echo "<table class=center style=margin-left:auto;margin-right:auto; border=1>
        <tr>
        <th>Name</th>
        </tr>";

        while ($row = $rs->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='./movie.php?id=".$row['id']."'>" . $row['title'] . "</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else {
        echo "<h1>No results</h1>";
    }
    $rs->free();
}
$db->close();
$db->close();
?>




</body>
</html>