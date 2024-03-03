<?php
    $id = $_POST["id"];
    $usr = $_POST["usr"];
    $nom = $_POST["nom"];
    $ape = $_POST["ape"];
    $pwd = $_POST["pwd"];
    if($_POST["admin"] == "true"){
        $admin = "1";
    }else{
        $admin = "0";
    }
    include('./conexion.php');
    try {
        $user ="UPDATE usuarios SET user = :usr, nombre = :nom, apellidos = :ape, admin = :admin ";
        if($pwd == ""){
            $user .=" WHERE id_user= :id";
        }else{
            $pwd = password_hash($pwd, PASSWORD_BCRYPT);
            $user .=" ,pwd = :pwd WHERE id_user= :id";
        }
        $queryUsr = $conn ->prepare($user);
        $queryUsr->bindParam(":usr",$usr);
        $queryUsr->bindParam(":nom",$nom);
        $queryUsr->bindParam(":ape",$ape);
        $queryUsr->bindParam(":admin",$admin);
        if($pwd != ""){
            $queryUsr->bindParam(":pwd",$pwd);
        }
        $queryUsr->bindParam(":id",$id);
        $queryUsr -> execute();
        echo "ok";
    } catch (Exception $e){
        echo "Error en la conexión con la base de datos: " . $e->getMessage();
        die();
    }
?>