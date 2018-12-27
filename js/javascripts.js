/***********************************VALIDATION***********************************/
$(document).ready(function(){

jQuery.validator.addMethod("atof", function(value, element) {
  return this.optional(element) || /^[a-f]+$/i.test(value);
}, "A-F only please");

jQuery.validator.addMethod("atok", function(value, element) {
  return this.optional(element) || /^[a-k]+$/i.test(value);
}, "A-K only please");

jQuery.validator.addMethod("letters", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Alphabets only please");

$('#talquiz').validate({
	errorClass: 'error',
	rules: {
		'question1answers':    { required: true,},
		'question2answers':    { required: true,},
		'question1banswers':   { required: true,},
		'question1banswerstext':{ required: true,},
		'question2banswers':   { required: true,},
		'question3answers':    { required: true,},
		'question4answers':    { required: true,},
		'question5answers':    { required: true,},
		'question6answers':    { required: true,},
		'question7answers':    { required: true,},
		'question8answers[]':  { required: true,},
		'question9answers':    { required: true,},
		'question10answers[]': { required: true,},
		'question11answers':   { required: true,},
		'question12answers':   { required: true,},
		'question13answers':   { required: true,},
		'question14answers':   { required: true,},
		'question15answers':   { required: true,},
		'question17answers[]': { required: true,},
		'question18answers':   { required: true,},
		'question19answers':   { required: true,},
		'question20answers':   { required: true,},
		'question21answers':   { required: true,},
		'question22answers':   { required: true,},
		'question23answers':   { required: true,},
		'question24answers':   { required: true,},
		'question25answers':   { required: true,},
		'question26answers':   { required: true,},
		'question27answers':   { required: true,},
		'question28answers':   { required: true,},
		'question29answers':   { required: true,},
		'question30answers':   { required: true,},
		'question30answersA':  { required: true, letters:true},
		/*'question30answersB':  { required: true, letters:true},
		'question30answersC':  { required: true, letters:true},
		'question30answersD':  { required: true, letters:true},
		'question30answersE':  { required: true, letters:true},*/
		'question30answersF':  { required: true,},
		'question31answers':   { required: true,},
		'question32answers':   { required: true,},
		'question33answers':   { required: true,},
		'question34answers':   { required: true,},
		'question35answers':   { required: true,},
		'question36answers[]': { required: true, maxlength: 6,},
		'question37answers':   { required: true,}, //essay
		'question38answers':   { required: true,}, //essay
		'agree':               { required: true,},
		'fullname':            { required: true,},

	},
		messages: {
		'question1answers':    { required:"Please answer this question!",},
		'question2answers':    { required:"Please answer this question!",},
		'question1banswers':   { required:"Please answer this question!",},
		'question1banswerstext':{ required:"Please answer this question!",},
		'question2banswers':   { required:"Please answer this question!",},
		'question3answers':    { required:"Please answer this question!",},
		'question4answers':    { required:"Please answer this question!",},
		'question5answers':    { required:"Please answer this question!",},
		'question6answers':    { required:"Please answer this question!",},
		'question7answers':    { required:"Please answer this question!",},
		'question8answers[]':  { required:"Please answer this question!",},				
		'question9answers':    { required:"Please answer this question!",},
		'question10answers[]': { required:"Please answer this question!",},
		'question11answers':   { required:"Please answer this question!",},
		'question12answers':   { required:"Please answer this question!",},
		'question13answers':   { required:"Please answer this question!",},
		'question14answers':   { required:"Please answer this question!",},
		'question15answers':   { required:"Please answer this question!",},
		'question17answers[]': { required:"Please answer this question!",},
		'question18answers':   { required:"Please answer this question!",},
		'question19answers':   { required:"Please answer this question!",},
		'question20answers':   { required:"Please answer this question!",},
		'question21answers':   { required:"Please answer this question!",},
		'question22answers':   { required:"Please answer this question!",},
		'question23answers':   { required:"Please answer this question!",},
		'question24answers':   { required:"Please answer this question!",},
		'question25answers':   { required:"Please answer this question!",},
		'question26answers':   { required:"Please answer this question!",},
		'question27answers':   { required:"Please answer this question!",},
		'question28answers':   { required:"Please answer this question!",},
		'question29answers':   { required:"Please answer this question!",},
		'question30answers':   { required:"Please answer this question!",},
		'question30answersA':  { required:"Please answer this question!",},
		/*'question30answersB':  { required:"Please answer this question!",},
		'question30answersC':  { required:"Please answer this question!",},
		'question30answersD':  { required:"Please answer this question!",},
		'question30answersE':  { required:"Please answer this question!",},*/
		'question30answersF':  { required:"Please answer this question!",},
		'question31answers':   { required:"Please answer this question!",},
		'question32answers':   { required:"Please answer this question!",},
		'question33answers':   { required:"Please answer this question!",},
		'question34answers':   { required:"Please answer this question!",},
		'question35answers':   { required:"Please answer this question!",},
		'question36answers[]': { required:"Please answer this question!", maxlength: "No more than {0} options please!",},
		//'question37answers':   { required:"Please answer this question!", minlength: "Your answer is too short!",},
		//'question38answers':   { required:"Please answer this question!", minlength: "Your answer is too short!",},
		'agree':               { required:"Please accept the honor code",},
		'fullname':            { required:"Please enter your full name",},
	},

});

//refuse form submit using enter key
$('#talquiz input').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
});

//hide/show other textbox for Q1
$(function() {
    $('input[name="question1banswers"]').on('click', function() {
        if ($(this).val() == 'D') {
            $('#hideshow1').show('fast');
        }
        else {
            $('#hideshow1').hide('fast');
        }
    });
});

$( "#sortable1" ).sortable({
  placeholder: "ui-state-highlight",
  stop: function( event, ui ) {
    var data = $('#sortable1').sortable('toArray', { attribute: 'pri1-id' });
    document.getElementById('question-14-answers').value = data[0]+"."+data[1]+"."+data[2]+"."+data[3]+"."+data[4]+"."+data[5];
 }
});

$( "#sortable" ).disableSelection();

    $(function() {
    $('.sortablepri2').sortable({
        placeholder: 'ui-state-highlight',
        connectWith: '.sortablepri2',
        cancel: ".ui-state-disabled",
        receive: function(event, ui) {
            var $this = $(this);
            if ($this.children('li').length > 3 && $this.attr('id') != "sortable2") {
                console.log('Only one per list!');
                $(ui.sender).sortable('cancel');
            }
        },
        stop: function( event, ui ) {
        var data1 = $('#top3').sortable('toArray', { attribute: 'pri2-id' });
        document.getElementById('question-15-answers-1').value = data1[0]+"."+data1[1]+"."+data1[2]+"."+data1[3];

        var data2 = $('#bottom3').sortable('toArray', { attribute: 'pri2-id' });
        document.getElementById('question-15-answers-2').value = data2[0]+"."+data2[1]+"."+data2[2]+"."+data2[3];
        }
    });
    });

    $( "#sortable2" ).disableSelection();

$("#submit2").click(function(){
	return true;
});

$('#submit').click(function() {
    if($('#talquiz').valid() 
    	&& $('.nav-tabs > .first').hasClass('complete') 
    	&& $('.nav-tabs > .second').hasClass('complete') 
    	&& $('.nav-tabs > .third').hasClass('complete') 
    	&& $('.nav-tabs > .lifevision').hasClass('complete') 
    	&& $('.nav-tabs > .fourth').hasClass('complete') 
    	&& $('.nav-tabs > .fifth').hasClass('complete') 
    	&& $('.nav-tabs > .sixth').hasClass('complete') 
    	&& $('.nav-tabs > .seventh').hasClass('complete') 
    	&& $('.nav-tabs > .eighth').hasClass('complete') ){
    	return true;
    }
    	else {
    		alert('Please complete all the sections before you submit!');
    		return false;
    	}
});

$('.next').click(function(){
	/*$("#talquiz").valid(); */
	
	if($("#talquiz").valid()===true){
		$('.nav-tabs > .active').addClass('complete');
 		$('.nav-tabs > .active').removeClass('incomplete');
	 	$('.nav-tabs > .active').next('li').find('a').trigger('click');
	 }
	 else{
	 	$('.nav-tabs > .active').addClass('incomplete');
 		$('.nav-tabs > .active').removeClass('complete');
	 	$('.nav-tabs > .active').next('li').find('a').trigger('click');
	 }
	 $("html, body").animate({ scrollTop: 0 }, "fast");
});
$('.previous').click(function(){
	/*$("#talquiz").valid(); */
	
	if($("#talquiz").valid()===true){
		$('.nav-tabs > .active').addClass('complete');
 		$('.nav-tabs > .active').removeClass('incomplete');
	 	$('.nav-tabs > .active').prev('li').find('a').trigger('click');
	 }
	 else{
	 	$('.nav-tabs > .active').addClass('incomplete');
 		$('.nav-tabs > .active').removeClass('complete');
	 	$('.nav-tabs > .active').prev('li').find('a').trigger('click');
	 }
	 $("html, body").animate({ scrollTop: 0 }, "fast");
});

$('.tablink').click(function() {
 	/*$('#talquiz').valid();*/
 	if($('#talquiz').valid()!==true){
 		$('.nav-tabs > .active').removeClass('complete');
 		$('.nav-tabs > .active').addClass('incomplete');
 		/*return false;*/
 	}
 	else{
 		$('.nav-tabs > .active').removeClass('incomplete');
 		$('.nav-tabs > .active').addClass('complete');
 		return true;
 	}

});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e)
{
	if($('.nav-tabs > .active').hasClass('incomplete')){
		$("#talquiz").valid(); 
	}
});

