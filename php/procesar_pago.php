<?php
// Procesamiento seguro de pagos de membresías y generación de licencias
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
    exit;
}

// Obtener datos JSON o POST
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);
if (!$data) {
    $data = $_POST;
}

$plan = strtoupper(trim($data['plan'] ?? 'MEDIUM'));
$periodo = strtolower(trim($data['periodo'] ?? 'monthly'));
$titular = trim($data['titular'] ?? '');
$email = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$numeroTarjeta = preg_replace('/\D/', '', $data['numero_tarjeta'] ?? '');
$vencimiento = trim($data['vencimiento'] ?? '');
$cvv = preg_replace('/\D/', '', $data['cvv'] ?? '');

// Validación de campos obligatorios
if (!$titular) {
    echo json_encode(['success' => false, 'error' => 'Por favor ingresá el nombre y apellido del titular.']);
    exit;
}

if (!$email) {
    echo json_encode(['success' => false, 'error' => 'Por favor ingresá un correo electrónico válido para recibir tu licencia.']);
    exit;
}

// Validación de tarjeta (entre 13 y 19 dígitos)
if (strlen($numeroTarjeta) < 13 || strlen($numeroTarjeta) > 19) {
    echo json_encode(['success' => false, 'error' => 'El número de tarjeta no es válido.']);
    exit;
}

// Validación de CVV (3 o 4 dígitos)
if (strlen($cvv) < 3 || strlen($cvv) > 4) {
    echo json_encode(['success' => false, 'error' => 'El código CVV no es válido.']);
    exit;
}

// Validación de fecha de vencimiento (MM/YY)
if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $vencimiento, $matches)) {
    echo json_encode(['success' => false, 'error' => 'La fecha de vencimiento debe tener formato MM/YY.']);
    exit;
}

$mes = (int)$matches[1];
$ano = (int)('20' . $matches[2]);
$mesActual = (int)date('m');
$anoActual = (int)date('Y');

if ($ano < $anoActual || ($ano === $anoActual && $mes < $mesActual)) {
    echo json_encode(['success' => false, 'error' => 'La tarjeta ingresada se encuentra vencida.']);
    exit;
}

// Configuración de planes y precios
$planesConfig = [
    'BASIC' => [
        'nombre' => 'Plan Basic',
        'precio_mensual' => 15.00,
        'precio_anual' => 144.00, // $12/mes
        'limite_pcs' => 10,
        'codigo' => 'BAS'
    ],
    'MEDIUM' => [
        'nombre' => 'Plan Medium',
        'precio_mensual' => 25.00,
        'precio_anual' => 240.00, // $20/mes
        'limite_pcs' => 20,
        'codigo' => 'MED'
    ],
    'ENTERPRISE' => [
        'nombre' => 'Plan Enterprise',
        'precio_mensual' => 60.00,
        'precio_anual' => 576.00, // $48/mes
        'limite_pcs' => 50,
        'codigo' => 'PRO'
    ]
];

if (!isset($planesConfig[$plan])) {
    $plan = 'MEDIUM';
}

$config = $planesConfig[$plan];
$monto = ($periodo === 'annual') ? $config['precio_anual'] : $config['precio_mensual'];
$limitePcs = $config['limite_pcs'];
$ultimos4 = substr($numeroTarjeta, -4);

// Generar Token de Licencia único
function generarTokenLicencia($codigoPlan) {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $bloque1 = '';
    $bloque2 = '';
    for ($i = 0; $i < 4; $i++) {
        $bloque1 .= $chars[random_int(0, strlen($chars) - 1)];
        $bloque2 .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return "SIMC-{$codigoPlan}-{$bloque1}-{$bloque2}";
}

$tokenLicencia = generarTokenLicencia($config['codigo']);

// Calcular fecha de expiración
$diasValidez = ($periodo === 'annual') ? 365 : 30;
$fechaExpiracion = date('Y-m-d H:i:s', strtotime("+{$diasValidez} days"));

// Guardar licencia en base de datos
try {
    $db = get_db();

    // Asegurar existencia de tabla
    $db->exec("CREATE TABLE IF NOT EXISTS `licencias_membresia` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `token_licencia` varchar(40) NOT NULL UNIQUE,
      `plan` varchar(20) NOT NULL,
      `email_comprador` varchar(120) NOT NULL,
      `titular` varchar(100) NOT NULL,
      `monto_pagado` decimal(10,2) NOT NULL,
      `periodo` varchar(20) NOT NULL DEFAULT 'monthly',
      `limite_pcs` int(11) NOT NULL DEFAULT 20,
      `ultimos4` varchar(4) DEFAULT NULL,
      `estado` varchar(20) NOT NULL DEFAULT 'activa',
      `fecha_compra` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `fecha_expiracion` datetime NOT NULL,
      `canjeado_en` datetime DEFAULT NULL,
      `sala_token` varchar(32) DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `idx_token` (`token_licencia`),
      KEY `idx_email` (`email_comprador`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Detectar usuario asociado
    start_session();
    $userId = $_SESSION['usuario_id'] ?? null;
    if (!$userId) {
        $uStmt = $db->prepare("SELECT id FROM `usuarios` WHERE LOWER(email) = LOWER(:email) LIMIT 1");
        $uStmt->execute([':email' => $email]);
        $uRow = $uStmt->fetch();
        if ($uRow) {
            $userId = $uRow['id'];
        }
    }

    $stmt = $db->prepare("INSERT INTO `licencias_membresia` 
        (`user_id`, `token_licencia`, `plan`, `email_comprador`, `titular`, `monto_pagado`, `periodo`, `limite_pcs`, `ultimos4`, `estado`, `fecha_expiracion`) 
        VALUES (:uid, :token, :plan, :email, :titular, :monto, :periodo, :limite, :ult4, 'activa', :exp)");

    $stmt->execute([
        ':uid' => $userId,
        ':token' => $tokenLicencia,
        ':plan' => $plan,
        ':email' => $email,
        ':titular' => $titular,
        ':monto' => $monto,
        ':periodo' => $periodo,
        ':limite' => $limitePcs,
        ':ult4' => $ultimos4,
        ':exp' => $fechaExpiracion
    ]);

    echo json_encode([
        'success' => true,
        'message' => '¡Pago procesado con éxito!',
        'token_licencia' => $tokenLicencia,
        'plan' => $plan,
        'plan_nombre' => $config['nombre'],
        'limite_pcs' => $limitePcs,
        'monto_pagado' => number_format($monto, 2, '.', ''),
        'periodo' => ($periodo === 'annual' ? 'Anual' : 'Mensual'),
        'email' => $email,
        'ultimos4' => $ultimos4,
        'fecha_expiracion' => date('d/m/Y', strtotime($fechaExpiracion))
    ]);

} catch (Exception $e) {
    error_log('[PAGO ERROR] ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Ocurrió un error al registrar la licencia. Por favor reintentá.'
    ]);
}
