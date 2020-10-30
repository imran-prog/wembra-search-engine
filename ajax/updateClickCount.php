<?php
include("..\config.php");

if(isset($_POST["linkId"])) {
	$query = $con->prepare("UPDATE clicks SET use = use + 1 WHERE id=:id");
	$query->bindParam(":id", $_POST["linkId"]);

	$query->execute();
}
else {
	echo "No link passed to page";
}
?>