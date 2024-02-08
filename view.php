<?php
include("./proc/conexion.php");
    session_start();
    if(!isset($_SESSION["id"]) || $_SESSION["id"]==""){
        if($_SESSION["estado"] !=3){
            header('Location: ./login');
            die();
        }
        header('Location: ./login');
        die();
    }
    $id = $_GET["id"];
    // Consulta con los datos de la peli
    $sql = "SELECT * FROM peliculas WHERE id_peli = :id";
    $stmt = $conn ->prepare($sql);
    $stmt -> bindParam(":id", $id);
    $stmt -> execute();
    $peliDato = $stmt->fetch();
    // Genero
    $sql = "SELECT g.genero FROM peli_genero `pg` INNER JOIN generos `g` ON g.id_genero = pg.id_gen WHERE id_peli = :id";
    $stmtGen = $conn ->prepare($sql);
    $stmtGen -> bindParam(":id", $id);
    $stmtGen -> execute();
    $generos = $stmtGen->fetchAll();
    $genStr = "<strong>Generos: </strong>";
    foreach ($generos as $genero) {
        $genStr .= $genero["genero"]." ";
    }
    // Reparto
    $sql = "SELECT r.nombre, r.apellidos, rp.rol FROM reparto `r` INNER JOIN reparto_peli `rp` ON r.id_reparto = rp.actor WHERE rp.peli = :id ORDER BY rp.rol ASC; ";
    $stmtRep = $conn ->prepare($sql);
    $stmtRep -> bindParam(":id", $id);
    $stmtRep -> execute();
    $reparto = $stmtRep->fetchAll();
    $dir = "<strong>Director:</strong> ";
    $act = "<strong>Actores:</strong> ";
    foreach ($reparto as $actor) {
        if($actor["rol"] == 1){
            $dir .=$actor["nombre"]." ".$actor["apellidos"]." ";
        }else{
            $act .=$actor["nombre"]." ".$actor["apellidos"]." ";
        }
        // echo $actor["nombre"]." ";
    }
    // el usuario le ha dado a like?
    $likeSQL = "SELECT * FROM likes WHERE peli = :peli AND user = :usr LIMIT 1";
    $stmt = $conn -> prepare($likeSQL);
    $stmt->bindParam(":peli",$id);
    $stmt->bindParam(":usr",$_SESSION["id"]);
    $stmt -> execute();
    if($stmt->rowCount()==0){
        $likeMsg = "añadir a favoritos";
    }else{
        $likeMsg = "favoritos";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<body>
    <input type="hidden" id="id" value ="<?php echo $id; ?>">
    <input type="hidden" id="usr" value ="<?php echo $_SESSION["id"]; ?>">
    <div id="viewContainer">
        <?php
            echo '<h1>'.$peliDato["nom_peli"].'</h1>';
            echo '<p>'.$genStr.'</p>';
            echo '<p>'.$dir.' '.$act.'</p>';
            echo '<p>'.$peliDato["sinopsis"].'</p>';
        ?>
    </div>
    <button id="likebtn"><?php echo $likeMsg; ?></button>
    <script src="./js/view.js"></script>
</body>
</html>