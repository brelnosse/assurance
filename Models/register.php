<?php
    function checkIfCodeExist($code){
        include('../../Models/db.php');
        $getcode = $bdd->query('SELECT * FROM employe WHERE auth_key = "'.$code.'"');
        if($getcode->rowCount() == 0){
            return $code;
        }else{
            return false;
        }
    }
    function checkIfEmailExist($email){
        include('../../Models/db.php');
        $getemail = $bdd->query('SELECT * FROM employe WHERE email = "'.$email.'"');
        return $getemail->rowCount() == 1;
    }
    function addEmploye($nom, $prenom, $email, $phone, $poste, $bdate, $photo, $auth_key){
        include('../../Models/db.php');
        if(checkIfEmailExist($email)){
            return false;
        }else{
            $addEmp = $bdd->prepare('INSERT INTO employe(nom, prenom, email, phone, poste, bdate, photo, auth_key, mdp, added_date) VALUES(?,?,?,?,?,?,?,?, null, CURDATE())');
            return $addEmp->execute(array($nom, $prenom, $email, $phone, $poste, $bdate, $photo, $auth_key));
        }
    }