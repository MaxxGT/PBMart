<script type="text/javascript">
    function showUser(str)
    {
        if (str=="")
          {
          document.getElementById("q").innerHTML="";
          return;
          } 
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
          {
				document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","acc.php?q="+str,true);
        xmlhttp.send();
    }
</script>

<body>
<input type="text" name="q" id="q" onchange='showUser(this.value);'></input>
<div id="myDiv">
Text Display here...
</div>
</body>