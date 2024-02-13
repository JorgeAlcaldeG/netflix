<?php
    session_start();
    if(!isset($_SESSION["id"]) || $_SESSION["estado"] !=3 || $_SESSION["id"]="" || $_SESSION["admin"]==0){
        header('Location: ./perfil.php');
        die();
    }
    // var_dump($_SESSION);
    include("./proc/conexion.php");
    include("./proc/updateUsrSession.php");
    $user = updSession($_SESSION["nom"],$conn);
    $_SESSION["id"] = $user["id_user"];
    $_SESSION["nom"] = $user["user"];
    $_SESSION["estado"] = $user["estado"];
    $_SESSION["admin"] = $user["admin"];

    if($user["admin"]==0){
        header('Location: ./perfil.php');
        die();
    }

    // $sql = "SELECT id_user, user,nombre,apellidos, estado, admin FROM usuarios";
    // $queryUsr = $conn ->prepare($sql);
    // $queryUsr -> execute();
    // $Allusr = $queryUsr->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Perfil:<?php echo $_SESSION["nom"]; ?></title>
</head>
<body>
    <input type="hidden" id="likesNum">
    <div class="crudContainer">
        <button id="crudBtn">Peliculas</button>
        <h1 id="crudTitulo">Usuarios</h1>
        <hr>
        <div id="res"></div>
        <br>
        <br>
        <a href="./index.php" class="volverBtn">Cartelera</a>
    </div>
    <script src="./js/perfilAdmin.js"></script>
</body>
</html>