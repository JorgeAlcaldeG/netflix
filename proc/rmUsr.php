<?php
    include("./conexion.php");
    try {
        $conn->beginTransaction();
        $sql = "DELETE FROM likes WHERE user = :id";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bindParam(":id",$_POST["id"]);
        $stmt1->execute();
        $sql = "DELETE FROM usuarios WHERE id_user = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id",$_POST["id"]);
        $stmt->execute();
        $conn->commit();
        echo "ok";
    } catch (Exception $e){
        $conn->rollback();
        echo "Error en la conexión con la base de datos: " . $e->getMessage();
        die();
    }
?>