$(function goToByScroll(id){
    $('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
});

}); /*end document ready*/
/***********************************VALIDATION***********************************/
/**********************************TOUCH PUNCH**********************************/
/*!
 * jQuery UI Touch Punch 0.2.3
 * Copyright 2011–2014, Dave Furfero
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * Depends:
 *  jquery.ui.widget.js
 *  jquery.ui.mouse.js
 */
!function(a){function f(a,b){if(!(a.originalEvent.touches.length>1)){a.preventDefault();var c=a.originalEvent.changedTouches[0],d=document.createEvent("MouseEvents");d.initMouseEvent(b,!0,!0,window,1,c.screenX,c.screenY,c.clientX,c.clientY,!1,!1,!1,!1,0,null),a.target.dispatchEvent(d)}}if(a.support.touch="ontouchend"in document,a.support.touch){var e,b=a.ui.mouse.prototype,c=b._mouseInit,d=b._mouseDestroy;b._touchStart=function(a){var b=this;!e&&b._mouseCapture(a.originalEvent.changedTouches[0])&&(e=!0,b._touchMoved=!1,f(a,"mouseover"),f(a,"mousemove"),f(a,"mousedown"))},b._touchMove=function(a){e&&(this._touchMoved=!0,f(a,"mousemove"))},b._touchEnd=function(a){e&&(f(a,"mouseup"),f(a,"mouseout"),this._touchMoved||f(a,"click"),e=!1)},b._mouseInit=function(){var b=this;b.element.bind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),c.call(b)},b._mouseDestroy=function(){var b=this;b.element.unbind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),d.call(b)}}}(jQuery);
//$('li.ui-state-default.ui-sortable-handle').draggable();
/*$('#sortable2').draggable();*/
/**********************************TOUCH PUNCH**********************************/
/********************************TEXTAREA COUNTER********************************/
/**
 * jQuery.textareaCounter
 * Version 1.0
 * Copyright (c) 2011 c.bavota - http://bavotasan.com
 * Dual licensed under MIT and GPL.
 * Date: 10/20/2011
**/
(function($){
	$.fn.textareaCounter1 = function(options) {
		// setting the defaults
		// 
		var defaults = {
			limit: 150
		};	
		var options = $.extend(defaults, options);
 
		// and the plugin begins
		return this.each(function() {
			var obj, text, wordcount, limited;
			
			obj = $(this);
			obj.after('<span style="font-size: 18px; clear: both; display: block;" id="counter-text1">Max. '+options.limit+' words</span>');

			obj.keyup(function() {
			    text = obj.val();
			    if(text === "") {
			    	wordcount = 0;
			    } else {
				    wordcount = $.trim(text).split(/[\s\.\?]+/).length;
				}
			    if(wordcount > options.limit) {
			        $("#counter-text1").html('<span style="color: #DD0000;">0 words left</span>');
					limited = $.trim(text).split(" ", options.limit);
					limited = limited.join(" ");
					$(this).val(limited);
			    } else {
			        $("#counter-text1").html((options.limit - wordcount)+' words left');
			    } 
			});
		});
	};
})(jQuery);

