<?php
//used by branches.php to load showMsg's select company field
require('assets/php/mySqlConnect.php');
$sql = "SELECT companyId, companyName, type FROM `companies` WHERE administratorId = " . $_SESSION['adminDetails']->id .";";

$result = mysqli_query($link, $sql);
$number = mysqli_num_rows($result);
$fCIAN = "var COMPANY_ID_NAMES = ".'"';
while($row = mysqli_fetch_array($result)){
    $fCIAN .= "<option id='".$row['companyId']."'>".ucwords($row['companyName'])." - ".$row['type']."</option>";

}
echo($fCIAN.'"'.";");
?>