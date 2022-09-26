<html>
<body>

<style>
h1 {text-align: center;}
table {text-align: center;}
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

<?php
$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}

$id = $_GET['id'];

if (empty($id)) {
    $id = 4033;
}

$query = "SELECT * FROM Actor WHERE (id = '$id')";
$rs = $db->query($query);

echo "<h1>Actor Stats</h1>";
echo "<table class=center style=margin-left:auto;margin-right:auto; border=1>
    <tr>
        <th>Name</th>
        <th>Sex</th>
        <th>DoB</th>
        <th>DoD</th>
    </tr>";

while ($row = $rs->fetch_assoc()) {
    echo "<tr>";
    $full_name = $row['first']." ".$row['last'];
    $id = $row['id'];
    if ($row['dod'] == NULL) {
        $death = 'Still alive';
    }
    else {
        $death = $row['dod'];
    }
    echo "<td>" . "$full_name" . "</td>";
    echo "<td>" . $row['sex'] . "</td>";
    echo "<td>" . $row['dob'] . "</td>";
    echo "<td>" . $death . "</td>";
    echo "</tr>";
}

echo "</table>";


$rs->free();
$query = "SELECT title, id FROM Movie WHERE id IN (SELECT mid FROM MovieActor WHERE aid = '$id')";
$rs = $db->query($query);


echo "<h1>Actor Movies</h1>";
echo "<table class=center style=margin-left:auto;margin-right:auto; border=1>
<tr>
<th>Movie Title</th>
</tr>";


while ($row = $rs->fetch_assoc()) {
    echo "<tr>";
    echo "<td><a href='./movie.php?id=".$row['id']."'>" . $row['title'] . "</a></td>";
    echo "</tr>";
}
$rs->free();
$db->close();

echo "</table>";
?>
</body>
</html>