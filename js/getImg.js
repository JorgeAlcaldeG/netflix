var file = document.getElementById("miniatura");
var profilePreview = document.getElementById("preview");
var titulo = document.getElementById("titulo");
var nom = document.getElementById("nom");
nom.addEventListener("change",()=>{ titulo.innerText=nom.value})
file.addEventListener("change",()=>{getImg()})

function getImg(){
    if (file.files && file.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            // profilePreview.style.visibility = "visible";
            profilePreview.style.backgroundImage = `url(${e.target.result})`;
        };
        reader.readAsDataURL(file.files[0]);
    }
}
