btnState = document.getElementById("crudBtn");
btnState.addEventListener("click",()=>{changeBtn();GetCrud()})
res = document.getElementById("res");
var titulo = document.getElementById("crudTitulo");
var likesNum = document.getElementById("likesNum");
var cerrar = document.getElementById("cerrar");
var modForm = document.getElementById("modForm");
cerrar.addEventListener("click",()=>{
    modForm.style.display = "none";
})
function changeBtn(){
    if(btnState.innerText == "Peliculas"){
        btnState.innerText = "Usuarios";
        titulo.innerText = "Peliculas"
    }else{
        btnState.innerText = "Peliculas";
        titulo.innerText = "Usuarios"
    }
}
var like = 0;
function getLikes(peli){
    var formdata = new FormData();
    formdata.append('id', peli);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/getLikes.php');
    ajax.onload=function(){
        if(ajax.readyState ==4 && ajax.status==200){
            // console.log(ajax.responseText)
            like = ajax.responseText
            likesNum.value = like
            // console.log(likesNum.value);
        }
    }
    ajax.send(formdata);
}
function GetCrud(){
    var formdata = new FormData();
    var data = "";
    if(btnState.innerText == "Peliculas"){
        data = "peli";
    }else{
        data = "usu";
    }
    formdata.append('data', data);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/getCrud.php');
        ajax.onload=function(){
            if(ajax.readyState ==4 && ajax.status==200){
                res.innerHTML = ""
                var json = JSON.parse(ajax.responseText);
                if(data == "peli"){
                    $datos = "<table><tr><th>User</th><th>Nombre completo</th><th>Estado</th><th>Permisos</th><th>Acciones</th></tr>"
                    json.forEach(function(item){
                        var nomCompleto = `${item.nombre} ${item.apellidos}`;
                        var botones = "";
                        if(item.estado == 1){
                            var estado = "Nuevo";
                            botones = "<button class='tableBtn' onclick='enable("+item.id_user+")'>Aceptar</button><button class='tableBtn ama' onclick='remove("+item.id_user+")'>Rechazar</button>";
                        }else if (item.estado == 2){
                            var estado = "Deshabilitado";
                            botones = "<button class='tableBtn' onclick='enable("+item.id_user+")'>Habilitar</button><button class='tableBtn ama' onclick='showMod("+item.id_user+")'>Modificar</button><button class='tableBtn red' onclick='remove("+item.id_user+")'>Borrar</button>";
                        }else{
                            var estado = "Activo";
                            botones = "<button class='tableBtn'onclick='enable("+item.id_user+")'>Deshabilitar</button><button class='tableBtn ama' onclick='showMod("+item.id_user+")'>Modificar</button><button class='tableBtn red' onclick='remove("+item.id_user+")'>Borrar</button>";
                        }
                        if(item.admin == 0){
                            var tipo = "Usuario"
                        }else{
                            var tipo = "Administrador"
                        }
                        $datos +=`<tr>
                        <th>${item.user}</th>
                        <th>${nomCompleto}</th>
                        <th>${estado}</th>
                        <th>${tipo}</th>
                        <th>${botones}</th>
                        </tr>`
                    });
                    $datos +=`</table>`;
                    res.innerHTML = $datos;
                }else{
                    $datos="<a href='./AddPeli.php' class='volverBtn'>Añadir peli</a>";
                    $datos+="<p></p>"
                    $datos+="<table id='peli'><tr><th>Pelicula</th><th>Año</th><th>Acciones</th></tr>"
                    json.forEach(function(item){
                        $datos+=`<tr><th>${item.nom_peli}</th>
                        <th>${item.año}</th>
                        <th><button class='tableBtn ama'>Modificar</button><button class='tableBtn red' onclick='removePeli("${item.id_peli}")'>Borrar</button></th></tr>`
                    });
                    res.innerHTML = $datos;
                }
            }
        }
    ajax.send(formdata);
}
window.onload = GetCrud;

function enable(id){
    var formdata = new FormData();
    formdata.append('id', id);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/enableUsr.php');
    ajax.onload=function(){
        if(ajax.readyState ==4 && ajax.status==200){
            console.log(ajax.responseText);
            Swal.fire({
                title: `${ajax.responseText}`,
                icon: "success",
                toast: true,
                position: "top-end",
                timer: 2000,
                showConfirmButton:false,
                showCancelButton: false
              })
            GetCrud();
        }
    }
    ajax.send(formdata);
}

function remove(id){
    Swal.fire({
        title: "Borrar usuario",
        text: "Estás seguro de que quieres hacer esta acción?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: "No"
      }).then((result) => {
        if (result.isConfirmed) {
            var formdata = new FormData();
            formdata.append('id', id);
            var ajax = new XMLHttpRequest();
            ajax.open('POST', './proc/rmUsr.php');
            ajax.onload=function(){
                if(ajax.readyState ==4 && ajax.status==200){
                    console.log(ajax.responseText);
                    Swal.fire({
                        title: "Eliminado!",
                        text: "El usuario ha sido eliminado",
                        icon: "success"
                      });
                    GetCrud();
                }
            }
            ajax.send(formdata);
        }
      });
}
// removePeli
function removePeli(id){
    Swal.fire({
        title: "Borrar peli",
        text: "Estás seguro de que quieres hacer esta acción?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: "No"
      }).then((result) => {
        if (result.isConfirmed) {
            var formdata = new FormData();
            formdata.append('id', id);
            var ajax = new XMLHttpRequest();
            ajax.open('POST', './proc/rmPeli.php');
            ajax.onload=function(){
                if(ajax.readyState ==4 && ajax.status==200){
                    console.log(ajax.responseText);
                    if(ajax.responseText == "ok"){
                        Swal.fire({
                            title: "Eliminado!",
                            text: "La peli ha sido eliminada",
                            icon: "success"
                          });
                        GetCrud();
                    }
                }
            }
            ajax.send(formdata);
        }
      });
}
function showMod(id){
    modForm.style.display = "block";
    var formdata = new FormData();
    formdata.append('id', id);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/getUsrData.php');
    ajax.onload=function(){
        if(ajax.readyState ==4 && ajax.status==200){
            var res = document.getElementById("modFormRes");
            res.innerHTML = ajax.responseText;
        }
    }
    ajax.send(formdata);
}

function updateUsr(){
    var id = document.getElementById("id_user").value;
    var usr = document.getElementById("usr").value;
    var nom= document.getElementById("nom").value;
    var ape = document.getElementById("ape").value;
    var pwd = document.getElementById("pwd").value;
    var admin = document.getElementById("admin").checked;
    var formdata = new FormData();
    formdata.append('id', id);
    formdata.append('usr',usr);
    formdata.append('nom',nom);
    formdata.append('ape',ape);
    formdata.append('pwd',pwd);
    formdata.append('admin',admin);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/updateUsr.php');
    ajax.onload=function(){
        if(ajax.readyState ==4 && ajax.status==200){
            console.log(ajax.responseText);
            if(ajax.responseText == "ok"){
                Swal.fire({
                    title: `usuario actualizado`,
                    icon: "success",
                    toast: true,
                    position: "top-end",
                    timer: 2000,
                    showConfirmButton:false,
                    showCancelButton: false
                  })
                GetCrud()
            }
        }
    }
    ajax.send(formdata);
}