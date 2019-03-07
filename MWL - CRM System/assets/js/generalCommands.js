function closeChanges(element, what){
	$(element).slideUp(500, function(){		
			$(this).empty().html('<div style="margin-top:15px" class="parent w-100 text-center"><div class="child "><h4 class="title zoomed-out-very-tiny transition-0-5">Select a '+what+' to proceed.</h4></div></div>	');
			$(element).slideDown(400);
	});
	$('.aptDetailsHeader').html(toTitleCase(what) + ' Details');
}


function closeListingMenu(x, signs, returnState){
	$(x).siblings('.holded').removeClass('holded');
	$(signs).removeClass('rotate-180');
	$(x).slideUp(500, function(){
		$(x).children('.row').empty();	
		if($(x).parent().parent().find('.holded').length == 0){
			$(x).parent().parent().parent().parent().attr('class', returnState);
		}
	});
	
}

//Handle search bar

var temp = window.location.href;
var count = (temp.match(/id=/g) || []).length;
if(count != 0){
	$('#searchBox').val(temp.split('?q=')[1]);		
}
$(document).on('click', '#searchBoxBtn', function(e){
	e.preventDefault();
	var type = $(this).siblings('.hidden').attr('id');
	var value = $('#searchBox').val().trim();
	if(value){
		window.location.href = 'dashboard.php?q=' + value +'&type='+type;
	}else{
		window.showMsg('Oops!', 'You have not typed anything! <br/>  <br/> Please type something before trying to search again, fool!', "ok", "failure");
	}
	
			
});

$(document).on('click', '#btnLogout', function(){
	window.logout();		
});



$(document).on('click', '.updateComplete #ok', function(){
	$('#alert').removeClass('updateComplete').hide();			
});

//Handle strings

function toTitleCase(str) {
	return str.replace(/(?:^|\s)\w/g, function(match) {
		return match.toUpperCase();
	});
}
//Handle field checks
function checkFields(details, names, what){
	var fieldsWrong = "";
	var countErrors = 0;
	var pluralSingular = "value is";
	$.each(details, function(i, value){	
		if(!value || (names[i] && names[i].toString().toLowerCase().trim() == "email" && !validateEmail(value))){
			countErrors++;
			fieldsWrong += " <b>" + names[i] + "</b> <br/>";
		}
	});
	
	if(countErrors > 1){
		pluralSingular = "values are";
	}
	
	if(countErrors > 0){
		window.showMsg("Oops! Something went wrong.", "The following "+ pluralSingular +" not acceptable:<br/>" + fieldsWrong + "<br/>Try editing them, and after doing so you can try saving again!" , "ok", "failure");
	}else{
		//update fields db
		window.setInfo("1",what, details);			
	}
}
//validate email

function validateEmail(emailAddress){
	if(emailAddress.match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
		return false;
	}else{
		return true;
	}
}