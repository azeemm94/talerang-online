$('#videoemail').validate({
    errorElement: 'label',
    errorClass: 'error',
    rules: {
        'counsellor':   { required: true,},
        'studentemail': { required: true, minlength: 2,/* iscontact: true*/},
    },
    messages: {
        'counsellor':   { required: "Please select counsellor name",},
        'studentemail': { required: "Please enter student name", minlength: "Please enter student name", /*iscontact:"Not a contact"*/},
    },
});
