<?php
    // Comprobar privilegios del usuario
    session_start();
    if(!isset($_SESSION["id"]) || $_SESSION["id"]==""){
        if($_SESSION["estado"] !=3){
            header('Location: ./login');
            die();
        }
        header('Location: ./login');
        die();
    }
    $usr = $_SESSION["id"];
    $sql = "SELECT estados, admin FROM usuarios WHERE id_user = :usr LIMIT 1";
    $stmt = $conn -> prepare($likeSQL);
    $stmt->bindParam(":usr",$usr);
    $stmt -> fetch();
    $user = $stmt -> execute();
    if($user["estado"] !=3){
        header('Location: ./login');
        die();
    }else{
        $_SESSION["estado"] = $user["estado"];
        $_SESSION["admin"] = $user["admin"];
    }
?>