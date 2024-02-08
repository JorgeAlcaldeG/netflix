<?php
    include("./conexion.php");
    // var_dump($_POST);
    $sql = "SELECT * FROM peli_genero WHERE id_peli = :peli AND id_gen = :gen LIMIT 1";
    $stmt = $conn -> prepare($sql);
    $stmt->bindParam(":peli",$_POST["peli"]);
    $stmt->bindParam(":gen",$_POST["gen"]);
    $stmt -> execute();
    echo $stmt->rowCount();
    // echo $sql;
?>