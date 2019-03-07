/* for modal showMsg */
function showMsg(title, what, okyesno, successorfailure){			
		$('#alert .modal-title').html(title);
		$('#alert .modal-body > p').html(what);	
	if(okyesno == "yesno"){
		$('.yesNo').removeClass('hidden');
		$('.ok, .addCancel').addClass('hidden');
	}else if(okyesno == "ok"){
		$('.yesNo, .addCancel').addClass('hidden');
		$('.ok').removeClass('hidden');
		if(successorfailure == "failure"){
			$('#ok').removeClass('btn-success').addClass('btn-danger');
		}else{
			$('#ok').removeClass('btn-danger').addClass('btn-success');
		}
	}else if(okyesno == "addcancel"){
		$('.addCancel').removeClass('hidden');
		$('.ok, .yesNo').addClass('hidden');
	}
		$('#alert').addClass('modal In').css('display','table');
}

$(document).on('click', '#alert button', function(){
		if(!$(this).hasClass('needChecks')){
			$('#alert').hide();
		}
});