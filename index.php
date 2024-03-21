<?php 
    require('FonctionsDB.php');
    require('generateToken.php');

    $data = json_decode(file_get_contents("php://input"), true);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    try{  
        if (searchMedecin($login, $mdp)) {
            $login = $data['login'];
            $mdp = $data['mdp'];
            $headers = [ 'alg' => 'HS256', 'typ' => 'JWT', ];
            $payload = ['login' => $login,'mdp' => $mdp,'exp' => time() + 3600];
            $secret = 'secret';
            $token = generate_jwt($headers, $payload, $secret);
            setcookie("usertoken", $token);
            deliver_response(200, "Authentification réussie", $token);
        } else {
            deliver_response(404, "Authentification échouée", null);
        }
    } catch (Exception $e) {    
        echo 'Erreur : ' . $e->getMessage();
    }
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        try{
            if($_COOKIE['usertoken']){
                $token = $_COOKIE['usertoken'];
                $secret = 'secret';
                if(is_jwt_valid($token, $secret)){
                    deliver_response(200, "Authentification réussie", $token);
                } else {
                    deliver_response(404, "Authentification échouée", null);
                }
            } else {
                deliver_response(404, "Authentification échouée", null);
            }
        } catch (Exception $e) {    
            echo 'Erreur : ' . $e->getMessage();
        }
    }
?>