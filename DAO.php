<?php
include("config.php");
class DAO{
public function dbConnect(){
$dbhost = "localhost"; // set the hostname
$dbname = "wembra" ; // set the database name
$dbuser = "root" ; // set the mysql username
$dbpass = "";  // set the mysql password
try {
$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass); 
$dbConnection->exec("set names utf8");
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $dbConnection;
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
}
public function searchData($searchVal){
try {
$dbConnection = $this->dbConnect();
$stmt = $dbConnection->prepare("SELECT * FROM `search` WHERE `words` like :searchVal ORDER BY times DESC LIMIT 6");
$val = "$searchVal%"; 
$stmt->bindParam(':searchVal', $val , PDO::PARAM_STR);   
$stmt->execute();
$Count = $stmt->rowCount(); 
//echo " Total Records Count : $Count .<br>" ;
$result ="" ;
if ($Count  > 0){
while($data=$stmt->fetch(PDO::FETCH_ASSOC)) {          
$result = $result .'<div class="search-result"><a class="csuiom" href="http://localhost/web/search?term='.$data['words'].'&type=web&UC=UTF-8&uic=Xgudksbvi429smvbiabvibfi7289fdkxnvkskabnvuh783uishvjhbg">'.$data['words'].'</a></div>';    
}
return $result ;
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
} 
}
?>