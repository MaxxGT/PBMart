<!DOCTYPE html>
<html>
<head>
<title>Search Box Example 1</title>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<!-- CSS styles for standard search box -->
<style type="text/css">
	#tfheader{
		
	}
	#tfnewsearch{
		padding:20px;
	}
	.tftextinput{
		height: 25px;
		margin: 0;
		padding: 5px 15px;
		font-family: Arial, Helvetica, sans-serif;
		font-size:18px;
		border:1px solid #0076a3;
				
		border-top-left-radius: 5px 5px;
		border-bottom-left-radius: 5px 5px;
		border-top-right-radius: 5px 5px;
		border-bottom-right-radius: 5px 5px;
	}
	.tfbutton {
		height: 38px;
		margin: 0;
		padding: 5px 15px;
		font-family: Arial, Helvetica, sans-serif;
		font-size:14px;
		outline: none;
		cursor: pointer;
		text-align: center;
		text-decoration: none;
		color: #ffffff;
		border: solid 1px #0076a3; border-right:0px;
		background: #0095cd;
		background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
		background: -moz-linear-gradient(top,  #00adee,  #0078a5);
		border-top-left-radius: 5px 5px;
		border-bottom-left-radius: 5px 5px;
		border-top-right-radius: 5px 5px;
		border-bottom-right-radius: 5px 5px;
	}
	.tfbutton:hover {
		text-decoration: none;
		background: #007ead;
		background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
		background: -moz-linear-gradient(top,  #0095cc,  #00678e);
	}
	/* Fixes submit button height problem in Firefox */
	.tfbutton::-moz-focus-inner {
	  border: 0;
	}
	.tfclear{
		clear:both;
	}
</style>
</head>
<body>
	<!-- HTML for SEARCH BAR -->
	<div id="tfheader">
		<form id="tfnewsearch" method="get" action="http://www.google.com">
		    <center>
				<input type="text" class="tftextinput" name="q" size="80" maxlength="120">
				<input type="submit" value="Search" class="tfbutton">
			</center>
		</form>
	<div class="tfclear"></div>
	</div>
</body>
</html>

