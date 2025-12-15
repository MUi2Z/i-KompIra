<?php
    function loadEnv($path) {
        if (!file_exists($path)) {
            die("Error: .env file not found at " . htmlspecialchars($path));
        }
    
        // Gantikan file() dengan file_get_contents() dan pecahkan baris
        $content = file_get_contents($path);
        $lines = explode("\n", $content);
        $env_vars = [];
    
        foreach ($lines as $line) {
            $line = trim($line);
        
            // Abaikan baris kosong dan komen
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }
        
            // Cari tanda '='
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value, " \r\n\"'"); // Remove surrounding quotes/whitespace
            
                if (!empty($name)) {
                    $env_vars[$name] = $value;
                    // Set these variables globally
                    putenv("{$name}={$value}");
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
        return $env_vars;
    }


       // .env location
       // Dari 'config', kita perlu naik SATU tahap ke 'i-KompIra' (root projek).
       $envPath = __DIR__ . '/../.env';
       $env = loadEnv($envPath);
       
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