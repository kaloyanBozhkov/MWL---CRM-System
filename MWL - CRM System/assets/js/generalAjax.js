function updateList(what, title, content){	
	$.ajax({
		type: "POST",
		url: 'assets/php/listUpdate.php',
		data: {what: what},
		success: function(f) {
			$('#aptListing').parent().slideUp(400, function(){		
			$('#aptListing').siblings('p').remove();
				$('#aptListing tbody').html('').append(f);
				$('#aptListing').parent().slideDown(300, function(){		
					window.showMsg(title, content, 'ok', 'success');
				});
			});				
		}
	});	

}

function insertNewX(what, optional){
	$.ajax({
		type: "POST",
		url: 'assets/php/insertNewX.php',
		data: {what: what, optional:optional},
		success: function(f) {
			$('#alert #ok').addClass('addAptDone');
			//console.log(f);
			if(f){
			window.updateList(what, 'Operation Complete!', 'A new '+what+' has been added successfully!');			
			closeChanges($('#closeChanges').parent().parent(), what);
			}else{
				window.showMsg('Operation Failed!', 'The new '+what+' could not be added at this moment. <br/>Please try again at another time.', 'ok', 'failure');
			}
		}
	});			
}


//id of company/branch/person to edit, what indicates if it's a person, branch or company, details has all field inputs
function setInfo(id, what, details){
	$.ajax({
		type: "POST",
		url: 'assets/php/setDetail.php',
		data: {id: id, what: what, value: JSON.stringify(details)},				
		success: function(f) {
		if(f){
			$('#alert').addClass('updateComplete');
			window.updateList(what, 'Yay! Operation Completed Neatly!', 'The '+what+' was updated successfully!');			
			closeChanges($('#closeChanges').parent().parent(), what);					
		}else{
			
			window.showMsg("Oops! Something went wrong.", "Ther was a problem with completing the request. Please try again later." , "ok", "failure");
		}
		}
	});	
}

//ajax load x(company,branch,contact) list	
function getInfo(id, what, where){
	$.ajax({
		type: "POST",
		url: 'assets/php/showDetail.php',
		data: {id: id, what: what, where:where},
		success: function(f) {
			$(where).empty().append(f.replace(/<br *\/?>/gi,'\n'));
		}
	});	
}

function logout(){
$.ajax({
	type: "POST",
	url: 'assets/php/logout.php',
	success: function(f) {	
		window.location = 'index.php';	
	}
});
}
