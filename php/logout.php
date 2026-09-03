<?php
require_once __DIR__ . '/conexion.php';
start_session();

// Registrar logout en el log si hay sesión activa
if (is_logged_in()) {
    $ip = get_client_ip();
    $ua = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
    try {
        $db = get_db();
        $db->prepare("
            INSERT INTO sesiones_log (usuario_id, ip, user_agent, accion)
            VALUES (:uid, :ip, :ua, 'logout')
        ")->execute([
            ':uid' => $_SESSION['usuario_id'],
            ':ip'  => $ip,
            ':ua'  => $ua,
        ]);
    } catch (Exception $e) {
        error_log('[SIMC] logout log error: ' . $e->getMessage());
    }
}

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy();

header('Location: ' . get_base_url() . '/index.php');
exit;