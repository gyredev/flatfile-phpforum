/*******************************************/
/*
 * 
*/
/*******************************************/

  
function fmt(s,a) {
	return s.replace(/\{([0-9]+)\}/g, function(x) { return a[x[1]]; });
}

function ago($timestamp) {
	
        var $difference = $timestamp - (Date.now()/1000)|0, $num;
var $difference=($difference)*-1;

		
        switch(true){
        case ( $difference < 60):
if($difference < 0 && $difference < -60) {
 var $difference=(60+$difference);
}
 return "" + $difference + ' ' + ('second(s) ago');
        case ($difference < 3600): //60*60 = 3600
                return "" + ($num = Math.round(10*($difference/(60)))/10) + ' ' + ('minute(s) ago');
        case ($difference < 86400): //60*60*24 = 86400
                return "" + ($num = Math.round(10*($difference/(3600)))/10) + ' ' + ('hour(s) ago');
        case ($difference < 2592000): //60*60*24*30 = 2592000
                return "" + ($num = Math.round(10*($difference/(86400)))/10) + ' ' + ('day(s) ago');
        case ($difference < 31536000): //60*60*24*365 = 31536000
                return "" + ($num = Math.round(10*($difference/(2592000)))/10) + ' ' + ('month(s) ago');
        default:
                return "" + ($num = Math.round(10*($difference/(31536000)))/10) + ' ' + ('year(s) ago');
        }
}

function SetCookie(cookieName,cookieValue,nDays) {
 var today = new Date();
 var expire = new Date();
 if (nDays==null || nDays==0) nDays=1;
 expire.setTime(today.getTime() + 3600000*24*nDays);
 document.cookie = cookieName+"="+escape(cookieValue)
                 + ";expires="+expire.toGMTString();
}
function readCookie(cookieName) {
 var re = new RegExp('[; ]'+cookieName+'=([^\\s;]*)');
 var sMatch = (' '+document.cookie).match(re);
 if (cookieName && sMatch) return unescape(sMatch[1]);
 return '';
}

function insertAtCaret(textAreaId, text) {
    var textArea = document.getElementById(textAreaId);
    var cursorPosition = textArea.selectionStart;
    addTextAtCursorPosition(textArea, cursorPosition, text);
    updateCursorPosition(cursorPosition, text, textArea);
}
function addTextAtCursorPosition(textArea, cursorPosition, text) {
    var front = (textArea.value).substring(0, cursorPosition);
    var back = (textArea.value).substring(cursorPosition, textArea.value.length);
    textArea.value = front + text + back;
}
function updateCursorPosition(cursorPosition, text, textArea) {
    cursorPosition = cursorPosition + text.length;
    textArea.selectionStart = cursorPosition;
    textArea.selectionEnd = cursorPosition;
    textArea.focus();    
}

 
function parseRSS(url, callback) {
	
	$.getJSON("http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&callback=?"+ encodeURIComponent(url), {
    num: 10,
    q: url,
	data: data
})
.done(function() { document.write(data); })
.fail(function() {   })
.always(function() {  });


	/*
$.ajax({
           type: 'GET',
           url: url,
           processData: true,
           data: {},
           dataType: "json",
           success: function (data) {
               alert(data);
           }
});
 */

    
    
}



function commands(x,y,z) {
var ss='';

	//toggle commands
					if (x!=null) {
					
					
						if (x=='x') {
							var ss=prompt('Type command 1-100. 0=bliz player, 2=repeat youtube vid, 3=maps','0');
						
						
						}else{
							var ss=x;
						}
						
		
		switch(ss) {
			
				case 'report':

				
				var m = "administrator"
  var mailto_link = 'mailto:' + m +'@gyrereality.byethost18.com?subject=Reporting post #'+y+'&body='+location.href+'#'+y+'\r\n';
  window = window.open(mailto_link, 'emailWindow');
//  if (window && window.open && !window.closed)     
    //  window.close()
 break;
			
		case '0':
		window.open('http://classic.battle.net/window.shtml');
		
		break;
			
			
			case '1':
				window.open('http://www.shoutcast.com/');
			
			break;
			
			case '2':
				var s=prompt('paste youtube url','');
				var s=s.replace('https://www.youtube.com/watch?v=',''); 
				window.open('https://listenonrepeat.com/?v='+s);
			//window.open('http://www.youtube.com/v/'+s+'?version=3&loop=1&playlist='+s);
			
			break;
				case '3':
				window.open('http://maps.google.com');
				
				break;
				
		}
						
						
						return;
					}

}


