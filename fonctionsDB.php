<?php
    require('DbConfig.php');
    function searchMedecin($login, $mdp){
        $DbConfig = DbConfig::getDbConfig();
        try {
            $req = $DbConfig->getPDO()->prepare('SELECT id, login, mdp FROM secretaire WHERE login = :login AND mdp = :mdp');
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
            echo 'ERREUR : ' . $pe->getMessage();
        }
    
    }

?>