/*$(function(){
    $(".landing").hover(
        function(){
           $(this).stop().animate({ "padding" : "15px" },300); 
        },
        function(){
           $(this).stop().animate({ "padding" : "30px" },300); 
        }
    );                             
});*/

$(function() {
    $('input[name="inttype"]').on('click', function() {
        if ($(this).val() == 'hrfit') {
            $('#deschrfit').show('fast');
        }
        else {
            $('#deschrfit').hide('fast');
        }

        if ($(this).val() == 'case') {
            $('#desccase').show('fast');
        }
        else {
            $('#desccase').hide('fast');
        }
    });
});