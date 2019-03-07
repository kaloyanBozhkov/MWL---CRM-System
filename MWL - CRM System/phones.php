<?php
session_start();
if($_SESSION['adminLogged'] !== true){
	header('Location: index.php');
}
$what = "phone number";
?>
<!DOCTYPE HTML>
<html lang='en-US'>
<head>
	<title>MWL - <?php echo(ucwords($what));?> Listings</title>
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
    $extra1 = "";
    $extra2 = "";
    $extra3 = "";
    $extra4 = "";
    $extra5 = "";
    $extra6= " class='active' ";
    require('assets/php/content.php'); 
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
<!-- Load Company Names and ID's -->
<?php 
    require('assets/php/fetchEmployeeBranchIdAndName.php');
?>
$(document).ready(function() {
if($('#cCHecker').length == 1){
    $('#addApt').attr('disabled','true');
    $('#addApt').parent().find('p').html('Cannot add a <?php echo($what); ?> without a branch.');
}
    $(document).on('click', '#closeChanges', function(){
        window.closeChanges($(this).parent().parent(), "<?php echo($what); ?>");
    });

    $(document).on('click', '#saveChanges', function(){
        var details = [
            $('#phonenumberId').html().toString().trim(),
            $('#phoneNumberFull').val().toString().trim(),
            $('#branchCompanyId option:selected').attr('id').toString().trim(),             
            $('#phoneNumberType').val().toString().trim(),
            $('#delete').val().toString().trim()
        ];

        var detailNames = [
            $('#phonenumberId').parent().siblings('th').children().html().toString().trim(),
            $('#phoneNumberFull').parent().siblings('th').children().html().toString().trim(), 
            $('#branchCompanyId').parent().siblings('th').children().html().toString().trim(),
            $('#phoneNumberType').parent().siblings('th').children().html().toString().trim(),
            
        ];
        window.checkFields(details, detailNames, '<?php echo($what); ?>');

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

        var div = "<select id='companySelectId'>"+window.BRANCHES_ID_NAMES+ "</select>";

        window.showMsg("Select a branch or company", "You must select one of the following branches or contacts in order to add a new email address to it:<br/>" + div, "addcancel", "success");
        
        
    });
    
    $(document).on('click', '#alert #add', function(){
        window.insertNewX('<?php echo($what); ?>', $('#companySelectId option:selected').attr('id'),'Y');
    });

    $(document).on('change keypress keyup keydown', '.numericInput', function(){

        $(this).val($(this).val().replace(/[^0-9.]/g, ""));

    });

    
});


</script>
</body>
</html>