function changeoption(a,z){
	var id0=$("footer");
	
	var option='';
	var option=window.$('#changeoption').val();
	if (option=='' && a!='loadcss') {

	return false;
	}
	
		
		
	if (option=='nostyle' && a!='loadcss') {
		$('#stylesheet').html('<style>#comment,textarea {  width:100%; height:220px; }</style>');
$('#stylesheet').attr('href', '');
SetCookie('stylesheet','nostyle',4);
	return false;	
	}
	
	
	
	if (a=='loadcss' && readCookie('stylesheet').length>2) {
		//get saved cookie theme
		$('#stylesheet').attr('href', 'res/'+readCookie('stylesheet')+'.css');
		return true;
	}


// prevent option error type
if (option!=null) {
		if (option.length>2) {
		$('#stylesheet').attr("href", 'res/'+option+'.css');
		SetCookie('stylesheet',option,365);
		}else{
			//private browsing or noscript
		}

}


}





window.replytoggled=1;

function reply(n,f){


	var id0=$("#"+n).closest(".post");
id0.addClass("highlightquote");
	var id00=$("#"+n).closest(".post0");
id00.addClass("highlightquote");

if (window.replytoggled==1) {
id00.append(" <div id='repliedposting' class='postform'>[replying to this post] <input type='button' value='Report Post ["+n+"]' onclick='commands(\"report\","+n+");'><br />"+$(".postform").html()+"</div>");

id0.append(" <div id='repliedposting' class='postform'>[replying to this post] <input type='button' value='Report Post ["+n+"]' onclick='commands(\"report\","+n+");'><br />"+$(".postform").html()+"</div>");


if (window.newinput==0) {
var out=''; 
if (readCookie('savecomm').length>=3) { var out='\r\n'+readCookie('savecomm'); }

	 window.newinput=1; $("#comment").val("[#]"+n+"[/#]\r\n"+out);
}else{
$("#comment").val("[#]"+n+"[/#]\r\n"+readCookie('savecomm'));
}


$("#name").val(readCookie('name'));
		setTimeout(function(){ SetCookie('savecomm',$('#comment').val(),365);}, 1500);
	


//$(".postform").detach().appendTo(".repliedposting");



/*
$(".postform").css("position","absolute");

$(".postform").css("overflow","auto");

$(".postform").addClass("transparent_class");
$(".postform").css("right","10px");
$(".postform").css("top",$(window).scrollTop()+0+"px");		

$(".postform").css("backgroundColor","#000000");
$(".postform").css("color","#aaaaaa");


$("#comment").css("height","77px");
$("#comment").css("width","90%");

$(".postform").css("width","24%");
$(".postform").css("min-width","226px");

$(".postform").css("height","288px");

$(".postform").append( "<a id='down' style='' href='#bottom'>&darr; &darr; &darr;</a>" );
*/
window.replytoggled=0;
}else{
window.replytoggled=1;


$('#repliedposting').remove();


$("#comment").val(readCookie('savecomm'));

$(".post").removeClass("highlightquote");
$(".post0").removeClass("highlightquote");
/*$(".postform").css("position","");

$(".postform").css("top","0");

$(".postform").css("right","0");

$(".postform").attr("style","overflow:visible;");

$(".postform").css("color","");
		
$(".postform").css("display","block");

$(".postform").removeClass("transparent_class");
$(".postform").css("backgroundColor","");
$("#down").remove();


$("#comment").css("height","");
$("#comment").css("width","");
*/

}


}

function bbcode(n,x,y){
	//var comment=$('post'+n).html();

	$('#comment').val($('#comment').val()+" "+x+n+y+"");
			setTimeout(function(){ SetCookie('savecomm',$('#comment').val(),365);}, 1500);
	
}


window.newinput=0;
function savecomm(e,n) {
 
//and properly parse for linkify cpaste
var str=$('#comment').val();
   var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
 
	if (key==118 || n=='118'){
	

				setTimeout(function(){ SetCookie('savecomm',$('#comment').val(),365);}, 2500);
	
	//doesnt work when caret pasted before end string
	//must remove ending fslash.

		 setTimeout(function () {
			 
			

if (str!=$('#comment').val()) {

var p=$('#comment').val().replace(str,'');

var trailin=p.substr(p.length-1);

if (  trailin=='/') {

	$('#comment').val('');
 insertAtCaret('comment',''+str+'\r\n '+p);

}else if (p.substr(0,3)=='htt' ) {
	$('#comment').val('');
  insertAtCaret('comment',''+str+'\r\n '+p);


}

 
		}
   
  }, 400);

  

	}
	
	
	if (n=='savename') {
		setTimeout(function(){ SetCookie('name',$('#name').val(),700);}, 1000);
	}
	
	if (n=='save') {
		setTimeout(function(){ SetCookie('savecomm',$('#comment').val(),365);}, 1000);
	if (e!==0 && e!=null) { window.newinput=1; }
	}
	
}



	window.xx=0;
