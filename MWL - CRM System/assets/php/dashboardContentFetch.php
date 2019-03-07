<?php
require('mySqlConnect.php');
$id = mysqli_real_escape_string($link, $_POST['id']); //sender ID
$what = mysqli_real_escape_string($link, $_POST['what']); //sender typebranch..)
$sender = mysqli_real_escape_string($link, $_POST['sender']);

$sql = $output = $ending = "";

if($sender == "companies"){
    $ending = " companies.companyId = '".$id."' ;";
    
}elseif($sender == "branches"){
    $ending = " branches.branchId = '".$id."' ;";
    if($what == "email"){
        $ending = "branch";
        	$sql = "SELECT emailaddresses.* FROM `branches`,`emailaddresses`,`companies` WHERE companies.administratorId = " . $_SESSION['adminDetails']->id ." AND companies.companyId = branches.companyId AND branches.branchId = emailaddresses.branchId AND branches.branchId = '".$id."';";
    }elseif($what == "phone"){
          $ending = "branch";
        	$sql = "SELECT phonenumbers.* FROM `branches`,`phonenumbers`,`companies` WHERE companies.administratorId = " . $_SESSION['adminDetails']->id ." AND companies.companyId = branches.companyId AND branches.branchId = phonenumbers.branchId AND branches.branchId = '".$id."';";
    }
}elseif($sender == "contacts"){
    $ending = " employees.employeeId = '".$id."';";
    if($what == "branch"){
         $ending = " branches.branchId = membership.branchId AND membership.employeeId = '".$id."';";
    }elseif($what == "email"){
          $ending = "contact";
        	$sql = "SELECT emailaddresses.* FROM `employees`,`emailaddresses`,`membership`,`branches`,`companies` WHERE companies.administratorId = " . $_SESSION['adminDetails']->id ." AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND emailaddresses.employeeId = employees.employeeId AND employees.employeeId = '".$id."';";
    }elseif($what == "phone"){
          $ending = "contact";
        	$sql = "SELECT phonenumbers.* FROM `employees`,`phonenumbers`,`membership`,`branches`,`companies` WHERE companies.administratorId = " . $_SESSION['adminDetails']->id ." AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND phonenumbers.employeeId = employees.employeeId AND employees.employeeId = '".$id."';";
    }
}

