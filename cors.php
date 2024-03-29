<?php
    
    header("Access-Control-Allow-Origin: http://localhost");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT, PATCH");
    header("Access-Control-Allow-Headers: Content-Type");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }

?>