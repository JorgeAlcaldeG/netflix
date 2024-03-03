<?php
    // Comprobar privilegios del usuario
    session_start();
    // var_dump($_SESSION);
    if(!isset($_SESSION["id"]) || $_SESSION["id"]==""){
        if($_SESSION["estado"] !=3){
            header('Location: ./login.php');
            die();
        }
        header('Location: ./login.php');
        die();
    }
    if($_SESSION["admin"] == 1){
        header('Location: ./perfilAdmin.php');
        die();
    }
    include("./proc/conexion.php");
    $userDataSQL = "SELECT * FROM usuarios WHERE id_user = :id LIMIT 1";
    $data = $conn ->prepare($userDataSQL);
    $data -> bindParam(":id", $_SESSION["id"]);
    $data -> execute();
    $userData = $data->fetch();
    // var_dump($userData);
    $likesSQL = "SELECT peli FROM likes WHERE user = :usr";
    $likesStmt = $conn->prepare($likesSQL);
    $likesStmt->bindParam(":usr",$_SESSION["id"]);
    $likesStmt->execute();
    $likes = $likesStmt->fetchAll();

    function getPeli($id){
        include("./proc/conexion.php");
        $peli = "SELECT * FROM peliculas WHERE id_peli = :id";
        $stmt = $conn->prepare($peli);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $peli = $stmt->fetch();
        return $peli;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Pixelify+Sans&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Perfil: <?php echo $_SESSION["nom"]; ?></title>
</head>
<body>
    <h1 style="text-align:center;">Hola, <?php echo $userData["nombre"]." ".$userData["apellidos"]." (".$_SESSION["nom"].")"?></h1>
    <div class="containerHome">
        <h2>Tus peliculas favoritas</h2>
        <hr>
        <div class="row" style="padding-left:20%">
        <?php
            foreach ($likes as $film) {
                // var_dump($film);
                $peli = getPeli($film["peli"]);
                // var_dump($peli);
                echo '<div class="col-3 frame" style="background-image: url(./resources/frames/'.$peli["id_peli"].'.jpg)" onclick="viewer('.$peli["id_peli"].')">
                <p class="frameTitulo" style="margin-top:192%;">'.$peli["nom_peli"].'</p>
                </div>';
            }
            ?>
        </div>
        <br>
        <a href="index.php" class="volverBtn">Cartelera</a>

    </div>
    <script>
        function viewer(id){
            window.location.href = `./view.php?id=${id}`;
        }
    </script>
</body>
</html>