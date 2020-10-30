<?php
include("DAO.php");
if(isset($_POST["searchtxt"])){
 
 $searchVal = trim($_POST["searchtxt"]);
 $dao = new DAO();
 echo $dao->searchData($searchVal);
}

?>