<script>
    hide()
	{	
		msg('123');
		document.getElementById('abc 1').style.display='none';
    }
</script>
   /* after that add html*/
   
   
    <html>
		<head>
			<title>...</title>
		</head>
		<body>
			<table border = 2>
				<tr>
					<td><input type='button' onclick='hide();' >2015</input></td>
				</tr>
				<tr id = "abc 1">
					<td>abcd</td>
				</tr>
				<tr id ="abc 2">
					<td>efgh</td>
				</tr>
			</table>
		</body>
    </html>