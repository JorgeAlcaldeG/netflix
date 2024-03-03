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
    <h1>Crear peli</h1>
    <hr>
    <form action="./proc/AddPeli.php" method="post" class="formPeli" enctype='multipart/form-data'>
        <div class="fila">
            <div class="col2">
                <label for="nom">Nombre de la peli</label>
                <br>
                <input class="inputForms" type="text" name="nom" id="nom">
                <br>
                <label for="time">Duración</label>
                <br>
                <input class="inputForms2" type="number" name="time" id="time">
                <br>
                <label for="year">Año</label>
                <br>
                <input class="inputForms2" type="number" name="year" id="year">
                <br>
                <label for="pais">País</label>
                <br>
                <select name="pais" id="pais">
                    <?php
                        foreach ($paises as $pais) {
                            echo"<option value='".$pais["id_pais"]."'>".$pais["pais"]."</option>";
                        }
                    ?>
                </select>
                <br>
                <fieldset>
                    <legend>Categorías</legend>
                    <?php
                            foreach ($catList as $cat) {
                                echo "<input type='checkbox' name='cat[]' id='cat".$cat['id_genero']."' value='".$cat['id_genero']."'>";
                                echo"<label for='cat".$cat['id_genero']."'>".$cat['genero']."</label>";
                            }
                            ?>
                </fieldset>
                <label for="nom">Sinopsis</label>
                <br>
                <textarea name="sinopsis" id="sinopsis" class="sinopsisForm"></textarea>
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
        <button type="submit">Enviar</button>
    </form>
    <script src="./js/getImg.js"></script>
</body>
</html>