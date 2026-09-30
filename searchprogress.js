<!--

var task_ID = null;
var progress = 0;
var q;

//-----------------------------------------------------------------------------------------------------------------

function Ga(){
var a=null;

try{a=new ActiveXObject("Msxml2.XMLHTTP")}
catch(b){
try{a=new ActiveXObject("Microsoft.XMLHTTP")}
catch(c){a=null}}
if(!a&&typeof XMLHttpRequest!="undefined"){a=new XMLHttpRequest}
return a
}

function lb(a){

 if(q&&q.readyState!=0&&q.readyState!=4){q.abort()}
 q=Ga();
 if(q){
    q.open("GET",a,true);
    q.onreadystatechange = function(){
       if(q.readyState==4 && q.responseText){
          switch(q.status){
           //case 403:I=1000;break;
           //case 302:case 500:case 502:case 503:I++;break;
           case 200:
                r = q.responseText;
                if(task_ID != null){
                   if(r >= 0){
                      for(i=0;i<=100;i+=5){
                         e = document.getElementById("p"+i);
                         if(e.style.display != 'none')
                            e.style.display = 'none';
                      }
                      if(r > 0){
                         e = document.getElementById("p"+r);
                         e.style.display = 'block';
                      }
                      else{
                         e = document.getElementById("s_area");
                         e.style.display = 'block';
                      }
                      if(r > 0 && r < 100){
                         setTimeout('mprogress()',2000);
                      }
                      else{
                         showresults();
                      }
                   }
                   else aq();
                }
                else{
                   sa = document.getElementById("s_area");
                   if(e = document.getElementById("adv_area")) 
                      e.style.display = 'none';
                   if(e = document.getElementById("l_area")){
                      e.style.display = 'block';
                      if(r == '0')
                         e.innerHTML = '<font class="errortext"><p>Извините, сервис временно не доступен</p></font>';
                      else
                         e.innerHTML = r;
                   }
                   else if(sa.style.display != 'block')
                      alert('Поиск завершен. Результаты в разделе "Найти online"');
                   if(e = document.getElementById("p100"))
                      e.style.display = 'none';
                   sa.style.display = 'block';
                }
        break;
    }}};
    q.send(null);
}}

//-----------------------------------------------------------------------------------------------------------------

function mprogress(){

 lb('/search/progress.php?id=5&hash=' + Math.random());
}

//-----------------------------------------------------------------------------------------------------------------

function aq(){

 //alert('Сервис временно недоступен');
 for(i=0;i<=100;i+=5){
    if(e = document.getElementById("p"+i))
       e.style.display = 'none';
 }
 task_ID = null;
 lb('/search/abort.php?id=5&hash=' + Math.random());
}

//-----------------------------------------------------------------------------------------------------------------

function showresults(){

 lb('/search/sr.php?id=5&hash=' + Math.random());
 task_ID = null;
 //progress = 0;
}

//-----------------------------------------------------------------------------------------------------------------

function ph(){

 //alert("task_ID="+task_ID+", progress="+progress);

 e = document.getElementById("s_area");
 if(task_ID != null){
    if(e.style.display != 'none')
       e.style.display = 'none';
    mprogress();
 }
 else{
    if(e.style.display != 'block')
       e.style.display = 'block';
 }
 if(progress==100 && task_ID != null){
    showresults();
 }
}

//-->