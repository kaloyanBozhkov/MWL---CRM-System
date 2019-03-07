var GLOBAL_goToWhere = "";

(function ($) {
    "use strict";
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

	function getCookie(name) {
	  var value = "; " + document.cookie;
	  var parts = value.split("; " + name + "=");
	  if (parts.length == 2) return parts.pop().split(";").shift();
	}
	
	var uu = getCookie('username');
	
	if(uu !== null && typeof uu !== 'undefined'){
		$('#ckb1').prop('checked', true);
		$('#username').val(uu);
	}
	
    $(document).on('click', '#btnlgn', function(){
        var check = true;	
		
        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }
		if(check){			
			sendCredentials('dashboard.php');
		}	
		
		
    });

	function set_cookie(name, value) {
		document.cookie = name +'='+ value +'; Path=/;';
	}
	function delete_cookie(name) {
		document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;Path=/;';
	}
	

	
	function sendCredentials(where){
			$.ajax({
                type: "POST",
                url: 'assets/php/login.php',
                data: {username: $('#username').val(), password: $('#pass').val()},
                success: function(f) {	
					if(f == 0){		
						window.GLOBAL_goToWhere = where;
						if($('#ckb1').is(':checked')){
							set_cookie('username', $('#username').val());							
						}else{
							delete_cookie('username');
						}
						window.showMsg('Logged in!','Hooray!<br/><br/>You have successfully logged in as <b>'+$('#username').val().trim()+'</b>, congratulations.<br/><br/>Now carry on with your life, fool.','ok', 'success');
					}else{
						window.showMsg('Login failed!','Oops, something went wrong.<br/><br/>There seems to be an issue with the credentials used, they were not recognized.','ok', 'failure');
					}					
				}
			});
		
	}

	$(document).on('keypress', function(e){
		if (!e) e = window.event;
		if (e.keyCode == '13'){
		  $('#btnlgn').click();
		  return false;
		}
	}) 
	
	
    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }


})(jQuery);