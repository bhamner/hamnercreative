DocReady( () => {

	//delete confirmation 
	if ($('#deleteConfirmationCode').length ){
   		$("input#deleteConfirmationCode").keyup(function(){
	      if ($("input#deleteConfirmationCode").val() == $("#deleteCode").html() ){
	      	$("#submitDelete").prop("disabled", false);
	      }
		});
	}


});// end docready



