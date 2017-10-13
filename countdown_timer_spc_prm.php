<!-- http://www.rmkwebdesign.com/Countdown_Timers/Samples.php -->
<style type="text/css">
.numbers {
    padding: 0px;
    text-align: right; 
    font-family: Arial; 
    font-size: 20px; 
    font-weight: bold;        /* options are normal, bold, bolder, lighter */
    font-style: italic;       /* options are normal or italic */
    color: #000000;     /* change color using the hexadecimal color codes for HTML */
	color: red;
}
</style>

<div id="form" style="position: relative; top: 3px;">
<table border="0">
    <tr>
        <td colspan="9"><div class="numbers" id="count2" style="text-align: center;"></div></td>
    </tr>
    <tr>
		<td width='100%'><font size='5' color='red'><i><B></B></i>&nbsp;</td>
        <td align="right"><div class="numbers" id="dday"></div></td>        
        <td align="left"><font size='4' color='red'><i><B><div class="title" id="days">&nbsp;Days</B></i>&nbsp;</div></td>
        <td align="right"><div class="numbers" id="dhour"></div></td>
        <td align="left"><font size='4' color='red'><i><B><div class="title" id="hours">&nbsp;Hours</B></i>&nbsp;</div></td>
        <td align="right"><div class="numbers" id="dmin"></div></td>
        <td align="left"><font size='4' color='red'><i><B><div class="title" id="minutes">&nbsp;Minutes</B></i>&nbsp;</div></td>
        <td align="right"><div class="numbers" id="dsec"></div></td>
        <td align="left"><font size='4' color='red'><i><B><div class="title" id="seconds">&nbsp;Seconds</B></i></div></td>
		</font>
    </tr>
</table>
</div>


<script type="text/javascript">

/*
Count down until any date script-
By JavaScript Kit (www.javascriptkit.com)
Over 200+ free scripts here!
Modified by Robert M. Kuhnhenn, D.O. 
on 5/30/2006 to count down to a specific date AND time,
and on 1/10/2010 to include time zone offset.
*/

/*  Change the items below to create your countdown target date and announcement once the target date and time are reached.  */
var current="Our Weekly Promotions is end now! More promotions are coming soon! Thank you for your support!";        //>enter what you want the script to display when the target date and time are reached, limit to 20 characters
var year=2016;        //>Enter the count down target date YEAR
var month=01;          //>Enter the count down target date MONTH
var day=12;           //>Enter the count down target date DAY
var hour=11;          //>Enter the count down target date HOUR (24 hour clock)
var minute=00;        //>Enter the count down target date MINUTE
var tz=-5;            //>Offset for your timezone in hours from UTC (see http://wwp.greenwichmeantime.com/index.htm to find the timezone offset for your location)

//>    DO NOT CHANGE THE CODE BELOW!    <
var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

function countdown2016(yr,m,d,hr,min)
{
	theyear=yr;themonth=m;theday=d;thehour=hr;theminute=min;
	var today=new Date();
	var todayy=today.getYear();
	if (todayy < 1000) {
	todayy+=1900; }
	var todaym=today.getMonth();
	var todayd=today.getDate();
	var todayh=today.getHours();
	var todaymin=today.getMinutes();
	var todaysec=today.getSeconds();
	var todaystring1=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec;
	var todaystring=Date.parse(todaystring1)+(tz*1000*60*60);
	var futurestring1=(montharray[m-1]+" "+d+", "+yr+" "+hr+":"+min);
	var futurestring=Date.parse(futurestring1)-(today.getTimezoneOffset()*(1000*60));
	var dd=futurestring-todaystring;
	var dday=Math.floor(dd/(60*60*1000*24)*1);
	var dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1);
	var dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);
	var dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
	if(dday<=0&&dhour<=0&&dmin<=0&&dsec<=0)
	{
		alert(current);
		window.location.replace("index.php?hyperlink=home");
		
		//document.getElementById('count2').innerHTML=current;
		document.getElementById('count2').style.display="block";
		document.getElementById('count2').style.width="390px";
		document.getElementById('dday').style.display="none";
		document.getElementById('dhour').style.display="none";
		document.getElementById('dmin').style.display="none";
		document.getElementById('dsec').style.display="none";
		document.getElementById('days').style.display="none";
		document.getElementById('hours').style.display="none";
		document.getElementById('minutes').style.display="none";
		document.getElementById('seconds').style.display="none";
		return;
	}else{
	document.getElementById('count2').style.display="none";
	document.getElementById('dday').innerHTML=dday;
	document.getElementById('dhour').innerHTML=dhour;
	document.getElementById('dmin').innerHTML=dmin;
	document.getElementById('dsec').innerHTML=dsec;
	setTimeout("countdown2016(theyear,themonth,theday,thehour,theminute)",1000);
	}
}

countdown2016(year,month,day,hour,minute);

</script>