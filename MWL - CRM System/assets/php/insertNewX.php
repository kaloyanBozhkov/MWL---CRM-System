<?php
require('mySqlConnect.php');
$what = mysqli_real_escape_string($link, $_POST['what']);
$optional = mysqli_real_escape_string($link, $_POST['optional']);
$extra2 = "";
if($what == "company"){
	$where = "companies";
	$extra = "(`companyId`, `companyName`, `type`, `description`, `visibility`, `administratorId`) 
VALUES 
('','New Company', 'No type', 'There is no description yet.', '0',  '".($_SESSION['adminDetails']->id) ."');";
}elseif($what == "branch"){
	$where = "branches";
	$extra = "(`branchId`, `companyId`, `country`, `city`, `postcode`, `address`, `number`, `floor`, `branchName`, `description`, `visibility`) 
	VALUES 
	('','".$optional."', 'country', 'city', 'postcode', 'address','0','floor','New Branch','No description added yet.','0');";
}elseif($what == "contact"){
	$what = "employee";
	$where = "employees";
	$extra = "(`employeeId`, `fullName`, `firstName`, `lastName`, `details`, `sex`, `age`) 
	VALUES 
	('','Name Surename', 'Name', 'Surename', 'Details', 'Sex','0');";	
   $extra2 = " INSERT INTO `membership`(`branchId`,`employeeId`,`creationDate`) VALUES ('".$optional."',@m,'".date("Y-m-d")."'); ";
}elseif($what == "email address"){
    $what = "emailaddress";
    $where = "emailaddresses";
    $branchId = "null";
    $employeeId = "null";
    $entityType = "";
    if(substr($optional, 0, 1) == "c"){
        $employeeId = "'".substr($optional, 1)."'";
        $entityType = "employee";
    }else{
        $branchId = "'".substr($optional, 1)."'";
        $entityType = "branch";
    }
    $extra = " (`emailaddressId`,`branchId`, `employeeId`, `emailFull`, `email`, `domain`, `emailAddressType`, `entityType`) VALUES ('',".$branchId.",".$employeeId.",'email@address.com','email','domain.com','Address Type','".$entityType."');";
    
}elseif($what == "phone number"){
    $what = "phonenumber";
    $where = "phonenumbers";
    $branchId = "null";
    $employeeId = "null";
    $entityType = "";
    if(substr($optional, 0, 1) == "c"){
        $employeeId = "'".substr($optional, 1)."'";
        $entityType = "employee";
    }else{
        $branchId = "'".substr($optional, 1)."'";
        $entityType = "branch";
    }
    $extra = " (`phonenumberId`,`branchId`, `employeeId`, `phoneNumberFull`, `countryCode`, `phoneNumber`, `phoneNumberType`, `entityType`) VALUES ('',".$branchId.",".$employeeId.",'(+1) 000-00-00-000','(+1)','000-00-00-000','Number Type','".$entityType."');";
    
}
$sql = "SET @m = (SELECT IFNULL(MAX(".$what."Id), '0') + 1 FROM `".$where."` ); 
SET @s = CONCAT('ALTER TABLE `".$where."` AUTO_INCREMENT=', @m);
PREPARE stmt1 FROM @s;
EXECUTE stmt1;
DEALLOCATE PREPARE stmt1;
INSERT INTO `".$where."`".$extra.$extra2;


if(mysqli_multi_query($link, $sql)){
	echo($sql);
}else{
	echo($sql);
};			

?>