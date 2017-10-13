var fImg ='<img alt="ERROR" src="img/exclamation.png">';
var sImg ='<img alt="OK" src="img/accept.png">';
var val = false;
function gE(i){
	return document.getElementById(i);
}
function valNumber(i, es,ix){
	iem =isNumber(i);
	gE(es).innerHTML = iem?sImg:fImg;
	ix.style.backgroundColor= iem?"":"#ffdddd";
	val=iem;
}
function valEmpty(i,es,ix){
	iem = !isEmpty(i);
	gE(es).innerHTML = iem?sImg:fImg;
	ix.style.backgroundColor= iem?"":"#ffdddd";
	val=iem;
}
function valDate(i, es, ix){
	var valid = true;
	var g = i.split("-");
	if (!isNumber(g[0])){
		valid = false;
	}
	if (!isNumber(g[1])){
		valid = false;
	}
	if (!isNumber(g[2])){
		valid = false;
	}
	gE(es).innerHTML = valid?sImg:fImg;
	ix.style.backgroundColor=valid?"":"#ffdddd";
	val=valid;
}
function valUsername(i, es, ix){
	var illegalChar =/[\W_]/;
	var valid = true;
	var Username = i;
	//"^[a-z0-9_-]{2,15}$"
//	Username = Username.replace(/^[\s]+/g,"");
	valid=!(illegalChar.test(Username));
//	alert(valid);
	gE(es).innerHTML = valid?sImg:fImg;
	ix.style.backgroundColor=valid?"":"#ffdddd";
	val=valid;
}
function isNumber(i){
	var valid = true;
	try{
		var n = parseInt(i,10);
		if (isNaN(n)){
			valid = false;
		}
	}catch(e){
		valid = false;
	}
	return valid;
}
function isEmpty(i){
	if((i.lenghth==0)||(i==null)){
		return true;
	}else{return false;}
}