(function($){
	$.fn.textareaCounter2 = function(options) {
		// setting the defaults
		// 
		var defaults = {
			limit: 150
		};	
		var options = $.extend(defaults, options);
 
		// and the plugin begins
		return this.each(function() {
			var obj, text, wordcount, limited;
			
			obj = $(this);
			obj.after('<span style="font-size: 18px; clear: both; display: block;" id="counter-text2">Max. '+options.limit+' words</span>');

			obj.keyup(function() {
			    text = obj.val();
			    if(text === "") {
			    	wordcount = 0;
			    } else {
				    wordcount = $.trim(text).split(/[\s\.\?]+/).length;
				}
			    if(wordcount > options.limit) {
			        $("#counter-text2").html('<span style="color: #DD0000;">0 words left</span>');
					limited = $.trim(text).split(" ", options.limit);
					limited = limited.join(" ");
					$(this).val(limited);
			    } else {
			        $("#counter-text2").html((options.limit - wordcount)+' words left');
			    } 
			});
		});
	};
})(jQuery);
$("textarea#question37answers").textareaCounter1({ limit: 150 });
$("textarea#question38answers").textareaCounter2({ limit: 150 });
/********************************TEXTAREA COUNTER********************************/
/*************************************ROTATE*************************************/
// VERSION: 2.3 LAST UPDATE: 11.07.2013
/*
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 *
 * Made by Wilq32, wilq32@gmail.com, Wroclaw, Poland, 01.2009
 * Website: http://jqueryrotate.com
 */
