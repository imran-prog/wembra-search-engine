<?php
include("..\config.php");

if(isset($_POST["csuiom"])) {
	$query = $con->prepare("UPDATE search SET times = times + 1 WHERE id=:id");
	$query->bindParam(":id", $_POST["csuiom"]);

	$query->execute();
}
else {
	echo "No link passed to page";
}
?>