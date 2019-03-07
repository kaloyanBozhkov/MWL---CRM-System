<?php
require('mySqlConnect.php');
$id = mysqli_real_escape_string($link, $_POST['id']);
$what = mysqli_real_escape_string($link, $_POST['what']);
$selectOptions = "";
if($what == "company"){
    $sql = "SELECT * FROM `companies` WHERE companyId = ".$id." AND administratorId = ".($_SESSION['adminDetails']->id)." ORDER BY companyId ASC";
}elseif($what == "branch"){
    $sql = "SELECT companies.companyId, companies.companyName FROM `companies` WHERE companies.administratorId = '".($_SESSION['adminDetails']->id)."';";

    $result = mysqli_query($link, $sql);
    $number = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result)){
          $selectOptions .= '<option id="'.$row['companyId'].'">'.$row['companyName'].'</option>';
    }
    $sql = "SELECT branches.*, companies.companyId, companies.companyName FROM `branches`, `companies` WHERE branchId = ".$id." AND branches.companyId = companies.companyId ORDER BY branchId ASC";
  
}elseif($what == "contact"){
	$what = "employee";

     $sql = "SELECT branches.branchId, branches.branchName FROM `branches`, `companies` WHERE companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND branches.companyId = companies.companyId;";

    $result = mysqli_query($link, $sql);
    $number = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result)){
          $selectOptions .= '<option id="'.$row['branchId'].'">'.$row['branchName'].'</option>';
    }
    
   $sql="SELECT employees.*, branches.branchId, branches.branchName FROM `employees`, `membership`, `branches`, `companies` WHERE employees.employeeId = ".$id." AND employees.employeeId = membership.employeeId AND membership.branchId = branches.branchId AND companies.companyId = branches.companyId AND companies.administratorId = '".($_SESSION['adminDetails']->id)."' ORDER BY employees.employeeId ASC";
    
}elseif($what == "email address"){
	//fetch select field branch and employee options
    $sql = 'SELECT CONCAT("b",branches.branchId) as "id", branches.branchName as "name", companies.companyName as "companyName" FROM `companies`, `branches` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId UNION SELECT CONCAT("c",employees.employeeId) as "id", employees.fullName as "name", CONCAT(branches.branchName, " - ", companies.companyName) as "companyName" FROM `companies`, `branches`,`membership`,`employees` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId';
    $result = mysqli_query($link, $sql);
    $switch = false;
    $selectOptions .="<option disabled>───── Branches ─────</option>";
    while($row = mysqli_fetch_array($result)){
      if(!$switch && substr($row['id'], 0, 1) == "c"){
            $switch = true;
            $selectOptions .= "<option disabled>───── Contacts ─────</option>";
      }
      $selectOptions .= '<option id="'.$row['id'].'">'.$row['name'].'</option>';
    } 


//fetch selected email address row
	
    $sql = "SELECT emailaddresses.* FROM `emailaddresses`, `membership`, `branches`,`companies` WHERE
companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND branches.branchId = emailaddresses.branchId AND emailaddresses.emailaddressId = '".$id."' UNION ALL SELECT emailaddresses.* FROM `emailaddresses`, `membership`, `branches`,`companies`, `employees` WHERE
companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND employees.employeeId = emailaddresses.employeeId AND emailaddresses.emailaddressId = '".$id."';";
   
    
}elseif($what == "phone number"){
	//fetch select field branch and employee options
    $sql = 'SELECT CONCAT("b",branches.branchId) as "id", branches.branchName as "name", companies.companyName as "companyName" FROM `companies`, `branches` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId UNION SELECT CONCAT("c",employees.employeeId) as "id", employees.fullName as "name", CONCAT(branches.branchName, " - ", companies.companyName) as "companyName" FROM `companies`, `branches`,`membership`,`employees` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId';
    $result = mysqli_query($link, $sql);
    $switch = false;
    $selectOptions .="<option disabled>───── Branches ─────</option>";
    while($row = mysqli_fetch_array($result)){
      if(!$switch && substr($row['id'], 0, 1) == "c"){
            $switch = true;
            $selectOptions .= "<option disabled>───── Contacts ─────</option>";
      }
      $selectOptions .= '<option id="'.$row['id'].'">'.$row['name'].'</option>';
    } 


//fetch selected phone number row
	
    $sql = "SELECT phonenumbers.* FROM `companies`, `branches`, `membership`, `employees`,`phonenumbers` WHERE companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND employees.employeeId = phonenumbers.employeeId AND phonenumbers.phonenumberId = '".$id."' UNION ALL SELECT phonenumbers.* FROM `companies`, `branches`, `phonenumbers` WHERE companies.administratorId = '".($_SESSION['adminDetails']->id)."' AND companies.companyId = branches.companyId AND branches.branchId = phonenumbers.branchId AND phonenumbers.phonenumberId = '".$id."';";
   
    
}
$result = mysqli_query($link, $sql);
$number = mysqli_num_rows($result);
if ($number != 0) {
	$div = "There was an issue with communicating to the server, please try again later. ";
	$row = mysqli_fetch_array($result);
	if($what == "company")
    {
		$div = '<table class="w-100">
			<tbody>
			<tr class="separator block"></tr>
											
			<tr>
			<th class="text-left">								
					<h4 class="title">ID</h4> 				
			</th>
			<th class="text-center"> 
				<p class="category" id="companyId">'.$row['companyId'].'</p>
			</th>
			</tr>
			<tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Company Name</h4> 								
			</th>
			<th class="text-center"> 
				<input type="text" id="companyName" class="font-weight-normal text-center w-80" value="'.$row['companyName'].'"/>
			</th>
			</tr>
			
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Type</h4> 		
			</th>
			<th class="text-center"> 
				<input type="text" id="companyType" class="font-weight-normal text-center w-80" value="'.$row['type'].'"/>
			</th>
			</tr>
			
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Description</h4> 		
			</th>
			<th class="text-center"> 
				<div class="parent w-100">
					<textarea id="companyDescription" style="resize:vertical;text-align:left;" class="child font-weight-normal text-center">'.$row['description'].'</textarea>
				</div>
			</th>
			</tr>
			
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Visibility</h4> 		
			</th>
			<th class="text-center"> 
			<input type="number" min="0" max="1" id="companyVisibility" class="font-weight-normal text-center w-80" value="'.$row['visibility'].'"/>
			</th>
			</tr>
			
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Delete</h4> 		
			</th>
			<th class="text-center"> 
			<select id="delete" class="font-weight-normal text-center w-80">
			  <option value="no">No</option>
			  <option value="yes">Yes</option>
			</select>
			</th>
			</tr>
			</tbody>
			</table>
			<div class="row m-0 m-top-25 noEffect">
				<div id="saveChanges" class="col-xs-10 col-xs-push-1 text-center"><button class="btn btn-default w-100 ">SAVE CHANGES<div class="ripple-container"></div></button></div>
			</div>
			<div class="row m-0 noEffect">
				<div id="closeChanges" class="col-xs-10 col-xs-push-1 text-center"><button class="btn btn-default w-100 ">CLOSE</button></div></div>
			</div>	
				';
	
    }elseif($what == "branch")
    {
        $div = '<table class="w-100">
			<tbody>
			<tr class="separator block"></tr>
											
			<tr>
			<th class="text-left">								
					<h4 class="title">ID</h4> 				
			</th>
			<th class="text-center"> 
				<p class="category" id="branchId">'.$row['branchId'].'</p>
			</th>
			</tr>
			<tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Branch Name</h4> 								
			</th>
			<th class="text-center"> 
				<input type="text" id="branchName" class="font-weight-normal text-center w-80" value="'.$row['branchName'].'"/>
			</th>
			</tr>
			
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Company</h4> 		
			</th>
			<th class="text-center"> 
			<select id="branchCompanyId" class="font-weight-normal text-center w-80">
			  '.str_replace('id="'.$row['companyId'].'"','id="'.$row['companyId'].'" selected', $selectOptions).'
			</select>
			</th>
			</tr>
			
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Description</h4> 		
			</th>
			<th class="text-center"> 
				<div class="parent w-100">
					<textarea id="branchDescription" style="resize:vertical;text-align:left;" class="child font-weight-normal text-center">'.$row['description'].'</textarea>
				</div>
			</th>
			</tr>
			
            
            <tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Country</h4> 								
			</th>
			<th class="text-center"> 
				<input type="text" id="branchCountry" class="font-weight-normal text-center w-80" value="'.$row['country'].'"/>
			</th>
			</tr>  
            <tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">City</h4> 								
			</th>
			<th class="text-center"> 
				<input type="text" id="branchCity" class="font-weight-normal text-center w-80" value="'.$row['city'].'"/>
			</th>
			</tr>  
            <tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Postcode</h4> 								
			</th>
			<th class="text-center"> 
				<input type="text" id="branchPostcode" class="font-weight-normal text-center w-80" value="'.$row['postcode'].'"/>
			</th>
			</tr>
            
            <tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Address</h4> 								
			</th>
			<th class="text-center"> 
				<input type="text" id="branchAddress" class="font-weight-normal text-center w-80" value="'.$row['address'].'"/>
			</th>
			</tr>
            <tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Number</h4> 								
			</th>
			<th class="text-center"> 
				<input type="text" id="branchNumber" class="font-weight-normal text-center w-80" value="'.$row['number'].'"/>
			</th>
			</tr>
          <tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Floor</h4> 								
			</th>
			<th class="text-center"> 
				<input type="text" id="branchFloor" class="font-weight-normal text-center w-80" value="'.$row['floor'].'"/>
			</th>
			</tr>
            
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Visibility</h4> 		
			</th>
			<th class="text-center"> 
			<input type="number" min="0" max="1" id="branchVisibility" class="font-weight-normal text-center w-80" value="'.$row['visibility'].'"/>
			</th>
			</tr>
			
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Delete</h4> 		
			</th>
			<th class="text-center"> 
			<select id="delete" class="font-weight-normal text-center w-80">
			  <option value="no">No</option>
			  <option value="yes">Yes</option>
			</select>
			</th>
			</tr>
			</tbody>
			</table>
			<div class="row m-0 m-top-25 noEffect">
				<div id="saveChanges" class="col-xs-10 col-xs-push-1 text-center"><button class="btn btn-default w-100 ">SAVE CHANGES<div class="ripple-container"></div></button></div>
			</div>
			<div class="row m-0 noEffect">
				<div id="closeChanges" class="col-xs-10 col-xs-push-1 text-center"><button class="btn btn-default w-100 ">CLOSE</button></div></div>
			</div>	
				';
        
        
        
        
        
        
        
        
        
        
        
        
	
    
    }elseif($what == "employee")
    {
		$what = "employee";
        $div = '<table class="w-100">
			<tbody>
			<tr class="separator block"></tr>
											
			<tr>
			<th class="text-left">								
					<h4 class="title">ID</h4> 				
			</th>
			<th class="text-center"> 
				<p class="category" id="employeeId">'.$row['employeeId'].'</p>
			</th>
			</tr>
			<tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Name</h4> 								
			</th>
			<th class="text-center"> 
				<input type="text" id="employeeFirstName" class="font-weight-normal text-center w-80" value="'.$row['firstName'].'"/>
			</th>
			</tr>
            
            <tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Surename</h4> 								
			</th>
			<th class="text-center"> 
				<input type="text" id="employeeLastName" class="font-weight-normal text-center w-80" value="'.$row['lastName'].'"/>
			</th>
			</tr>
			
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Branch</h4> 		
			</th>
			<th class="text-center"> 
			<select id="branchCompanyId" class="font-weight-normal text-center w-80">
			  '.str_replace('id="'.$row['branchId'].'"','id="'.$row['branchId'].'" selected', $selectOptions).'
			</select>
			</th>
			</tr>
			
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Details</h4> 		
			</th>
			<th class="text-center"> 
				<div class="parent w-100">
					<textarea id="employeeDetails" style="resize:vertical;text-align:left;" class="child font-weight-normal text-center">'.$row['details'].'</textarea>
				</div>
			</th>
			</tr>
            
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Sex</h4> 		
			</th>
			<th class="text-center"> 
			<select id="employeeSex" class="font-weight-normal text-center w-80">
			 '.str_replace('id="'.$row['sex'].'"','id="'.$row['sex'].'" selected','<option id="male">Male</option>
			  <option id="female">Female</option>').'
			</select>
			</th>
			</tr>
            
            	<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Age</h4> 		
			</th>
			<th class="text-center"> 
			<input type="number" min="1" max="120" id="employeeAge" class="font-weight-normal text-center w-80" value="'.$row['age'].'"/>
			</th>
			</tr>
            
            	<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Visibility</h4> 		
			</th>
			<th class="text-center"> 
			<input type="number" min="0" max="1" id="employeeVisibility" class="font-weight-normal text-center w-80" value="'.$row['visibility'].'"/>
			</th>
			</tr>
			
			<tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Delete</h4> 		
			</th>
			<th class="text-center"> 
			<select id="delete" class="font-weight-normal text-center w-80">
			  <option value="no">No</option>
			  <option value="yes">Yes</option>
			</select>
			</th>
			</tr>
			</tbody>
			</table>
			<div class="row m-0 m-top-25 noEffect">
				<div id="saveChanges" class="col-xs-10 col-xs-push-1 text-center"><button class="btn btn-default w-100 ">SAVE CHANGES<div class="ripple-container"></div></button></div>
			</div>
			<div class="row m-0 noEffect">
				<div id="closeChanges" class="col-xs-10 col-xs-push-1 text-center"><button class="btn btn-default w-100 ">CLOSE</button></div></div>
			</div>	
				';
   
	}elseif($what == "email address")
    {
		$what = "emailaddress";
        $ownerId = "c".$row['employeeId'];;
        if($row['entityType'] == "branch"){
            $ownerId = "b".$row['branchId'];
        }
        $div = '<table class="w-100">
			<tbody>
			<tr class="separator block"></tr>
											
			<tr>
			<th class="text-left">								
					<h4 class="title">Address ID</h4> 				
			</th>
			<th class="text-center"> 
				<p class="category" id="emailaddressId">'.$row['emailaddressId'].'</p>
			</th>
			</tr>
            
            <tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Email</h4> 		
			</th>
			<th class="text-center"> 
				<input type="text" id="emailFull" class="font-weight-normal text-center w-80" value="'.$row['emailFull'].'"/>
			</th>
			</tr>
            
			<tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Related To</h4> 								
			</th>
			<th class="text-center"> 
            <select id="branchCompanyId" class="font-weight-normal text-center w-80">
            '.str_replace('id="'.$ownerId.'"','id="'.$ownerId.'" selected ',$selectOptions).'
			</select>
			</th>
			</tr>
	
			<tr class="separator block"></tr>
			
			<th class="text-left">								
            <h4 class="title">Type</h4> 		
			</th>
			<th class="text-center"> 
			<input type="text" id="emailType" class="font-weight-normal text-center w-80" value="'.ucfirst($row['emailAddressType']).'"/>
			</th>
			</tr>
            <tr class="separator block"></tr>
			
			<th class="text-left">								
            <h4 class="title">Delete</h4> 		
			</th>
			<th class="text-center"> 
			<select id="delete" class="font-weight-normal text-center w-80">
			  <option value="no">No</option>
			  <option value="yes">Yes</option>
			</select>
			</th>
			</tr>
			</tbody>
			</table>
			<div class="row m-0 m-top-25 noEffect">
				<div id="saveChanges" class="col-xs-10 col-xs-push-1 text-center"><button class="btn btn-default w-100 ">SAVE CHANGES<div class="ripple-container"></div></button></div>
			</div>
			<div class="row m-0 noEffect">
				<div id="closeChanges" class="col-xs-10 col-xs-push-1 text-center"><button class="btn btn-default w-100 ">CLOSE</button></div></div>
			</div>';
   
	}elseif($what == "phone number")
    {
		$what = "phonenumber";
        $ownerId = "c".$row['employeeId'];;
        if($row['entityType'] == "branch"){
            $ownerId = "b".$row['branchId'];
        }
        $div = '<table class="w-100">
			<tbody>
			<tr class="separator block"></tr>
											
			<tr>
			<th class="text-left">								
					<h4 class="title">Unique ID</h4> 				
			</th>
			<th class="text-center"> 
				<p class="category" id="phonenumberId">'.$row['phonenumberId'].'</p>
			</th>
			</tr>
            
            <tr class="separator block"></tr>
			
			<th class="text-left">								
					<h4 class="title">Phone Number</h4> 		
			</th>
			<th class="text-center"> 
				<input type="text" id="phoneNumberFull" class="font-weight-normal text-center w-80" value="'.$row['phoneNumberFull'].'"/>
			</th>
			</tr>
            
			<tr class="separator block"></tr>
										
			<th class="text-left">							
				<h4 class="title">Related To</h4> 								
			</th>
			<th class="text-center"> 
            <select id="branchCompanyId" class="font-weight-normal text-center w-80">
            '.str_replace('id="'.$ownerId.'"','id="'.$ownerId.'" selected ',$selectOptions).'
			</select>
			</th>
			</tr>
	
			<tr class="separator block"></tr>
			
			<th class="text-left">								
            <h4 class="title">Type</h4> 		
			</th>
			<th class="text-center"> 
			<input type="text" id="phoneNumberType" class="font-weight-normal text-center w-80" value="'.ucfirst($row['phoneNumberType']).'"/>
			</th>
			</tr>
            <tr class="separator block"></tr>
			
			<th class="text-left">								
            <h4 class="title">Delete</h4> 		
			</th>
			<th class="text-center"> 
			<select id="delete" class="font-weight-normal text-center w-80">
			  <option value="no">No</option>
			  <option value="yes">Yes</option>
			</select>
			</th>
			</tr>
			</tbody>
			</table>
			<div class="row m-0 m-top-25 noEffect">
				<div id="saveChanges" class="col-xs-10 col-xs-push-1 text-center"><button class="btn btn-default w-100 ">SAVE CHANGES<div class="ripple-container"></div></button></div>
			</div>
			<div class="row m-0 noEffect">
				<div id="closeChanges" class="col-xs-10 col-xs-push-1 text-center"><button class="btn btn-default w-100 ">CLOSE</button></div></div>
			</div>';
   
	}
						
	
	echo($div);	
}else{
	$output = 'Details could not be loaded. Try again later.';
	echo($output);	
}

?>