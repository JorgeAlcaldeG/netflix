<?php
    include("./conexion.php");
    $sql = "SELECT estado from usuarios WHERE id_user = :id LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id",$_POST["id"]);
    $stmt->execute();
    $estado = $stmt->fetchColumn();
    $num = "";
    $msj="";
    if($estado == 3){
        $num = 2;
        $msj = "Usuario deshabilitado";
    }else if ($estado == 2){
        $num = 3;
        $msj = "Usuario habilitado";
    }else{
        $num = 3;
        $msj = "Usuario habilitado";
    }
    try {
        $sql = "UPDATE usuarios SET estado = $num WHERE id_user = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id",$_POST["id"]);
        $stmt->execute();
        echo $msj;
    } catch (Exception $e){
        echo "Error en la conexión con la base de datos: " . $e->getMessage();
        die();
    }
?>