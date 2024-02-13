<?php
include("./conexion.php");
// var_dump($_POST);
if($_POST["data"]=="peli"){
    $sql = "SELECT id_user, user,nombre,apellidos, estado, admin FROM usuarios";
    $queryUsr = $conn ->prepare($sql);
    $queryUsr -> execute();
    $Allusr = $queryUsr->fetchAll();
    echo json_encode($Allusr);
}else{
    $sql = "SELECT `id_peli`,`nom_peli`,`año` FROM peliculas";
    $queryPeli = $conn ->prepare($sql);
    $queryPeli -> execute();
    $AllPeli = $queryPeli->fetchAll();
    echo json_encode($AllPeli);
}

?>