<?php
    require_once('./DbConfig.php');
    require_once('./GenerateToken.php');

    function searchMedecin($login, $mdp){
        $DbConfig = DbConfig::getDbConfig();
        try {
            $req = $DbConfig->getPDO()->prepare('SELECT * FROM secretaire WHERE login = :login AND mdp = :mdp');
            $req->execute(array(
                'login' => $login,
                'mdp' => $mdp,
            ));
            $result = $req->fetch(PDO::FETCH_ASSOC);
            if ($result !== false) {
                return true;
            } else {
                return $result;
            }
        } catch (Exception $pe) {
            deliver_response(400, "Erreur de connexion : " . $pe->getMessage(), null);
        }
    
    }

?>