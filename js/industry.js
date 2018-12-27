$("#reference").validate({
		errorElement: 'label',
        errorClass: 'error',
        focusInvalid: false,
        //errorPlacement: function(error,element) { return true; },
        rules: {
        	'refname1':  { required:true, },
        	'refemail1': { required:true, email:true, },
        	'refmob1':   { required:true, number: true, minlength: 10, maxlength: 10, },
        	'reforg1':   { required:true, },
        	'refdesn1':  { required:true, },
        	'refname2':  { required:true, },
        	'refemail2': { required:true, email:true, },
        	'refmob2':   { required:true, number: true, minlength: 10, maxlength: 10, },
        	'reforg2':   { required:true, },
        	'refdesn2':  { required:true, },
        },
        messages: {
        	'refname1':  { required: "Please answer this question" , },
        	'refemail1': { required: "Please answer this question" , email: "Please enter a valid email address", },
        	'refmob1':   { required: "Please answer this question" , number: "Please only enter numbers", minlength: "Mobile number must be 10 digits", maxlength: "Mobile number must be 10 digits", },
        	'reforg1':   { required: "Please answer this question" , },
        	'refdesn1':  { required: "Please answer this question" , },
        	'refname2':  { required: "Please answer this question" , },
        	'refemail2': { required: "Please answer this question" , email: "Please enter a valid email address", },
        	'refmob2':   { required: "Please answer this question" , number: "Please only enter numbers", minlength: "Mobile number must be 10 digits", maxlength: "Mobile number must be 10 digits", },
        	'reforg2':   { required: "Please answer this question" , },
        	'refdesn2':  { required: "Please answer this question" , },
        },
});

$('#resumeUpload').validate({
		errorElement: 'label',
        errorClass: 'error',
        rules: {
        	'fileToUpload': { required:true, extension:"doc|docx|pdf", },
        },
        messages:{
        	'fileToUpload': { required: "Please choose file for your resume first", },
        },
});

$('#video').validate({
		errorElement: 'label',
        errorClass: 'error',
        rules: {
        	'video-link': { required:true, },
        },
        messages:{
        	'video-link': { required: "Please enter the link first", },
        },
});