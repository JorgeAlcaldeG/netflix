<?php
// var_dump($_POST);
$id = $_POST["id"];
try {
    include('./conexion.php');
    $sql = "SELECT miniatura, video FROM peliculas WHERE id_peli =:peli LIMIT 1";
    $query = $conn ->prepare($sql);
    $query -> bindParam(":peli", $id);
    $query -> execute();
    $files = $query->fetch();
    $conn->beginTransaction();
    $sql = "DELETE FROM `peli_genero` WHERE id_peli = :peli";
    $query = $conn ->prepare($sql);
    $query -> bindParam(":peli", $id);
    $query -> execute();
    $sql = "DELETE FROM `peliculas` WHERE id_peli = :peli";
    $query2 = $conn ->prepare($sql);
    $query2 -> bindParam(":peli", $id);
    $query2 -> execute();
    $conn -> commit();
    unlink("../resources/frames/".$files["miniatura"]);
    unlink("../resources/video/".$files["video"]);
    echo "ok";
} catch (Exception $e){
    // $conn -> rollback();
    echo "Error en la conexión con la base de datos: " . $e->getMessage();
    die();
}