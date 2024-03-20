<?php 
    require('FonctionsDB.php');
    require('generateToken.php');

    $data = json_decode(file_get_contents("php://input"), true);
    $login = $data['login'];
    $mdp = $data['mdp'];

    try{  
        if (searchMedecin($login, $mdp)) {
            $headers = [ 'alg' => 'HS256', 'typ' => 'JWT', ];
            $payload = ['login' => $login,'mdp' => $mdp,'exp' => time() + 3600];
            $secret = 'secret';
            $token = generate_jwt($headers, $payload, $secret);
            setcookie("usertoken", $token);
        } else {
            echo "L'authentification a échoué.";
        }
    } catch (Exception $e) {    
        echo 'Erreur : ' . $e->getMessage();
    }


    try{
        if($_COOKIE['usertoken']){
            $token = $_COOKIE['usertoken'];
            $secret = 'secret';
            if(is_jwt_valid($token, $secret)){
                echo "Authentification réussie";
            } else {
                echo "Authentification échouée";
            }
        } else {
            echo "Authentification échouée";
        }
    } catch (Exception $e) {    
        echo 'Erreur : ' . $e->getMessage();
    }

?>