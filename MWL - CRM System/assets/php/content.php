<?php require('assets/php/header.php'); ?>

            <div class="content">
                <div class="container-fluid">
					 <div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="card">
								<div class="card-header">
									<h4 class="title text-center" id="aptName">Select <?php echo(ucwords($what));?></h4>
								</div>
								<div class="card-content">
									<table id="aptListing" class="w-100">
									<tbody>
										 <?php 
										 require('assets/php/listUpdate.php');	?>						
									</tbody>
									</table>
									
									
									
									
								</div>
								
							</div>
							 <div class="row text-center">
								  <button type="button" class="btn btn-default btn-circle btn-xl zoomed-out-tiny transition-0-5" id="addApt">
									<i class="glyphicon glyphicon-plus" style="font-size:25px;"></i>
								  </button>
								  <p>Add  <?php echo($what);?></p>
							 </div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div id="detailsSection" class="card">
								<div class="card-header">
									<h4 class="title text-center aptDetailsHeader" id="aptName"> <?php echo(ucwords($what));?> Details</h4>
								</div>
								
								<div id="aptListingsDetails" class="card-content">
									
								<div style="margin-top:15px" class="parent w-100 text-center"><div class="child "><h4 class="title zoomed-out-very-tiny transition-0-5">Select a <?php echo($what);?> to proceed.</h4></div></div><!-- Also check  for text change generalCommands > Close -->	
										<!-- LOAD SEQUENCE -->		
																				
									
								</div>
							</div>
						</div>
					 </div>

					
                </div>
            </div>
    <?php require('footer.php'); ?>
        </div>
    </div>