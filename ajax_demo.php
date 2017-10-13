<!-- http://stackoverflow.com/questions/8779845/javascript-setinterval-not-working -->
<script type="text/javascript">
    function upd()
    {
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
				document.getElementById("price_ajax").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","order_manage.php",true);
        xmlhttp.send();
    }
	upd();
	setInterval(upd, 10000);
</script>

<span id="price_ajax" />
