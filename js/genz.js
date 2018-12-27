window.fbAsyncInit = function() {
FB.init({
  appId      : '246763172448661',
  xfbml      : true,
  version    : 'v2.8'
});
};

(function(d, s, id){
 var js, fjs = d.getElementsByTagName(s)[0];
 if (d.getElementById(id)) {return;}
 js = d.createElement(s); js.id = id;
 js.src = "//connect.facebook.net/en_US/sdk.js";
 fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


var stepno=0;
var correct="ACDCABABDE";
var answer="";
var correctopt="";
var score=0;
var timecomplete=false;

/*timerstart();*/
$('.quiz-step').each(function() {
var $step = $(this);

timerstart();

timecomplete = false;
// for each step, add click listener
// apply current active class
$step.find('.quiz-answer').click(function quizanswer(){

    var $this = $(this);

        // check to see if an answer was previously selected
        if ($step.children('.active').length > 0) {
            var wasActive = $step.children('.active');
            $step.children('.active').removeClass('active');
            $this.addClass('active');
        } else {
            $this.addClass('active');
            updateStep($step);
        }
    });
});

// show current step/hide other steps
function updateStep($currentStep) {
    if ($currentStep.hasClass('current')) 
    {	
    	$currentStep.removeClass('current');
        $currentStep.hide('slow');
        
        $currentStep.next('.quiz-step').addClass('current');
        $currentStep.next('.quiz-step').slideDown('fast');
        timerstop();

        if($currentStep.hasClass('question')) 
        {
    		correctopt=correct.charAt(stepno-1);
	        chosenopt=$('input[name=q'+stepno+']:checked', '#genz').val();

	        if(chosenopt==correctopt)
	        {
	        	$currentStep.next('.quiz-step').addClass('correct');
	        	$currentStep.next('.quiz-step').find('.answer-image').prepend('<img src="img/genz/correct.png">');
	        	score++;
	        }
	        else if(timecomplete)
	        {
	        	$currentStep.next('.quiz-step').addClass('timeup');
	        	$currentStep.next('.quiz-step').find('.answer-image').prepend('<img src="img/genz/timesup.jpg">');
	        } 
	        else //wrong answer selected
	        {
	        	$currentStep.next('.quiz-step').addClass('incorrect');
	        	$currentStep.next('.quiz-step').find('.answer-image').prepend('<img src="img/genz/incorrect.png">');
	        }

		    answer+=chosenopt;
		   /* console.log(answer);
		    console.log(score);*/
        }

        if(! $currentStep.hasClass('question')) 
    	{	
    		stepno++;
    		timerstart();
    	}
        $('span#stepno').text(stepno);
    }
}

if($(".current").hasClass("start"))
{
	$("#timer").css({"display":"none"});
	$("#qno").css({"display":"none"});
}

var timer = null;
function timerstart() {
	value=20;  // time in seconds given to each question
	$("span#timerclock").text(value);
	$("div#timer").css({"display":"inline-block"});
  if (timer !== null) return;
  timer = setInterval(function (){
      value-=1;
      if(value==0)
      {
      	timecomplete=true;
      	timerstop();
      }
      else timecomplete=false;
      
      $("#timerclock").text(value);
  }, 1000); 
}

function timerstop() {
	$("span#timerclock").text(value);
	clearInterval(timer);
	timer = null;

	var radioid='#q'+stepno+'at';

	if(timecomplete==true)
	$(radioid).trigger('click');
	$("div#timer").css({"display":"none"});
}

$("#quizstart").on( 'click', function () {
	$("#qno").css({"display":"block"});
    $.ajax({
        type: 'post',
        url: '',
        data: {
            quizstart: '1'
        },
        success: function( data ) {
           /* console.log( data );*/
        }
    });
});

$("#dummy10").on( 'click', function () {

	$("#timer").css({"display":"none"});
	$("div#qno").css({"display":"none"});
	$('div#results').find("h2.question-title").prepend("You scored: "+score+"/10");

    $.ajax({
        type: 'post',
        url: '',
        data: {
            score: score,
            answers: answer 
        },
        success: function( data ) {
        	/*console.log(score+" "+answer);
            console.log( data );*/
        }
    });
});

function preloadImages(array) {
    if (!preloadImages.list) {
        preloadImages.list = [];
    }
    var list = preloadImages.list;
    for (var i = 0; i < array.length; i++) {
        var img = new Image();
        img.onload = function() {
            var index = list.indexOf(this);
            if (index !== -1) {
                // remove image from the array once it's loaded
                // for memory consumption reasons
                list.splice(index, 1);
            }
        }
        list.push(img);
        img.src = array[i];
    }
}

preloadImages(["img/genz/correct.png", "img/genz/incorrect.png", "img/genz/timesup.jpg"]);

/*Facebook Sharing*/
document.getElementById('shareBtn').onclick = function() {

    FB.ui({
        display: 'popup',
        method: 'share',
        title: 'I got ' + score + '/10! How about you?',
        description: 'How well do you know Generation Z? Find out now!',
    link: 'www.talerang.com/express/genz.php',
    picture: 'www.talerang.com/express/img/genz/generation-z.jpg',
    href: 'www.talerang.com/express/genz.php',

  }, function(response){}); 
}