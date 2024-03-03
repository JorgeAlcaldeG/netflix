<?php
// var_dump($_POST);
echo $_POST["id"];
$error="";
$data="";
if(!isset($_POST)){
    header('Location: ../');
    exit();
}
if(isset($_POST["nom"])){
    $nom=$_POST["nom"];
    $data.="nom=".$nom."&";
    if($nom == ""){
        $error .= "nomVacio=true&";
    }
}
if(isset($_POST["year"])){
    $year=$_POST["year"];
    $data.="year=".$year."&";
    if($year==""){
        $error .= "yearVacio=true&";
    }
}
if(isset($_POST["time"])){
    $time=$_POST["time"];
    $data.="time=".$time."&";
    if($time==""){
        $error .= "timeVacio=true&";
    }
}
if(isset($_POST["pais"])){
    $pais=$_POST["pais"];
    $data.="pais=".$pais."&";
    if($pais==""){
        $error .= "paisVacio=true&";
    }
}
if(isset($_POST["cat"])){
    $cat = $_POST["cat"];
}else{
    $error .= "catVacio=true&";
}
if(isset($_POST["sinopsis"])){
    $sinopsis=$_POST["sinopsis"];
    $data.="sin=".$sinopsis."& ";
    if($sinopsis ==""){
        $error .= "sinopsisVacio=true&";
    }
}
if($error !=""){
    header('Location: ../ModPeli.php?'.$error.$data."id=".$_POST["id"]);
    exit();
}
include("conexion.php");

if($_FILES['miniatura']["name"]!=""){
    $info = pathinfo($_FILES['miniatura']['name']);
    $ext = $info['extension'];
    $fecha = date("Y-m-dH-i-s");
    $nameFile = $fecha.".".$ext; 
    $target = '../resources/frames/'.$nameFile;
    move_uploaded_file( $_FILES['miniatura']['tmp_name'], $target);
    unlink("../resources/frames/".$_POST["miniatura"]);
}
if($_FILES['video']["name"]!=""){
    $info = pathinfo($_FILES['video']['name']);
    $ext = $info['extension']; // get the extension of the file
    $fecha = date("Y-m-dH-i-s");
    $namePeli = $fecha.".".$ext; 
    $target = '../resources/video/'.$namePeli;
    move_uploaded_file( $_FILES['video']['tmp_name'], $target);
    unlink("../resources/video/".$_POST["video"]);
}

try {
    $conn->beginTransaction();
    $sql = "UPDATE `peliculas` SET `nom_peli`=:nom,`sinopsis`=:sinopsis,`duracion`=:dura,`año`=:year,`pais`=:pais ";
    if($_FILES['video']["name"]!=""){
        $sql .=", `video`=:vid " ;
    }
    if($_FILES['miniatura']["name"]!=""){
        $sql .=",`miniatura`=:min " ;
    }
    $sql .="WHERE id_peli = :id";
    echo $sql;
    $query = $conn ->prepare($sql);
    $query -> bindParam(":nom", $nom);
    $query -> bindParam(":sinopsis", $sinopsis);
    $query -> bindParam(":year", $year);
    $query -> bindParam(":dura", $time);
    $query -> bindParam(":pais", $pais);
    $query -> bindParam(":id", $_POST["id"]);
    if($_FILES['video']["name"]!=""){
        $query -> bindParam(":vid", $namePeli);
    }
    if($_FILES['miniatura']["name"]!=""){
        $query -> bindParam(":min", $nameFile);
    }
    $query -> execute();
    $sql = "DELETE FROM `peli_genero` WHERE id_peli = :peli";
    $query1 = $conn ->prepare($sql);
    $query1 -> bindParam(":peli", $_POST["id"]);
    $query1 -> execute();
    for ($i=0; $i < count($cat); $i++) { 
        $sql = "INSERT INTO `peli_genero`(`id_peli`, `id_gen`) VALUES (:peli,:gen)";
        $query2 = $conn ->prepare($sql);
        // var_dump($cat);
        $genero=$cat[$i];
        $query2 -> bindParam(":peli", $_POST["id"]);
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