<!DOCTYPE html>
<html>
<script>
function myFunction() {
	if(document.getElementById("International_chk").checked)
	{
		 document.getElementById("myText").disabled = false;
	}else
	{
			document.getElementById("myText").disabled = true;
	}
}
</script>
<body>



Name: <input type="text" id="myText" disabled>



International ? <input type='checkbox' id="International_chk" name="International" onclick="myFunction();"></input>



</body>
</html>

