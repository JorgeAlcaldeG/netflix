<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <title>Inicio de sesión</title>
</head>
<body>
    <div id="LoginContainer">
        <h1 class="colorMain">Login</h1>
        <p class="colorSub"><strong>Inicia sesión para disfrutar de las mejores peliculas</strong></p>
        <form action="./proc/valideteUsr.php" method="post" id="login" onsubmit="return validateLogin()">
            <input type="text" name="usr" id="usr" placeholder="USUARIO">
                <p id="usrError"><?php if(isset($_GET["usrVacio"])){echo "El campo usuario es obligatorio";} ?></p>
            <br>
            <input type="password" name="pwd" id="pwd" placeholder="CONTRASEÑA">
                <p id="pwdError"><?php if(isset($_GET["pwdVacia"])){echo "El campo contraseña es obligatorio";} ?></p>
            <br>
            <button type="submit">Iniciar sesión</button>
            <input type="hidden" name="tipo" value="reserva">
        </form>
        <p id="error"></p>
        <p>Tienes problemas para iniciar sesión? Contacta con nosotros</p>
        <p>Aún no eres cliente? <strong>Pulsa aqui para registrarte</strong></p>
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
    ?>
</body>
</html>