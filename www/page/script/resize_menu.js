var Gmenu,Gentete,Gpav,Glogo;
function resizePav(){
 if (Gentete.offsetWidth < 783) {
  Gpav.style.width=Gentete.offsetWidth+'px';
  Glogo.style.width=Gpav.offsetWidth/5.2+'px';
 }
 else {
  Gpav.style.width='783px';
  Glogo.style.width='150px';
 }
 Gentete.style.height=Gpav.offsetHeight+'px';
}
function initPav(){
 Gentete=document.getElementById('entete');
 Gpav=document.getElementById('pavillon');
 Glogo=document.getElementById('logoevt');
 resizePav();
}
function resizeMenu(){
 if (Gmenu.offsetWidth < 377)
  Gmenu.style.height='220px'; // 6
 else if (Gmenu.offsetWidth < 630)//515
  Gmenu.style.height='190px'; // 5
 else if (Gmenu.offsetWidth < 971)//600
  Gmenu.style.height='160px'; // 4
 else
  Gmenu.style.height='140px'; // 3
}
function initMenu(){Gmenu=document.getElementById('menu');resizeMenu();}
function init(){initMenu();initPav();}
function resize(){resizeMenu();resizePav();}
window.onload=init;
window.onresize=resize;
