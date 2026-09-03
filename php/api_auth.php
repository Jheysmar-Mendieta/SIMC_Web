<?php
// API de autenticación y sincronización de membresías para SIMC Supervisor
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

$action = strtolower(trim($data['action'] ?? 'login'));

$db = get_db();

if ($action === 'login') {
    $rawUser = trim($data['username'] ?? $data['email'] ?? $data['usuario'] ?? '');
    $rawPass = trim($data['password'] ?? $data['clave'] ?? '');

    if (!$rawUser || !$rawPass) {
        echo json_encode([
            'success' => false,
            'error' => 'Por favor ingresá tu usuario o correo electrónico y tu contraseña.'
        ]);
        exit;
    }

    try {
        // Buscar usuario en la base de datos
        $stmt = $db->prepare("SELECT id, username, email, password, rol, activo FROM `usuarios` WHERE LOWER(username) = LOWER(:u1) OR LOWER(email) = LOWER(:u2) LIMIT 1");
        $stmt->execute([':u1' => $rawUser, ':u2' => $rawUser]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($rawPass, $user['password'])) {
            echo json_encode([
                'success' => false,
                'error' => 'Usuario o contraseña incorrectos.'
            ]);
            exit;
        }

        if ((int)$user['activo'] !== 1) {
            echo json_encode([
                'success' => false,
                'error' => 'Tu cuenta se encuentra inactiva o suspendida. Contactá al soporte.'
            ]);
            exit;
        }

        // Actualizar último login
        $db->prepare("UPDATE `usuarios` SET `ultimo_login` = NOW() WHERE `id` = :id")->execute([':id' => $user['id']]);

        // Buscar licencias activas vinculadas a este usuario o su email
        $licStmt = $db->prepare("
            SELECT * FROM `licencias_membresia`
            WHERE (user_id = :uid OR LOWER(email_comprador) = LOWER(:email))
              AND fecha_expiracion > NOW()
              AND estado = 'activa'
            ORDER BY 
              CASE 
                WHEN plan = 'ENTERPRISE' THEN 3
                WHEN plan = 'MEDIUM' THEN 2
                ELSE 1 
              END DESC,
              fecha_expiracion DESC
        ");
        $licStmt->execute([
            ':uid' => $user['id'],
            ':email' => $user['email']
        ]);
        $licencias = $licStmt->fetchAll();

        $membresiaActiva = null;
        if (!empty($licencias)) {
            $mejorLicencia = $licencias[0];
            $planCode = strtoupper($mejorLicencia['plan']);
            $nombresPlanes = [
                'BASIC' => 'Plan Basic (10 PCs)',
                'MEDIUM' => 'Plan Medium (20 PCs + IA)',
                'ENTERPRISE' => 'Plan Enterprise (50+ PCs Full)'
            ];

            $membresiaActiva = [
                'activa' => true,
                'plan' => $planCode,
                'plan_nombre' => $nombresPlanes[$planCode] ?? "Plan {$planCode}",
                'limite_pcs' => (int)$mejorLicencia['limite_pcs'],
                'token_licencia' => $mejorLicencia['token_licencia'],
                'fecha_expiracion' => date('d/m/Y', strtotime($mejorLicencia['fecha_expiracion'])),
                'dias_restantes' => (new DateTime())->diff(new DateTime($mejorLicencia['fecha_expiracion']))->days
            ];
        } else {
            // Sin membresía de pago activa (modo demo de prueba)
            $membresiaActiva = [
                'activa' => false,
                'plan' => 'DEMO',
                'plan_nombre' => 'Modo Demo Gratuito (3 PCs)',
                'limite_pcs' => 3,
                'token_licencia' => null,
                'fecha_expiracion' => null,
                'dias_restantes' => 0
            ];
        }

        echo json_encode([
            'success' => true,
            'message' => '¡Autenticación exitosa!',
            'user' => [
                'id' => (int)$user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'rol' => $user['rol']
            ],
            'membresia' => $membresiaActiva,
            'licencias_total' => count($licencias)
        ]);

    } catch (Exception $e) {
        error_log('[API AUTH ERROR] ' . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => 'Error del servidor al procesar la autenticación.'
        ]);
    }
    exit;
}

if ($action === 'sync' || $action === 'check') {
    $userId = (int)($data['user_id'] ?? 0);
    $email = trim($data['email'] ?? '');

    if (!$userId && !$email) {
        echo json_encode(['success' => false, 'error' => 'Datos de usuario insuficientes.']);
        exit;
    }

    try {
        $licStmt = $db->prepare("
            SELECT * FROM `licencias_membresia`
            WHERE (user_id = :uid OR LOWER(email_comprador) = LOWER(:email))
              AND fecha_expiracion > NOW()
              AND estado = 'activa'
            ORDER BY 
              CASE 
                WHEN plan = 'ENTERPRISE' THEN 3
                WHEN plan = 'MEDIUM' THEN 2
                ELSE 1 
              END DESC,
              fecha_expiracion DESC
        ");
        $licStmt->execute([':uid' => $userId, ':email' => $email]);
        $licencias = $licStmt->fetchAll();

        if (!empty($licencias)) {
            $mejorLicencia = $licencias[0];
            $planCode = strtoupper($mejorLicencia['plan']);
            $nombresPlanes = [
                'BASIC' => 'Plan Basic (10 PCs)',
                'MEDIUM' => 'Plan Medium (20 PCs + IA)',
                'ENTERPRISE' => 'Plan Enterprise (50+ PCs Full)'
            ];

            echo json_encode([
                'success' => true,
                'membresia' => [
                    'activa' => true,
                    'plan' => $planCode,
                    'plan_nombre' => $nombresPlanes[$planCode] ?? "Plan {$planCode}",
                    'limite_pcs' => (int)$mejorLicencia['limite_pcs'],
                    'token_licencia' => $mejorLicencia['token_licencia'],
                    'fecha_expiracion' => date('d/m/Y', strtotime($mejorLicencia['fecha_expiracion']))
                ]
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'membresia' => [
                    'activa' => false,
                    'plan' => 'DEMO',
                    'plan_nombre' => 'Modo Demo Gratuito (3 PCs)',
                    'limite_pcs' => 3,
                    'token_licencia' => null,
                    'fecha_expiracion' => null
                ]
            ]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error al sincronizar membresías.']);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'Acción no reconocida.']);
