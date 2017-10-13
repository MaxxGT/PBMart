<?php
	include('header.php');
	$keywords = ucwords((isset($_POST['keywords']) ? $_POST['keywords'] : ''));
	$ky = ucwords((isset($_GET['ky']) ? $_GET['ky'] : ''));
	if($keywords !="")
	{
		header('Location: ?ky='.$keywords.'#'.$keywords);
	}
	
?>

<style>
a:focus, a:active {
    color: green;
}
</style>

<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","area.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>

<script>
var TRange=null;

function findString () {
var str = document.getElementById('keywords').value;
 if (parseInt(navigator.appVersion)<4) return;
 var strFound;
 if (window.find) {

  // CODE FOR BROWSERS THAT SUPPORT window.find

  strFound=self.find(str);
  if (!strFound) {
   strFound=self.find(str,0,1);
   while (self.find(str,0,1)) continue;
  }
 }
 else if (navigator.appName.indexOf("Microsoft")!=-1) {

  // EXPLORER-SPECIFIC CODE

  if (TRange!=null) {
   TRange.collapse(false);
   strFound=TRange.findText(str);
   if (strFound) TRange.select();
  }
  if (TRange==null || strFound==0) {
   TRange=self.document.body.createTextRange();
   strFound=TRange.findText(str);
   if (strFound) TRange.select();
  }
 }
 else if (navigator.appName=="Opera") {
  alert ("Opera browsers not supported, sorry...")
  return;
 }
 if (!strFound)
 {
	 if(document.getElementById('keywords').value=="")
	 {
		alert("Please fill in your address!");
	 }else{
		alert ("Area "+str+" could not be found!");
	 }
 return;
 }
}
</script>

<BR/>
<div id="playground">
<h1>PBMART SERVICES AREA</h1>
		<BR/>
	<div align='right'>	
		
		<form method="post" action="javascript:findString();"> 
		  
			<input type="search" id="keywords" name="keywords" size="35" style="height:27px" placeholder="Search your area..." autocomplete="off" value="<?php echo $ky; ?>" />
		
		<img src="css/images/toolbar_find.png" width='20px' height='20px' />
		</form>
	</div>
	
<BR/>
<font size='5'>
	93200	
</font>
<BR/><BR/>
<font size='3'>
	Jalan Rock, Taman Timberland<BR/>
	Jalan Sherip Masahor<BR/>
	Jalan Tong Wei Tah<BR/>
	Jalan Tong Wei Tah, Taman Iris<BR/>
	Jalan  Tai Tshin Jar<BR/>
	Lorong Tabuan Timur<BR/>
	Lorong Tabuan<BR/>
	Sunny Estate<BR/>
	Taman Hua Joo<BR/>
	Taman Iris<BR/>
	Taman Intersar<BR/>
	Taman Merlin<BR/>
	Taman Timberland<BR/>
</font>
<BR/><BR/>
<font size='5'>
	93250	
