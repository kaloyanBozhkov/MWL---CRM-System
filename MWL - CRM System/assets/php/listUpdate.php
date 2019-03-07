<?php
require('mySqlConnect.php');
if(!isset($what)){
    $what = $_POST['what'];
}
if($what == "company"){
$sql = "SELECT branches.companyId as 'companyID', count(branches.branchId) as 'numberOfBranches' FROM companies, branches WHERE  companies.companyId = branches.companyId AND companies.administratorId = '".($_SESSION['adminDetails']->id) ."' GROUP BY branches.companyId";
$branchCount = new stdClass(); //Objects in PHP need a class, but the new stdClass() lets you start quickly without the class {...} jazz.;

$result = mysqli_query($link, $sql);
$number = mysqli_num_rows($result);

if ($number != 0) {
	while ($row = mysqli_fetch_array($result)) {
		$x = $row['companyID'];
		$y = $row['numberOfBranches'];
		$branchCount -> $x = $y;
	}
}

$sql = "SELECT * FROM companies WHERE `administratorId` = '".($_SESSION['adminDetails']->id) ."' ORDER BY administratorId ASC";

$result = mysqli_query($link, $sql);
$number = mysqli_num_rows($result);
if ($number != 0) {
	$div = "<!-- Start Company Listing -->";
	$cont = 1;
	while ($row = mysqli_fetch_array($result)) {
		$darker = "";
		if($cont % 2 == 0){
			$darker = 'class="darker"';
		}
		
		$bC = 0;
		
		if(isset($branchCount -> {$row['companyId']})){
			$bC = $branchCount -> {$row['companyId']};
		}
		
		$div .= '<tr class="separator block"></tr>
					<tr '.$darker .' id="'.$row['companyId'].'"><th>
					<div>
						<h4 class="title" id="">'.$row['companyName'].'</h4>
						</div>
	
						<div>
							<p class="category">'.$row['companyId'].' - '.$row['companyName'].' - Type: '.$row['type'].' - Branches: '. $bC .' - Visibility: '.$row['visibility'].'</p>
						</div>											
					</th></tr>';
					
		$cont++;
	}
	echo($div);
}else{
	echo('<p class="text-center">No companies to show yet.</p>');
}
}elseif($what == "branch"){ //BRANCHES START HERE ------------------------------------------------
$sql = "SELECT branches.branchId as 'branchID', count(employees.employeeId) as 'numberOfEmployees' 
FROM `employees`, `branches`, `companies`, `membership` 
WHERE  branches.branchId = membership.branchId 
AND membership.employeeId = employees.employeeId 
AND companies.companyId = branches.companyId 
AND companies.administratorId = '".($_SESSION['adminDetails']->id) ."'
GROUP BY branches.branchId";
    
$employeeCount = new stdClass(); //Objects in PHP need a class, but the new stdClass() lets you start quickly without the class {...} jazz.;

$result = mysqli_query($link, $sql);
$number = mysqli_num_rows($result);

if ($number != 0) {
	while ($row = mysqli_fetch_array($result)) {
		$x = $row['branchID'];
		$y = $row['numberOfEmployees'];
		$employeeCount -> $x = $y;
	}
}
    
    
$sql = "SELECT branches.*, companies.companyId, companies.companyName, companies.administratorId FROM branches, companies WHERE `administratorId` = '".($_SESSION['adminDetails']->id)."' AND branches.companyId = companies.companyId ORDER BY companies.companyId ASC";

$result = mysqli_query($link, $sql);
$number = mysqli_num_rows($result);
    
if ($number != 0) {
	$div = "<!-- Start Branch Listing -->";
	$cont = 1;
	while ($row = mysqli_fetch_array($result)) {
		$darker = "";
		if($cont % 2 == 0){
			$darker = 'class="darker"';
		}
			
        
        $cC = 0;
		
		if(isset($employeeCount -> {$row['branchId']})){
			$cC = $employeeCount -> {$row['branchId']};
		}
        
		$div .= '<tr class="separator block"></tr>
					<tr '.$darker .' id="'.$row['branchId'].'"><th>
					<div>
						<h4 class="title" id="">'.$row['branchName'].'</h4>
						</div>
	
						<div>
							<p class="category">'.$row['branchId'].' - '.ucfirst($row['companyName']).' - Employees: '.$cC.' - '.ucfirst($row['country']).' - '.ucfirst($row['city']).' -  '.$row['postcode'].' -  '.$row['address'].' -  '.$row['number'].' -  '.$row['floor'].'</p>
							
						</div>											
					</th></tr>';
					
		$cont++;
	}
	echo($div);
}else{
    $sql = "SELECT COUNT(companies.companyId) as 
    'totalCompanies' FROM `companies` WHERE companies.administratorId = '".($_SESSION['adminDetails']->id)."'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    $d = "";
    if($row['totalCompanies'] == 0){
        $d = '<span id="cCHecker" class="hidden"></span>';        
    }    
	echo($d.'<p class="text-center">No branches to show yet.</p>');
}
}elseif($what == "contact"){ //CONTACT SSTART HERE -----------------------------------------------------
    $sql = "SELECT companies.companyName, branches.branchId, branches.branchName, employees.* FROM `branches`, `employees`, `membership`, `companies` WHERE membership.branchId = branches.branchId AND membership.employeeId = employees.employeeId AND companies.companyId = branches.companyId AND companies.administratorId = '".($_SESSION['adminDetails']->id)."' ORDER BY employees.employeeId ASC";

    $result = mysqli_query($link, $sql);
    $number = mysqli_num_rows($result);
    
if ($number != 0) {
	$div = "<!-- Start Employee Listing -->";
	$cont = 1;
	while ($row = mysqli_fetch_array($result)) {
		$darker = "";
		if($cont % 2 == 0){
			$darker = 'class="darker"';
		}
			
		$div .= '<tr class="separator block"></tr>
					<tr '.$darker .' id="'.$row['employeeId'].'"><th>
					<div>
						<h4 class="title" id="">'.$row['fullName'].'</h4>
						</div>
	
						<div>
							<p class="category">'.$row['employeeId'].' - '.ucfirst($row['branchName']).' - '.ucfirst($row['companyName']).' - '.ucfirst($row['age']).' - '.ucfirst($row['sex']).'</p>
							
						</div>											
					</th></tr>';
					
		$cont++;
	}
	echo($div);
}else{
    $sql = "SELECT COUNT(branches.branchId) as 
    'totalBranches' FROM `companies`,`branches` WHERE companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND branches.companyId = companies.companyId;";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    $d = "";
    if($row['totalBranches'] == 0){
        $d = '<span id="cCHecker" class="hidden"></span>';        
    }    
	echo($d.'<p class="text-center">No contacts to show yet.</p>');
}
    
    
}elseif($what == "email address"){ //EMAIL ADDRESSES START HERE -----------------------------------------------------
    $sql = "SELECT emailaddresses.*, CONCAT(employees.fullName, ' [', branches.branchName, ' - ', companies.companyName, ']' ) as 'name' FROM `employees`, `emailaddresses`, `membership`,`companies`,`branches` WHERE emailaddresses.employeeId = employees.employeeId AND companies.companyId = branches.companyId AND membership.branchId = branches.branchId AND employees.employeeId = membership.employeeId AND companies.administratorId = '".($_SESSION['adminDetails']->id)."' UNION ALL
    SELECT emailaddresses.*, CONCAT(branches.branchName, ' [', companies.companyName, ']') as 'name' FROM `branches`,`emailaddresses`,`companies` WHERE emailaddresses.branchId = branches.branchId AND branches.companyId = companies.companyId AND companies.administratorId = '".($_SESSION['adminDetails']->id)."';";
    $result = mysqli_query($link, $sql);
    $number = mysqli_num_rows($result);
    
if ($number != 0) {
	$div = "<!-- Start Email Address Listing -->";
	$cont = 1;
	while ($row = mysqli_fetch_array($result)) {
		$darker = "";
		if($cont % 2 == 0){
			$darker = 'class="darker"';
		}
        $wht = "Owner:";
        
        if($row['entityType'] == "branch"){
             $wht = "Branch:";
        }
        
		$div .= '<tr class="separator block"></tr>
					<tr '.$darker .' id="'.$row['emailaddressId'].'"><th>
					<div>
						<h4 class="title">'.$row['emailFull'].'</h4>
						</div>
						<div>
							<p class="category">'.$row['emailaddressId'] .' - '.$wht.' <b>'.explode("[", ucwords($row['name']))[0].'</b> ['.explode("[", ucwords($row['name']))[1].' - '.ucfirst($row['emailAddressType']).'</p>
						</div>		
					</th></tr>';
					
		$cont++;
	}
	echo($div);
}else{
    $sql = "SET @a = (SELECT COUNT(branches.branchId) FROM `companies`,`branches` WHERE companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND branches.companyId = companies.companyId);
    SET @b = (SELECT COUNT(employees.employeeId) FROM `companies`,`branches`, `employees`, `membership` WHERE companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND branches.companyId = companies.companyId AND membership.branchId = branches.branchId AND employees.employeeId = membership.employeeId);
    SELECT @a + @b as 'total';";
    $total = 0;
// Execute multi query
 if (mysqli_multi_query($link,$sql)){
  while(mysqli_more_results($link) && mysqli_next_result($link)){
    // Store first result set
    if ($result=mysqli_store_result($link)) {
      // Fetch one and one row
        $row=mysqli_fetch_array($result);
        $total = $row['total'];
      // Free result set
      mysqli_free_result($result);
      }
    }
}
  
    $d = "";
    if($total == 0){
        $d = '<span id="cCHecker" class="hidden"></span>';        
    }    
	echo($d.'<p class="text-center">No email addresses to show yet.</p>');
}
    
    
}elseif($what == "phone number"){ //PHONE NUMBERS START HERE -----------------------------------------------------
    $sql = 'SELECT phonenumbers.*, CONCAT(employees.fullName, " [", branches.branchName, " - ", companies.companyName, "]") as "ownerName" FROM `companies`, `branches`, `membership`,`employees`,`phonenumbers` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId ANd branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND employees.employeeId = phonenumbers.employeeId UNION ALL SELECT phonenumbers.*, CONCAT(branches.branchName, " [", companies.companyName, "]") as "ownerName" FROM `companies`, `branches`, `phonenumbers` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = phonenumbers.branchId;';

    $result = mysqli_query($link, $sql);
    $number = mysqli_num_rows($result);
    
if ($number != 0) {
	$div = "<!-- Start Phone Number Listing -->";
	$cont = 1;
	while ($row = mysqli_fetch_array($result)) {
		$darker = "";
		if($cont % 2 == 0){
			$darker = 'class="darker"';
		}
        $wht = "Owner:";
        
        if($row['entityType'] == "branch"){
             $wht = "Branch:";
        }
        
		$div .= '<tr class="separator block"></tr>
					<tr '.$darker .' id="'.$row['phonenumberId'].'"><th>
					<div>
						<h4 class="title">'.explode('[', $row['ownerName'])[0].'</h4>
						</div>
						<div>
							<p class="category">'.$row['phonenumberId'] .' - <b>'.$row['phoneNumberFull'].'</b> -  '.ucfirst($row['phoneNumberType']).' - '.$wht.' <b>'.explode("[", ucwords($row['ownerName']))[0].'</b> ['.explode("[", ucwords($row['ownerName']))[1].' </p>
						</div>		
					</th></tr>';
					
		$cont++;
	}
	echo($div);
}else{
    $sql = "SET @a = (SELECT COUNT(branches.branchId) FROM `companies`,`branches` WHERE companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND branches.companyId = companies.companyId);
    SET @b = (SELECT COUNT(employees.employeeId) FROM `companies`,`branches`, `employees`, `membership` WHERE companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND branches.companyId = companies.companyId AND membership.branchId = branches.branchId AND employees.employeeId = membership.employeeId);
    SELECT @a + @b as 'total';";
    $total = 0;
// Execute multi query
 if (mysqli_multi_query($link,$sql)){
  while(mysqli_more_results($link) && mysqli_next_result($link)){
    // Store first result set
    if ($result=mysqli_store_result($link)) {
      // Fetch one and one row
        $row=mysqli_fetch_array($result);
        $total = $row['total'];
      // Free result set
      mysqli_free_result($result);
      }
    }
}
  
    $d = "";
    if($total == 0){
        $d = '<span id="cCHecker" class="hidden"></span>';        
    }    
	echo($d.'<p class="text-center">No phone numbers to show yet.</p>');
}
    
    
}

									
?>