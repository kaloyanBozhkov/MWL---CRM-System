<?php
//used by branches.php to load showMsg's select company field
require('assets/php/mySqlConnect.php');
$sql = "SELECT branches.branchId, branches.branchName, companies.companyName FROM `companies`, `branches` WHERE companies.administratorId = " . $_SESSION['adminDetails']->id ." AND companies.companyId = branches.companyId;";

$result = mysqli_query($link, $sql);
$number = mysqli_num_rows($result);
$fCIAN = "var BRANCHES_ID_NAMES = ".'"';
while($row = mysqli_fetch_array($result)){
    $fCIAN .= "<option id='".$row['branchId']."'>".ucwords($row['branchName'])." - ".$row['companyName']."</option>";

}
echo($fCIAN.'"'.";");
?>