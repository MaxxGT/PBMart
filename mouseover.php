<style>
a.tooltip {outline:none; }
a.tooltip strong {line-height:30px;}
a.tooltip:hover {text-decoration:none;} 
a.tooltip span {
    z-index:10;display:none; padding:14px 20px;
    margin-top:60px; margin-left:-0px;
    width:300px; line-height:16px;
}
a.tooltip:hover span{
    display:inline; position:absolute; 
    border:2px solid #FFF;  color:#EEE;
    background:#333 url(cssttp/css-tooltip-gradient-bg.png) repeat-x 0 0;
}
.callout {z-index:20;position:absolute;border:0;top:-14px;left:120px;}
    
/*CSS3 extras*/
a.tooltip span
{
    border-radius:2px;        
    box-shadow: 0px 0px 8px 4px #666;
    /*opacity: 0.8;*/
}
</style>

<!--Second tooltip-->
<a href="#" class="tooltip">
    <img src="css/images/info2.png" />
    <span>
        <strong>ORDER INFO</strong><br />
        1 x 26.60 = 26.60<br />
		Handling  =  3.40<br />
		======== 30.00
    </span>
</a>