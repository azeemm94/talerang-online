$(document).ready(function(){    
        $('#mockform').validate({
            errorElement: 'label',
            errorClass: 'error',
            rules: {
                'mocktype':  { required: true,},
                'grade10m':  { required: true,},
                'grade10t':  { required: true,},
                'grade12m':  { required: true,},
                'grade12t':  { required: true,},
                'ldrex':     { required: true,},
                'workex':    { required: true,},
                'country':   { required: true,},
                'skill':     { required: true,},
                'mobileno':  { required: true,},
                'skypeid':   { required: true,},
                'intmode':   { required: true,},
            },
            messages: {
                'ldrex':     { required: "Please answer this question!",},
                'workex':    { required: "Please answer this question!",},
                'skill':     { required: "Please answer this question!",},
                'grade10m':  { required: "",},
                'grade10t':  { required: "",},
                'grade12m':  { required: "",},
                'grade12t':  { required: "",},
            }
        });

        $(function() {
            $('select[name="skill"]').on('click', function() {
                if ($(this).val() == 'Other') {
                    $('#otherskill').show('fast');
                }
                else {
                    $('#otherskill').hide('fast');
                }
            });
        });

        $(function() {
            $('input[name="intmode"]').on('click', function() {
                if ($(this).val() == 'phone') {
                    $('div#mobileno').show('fast');
                }
                else {
                    $('div#mobileno').hide('fast');
                }
                if($(this).val() == 'skype') {
                    $('div#skypeid').show('fast');
                }
                else {
                    $('div#skypeid').hide('fast');
                }
            });
        });


});