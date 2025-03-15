<?php
    include('../../Models/register.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require "../../vendor/autoload.php";
    $_SESSION['connection_ok'] = 0;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $_SESSION['email_ok'] = 0;
        $_SESSION['nom_err'] = 0;
        $_SESSION['prenom_err'] = 0;
        $_SESSION['email_err'] = 0;
        $_SESSION['phone_err'] = 0;
        $_SESSION['bdate_err'] = 0;
        $_SESSION['poste_err'] = 0;
        $_SESSION['photo_err'] = 0;

        if(isset($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['phone'],$_POST['poste'],$_POST['bdate'])){
            include('../../Models/db.php');
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $mail = htmlspecialchars($_POST['email']);
            $phone = htmlspecialchars($_POST['phone']);
            $poste = htmlspecialchars($_POST['poste']);
            $bdate = htmlspecialchars($_POST['bdate']);
            $curDate = new DateTime(date('Y-m-d'));
            $nbdate = new DateTime($bdate);
            $code = auth_key($bdd);
            $photo;
            $isPhoto = false;
            if(isset($_FILES['photo']['name']) && $_FILES['photo']['error'] == 0){
                $filename = $_FILES['photo']['name'];
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                if(in_array($extension, ['jpg','jpeg','png'])){
                    if($_FILES['photo']['size'] <= 500*1024){
                        if(move_uploaded_file($_FILES['photo']['tmp_name'], "../../ressources/upload/".time()."".$filename)){
                            $photo = "ressources/upload/".time()."".$filename;
                            $isPhoto = true;
                        }
                    }else{
                        $isPhoto = false;
                    }
                }else{
                    $isPhoto = false;
                }
            }
            $isVerified = [
                "isNom" => !empty($nom) && strlen($nom) >= 3,
                "isPrenom" => !empty($prenom) && strlen($prenom) >= 3,
                "isEmail" => filter_var($mail, FILTER_VALIDATE_EMAIL),
                "isPhone" => !empty($phone) && (strlen($phone) == 9) && ($phone[0] == 6),
                "isPoste" => !empty($poste),
                "isBdate" => ($curDate > $nbdate) && date_diff($curDate, $nbdate)->y >= 18,
                "isPhoto" => $isPhoto
            ];

            if(!in_array(false, $isVerified)){
                if(addEmploye($nom, $prenom, $mail, $phone, $poste, $bdate, $photo, $code)){
                    sendEmail($mail, "Finalisation de la creation de compte", $body, $prenom, $code);
                    header('location: mailAlert.php');
                    $_SESSION['connection_ok'] = 0;
                }else{
                    $_SESSION['connection_ok'] = 1;
                }
            }else{
                if($isVerified['isNom'] == false){
                    $_SESSION['nom_err'] = 1;
                }
                if($isVerified['isPrenom'] == false){
                    $_SESSION['prenom_err'] = 1;
                }
                if($isVerified['isEmail'] == false){
                    $_SESSION['email_err'] = 1;
                }
                if($isVerified['isPhone'] == false){
                    $_SESSION['phone_err'] = 1;
                }
                if($isVerified['isPoste'] == false){
                    $_SESSION['poste_err'] = 1;
                }
                if($isVerified['isBdate'] == false){
                    $_SESSION['bdate_err'] = 1;
                }
                if($isVerified['isPhoto'] == false){
                    $_SESSION['photo_err'] = 1;
                }
            }
        }
    }
    function isNomErr(){
        if(isset($_SESSION['nom_err']) && $_SESSION['nom_err'] == 1){
            echo "<p style='color: red'>Le nom doit contenir entre 03 et 20 caracteres.</p>";   
        }
    }
    function isPrenomErr(){
        if(isset($_SESSION['prenom_err']) && $_SESSION['prenom_err'] == 1){
            echo "<p style='color: red'>Le nom doit contenir entre 03 et 20  caracteres.</p>";   
        }
    }
    function isEmailErr(){
        if(isset($_SESSION['email_err']) && $_SESSION['email_err'] == 1){
            echo "<p style='color: red'>L'email est incorrect</p>";   
        }
    }
    function isPhoneErr(){
        if(isset($_SESSION['phone_err']) && $_SESSION['phone_err'] == 1){
            echo "<p style='color: red'>Le numero doit commence par 6 et contenir exactement 9 chiffres.</p>";   
        }
    }
    function isPosteErr(){
        if(isset($_SESSION['poste_err']) && $_SESSION['poste_err'] == 1){
            echo "<p style='color: red'>Le poste doit etre renseigner.</p>";   
        }
    }
    function isBdateErr(){
        if(isset($_SESSION['bdate_err']) && $_SESSION['bdate_err'] == 1){
            echo "<p style='color: red'>Cet employe n'est pas en age de travailler (18 ans minimum)</p>";   
        }
    }
    function isPhotoErr(){
        if(isset($_SESSION['photo_err']) && $_SESSION['photo_err'] == 1){
            echo "<p style='color: red'>Choisissez une image .jgp, .jpeg ou .png de taille inferieure a 500ko</p>";   
        }
    }
    function isAuthErr(){
        if(isset($_SESSION['connection_ok']) && $_SESSION['connection_ok'] == 1){
            echo "<div class='alert danger' style='margin-top: 20px'><p style='color: red'><i class='fas fa-exclamation-triangle'></i>Il se pourrait qu'un employer avec la meme adresse email existe deja.</p></div>";   
        }
    }

    function auth_key($bdd){
        $arr1 = preg_match_all('/[a-zA-Z]/','abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $matches);
        $letters = $matches[0];
        $arr2 = preg_match_all('/\d/','0123456789', $matches);
        $numbers = $matches[0];
        $fulltab = array_merge($letters, $numbers);
        $code = "";
        for($i = 0; $i < 6; $i++){
            $code .= $fulltab[rand(0, count($fulltab)-1)];
        }

        if(checkIfCodeExist($code)){
            return $code;
        }else{
            auth_key();
        }
    }
    //Fonction d'envoi d'email
    function sendEmail($to, $subject, $body, $prenom, $login) {
        try {
            //Créer une nouvelle instance
            $mail = new PHPMailer(true);

            //Configuration du serveur
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';         // Serveur SMTP Gmail
            $mail->SMTPAuth   = true;
            $mail->Username   = 'brelnosse2@gmail.com';        // Votre adresse Gmail
            $mail->Password   = 'uomo yvbi igkh umte'; // Mot de passe d'application
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port       = 587;                      // Port Gmail TLS

            //Configuration de l'expéditeur et du destinataire
            $mail->setFrom('brelnosse2@gmail.com', 'ne.pasrepondre');
            $mail->addAddress($to);

            //Configuration du contenu
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Infos</title>
                </head>
                <body>
                    <p>Bonjour/bonsoir Mr. '.$prenom.',</p>
                    <p>Pour finalisez votre inscription, vous allez devoir definir un mot de passe (lien vers la page de definition du mot de passe <a href="login.php">Definition du mot de passe</a>)</p>
                    <p>Votre login est: <b>'.$login.'</b></p>
                    <p style="color: red;font-weight: bold">NB: Ne partager votre login a personne.</p>
                </body>
                </html>
            ';
            $mail->CharSet = 'UTF-8';

            //Gestion des erreurs SMTP en production
            $mail->SMTPDebug = 0;  // 0 = pas de debug, 2 = debug complet
            
            //Ajout d'un timeout
            $mail->Timeout = 30;

            //Envoi de l'email
            $mail->send();
            $_SESSION['email_ok'] = 1;
        } catch (Exception $e) {
            //Log l'erreur dans un fichier
            error_log("Erreur d'envoi d'email: " . $mail->ErrorInfo);
            return ['success' => false, 'message' => "L'email n'a pas pu être envoyé. Erreur: " . $mail->ErrorInfo];
        }
    }
?>