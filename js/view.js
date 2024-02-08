var likeBtn = document.getElementById("likebtn");
var id = document.getElementById("id").value; 
var usr = document.getElementById("usr").value;
likeBtn.addEventListener("click",()=>{likefunc(id,usr)});

function likefunc(id){
    var formdata = new FormData();
    formdata.append('id', id);
    formdata.append('usr', usr);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/likefunc.php');
        ajax.onload=function(){
            if(ajax.readyState ==4 && ajax.status==200){
                if(ajax.responseText == "fav"){
                    likeBtn.innerText = "favoritos";
                }else{
                    likeBtn.innerText = "añadir a favoritos";
                }
            }
        }
    ajax.send(formdata);
}