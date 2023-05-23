<?php
    include("baglanti.php");

    $username_err=$email_err=$parola_err=$parola_tekrar_err="";

    $k_parola=0;

    //kaydet butonu ve veri tabanına eklemek için olan sorgular

    if(isset($_POST["kaydet"])){

        // isim girişi sorgulama

        if(empty($_POST["isim"])){
            $username_err = "İsim boş bırakılamaz";
        
        }else if(strlen($_POST["isim"])<6){
            $username_err = "İsim en az 6 karakter olmalı";
        
        }else if (!preg_match('/^[a-z\d_]{5,20}$/i',$_POST["isim"])) {
            $username_err = "Kullanıcı adında öel karakterler olamaz.";
        }else{
            $username = $_POST["isim"];
        }

        //email girişi sorgulama

        if(empty($_POST["email"])){
            $email_err = "email boş olamaz";
        
        }else{
            $email = $_POST["email"]; //html extra sorgular
        }

        //parola doğrulama

        if(empty($_POST["parola"]))
        {
            $parola_err="Parola boş geçilemez";
        
        }else if(strlen($_POST["parola"])<8){
            $parola_err="Parola en az 8 karakter olmalı";
        
        }else{
            $k_parola = password_hash($k_parola, PASSWORD_DEFAULT);
        }

        //parola tekrarı doğrulama

        if(empty($_POST["parola"]))
        {
            $parola_tekrar_err="Parola tekrar boş geçilemez";
        
        }else if(strlen($_POST["parolatekrar"])<8){
            $parola_tekrar_err="Parola tekrarı en az 8 karakter olmalı";
        
        }else if($_POST["parolatekrar"] != $_POST["parola"]){
            $parola_tekrar_err="Parolalar eşleşmiyor";
        
        }else{
            $k_parola_tekrar = $_POST["parolatekrar"];
        }

        $k_soyisim = $_POST["soyisim"];

        
        //doğrulamalar bitişi ve  veri tabanına ekleme işlemi

        if(isset($username) && isset($email) && isset($k_parola) && isset($k_parola_tekrar) ){

        // ekleme değişkeni  "ekle" oldu
        $ekle = "INSERT INTO kullanıcılar(isim,soyisim,email,parola) VALUES ('$username','$k_soyisim','$email','$k_parola')";

        $yükle = mysqli_query($baglanti,$ekle); 
        if($yükle){
            echo '<div class="alert alert-success" role="alert">
            Kayıt eklendi giriş yapabilirsiniz.
          </div>';
          header("location:login.php");
        }
        else{
            echo '<div class="alert alert-warning" role="alert">
           Kayıt başarısız.
          </div>';
        }
        mysqli_close($baglanti);
        }
    }
    
?>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Üye Kayıt Formu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </head>
<body>
        
    <div class="container p-5">
        <div class="card p-5">

            <form action="kayıt.php" method="POST">

            <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">İsim</label>
            <input type="text" class="form-control 
            
            <?php
                if(!empty($username_err)){
                    echo "is-invalid";
                }
            ?>
            " id="exampleInputEmail1" name="isim">
            <div id="emailHelp" class="form-text"></div>

            <?php 
                echo $username_err;
            ?>
            </div>

            <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Soyisim</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="soyisim">
            <div id="emailHelp" class="form-text"></div>
            </div>
            
            <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email adres</label>
            <input type="email" class="form-control 
            
            <?php
                if(!empty($email_err)){       //email boşsa bootsrap hata kodları çalışır
                    echo "is-invalid";
                }
            ?>
            
            " id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
            <div id="emailHelp" class="form-text"></div>

            <?php 
                echo $email_err;
            ?>
        
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Parola</label>
            <input type="password" class="form-control 
            
            <?php
                if(!empty($parola_err)){     //parola boşsa bootsrap hata kodları çalışır
                    echo "is-invalid";
                }
            ?>
                
            " id="exampleInputPassword1" name="parola">

            <?php 
                echo $parola_err;       //bu değişken en başta boş tanımlanmıştı.
            ?>
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Parola Doğrulama</label>
            <input type="password" class="form-control 
            
            <?php
                if(!empty($parola_tekrar_err)){ 
                    echo "is-invalid";
                }
            ?>
                
            " id="exampleInputPassword1" name="parolatekrar">

            <?php 
                echo $parola_tekrar_err;
            ?>
        </div>
        
        <button type="submit" name="kaydet" class="btn btn-primary">Kaydet</button>
        </form>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>
