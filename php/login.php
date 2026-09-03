<?php
require_once __DIR__ . '/conexion.php';
start_session();

header('Content-Type: application/json; charset=utf-8');

// Si ya está autenticado, responder con la redirección correspondiente
if (is_logged_in()) {
    $baseUrl = get_base_url();
    $redirect = (current_role() === 'admin') 
        ? $baseUrl . '/admin/dashboard.php' 
        : $baseUrl . '/index.php';

    echo json_encode([
        'success'  => true,
        'redirect' => $redirect
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido.']);
    exit;
}

// Leer datos del formulario
$raw_user = trim($_POST['username'] ?? '');
$raw_pass = $_POST['password'] ?? '';
$ip       = get_client_ip();
$ua       = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);

if ($raw_user === '' || $raw_pass === '') {
    echo json_encode([
        'error' => 'Completá tu usuario/email y contraseña.'
    ]);
    exit;
}

$db = get_db();

// Control de intentos fallidos (máximo 5 en 15 minutos)
$stmt = $db->prepare("
    SELECT COUNT(*)
    FROM sesiones_log
    WHERE ip = :ip
      AND accion = 'login_fallido'
      AND creado_en >= NOW() - INTERVAL 15 MINUTE
");
$stmt->execute([':ip' => $ip]);
$intentos_fallidos = (int) $stmt->fetchColumn();

if ($intentos_fallidos >= 5) {
    http_response_code(429);
    echo json_encode([
        'error' => 'Demasiados intentos fallidos. Tu IP fue pausada temporalmente. Esperá 15 minutos.'
    ]);
    exit;
}

// Buscar usuario por username o email
$stmt = $db->prepare("
    SELECT
        id,
        username,
        email,
        password,
        rol,
        activo
    FROM usuarios
    WHERE username = :u1
       OR email = :u2
    LIMIT 1
");
$stmt->execute([
    ':u1' => $raw_user,
    ':u2' => $raw_user
]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar credenciales
$credenciales_ok = $usuario && password_verify($raw_pass, $usuario['password']);

if (!$credenciales_ok) {
    $uid_log = $usuario['id'] ?? null;

    $stmtLog = $db->prepare("
        INSERT INTO sesiones_log
            (usuario_id, ip, user_agent, accion)
        VALUES
            (:uid, :ip, :ua, 'login_fallido')
    ");
    $stmtLog->execute([
        ':uid' => $uid_log,
        ':ip'  => $ip,
        ':ua'  => $ua
    ]);

    $intentosRestantes = max(0, 4 - $intentos_fallidos);
    $msgExtra = ($intentosRestantes > 0) ? " (Te quedan $intentosRestantes intentos antes del bloqueo temporal)" : "";

    echo json_encode([
        'error' => "Credenciales inválidas.$msgExtra"
    ]);
    exit;
}

// Verificar si la cuenta está activa
if (empty($usuario['activo'])) {
    echo json_encode([
        'error' => 'Tu cuenta está desactivada o suspendida. Por favor, contactá al administrador.'
    ]);
    exit;
}

// Regenerar ID de sesión para prevenir Session Fixation
session_regenerate_id(true);

$_SESSION['usuario_id']    = (int) $usuario['id'];
$_SESSION['username']      = $usuario['username'];
$_SESSION['email']         = $usuario['email'];
$_SESSION['rol']           = $usuario['rol'];
$_SESSION['last_activity'] = time();

// Actualizar fecha del último login
$db->prepare("
    UPDATE usuarios
    SET ultimo_login = NOW()
    WHERE id = :id
")->execute([
    ':id' => $usuario['id']
]);

// Registrar login en auditoría
$db->prepare("
    INSERT INTO sesiones_log
        (usuario_id, ip, user_agent, accion)
    VALUES
        (:uid, :ip, :ua, 'login')
")->execute([
    ':uid' => $usuario['id'],
    ':ip'  => $ip,
    ':ua'  => $ua
]);

// Redirección según rol
$baseUrl = get_base_url();
$redirect = ($usuario['rol'] === 'admin') 
    ? $baseUrl . '/admin/dashboard.php' 
    : $baseUrl . '/index.php';

echo json_encode([
    'success'  => true,
    'redirect' => $redirect
]);
exit;