!function($){for(var supportedCSS,supportedCSSOrigin,styles=document.getElementsByTagName("head")[0].style,toCheck="transformProperty WebkitTransform OTransform msTransform MozTransform".split(" "),a=0;a<toCheck.length;a++)void 0!==styles[toCheck[a]]&&(supportedCSS=toCheck[a]);supportedCSS&&(supportedCSSOrigin=supportedCSS.replace(/[tT]ransform/,"TransformOrigin"),"T"==supportedCSSOrigin[0]&&(supportedCSSOrigin[0]="t")),eval('IE = "v"==""'),jQuery.fn.extend({rotate:function(t){if(0!==this.length&&"undefined"!=typeof t){"number"==typeof t&&(t={angle:t});for(var i=[],e=0,s=this.length;s>e;e++){var a=this.get(e);if(a.Wilq32&&a.Wilq32.PhotoEffect)a.Wilq32.PhotoEffect._handleRotation(t);else{var r=$.extend(!0,{},t),h=new Wilq32.PhotoEffect(a,r)._rootObj;i.push($(h))}}return i}},getRotateAngle:function(){for(var t=[],i=0,e=this.length;e>i;i++){var s=this.get(i);s.Wilq32&&s.Wilq32.PhotoEffect&&(t[i]=s.Wilq32.PhotoEffect._angle)}return t},stopRotate:function(){for(var t=0,i=this.length;i>t;t++){var e=this.get(t);e.Wilq32&&e.Wilq32.PhotoEffect&&clearTimeout(e.Wilq32.PhotoEffect._timer)}}}),Wilq32=window.Wilq32||{},Wilq32.PhotoEffect=function(){return supportedCSS?function(t,i){t.Wilq32={PhotoEffect:this},this._img=this._rootObj=this._eventObj=t,this._handleRotation(i)}:function(t,i){if(this._img=t,this._onLoadDelegate=[i],this._rootObj=document.createElement("span"),this._rootObj.style.display="inline-block",this._rootObj.Wilq32={PhotoEffect:this},t.parentNode.insertBefore(this._rootObj,t),t.complete)this._Loader();else{var e=this;jQuery(this._img).bind("load",function(){e._Loader()})}}}(),Wilq32.PhotoEffect.prototype={_setupParameters:function(t){this._parameters=this._parameters||{},"number"!=typeof this._angle&&(this._angle=0),"number"==typeof t.angle&&(this._angle=t.angle),this._parameters.animateTo="number"==typeof t.animateTo?t.animateTo:this._angle,this._parameters.step=t.step||this._parameters.step||null,this._parameters.easing=t.easing||this._parameters.easing||this._defaultEasing,this._parameters.duration="duration"in t?t.duration:t.duration||this._parameters.duration||1e3,this._parameters.callback=t.callback||this._parameters.callback||this._emptyFunction,this._parameters.center=t.center||this._parameters.center||["50%","50%"],"string"==typeof this._parameters.center[0]?this._rotationCenterX=parseInt(this._parameters.center[0],10)/100*this._imgWidth*this._aspectW:this._rotationCenterX=this._parameters.center[0],"string"==typeof this._parameters.center[1]?this._rotationCenterY=parseInt(this._parameters.center[1],10)/100*this._imgHeight*this._aspectH:this._rotationCenterY=this._parameters.center[1],t.bind&&t.bind!=this._parameters.bind&&this._BindEvents(t.bind)},_emptyFunction:function(){},_defaultEasing:function(t,i,e,s,a){return-s*((i=i/a-1)*i*i*i-1)+e},_handleRotation:function(t,i){return supportedCSS||this._img.complete||i?(this._setupParameters(t),void(this._angle==this._parameters.animateTo?this._rotate(this._angle):this._animateStart())):void this._onLoadDelegate.push(t)},_BindEvents:function(t){if(t&&this._eventObj){if(this._parameters.bind){var i=this._parameters.bind;for(var e in i)i.hasOwnProperty(e)&&jQuery(this._eventObj).unbind(e,i[e])}this._parameters.bind=t;for(var e in t)t.hasOwnProperty(e)&&jQuery(this._eventObj).bind(e,t[e])}},_Loader:function(){return IE?function(){var t=this._img.width,i=this._img.height;this._imgWidth=t,this._imgHeight=i,this._img.parentNode.removeChild(this._img),this._vimage=this.createVMLNode("image"),this._vimage.src=this._img.src,this._vimage.style.height=i+"px",this._vimage.style.width=t+"px",this._vimage.style.position="absolute",this._vimage.style.top="0px",this._vimage.style.left="0px",this._aspectW=this._aspectH=1,this._container=this.createVMLNode("group"),this._container.style.width=t,this._container.style.height=i,this._container.style.position="absolute",this._container.style.top="0px",this._container.style.left="0px",this._container.setAttribute("coordsize",t-1+","+(i-1)),this._container.appendChild(this._vimage),this._rootObj.appendChild(this._container),this._rootObj.style.position="relative",this._rootObj.style.width=t+"px",this._rootObj.style.height=i+"px",this._rootObj.setAttribute("id",this._img.getAttribute("id")),this._rootObj.className=this._img.className,this._eventObj=this._rootObj;for(var e;e=this._onLoadDelegate.shift();)this._handleRotation(e,!0)}:function(){this._rootObj.setAttribute("id",this._img.getAttribute("id")),this._rootObj.className=this._img.className,this._imgWidth=this._img.naturalWidth,this._imgHeight=this._img.naturalHeight;var t=Math.sqrt(this._imgHeight*this._imgHeight+this._imgWidth*this._imgWidth);this._width=3*t,this._height=3*t,this._aspectW=this._img.offsetWidth/this._img.naturalWidth,this._aspectH=this._img.offsetHeight/this._img.naturalHeight,this._img.parentNode.removeChild(this._img),this._canvas=document.createElement("canvas"),this._canvas.setAttribute("width",this._width),this._canvas.style.position="relative",this._canvas.style.left=-this._img.height*this._aspectW+"px",this._canvas.style.top=-this._img.width*this._aspectH+"px",this._canvas.Wilq32=this._rootObj.Wilq32,this._rootObj.appendChild(this._canvas),this._rootObj.style.width=this._img.width*this._aspectW+"px",this._rootObj.style.height=this._img.height*this._aspectH+"px",this._eventObj=this._canvas,this._cnv=this._canvas.getContext("2d");for(var i;i=this._onLoadDelegate.shift();)this._handleRotation(i,!0)}}(),_animateStart:function(){this._timer&&clearTimeout(this._timer),this._animateStartTime=+new Date,this._animateStartAngle=this._angle,this._animate()},_animate:function(){var t=+new Date,i=t-this._animateStartTime>this._parameters.duration;if(i&&!this._parameters.animatedGif)clearTimeout(this._timer);else{if(this._canvas||this._vimage||this._img){var e=this._parameters.easing(0,t-this._animateStartTime,this._animateStartAngle,this._parameters.animateTo-this._animateStartAngle,this._parameters.duration);this._rotate(~~(10*e)/10)}this._parameters.step&&this._parameters.step(this._angle);var s=this;this._timer=setTimeout(function(){s._animate.call(s)},10)}this._parameters.callback&&i&&(this._angle=this._parameters.animateTo,this._rotate(this._angle),this._parameters.callback.call(this._rootObj))},_rotate:function(){var t=Math.PI/180;return IE?function(t){this._angle=t,this._container.style.rotation=t%360+"deg",this._vimage.style.top=-(this._rotationCenterY-this._imgHeight/2)+"px",this._vimage.style.left=-(this._rotationCenterX-this._imgWidth/2)+"px",this._container.style.top=this._rotationCenterY-this._imgHeight/2+"px",this._container.style.left=this._rotationCenterX-this._imgWidth/2+"px"}:supportedCSS?function(t){this._angle=t,this._img.style[supportedCSS]="rotate("+t%360+"deg)",this._img.style[supportedCSSOrigin]=this._parameters.center.join(" ")}:function(i){this._angle=i,i=i%360*t,this._canvas.width=this._width,this._canvas.height=this._height,this._cnv.translate(this._imgWidth*this._aspectW,this._imgHeight*this._aspectH),this._cnv.translate(this._rotationCenterX,this._rotationCenterY),this._cnv.rotate(i),this._cnv.translate(-this._rotationCenterX,-this._rotationCenterY),this._cnv.scale(this._aspectW,this._aspectH),this._cnv.drawImage(this._img,0,0)}}()},IE&&(Wilq32.PhotoEffect.prototype.createVMLNode=function(){document.createStyleSheet().addRule(".rvml","behavior:url(#default#VML)");try{return!document.namespaces.rvml&&document.namespaces.add("rvml","urn:schemas-microsoft-com:vml"),function(t){return document.createElement("<rvml:"+t+' class="rvml">')}}catch(t){return function(t){return document.createElement("<"+t+' xmlns="urn:schemas-microsoft.com:vml" class="rvml">')}}}())}(jQuery);var angle=0;setInterval(function(){angle+=3,$("#img").rotate(angle)},50);
/*********************************ROTATE*********************************/
/***************************SHUFFLE***************************/
(function($){
    $.fn.shuffle = function() {
        var allElems = this.get(),
            getRandom = function(max) {
                return Math.floor(Math.random() * max);
            },
            shuffled = $.map(allElems, function(){
                var random = getRandom(allElems.length),
                    randEl = $(allElems[random]).clone(true)[0];
                allElems.splice(random, 1);
                return randEl;
           });
        this.each(function(i){
            $(this).replaceWith($(shuffled[i]));
        });
        return $(shuffled);
    };
})(jQuery);

