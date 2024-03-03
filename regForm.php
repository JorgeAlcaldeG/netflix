<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Pixelify+Sans&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <title>Registrarse</title>
</head>
<body>
<div id="LoginContainer">
        <h1 class="colorMain centrarTxt">Registrarse</h1>
        <p class="colorSub centrarTxt"><strong>Atencion:</strong></p>
        <p class="colorSub centrarTxt"> El usuario creado no estará habilitado hasta que un administrador acepte el registro</p>
        <form action="./proc/valideteReg.php" method="post" id="reg" onsubmit="return validateReg()">
            <input type="text" name="usr" id="usr" class="inputForms" placeholder="USUARIO" value="<?php if(isset($_GET["usr"])){echo $_GET["usr"];} ?>">
                <p id="usrError"><?php if(isset($_GET["usrVacio"])){echo "El campo usuario es obligatorio";} ?></p>
            <input type="text" name="nom" id="nom" class="inputForms" placeholder="NOMBRE" value="<?php if(isset($_GET["nom"])){echo $_GET["nom"];} ?>">
                <p id="nomError"><?php if(isset($_GET["nomVacia"])){echo "El campo nombre es obligatorio";} ?></p>
            <input type="text" name="ape" id="ape" class="inputForms" placeholder="APELLIDO" value="<?php if(isset($_GET["ape"])){echo $_GET["ape"];} ?>">
                <p id="apeError"><?php if(isset($_GET["apeVacia"])){echo "El campo apellido es obligatorio";} ?></p>
            <input type="password" name="pwd" class="inputForms" id="pwd" placeholder="CONTRASEÑA">
                <p id="pwdError"><?php if(isset($_GET["pwdVacia"])){echo "El campo contraseña es obligatorio";} ?></p>
            <input type="password" name="pwd2" class="inputForms" id="pwd2" placeholder="REPITE LA CONTRASEÑA">
                <p id="pwdError"><?php if(isset($_GET["pwdVacia"])){echo "La contraseña no coincide";} ?></p>
            <br>
            <button type="submit" class="logBtn">Registrarse</button>
        </form>
        <p id="error" class="centrarTxt"></p>
        <p class="centrarTxt">Ya soy usuario <strong><a href="./login.php" class="delineado">Iniciar sesión</a></strong></p>
    </div>
    <script src="./js/reg.js"></script>
    <?php 
        if(isset($_GET["RegError"])){
            echo'<script>
            Swal.fire({
                icon: "error",
                title: "El usuario ya existe",
                text: "prueba otro nombre de usuario e intentalo de nuevo",
              });
            </script>';
        }
    ?>
</body>
</html>