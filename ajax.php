
<?php
include('config.php');
$s1=$_REQUEST["n"];
$select_query="SELECT * FROM search WHERE words LIKE '%".$s1."%'";
$sql=mysqli_query($con,$select_query) or die (mysqli_error("Connection Failed"));
$s="";
while($term=mysqli_fetch_array($sql))
{
	$s=$s."
	<a class='link-p-colr' href='search?term=".$term['words']."'>
		<div class='live-outer'>
                <div class='live-product-det'>
                	<div class='live-product-name'>
                    	<p>".$term['words']."</p>
                    </div>
                </div>
            </div>
	</a>
	"	;
}
echo $s;
?>