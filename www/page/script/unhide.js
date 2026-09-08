function unhide(id){
 var s = document.getElementById(id).style;
 if(s.display=='none' || s.display=='') s.display='block';
 else s.display='none';
}
