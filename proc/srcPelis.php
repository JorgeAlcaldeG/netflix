<?php
    include("./conexion.php");
    // $nextPeli="SELECT `id_peli`,`nom_peli` FROM peliculas LIMIT 5,1000;";
    // var_dump($_POST);
    $src = $_POST["src"];
    $sqlFilms = "SELECT nom_peli, id_peli FROM peliculas";
    if($src != ""){
        $src .= "%";
        $sqlFilms .=" WHERE nom_peli like :src";
    }else{
        // TODAS LAS PELIS
        $sqlFilms="SELECT `id_peli`,`nom_peli` FROM peliculas";
    }
    $stmt = $conn -> prepare($sqlFilms);
    if($src != ""){
        $stmt->bindParam(":src",$src);
    }
    $stmt -> execute();
    $films = $stmt ->fetchAll();
    // echo json_encode($films);
    $numPelis = 0;
    if($stmt -> rowCount() != 0){
        foreach ($films as $film) {
            if($_POST["gen"]!=0){
                $sql = "SELECT * FROM peli_genero WHERE id_peli = :peli AND id_gen = :gen LIMIT 1";
                $stmt = $conn -> prepare($sql);
                $stmt->bindParam(":peli",$film["id_peli"]);
                $stmt->bindParam(":gen",$_POST["gen"]);
                $stmt -> execute();
                // echo $stmt->rowCount();
                if($stmt->rowCount() == 1){
                    $numPelis++;
                    echo'<div class="col-3 frame general" style="background-image: url(./resources/frames/'.$film["id_peli"].'.jpg)" onclick="viewer('.$film["id_peli"].')"><p class="frameTituloAll">'.$film["nom_peli"].'</p></div>'; 
                }
            }else{
                echo'<div class="col-3 frame general" style="background-image: url(./resources/frames/'.$film["id_peli"].'.jpg)" onclick="viewer('.$film["id_peli"].')"><p class="frameTituloAll">'.$film["nom_peli"].'</p></div>'; 
            }
        }
        if($_POST["gen"]!=0 && $numPelis ==0){
            echo "<p>No se han encontrado peliculas que cumplan los requisitos indicados</p>";
        }
    }else{
        echo "<p>No se han encontrado peliculas que cumplan los requisitos indicados</p>";
    }
?>