$('.shuffle').each(function(){
$(this).find('div').shuffle();
});

$('.shuffle1').each(function(){
$(this).find('.shuffleopt').shuffle();
});
/***************************SHUFFLE***************************/
/******************************TIMER******************************/
function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor((t / 1000) % 60);
  var minutes = Math.floor((t / 1000 / 60) % 60);
  return {
    'total': t,
    'minutes': minutes,
    'seconds': seconds
  };
}

function initializeClock(id, endtime) {
  var clock = document.getElementById(id);
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');

  function updateClock() {
    var t = getTimeRemaining(endtime);
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

    if (t.total <= 0) {
      alert("Your time is up! \nPress OK to see the results");
      $("#submit2").trigger('click');
      clearInterval(timeinterval);
      return;
    }
  }
  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}

var minutes=30;   //enter number of minutes you want to set timer for
var deadline = new Date(Date.parse(new Date()) + minutes * 60 * 1000);
initializeClock('clockdiv', deadline);
/********************************TIMER********************************/
/***********************************ARE YOU SURE***********************************/
/*!
 * jQuery Plugin: Are-You-Sure (Dirty Form Detection)
 * https://github.com/codedance/jquery.AreYouSure/
 *
 * Copyright (c) 2012-2014, Chris Dance and PaperCut Software http://www.papercut.com/
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * Author:  chris.dance@papercut.com
 * Version: 1.9.0
 * Date:    13th August 2014
 */

 //function call at end of file
