<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <title>Registrarse</title>
</head>
<body>
<?php
// var_dump($_POST);
$error="";
$data="";
$usr = $_POST["usr"];
$nom = $_POST["nom"];
$ape = $_POST["ape"];
$pwd = $_POST["pwd"];
$pwd2 = $_POST["pwd2"];
if(!isset($_POST)){
    header("Location: ../regForm.php");
    exit();
}
$data .="usr=$usr&";
if($_POST["usr"] == "" || !isset($_POST["usr"])){
    $error .= "usrVacio=true&";
}
$data .= "nom=$nom&";
if($_POST["nom"] == "" || !isset($_POST["nom"])){
    $error .= "nomVacia=true&";
}
$data .= "ape=$ape&";
if($_POST["ape"] == "" || !isset($_POST["ape"])){
    $error .= "apeVacia=true&";
}
if($_POST["pwd"] == "" || !isset($_POST["pwd"])){
    $error .= "pwdVacia=true&";
}
if($_POST["pwd"] != $_POST["pwd2"]){
    $error .= "pwdError=true&";
}
if($error !=""){
    header("Location: ../regForm.php?$error$data");
    exit();
}else{
    include("conexion.php");
    // Buscamos si el usuario existe
    $sql = "SELECT id_user FROM usuarios WHERE user = :usr LIMIT 1";
    $query = $conn ->prepare($sql);
    $query -> bindParam(":usr", $usr);
    $query -> execute();
    if($query -> rowCount() == 1){
        header("Location: ../regForm.php?RegError=true&$data");
        exit();
    }
    try {
        // Creamos el usuario en caso de que no exista
        $pwd = password_hash($pwd, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (`user`, `pwd`, `nombre`, `apellidos`, `estado`, `admin`) VALUES (:usr,:pwd,:nom,:ape,'1','0')";
        $query = $conn ->prepare($sql);
        $query -> bindParam(":usr", $usr);
        $query -> bindParam(":pwd", $pwd);
        $query -> bindParam(":nom", $nom);
        $query -> bindParam(":ape", $ape);
        $query -> execute();
        header("Location: ../login.php?userCreado=true");
        exit();
    } catch (Exception $e){
        echo "Error en la conexión con la base de datos: " . $e->getMessage();
        die();
    }
}
?>    
</body>
</html>
