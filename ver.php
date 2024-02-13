<?php
    session_start();
    if(!isset($_SESSION["id"]) || $_SESSION["id"]=""){
        header('Location: ./login.php');
        die();
    }
    include("./proc/updateUsrSession.php");
    $user = updSession($_SESSION["nom"],$conn);
    $_SESSION["id"] = $user["id_user"];
    $_SESSION["nom"] = $user["user"];
    $_SESSION["estado"] = $user["estado"];
    $_SESSION["admin"] = $user["admin"];
    if($_SESSION["estado"] !=3){
        header('Location: ./login.php');
        die();
    }
    include("./proc/conexion.php");
    $id = $_GET["id"];
    $sql = "SELECT * FROM peliculas WHERE id_peli = :id";
    $stmt = $conn ->prepare($sql);
    $stmt -> bindParam(":id", $id);
    $stmt -> execute();
    $peliDato = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Viendo una peli: <?php echo $peliDato["nom_peli"]; ?></title>
</head>
<body>
    <h1 id="centrarTitulo"><?php echo $peliDato["nom_peli"]; ?></h1>
    <video width="640" height="480" controls id="player">
    <source src="./resources/video/<?php echo $id; ?>.mp4" type="video/mp4">
    Your browser does not support the video tag.
    </video> 
    <br>
    <br>
    <a href="./index.php" class="volverBtn">Volver</a>
</body>
</html>