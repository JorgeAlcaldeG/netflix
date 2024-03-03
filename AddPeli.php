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
    <a href="./perfilAdmin.php" class="volverBtn">Volver</a>
    <br>
    <br>
    <hr>
    <form action="./proc/AddPeli.php" method="post" class="formPeli" enctype='multipart/form-data'>
        <div class="fila">
            <div class="col2">
                <label for="nom">Nombre de la peli</label>
                <br>
                <input class="inputForms" type="text" name="nom" id="nom" value="<?php if(isset($_GET["nom"])){echo $_GET["nom"];} ?>">
                <p id="nomError"> <?php if(isset($_GET["nomVacio"])){echo "Campo obligatorio";} ?></p>
                <label for="time">Duración</label>
                <br>
                <input class="inputForms2" type="number" name="time" id="time" value="<?php if(isset($_GET["time"])){echo $_GET["time"];} ?>">
                <p id="timeError"><?php if(isset($_GET["timeVacio"])){echo "Campo obligatorio";} ?></p>
                <label for="year">Año</label>
                <br>
                <input class="inputForms2" type="number" name="year" id="year" value="<?php if(isset($_GET["year"])){echo $_GET["year"];} ?>">
                <p id="yearError"><?php if(isset($_GET["yearVacio"])){echo "Campo obligatorio";} ?></p>
                <label for="pais">País</label>
                <br>
                <select name="pais" id="pais">
                    <?php
                        foreach ($paises as $pais) {
                            if(isset($_GET["pais"])){
                                if($pais["id_pais"] == $_GET["pais"]){
                                    echo"<option value='".$pais["id_pais"]."' selected>".$pais["pais"]."</option>";
                                }else{
                                    echo"<option value='".$pais["id_pais"]."'>".$pais["pais"]."</option>";
                                }
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
                <textarea name="sinopsis" id="sinopsis" class="sinopsisForm"><?php if(isset($_GET["sin"])){echo $_GET["sin"];} ?></textarea>
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
                <p id="mediaError"><?php if(isset($_GET["vidVacio"]) || isset($_GET["minVacio"])){echo "Campo obligatorio";} ?></p>
            </div>
        </div>
        <button type="submit">Enviar</button>
    </form>
    <script src="./js/getImg.js"></script>
</body>
</html>