window.yy=0;
function postinit_hover(n,status){
	//float raw text box with transparent class

		var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();

var pos=( scrollPosition -scrollHeight );

 window.xx=0;
  window.yy=0;
	$( "#"+n ).mouseover(function(e) {
      var posX = $(this).offset().left,
            posY = $(this).offset().top;
            
   window.xx=(e.pageX - posX);
     window.yy=e.pageY - posY;

});
if (status==2){
			window.setTimeout("$('#"+n+"').addClass(\"highlightquote\")",200);

			window.setTimeout("$('#"+n+"').removeClass(\"highlightquote\")",9700);

	return;
}
if (status==1){
	
	$( "#view"+n ).remove();
	return;
}

	var content=$('#'+n+'').html();

//prevent being close to link overlapping
if (pos<=70){
	window.xx+=300;
	window.yy+=250;

}else{
		window.xx+=144;
	window.yy=pos+300;

}

$( "body" ).append('<div class="post highlightquote" style="z-index:5;max-height:200px; max-width:400px;overflow:hidden;position:absolute;top:'+(window.yy)+';left:'+(window.xx)+';" id="view'+n+'">'+content+'</div>');




}


//////////////////////////////////////
//post page only initial


function postinit() {
	var length=1+$('.post').length;
	document.title=document.title+' ['+length+']';
	
	
	var id0=$(".post0").closest(".post0").attr("id");
	$('.'+id0+'reply').each(function(c) {

	if ($('.'+id0+'reply').length>0) {
	var id00=$(this).closest(".post").attr("id");
	var content=$('#'+id00+'').html();

	$('#'+id0+'').html($('#'+id0+'').html()+' &uarr; <a style="cursor:pointer;" onclick="postinit_hover('+id00+',2);" onmouseout="postinit_hover('+id00+',1);" onmouseover="postinit_hover('+id00+',0);" href="#'+id00+'"><<'+id00+'</a> ');
					}
		
		});


	$('.post').each(function(c) {

	var id=$(this).closest(".post").attr("id");
	
	$('.'+id+'reply').each(function(c) {

	if ($('.'+id+'reply').length>0) {
	var id2=$(this).closest(".post").attr("id");
	$('#'+id+'').html($('#'+id+'').html()+' &uarr; <a style="cursor:pointer;" onclick="postinit_hover('+id2+',2);" onmouseout="postinit_hover('+id2+',1);" onmouseover="postinit_hover('+id2+',0);" href="#'+id2+'"><<'+id2+'</a> ');
					}
		
		});
		
		
		});
			
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 // some code..
$("#name").val(readCookie('name'));
$(".post").removeClass("highlightquote");
$(".post0").removeClass("highlightquote");
 return;
 }

	$(window).on("scroll", function() {
	var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();

var pos=( scrollPosition -scrollHeight );

if ( window.replytoggled==0 && (pos+1111)<scrollHeight ) {
    //$(".postform").css("top",$(window).scrollTop()+"px");


}else {

window.replytoggled=1;
$('#repliedposting').remove();

//THIS FALSLY REVERTS WHEN PASTED CONTENT IS PUT IN
//if (window.newinput==1) {$("#comment").val(readCookie('savecomm'));}
$("#name").val(readCookie('name'));
$(".post").removeClass("highlightquote");
$(".post0").removeClass("highlightquote");

/*$(".postform").css("position","");

$(".postform").css("top","0");

$(".postform").css("right","0");

$(".postform").attr("style","overflow:visible;");

$(".postform").css("color","");
		
$(".postform").css("display","block");

$(".postform").removeClass("transparent_class");

$(".postform").css("backgroundColor","");
$("#down").remove();


$("#comment").css("height","");
$("#comment").css("width","");
* 
*/
}});


	


}







//////////////////////////////////////
//global initial



function togglemenu() {
				

	var a=$("#togglemenu");
if (a.html()=='') {

		$("#togglemenu").html('<a href="" target="_blank"></a> | <a href="http://185.27.132.238/roundcubemail/?i=1" target="_blank">admin email</a> | <br><br> <input type="button" value="commands" onclick="commands(\'x\');">');

							

		
	}else{
		$("#togglemenu").html('');
	}
}

	if (readCookie('name')!=null) {
		window.setTimeout("$('#name').val(readCookie('name'))",200);

	}
	if (readCookie('stylesheet')!=null) {
	
window.setTimeout("window.changeoption('loadcss')",200);


	}
	//force go to post id
	var postid=window.location.href.split('#'); 
	if ( postid[1]>0) {
		
		
window.setTimeout("window.location.href=window.location.href;",500);

    


    
	}


$( document ).ready(function(){
	var do_embed_yt = function(tag) {
		$('div.video-container a', tag).click(function() {
			var videoID = $(this.parentNode).data('video');
				$(this.parentNode).html('<iframe type="text/html" '+
				'width="360" height="270" src="//www.youtube.com/embed/' + videoID +
				'?autoplay=1&html5=1" allowfullscreen frameborder="0"/>');

			return false;
		});
	};
	do_embed_yt(document);

        // allow to work with auto-reload.js, etc.
        $(document).on('new_post', function(e, post) {
                do_embed_yt(post);
        });
});






//check for mobile device or by small width screen


