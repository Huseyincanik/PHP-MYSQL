<?php

    $host = "localhost";
    $kullanici = "root";
    $parola = "";
    $dt = "üyeler";

    $baglanti = mysqli_connect($host,$kullanici,$parola,$dt);
    mysqli_set_charset($baglanti,"UTF8");

    if($baglanti){

    }else{
        echo "Bağlanti Hatasi". mysqli_connect_errno();
    }

?>