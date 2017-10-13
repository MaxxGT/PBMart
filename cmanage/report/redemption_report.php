<?php
//Authour: Voong Tze Howe
//Date Written: 13/11/2014
//Description: Monthly Sales Report
//Last Modification: 

include('../../connection/pbmartconnection.php');

if(isset($_POST['year']))
{
	$YEARS = $_POST['year'];
}else
{
	$YEARS ="";
}

if(isset($_POST['month_from']))
{
	$month_from	 = $_POST['month_from'];
}else
{
	$month_from	 ="";
}

if(isset($_POST['month_to']))
{
	$month_to = $_POST['month_to'];
}else
{
	$month_to ="";
}
?>

<script type="text/javascript">
	function x(integer)
	{
		if(integer == '0')
		{
			window.location='report_list.php';
		}else if(integer == '1')
		{
			
		}else
		{
			window.location='report_list.php';
		}
	}
</script>

<html>
	<head>
		<title>Report</title>
		
		 <meta charset="utf-8">
		  <title>Chosen: A jQuery Plugin by Harvest to Tame Unwieldy Select Boxes</title>
		  <!-- <link rel="stylesheet" href="docsupport/style.css"> -->
		  <link rel="stylesheet" href="../css/chosen/docsupport/prism.css">
		  <link rel="stylesheet" href="../css/chosen/chosen.css">
		  <style type="text/css" media="all">
			/* fix rtl for demo */
			.chosen-rtl .chosen-drop { left: -9000px; }
		  </style>
		
		
		
		
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/960.css" />
		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/text.css" />
		<link rel="stylesheet" type="text/css" href="../css/red.css" />
		<link type="text/css" href="../css/smoothness/ui.css" rel="stylesheet" /> 
			<script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/blend/jquery.blend.js"></script>
		<script type="text/javascript" src="../js/ui.core.js"></script>
		<script type="text/javascript" src="../js/ui.sortable.js"></script>    
		<script type="text/javascript" src="../js/ui.dialog.js"></script>
		<script type="text/javascript" src="../js/ui.datepicker.js"></script>
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/flot/jquery.flot.pack.js"></script>
		
		<script type="text/javascript">
			document.getElementById("myButton").onclick = function () {
				location.href = "report_list.php";
			};
		</script>
	</head>
	<body>
	<?php
include('../header/header.php');
?>
	<div class="grid_16">
		<!-- TABS START -->
		<div id="tabs">
			 <div class="container">
				<ul>
					<li><a href="../report/report.php?hyperlink=reports" class="current"><span>Generate Report</span></a></li>
					<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
			   </ul>
			</div>
		</div>
		<!-- TABS END -->    
	</div>	
	<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
				<p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../report/report.php?hyperlink=reports">Generate Report</a> >> <a href="../report/sale_report.php?hyperlink=reports">Sales Report</a></p>
			</div>
			<br />
		        <table border="0">
	                   <tr>
		               <td>&nbsp;</td>
	                   </tr>
                        </table>
						
	<form name="report_form" action="redemption_report_prcss.php" method="post">
		<table border="1" width="800px" class="box-table-a">
				
					<tr>
						<th colspan="4" align="center"><strong>Generate Monthly Redemption Report</strong></th>
					</tr>
				
					<tr>
						<th align="center">Year :</th>
						<td colspan="3">
							<select name="year" style="font-family: verdana; font-size: 12px;" onchange="autoSubmit()">
									<option value=""> - - SELECT - - </option>
									<?php
									$year = date("Y");
									$year--;
									for($i=0;$i<2;$i++)
									{ 
										
										if($year== $YEARS){ 
										   $sel = 'selected'; 
									} ?>
									<option value="<?=$year; ?>" <?php if(isset($sel)){echo $sel;} ?>><?=$year; ?></option>
									<?php 
									$year++; 	
									$sel= ""; 
									} ?>
							</select>
						</td>
					</tr>
					<tr>
						<th align="center">From :</th>
						<td>
							<select name="month_from" style="font-family: verdana; font-size: 12px;" onchange="autoSubmit()">
									<option value="">- -SELECT- -</option>
									<?php
									$monthVal="1";
									$SELECTED="";
									
									$months = array("JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER");
									//http://stackoverflow.com/questions/7020821/for-loop-for-each-month-of-year
									foreach ($months as $month)
									{
										if($monthVal == $month_from){
											$SELECTED = 'selected';
										} ?>
										<option value="<?=$monthVal++;?>" <?=$SELECTED?>> <?=$month;?></option>
										<?php
										$SELECTED="";
									} ?>
							</select>
							
						</td>
						
						<th align="center">To :</th>
						<td>
							<select name="month_to" style="font-family: verdana; font-size: 12px;" onchange="autoSubmit()">
									<option value="">- -SELECT- -</option>
									<?php
									$monthVal="1";
									$SELECTED="";
									
									$months = array("JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER");
									
									foreach ($months as $month)
									{
										if($monthVal == $month_to){
											$SELECTED = 'selected';
										} ?>
										<option value="<?=$monthVal++;?>" <?=$SELECTED?>> <?=$month;?></option>
										<?php
										$SELECTED="";
									} ?>
							</select>
						</td>
					</tr>
					
					
					
					<tr>
						<th align="center" colspan="4">
							<input name="btnSubmit" type="submit"  value="View Report" target="_new"></button>
							<input name="btnSubmit" type="submit"  Value="Generate PDF"></input>
						</th>
					</tr>
	</form>	
	</table>
			<br />						
			<br />
			<br />
				
				<?php
				include('../footer.php');
			?>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
  <script src="../css/chosen/chosen.jquery.js" type="text/javascript"></script>
  <script src="../css/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
	</body>
</html>