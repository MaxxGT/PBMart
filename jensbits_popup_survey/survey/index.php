<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Survey Test</title>
<style type="text/css" media="screen">
body {background-color: #efefef;font-family: "Trebuchet MS",sans-serif;font-size: 16px;}
h1,h2,p {padding: 5px;}
h1,h2{font-size: 18px; color: #666666;}
.container {width: 50%;margin-left: 25%;margin-top:2%;background: #ffffff;border: 4px solid #cccccc;}
#survey,#survey_thanks{font-size:80%}
p#surveyDenied{text-align:right;color: #cc0202;margin: 0;padding:0;}
p#surveyDenied a{color:#cc0202;}
div#error_message{font-weight:bold;color: #FF0000}

div.progress-container {
  border: 1px solid #ccc; 
  width: 150px; 
  padding: 1px; 
  margin-bottom: 5px;
  background: white;
}

div.progress-container > div {
  height: 12px;
  margin-bottom: 2px;
}
div.progress-container > div.pink { 
  background-color:#CC6699; 
}
div.progress-container > div.blue { 
  background-color: #3366CC; 
}
div.progress-container > div.soccer { 
  background-color: #006633; 
}
div.progress-container > div.futbol { 
  background-color: #663333; 
}
</style>
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css">

<script language="javascript" type="text/javascript" src="js/jquery-1.4.min.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script language="javascript" type="text/javascript">
$().ready( function () {

	$(function(){  
			$('#survey').dialog({
				bgiframe: true,
				autoOpen: false,
				modal: true,
				width: 500,
				resizable: false,
				buttons: {
					Submit: function(){
						if($("input[name='radio_color']:checked").val() !== undefined && $("input[name='radio_sport']:checked").val() !== undefined){
							setCookie('POPsurvey','POPsurvey',30);
							$.post("process_survey.php", $("#popup_survey").serialize(),
							function(data){
								if(data.db_check == 'fail'){
									$("#error_message").html("<p>Database not available. Please try again.</p>");
								} else {
									$("div.pink").css("width",data.perPink);
									$(".perPink").html(data.perPink + "% (" + data.totalPink + ")");
									
									$("div.blue").css("width",data.perBlue);
									$(".perBlue").html(data.perBlue + "% (" + data.totalBlue + ")");
									
									$("div.soccer").css("width",data.perSoccer);
									$(".perSoccer").html(data.perSoccer + "% (" + data.totalSoccer + ")");
									
									$("div.futbol").css("width",data.perFutbol);
									$(".perFutbol").html(data.perFutbol + "% (" + data.totalFutbol + ")");
									
									$(".totalRes").html(data.totalRes);
									
									$('#survey').dialog('close');
									$('#survey_thanks').dialog('open');
								}
								}, "json");
						}else{
							$("#error_message").html("<p>Please answer all questions.</p>");
						}
					}
				}
			});
		});
		
	$(function(){  
			$('#survey_thanks').dialog({
				bgiframe: true,
				autoOpen: false,
				modal: true,
				width: 500,
				resizable: false,
				buttons: {
					Close: function(){
						$(this).dialog('close');
						}
					}
			});
		});

	$('.surveyCookieDelete').click(function() {		
		deleteCookie('POPsurvey');
		alert('Survey cookie cleared. Hit Refresh to see the survey again.');
	});
	
	$('p#surveyDenied a').click(function() {
		setCookie('POPsurvey','POPsurvey',30);
		//ajax to count denials??
		$('#survey').dialog('close');
	});
	
	$('#thanksClose').click(function() {
		$('#survey_thanks').dialog('close');
	});
	
	checkCookie('POPsurvey');	

});

function setCookie(c_name,value,expiredays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
} 
function getCookie(c_name)
{
	if (document.cookie.length>0)
	  {
	  c_start=document.cookie.indexOf(c_name + "=");
	  if (c_start!=-1)
		{
		c_start=c_start + c_name.length+1;
		c_end=document.cookie.indexOf(";",c_start);
		if (c_end==-1) c_end=document.cookie.length;
		return unescape(document.cookie.substring(c_start,c_end));
		}
	  }
	return "";
}

function checkCookie(c_name)
{
	cookie_value=getCookie(c_name);
	if (cookie_value=="") {
		$('#survey').dialog('open');
	}
	  
}

function deleteCookie(c_name) {
	document.cookie = c_name +'=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
} 

</script>
<script type="text/javascript">
//if you copy source, please delete the Google Analytics tracking code before posting on your server.
//Thanks, Jen
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-4945154-2']);
  _gaq.push(['_setDomainName', 'none']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_trackEvent', 'Demo', 'View', '/demos/survey/index.php' ]);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
  })();
</script>
</head>

<body>
	<div class="container">
		<div id="survey" title="Special Promotions Terms of Use">
				<B>Special Promotions Terms & Conditions:</B><BR/>
				<p>1. </p>
				<p>2. </p>
				<p>3. </p>
				<input type="checkbox" name="btnChk" value='1'>I accept the Terms and Conditions. <font color='red'>*</font></input>
		</div>
	</div>
</body>
</html>