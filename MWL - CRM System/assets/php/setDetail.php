<?php
require('mySqlConnect.php');
$id = mysqli_real_escape_string($link, $_POST['id']);
$what = mysqli_real_escape_string($link, $_POST['what']);
$value = $_POST['value'];
$details = json_decode($value);
$sql = "";
if($what == "company"){
	$where = "companies";
	if($details[5] == "no"){
		$sql .= "UPDATE `".$where."` 
		SET 
		`companyName`='".ucwords(mysqli_real_escape_string($link, $details[1]))."',
		`type`='".mysqli_real_escape_string($link, $details[2])."',
		`description`='".mysqli_real_escape_string($link, $details[3])."',
		`visibility`='".mysqli_real_escape_string($link, $details[4])."'
		 WHERE 
		`companyId` = '".mysqli_real_escape_string($link, $details[0])."' 
		AND 
		`administratorId` = '".($_SESSION['adminDetails']->id) ."';";
	}else{
		$sql .= "DELETE FROM `".$where."` WHERE `companyId` = '" . mysqli_real_escape_string($link, $details[0])."' AND `administratorId` = '".($_SESSION['adminDetails']->id) ."';";
	}
}elseif($what == "branch"){
	$where = "branches";
	$sql .= "SET @a = (SELECT branches.branchId FROM `companies`, `branches` WHERE companies.companyId = branches.companyId AND companies.administratorId = '".($_SESSION['adminDetails']->id) ."' AND branches.branchId = '".mysqli_real_escape_string($link, $details[0])."');";
  	if($details[11] == "no"){
		$sql .= "UPDATE `".$where."` 
		SET 
		`branchName`='".ucwords(mysqli_real_escape_string($link, $details[1]))."',
		`companyId`='".mysqli_real_escape_string($link, $details[2])."',
		`description`='".mysqli_real_escape_string($link, $details[3])."',
		`country`='".ucwords(mysqli_real_escape_string($link, $details[4]))."',
		`city`='".ucwords(mysqli_real_escape_string($link, $details[5]))."',
		`postcode`='".strtoupper(mysqli_real_escape_string($link, $details[6]))."',
        `address`='".ucwords(mysqli_real_escape_string($link, $details[7]))."',
		`number`='".mysqli_real_escape_string($link, $details[8])."',
		`floor`='".mysqli_real_escape_string($link, $details[9])."',
		`visibility`='".mysqli_real_escape_string($link, $details[10])."'
		 WHERE 
		`branchId` = @a;";
	}else{
		$sql .= "DELETE FROM `".$where."` WHERE `branchId` = @a;";
	}  
    
    
    
    
}elseif($what == "contact"){
	$where = "employees";
	$what = "employee";
	$sql .= "SET @a = (SELECT employees.employeeId FROM `companies`, `branches`, `membership`, `employees` WHERE companies.companyId = branches.companyId AND companies.administratorId = '".($_SESSION['adminDetails']->id) ."' AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND employees.employeeId = '" . mysqli_real_escape_string($link, $details[0])."');";
	  	if($details[8] == "no"){
		$sql .= "UPDATE `".$where."` 
		SET 
		`firstname`='".ucwords(mysqli_real_escape_string($link, $details[1]))."',
		`lastName`='".mysqli_real_escape_string($link, $details[2])."',
		`details`='".ucwords(mysqli_real_escape_string($link, $details[4]))."',
        `sex`='".ucwords(mysqli_real_escape_string($link, $details[5]))."',
        `age`='".ucwords(mysqli_real_escape_string($link, $details[6]))."',
		`visibility`='".mysqli_real_escape_string($link, $details[7])."',
        `fullName` = '".ucwords(mysqli_real_escape_string($link, $details[1])) .' '.ucwords(mysqli_real_escape_string($link, $details[2]))."'
		 WHERE 
		`employeeId` = '".mysqli_real_escape_string($link, $details[0])."';
        UPDATE `membership` SET 
        `branchId`='".mysqli_real_escape_string($link, $details[3])."'
        WHERE
        `employeeId`=@a;
        ";
	}else{
		$sql .= "DELETE FROM `".$where."` WHERE `employeeId` = @a;";
	}  
}elseif($what == "email address"){
	$where = "emailaddresses";
	$what = "emailaddress";
    $id = mysqli_real_escape_string($link, $details[2]);
    $branchId = "null";
    $employeeId = "null";
    $type = "";
    if(substr($id,0,1) == "b"){
        $branchId ="'".substr($id,1)."'";
        $type = "branch";
    }else{
        $employeeId = "'".substr($id,1)."'";
        $type = "employee";
    }
    $email = mysqli_real_escape_string($link, $details[1]);
    $mail = explode("@", $email)[0];
    $domain = explode("@", $email)[1];
	$sql .= "SET @a = (SELECT emailaddresses.emailaddressId FROM `companies`, `branches`, `membership`, `employees`, `emailaddresses` WHERE companies.companyId = branches.companyId AND companies.administratorId = '".($_SESSION['adminDetails']->id) ."' AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND employees.employeeId = emailaddresses.employeeId AND emailaddresses.emailaddressId = '" . mysqli_real_escape_string($link, $details[0])."' UNION ALL SELECT emailaddresses.emailaddressId FROM `companies`,`branches`,`emailaddresses` WHERE companies.companyId = branches.companyId AND companies.administratorId = '".($_SESSION['adminDetails']->id) ."' AND branches.branchId = emailaddresses.branchId AND emailaddresses.emailaddressId = '" . mysqli_real_escape_string($link, $details[0])."');";
	if($details[4] == "no"){
		$sql .= "UPDATE `".$where."` 
		SET 
		`branchId`=".$branchId.",
		`employeeId`=".$employeeId.",
        `emailFull`='".$email."',
        `email`='".$mail."',
        `domain`='".$domain."',
		`emailAddressType`='".ucfirst(mysqli_real_escape_string($link, $details[3]))."',
        `entityType` = '".$type."'
		 WHERE 
		`emailaddressId` = @a;";
	}else{
		$sql .= "DELETE FROM `".$where."` WHERE `emailAddressId` = @a;";
	}  
}elseif($what == "phone number"){
	$where = "phonenumbers";
	$what = "phonenumber";
    $id = mysqli_real_escape_string($link, $details[2]);
    $branchId = "null";
    $employeeId = "null";
    $type = "";
    if(substr($id,0,1) == "b"){
        $branchId ="'".substr($id,1)."'";
        $type = "branch";
    }else{
        $employeeId = "'".substr($id,1)."'";
        $type = "employee";
    }
    $phoneNumberFull = mysqli_real_escape_string($link, $details[1]);
    $countryCode = explode(")", $phoneNumberFull)[0].")";
	$phoneNumber = explode(")", $phoneNumberFull)[1];
	$sql .= "SET @a = (SELECT phonenumbers.phonenumberId FROM `companies`, `branches`, `membership`, `employees`, `phonenumbers` WHERE companies.companyId = branches.companyId AND companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND employees.employeeId = phonenumbers.employeeId AND phonenumbers.phonenumberId = '" . mysqli_real_escape_string($link, $details[0])."' UNION ALL SELECT phonenumbers.phonenumberId FROM `companies`,`branches`,`phonenumbers` WHERE companies.companyId = branches.companyId AND companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND branches.branchId = phonenumbers.branchId AND phonenumbers.phonenumberId = '" . mysqli_real_escape_string($link, $details[0])."');";

	  	if($details[4] == "no"){
		$sql .= "UPDATE `".$where."` 
		SET 
		`branchId`=".$branchId.",
		`employeeId`=".$employeeId.",
        `phoneNumberFull`='".$phoneNumberFull."',
        `phoneNumber`='".$phoneNumber."',
        `countryCode`='".$countryCode."',
		`phoneNumberType`='".ucfirst(mysqli_real_escape_string($link, $details[3]))."',
        `entityType` = '".$type."'
		 WHERE 
		`phonenumberId` = @a;";
	}else{
		$sql .= "DELETE FROM `".$where."` WHERE `phonenumberId` = @a;";
	}  
}

if(mysqli_multi_query($link, $sql)){
	echo(true);
}else{
	echo(false);
};
?>