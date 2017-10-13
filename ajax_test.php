<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"> </script>
</head>
<body>
<div id="tableID">
 <?php include_once'ajax_test2.php'; ?>
</div>
	<script type='text/javascript'>
      var table = $('#tableID');
     // refresh every 5 seconds
     var refresher = setInterval(function(){
       table.load("ajax_test2.php");
     }, 5000);
     setTimeout(function() {
       clearInterval(refresher);
     }, 1800000);
	</script>
</body>
</html>