<?php
include('./conexion.php');
$user ="SELECT * FROM usuarios WHERE id_user= :id LIMIT 1";
$queryUsr = $conn ->prepare($user);
$queryUsr->bindParam(":id",$_POST["id"]);
$queryUsr -> execute();
$usrRes = $queryUsr->fetch();
echo '<h2>Editar '.$usrRes["nombre"].'</h2>
<label for="usr">Usuario</label>
</br>
<input type="text" name="usr" id="usr" value="'.$usrRes["id_user"].'">
</br>
<label for="nom">Nombre</label>
</br>
<input type="text" name="nom" id="nom" value="'.$usrRes["nombre"].'">
</br>
<label for="ape">Apellidos</label>
</br>
<input type="text" name="ape" id="ape" value="'.$usrRes["apellidos"].'">
</br>
<label for="pwd">contraseña</label>
</br>
<input type="text" name="pwd" id="pwd" value="">
</br>
</br>
<button type="submit" class="tableBtn" style="margin-left:13%">Modificar</button>';
?>