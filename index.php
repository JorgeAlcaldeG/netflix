<?php
    session_start();
    // var_dump($_SESSION);
    include('./proc/conexion.php');
    // TOP 5
    $top5 = "SELECT l.peli AS 'id_peli', p.nom_peli, count(l.id_like) AS 'likes' FROM `likes` `l` INNER JOIN peliculas `p` ON l.peli = p.id_peli GROUP BY l.peli ORDER BY likes DESC LIMIT 5;";
    $queryTop = $conn ->prepare($top5);
    $queryTop -> execute();
    $topFilms = $queryTop->fetchAll();

    if(isset($_SESSION["nom"])){
        $user ="SELECT * FROM usuarios WHERE id_user=:id";
        $queryUsr = $conn ->prepare($user);
        $queryUsr->bindParam(":id",$_SESSION["id"]);
        $queryUsr -> execute();
        $usrRes = $queryUsr->fetch();
        // var_dump($usrRes);
        $nom = $usrRes["nombre"];
    }
    
    $catSQL = "SELECT DISTINCT g.genero AS 'genero', g.id_genero AS 'id_genero' FROM generos `g` INNER JOIN peli_genero `p` ON p.id_gen = g.id_genero";
    $cat = $conn ->prepare($catSQL);
    $cat ->execute();
    $catList = $cat->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Cartelera</title>
</head>
<body>
    <div id="homeMarginTop"></div>
    <div id="header">
        <div class="row">
            <div class="col-10">
                <form action="" method="post">
                    <!-- <p>Buscador</p> -->
                    <input type="text" name="buscar" id="buscar" placeholder="Buscar peliculas">
                    <br>
                    <select name="cat" id="cat" style="margin-left:50%;">
                        <option value="0">Categoría</option>
                        <?php
                            foreach ($catList as $cat) {
                                echo'<option value="'.$cat["id_genero"].'">'.$cat["genero"].'</option>';
                            }
                        ?>
                    </select>
                    <input type="checkbox" name="tieneLike" id="tieneLike">
                    <label for="tieneLike">Tus favoritos</label>
                </form>
            </div>
            <div class="col-2">
                <?php 
                    if(!isset($_SESSION["nom"])){
                        echo '<a href="login.php">Iniciar sesión</a>';
                    }else{
                        echo"<a href='perfil.php'<p>Hola, $nom</p></a>";
                    }
                ?>
                <a href="./logout.php">Cerrar sesión</a>
            </div>
        </div>
    </div>
    <div class="containerHome">
        <h1 class="colorMain">TOP 5</h1>
        <p class="colorSub">Las 5 peliculas mas populares del momento</p>
        <hr>
        <div class="row">
            <?php
                foreach ($topFilms as $peli) {
                    echo '<div class="col frame" style="background-image: url(./resources/frames/'.$peli["id_peli"].'.jpg)" onclick="viewer('.$peli["id_peli"].')">
                    <p class="frameTitulo">'.$peli["nom_peli"].'</p>
                    </div>';
                }
            ?>
        </div>
        <br>
        <h1 class="colorMain">Todas las peliculas</h1>
        <hr>
    </div>
    <div class="containerAllPelis">
        <div class="row" id="allFilmsContainer">
            
        </div>
    </div>
    <br>
    <br>
    <script src="./js/home.js"></script>
</body>
</html>