var brname=navigator.appName, BrVer='';
if(brname.substring(0,2)=="Mi")
	BrVer='E';
var timer = 0;
lastid = -1;

function show(id)
{
	if(!((document.all)?document.all['menu'+id]:document.getElementById('menu'+id)))
		return;
	clearTimeout(timer);
	if((id != lastid) && (lastid!=-1))
		((document.all)?document.all['menu'+lastid]:document.getElementById('menu'+lastid)).style.visibility = 'hidden';
	hideElement("SELECT", document.getElementById('menu'+lastid));
	lastid = id;
	((document.all)?document.all['menu'+lastid]:document.getElementById('menu'+lastid)).style.visibility = 'visible';
}

function hidden(id)
{
	if(!((document.all)?document.all['menu'+id]:document.getElementById('menu'+id)))
		return;
	showElement("SELECT");
	timer = setTimeout("if('"+id+"' == '"+lastid+"'){((document.all)?document.all['menu"+lastid+"']:document.getElementById('menu"+lastid+"')).style.visibility = 'hidden';}", 500)
}


function GetPos(el)
{
	if (!el || !el.offsetParent)return false;
	var res=Array()
	res["left"] = el.offsetLeft;
	res["top"] = el.offsetTop;
	var objParent = el.offsetParent;
	while (objParent.tagName.toUpperCase()!="BODY")
	{
		res["left"] += objParent.offsetLeft;
		res["top"] += objParent.offsetTop;
		objParent = objParent.offsetParent;
	}
	res["right"]=res["left"]+el.offsetWidth;
	res["bottom"]=res["top"]+el.offsetHeight;
	return res;
}

function hideElement(elName, Menu)
{
	if(BrVer!='E') return;
	for (i = 0; i < document.all.tags(elName).length; i++)
	{
		Obj = document.all.tags(elName)[i];
		if(!(pMenu=GetPos(Menu)))continue;
		if(!(pObj=GetPos(Obj)))continue;

		if(pObj["left"]<pMenu["right"] && pMenu["left"]<pObj["right"] && pObj["top"]<pMenu["bottom"] && pMenu["top"]<pObj["bottom"])
			Obj.style.visibility = "hidden";
	}
}

function showElement(elName)
{
	if(BrVer!='E') return;
	for (i = 0; i < document.all.tags(elName).length; i++)
	{
		obj = document.all.tags(elName)[i];
		if (!obj || !obj.offsetParent)continue;
		if(obj.style.visibility=="hidden")
			obj.style.visibility = "visible";
	}
}
