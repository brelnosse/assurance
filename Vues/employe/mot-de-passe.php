<?php
session_start();
include('../../Controller/registerController.php');

// Page 2: mot-de-passe.php - Deuxième formulaire (mot de passe)
if (basename($_SERVER['PHP_SELF']) == "mot-de-passe.php") {
    // Vérifier si les données de l'étape 1 sont présentes
    if (!isset($_SESSION['login']) || !isset($_SESSION['email'])) {
        // Rediriger vers la première étape si les données manquent
        header("Location: index.php");
        exit();
    }
    
    // Si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier que les mots de passe correspondent
        if ($_POST['password'] == $_POST['confirm_password']) {
            // Stocker le mot de passe en session
            $_SESSION['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            if(updateMdp($_SESSION['password'], $_SESSION['email'], $_SESSION['login'])){
                echo "ok";
                exit();
            }else{
                echo "erro";
            }
            // Rediriger vers le tableau de bord
        } else {
            $error = "Les mots de passe ne correspondent pas.";
        }
    }else{
echo $_SERVER["REQUEST_METHOD"] ;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe</title>
    <link rel="stylesheet" href="../../ressources/css/common.css">
    <link rel="stylesheet" href="../../ressources/css/loginEmp.css">
</head>
<body>
    <h2>Definition du mot de passe</h2>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form id="etape2Form" method="post">
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirmez le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        
        <button type="submit" name="etape2" id="submitBtn">Terminer l'inscription</button>
        
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
        document.getElementById('etape2Form').addEventListener('submit', function() {
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('loaderc').style.display = 'flex';
        });
    </script>
</body>
</html>
<?php
}
?>
