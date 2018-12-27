	$( "#page" ).change(function() {
 		$("#submit").trigger('click');
	});

	
	$('.lifevisform').each(function(){
	$(this).validate({
		errorClass: 'error',
		errorPlacement: function(error,element) {return true;},
		focusInvalid: false,
		rules: {
			'lvgrade1':        { required : true },
			'lvgrade2':        { required : true },
			'lifevisfeedback': { required : true },
		},
	});
	});