$( function() {
	$('.datepicker').each(function(){
		$(this).datepicker({ 
			showAnim:"slideDown",
			changeMonth:true,
			changeYear:false,
			showOtherMonths: true,
			selectOtherMonths: false,
			dateFormat: 'D, d M yy', 
			maxDate: new Date(),
		});
	});
});

$( "#page" ).change(function() {
	$("#submit").trigger('click');
});

$('.feedbackform').each(function(){
	$(this).validate({
		errorClass: 'error',
		errorPlacement: function(error,element) {return true;},
		focusInvalid: false,
		rules: {
			'intdate': {required : true,},
			'inttime': {required : true,},
			'mockfeedback': {required : true,},
		},
	});
	$('.datepicker').change(function() {
  		$(this).valid();
  	});
});
