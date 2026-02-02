<?php
// config/connection.php

    if (!function_exists('loadEnv')) {
        function loadEnv($path) {
            if (!file_exists($path)) {
                die("Error: .env file not found at " . htmlspecialchars($path));
            }
            
            $content = file_get_contents($path);
            $lines = explode("\n", $content);
            $env_vars = [];
        
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line) || str_starts_with($line, '#')) continue;
            
                if (strpos($line, '=') !== false) {
                    list($name, $value) = explode('=', $line, 2);
                    $name = trim($name);
                    $value = trim($value, " \r\n\"'"); 
                
                    if (!empty($name)) {
                        $env_vars[$name] = $value;
                        putenv("{$name}={$value}");
                        $_ENV[$name] = $value;
                        $_SERVER[$name] = $value;
                    }
                }
            }
            return $env_vars;
        }
    }
    
    // Teruskan dengan logik sambungan pangkalan data...
    $envPath = __DIR__ . '/../.env';
    $env = loadEnv($envPath);
    // ...
       
    // ===================================
    // Database Connection Logic
    // ===================================
    
    // Gunakan pemboleh ubah $_ENV yang telah ditetapkan dari .env
    $servername = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];
    $dbname = $_ENV['DB_DATABASE'];
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>