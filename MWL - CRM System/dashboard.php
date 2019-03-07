<?php
session_start();
if($_SESSION['adminLogged'] !== true){
	header('Location: index.php');
}
$what = "dashboard";
?>
<!DOCTYPE HTML>
<html lang='en-US'>
<head>
	<title>MWL - <?php echo(ucfirst($what));?></title>
	<!-- OTHER -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="description" content="CRM system used to store information about customers.">
	<meta name="keywords" content="MWL exercise">
	<meta name="author" content="Kaloyan Bozhkov">	
	<meta name="robots" content="index, follow">	
	<!-- Google Fonts - Comfortaa  && icons -->
	<link href="https://fonts.googleapis.com/css?family=Comfortaa&amp;subset=cyrillic,cyrillic-ext,greek,latin-ext,vietnamese" rel="stylesheet">
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico"/>
	<!-- CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="stylesheet" href="assets/css/material-dashboard.css" />	
    <link rel="stylesheet" href="assets/templates/prompt/style.css" />
</head>
<body>
<?php
    $extra3 = "";
    $extra2 = "";
    $extra4 = "";
    $extra5 = "";
    $extra6 = "";
    $extra1 = " class='active' ";
    require('assets/php/dashboardContent.php'); 
?>

<!-- MODAL PROMPT -->
<?php require('assets/templates/prompt/prompt.php') ?>

<!-- JS SCRIPT AREA-->
<!-- jQuery -->
<script src="assets/js/jquery.js" type="text/javascript"></script>
<script src="assets/js/generalAjax.js" type="text/javascript"></script>
<script src="assets/js/generalCommands.js" type="text/javascript"></script>

<script src="assets/templates/prompt/functionality.js" type="text/javascript"></script>
<!--  PerfectScrollbar Library -->
<script src="assets/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Material Dashboard javascript methods -->
<script src="assets/js/material-dashboard.js" type="text/javascript"></script>
<script src="assets/js/material.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var smilies = [":)",";)",":}",":P",":D",":L",":S",":I",":O",":]",":[",":(",";(","=(","=)","=]","=["];
        $('#sadFace h1').html(smilies[(Math.floor(Math.random() * smilies.length))-1]);
        $(document).on('click','#sadFace',function(){
		    
		    $('#sadFace h1').html(smilies[(Math.floor(Math.random() * smilies.length))-1]);
		    
		});
		
		$(document).on('click', '.aptOptions .row > div', function(){
			var target = what = classToToggle = returnState = '';
			var mother = $(this).parent().parent().attr('id');	
			var type = mother.split('-')[1];
			//how large div should be
			if(type == "company"){
				classToToggle = 'col-lg-12 col-md-12 col-xs-12';
				returnState = 'col-lg-5 col-md-12 col-xs-12 FFFF';
			}else if(type == "branch" || type == "contact"){
				classToToggle = 'col-lg-12 col-md-12 col-xs-12';
				returnState = 'col-lg-12 col-md-12 col-xs-12';
			}
			var x = $(this).siblings(target);	
			var signs = "#"+ mother +" #"+$(x).siblings('div').attr('id')+" ."+$(x).parent().parent().attr('id') + "-sign";
			var sender = $(this).attr('id');
			var parentSenderCategory = $(this).parent().parent().parent().parent().parent().parent().attr('id');
			if(sender == "details"){
				target = ".targetDetails";
				what = "company";
			}else if(sender == "branches"){
				target = ".target";
				what = "branch";
			}else if(sender == "contacts"){
				target = ".targetContacts";
				what = "contact";
			}else if(sender == "emails"){
				target = ".targetEmails";
				what = "email";
			}else if(sender == "phones"){
				target = ".targetPhones";
				what = "phone";
			}
					
			var id = x.attr('id');
			
			if ($(x).css('display') !== "block") {
				
				$(x).siblings('div').addClass('holded');
				$(signs).addClass('rotate-180');
				$(x).parent().parent().parent().parent().attr('class', classToToggle);
				fetchX(id, what, target, parentSenderCategory); //Get company branch details.
			} else {
				
				 window.closeListingMenu(x, signs, returnState);
			
			}
		});
		
		
		
		function fetchX(id, what, x, sender){//sender = static category (companies, branches, contacts), x = targt/targetDetails (category rows), what = company/branch/contact, dynamic (rows)
			var idWhat = $('#'+id+x).parent().parent().attr('id').split('-');
			if(id == idWhat[0]){
				$.ajax({
					type: "POST",
					url: 'assets/php/dashboardContentFetch.php',
					data: {id: id, what: what, sender:sender},
					success: function(f) {
						$("#"+ sender + " "+ x +" #target-"+ id).empty().append(f).parent().slideDown(500);
					
					}
				});	
			
			}else{
				showMsg('Oops!', 'Something went wrong! :(', 'ok', 'failure');
			}

			
		}

		$(document).on('click', '.titleTop', function(){
		    var category = '#'+ $(this).parent().attr('id');
			$(category + ' > .cont').slideToggle();
			if($(category + ' .titleTop .rotate-180').length == 0){
				$(category + ' .titleTop .glyphicon').addClass('rotate-180');
			}else{
				$(category + ' .titleTop .glyphicon').removeClass('rotate-180');
			};
		});
		
		$(document).on('click', '#saveChanges', function(){
			var companyDetails = [
				$('#companyId').html().toString().trim(),
				window.toTitleCase($('#companyName').val().toString().toLowerCase().trim()).replace("'","''"),
				$('#companyType').val().toString().trim(),
				$('#companyDescription').val().toString().trim().replace("'","''").replace(/\r\n|\r|\n/g,"<br />"), //transform breaks from enter to <br/>
				$('#companyVisibility').val().toString().trim(),
				$('#delete').val().toString().trim()
			];
			
			var detailNames = [
				$('#companyId').parent().siblings('th').children().html().toString().trim(),
				$('#companyName').parent().siblings('th').children().html().toString().trim(),
				$('#companyType').parent().siblings('th').children().html().toString().trim(),
				$('#companyDescription').parent().parent().siblings('th').children().html().toString().trim(), //extra parent for v centering
				$('#companyVisibility').parent().siblings('th').children().html().toString().trim()				
			];
			
			window.checkFields(companyDetails, detailNames, "<?php echo($what); ?>");
			
		});

		$(document).on('click', '#aptListing tr', function(){
			var id = $(this).attr('id');
			$('#aptListingsDetails').empty().append('<div class="parent w-100 text-center tmpLoading"><div class="child "><h4 class="title zoomed-out-very-tiny transition-0-5">Loading..</h4></div></div>');	
			var x = $(this);
			$('#aptListingsDetails').slideUp(400, function(){
				window.getInfo(id, '<?php echo($what); ?>', '#aptListingsDetails');	
				$('.aptDetailsHeader').html('Title is loading..');
				$('#aptListingsDetails').delay(400).slideDown(300, function(){
					
					$('.aptDetailsHeader').html(x.find('.title').html());
					
				});
				
			});							

		});	
		
		
		$(document).on('click', '#addApt', function(){
			window.location = "companies.php";
		});
		

		$(document).on('change keypress keyup keydown', '.numericInput', function(){
			
			$(this).val($(this).val().replace(/[^0-9.]/g, ""));
			
		});
		

    });


</script>
</body>
</html>