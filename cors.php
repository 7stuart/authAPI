<?php
    
    header("Access-Control-Allow-Origin: https://gestionmedicalfront.alwaysdata.net");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT, PATCH");
    header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Assurez-vous d'inclure tous les en-têtes nécessaires
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
    

?>