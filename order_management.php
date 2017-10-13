<script>
(function () {

var original = "(1)PBMART ORDER";
var timeout;

window.flashTitle = function (newMsg, howManyTimes) {
    function step() {
        document.title = (document.title == original) ? newMsg : original;

        if (--howManyTimes > 0) {
            timeout = setTimeout(step, 1000);
        };
    };

    howManyTimes = parseInt(howManyTimes);

    if (isNaN(howManyTimes)) {
        howManyTimes = 5;
    };

    cancelFlashTitle(timeout);
    step();
};

window.cancelFlashTitle = function () {
    clearTimeout(timeout);
    document.title = original;
};

}());

flashTitle("OR000123", 10); // toggles it 10 times.
</script>

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