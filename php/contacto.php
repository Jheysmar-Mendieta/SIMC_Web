<?php
require_once __DIR__ . '/conexion.php';
start_session();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido.']);
    exit;
}

$nombre  = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$mensaje = trim($_POST['message'] ?? '');
$ip      = get_client_ip();

if ($nombre === '' || $email === '' || $mensaje === '') {
    echo json_encode(['error' => 'Todos los campos son obligatorios.']);
    exit;
}

if (mb_strlen($nombre) > 120) {
    echo json_encode(['error' => 'El nombre no puede superar los 120 caracteres.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 120) {
    echo json_encode(['error' => 'El correo electrónico no tiene un formato válido.']);
    exit;
}

if (mb_strlen($mensaje) < 10) {
    echo json_encode(['error' => 'El mensaje es demasiado corto (mínimo 10 caracteres).']);
    exit;
}

if (mb_strlen($mensaje) > 3000) {
    echo json_encode(['error' => 'El mensaje no puede superar los 3000 caracteres.']);
    exit;
}

$db = get_db();

// Control de frecuencia de envíos por IP (máximo 5 por hora)
$stmt = $db->prepare("
    SELECT COUNT(*) FROM consultas
    WHERE ip = :ip
      AND creado_en >= NOW() - INTERVAL 1 HOUR
");
$stmt->execute([':ip' => $ip]);

if ((int) $stmt->fetchColumn() >= 5) {
    echo json_encode(['error' => 'Has enviado varios mensajes recientemente. Por favor, intentá nuevamente más tarde.']);
    exit;
}

// Guardar consulta en la base de datos
$stmt = $db->prepare("
    INSERT INTO consultas (nombre, email, mensaje, ip)
    VALUES (:nombre, :email, :mensaje, :ip)
");
$stmt->execute([
    ':nombre'  => $nombre,
    ':email'   => $email,
    ':mensaje' => $mensaje,
    ':ip'      => $ip,
]);

echo json_encode([
    'success' => true,
    'mensaje' => '¡Tu consulta fue enviada con éxito! Te responderemos a la brevedad.',
]);
exit;