(function($) {
  
  $.fn.areYouSure = function(options) {
      
    var settings = $.extend(
      {
        'message' : 'You have unsaved changes!',
        'dirtyClass' : 'dirty',
        'change' : null,
        'silent' : false,
        'addRemoveFieldsMarksDirty' : false,
        'fieldEvents' : 'change keyup propertychange input',
        'fieldSelector': ":input:not(input[type=submit]):not(input[type=button])"
      }, options);

    var getValue = function($field) {
      if ($field.hasClass('ays-ignore')
          || $field.hasClass('aysIgnore')
          || $field.attr('data-ays-ignore')
          || $field.attr('name') === undefined) {
        return null;
      }

      if ($field.is(':disabled')) {
        return 'ays-disabled';
      }

      var val;
      var type = $field.attr('type');
      if ($field.is('select')) {
        type = 'select';
      }

      switch (type) {
        case 'checkbox':
        case 'radio':
          val = $field.is(':checked');
          break;
        case 'select':
          val = '';
          $field.find('option').each(function(o) {
            var $option = $(this);
            if ($option.is(':selected')) {
              val += $option.val();
            }
          });
          break;
        default:
          val = $field.val();
      }

      return val;
    };

    var storeOrigValue = function($field) {
      $field.data('ays-orig', getValue($field));
    };

    var checkForm = function(evt) {

      var isFieldDirty = function($field) {
        var origValue = $field.data('ays-orig');
        if (undefined === origValue) {
          return false;
        }
        return (getValue($field) != origValue);
      };

      var $form = ($(this).is('form')) 
                    ? $(this)
                    : $(this).parents('form');

      // Test on the target first as it's the most likely to be dirty
      if (isFieldDirty($(evt.target))) {
        setDirtyStatus($form, true);
        return;
      }

      $fields = $form.find(settings.fieldSelector);

      if (settings.addRemoveFieldsMarksDirty) {              
        // Check if field count has changed
        var origCount = $form.data("ays-orig-field-count");
        if (origCount != $fields.length) {
          setDirtyStatus($form, true);
          return;
        }
      }

      // Brute force - check each field
      var isDirty = false;
      $fields.each(function() {
        $field = $(this);
        if (isFieldDirty($field)) {
          isDirty = true;
          return false; // break
        }
      });
      
      setDirtyStatus($form, isDirty);
    };

    var initForm = function($form) {
      var fields = $form.find(settings.fieldSelector);
      $(fields).each(function() { storeOrigValue($(this)); });
      $(fields).unbind(settings.fieldEvents, checkForm);
      $(fields).bind(settings.fieldEvents, checkForm);
      $form.data("ays-orig-field-count", $(fields).length);
      setDirtyStatus($form, false);
    };

    var setDirtyStatus = function($form, isDirty) {
      var changed = isDirty != $form.hasClass(settings.dirtyClass);
      $form.toggleClass(settings.dirtyClass, isDirty);
        
      // Fire change event if required
      if (changed) {
        if (settings.change) settings.change.call($form, $form);

        if (isDirty) $form.trigger('dirty.areYouSure', [$form]);
        if (!isDirty) $form.trigger('clean.areYouSure', [$form]);
        $form.trigger('change.areYouSure', [$form]);
      }
    };

    var rescan = function() {
      var $form = $(this);
      var fields = $form.find(settings.fieldSelector);
      $(fields).each(function() {
        var $field = $(this);
        if (!$field.data('ays-orig')) {
          storeOrigValue($field);
          $field.bind(settings.fieldEvents, checkForm);
        }
      });
      // Check for changes while we're here
      $form.trigger('checkform.areYouSure');
    };

    var reinitialize = function() {
      initForm($(this));
    }

    if (!settings.silent && !window.aysUnloadSet) {
      window.aysUnloadSet = true;
      $(window).bind('beforeunload', function() {
        $dirtyForms = $("form").filter('.' + settings.dirtyClass);
        if ($dirtyForms.length == 0) {
          return;
        }
        // Prevent multiple prompts - seen on Chrome and IE
        if (navigator.userAgent.toLowerCase().match(/msie|chrome/)) {
          if (window.aysHasPrompted) {
            return;
          }
          window.aysHasPrompted = true;
          window.setTimeout(function() {window.aysHasPrompted = false;}, 900);
        }
        return settings.message;
      });
    }

    return this.each(function(elem) {
      if (!$(this).is('form')) {
        return;
      }
      var $form = $(this);
        
      $form.submit(function() {
        $form.removeClass(settings.dirtyClass);
      });
      $form.bind('reset', function() { setDirtyStatus($form, false); });
      // Add a custom events
      $form.bind('rescan.areYouSure', rescan);
      $form.bind('reinitialize.areYouSure', reinitialize);
      $form.bind('checkform.areYouSure', checkForm);
      initForm($form);
    });
  };

})(jQuery);

$(function() {
        $('#talquiz').areYouSure(
          {
            message: 'If you leave before submitting, your results will not be calculated.'
          }
        );
});
/***********************************ARE YOU SURE***********************************/