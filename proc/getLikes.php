<?php
include("./conexion.php");
$id = $_POST["id"];
$likeSQL = "SELECT count(peli) as 'likes' FROM likes WHERE peli = :peli";
$stmt = $conn -> prepare($likeSQL);
$stmt->bindParam(":peli",$_POST["id"]);
$stmt -> execute();
$likes =  $stmt -> fetch();
// var_dump($likes);
echo $likes["likes"];
?>