</font>
<BR/><BR/>
<font size='3'>
	Everbright Estate Km 5<BR/>
	Green Heights<BR/>
	Jalan Tawi<BR/>
	Jalan Kong Ping<BR/>
	Jalan Golden Farm<BR/>
	Jalan Airport Batu 7<BR/>
	Jalan Arang<BR/>
	Jalan Arang, Taman Flora Indah(Arang Flat)<BR/>
	Jalan Batu Kawa, Batu Kawah New Township<BR/>
	Jalan Batu Kawa, Rpr Batu Kawa<BR/>
	Jalan Batu Kawa, Taman Desa Wira<BR/>
	Jalan Batu Kawa, Tondong<BR/>
	Jalan Bau-batu Kawa, Pekan Batu Kawa<BR/>
	Jalan Bayan<BR/>
	Jalan Burong Landas<BR/>
	Jalan Burung Bunga Api<BR/>
	Jalan Burung Kawok<BR/>
	Jalan Burung Lilin<BR/>
	Jalan Burung Rawa<BR/>
	Jalan Datuk Stephen Yong<BR/>
	Jalan Dogan<BR/>
	Jalan Dogan Arang<BR/>
	Jalan Ensing<BR/>
	Jalan Everbright, Everbright Estate<BR/>
	Jalan Everbright Park, Everbright Park<BR/>
	Jalan Hup Kee<BR/>
	Jalan Kangking<BR/>
	Jalan Kangkok<BR/>
	Jalan Ketitir<BR/>
	Jalan Kung Phin<BR/>
	Jalan Lapangan Terbang<BR/>
	Jalan Semaba<BR/>
	Jalan Sherip Masahor<BR/>
	Jalan Stampin<BR/>
	Jalan Stampin Tengah<BR/>
	Jalan Stapok<BR/>
	Jalan Stutong<BR/>
	Jalan Stutong, Taman Height Estate<BR/>
	Jalan Stutong, Taman Satria Jaya BDC<BR/>
	Jalan Stapok Selatan, Kuching Sarawak<BR/>
	Jalan Stapok Utara Kuching Sarawak<BR/>
	Kampung Segedup Jalan Segedup<BR/>
	Kampung Semeba Jalan Semeba<BR/>
	Kampung Sinar Budi<BR/>
	Kampung Stapok Cina<BR/>
	Kampung Stapok<BR/>
	Lrg 2 Off Jalan Rock, Taman Timberland<BR/>
	Lrg 3 Off Jalan Seng Goon Garden, Taman Seng Goon<BR/>
	Lrg 5 Off Jalan Desa Wira, Taman Desa Bumiko<BR/>
	Metro Garden<BR/>
	Mjc Apartment & Condo Jalan Batu Kawa<BR/>
	Mjc Commercial Centre Jalan Batu Kawa<BR/>
	Resettlement Scheme Stapok<BR/>
	Stapok Avenue<BR/>
	Taman Pheonix<BR/>
	Taman Batu Kawa Heights<BR/>
	Taman Berjaya<BR/>
	Taman Bolder Built<BR/>
	Taman Bumiko<BR/>
	Taman Genesis<BR/>
	Taman Lian Hua<BR/>
	Taman Pheonix<BR/>
	Taman Mewah<BR/>
	Taman Metro<BR/>
	Taman Mei Lee<BR/>
	Taman Lok Thian<BR/>
	Taman Ultra<BR/>
	Taman Wui Lee<BR/>
	Taman Stapok<BR/>
	Taman Summerhill Villa Jalan Stapok Selatan<BR/>
	Taman Everbright Estate(Batu Kawa)<BR/>
	Taman Everbright Park<BR/>
	Taman Lung Foo<BR/>
	Taman Beautiful Jalan Field Force<BR/>
	Taman Borneo<BR/>
	Taman Capital<BR/>
	Taman Carina Estate<BR/>
	Taman Chung Nion<BR/>
	Taman Desa Moyan<BR/>
	Taman Green Heights<BR/>
	Taman Green Ville<BR/>
	Taman Greenvilla<BR/>
	Taman High Field Jalan Batu Kawa<BR/>
	Taman Home Mart<BR/>
	Taman Home Park<BR/>
	Taman How Ching<BR/>
	Taman Inspire<BR/>
	Taman Janting<BR/>
	Taman Kit Fah<BR/>
	Taman Kwong Tiong<BR/>
	Taman Lovely Land<BR/>
	Taman Megajuta<BR/>
	Taman Mjc Mutiara<BR/>
	Taman Moyan Utama<BR/>
	Taman Parkview<BR/>
	Taman Pearl<BR/>
	Taman Phoenix<BR/>
	Taman Putera Park<BR/>
	Taman Richmond Hill<BR/>
	Taman Royal<BR/>
	Taman Sakura Indah<BR/>
	Taman San Chin<BR/>
	Taman Sarmax<BR/>
	Taman Sasa<BR/>
	Taman Seng Goon<BR/>
	Taman Seri Emas<BR/>
	Taman Shefford View<BR/>
	Taman Shing Yu<BR/>
	Taman Spring Field<BR/>
	Taman Sri Moyan<BR/>
	Taman Sri Segedup<BR/>
	Taman Stapok Estate Jalan Stapok Selatan<BR/>
	Taman Sunny Heights<BR/>
	Taman Sunny Hill<BR/>
	Taman Tropimas<BR/>
	<a name="Taman Union"><?php if($ky=="Taman Union"){echo "<mark>"; } ?>Taman Union<?php if($ky=="Taman Union"){echo "</mark>"; } ?></a><BR/>
	<a name="Taman Victoria">Taman Victoria</a><BR/>
	<a name="Taman Victoria Jalan Satpok Utama">Taman Victoria Jalan Satpok Utama</a><BR/>
	<a name="Taman Wawasan">Taman Wawasan</a><BR/>
	<div id="Taman HDC(RPR Batu Kawa)"><?php if($ky=="Taman HDC(RPR Batu Kawa)"){echo "<mark>"; } ?>Taman HDC(RPR Batu Kawa)<?php if($ky=="Taman HDC(RPR Batu Kawa)"){echo "</mark>"; } ?></div><BR/>
</font>
<BR/><BR/>
<font size='5'>
	93350
