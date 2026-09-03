<?php
require_once __DIR__ . '/conexion.php';
start_session();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

if (is_logged_in()) {
    echo json_encode(['error' => 'Ya tenés una sesión activa.']);
    exit;
}

// Datos del formulario
$username      = trim($_POST['username'] ?? '');
$email         = trim($_POST['email'] ?? '');
$password      = $_POST['password'] ?? '';
$confirm       = $_POST['confirm'] ?? '';
$acceptTerms   = !empty($_POST['accept_terms']);
$acceptPrivacy = !empty($_POST['accept_privacy']);
$ip            = get_client_ip();

// Validaciones
if ($username === '' || $email === '' || $password === '' || $confirm === '') {
    echo json_encode(['error' => 'Todos los campos son obligatorios.']);
    exit;
}

if (!$acceptTerms || !$acceptPrivacy) {
    echo json_encode(['error' => 'Debés aceptar los Términos y Condiciones y la Política de Privacidad para crear una cuenta.']);
    exit;
}

if (!preg_match('/^[a-zA-Z0-9_.]{3,40}$/', $username)) {
    echo json_encode(['error' => 'El usuario debe tener entre 3 y 40 caracteres (solo letras, números, guion bajo o punto).']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 120) {
    echo json_encode(['error' => 'El correo electrónico no tiene un formato válido.']);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(['error' => 'La contraseña debe tener al menos 8 caracteres.']);
    exit;
}

if ($password !== $confirm) {
    echo json_encode(['error' => 'Las contraseñas no coinciden.']);
    exit;
}

$db = get_db();

// Límite de registros por IP (máximo 3 por hora)
$stmtRate = $db->prepare("
    SELECT COUNT(*) 
    FROM usuarios 
    WHERE ip_registro = :ip 
      AND creado_en >= NOW() - INTERVAL 1 HOUR
");
$stmtRate->execute([':ip' => $ip]);
if ((int) $stmtRate->fetchColumn() >= 3) {
    http_response_code(429);
    echo json_encode(['error' => 'Límite de registros alcanzado para tu dirección IP. Por favor, intentá más tarde.']);
    exit;
}

// Verificar si el usuario o email ya existen
$stmt = $db->prepare("
    SELECT username, email
    FROM usuarios
    WHERE username = :username OR email = :email
    LIMIT 1
");
$stmt->execute([
    ':username' => $username,
    ':email'    => $email
]);
$exists = $stmt->fetch(PDO::FETCH_ASSOC);

if ($exists) {
    if (strcasecmp($exists['username'], $username) === 0) {
        echo json_encode(['error' => 'El nombre de usuario ya se encuentra registrado.']);
        exit;
    }

    if (strcasecmp($exists['email'], $email) === 0) {
        echo json_encode(['error' => 'El correo electrónico ya está registrado.']);
        exit;
    }
}

// Guardar nuevo usuario
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

$stmt = $db->prepare("
    INSERT INTO usuarios 
        (username, email, password, rol, activo, ip_registro, ultimo_login, creado_en)
    VALUES 
        (:username, :email, :password, 'operador', 1, :ip, NULL, NOW())
");

$stmt->execute([
    ':username' => $username,
    ':email'    => $email,
    ':password' => $hash,
    ':ip'       => $ip
]);

echo json_encode([
    'success' => true,
    'mensaje' => '¡Cuenta creada con éxito! Ahora podés iniciar sesión.'
]);
exit;