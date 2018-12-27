$('input[name="pay-option"]').on('click', function() {
         if ($(this).val() == 'citrus-pay') 
         {
         		$('.notif.fail').hide('fast');
            $('#citrus-test').show('fast');
         }
         else 
         {
         		$('.notif.fail').show('fast');
         		$('#citrus-test').hide('fast');
         }

         if ($(this).val() == 'coupon-pay')
         {
            $('#coupon').show('fast');
         }  
         else
         {
            $('#coupon').hide('fast');
         } 
     });
$('#coupon').validate({
  errorClass: 'error',
  rules: {
    'ccode':    { required: true,},
  },
});
