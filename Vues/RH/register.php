<?php
    session_start();
    include('../../Controller/registerController.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../ressources/css/common.css">
    <link rel="stylesheet" href="../../ressources/css/registerRH.css">
</head>
<body>
    <?php
        include('components/navbar.php');    
        if(connection_status() !== CONNECTION_NORMAL){ ?>
            <div class="loadercontainer">
                ok\
            </div>
    <?php
        }
    ?>
    
    <div class="alert">
        <p><i class="fas fa-info-circle"></i>Lorsque vous ajouterer un nouvel employ&eacute;, un code de connexion genererer automatiquement et envoyee par mail afin qu'il puisse se connecter. vous pourrez voir se code dans la page <a href="" class="link"><i class="fas fa-users"></i> employes</a>.</p>
    </div>
    <form class="form" method="post" enctype="multipart/form-data">
        <h1 style="grid-column: span 2">Nouvel employe</h1>
        <div class="inputContainer">
            <label for="nom">Nom <b style="color: red">*</b></label>
            <input type="text" name="nom" id="nom" class="input" value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ""?>" required>
            <?php isNomErr(); ?>
        </div>
        <div class="inputContainer">
            <label for="prenom">Prenom <b style="color: red">*</b></label>
            <input type="text" name="prenom" id="prenom" class="input" value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ""?>" required>
            <?php isPrenomErr(); ?>
        </div>
        <div class="inputContainer">
            <label for="mail">Adresse mail <b style="color: red">*</b></label>
            <input type="email" name="email" id="email" class="input" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ""?>" required>
            <?php isEmailErr(); ?>
        </div>
        <div class="inputContainer">
            <label for="phone">Numero de telephone <b style="color: red">*</b></label>
            <input type="number" name="phone" id="phone" class="input" value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ""?>" required>
            <?php isPhoneErr(); ?>

        </div>
        <div class="inputContainer group">
            <label for="poste">Poste de l'employe <b style="color: red">*</b></label>
            <select name="poste" id="poste" required>
                <option value="">Selectionner un poste</option>
                <option value="agts" <?= isset($_POST['poste']) && $_POST['poste'] == 'agts'  ? "selected" : ""?>>AGTS - Agent assurance site</option>
                <option value="rasd" <?= isset($_POST['poste']) && $_POST['poste'] == 'rasd'  ? "selected" : ""?>>RASD - Responsable assurance direction</option>
            </select>
            <?php isPosteErr(); ?>
        </div>
        <div class="inputContainer group">
            <label for="birthdate">Date de naissance <b style="color: red">*</b></label>
            <input type="date" name="bdate" id="bdate" class="input" value="<?= isset($_POST['bdate']) ? htmlspecialchars($_POST['bdate']) : ""?>" required>
            <?php isBdateErr(); ?>
        </div>
        <div class="inputContainer group">
            <label for="photo">Photo d'identification <i>(JPEG, JPG, PNG)</i><b style="color: red">*</b></label>
            <input type="file" name="photo" id="photo" class="input" required>
            <?php isPhotoErr(); ?>
        </div>
        <div>
        <?php isAuthErr(); ?>
        </div>
        <input type="submit" class="submitbtn" name="send" value="Ajouter l'employe">
    </form>
    <script src="../../ressources/js/all.js"></script>
</body>
</html>