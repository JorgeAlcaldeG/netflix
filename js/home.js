function viewer(id){
    window.location.href = `./view.php?id=${id}`;
}
var src = document.getElementById("buscar");
var allpelis = document.getElementById("allFilmsContainer");
var generos = document.getElementById("cat");
generos.addEventListener("change",()=>{buscador()})
src.addEventListener("keyup",()=>{buscador()})

function buscador(){
    var formdata = new FormData();
    formdata.append('src', src.value);
    formdata.append('gen', generos.value);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/srcPelis.php');
        ajax.onload=function(){
            if(ajax.readyState ==4 && ajax.status==200){
                allpelis.innerHTML="";
                var res = ajax.responseText;
                allpelis.innerHTML=res;
            }
        }
    ajax.send(formdata);
}
window.onload = buscador();