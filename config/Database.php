<?php
/**
 * Database Connection Class
 * 
 * Reads configuration from .env file or uses default values
 * Make sure to create .env file from .env.example
 */
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        // Load from .env file if exists
        $this->loadEnvConfig();
        
        // Fallback to default values
        $this->host = $this->host ?? "localhost";
        $this->db_name = $this->db_name ?? "onlinecourse";
        $this->username = $this->username ?? "root";
        $this->password = $this->password ?? "";
    }

    /**
     * Load configuration from .env file
     */
    private function loadEnvConfig() {
        $envFile = __DIR__ . '/../.env';
        
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                // Skip comments
                if (strpos($line, '#') === 0) continue;
                
                // Parse key=value
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    
                    // Remove quotes if present
                    $value = trim($value, '"\'');
                    
                    switch ($key) {
                        case 'DB_HOST':
                            $this->host = $value;
                            break;
                        case 'DB_NAME':
                            $this->db_name = $value;
                            break;
                        case 'DB_USER':
                            $this->username = $value;
                            break;
                        case 'DB_PASS':
                            $this->password = $value;
                            break;
                    }
                }
            }
        }
    }

    /**
     * Get database connection
     * @return PDO|null
     */
    public function getConnection() {
        if ($this->conn !== null) {
            return $this->conn;
        }
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_PERSISTENT => false
                ]
            );
        } catch(PDOException $e) {
            // Log error
            error_log("Database connection error: " . $e->getMessage());
            
            // Show appropriate message based on environment
            $isDebug = defined('APP_DEBUG') && APP_DEBUG;
            if ($isDebug) {
                die("Database connection error: " . $e->getMessage());
            } else {
                die("Database connection failed. Please contact administrator.");
            }
        }
        
        return $this->conn;
    }
}
?>
