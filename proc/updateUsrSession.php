<?php
    include("conexion.php");
    function updSession($usr,$conn){
        $sql = "SELECT id_user, user, estado, admin FROM usuarios WHERE user = :usr";
        $queryUsr = $conn ->prepare($sql);
        $queryUsr->bindParam(":usr",$usr);
        $queryUsr -> execute();
        return $usrRes = $queryUsr->fetch();
    }

?>