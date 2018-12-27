/**********************Facebook initialization**********************/
window.fbAsyncInit = function() {
FB.init({
  appId      : '1742318776028717',
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

/***************************Custom JS***************************/
var stepno=1;
var answer="";
var timecomplete=false;
var j=0,h=0,e=0;
var highest='';
var message='';
var messagequiz='';
var fbpiclink='';
var correct=new Array(10);

correct[0]=[5,0,10];correct[1]=[5,10,0];correct[2]=[10,0,5];correct[3]=[5,10,0];correct[4]=[10,5,10];correct[5]=[5,10,0];correct[6]=[10,0,5];correct[7]=[5,10,0];correct[8]=[5,5,5];correct[9]=[5,10,5];


/*timerstart();*/
$('.quiz-step').each(function() {
var $step = $(this);

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

        if($currentStep.hasClass('question'))
        {
            chosenopt=$('input[name=q'+stepno+']:checked', '#jhe').val();

            if(chosenopt=='Y')
            {
                j+=correct[stepno-1][0];
                e+=correct[stepno-1][1];
                h+=correct[stepno-1][2];
            }

            answer+=chosenopt;
            console.log(answer);
           /* console.log(score);*/
           if(stepno<=10) stepno++;
           /*console.log("J="+j+" E="+e+" H="+h);*/

            $('span#stepno').text(stepno);

            
        }
		switch(stepno)
        {
            case 1:  $("#question-row").css({"background":"url('img/jhe/core-subject.jpg')"}); 
                        break;
            case 2:  $("#question-row").css({"background":"url('img/jhe/team-management.jpg')"}); 
                        break;
            case 3:  $("#question-row").css({"background":"url('img/jhe/peaceful-life.jpg')"}); 
                        break;
            case 4:  $("#question-row").css({"background":"url('img/jhe/business-idea.jpg')"}); 
                        break;
            case 5:  $("#question-row").css({"background":"url('img/jhe/field-to-pursue.jpg')"}); 
                        break;
            case 6:  $("#question-row").css({"background":"url('img/jhe/fast-paced-environment.jpg')"}); 
                        break;
            case 7:  $("#question-row").css({"background":"url('img/jhe/financial-security.jpg')"}); 
                        break;
            case 8:  $("#question-row").css({"background":"url('img/jhe/independent-decisions.jpg')"}); 
                        break;
            case 9:  $("#question-row").css({"background":"url('img/jhe/industry-clarity.jpg')"}); 
                        break;
            case 10: $("#question-row").css({"background":"url('img/jhe/out-of-the-box.jpg')"}); 
                        break;
        }
    }
}

if($(".current").hasClass("start"))
{
	$("#qno").css({"display":"none"});
}

$("#quizstart").on( 'click', function () {
	$("#qno").css({"display":"block"});
    $.ajax({
        type: 'post',
        url: '',
        data: {
            jhe_start: '1'
        },
        success: function( data ) {
        }
    });
});

$('input[name="q10"]').on( 'click', function () {

    j=Math.round((j/65)*100);
    e=Math.round((e/60)*100);
    h=Math.round((h/40)*100);
    var flag=false;
    for(var x=100;x>=0;x--)
    {
        if(j==x) { highest+='j'; flag=true; }
        if(e==x) { highest+='e'; flag=true; }
        if(h==x) { highest+='h'; flag=true; }
        if(flag) break;
    }

    if(highest.length==1)
    {
        if(highest=='j')
        {
            message+="I am most suited for a job.";
            messagequiz+="You are most suited for a job.";
            $('#question-row').css({"background":"url(img/jhe/opportunity-ahead.jpg)"});
            fbpiclink='www.talerang.com/express/img/jhe/opportunity-ahead.jpg';
        }
        if(highest=='e')
        {
            message+="I am most suited for entrepreneurship.";
            messagequiz+="You are most suited for entrepreneurship.";
            $('#question-row').css({"background":"url(img/jhe/entrepreneurship.jpg)"});
            fbpiclink='www.talerang.com/express/img/jhe/entrepreneurship.jpg';
        }
        if(highest=='h')
        {
            message+="I am most suited for higher studies.";
            messagequiz+="You are most suited for higher studies.";
            $('#question-row').css({"background":"url(img/jhe/higher-studies.jpg)"});
            fbpiclink='www.talerang.com/express/img/jhe/higher-studies.jpg';
        }
    }
    else if(highest.length==2)
    {
        if(highest=='je')
        {
            message+="I am most suited for a job or entrepreneurship.";
            messagequiz+="You are most suited for a job or entrepreneurship.";
        }
        else if(highest=='jh')
        {
            message+="I am most suited for a job or higher studies.";
            messagequiz+="You are most suited for a job or higher studies.";
        }
        else if(highest=='eh')
        {
            message+="I am most suited for entrepreneurship or higher studies.";
            messagequiz+="You are most suited for entrepreneurship or higher studies.";
        }
        $('#question-row').css({"background":"none"});
        fbpiclink='www.talerang.com/express/img/jhe/opportunity-ahead.jpg';
    }
    else //jeh
    {
        message+="I am suited for anything that I choose.";
        messagequiz+="You are suited for anything that you choose.";
        $('#question-row').css({"background":"none"});
        fbpiclink='www.talerang.com/express/img/jhe/opportunity-ahead.jpg';
    }
    message+=" How about you?";
    /*console.log(message);*/

	$("div#qno").css({"display":"none"});
	$('div#results').find("h2.score-title").prepend(messagequiz);
    $('div#results').find("p.sub-scores").prepend("Propensity towards Jobs: "+j+"%<br>Propensity towards Entrepreneurship: "+e+"%<br>Propensity towards Higher Studies: "+h+"%");

    $.ajax({
        type: 'post',
        url: '',
        data: {
            jhe_end:'1',
            j:j,
            e:e,
            h:h,
            highest:highest,
            answer: answer,
        },
        success: function( data ) {
        	/*console.log(score+" "+answer);
            console.log( data );*/
        }
    });
});

/**************************Facebook Sharing**************************/
document.getElementById('shareBtn').onclick = function() {

    FB.ui({
        display: 'popup',
        method: 'share',
        title: message,
        description: 'What is the right path for you immediately after college? Find out now!',
    link: 'www.talerang.com/express/jhe.php',
    picture: fbpiclink,
    href: 'www.talerang.com/express/jhe.php',

  }, function(response){}); 
}

/**************************Preload Images**************************/
function preloadImages(array) {
    if (!preloadImages.list) {
        preloadImages.list = [];
    }
    var list = preloadImages.list;
    for (var i = 0; i < array.length; i++) {
        var img=new Image();
        img.onload=function() {
            var index = list.indexOf(this);
            if (index !== -1) list.splice(index, 1);
        }
        list.push(img);
        img.src = array[i];
    }
}
preloadImages(["img/jhe/core-subject.jpg","img/jhe/team-management.jpg","img/jhe/peaceful-life.jpg","img/jhe/business-idea.jpg","img/jhe/field-to-pursue.jpg","img/jhe/fast-paced-environment.jpg","img/jhe/financial-security.jpg","img/jhe/independent-decisions.jpg","img/jhe/industry-clarity.jpg","img/jhe/out-of-the-box.jpg","img/jhe/higher-studies.jpg","img/jhe/entrepreneurship.jpg","img/jhe/opportunity-ahead.jpg"]);