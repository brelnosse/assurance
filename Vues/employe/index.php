<?php
// Démarrer la session pour conserver les données entre les pages
session_start();
include('../../Controller/registerController.php');

// Page 1: index.php - Formulaire initial (login et email)
if (basename($_SERVER['PHP_SELF']) == "index.php") {
    // Si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer et stocker les données en session
        $_SESSION['login'] = trim($_POST['login']);
        $_SESSION['email'] = trim($_POST['email']);
        
        if(checkIfEmployeExist($_SESSION['email'], $_SESSION['login'])){
            header("Location: mot-de-passe.php");
        }else{
            echo "no existant";
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 1</title>
    <link rel="stylesheet" href="../../ressources/css/common.css">
    <link rel="stylesheet" href="../../ressources/css/loginEmp.css">
</head>
<body>
    <h2 class="title">Information de connexion</h2>
    
    <form id="etape1Form" method="post" action="">
        <div class="form-group">
            <label for="login">Login <i style="font-weight: 100;color: red">(envoyer par mail)</i> :</label>
            <input type="text" id="login" name="login" required>
        </div>
        
        <div class="form-group">
            <label for="email">Adresse email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <input type="submit" name="etape1" class="btn active" id="submitBtn" value="continuer">
        <div class="loaderc" id="loaderc">
            <div class="loadercontainer">
                <div class="cercle"></div>
                <div class="enfant">
                    <div class="tete">
                    <div class="oeil-gauche"></div>
                    <div class="oeil-droit"></div>
                    <div class="sourire"></div>
                    </div>
                    <div class="corps"></div>
                    <div class="bras-gauche"></div>
                    <div class="bras-droit"></div>
                    <div class="jambe-gauche"></div>
                    <div class="jambe-droite"></div>
                </div>
            </div> 
        </div>  
    </form>
    
    <script>
        document.getElementById('etape1Form').addEventListener('submit', function() {
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('loaderc').style.display = 'flex';
        });
    </script>
</body>
</html>
<?php
}
?>
