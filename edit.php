<?php
	session_start();
?>
<!doctype html>
<html lang="se">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Soloäventyr - Redigera</title>
	<link href="https://fonts.googleapis.com/css?family=Merriweather|Merriweather+Sans" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav id="navbar">
	<a href="index.php">Hem</a>
	<a href="play.php?page=1">Spela</a>
	<a class="active" href="edit.php">Redigera</a>
</nav>
<main class="content">
	<section>
		<h1>Redigera</h1>

<form action="edit.php" method="POST">
  TEXT:<br>
<textarea rows="4" cols="50" name="text"> </textarea>
  <br>BILD:<br>
  <input type="text" name="bild" value="">
  <br>Tryck på sumbit för att skapa din fråga<br>
  <input type="submit" name="submit" value="Submit">
	<input type="submit" name="update" value="Update">
</form>

<?php
// TODO

include_once 'include/dbinfo.php';
// PDO
$dbh = new PDO('mysql:host=localhost;dbname=test;charset=utf8mb4', $dbuser, $dbpass);


if (isset($_POST['submit'])){
	$filteredText = filter_input(INPUT_POST, "text", FILTER_SANITIZE_EMAIL);
	$filteredPic = filter_input(INPUT_POST, "bild", FILTER_SANITIZE_SPECIAL_CHARS);
	$stmt = $dbh->prepare("INSERT INTO story (text, bild) VALUES (:text, :bild)");
	$stmt->bindparam(':text', $filteredText);
  $stmt->bindparam(':bild', $filteredPic);
	$stmt->execute();

var_dump($_POST);

}elseif(isset($_POST['update'])) {
	$filteredText = filter_input(INPUT_POST, "text", FILTER_SANITIZE_EMAIL);
	$filteredPic = filter_input(INPUT_POST, "bild", FILTER_SANITIZE_SPECIAL_CHARS);
	$stmt = $dbh->prepare("UPDATE story SET text= :text, bild= :bild WHERE 0");
	$stmt->bindparam(':text', $filteredText);
	$stmt->bindparam(':bild', $filteredPic);
	$stmt->execute();

}


$stmt = $dbh->prepare("SELECT * FROM story");
$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table>";

foreach ($row as $value){
	echo "<tr>";
			echo 	"<td>" . $value['id'] . "</td>";
			echo "<td>" . substr($value['text'], 0, 40) . " </td>";
	echo "<td <a href=\"edit.php?edit=" . $value['id'] . "\">Edit</a> </td>";
	echo "</tr>";
}

echo "</table>";

?>
</main>
<script src="js/navbar.js"></script>
</body>
</html>
