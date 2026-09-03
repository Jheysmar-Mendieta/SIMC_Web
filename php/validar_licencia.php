<?php
// Endpoint API de validación y canje de licencias de membresía
if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/conexion.php';

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);
if (!$data || !is_array($data)) {
    $data = !empty($_POST) ? $_POST : $_GET;
}

$tokenLicencia = strtoupper(trim($data['token'] ?? $data['token_licencia'] ?? ''));
$salaToken = trim($data['sala_token'] ?? '');

if (!$tokenLicencia) {
    echo json_encode(['success' => false, 'valid' => false, 'error' => 'Token de licencia no proporcionado.']);
    exit;
}

try {
    $db = get_db();

    $stmt = $db->prepare("SELECT * FROM `licencias_membresia` WHERE `token_licencia` = :token LIMIT 1");
    $stmt->execute([':token' => $tokenLicencia]);
    $licencia = $stmt->fetch();

    if (!$licencia) {
        echo json_encode([
            'success' => false,
            'valid' => false,
            'error' => 'El código de membresía no existe o es incorrecto.'
        ]);
        exit;
    }

    // Verificar fecha de expiración
    $ahora = new DateTime();
    $expiracion = new DateTime($licencia['fecha_expiracion']);

    if ($ahora > $expiracion) {
        echo json_encode([
            'success' => false,
            'valid' => false,
            'error' => 'La membresía correspondiente a este token ya ha expirado.'
        ]);
        exit;
    }

    // Actualizar canje si se provee sala
    $updateStmt = $db->prepare("UPDATE `licencias_membresia` 
        SET `canjeado_en` = NOW(), `sala_token` = COALESCE(:sala, `sala_token`) 
        WHERE `id` = :id");
    $updateStmt->execute([
        ':sala' => $salaToken ?: null,
        ':id' => $licencia['id']
    ]);

    echo json_encode([
        'success' => true,
        'valid' => true,
        'token_licencia' => $licencia['token_licencia'],
        'plan' => $licencia['plan'],
        'limite_pcs' => (int)$licencia['limite_pcs'],
        'titular' => $licencia['titular'],
        'email' => $licencia['email_comprador'],
        'fecha_expiracion' => date('d/m/Y', strtotime($licencia['fecha_expiracion']))
    ]);

} catch (Exception $e) {
    error_log('[VALIDAR LICENCIA ERROR] ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'valid' => false,
        'error' => 'Error consultando la base de datos de licencias.'
    ]);
}
