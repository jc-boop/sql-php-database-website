<html>
<body>

<style>
h1 {text-align: center;}
table {text-align: center;}
nav {text-align: center;}
div {text-align: center;}

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

$statement = $db->prepare("SELECT id,title,year,rating,company FROM Movie WHERE id=?");
$id=$_GET['id'];

$statement->bind_param('i',$id);
$statement->execute();
$statement->bind_result($returned_id, $returned_title,$returned_year,$returned_rating,$returned_company);
$statement->fetch()

?>
<h1>
  <?php echo $returned_title?>
</h1>
<nav>
<p>
  <?php echo "MPAA Rating: " . $returned_rating . "<br>"?>
  <?php echo "Year: " . $returned_year. "<br>"?>
  <?php echo "Production Co: " . $returned_company. "<br>"?>
  <?php $statement->close();?>
</p>
</nav>
<nav>
<?php
	$statement = $db->prepare("SELECT A.first, A.last,A.id FROM Actor A CROSS JOIN MovieActor M WHERE M.mid=? AND A.id=M.aid");
	$mid=$_GET['id'];

	$statement->bind_param('i',$mid);
	$statement->execute();
	$statement->bind_result($returned_first,$returned_last,$returned_id);
	while ($statement->fetch()) { 
	    echo "<a href=actor.php?id=" . $returned_id . ">" . $returned_first . ' ' . $returned_last . "</a><br>";
	}
	$statement = $db->prepare("SELECT AVG(rating) FROM Review GROUP BY mid HAVING mid=?");
	$mid=$_GET['id'];

	$statement->bind_param('i',$mid);
	$statement->execute();
	$statement->bind_result($returned_rating);



	$statement->fetch();
	echo "<br>Average rating: ";
	echo $returned_rating;
	echo "<br>";

	$statement->close();
	
	$mid=$_GET['id'];
	echo "<br><a href=\"review.php?id=" . $mid . "\""."><button>Leave A Review</button></a>";
	echo "<br>";

	$query = "SELECT comment, name, rating, time FROM Review WHERE mid = '$mid'";
	$rs = $db->query($query);
	$counter = 1;

	while ($row = $rs->fetch_assoc()) {
		echo "".$row['name']." commented on ".$row['time']." with a rating of ".$row['rating']." and said: ".$row['comment']."";
		echo "<br>";
	}

	$statement->close();
	$db->close();
?>
</nav>
</body>
</html>