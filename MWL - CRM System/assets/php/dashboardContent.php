<?php require('assets/php/header.php'); ?>
 <div class="content">
                <div class="container-fluid">
					 <?php 					
						require('assets/php/mySqlConnect.php');
				            
				         $query = $type = $companyDiv = $branchDiv = $contactDiv = "";
						if (isset($_GET['q']) && isset($_GET['type'])){
							$query = mysqli_real_escape_string($link, $_GET['q']);
							$type = $_GET['type'];
							$searchFields = array();
							if($type == "c"){
									    $sql = 'SELECT companies.companyId as "id", companies.companyName as "title", "Company" as "origin", "company" as "type"  FROM `companies` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.visibility = "1" AND (companies.companyName LIKE "%'.$query.'%" OR companies.type LIKE "%'.$query.'%" OR companies.description LIKE "%'.$query.'%" OR companies.companyId = "'.$query.'")';
									    
								}elseif($type == "b"){
									 $sql = 'SELECT branches.branchId as "id", branches.branchName as "title", companies.companyName as "origin", "branch" as "type"  FROM `branches`, `companies` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND companies.visibility = "1" AND branches.visibility = "1" AND (branches.branchName LIKE "%'.$query.'%" OR branches.description LIKE "%'.$query.'%" OR branches.country LIKE "%'.$query.'%" OR branches.city LIKE "%'.$query.'%" OR branches.postcode LIKE "%'.$query.'%" OR branches.address LIKE "%'.$query.'%" OR branches.branchId = "'.$query.'")';
									 
								}elseif($type == "e"){
									$sql = 'SELECT employees.employeeId as "id", employees.fullname as "title", CONCAT(branches.branchName," - ",companies.companyName) as "origin", "contact" as "type"  FROM `companies`, `branches`,`membership`,`employees` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND (
									    employees.employeeId = "'.$query.'" OR employees.fullName LIKE "%'.$query.'%" OR employees.sex LIKE "'.$query.'" OR employees.details  LIKE "%'.$query.'%");';
								}elseif($type == "ea"){
									$sql = '(SELECT DISTINCT branches.branchId as "id", branches.branchName as "title", companies.companyName as "origin", "branch" as "type"  FROM `branches`, `companies`,`emailaddresses` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND companies.visibility = "1" AND branches.visibility = "1" AND emailaddresses.branchId = branches.branchId AND (emailaddresses.emailFull LIKE "%'.$query.'%" OR emailaddresses.emailAddressType LIKE "%'.$query.'%"  OR branches.branchName LIKE "%'.$query.'%" )) UNION ALL (SELECT DISTINCT employees.employeeId as "id", employees.fullname as "title", CONCAT(branches.branchName," - ",companies.companyName) as "origin", "contact" as "type"  FROM `companies`, `branches`,`membership`,`employees`,`emailaddresses` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND employees.employeeId = emailaddresses.employeeId AND (
									    emailaddresses.emailFull LIKE "%'.$query.'%" OR emailaddresses.emailAddressType LIKE "%'.$query.'%" OR employees.fullName LIKE "%'.$query.'%"));';
								}elseif($type == "ph"){
									$sql = '(SELECT DISTINCT branches.branchId as "id", branches.branchName as "title", companies.companyName as "origin", "branch" as "type"  FROM `branches`, `companies`,`phonenumbers` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND companies.visibility = "1" AND branches.visibility = "1" AND phonenumbers.branchId = branches.branchId AND (phonenumbers.phoneNumberFull LIKE "%'.$query.'%" OR phonenumbers.phoneNumberType LIKE "%'.$query.'%" OR branches.branchName LIKE "%'.$query.'%" )) UNION ALL (SELECT DISTINCT employees.employeeId as "id", employees.fullname as "title", CONCAT(branches.branchName," - ",companies.companyName) as "origin", "contact" as "type"  FROM `companies`, `branches`,`membership`,`employees`,`phonenumbers` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND employees.employeeId = phonenumbers.employeeId AND (
									    phonenumbers.phoneNumberFull LIKE "%'.$query.'%" OR phonenumbers.phoneNumberType LIKE "%'.$query.'%" OR employees.fullName LIKE "%'.$query.'%" ));';
								}elseif($type == "d"){
								   $sql = '(SELECT DISTINCT companies.companyId as "id", companies.companyName as "title", "Company" as "origin", "company" as "type"  FROM `companies` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.visibility = "1" AND (companies.companyName LIKE "%'.$query.'%" OR companies.type LIKE "%'.$query.'%" OR companies.description LIKE "%'.$query.'%" OR companies.companyId = "'.$query.'"))
								   UNION ALL
								        (SELECT DISTINCT branches.branchId as "id", branches.branchName as "title", companies.companyName as "origin", "branch" as "type"  FROM `branches`, `companies` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND companies.visibility = "1" AND branches.visibility = "1" AND (branches.branchName LIKE "%'.$query.'%" OR branches.description LIKE "%'.$query.'%" OR branches.country LIKE "%'.$query.'%" OR branches.city LIKE "%'.$query.'%" OR branches.postcode LIKE "%'.$query.'%" OR branches.address LIKE "%'.$query.'%" OR branches.branchId = "'.$query.'"))
							        UNION ALL
								        (SELECT employees.employeeId as "id", employees.fullname as "title", CONCAT(branches.branchName," - ",companies.companyName) as "origin", "contact" as "type"  FROM `companies`, `branches`,`membership`,`employees` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND (
									    employees.employeeId = "'.$query.'" OR employees.fullName LIKE "%'.$query.'%" OR employees.sex LIKE "'.$query.'" OR employees.details  LIKE "%'.$query.'%"))
								    UNION
								    (SELECT DISTINCT branches.branchId as "id", branches.branchName as "title", companies.companyName as "origin", "branch" as "type"  FROM `branches`, `companies`,`emailaddresses` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND companies.visibility = "1" AND branches.visibility = "1" AND emailaddresses.branchId = branches.branchId AND (emailaddresses.emailFull LIKE "%'.$query.'%" OR emailaddresses.emailAddressType LIKE "%'.$query.'%"  OR branches.branchName LIKE "%'.$query.'%" )) UNION ALL (SELECT DISTINCT employees.employeeId as "id", employees.fullname as "title", CONCAT(branches.branchName," - ",companies.companyName) as "origin", "contact" as "type"  FROM `companies`, `branches`,`membership`,`employees`,`emailaddresses` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND employees.employeeId = emailaddresses.employeeId AND (
									    emailaddresses.emailFull LIKE "%'.$query.'%" OR emailaddresses.emailAddressType LIKE "%'.$query.'%" OR employees.fullName LIKE "%'.$query.'%"))
									    UNION 
									    (SELECT DISTINCT branches.branchId as "id", branches.branchName as "title", companies.companyName as "origin", "branch" as "type"  FROM `branches`, `companies`,`phonenumbers` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND companies.visibility = "1" AND branches.visibility = "1" AND phonenumbers.branchId = branches.branchId AND (phonenumbers.phoneNumberFull LIKE "%'.$query.'%" OR phonenumbers.phoneNumberType LIKE "%'.$query.'%" OR branches.branchName LIKE "%'.$query.'%" )) UNION ALL (SELECT DISTINCT employees.employeeId as "id", employees.fullname as "title", CONCAT(branches.branchName," - ",companies.companyName) as "origin", "contact" as "type"  FROM `companies`, `branches`,`membership`,`employees`,`phonenumbers` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND employees.employeeId = phonenumbers.employeeId AND (
									    phonenumbers.phoneNumberFull LIKE "%'.$query.'%" OR phonenumbers.phoneNumberType LIKE "%'.$query.'%" OR employees.fullName LIKE "%'.$query.'%" ))
									    ';
								}
							
						}else{
						    	$sql = 'SELECT companies.companyId as "id", companies.companyName as "title", "Company" as "origin", "company" as "type"  FROM `companies` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.visibility = "1"
						UNION ALL 
						SELECT branches.branchId as "id", branches.branchName as "title", companies.companyName as "origin", "branch" as "type"  FROM `branches`, `companies` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND companies.visibility = "1" AND branches.visibility = "1"
						UNION ALL 
						SELECT employees.employeeId as "id", employees.fullname as "title", CONCAT(branches.branchName," - ",companies.companyName) as "origin", "contact" as "type"  FROM `companies`, `branches`,`membership`,`employees` WHERE companies.administratorId = "'.($_SESSION['adminDetails']->id).'" AND companies.companyId = branches.companyId AND branches.branchId = membership.branchId AND membership.employeeId = employees.employeeId AND companies.visibility = "1" AND branches.visibility = "1" AND employees.visibility = "1";';
				
						}
					
                        $recordsReturned = array(0,0,0); 
						$result = mysqli_query($link, $sql);
						$number = mysqli_num_rows($result);
						if ($number != 0) {
							$div = "<!-- Start Listing Everything-->";
							$runatstart = $executedOnce = $executedOnceBranch = false;
							while ($row = mysqli_fetch_array($result)) {
							
							if($row['type'] == "company"){
							    $recordsReturned[0]++;
							    $size = "col-lg-5 col-md-12 col-xs-12 FFFF";
								$miniLogo = '<span class="glyphicon glyphicon-list-alt inline-block"></span>';
								$content = '
								<div class="row">
													<div id="details" class="col-xs-12">
														<p class="text-center"><i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:left;line-height:20px"></i> Company Details <i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:right;line-height:20px"></i></p>										
													</div>
													<div id="'.$row['id'].'" class="col-xs-12 text-center w-100 targetDetails padding-0 margin--" style="display:none">
														<div id="target-'.$row['id'].'" class="row">
													
														</div>
													</div>										
													
											</div>
								<div class="row">
													<div  id="branches" class="col-xs-12">
														<p class="text-center"><i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:left;line-height:20px"></i> Branches List <i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:right;line-height:20px"></i></p>										
													</div>
													<div id="'.$row['id'].'" class="col-xs-12 text-center w-100 target padding-0" style="display:none">
														<div  id="target-'.$row['id'].'" class="row">
													
														</div>
													</div>										
													
											</div>';
								$companyDiv .= '
									<div class="'.$size.'">
										<div class="card"><div class="card-header">
											<h4 class="title" id="aptName">'.$miniLogo.' '.$row['title'].'</h4>
												<p class="category" id="aptAddress">'.$row['origin'].'</p>
											</div>
											<div id="'.$row['id'].'-'.$row['type'].'" class="card-content aptOptions">
												'.$content.'
											</div>
										</div>
									</div>
								';
							}elseif($row['type'] == "branch"){
							    $recordsReturned[1]++;
								$size = "col-lg-12 col-md-12";
								$miniLogo = '<span class="glyphicon glyphicon-folder-close inline-block"></span>';
								$content =  '
								<div class="row">
													<div id="branches" class="col-xs-12">
														<p class="text-center"><i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:left;line-height:20px"></i> Branch Details <i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:right;line-height:20px"></i></p>										
													</div>
													<div id="'.$row['id'].'" class="col-xs-12 text-center w-100 target padding-0 margin--" style="display:none">
														<div  id="target-'.$row['id'].'" class="row">
													
														</div>
													</div>										
													
											</div>
								<div class="row">
													<div  id="contacts" class="col-xs-12">
														<p class="text-center"><i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:left;line-height:20px"></i> Contacts List <i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:right;line-height:20px"></i></p>										
													</div>
													<div id="'.$row['id'].'" class="col-xs-12 text-center w-100 targetContacts padding-0" style="display:none">
														<div  id="target-'.$row['id'].'" class="row">
													
														</div>
													</div>										
													
											</div>
							    <div class="row">
													<div  id="emails" class="col-xs-12">
														<p class="text-center"><i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:left;line-height:20px"></i> Email Addresses <i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:right;line-height:20px"></i></p>										
													</div>
													<div id="'.$row['id'].'" class="col-xs-12 text-center w-100 targetEmails padding-0" style="display:none">
														<div  id="target-'.$row['id'].'" class="row">
													    
														</div>
													</div>										
													
											</div>			
								<div class="row">
													<div  id="phones" class="col-xs-12">
														<p class="text-center"><i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:left;line-height:20px"></i> Phone Numbers <i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:right;line-height:20px"></i></p>										
													</div>
													<div id="'.$row['id'].'" class="col-xs-12 text-center w-100 targetPhones padding-0" style="display:none">
														<div  id="target-'.$row['id'].'" class="row">
													    
														</div>
													</div>										
													
											</div>			
											
											';
								$branchDiv .= '
									<div class="'.$size.'">
										<div class="card"><div class="card-header">
											<h4 class="title" id="aptName">'.$miniLogo.' '.$row['title'].'</h4>
												<p class="category" id="aptAddress">'.$row['origin'].'</p>
											</div>
											<div id="'.$row['id'].'-'.$row['type'].'" class="card-content aptOptions">
												'.$content.'
											</div>
										</div>
									</div>
								';
								
								
								
								
								
							}elseif($row['type'] == "contact"){
							    $recordsReturned[2]++;
							    $size = "col-lg-12 col-md-12";
								$miniLogo = '<span class="glyphicon glyphicon-user inline-block"></span>';
								$content =  '
								<div class="row">
													<div id="contacts" class="col-xs-12">
														<p class="text-center"><i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:left;line-height:20px"></i> Contact Details <i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:right;line-height:20px"></i></p>										
													</div>
													<div id="'.$row['id'].'" class="col-xs-12 text-center w-100 targetContacts padding-0 margin--" style="display:none">
														<div  id="target-'.$row['id'].'" class="row">
													
														</div>
													</div>										
													
											</div>
								<div class="row">
													<div  id="branches" class="col-xs-12">
														<p class="text-center"><i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:left;line-height:20px"></i> Branch Details <i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:right;line-height:20px"></i></p>										
													</div>
													<div id="'.$row['id'].'" class="col-xs-12 text-center w-100 target padding-0" style="display:none">
														<div  id="target-'.$row['id'].'" class="row">
													
														</div>
													</div>										
													
											</div>
											<div class="row">
													<div  id="emails" class="col-xs-12">
														<p class="text-center"><i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:left;line-height:20px"></i> Email Addresses <i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:right;line-height:20px"></i></p>										
													</div>
													<div id="'.$row['id'].'" class="col-xs-12 text-center w-100 targetEmails padding-0" style="display:none">
														<div  id="target-'.$row['id'].'" class="row">
													    
														</div>
													</div>										
													
											</div>
												<div class="row">
													<div  id="phones" class="col-xs-12">
														<p class="text-center"><i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:left;line-height:20px"></i> Phone Numbers <i class="glyphicon glyphicon-menu-up '.$row['id'].'-'.$row['type'].'-sign" style="font-size:10px;float:right;line-height:20px"></i></p>										
													</div>
													<div id="'.$row['id'].'" class="col-xs-12 text-center w-100 targetPhones padding-0" style="display:none">
														<div  id="target-'.$row['id'].'" class="row">
													    
														</div>
													</div>										
													
											</div>
											';
								$contactDiv .= '
									<div class="'.$size.'">
										<div class="card"><div class="card-header">
											<h4 class="title" id="aptName">'.$miniLogo.' '.$row['title'].'</h4>
												<p class="category" id="aptAddress">'.$row['origin'].'</p>
											</div>
											<div id="'.$row['id'].'-'.$row['type'].'" class="card-content aptOptions">
												'.$content.'
											</div>
										</div>
									</div>
								';
							}

							}
    						$one = $two = $three = "";
    						
    						if($recordsReturned[0] >= 1){
						    	$companyOpening = "<div id='companies' class='row text-center'><h3 class='text-left titleTop'>Companies <i class='glyphicon glyphicon-menu-up' style='vertical-align:middle;font-size:15px;'></i></h3><div class='cont'>";
							
					        	$one .= $companyOpening.$companyDiv."</div></div>"; 
    						
    						}
    						
    						if($recordsReturned[1] >= 1){
						    	$branchOpening = "<div id='branches' class='row text-center'><h3 class='text-left titleTop'>Branches <i class='glyphicon glyphicon-menu-up' style='vertical-align:middle;font-size:15px;'></i></h3><div class='cont'>";
    								
    					    	$two .= $branchOpening.$branchDiv."</div></div>"; 
    						}
    						if($recordsReturned[2] >= 1){
						    	$contactOpening = "<div id='contacts' class='row text-center'><h3 class='text-left titleTop'>Contacts <i class='glyphicon glyphicon-menu-up' style='vertical-align:middle;font-size:15px;'></i></h3><div class='cont'>";
    							  
    					    	$three .= $contactOpening.$contactDiv."</div></div>"; 
    						}
    							     
    						$outputTime = $one.$two.$three;
    						echo($outputTime);
						}else{
						if(isset($query) && isset($type) && $query !== "" && $type !== ""){
						      $endMsg = '<div class="row text-center"><div id="sadFace" ><h1>:(</h1></div><p>No companies, brnaches, contacts, email addresses or phone numbers were found for your search attempt.</p></div>';
						}else{
						  //button						
							$endButtonCompany = '<div class="row text-center">
								<button type="button" class="btn btn-default btn-circle btn-xl zoomed-out-tiny transition-all-0-5" id="addApt">
									<i class="glyphicon glyphicon-list-alt" style="font-size:25px;"></i>
								</button>
								<p>Company Listings</p>
							 </div>';
						    $endMsg = '<div class="row text-center"><div id="sadFace" class="col-xs-12" ><h1>:(</h1></div><p>No companies, brnaches or contacts to display at the moment, add some first.</p></div>'.$endButtonCompany;
						    
						}							
						
							echo($endMsg);
						}
						
					 ?>

                </div>
            </div>
            <?php require('footer.php');  ?>
            