</font>
<BR/><BR/>
<font size='3'>
	Jalan Upland<BR/>
	Jalan Keranji 1 - 6<BR/>
	Evergreen Heights<BR/>
	Jalan Bayor Bukit<BR/>
	Jalan Durian Burong<BR/>
	Jalan Hui Sing<BR/>
	Jalan Kampung Tabuan Dayak<BR/>
	Jalan Kedandi 11<BR/>
	Jalan Kedandi 14<BR/>
	Jalan Kempas<BR/>
	Jalan Laksamana Cheng Ho Lrg1, Lrg5<BR/>
	Jalan Muara Tabuan<BR/>
	Jalan Seladah<BR/>
	Jalan Setampin<BR/>
	Jalan Setia Raja<BR/>
	Jalan Setia Raja, Taman Sri Stutong<BR/>
	Jalan Setia Raja,  Samajaya Appartment<BR/>
	Jalan Setia Raja, Muara Tabuan Light Ind Park<BR/>
	Jalan Setia Raja, Sama Jaya Free Ind Zone<BR/>
	Jalan Setia Raja, Stutong Indah<BR/>
	Jalan Setia Raja, Tabuan Park<BR/>
	Jalan Setutong<BR/>
	Jalan Sherip Mansor<BR/>
	Jalan Song<BR/>
	Jalan Song, Tabuan Heights<BR/>
	Jalan Stampin<BR/>
	Jalan Stampin, Taman Hui Sing<BR/>
	Jalan Stampin Barat<BR/>
	Jalan Stampin Timur<BR/>
	Jalan Stutong<BR/>
	Jalan Stutong, Taman Satria Jaya Bdc<BR/>
	Jalan Stutong Indah<BR/>
	Jalan Stutong Jaya<BR/>
	Jalan Tabuan Dayak<BR/>
	Jalan Tabuan Jaya<BR/>
	Jalan Taman Hui Sing, Taman Hui Sing<BR/>
	Jalan Urat Mata<BR/>
	Jalan Urat Mata, Tabuan Jaya<BR/>
	Jalan Wan Alwi, Tabuan Jaya<BR/>
	Kampung Stampin<BR/>
	Kampung Tabuan Dayak<BR/>
	Kg Stutong<BR/>
	<a name="Kg Tabuan Dayak">Kg Tabuan Dayak</a><BR/>
	Kg Tabuan Jaya<BR/>
	Stampin<BR/>
	Tabuan Laru<BR/>
	Tabuan Dayak<BR/>
	Tabuan Dusun<BR/>
	Tabuan Heights<BR/>
	Tabuan Stutong Jalan Setia Raja<BR/>
	Taman Meranja<BR/>
	Taman Mersing<BR/>
	Taman Jelita<BR/>
	
	Taman BDC<BR/>
	Taman BDC Stampin<BR/>
	Taman Bahagia, Jalan Stampin<BR/>
	Taman Bayang<BR/>
	Taman Beverly Heights<BR/>
	Taman Casamarbela<BR/>
	Taman Cemerlang<BR/>
	Taman Centurion 1<BR/>
	Taman Centurion 2<BR/>
	Taman Daya<BR/>
	Taman Golden Height Lorong Hui Sing 6<BR/>
	Taman 7th Avenue Jalan Durian Burung<BR/>
	Taman Durian Burung Jalan Durian Burung<BR/>
	Taman Hui Sing<BR/>
	Taman Major<BR/>
	Taman Muara Tabuan<BR/>
	Taman Mubing<BR/>
	Taman Pelita Height Jalan Bdc<BR/>
	Taman Phoning<BR/>
	Taman Satria Jaya<BR/>
	Taman Sherie Mansor<BR/>
	Taman Sherip Mansor<BR/>
	Taman Sin Hai Min<BR/>
	<autofocus> Taman Sin Hai Min 1 </h2> <BR/>
	Taman Sin Hai Min 2<BR/>
	Taman Stampin Barat<BR/>
	Taman Stampin Heights<BR/>
	Taman Stutong Avenue<BR/>
	Taman Tabuan Desa<BR/>
	Taman Tabuan Dusun<BR/>
	Taman Tabuan Height Boulevard, Jalan Stutong<BR/>
	Taman Tabuan Height Drive, Jalan Stutong<BR/>
	Taman Tabuan Jaya<BR/>
	Taman Tabuan Jaya 1 & 2<BR/>
	Taman Tabuan Laru<BR/>
	Taman Woodland<BR/>
</font>

</div>
<script type="text/javascript">
function getfocus()
{
	alert('123');
    document.getElementById("href").click();
}

function losefocus() {
    document.getElementById("keywords").blur();
}
</script>


<script type="text/javascript" src="css/hilitor.js"></script>
<!--
<script type="text/javascript">
  var myHilitor2;

  document.addEventListener("DOMContentLoaded", function() {
    myHilitor2 = new Hilitor("playground");
    myHilitor2.setMatchType("left");
  }, false);

  document.getElementById("keywords").addEventListener("keyup", function() {
    myHilitor2.apply(this.value);
  }, false);

</script>
-->
<style>
	a{
		color:inherit;
		text-decoration:none;
	}
</style>


<BR/>
<BR/>
<BR/>

<?php
	include('footer.php');
?>