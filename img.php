<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>

<base href="http://www.coothead.co.uk/images/">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="language" content="english"> 
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">

<title></title>

<style type="text/css">
body {
    background-color:#333;
 }
ul {
    margin:50px 0 0 50px;
    padding:0;
    list-style-type:none;
 }
li {
    position:relative;
    clear:both;
    margin:10px 0;
 }
.thumb {
    display:block;
    border:2px solid #000;
    cursor:pointer;
 }
.big{
    position:absolute;
    border:5px double #000;
    display:none;
 }
#p0 {border-color:#f00;}
#p1 {border-color:#e1e5c4;}
#p2 {border-color:#5dacfb;}
#p3 {border-color:#f93;}
#p4 {border-color:#7fbe32;}
</style>

<script type="text/javascript">

function init(){

   thb=document.getElementsByTagName('img');
                                                
for(c=0;c<thb.length;c++) {
if(thb[c].className=='thumb') {
   thb[c].number=c;
   thb[c].onmouseover=function() { 

   el=this;

   pic=document.createElement('img');
   pic.setAttribute('src',this.src.split('_thumb')[0]+'.jpg');
   pic.setAttribute('id','p'+this.number);
   pic.className='big';

   document.body.appendChild(pic);

   obj=document.getElementById('p'+this.number);

this.onmouseout=function() {
   document.body.removeChild(pic);
 }
if(window.addEventListener){
   this.addEventListener('mousemove',curPos,false)
 }
else { 
if(window.attachEvent){
   this.attachEvent('onmousemove',curPos);
      }
     }
    }
   }
  }
 }

function curPos(event) {
   
   l=event.clientX
   t=event.clientY;
   w=l-el.offsetLeft;
   h=t-el.offsetTop;

if(/*@cc_on!@*/false){
   obj.style.top=(h+10)+'px';
   obj.style.left=(w+10)+'px';
   obj.style.display='block';
 }
else{
   obj.style.top=(h+12)+'px';
   obj.style.left=(w+12)+'px';
   obj.style.display='block';
  }
 }
   var preloads=[];

function preload(){
for(var c=0;c<arguments.length;c++) {
   preloads[preloads.length]=new Image();
   preloads[preloads.length-1].src=arguments[c];

  }

 }
   preload('blood.jpg','buddha.jpg','girl.jpg','grap.jpg','apple.jpg');

if(window.addEventListener){
   window.addEventListener('load',init,false);
 }
else { 
if(window.attachEvent){
   window.attachEvent('onload',init);
  }
 }
</script>

</head>
<body>

<ul>
 <li><img class="thumb" src="blood_thumb.jpg" alt=""></li>
 <li><img class="thumb" src="buddha_thumb.jpg" alt=""></li>
 <li><img class="thumb" src="girl_thumb.jpg" alt=""></li>
 <li><img class="thumb" src="grap_thumb.jpg" alt=""></li>
 <li><img class="thumb" src="apple_thumb.jpg" alt=""></li>
</ul>

</body>
</html>