<?php 
namespace Site\Models;

/**
 * Request
 *
 * Singleton class provides methods for accessing and sanitizing HTTP input,
 * session management, and request metadata. 
 * 
 * All functions that take $source as an argument let you
 * specify if the expected input is $_GET or $_POST
 * Use the constants INPUT_POST or INPUT_GET when calling the functions
 */

class Request
{  
    private static ?Request $instance = null;
    
    public static function getInstance(): Request
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getInteger(string $key, int $source = null): int
    {
        $value = $this->getInput($key, $source);
        return filter_var($value, FILTER_VALIDATE_INT) ?? 0;
    }

    public function getNumber(string $key, int $source = null): int|float
    {
        $value = $this->getInput($key, $source);

        if (!is_string($value) && !is_numeric($value)) {
            return 0;
        }

        $value = trim((string) $value);
        $value = preg_replace('/[^0-9.\-]/', '', $value);
        $value = preg_replace('/(?!^)-/', '', $value);

        if (!is_numeric($value)) {
            return 0;
        }

        return (strpos($value, '.') === false) ? (int)$value : (float)$value;
    }

    public function getString(string $key, int $source = null): string
    {
        $value = $this->getInput($key, $source);
        if (!is_string($value)) {
            return '';
        }
        return $this->cleanStringInput($value);
    }

    public function getSafeString(string $key, int $source = null): string
    {
        $value = $this->getString($key, $source);
        return $this->stripNonAscii($value);
    }

    public function getWord(string $key, int $source = null): string
    {
        $value = $this->getInput($key, $source);

        if (!is_string($value)) {
            return '';
        }

        $value = $this->cleanStringInput($value);
        $value = preg_replace(
            '/[^\p{L}\p{N}\s\.\,\!\?\-\_\'\"\:]/u', 
            '', 
            $value
        );
        return $value;
    }

    public function getSafeWord(string $key, int $source = null): string
    {
        $value = $this->getWord($key, $source);
        return $this->stripNonAscii($value);
    }

    public function getArray(string $key, int $source = null): array
    {
        $value = $this->getInput($key, $source) ?? [];
        return is_array($value) ? $value : [];
    }

    public function getJsonInput(
        string $source = 'php://input', 
        bool $assoc = true
    ): array|object|null
    {
        $json = file_get_contents($source);
        
        if ($json === false) {
            return null;
        }
        
        $data = json_decode($json, $assoc);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }
        
        return $data;
    }

    public function keyExists(string $key): bool
    {
        return $this->hasPost($key) || $this->hasGet($key);
    }

    public function hasGet(string $key): bool
    {
        return isset($_GET[$key]);
    }

    public function hasPost(string $key): bool
    {
        return isset($_POST[$key]);
    }

    public function getMethod(): string 
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function hasSession(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function getSession(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function setSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function unsetSession(string $key): void
    {
        unset($_SESSION[$key]);
    }
    
    private function getInput(string $key, int $source = null)
    {
        if ($source === INPUT_GET) {
            return $_GET[$key] ?? null;
        } elseif ($source === INPUT_POST) {
            return $_POST[$key] ?? null;
        } else {
            return $_POST[$key] ?? $_GET[$key] ?? null;
        }
    }

    private function cleanStringInput(string $input): string
    {
        $input = trim($input);
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    private function stripNonAscii(string $input): string
    {
        return preg_replace('/[^\x20-\x7E]/', '', $input);
    }
}