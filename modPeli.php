<?php
    include("./proc/conexion.php");
    // Lista de categorias
    $catSQL = "SELECT DISTINCT g.genero AS 'genero', g.id_genero AS 'id_genero' FROM generos `g` INNER JOIN peli_genero `p` ON p.id_gen = g.id_genero";
    $cat = $conn ->prepare($catSQL);
    $cat ->execute();
    $catList = $cat->fetchAll();
    // Pais
    $SqlPais ="SELECT * FROM pais";
    $stmt = $conn ->prepare($SqlPais);
    $stmt->execute();
    $paises = $stmt->fetchAll();

    $id = $_GET["id"];
    $sql ="SELECT * FROM peliculas WHERE id_peli = :id LIMIT 1";
    $stmt = $conn ->prepare($sql);
    $stmt -> bindParam(":id", $id);
    $stmt->execute();
    $peli = $stmt->fetch();
    $sql ="SELECT * FROM peli_genero WHERE id_peli = :id LIMIT 1";
    $stmt = $conn ->prepare($sql);
    $stmt -> bindParam(":id", $id);
    $stmt->execute();
    $cat = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Pixelify+Sans&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<body>
    <h1>Modificar peli <?php echo $peli["nom_peli"];?></h1>
    <a href="./perfilAdmin.php" class="volverBtn">Volver</a>
    <br>
    <br>
    <hr>
    <form action="./proc/ModPeli.php" method="post" class="formPeli" enctype='multipart/form-data'>
        <input type="hidden" name="id" value="<?php echo $peli["id_peli"]; ?>">
        <input type="hidden" name="vid" value="<?php echo $peli["video"]; ?>">
        <input type="hidden" name="min" value="<?php echo $peli["miniatura"]; ?>">
        <div class="fila">
            <div class="col2">
                <label for="nom">Nombre de la peli</label>
                <br>
                <input class="inputForms" type="text" name="nom" id="nom" value="<?php echo $peli["nom_peli"]; ?>">
                <p id="nomError"> <?php if(isset($_GET["nomVacio"])){echo "Campo obligatorio";} ?></p>
                <label for="time">Duración</label>
                <br>
                <input class="inputForms2" type="number" name="time" id="time" value="<?php echo $peli["duracion"]; ?>">
                <p id="timeError"><?php if(isset($_GET["timeVacio"])){echo "Campo obligatorio";} ?></p>
                <label for="year">Año</label>
                <br>
                <input class="inputForms2" type="number" name="year" id="year" value="<?php echo $peli["año"]; ?>">
                <p id="yearError"><?php if(isset($_GET["yearVacio"])){echo "Campo obligatorio";} ?></p>
                <label for="pais">País</label>
                <br>
                <select name="pais" id="pais">
                    <?php
                        foreach ($paises as $pais) {
                            if($peli["pais"] == $pais["id_pais"]){
                                echo"<option value='".$pais["id_pais"]."' selected>".$pais["pais"]."</option>";
                            }else{
                                echo"<option value='".$pais["id_pais"]."'>".$pais["pais"]."</option>";
                            }
                        }
                    ?>
                </select>
                <p id="paisError"><?php if(isset($_GET["paisVacio"])){echo "Campo obligatorio";} ?></p>
                <fieldset>
                    <legend>Categorías</legend>
                    <?php
                            foreach ($catList as $cat) {
                                echo "<input type='checkbox' name='cat[]' id='cat".$cat['id_genero']."' value='".$cat['id_genero']."'>";
                                echo"<label for='cat".$cat['id_genero']."'>".$cat['genero']."</label>";
                            }
                            ?>
                </fieldset>
                <p id="catError"><?php if(isset($_GET["catVacio"])){echo "Campo obligatorio";} ?></p>
                <label for="nom">Sinopsis</label>
                <br>
                <textarea name="sinopsis" id="sinopsis" class="sinopsisForm"><?php echo $peli["sinopsis"]?></textarea>
                <p id="sinError"><?php if(isset($_GET["sinopsisVacio"])){echo "Campo obligatorio";} ?></p>
            <br>
            </div>
            <div class="col2">
                <label for="video">Pelicula (.mp4)</label>
                <br>
                <input type="file" name="video" id="video" accept="video/mp4">
                <br>
                <label for="miniatura">Miniatura (.png - .jpeg)</label>
                <br>
                <input type="file" name="miniatura" id="miniatura" accept="image/png, image/jpeg, image/jpg">
                <br>
                <br>
                <div class="col frame2" id="preview" style="background-image: url(./resources/frames/preview.jpg);width:40%">
                <p class="frameTitulo2" id="titulo">test</p>
                </div>
            </div>
        </div>
        <button class="tableBtn" type="submit">Enviar</button>
    </form>
    <br>
    <script src="./js/getImg.js"></script>
</body>
</html>