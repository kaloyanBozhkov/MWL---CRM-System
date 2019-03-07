<?php
//used by branches.php to load showMsg's select company field
require('assets/php/mySqlConnect.php');
$sql = 'SELECT CONCAT("b",branches.branchId) as "id", branches.branchName as "name", companies.companyName as "companyName" FROM `companies`, `branches` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId UNION SELECT CONCAT("c",employees.employeeId) as "id", employees.fullName as "name", CONCAT(branches.branchName, " - ", companies.companyName) as "companyName" FROM `companies`, `branches`,`membership`,`employees` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId';
$result = mysqli_query($link, $sql);
$number = mysqli_num_rows($result);
$fCIAN = "var BRANCHES_ID_NAMES = ".'"<option disabled>───── Branches ─────</option>';
$switch = false;
while($row = mysqli_fetch_array($result)){
    
    if(!$switch && substr($row['id'], 0, 1) == "c"){
        $switch = true;
        $fCIAN .= "<option disabled>───── Contacts ─────</option>";
    }
    $fCIAN .= "<option id='".$row['id']."'>".ucwords($row['name'])." - ".$row['companyName']."</option>";

}
echo($fCIAN.'"'.";");
?>