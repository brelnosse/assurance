<?php
    session_start();
    if(!isset($_SESSION['email_ok']) && $_SESSION['email_ok'] == 0){
        header("location:register.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../ressources/css/common.css">
    <link rel="stylesheet" href="../../ressources/css/mailAlert.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1 class="title primary">Employe ajouter</h1>
        <p class="text">Une email a ete envoye a l'employe a fin qu'il puisse definir son mot de passe de connexion.</p>
        <div class="btn-container">
            <a href="register.php" class="btn"><i class="fas fa-angle-left"></i>Page precedente</a>
            <label for="mail" class="btn active"><i class="fas fa-envelope"></i>R&eacute;-envoyer l'email</label>
        </div>
    </div>
    <script src="../../ressources/js/all.js"></script>
</body>
</html>