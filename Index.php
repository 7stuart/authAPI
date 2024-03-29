<?php 
    include_once './cors.php';
    require_once('./FonctionsDB.php');
    require_once('./GenerateToken.php');

    $data = json_decode(file_get_contents("php://input"), true);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        try{  
            $login = $data['login'];
            $mdp = $data['mdp'];
            if (searchMedecin($login, $mdp)) {
                $headers = [ 'alg' => 'HS256', 'typ' => 'JWT', ];
                $payload = ['login' => $login,'mdp' => $mdp,'exp' => time() + 3600];
                $secret = 'secret';
                $token = generate_jwt($headers, $payload, $secret);
                // $_COOKIE["usertoken"] = $token;
                setcookie("usertoken", $token, 
                    'expires' => time() + 3600, // Durée de vie du cookie
                    'path' => '/',               // Chemin d'accès du cookie
                    'domain' => 'authapigestionmedical', // Domaine du cookie

                );
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