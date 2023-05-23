<?php
include("baglanti.php");

$email_err=$parola_err="";

$k_parola=0;

if(isset($_POST["giris"])){


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
        $k_parola = $_POST["parola"];
    }

    


    //doğrulamalar girilme  ve  veri tabanına ekleme işlemi
    if(isset($email) && isset($k_parola)){

    $select = "SELECT * FROM kullanıcılar WHERE email=$email";

    $bulunankullanıcı = mysqli_query($baglanti,$select);

    // bulunan sonuc hesabı var mı yok mu
    // e posta hesabı benzersiz değerdir 
    if(mysqli_num_rows($bulunankullanıcı)>0){
        
        $bulunankayit = mysqli_fetch_assoc($bulunankullanıcı);
        

        if(password_verify($k_parola,$bulunankayit($_POST["parola"]))){
            //parola doğru giriş yapıldı
            //oturum başlat
             session_start();
            $_SESSION["email"] = $bulunankayit["email"]; //bulunan hesap bulunankayit ile
            $_SESSION["isim"] = $bulunankayit["isim"];
            $_SESSION["soyisim"] = $bulunankayit["soyisim"];

            header("location:profile.php");
        }
        else{
            echo '<div class="alert alert-warning" role="alert">
           Giriş başarısız parola yanlış.
          </div>';
    }
        

    }else{
        echo '<div class="alert alert-warning" role="alert">
           Giriş başarısız email hatalı veya bulunamadı.
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
    <title>Oturum Açma Formu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        span{
            color:blue;
            text-decoration: underline;
            cursor: pointer;
            display: block;
            text-align: center;
        }
        p{
            
            text-align: center;
        }
    </style>
    </head>
<body>
        
    <div class="container p-5">
        <div class="card p-5">

            <form action="login.php" method="POST">

            <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email adres</label>
            <input type="email" class="form-control 
            
            <?php
                if(!empty($email_err)){
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
                if(!empty($parola_err)){
                    echo "is-invalid";
                }
            ?>
                
            " id="exampleInputPassword1" name="parola">

            <?php 
                echo $parola_err;
            ?>
        </div>

        <button type="submit" name="giriş" class="btn btn-primary">GİRİŞ YAP</button>
        </form>
        </div>
    </div>
    <p>Hesabınız yoksa hemen <span> <a href="kayıt.php">kaydolun</a></span></p>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>