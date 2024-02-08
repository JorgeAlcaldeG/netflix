<?php
    var_dump($_POST);
    $error = "";
    if(!isset($_POST)){
        header('Location: ../'); // Redirige a la página de inicio de sesión
        exit();
    }
    include("conexion.php");
    if($_POST["tipo"] == "reserva"){
        // Validar login
        if($_POST["usr"] !=""){
            $usr = $_POST["usr"];
        }else{
            $error .= "usrVacio=true&";
        }

        if($_POST["pwd"] != ""){
            $pwd = $_POST["pwd"];
        }else{
            $error .= "pwdVacia=true&";
        }
        if($error != ""){
            header("Location: ../login.php?$error");
            exit();
        }
        try {
            $sql = "SELECT * FROM usuarios WHERE user = :usr LIMIT 1";
            $query = $conn ->prepare($sql);
            $query -> bindParam(":usr", $usr);
            $query -> execute();
            $usrLogin = $query->fetch();
            if($query -> rowCount() == 1){
                if(password_verify($pwd, $usrLogin["pwd"])){
                    session_start();
                    $_SESSION["id"] = $usrLogin["id_user"];
                    $_SESSION["nom"] = $usrLogin["user"];
                    $_SESSION["estado"] = $usrLogin["estado"];
                    $_SESSION["admin"] = $usrLogin["admin"];
                    header("Location: ../index.php");
                    exit();
                    header("Location: ../index.php");
                    exit();
                }else{
                    header("Location: ../login.php?loginError=true");
                    exit();
                }
            }else{
                header("Location: ../login.php?loginError=true");
                exit();
            }
        } catch (Exception $e) {
            echo "Error: ".$e->getMessage();
        }

    }elseif ($_POST["tipo"] == "registro") {
        // Validar registro
    }else{
        header('Location: ../'); // Redirige a la página de inicio de sesión
        exit();
    }
?>