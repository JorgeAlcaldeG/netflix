<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Pixelify+Sans&display=swap" rel="stylesheet">

    <title>Inicio de sesión</title>
</head>
<body>
    <div id="LoginContainer">
        <h1 class="colorMain centrarTxt">Login</h1>
        <p class="colorSub centrarTxt"><strong>Inicia sesión para disfrutar de las mejores peliculas</strong></p>
        <form action="./proc/valideteUsr.php" method="post" id="login" onsubmit="return validateLogin()">
            <input type="text" name="usr" class="inputForms" id="usr" placeholder="USUARIO">
                <p id="usrError"><?php if(isset($_GET["usrVacio"])){echo "El campo usuario es obligatorio";} ?></p>
            <br>
            <input type="password" name="pwd" class="inputForms" id="pwd" placeholder="CONTRASEÑA">
                <p id="pwdError"><?php if(isset($_GET["pwdVacia"])){echo "El campo contraseña es obligatorio";} ?></p>
            <br>
            <button type="submit" class="logBtn">Iniciar sesión</button>
            <input type="hidden" name="tipo" value="reserva">
        </form>
        <p id="error" class="centrarTxt"></p>
        <p class="centrarTxt">Tienes problemas para iniciar sesión? Contacta con nosotros</p>
        <p class="centrarTxt">Aún no eres cliente? <strong><a href="./regForm.php" class="delineado">Pulsa aqui para registrarte</a></strong></p>
    </div>
    <script src="./js/login.js"></script>
    <?php 
        if(isset($_GET["loginError"])){
            echo'<script>
            Swal.fire({
                icon: "error",
                title: "Error al iniciar sesión",
                text: "Comprueba tus datos e intentalo de nuevo",
              });
            </script>';
        }
        if(isset($_GET["loginError2"])){
            echo'<script>
            Swal.fire({
                icon: "error",
                title: "Usuario deshabilitado",
                text: "No tienes acceso, para mas información contacte con un administrador",
              });
            </script>';
        }
        if(isset($_GET["userCreado"])){
            echo'<script>
            Swal.fire({
                icon: "success",
                title: "Usuario creado",
                text: "Te avisaremos cuando un administrador valide tu acceso",
              });
            </script>';
        }
        // userCreado
    ?>
</body>
</html>