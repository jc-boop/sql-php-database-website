<html>
<body>
<style>
h1 {text-align: center;}
form {text-align: center;}
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

if (isset($_GET['id'])) {
	$condition = 'id='.$_GET['id'].";";
	$query = "SELECT title, id FROM Movie WHERE " .$condition;
    $rs = $db->query($query);
	while ($row = $rs->fetch_assoc()) {
	echo "<h1><a href='./movie.php?id=".$row['id']."'>" . $row['title'] . "</a></h1>";
	}
}
?>

<h2 style="text-align:center">Leave a review</h2>
<form method="post" style="margin:20px; text-align:center">
<label for="name">Name:</label><br>
<input type ="text" id="name" name="name"><br>
<input type="radio" id="one" name="rating" value="1">
<label for="one">1</label><br>
<input type="radio" id="two" name="rating" value="2">
<label for="two">2</label><br>
<input type="radio" id="three" name="rating" value="3">
<label for="three">3</label><br>
<input type="radio" id="four" name="rating" value="4">
<label for="four">4</label><br>
<input type="radio" id="five" name="rating" value="5">
<label for="five">5</label><br>
<label for="comment">Comment:</label><br>
<input type ="text" id="comment" name="comment"><br>
<input type="hidden" name="mid" value=.".$_GET['id']."/>
<input type="submit" value="Submit">
</form>

<?php
if (isset($_POST["comment"])) {
	$id = $_GET['id'];
	date_default_timezone_set('America/Los_Angeles');
	$condition = "('".$_POST["name"]."', '".date('Y-m-d H:i:s')."', '".$_GET["id"]."', '".$_POST["rating"]."', '".$_POST["comment"]."');";
	$query = "INSERT INTO Review VALUES ".$condition;
	$rs = $db->query($query);
	echo "<h3 style=text-align:center>Thank you for submitting your review!</h3>";
	echo "<h3 style=text-align:center><a href='./movie.php?id=".$_GET['id']."' >Please click here to return to the previous page</a></h3>";
}
$db->close();
?>
</body>
</html>


