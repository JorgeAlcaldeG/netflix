var likeBtn = document.getElementById("likebtn");
var id = document.getElementById("id").value; 
var usr = document.getElementById("usr").value;
var likeNum = document.getElementById("likeNum")
likeBtn.addEventListener("click",()=>{likefunc(id,usr)});

function likefunc(id){
    var like = parseInt(likeNum.innerText);
    console.log(like)
    var formdata = new FormData();
    formdata.append('id', id);
    formdata.append('usr', usr);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/likefunc.php');
        ajax.onload=function(){
            if(ajax.readyState ==4 && ajax.status==200){
                if(ajax.responseText == "fav"){
                    likeBtn.src = "./resources/icon/like2.png";
                    likeNum.innerText = like+1;
                    // console.log(likeNum.innerText)
                }else{
                    likeNum.innerText= like-1;
                    likeBtn.src = "./resources/icon/like.png";
                    // console.log(likeNum.innerText)
                }
            }
        }
    ajax.send(formdata);
}