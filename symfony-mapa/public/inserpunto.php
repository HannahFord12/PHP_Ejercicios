<?php
    $conn= mysqli_connect("localhost", "root", "sa", "mapa");
    if(!$conn){
        exit("Could not connect");
    }
    $lat=$_GET["lat"];
    $lng=$_GET["lng"];

    $sql="INSERT INTO puntos('latitud', 'longitud') VALUES ('$lat','$lng')";
    

    mysqli_close($conn);

?>