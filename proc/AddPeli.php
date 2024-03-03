<?php
var_dump($_POST);
$error="";
if(!isset($_POST)){
    header('Location: ../');
    exit();
}
if(isset($_POST["nom"])){
    $nom=$_POST["nom"];
    if($nom == ""){
        $error .= "nomVacio=true&";
    }
}
if(isset($_POST["year"])){
    $year=$_POST["year"];
    if($year==""){
        $error .= "yearVacio=true&";
    }
}
if(isset($_POST["time"])){
    $time=$_POST["time"];
    if($time==""){
        $error .= "timeVacio=true&";
    }
}
if(isset($_POST["pais"])){
    $pais=$_POST["pais"];
    if($pais==""){
        $error .= "paisVacio=true&";
    }
}
if(isset($_POST["cat"])){
    $cat = $_POST["cat"];
    echo count($cat);
    if(count($cat)==0){
        $error .= "catVacio=true&";
    }
}
if(isset($_POST["sinopsis"])){
    $sinopsis=$_POST["sinopsis"];
    if($sinopsis ==""){
        $error .= "sinopsisVacio=true&";
    }
}
if(!isset($_FILES['miniatura'])){
    $error .= "minVacio=true&";
}
if(!isset($_FILES['video'])){
    $error .= "vidVacio=true&";
}
if($error !=""){
    header('Location: ../AddPeli.php?'.$error);
    exit();
}
include("conexion.php");
// Comprobamos si la peli existe
$sql = "SELECT nom_peli FROM peliculas WHERE nom_peli = :nom LIMIT 1";
$query = $conn ->prepare($sql);
$query -> bindParam(":nom", $nom);
$query -> execute();
if($query -> rowCount() == 1){
    header("Location: ../AddPeli.php?peliExist=true");
    exit();
}
// Subimos miniatura y peli
$info = pathinfo($_FILES['miniatura']['name']);
$ext = $info['extension']; // get the extension of the file
$fecha = date("Y-m-dH-i-s");
$nameFile = $fecha.".".$ext; 
$target = '../resources/frames/'.$nameFile;
move_uploaded_file( $_FILES['miniatura']['tmp_name'], $target);

$info = pathinfo($_FILES['video']['name']);
$ext = $info['extension']; // get the extension of the file
$fecha = date("Y-m-dH-i-s");
$namePeli = $fecha.".".$ext; 
$target = '../resources/video/'.$namePeli;
move_uploaded_file( $_FILES['video']['tmp_name'], $target);

try {
    $conn->beginTransaction();
    $sql = "INSERT INTO `peliculas`(`nom_peli`, `sinopsis`, `duracion`, `año`, `pais`, `miniatura`, `video`) VALUES (:nom,:sinopsis,:dura,:year,:pais,:min,:vid)";
    $query = $conn ->prepare($sql);
    $query -> bindParam(":nom", $nom);
    $query -> bindParam(":sinopsis", $sinopsis);
    $query -> bindParam(":year", $year);
    $query -> bindParam(":dura", $time);
    $query -> bindParam(":pais", $pais);
    $query -> bindParam(":min", $nameFile);
    $query -> bindParam(":vid", $namePeli);
    $query -> execute();
    $lastid = $conn -> lastInsertId();
    for ($i=0; $i < count($cat); $i++) { 
        $sql = "INSERT INTO `peli_genero`(`id_peli`, `id_gen`) VALUES (:peli,:gen)";
        $query2 = $conn ->prepare($sql);
        // var_dump($cat);
        $genero=$cat[$i];
        $query2 -> bindParam(":peli", $lastid);
        $query2 -> bindParam(":gen", $genero);
        $query2 -> execute();
    }
    $conn -> commit();
    header("Location: ../perfilAdmin.php");
} catch (Exception $e){
    $conn -> rollback();
    echo "Error en la conexión con la base de datos: " . $e->getMessage();
    die();
}

?>