if($what == "branch"){		
	$sql = "SELECT DISTINCT branches.* FROM `companies`, `branches`,`membership` WHERE companies.administratorId = " . $_SESSION['adminDetails']->id ." AND companies.companyId = branches.companyId AND ".$ending;

	$result = mysqli_query($link, $sql);
	$number = mysqli_num_rows($result);
	if($number !== 0){
		$table = "<div class='col-xs-12 overflow-x-scroll padding-0'>
						<table class='displayResult'>
							<tr>
								<th>Branch ID</th>						
								<th>Branch Name</th>
								<th>Description</th>
								<th>Country</th>
								<th>City</th>
								<th>Postcode</th>
								<th>Address</th>
								<th>Number</th>
								<th>Floor</th>
								<th>Visibility</th>
							</tr>
							?CONTENTHERE?
						</table>				
					</div>";
		$div = "";
		$x = false;
		$color = "";
		while($row = mysqli_fetch_array($result)){
			if(!$x){$x = true; $color = "class='tBgColor'";}else{$x = false; $color = "";};
			
			$div .= "<tr ".$color.">
			<td>".$row['branchId']."</td>
			<td>".$row['branchName']."</td>
			<td>".$row['description']."</td>
			<td>".$row['country']."</td>
			<td>".$row['city']."</td>
			<td>".$row['postcode']."</td>
			<td>".$row['address']."</td>
			<td>".$row['number']."</td>
			<td>".$row['floor']."</td>
			<td>".$row['visibility']."</td>
			
			</tr>";
		}
		$output = str_replace('?CONTENTHERE?',$div, $table);
	}else{
		$output = "<p>No branches added to this company yet.</p>";
	}

}elseif($what == "company"){
	$sql = "SELECT companies.* FROM `companies` WHERE companies.administratorId = " . $_SESSION['adminDetails']->id ." AND ".$ending;
	$result = mysqli_query($link, $sql);
	$number = mysqli_num_rows($result);
	if($number !== 0){
		$table = "<div class='col-xs-12 overflow-x-scroll padding-0'>
						<table class='displayResult'>
							<tr>
								<th>Company Id</th>						
								<th>Company Name</th>
								<th>Type</th>
								<th>Description</th>
								<th>Visibility</th>
							</tr>
							?CONTENTHERE?
						</table>				
					</div>";
		$div = "";
		$x = false;
		$color = "";
		while($row = mysqli_fetch_array($result)){
			if(!$x){$x = true; $color = "class='tBgColor'";}else{$x = false; $color = "";};
			
			$div .= "<tr ".$color.">
			<td>".$row['companyId']."</td>
			<td>".$row['companyName']."</td>
			<td>".$row['type']."</td>
			<td>".$row['description']."</td>
			<td>".$row['visibility']."</td>			
			</tr>";
		}
		$output = str_replace('?CONTENTHERE?',$div, $table);
	}else{
		$output = "<p>There has been an issue, oops!</p>";
	}
}elseif($what == "contact"){
	$sql = "SELECT employees.* FROM `companies`,`branches`,`employees`,`membership` WHERE companies.administratorId = " . $_SESSION['adminDetails']->id ." AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND ".$ending;
	$result = mysqli_query($link, $sql);
	$number = mysqli_num_rows($result);
	if($number !== 0){
		$table = "<div class='col-xs-12 overflow-x-scroll padding-0'>
						<table class='displayResult'>
							<tr>
								<th>Employee Id</th>						
								<th>First Name</th>
								<th>Last Name</th>
								<th>Details</th>
								<th>Sex</th>
								<th>Agee</th>
								<th>Visibility</th>
							</tr>
							?CONTENTHERE?
						</table>				
					</div>";
		$div = "";
		$x = false;
		$color = "";
		while($row = mysqli_fetch_array($result)){
			if(!$x){$x = true; $color = "class='tBgColor'";}else{$x = false; $color = "";};
			
			$div .= "<tr ".$color.">
			<td>".$row['employeeId']."</td>
			<td>".$row['firstName']."</td>
			<td>".$row['lastName']."</td>
			<td>".$row['details']."</td>
			<td>".$row['sex']."</td>	
			<td>".$row['age']."</td>
			<td>".$row['visibility']."</td>			
			</tr>";
		}
		$output = str_replace('?CONTENTHERE?',$div, $table);
	}else{
		$output = "<p>No contacts added to this branch yet.</p>";
	}    

}elseif($what == "email"){

	$result = mysqli_query($link, $sql);
	$number = mysqli_num_rows($result);
	if($number !== 0){
		$table = "<div class='col-xs-12 overflow-x-scroll padding-0'>
						<table class='displayResult'>
							<tr>
								<th>Emal Address Id</th>						
								<th>Email</th>
								<th>Address Type</th>
							</tr>
							?CONTENTHERE?
						</table>				
					</div>";
		$div = "";
		$x = false;
		$color = "";
		while($row = mysqli_fetch_array($result)){
			if(!$x){$x = true; $color = "class='tBgColor'";}else{$x = false; $color = "";};
			
			$div .= "<tr ".$color.">
        	<td>".$row['emailaddressId']."</td>
			<td>".$row['emailFull']."</td>
			<td>".$row['emailAddressType']."</td>		
			</tr>";
		}
		$output = str_replace('?CONTENTHERE?',$div, $table);
	}else{
		$output = "<p>No email address added to this ".$ending." yet.</p>";
	}    

}elseif($what == "phone"){

	$result = mysqli_query($link, $sql);
	$number = mysqli_num_rows($result);
	if($number !== 0){
		$table = "<div class='col-xs-12 overflow-x-scroll padding-0'>
						<table class='displayResult'>
							<tr>
								<th>Id</th>						
								<th>Phone Number</th>
								<th>Type</th>
							</tr>
							?CONTENTHERE?
						</table>				
					</div>";
		$div = "";
		$x = false;
		$color = "";
		while($row = mysqli_fetch_array($result)){
			if(!$x){$x = true; $color = "class='tBgColor'";}else{$x = false; $color = "";};
			
			$div .= "<tr ".$color.">
        	<td>".$row['phonenumberId']."</td>
			<td>".$row['phoneNumberFull']."</td>
			<td>".$row['phoneNumberType']."</td>		
			</tr>";
		}
		$output = str_replace('?CONTENTHERE?',$div, $table);
	}else{
		$output = "<p>No phone number added to this ".$ending." yet.</p>";
	}    

}



echo($output);


	
		
	

?>