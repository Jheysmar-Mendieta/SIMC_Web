<?php
// Módulo central de conexión y funciones de seguridad

// Cargar variables de entorno desde .env
(function () {
    $envPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
    if (!file_exists($envPath)) {
        return;
    }

    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }

        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $val = trim($parts[1]);
            $val = trim($val, "\"'");
            if (!isset($_ENV[$key]) && !isset($_SERVER[$key])) {
                putenv("$key=$val");
                $_ENV[$key] = $val;
                $_SERVER[$key] = $val;
            }
        }
    }
})();

// Constantes de conexión a base de datos
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'simc_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

// Cabeceras HTTP de seguridad
function set_security_headers(): void
{
    if (headers_sent()) {
        return;
    }

    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(self), microphone=(self), geolocation=()');

    $csp = "default-src 'self'; " .
           "script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; " .
           "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; " .
           "font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com; " .
           "img-src 'self' data: https:; " .
           "connect-src 'self' ws: wss:;";
    header("Content-Security-Policy: $csp");

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
               (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
    if ($isHttps) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }
}

// Aplicar cabeceras
set_security_headers();

// Retorna la conexión PDO a MySQL
function get_db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST .
               ";port=" . DB_PORT .
               ";dbname=" . DB_NAME .
               ";charset=" . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log('[SIMC DB ERROR] ' . $e->getMessage());

            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                "error" => "No se pudo conectar a la base de datos. Intente más tarde."
            ]);
            exit;
        }
    }

    return $pdo;
}

// Inicializar sesión con parámetros seguros de cookies
function start_session(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
                   (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');

        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        session_start();

        // Expirar sesión tras 2 horas de inactividad
        $maxInactivity = 7200;
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $maxInactivity)) {
            session_unset();
            session_destroy();
            session_start();
        }
        $_SESSION['last_activity'] = time();
    }
}

// Obtener URL base del proyecto
function get_base_url(): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir = dirname($scriptName);
    
    if (basename($dir) === 'admin' || basename($dir) === 'php' || basename($dir) === 'pages') {
        $dir = dirname($dir);
    }
    
    return rtrim(str_replace('\\', '/', $dir), '/');
}

// Obtener IP del cliente
function get_client_ip(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $firstIp = trim($ips[0]);
        if (filter_var($firstIp, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            $ip = $firstIp;
        }
    }

    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '127.0.0.1';
}

// Verificar si el usuario está autenticado
function is_logged_in(): bool
{
    start_session();
    return !empty($_SESSION['usuario_id']) && !empty($_SESSION['username']);
}

// Obtener rol del usuario
function current_role(): ?string
{
    start_session();
    return $_SESSION['rol'] ?? null;
}

// Exigir login para acceder
function require_login(): void
{
    if (!is_logged_in()) {
        header("Location: " . get_base_url() . "/index.php");
        exit;
    }
}

// Exigir un rol específico
function require_role(string $rol): void
{
    require_login();

    if (current_role() !== $rol) {
        header("Location: " . get_base_url() . "/index.php");
        exit;
    }
}

// Generar token CSRF
function generate_csrf_token(): string
{
    start_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Validar token CSRF
function verify_csrf_token(?string $token): bool
{
    start_session();
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}