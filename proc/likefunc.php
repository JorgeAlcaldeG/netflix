<?php
    include("./conexion.php");
    // var_dump($_POST);
    $id = $_POST["id"];
    $likeSQL = "SELECT * FROM likes WHERE peli = :peli AND user = :usr LIMIT 1";
    $stmt = $conn -> prepare($likeSQL);
    $stmt->bindParam(":peli",$_POST["id"]);
    $stmt->bindParam(":usr",$_POST["usr"]);
    $stmt -> execute();
    // echo $stmt->rowCount();
    if($stmt->rowCount() == 1){
        // DELETE LIKE
        try {
            $del = "DELETE FROM likes WHERE peli = :peli AND user = :usr";
            $stmtdel = $conn -> prepare($del);
            $stmtdel->bindParam(":peli",$_POST["id"]);
            $stmtdel->bindParam(":usr",$_POST["usr"]);
            $stmtdel->execute();
            echo "nofav";
        } catch (Exception $e){
            echo "Error en la conexión con la base de datos: " . $e->getMessage();
            die();
        }
    }else{
        // INSERT LIKE
        try {
            $del = "INSERT INTO likes (peli,user) VALUES(:peli,:usr)";
            $stmtdel = $conn -> prepare($del);
            $stmtdel->bindParam(":peli",$_POST["id"]);
            $stmtdel->bindParam(":usr",$_POST["usr"]);
            $stmtdel->execute();
            echo "fav";
        } catch (Exception $e){
            echo "Error en la conexión con la base de datos: " . $e->getMessage();
            die();
        }
    }
?>